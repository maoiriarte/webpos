<?php

include_once'db/connect_db.php';
session_start();
if($_SESSION['role']!=="Admin"){
    header('location:index.php');
}
include_once'inc/header_all.php';


   error_reporting(0);
   date_default_timezone_set('america/bogota');

      //GUARDAR COTIZACION   --------------------------------------------------------------------
      if(isset($_POST['guardar'])){

        $cashier_name = $_POST['cashier_name'];
        $orderdate = $_POST['orderdate'];
        $num_cotizacion = $_POST['num_cotizacion'];
        $id_cliente = $_POST['id_cliente'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $ciudad = $_POST['ciudad'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $producto = $_POST['producto'];
        $productprice = $_POST['productprice'];
        $quantity = $_POST['quantity'];
        $producttotal = $_POST['producttotal'];
        $total = $_POST['total'];
        $product_id = $_POST['product_id'];

        if(isset($_POST['num_cotizacion'])){
          $select = $pdo->prepare("SELECT num_cotizacion FROM tbl_cot WHERE num_cotizacion='$id'");
          $select->execute();

          if($select->rowCount() > 0 ){
              echo'<script type="text/javascript">
                  jQuery(function validation(){
                  swal("Warning", "Este número de cotizacion de cliente ya existe", "warning", {
                  button: "Continue",
                      });
                  });
                  </script>';
          } else {

                // INSERTAR DATOS DE COTIZACION A LA BD ----------------------------------------------------
                
                $insert = $pdo->prepare("INSERT INTO tbl_cot(cashier_name,orderdate,num_cotizacion,
                id_cliente,nombre,direccion,ciudad,telefono,email,producto,productprice,quatity,producttotal,
                total,product_id)VALUES(:cashier_name,:orderdate,:num_cotizacion,:id_cliente,:nombre,:direccion,:ciudad,
                :telefono,:email,:producto,:productprice,:quantity,:producttotal,:total,:product_id)");
                
                //vincular el parámetro de valores con la entrada del cliente

                $insert->bindParam(':cashier_name',$cashier);
                $insert->bindParam(':orderdate',$odate);   
                $insert->bindParam(':num_cotizacion',$num_cot);
                $insert->bindParam(':id_cliente',$id_cli);
                $insert->bindParam(':nombre',$nom);
                $insert->bindParam(':direccion',$dir);
                $insert->bindParam(':ciudad',$ciU);
                $insert->bindParam(':telefono',$tel);
                $insert->bindParam(':email',$em);
                $insert->bindParam(':producto',$produ);
                $insert->bindParam(':productprice',$productpri);
                $insert->bindParam(':quantity',$quanti);
                $insert->bindParam(':producttotal',$producttotal);
                $insert->bindParam(':total',$total_total);
                $insert->bindParam(':product_id',$product_id);
                $insert->execute();
                //if execution $insert
                if($insert->execute()){
                  echo'<script type="text/javascript">
                          jQuery(function validation(){
                          swal.fire("Success", "Producto guardado con éxito", "success", {
                          button: "Continuar",
                              });
                          });
                          </script>';
              }else{
                  echo '<script type="text/javascript">
                          jQuery.fire(function validation(){
                          swal("Error", "Ocurrió un error", "error", {
                          button: "Continuar",
                              });
                          });
                          </script>';

            
          }
      }
        }
  }
      
?>
<?php
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

    function fill_crew($pdo){
        $output= '';
  
        $select = $pdo->prepare("SELECT * FROM tbl_crew");
        $select->execute();
        $result = $select->fetchAll();
  
        foreach($result as $row){
          $output.='<option value="'.$row['id_cliente'].'">'.$row["id_cliente"].'</option>';
        }
  
        return $output;
      }
      if($id=$_GET['id']){
        $select = $pdo->prepare("SELECT * FROM tbl_crew WHERE id_cliente=$id");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);
        
        $idcliente_db = $row['id_cliente'];
        $nombre_db = $row['nombre'];
        $direccion_db = $row['direccion'];
        $ciudad_db = $row['ciudad'];
        $telefono_db = $row['telefono'];
        $email_db = $row['email'];
       
    
        }else{
        header('location:vender.php');
        }

?>
<style>
a.chosen-single {
  height: 34px !important;
  border-radius: 10px !important;
}
a.chosen-single span, a.chosen-single div b {
  margin-top: 5px !important;
  
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header animate__animated animate__headShake">
      <h2 align="center">
        CREAR COTIZACIÓN
      </h2>
    
    </section>

    <!-- Main content -->
    <section class="col-md-12 animate__animated animate__headShake">
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
                  <label>Fecha</label>
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
                  <label>N° Cotización</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-file-pdf-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="num_cotizacion" value="<?php echo rand() ?>" readonly
                    data-date-format="yyyy-mm-dd">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
    </section>
            
    <!-- Main content -->
    
        <form action="" method="POST" id="formulario">
            <!-- Registration Form -->
            <div class="col-md-12 ">
                <div class="">
                    
                    <div class="box-header with-border">
    
                    </div>
                 
                    <!-- /.box-header -->
                    <!-- BUSCAR CLIENTE ------------------------------------------------------------ -->
                 
                        <div class="form-group col-md-4">
                        <label for="fname">CC ó NIT</label>
                        <input type="hidden" class="form-control addOrder" name="id_cliente[]" readonly>
                        <select id="id_cliente" data-placeholder="Selecciona un cliente..." class="form-control chosen-select idcliente" name="id_cliente[]" style="width:100%;" required><option value="">--Selecciona cliente--</option><?php
                        echo fill_crew($pdo)?></select>

                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fname">Nombre completo</label>
                                    <input type="text" class="form-control nom" name="nombre[]" value="<?php echo $nombre_db; ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fdireccion">Dirección</label>
                                    <input type="text" class="form-control dir" name="direccion[] value="<?php echo $direccion_db; ?>"" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fciudad">Ciudad</label>
                                    <input type="text" class="form-control ciu" name="ciudad[]" value="<?php echo $ciudad_db; ?>"readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ftelefono">Teléfono</label>
                                    <input type="number" class="form-control tel" name="telefono[]" value="<?php echo $telefono_db; ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="femail">E-mail</label>
                                    <input type="text" class="form-control em" name="email[]" value="<?php echo $email_db; ?>"readonly>
                                </div>
                        
                        </div><!-- /.box-body -->    
                </div>
   
             
            </section>

            <!-- ---------------------------- -->

            <div class="box-body">
              <div class="col-md-11 ">
                <table class="table table-border" id="myOrder">
                  <thead>
                      <tr>
                          <th></th>
                          <th colspan="2">Producto</th>
                          <th>Precio venta</th>
                          <th>Cantidad</th>
                          <th>Total</th>
                          <th>
                            <button type="button" name="addOrder" class="btn btn-success btn-sm btn_addOrder" required><span>
                              <i class="fa fa-plus"></i>
                            </span></button>
                          </th>
                      </tr>

                  </thead>
                
                </table>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-offset-7 col-md-4">
                <div class="form-group">
                  <label>Total</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>COP</span>
                    </div>
                      <input type="text" class="form-control pull-right" name="total" id="total" required readonly>
                    </div>
                  <!-- /.input group -->
                  <div>
                    <br>
                     <button type="submit" class="btn btn-success" name="guardar">Guardar cotización</button>
            </div>
                  <!-- /.input group -->
                </div>
             
                  <!-- /.input group -->
                </div>
              </div>       
            </div>
          </form>
        
    
    <!-- /.content -->
 
  <!-- /.content-wrapper -->

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
        <input type="hidden" class="form-control productcode" name="productcode[]"  readonly>
        
        <input type="hidden" class="form-control productname" style="width:200px;" name="productname[]" readonly>
        </td>`;
        html+='<td colspan="2"><select data-placeholder="Selecciona un producto.." class="form-control chosen-select productid" name="productid[]" style="width:270px;" required><option value="">--Selecciona Producto--</option><?php
        echo fill_product($pdo)?></select></td>';
      
        html+='<td><input type="text" class="form-control productprice" style="width:100px;" name="productprice[]" readonly></td>';
        html+='<td><input type="number" class="form-control quantity_product" style="width:80px;" name="quantity[]" required></td>';
        html+='<td><input type="text" class="form-control producttotal" style="width:150px;" name="producttotal[]" readonly></td>';
        html+='<td><button type="button" name="remove" class="btn btn-danger btn-sm btn-remove"><i class="fa fa-trash"></i></button></td>'

        $('#myOrder').append(html);

        $('.productid').chosen({
          no_results_text: "Oops, no se encontraron resultados."
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
             
              tr.find(".productname").val(data["product_name"]);
        
       
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

        $("#total").val(net_total);
     
      }

      $('#id_cliente').chosen({
        width: '100%',
        no_results_text: "Oops, no se encontraron resultados."
      });
      // <!-- -----------------------  SCRIPT PARA BUSCAR CLIENTE -->
      $('#id_cliente').on('change', function(e){
        var idcliente = this.value;
        var tr=$(this).parent().parent();
        $.ajax({
          url:"getcrew.php",
          method:"get",
          data:{id:idcliente},
          success:function(data){
            console.log(data);
            tr.find(".idcli").val(data["id_cliente"]);
            tr.find(".nom").val(data["nombre"]);
            tr.find(".dir").val(data["direccion"]);
            tr.find(".ciu").val(data["ciudad"]);
            tr.find(".tel").val(data["telefono"]);
            tr.find(".em").val(data["email"]);
          
          }
        })



      });

    

  })

  </script>
  <script>
   document.querySelectorAll('.printbutton').forEach(function(element) {
    element.addEventListener('click', function() {
        print();
    });
});
</script>
<script>
var formulario = document.getElementById('formulario');

formulario.addEventListener('submit', function(e){
  e.preventDefault();
  console.log('Se estan enviando los datos...')
});
  </script>
 

 <?php
    include_once'inc/footer_all.php';
 ?>