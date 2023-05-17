<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']=="Admin"){
      include_once'inc/header_all.php';
    }else{
        include_once'inc/header_all_operator.php';
    }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row">



           <!-- Obtener inversion -->

      <!-- ---------------------------------------------------------------------------------------------- -->




        <!-- get alert stock -->
        <?php
        $select = $pdo->prepare("SELECT count(product_code) as total FROM tbl_product WHERE stock <= min_stock");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total1 = $row->total;
        ?>
      
        <!-- get total products-->
        <?php
        $select = $pdo->prepare("SELECT count(product_code) as t FROM tbl_product");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total = $row->t;
        ?>


      <div class="animate__animated animate__headShake" > 
        <!-- get total products notification -->
        <div class="col-md-4 col-sm-6 col-xs-12 ">
          <div class="info-box">
          <a href="product.php"><span class="info-box-icon bg-aqua"  style="border-radius:20px"><i class="fa fa-cubes"></i></span></a>

            <div class="info-box-content" >
             <span class="info-box-text">Total</span>
             <span class="info-box-text">de Productos</span>
              <span class="info-box-number"><?php echo $row->t ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- get today transactions -->
        <?php
        $select = $pdo->prepare("SELECT count(invoice_id) as i FROM tbl_invoice WHERE order_date = CURDATE()");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $invoice = $row->i ;
        ?>

      
         <!-- get today transactions notification -->
        <div class="col-md-4 col-sm-6 col-xs-12  ">
          <div class="info-box">
          <a href="order.php"><span class="info-box-icon bg-aqua"  style="border-radius:20px"> <span class="info-box-icon bg-aqua" style="border-radius:20px"><i class="fa fa-shopping-cart"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Transacciones</span>
              <span class="info-box-text">hoy</span>
              <span class="info-box-number"><?php echo $row->i ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <!-- get today income -->
        <?php
        $select = $pdo->prepare("SELECT sum(total) as total FROM tbl_invoice WHERE order_date = CURDATE()");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total = $row->total ;
        ?>
         <!-- get today income -->
         <?php if($_SESSION['role']=="Admin"){ ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua" style="border-radius:20px"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL </span>
              <span class="info-box-text">VENDIDO HOY</span>
              <span class="info-box-number">$ <?php echo number_format($total,0); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <?php
                }
                ?>  
      </div>
      </div>

      <div class="col-md-12 animate__animated animate__headShake">
        <div class="box box-success">
          <div align="center" class="box-header with-border m-0 vh-100 row justify-content-center align-items-center">
              <h1 class="box-title">Lista de productos más vendidos</h1>
          </div>
          <div class="box-body m-0 vh-100 row justify-content-center align-items-center">
            <div class=" col-md-12">
              <div style="overflow-x:auto;">
                <table class="table table-striped" id="myBestProduct">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Producto</th>
                              <th>Código</th>
                              <th>Vendido</th>
                              <th>Precio</th>
                              <th>Ingresos</th>
                          </tr>

                      </thead>
                      <tbody>
                          <?php
                          $no = 1;
                          $select = $pdo->prepare("SELECT product_code,product_name,price,sum(qty) as q, sum(qty*price) as total FROM
                          tbl_invoice_detail GROUP BY product_id ORDER BY sum(qty) DESC LIMIT 10");
                          $select->execute();
                          while($row=$select->fetch(PDO::FETCH_OBJ)){
                          ?>
                              <tr>
                              <td><?php echo $no++ ;?></td>
                              <td><?php echo $row->product_name; ?></td>
                              <td><?php echo $row->product_code; ?></td>
                              <td><?php echo $row->q; ?>
                              </td>
                              <td>$ <?php echo number_format($row->price);?></td>
                              <td>$ <?php echo number_format($row->total); ?></td>
                              </tr>

                        <?php
                          }
                        ?>
                      </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    </section>
  
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <script>
  $(document).ready( function () {
      $('#myBestProduct').DataTable();
  } );

  $(document).ready( function () {
      $('#myBestProductt').DataTable();
  } );
  </script>

<?php
    include_once'inc/footer_all.php';
 ?>