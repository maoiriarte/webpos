
<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }

    include_once'inc/header_all.php';

    error_reporting(0);
    date_default_timezone_set('america/bogota');

 
    if(isset($_POST['submit'])){

        $id_cliente = $_POST['id_cliente'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $ciudad = $_POST['ciudad'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $monto = $_POST['monto'];


        //check if the id_cliente already exist
        if(isset($_POST['id_cliente'])){
            $select = $pdo->prepare("SELECT id_cliente FROM tbl_crew WHERE id_cliente='$id_cliente'");
            $select->execute();

            if($select->rowCount() > 0 ){
                echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Esta identificación de cliente ya existe", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            } else {
                //insert query here
                $insert = $pdo->prepare("INSERT INTO tbl_crew(id_cliente,nombre,direccion,ciudad,telefono,email,monto) 
                VALUES(:id_cliente,:nombre,:direccion,:ciudad,:telefono,:email,:monto)");

                //binding the values parameter with input from cliente
                $insert->bindParam(':id_cliente',$id_cliente);
                $insert->bindParam(':nombre',$nombre);
                $insert->bindParam(':direccion',$direccion);
                $insert->bindParam(':ciudad',$ciudad);
                $insert->bindParam(':telefono',$telefono);
                $insert->bindParam(':email',$email);
                $insert->bindParam(':monto',$monto);

                //if execution $insert
                if($insert->execute()){
                    echo'<script type="text/javascript">
                        jQuery(function validation(){
                        swal.fire("Registro Exitoso", "Cliente registrado satisfactoriamente", "success", {
                        button: "Ok",
                            });
                        });
                        </script>';
                }
            }
        }
    }
?>

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid ">
        
    <!-- Modal -->
    <div class="modal fade" id="editcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header"  style="background-color:#367fa9; color:#fff">
            <h2 class="modal-title" id="exampleModalLabel">Editar cliente</h2>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!--..........................................................................................-->
                <!-- Main content -->
                  
                    <!-- Main content -->
                    <section class="content">
                        <form action="edit_clientes.php" method="POST">
                                <input type="hidden" name="id" id="update_id">
                            <!-- Registration Form -->
                            <div class="col-md-12">
                                    
                                    <!-- /.box-header -->
                                    <!-- form start -->

                                <div class="col-md-6">
                                    <label for="f_id">Identificación / Nit</label>
                                    <input type="number" id="id_cli" class="form-control" name="id_cliente" value="<?php echo $idcliente_db; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fname">Nombre completo</label>
                                    <input type="text" id="nom" class="form-control" name="nombre" value="<?php echo $nombre_db; ?> "required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fdireccion">Dirección</label>
                                    <input type="text" id="dir" class="form-control" name="direccion" value="<?php echo $direccion_db; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fciudad">Ciudad</label>
                                    <input type="text" id="ciu" class="form-control" name="ciudad" value="<?php echo $ciudad_db; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ftelefono">Teléfono</label>
                                    <input type="number" id="tel" class="form-control" name="telefono" value="<?php echo $telefono_db; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="femail">E-mail</label>
                                    <input type="text" id="em" class="form-control" name="email" value="<?php echo $email_db; ?>" require>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="fmonto">Monto a acreditar</label>
                                    <input type="number" id="mo" class="form-control" name="monto" value="<?php echo $monto_db; ?>" >
                                </div>
                                        
                                        
                             </div>
                                        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                              
                    </section>          

        </div>
       
        </div>
    </div>
    </div>
    <!-- /.content-wrapper -->
            <!--..........................................................................................-->


            <!-- Registration Form -->
        <h1 class="box-title">LISTA DE CLIENTES Y CARTERA</h1>
            
                <div class="container-fluid">  
                <?php if($_SESSION['role']=="Admin"){ ?>
                <button id="btnExportar" class="btn btn-primary btn-md pull-right" style="border-radius:20px; color:#fff">
                  <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Excel
                </button>
                <?php
                }
                ?>  
                        <button type="button" style="border-radius:20px" class="btn btn-primary pull-right" data-toggle="modal" data-target="#gastos">
                                <i class="fa fa-plus"> </i> 
                                Agregar cliente
                        </button>
                                <br>
                    <form action="" method="POST">  
                        <div class="modal fade" id="gastos" tabindex="-1" role="dialog" aria-labelledby="gastos" aria-hidden="true">
                            <div class="modal-dialog" role="document" style="border-radius:30px">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:#367fa9; color:#fff" >
                                        <h2 class="modal-title" id="gastos">Agregar cliente</h2>
                                        
                                        <button type="button" style="color:#fff"" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="box-body">

                                        
                                            <div class="form-group col-md-6">
                                                <label for="f_id">Identificación / Nit</label>
                                                <input type="number" class="form-control " id="f_id" name="id_cliente" placeholder="Ingrese la identificación" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fname">Nombre completo</label>
                                                <input type="text" class="form-control" id="fname" name="nombre" placeholder="Ingrese el nombre completo" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fdireccion">Dirección</label>
                                                <input type="text" class="form-control" id="fdireccion" name="direccion" placeholder="Ingrese una dirección" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fciudad">Ciudad</label>
                                                <input type="text" class="form-control" id="fciudad" name="ciudad" placeholder="Ingrese una ciudad" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="ftelefono">Teléfono</label>
                                                <input type="number" class="form-control" id="ftelefono" name="telefono" placeholder="Ingrese una ciudad" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="femail">E-mail</label>
                                                <input type="text" class="form-control" id="femail" name="email" placeholder="Ingrese un E-mail" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="fmonto">Monto a acreditar</label>
                                                <input type="number" class="form-control" id="fmonto" name="monto" placeholder="Ingrese monto a acreditar" required>
                                            </div>
                                          
                                            <div class="form-group footer col-md-12" >
                                                <button type="submit" class="btn btn-primary" name="submit" style="border-radius:20px"><i class="fa fa-user-plus" aria-hidden="true"></i>      Crear cliente</button>
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                            </div>
                        </div>
                    </form><!-- /.box-body -->
                        
                </div> 
            


           
        <div class="col-md-12 rounded float-righ">
            
            
            <!-- /.box-header -->
            <div class="box-body">
                <div class="box-body" style="overflow-x:auto;">
                    <table class="table table-striped col-md-12" id="tabla">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Identificación / Nit</th>
                                <th>Nombre del cliente</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>Teléfono</th>
                                <th>E-mail</th>   
                                <th>Crédito</th>
                                <th>Opción</th>   

                            </tr>
                        </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                $select = $pdo->prepare("SELECT * FROM tbl_crew");
                                $select->execute();
                                while($row=$select->fetch(PDO::FETCH_OBJ)){
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row->id_cliente; ?></td>
                                    <td><?php echo $row->nombre; ?></td>
                                    <td><?php echo $row->direccion; ?></td>
                                    <td><?php echo $row->ciudad; ?></td>
                                    <td><?php echo $row->telefono; ?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td><?php echo $row->monto; ?></td>
                                    <td>
                                    
                                         <a data-toggle="modal" style="border-radius:50px" href="#" data-target="#editcliente" class="btn btn-info btn-sm editbtn"><i class="fa fa-pencil"></i></a>
                                        <a href="delete_cliente.php?id=<?php echo $row->id_cliente; ?>"
                                        class="btn btn-danger btn-sm"  style="border-radius:50px" onclick="return confirm('¿Estas seguro, que deseas eliminar este usuario?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                    


                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                    </table>
                </div>  
            </div>
    </section>
    <!-- /.box -->
</div>
            
    <!-- /.content -->

  <!-- /.content-wrapper -->

  <script>
    //Date picker
    $('#datepicker_1').datepicker({
      autoclose: true
    });
  
  $(document).ready( function () {
      $('#tabla').DataTable();
  } );
 

      // <!-- -----------------------  SCRIPT PARA BUSCAR CLIENTE -->
     

    </script>


</script>
    <script>
        const $btnExportar = document.querySelector("#btnExportar"),
            $tabla = document.querySelector("#tabla");

        $btnExportar.addEventListener("click", function() {
            let tableExport = new TableExport($tabla, {
                exportButtons: false, // No queremos botones
                filename: "Lista de clientes", //Nombre del archivo de Excel
                sheetname: "Cartera", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });
    </script>

    <script>
        $('.editbtn').on('click', function(){
            $tr=$(this).closest('tr');
            var datos=$tr.children("td").map(function(){
                return $(this).text();
            });

            $('#update_id').val(datos[0]);
            $('#id_cli').val(datos[1]);
            $('#nom').val(datos[2]);
            $('#dir').val(datos[3]);
            $('#ciu').val(datos[4]);
            $('#tel').val(datos[5]);
            $('#em').val(datos[6]);
            $('#mo').val(datos[7]);
        });
    </script>
 <?php
    
    include_once'inc/footer_all.php';
 ?>