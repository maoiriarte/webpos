<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }
    include_once'inc/header_all.php';

    error_reporting(0);
  



    if(isset($_POST['btn_edit'])){
        
        $idgasto = $_POST['id_gasto'];
        $fecha = $_POST['fecha'];
        $cat = $_POST['cat_name'];
        $gasto = $_POST['gasto'];
        $descrip = $_POST['descrip'];

        $update = $pdo->prepare("UPDATE tbl_gastos SET id_gasto='$idgasto', fecha='$fecha', cat_name='$cat', gasto='$gasto', descrip='$descrip' WHERE gasto_id='".$_GET['id']."' ");
       
        $update->bindParam(':id_gasto', $idgasto_req);
        $update->bindParam(':fecha', $fecha_req);
        $update->bindParam(':cat_name', $cat_req);
        $update->bindParam(':gasto', $gasto_req);
        $update->bindParam(':descrip', $descrip_req);

        if($update->execute()){
          echo'<script type="text/javascript">
          jQuery(function validation(){
          swal("Success", "La categoria ha sido actualizada", "success", {
          button: "Continue",
              });
          });
          </script>';
        }else{
          echo'<script type="text/javascript">
          jQuery(function validation(){
          swal("Success", "Categoría disponible", "success", {
          button: "Continue",
              });
          });
          </script>';
        }
    }
  
    if($id=$_GET['id']){
      $select = $pdo->prepare("SELECT * FROM tbl_gastos WHERE gasto_id = '".$_GET['id']."' ");
      $select->execute();
      $row = $select->fetch(PDO::FETCH_OBJ);

      $id_gasto = $row->id_gasto;
      $fecha = $row->fecha;
      $cat = $row->cat_name;
      $gasto = $row->gasto;
      $descrip = $row->descrip;

    }else{
      header('location:gastos.php');
    }
  
    include_once'inc/header_all.php';
?>

 
    <!-- Main content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content-header">
        <form action="" method="POST" name="form_gastos"
                enctype="multipart/form-data" autocomplete="off">
            <!-- Registration Form -->
            <div class="col-md-12">
                <br>
                <div class="box box-succes"> 
                    <h3 class="box-title">Editar gastos</h3>
                 <br>
                    <!-- /.box-header -->
                    <!-- form start -->
                        <div class="" >
                            
                                <div class="form-group col-md-4">
                                    <label >Id gasto</label>
                                    <input type="number" class="form-control" name="id_gasto" value="<?php echo $id_gasto; ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label >Fecha</label>
                                    <input type="" id="nom" class="form-control" name="fecha" value="<?php echo $fecha; ?> "required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Categoría</label>
                                        <select class="form-control" name="cat_name" required>
                                            <?php
                                            $select = $pdo->prepare("SELECT * FROM tbl_category_gastos");
                                            $select->execute();
                                            while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                            extract($row);
                                            ?>
                                                <option <?php if($row['cat_name']==$cat) {?>
                                                selected = "selected"
                                                <?php }?> >
                                                <?php echo $row['cat_name']; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label >Gasto</label>
                                    <input type="number"  class="form-control" name="gasto" value="<?php echo $gasto; ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Descripción</label>
                                    <input type="text"  class="form-control" name="descrip" value="<?php echo $descrip; ?>" required>
                                </div>
                          
                        
                        </div><!-- /.box-body -->
                        
                        <div class="box-footer">
                           
                        </div>
                            <button type="submit" class="btn btn-primary" name="btn_edit">Actualizar</button>
                            <a href="gastos.php" class="btn btn-warning">Volver</a>
                        </div>
                    </form>
                <div class="box-footer">
                    
                </div>
                </div>
          
               
              
        </form>

        


    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

 <?php
    include_once'inc/footer_all.php';
 ?>


   

