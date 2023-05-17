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

    $id = $_GET['id'];
    if( !empty($id) ) {
    $delete = $pdo->prepare("DELETE FROM tbl_product WHERE product_id=".$id);

    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal.fire("Info", "El producto ha sido eliminado satisfactoriamente", "info", {
            button: "Continuar",
                });
            });
            
            </script>';
    }
}

?>
<html>
<head>
<meta http-equiv="refresh" content="60">

</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid animate__animated animate__headShake">
    <h1 class="box-title">LISTA DE PRODUCTOS</h1>
        <div class="box box-success">
        
            <div class="box-header with-border">
                
                <a href="add_product.php"><h1><button href="add_product.php" class="btn btn-primary btn-md pull-right" style="border-radius:20px"><i class="fa fa-plus"> </i>   Agregar producto</button></h1> </a>
                <?php if($_SESSION['role']=="Admin"){ ?>
                <button id="btnExportar" class="btn btn-primary btn-md pull-right" style="border-radius:20px">
                  <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Excel
                </button>
                <?php
                }
                ?>  
              
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="tabla">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Producto</th>
                                <!-- <th>Imagen</th> -->
                                <!-- <th>Código</th> -->
                                <th>Costo</th>
                                <th>P. Venta</th>
                                <th>Utilidad</th>
                                <th>Stock</th>
                                <th>Opción</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $select = $pdo->prepare("SELECT * FROM tbl_product");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td><?php echo $no++ ;?></td>
                                <td><?php echo $row->product_name; ?></td>

                              

                                <!-- <td><?php echo $row->product_code; ?></td> -->
                                <td><?php if($_SESSION['role']=="Admin"){ echo $row->purchase_price;}else{echo '--'; }?></td>
                                <td><?php echo $row->sell_price; ?></td>
                                <td><?php if($_SESSION['role']=="Admin"){ echo $row->sell_price - $row->purchase_price;}else{echo '--'; } ?> </td>
                                <td> <?php if($row->stock=="0"){ ?>
                                <span class="label label-danger"><?php echo $row->stock; ?></span>
                                <?php }elseif($row->stock<=$row->min_stock){ ?>
                                <span class="label label-warning"><?php echo $row->stock; ?></span>
                                <?php }else{ ?>
                                <span class="label label-primary"><?php echo $row->stock; ?></span>
                                <?php } ?>
                                </td>
                                
                                <td>
                                    <?php if($_SESSION['role']=="Admin"){ ?>
                                    <a href="product.php?id=<?php echo $row->product_id; ?>"
                                    class="btn btn-danger btn-sm" style="border-radius:50px" onclick="return confirm('¿Realmente desea eliminarlo?')"><i class="fa fa-trash"></i></a>
                                    
                                    <a href="edit_product.php?id=<?php echo $row->product_id; ?>" class="btn btn-info btn-sm" style="border-radius:50px"><i class="fa fa-pencil"></i></a>
                                    <?php
                                    }
                                    ?>
                                    <a href="view_product.php?id=<?php echo $row->product_id; ?>" class="btn btn-default btn-sm" style="border-radius:50px"><i class="fa fa-eye"></i></a>
                                </td>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready( function () {
      $('#tabla').DataTable();
  } );
  </script>
    <script>
        const $btnExportar = document.querySelector("#btnExportar"),
            $tabla = document.querySelector("#tabla");

        $btnExportar.addEventListener("click", function() {
            let tableExport = new TableExport($tabla, {
                exportButtons: false, // No queremos botones
                filename: "Lista de productos", //Nombre del archivo de Excel
                sheetname: "Lista de productos", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });
    </script>
 <?php
    include_once'inc/footer_all.php';
 ?>