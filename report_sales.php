<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['username']==""){
        header('location:index.php');
    }else{
        if($_SESSION['role']=="Admin"){
          include_once'inc/header_all.php';
          
        }else{
            include_once'inc/header_all_operator.php';
        }
    }
    error_reporting(0);

  
?>





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid animate__animated animate__headShake">
        <div class="box box-success">
          <form action="" method="POST" autocomplete="off">
            <div class="box-header with-border">
                <h3 class="box-title">Desde la fecha : <?php echo $_POST['date_1']?>
                </h3>
              
                <h3 class="box-title" >Hasta la fecha : <?php echo $_POST['date_2'] ?>
   
                </h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_1" name="date_1" data-date-format="yyyy-mm-dd">
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_2" name="date_2" data-date-format="yyyy-mm-dd">
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="date_filter" value="   Ver   "  class="btn btn-primary btn-sm">
                  
                </div>
                <br>
                <div class="col-md-3">
                


                <button id="btnExportar" class="btn btn-primary btn-md pull-left" style="border-radius:20px">
                  <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Excel
                </button>
                </div>
                <br>
              </div>
              <div>
                <br>

              </div>
                  <?php
                    $select = $pdo->prepare("SELECT sum(total) as total, sum(utilidad_total) as utilidad, count(invoice_id) as invoice FROM tbl_invoice
                    WHERE order_date BETWEEN :fromdate AND :todate");

                    // $select = $pdo->prepare("SELECT sum(gastos) as gastos, count(gasto_id) as gasto_id FROM tbl_gastos
                    // WHERE fecha BETWEEN :fromdate AND :todate");
                    
                    $select->bindParam(':fromdate', $_POST['date_1']);
                    $select->bindParam(':todate', $_POST['date_2']);
                    $select->execute();

                    $row = $select->fetch(PDO::FETCH_OBJ);

                    $total = $row->total;
                  
                
                   
                    $invoice = $row->invoice;
                    $utilidad = $row->utilidad;

                 // $select = $pdo->prepare("SELECT sum (total) as total FROM tbl_invoice INNER JOIN tbl_user ON tbl_user.user_id WHERE order_date = CURDATE()");
                    $select = $pdo->prepare("SELECT sum (total) as total FROM tbl_invoice_detail INNER JOIN tbl_user ON tbl_user.user_id WHERE order_date = CURDATE()");
                    $select->execute();
                    // $row=$select->fetch(PDO::FETCH_OBJ);
                    $total = $row->total;
                 
                    $update = $pdo->prepare("update tbl_invoice set utilidad_total = :utilidad_total where invoice_id = :invoice_id");
                    $update->bindParam(":utilidad_total", $utilidad_total);
                    $update->bindParam(":invoice_id", $invoice->invoice_id);

                    $update->execute();
                
// consulta para saber los gastos en un rango de fecha 
                  
                  //   $select = $pdo->prepare("SELECT sum (gastos) as gastos FROM tbl_gastos, count (gasto_id) as gastos FROM tbl_gastos
                  //   WHERE order_date BETWEEN :fromdate AND :todate");
                   
                  //  $select->bindParam(':fromdate', $_POST['date_1']);
                  //  $select->bindParam(':todate', $_POST['date_2']);
                  //  $select->execute(); 

                  //   $select->execute();
                  //   $gasto = $row->gasto;
                  //   $update = $pdo->prepare("update tbl_gastos set gastos = :gastos where gasto_id = :gasto_id");
                  //   $update->bindParam(":gasto_id", $gastos->gastos_id);
                  //   $update->execute();
// ---------------------------------------------------------------------------------------------------  
                  
                  $select = $pdo->prepare("SELECT fullname FROM tbl_user");
                  $select->execute();
                  $row=$select->fetch(PDO::FETCH_OBJ);
                  $nombre = $row->nombre;
                  ?>


              <div class="row">
                <div class="col-md-offset-0 col-md-4 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Total</span>
                      <span class="info-box-text">Operaciones</span>
                      <span class="info-box-number"><?php echo $invoice; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-offset-0 col-md-4 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Total</span>
                      <span class="info-box-text">de ingresos</span>
                      <span class="info-box-number">$ <?php echo number_format($total,0) ; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- <div class="col-md-offset-0 col-md-3 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Total</span>
                      <span class="info-box-text">de Gastos</span>
                      <span class="info-box-number">$ <?php echo number_format($gastos,0) ; ?></span>
                    </div>
                    
                  </div>
                
                </div> -->
                
                <div class="col-md-offset-0 col-md-4 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Total</span>
                      <span class="info-box-text">utilidad</span>
                      <span class="info-box-number">$ <?php echo number_format($utilidad,0) ; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
           

                <!-- /.col -->
              </div>

              <!--- Transaction Table -->
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="tabla">
                      <thead>
                          <tr>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Ingresos</th>
                            
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                            $select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE order_date BETWEEN :fromdate AND :todate");
                            $select->bindParam(':fromdate', $_POST['date_1']);
                            $select->bindParam(':todate', $_POST['date_2']);

                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                
                                <td class="text-uppercase"><?php echo $row->cashier_name; ?></td>
                                <td><?php echo $row->order_date; ?></td>
                                <td> <?php echo $row->total; ?></td>
                               
                                </tr>
                            <?php
                            }
                            ?>
                      </tbody>
                  </table>
              </div>

              <!-- Transaction Graphic -->
              <?php
                  $select = $pdo->prepare("SELECT order_date, sum(total) as price FROM tbl_invoice WHERE order_date BETWEEN :fromdate AND :todate
                  GROUP BY order_date");
                  $select->bindParam(':fromdate', $_POST['date_1']);
                  $select->bindParam(':todate', $_POST['date_2']);
                  $select->execute();
                  $total=[];
                  $date=[];
                  while($row=$select->fetch(PDO::FETCH_ASSOC)){
                      extract($row);
                      $total[]=$price;
                      $date[]=$order_date;

                  }
                  // echo json_encode($total);
              ?>
              <div class="chart">
                  <canvas id="myChart" style="height:250px;">

                  </canvas>
              </div>

              <?php
                  $select = $pdo->prepare("SELECT product_name, sum(qty) as q FROM tbl_invoice_detail WHERE order_date BETWEEN :fromdate AND :todate
                  GROUP BY product_id");
                  $select->bindParam(':fromdate', $_POST['date_1']);
                  $select->bindParam(':todate', $_POST['date_2']);
                  $select->execute();
                  $pname=[];
                  $qty=[];
                  while($row=$select->fetch(PDO::FETCH_ASSOC)){
                      extract($row);
                      $pname[]=$product_name;
                      $qty[]=$q;

                  }
                  // echo json_encode($total);
              ?>
              <div class="chart">
                  <canvas id="myBestSellItem" style="height:250px;">
                  </canvas>

          </form>
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script>
    //Date picker
    $('#datepicker_1').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker_2').datepicker({
      autoclose: true
    });

    $(document).ready( function () {
      $('#tabla').DataTable();
    } );
  </script>

  <script>
      var ctx = document.getElementById('myChart');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: <?php echo json_encode($date); ?>,
              datasets: [{
                  label: 'Total Pendapatan',
                  data: <?php echo json_encode($total); ?>,
                  backgroundColor: 'rgb(13, 192, 58)',
                  borderColor: 'rgb(32, 204, 75)',
                  borderWidth: 1
              }]
          },
          options: {}
      });
  </script>

  <style>
      .color{
          backgroundColor: rgb(120,102,102);
      }
  </style>


  <script>
      var ctx = document.getElementById('myBestSellItem');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: <?php echo json_encode($pname); ?>,
              datasets: [{
                  label: 'Total Produk Terjual',
                  data: <?php echo json_encode($qty); ?>,
                  backgroundColor: 'rgb(120,112,175)',
                  borderColor: 'rgb(255,255,255)',
                  borderWidth: 1
              }]
          },
          options: {}
      });
  </script>
<!-- script para exportar a excel -->
<script>
        const $btnExportar = document.querySelector("#btnExportar"),
            $tabla = document.querySelector("#tabla");

        $btnExportar.addEventListener("click", function() {
            let tableExport = new TableExport($tabla, {
                exportButtons: false, // No queremos botones
                filename: "Lista de gastos", //Nombre del archivo de Excel
                sheetname: "Lista de gastos", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });
    </script>

 <?php
//  include_once'update_utilidad.php';
    include_once'inc/footer_all.php';
 ?>