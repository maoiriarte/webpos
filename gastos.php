
<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }

    include_once'inc/header_all.php';

    error_reporting(0);
    date_default_timezone_set('america/bogota');
 
 
    $select = $pdo->prepare("SELECT SUM(gasto) as i FROM tbl_gastos");
              $select->execute();
              $row=$select->fetch(PDO::FETCH_OBJ);
              $gasto = $row->i;


    $id = $_GET['id'];
    if( !empty($id) ) {
    $delete = $pdo->prepare("DELETE FROM tbl_gastos WHERE gasto_id=".$id);

    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "El gasto ha sido eliminado satisfactoriamente", "info", {
            button: "Continuar",
                });
            });

            </script>';
    }
}
   

    if(isset($_POST['save_gasto'])){

       
        $idgasto = $_POST['id_gasto'];
        $fech = date("Y-m-d",strtotime($_POST['fecha']));
        $cat = $_POST['cat_name'];
        $gas = $_POST['gasto'];
        $desc = $_POST['descrip'];

        if(isset($_POST['id_gasto'])){
            $select = $pdo->prepare("SELECT id_gasto FROM tbl_gastos WHERE id_gasto='id_gasto'");
            $select->execute();

            if($select->rowCount() > 0){
                echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal.fire("Warning", "Esta gasto ya existe", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            } else {
    
                    //insert query here
                    $insert = $pdo->prepare("INSERT INTO tbl_gastos(id_gasto,fecha,cat_name,gasto,descrip)VALUES(:id_gasto,:fecha,:cat_name,:gasto,:descrip)");

                    //binding the values parameter with input from cliente
          
                    $insert->bindParam(':id_gasto', $idgasto);
                    $insert->bindParam(':fecha', $fech);
                    $insert->bindParam(':cat_name', $cat);
                    $insert->bindParam(':gasto', $gas);
                    $insert->bindParam(':descrip', $desc);
    
                    //if execution $insert
                    if($insert->execute()){
                        echo'<script type="text/javascript">
                            jQuery(function validation(){
                            swal.fire("Registro Exitoso", "Gasto registrado satisfactoriamente", "success", {
                            button: "Ok",
                                });
                                
                            });
                            
                            </script>';
                            
                    } else {
                        echo'<script type="text/javascript">
                            jQuery(function validation(){
                            swal.fire("Error", "No se pudieron guardar los datos", "warning", {
                            button: "Ok",
                                });
                            });
                            </script>';
                        }
                    }
                }
            }

?>
<html>
<head>
<meta http-equiv="refresh" content="25">

</head>
</html>
    <div class="content-wrapper">
                    <!-- Main content -->
        <section class="content container-fluid">         
                <h1 class="box-title">LISTA DE GASTOS</h1>
                        <div class="box box-success ">
                            <BR></BR>
                            <!-- Button trigger modal -->
                            <?php if($_SESSION['role']=="Admin"){ ?>
                <button id="btnExportar" class="btn btn-primary btn-md pull-right" style="border-radius:20px">
                  <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Excel
                </button>
                <?php
                }
                ?>  
                            <button type="button" style="border-radius:20px" class="btn btn-primary pull-right" data-toggle="modal" data-target="#gastos">
                            <i class="fa fa-plus"> </i> 
                            Agregar gasto
                            </button>
                            <br>
                                <!-- Modal -->
                                <div class="box-header with-border">
            <h2  >TOTAL GASTOS: <b><br> <br><?php echo "$ ".number_format ($row->i,0)?></b> </h2>
        </div>
           
                            <form action="" method="POST">     
                                <div class="modal fade" id="gastos" tabindex="-1" role="dialog" aria-labelledby="gastos" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content" style="border-radius:30px">
                                            <div class="modal-header" style="background-color:#367fa9; color:#fff">
                                                <h2 class="modal-title" id="gastos">Agregar gasto</h2>
                                                <button type="button" tyle="color:#fff" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body ">
                                            
                                                <!-- . . . . . . . . . . . . . . . . . . . . . . . -->
                                                <div class="form-group">
                                                    <label for="">Código de egreso</label><br>
                                                    <span class="text-muted">Asegúrese de que los códigos de producto sean correctos</span>
                                                    <input type="number" class="form-control"
                                                    name="id_gasto" value="<?php echo rand() ?>" readonly>
                                                </div>
                                                    <label for="">Seleccione una fecha</label>
                                                <div class="input-group date col-md-12">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input placeholder="Seleccione una fecha" type="text" class="form-control pull-right" id="datepicker_1" name="fecha" data-date-format="yyyy-mm-dd">
                                                </div>
                                                <br>
                                                <div class="form-group input-group date form-row col-md-12 col-xs-12">
                                                    <label for="">Categoría</label>
                                                    <select class="form-control" name="cat_name" required>
                                                    <option disabled selected>Selecciona una categoria</option>
                                                    <?php
                                                        $select = $pdo->prepare("SELECT * FROM tbl_category_gastos");
                                                        $select->execute();
                                                        while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                                        extract($row)
                                                    ?>
                                                    
                                                        <option><?php echo $row['cat_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>
                                                    
                                                </div>

                                            <div class="form-group col">
                                                <label for="inputEmail4">Monto de gasto</label>
                                                <input type="number" class="form-control" name="gasto" id="inputEmail4" placeholder="Ingrese monto" required>
                                            </div>
                            
                                            <div class="form-group col">
                                                <label for="exampleFormControlTextarea1">Descripción breve</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" name="descrip" rows="2" required></textarea>
                                            </div>
                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" name="save_gasto" class="btn btn-primary">Guardar</button>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>         
                
                        </div>    
            
                    <!-- Category Table -->
            

  
            <div class="col-md-12 rounded float-righ">
            
            
                <!-- /.box-header -->
                <div class="box-body" style="overflow-x:auto;">
                    <table class="table table-striped" id="tabla">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Descripción</th>
                                <th>Opción</th>

                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $select = $pdo->prepare('SELECT * FROM tbl_gastos');
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){ ?>
                            <tr>
                                <td><?php echo $row->fecha; ?></td>
                                <td><?php echo $row->cat_name; ?></td>
                                <td><?php echo $row->gasto; ?></td>
                                <td><?php echo $row->descrip; ?></td>
                                <td>
                                <a href="gastos.php?id=<?php echo $row->gasto_id; ?>"
                                onclick="return confirm('Realmente desea eliminarlo?')"
                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>

                                <a href="edit_gasto.php?id=<?php echo $row->gasto_id; ?>" class="btn btn-info btn-sm" style="width:30px"><i class="fa fa-pencil"></i></a>
                                <?php
                                }
                                ?>
                    
                            </td>
                            </tr>
                            <?php
                        ?>
                        </tbody>
                        
                    </table>
                </div>
                
               
            </div>
        </section>
        
        <!-- /.box -->
    </div>
    <script>
    //Date picker
    $('#datepicker_1').datepicker({
      autoclose: true
    });
  
  $(document).ready( function () {
      $('#tabla').DataTable();
  } );
 
        $('#gastos').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
        })
    </script>
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
    include_once'inc/footer_all.php';
 ?>