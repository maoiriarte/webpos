<?php
   include_once'db/connect_db.php';
   session_start();
   if($_SESSION['username']==""){
     include_once'inc/404.php';
   }else{
     if($_SESSION['role']=="Admin"){
       include_once'inc/header_all.php';
     }else{
         include_once'inc/header_all_operator.php';
     }
   }


    error_reporting(0);
    date_default_timezone_set('america/bogota');

    function fill_product($pdo){
      $output= '';

      $select = $pdo->prepare("SELECT * FROM tbl_product");
      $select->execute();
      $result = $select->fetchAll();

      foreach($result as $row){
        $output.='<option value="'.$row['product_id'].'">'.$row["product_name"].'</option>';
      }

      return $output;
    }

    if(isset($_POST['save_order'])){
      $cashier_name = $_POST['cashier_name'];
      $order_date = date("Y-m-d",strtotime($_POST['orderdate']));
      $order_time = date("H:i", strtotime($_POST['timeorder']));
      $product_name = $_POST['productname'];
      $qty = $_POST['quantity'];
      $total = $_POST['total'];
      $paid = $_POST['paid'];
      $due = $_POST['due'];


      $arr_product_id =  $_POST['productid'];
      $arr_product_code = $_POST['productcode'];
      $arr_product_name = $_POST['productname'];
      $arr_product_stock = $_POST['productstock'];
      $arr_product_qty = $_POST['quantity'];
      $arr_product_satuan = $_POST['productsatuan'];
      $arr_product_price = $_POST['productprice'];
      $arr_product_total =  $_POST['producttotal'];
      $arr_product_utilidad =  $_POST['utilidad'];

      $utilidad_total = 0;

      if($arr_product_code == ""){
        echo '<script type="text/javascript">
              jQuery(function validation(){
              swal("Warning", "Por favor complete el formulario de transacción", "warning", {
              button: "Continuar",
                  });
              });
              </script>';
      }else{


        $insert = $pdo->prepare("INSERT INTO tbl_invoice(cashier_name, order_date, time_order, total, paid, due)
        values(:name, :orderdate, :timeorder, :total, :paid, :due)");

        $insert->bindParam(':name', $cashier_name);
        $insert->bindParam(':orderdate',  $order_date);
        $insert->bindParam(':timeorder',  $order_time);
        $insert->bindParam(':total', $total);
        $insert->bindParam(':paid', $paid);
        $insert->bindParam(':due', $due);

        $insert->execute();


        $invoice_id = $pdo->lastInsertId();
        if($invoice_id!=null){
          for($i=0; $i<count($arr_product_id); $i++){

            $rem_qty = $arr_product_stock[$i] - $arr_product_qty[$i];

            if($rem_qty<0){
              echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Ingrese el monto de la compra", "warning", {
                    button: "Continuar",
                        });
                    });
                    </script>';
            }else{
              $update = $pdo->prepare("UPDATE tbl_product SET stock = '$rem_qty' WHERE product_id='".$arr_product_id[$i]."'");
              $update->execute();

            }


            $insert = $pdo->prepare("INSERT INTO tbl_invoice_detail(invoice_id, product_id, product_code, product_name, qty, price, total, order_date)
            values(:invid, :productid, :productcode, :productname, :qty, :price, :total, :orderdate)");

            $utilidad_total += $arr_product_qty[$i] * $arr_product_utilidad[$i];

            $insert->bindParam(':invid',  $invoice_id);
            $insert->bindParam(':productid',   $arr_product_id[$i]);
            $insert->bindParam(':productcode',   $arr_product_code[$i]);
            $insert->bindParam(':productname', $arr_product_name[$i]);
            $insert->bindParam(':qty', $arr_product_qty[$i]);
            $insert->bindParam(':price',  $arr_product_price[$i]);
            $insert->bindParam(':total',   $arr_product_total[$i]);
            $insert->bindParam(':orderdate',  $order_date);

            $insert->execute();
          }
          
          $update = $pdo->prepare("UPDATE tbl_invoice set utilidad_total = $utilidad_total where invoice_id = :invoice_id");
          $update->bindParam(':invoice_id', $invoice_id);
          $update->execute();

          echo '<script>location.href="create_order.php";</script>';
        }
      }


    }

?>
<style>


	/* div.scroll_horizontal {
	width: 100%;
	overflow: auto;
	border: 1px solid #fff;
	background-color: #fff;
	padding-bottom: 5%;
  z-index: auto;

 
} */

a.chosen-single {
  height: 34px !important;
  border-radius: 0 !important;
  
}
a.chosen-single span, a.chosen-single div b {
  margin-top: 5px !important;
}



</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 align="center">
        TRANSACCIONES
      </h2>
    
    </section>

    <!-- Main content -->
    <section class="content container-fluid animate__animated animate__headShake">
        <div class="box box-success">
          <form action="" method="POST">
            <div class="box-body">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Usuario</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="cashier_name" value="<?php echo $_SESSION['fullname']; ?>" readonly>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Fecha de la transacción</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="orderdate" value="<?php echo date("d-m-Y");?>" readonly
                    data-date-format="yyyy-mm-dd">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Hora de la transacción</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="timeorder" value="<?php echo date('H:i') ?>" readonly>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>
            <th>
            <button type="button" name="addOrder" style="border-radius:20px;" class="btn btn-primary btn-md btn_addOrder " required><span>
                    <i class="fa fa-plus" style="font-size:20px;"></i><spam>  Añadir producto</spam> 
                  </span></button>

            <div class="box-body">
              <!-- <div class="col-md-8 scroll_horizontal"> -->
              <div class="col-md-10">
                <table class="table table-border" id="myOrder">
                  <thead>
                  <tr>
                          <th>  </th>
                          <th>Producto</th>
                          <th>Stock</th>
                          <!-- <th>Costo</th> -->
                          <th>Valor</th>
                          <th>Cantidad</th>
                          <th>Total</th>
                          <th>
                           
                          </th>
                      </tr>

                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                  <label>Total</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>COP</span>
                    </div>
                    <input type="text" class="form-control pull-right" name="total" id="total" required readonly>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Dinero recibido</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>COP</span>
                    </div>
                    <input type="text" class="form-control pull-right" name="paid" id="paid" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Cambio</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>COP <?php echo $_SESSION['invoice_id']; ?></span>
                    </div>
                    <input type="text" class="form-control pull-right" name="due" id="due" required readonly>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>

            <div class="box-footer" align="center">
                <input type="submit" name="save_order" value="Guardar transacción" class="btn btn-primary">
                <a href="order.php" style="" class="btn btn-info">Volver<i class="fa fa-angle-left" style="width:30px"></i></a>
              </div>
          </form>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- AQUI COMIENZA EL CODIGO PARA REALIZAR UNA ORDEN -->
  <div class="addorder">
    <script>
      
    //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      })

      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      })

      //iCheck for checkbox and radio inputs
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
      })

      $(document).ready(function(){
        $(document).on('click','.btn_addOrder', function(){
          var html='';
          html+='<tr>';
          html+=`<td>
          <button type="button" name="remove" class="btn btn-danger btn-sm btn-remove"><i class="fa fa-trash"></i></button>
        <input type="hidden" class="form-control productcode" name="productcode[]" readonly>
        <input type="hidden" class="form-control utilidad" name="utilidad[]" readonly>
        <input type="hidden" class="form-control productname" style="width:300px;" name="productname[]" readonly>
        </td>`;
          
          html+='';
          html+='<td ><select required data-placeholder="Selecciona un producto.." class="form-control chosen-select productid" name="productid[]" style="width:250px;"><option style="border-radius: 20px;" value="">--Selecciona Producto--</option><?php
          echo fill_product($pdo)?></select></td>';
          html+='<td><input type="number" class="form-control productstock" style="width:150px;" name="productstock[]" readonly required></td>';
          // html+='<td><input type="number" class="form-control productcompra" style="width:90px;" name="productcompra[]" readonly></td>';
          html+='<td> <input type="number" class="form-control productprice" style="width:150px;"  min="1" name="productprice[]" readonly required></td>';
          html+='<td><input type="number" class="form-control quantity_product" style="width:150px;" min="1" name="quantity[]" required></td>';
          html+='<td><input type="number" class="form-control producttotal" style="width:150px;" name="producttotal[]" readonly required></td>';
        
          $('#myOrder').append(html);

          $('.productid').chosen({
            no_results_text: "Oops, no se encontraron resultado."
          });

          $('.productid').on('change', function(e){
            var productid = this.value;
            var tr=$(this).parent().parent();
            $.ajax({
              url:"getproduct.php",
              method:"get",
              data:{id:productid},
              success:function(data){
                console.log(data);
                tr.find(".productcode").val(data["product_code"]);
                tr.find(".utilidad").val(data["utilidad"]);
                tr.find(".productname").val(data["product_name"]);
                tr.find(".productstock").val(data["stock"]);
                tr.find(".productcompra").val(data["purchase_price"]);
                tr.find(".productprice").val(data["sell_price"]);
                tr.find(".quantity_product").val(0);
                tr.find(".producttotal").val(tr.find(".quantity_product").val() * tr.find(".productprice").val());
                calculate(0,0);
              }
            })
          })

        })

        $(document).on('click','.btn-remove', function(){
          $(this).closest('tr').remove();
          calculate(0,0);
          $("#paid").val(0);
        })

        $("#myOrder").delegate(".quantity_product","keyup change", function(){
          var quantity = $(this);
          var tr=$(this).parent().parent();
          if((quantity.val()-0)>(tr.find(".productstock").val()-0)){
            swal("Warning","Inventario insuficiente","warning");
            quantity.val(1);
            tr.find(".producttotal").val(quantity.val() * tr.find(".productprice").val());
            calculate(0,0);
          }else{
            tr.find(".producttotal").val(quantity.val() * tr.find(".productprice").val());
            calculate(0,0);
          }
        })

        function calculate(paid){
          var net_total = 0;
          var paid = paid;

          $(".producttotal").each(function(){
            net_total = net_total + ($(this).val()*1);
          })

          due = net_total - paid;

          $("#total").val(net_total);
          $("#due").val(due);
        }


        $("#paid").keyup(function(){
          var paid = $(this).val();
          calculate(paid);
        })

      });


      
        
  </script>
 </div>   

 <?php
    include_once'inc/footer_all.php';
 ?>