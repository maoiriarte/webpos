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
    $delete_query = "DELETE tbl_invoice , tbl_invoice_detail FROM tbl_invoice INNER JOIN tbl_invoice_detail ON tbl_invoice.invoice_id =
    tbl_invoice_detail.invoice_id WHERE tbl_invoice.invoice_id=$id";
    $delete = $pdo->prepare($delete_query);
    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Transacción eliminada", "info", {
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
<link rel="stylesheet" type="text/css" href="/dist/css/efectos.css" media="screen" />
</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  

    <!-- Main content -->
    <section class="content container-fluid animate__animated animate__headShake">
    
    <h1 class="box-title">LISTA DE VENTAS REALIZADAS</h1>
        <div class="box ">
       
            <div class="box-header with-border">
                <!-- <h3 class="box-title">Lista de transacciones</h3> -->

                
                




                <div class="box-header with-border">
                
                <?php if($_SESSION['role']=="Admin"){ ?>
                <button id="btnExportar" class="btn btn-primary btn-md pull-right" style="border-radius:20px">
                  <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Excel
                </button>
                <?php
                }
                ?>  

            </div>
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="tabla">
                        <thead>
                            <tr>
                                <th style="width:20px;">No</th>
                                <th style="width:80px;">Usuario</th>
                                <th style="width:40px;">Fecha</th>
                                <th style="width:40px;">Dinero</th>
                                <th style="width:40px;">Opción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $select = $pdo->prepare("SELECT * FROM tbl_invoice as tbl_user ORDER BY invoice_id  DESC LIMIT 150");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td><?php echo $no++ ; ?></td>
                                <td class="text-uppercase"><?php echo $row->cashier_name; ?></td>
                                <td><?php echo $row->order_date; ?></td>
                                <td><?php echo $row->total; ?></td>
                                <td>
                                    <?php if($_SESSION['role']=="Admin"){ ?>
                                    <a href="order.php?id=<?php echo $row->invoice_id; ?>" onclick="return confirm('¿Realmente desea eliminar la transacción?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    <?php } ?>
                                    <a data-toggle="modal" data-target="#detail-modal" onclick="showDetail(<?php echo $row->invoice_id; ?>)" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                    <a href="misc/nota.php?id=<?php echo $row->invoice_id; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
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

    <!-- Modal detalle -->
    <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius:30px">
            <div class="modal-header"  style="background-color:#367fa9; color:#fff">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle de la transacción</h4>
            </div>
            <div class="modal-body" >
                <h4><p align="center">
                <a href=""> | </a>
                   <i class="glyphicon glyphicon-user "></i> <span id="invoice-detail-user"></span>
                   <a href="">  |  </a> 
                    <i class="glyphicon glyphicon-calendar"> </i> <span id="invoice-detail-date"></span>
                   <a href="">  |  </a>
                    <i class="glyphicon glyphicon-time"> </i> <span id="invoice-detail-time"></span>
                    <a href=""> | </a>
                </p></h4>
                <table class="table">            
                    <thead style="background-color:#595959; color:#fff">
                        <th>Nº</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                        <th>Total</th>
                    </thead>
                    <tbody id="detail-invoice-body" style="background-color:#f0f1f3">
                    </tbody>
                </table>
                
                    <h4 align="center"><b>TOTAL DE LA COMPRA</h4><H1 align="center" style="background-color:#f6f7f9"><span  id="total-invoice-detail"> </b> </span>
                </H1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Fin Modal detalle -->


  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready( function () {
      $('#tabla').DataTable();
  } );

  async function showDetail(invoiceId) {
    if( !invoiceId ) return
    const response = (await (await fetch(`getDetailInvoice.php?id=${ invoiceId }`)).json())
    const { detail, invoice } = response

    const options1 = {style: 'currency', currency: 'COP'}
    const numberFormat = new Intl.NumberFormat('ru-RU', options1)
    document.querySelector('#detail-invoice-body').innerHTML = detail.join('')
    document.querySelector('#total-invoice-detail').innerHTML = " $" + (numberFormat.format(invoice.total)).split(',')[0]
    document.querySelector('#invoice-detail-user').innerHTML = invoice.cashier_name
    document.querySelector('#invoice-detail-date').innerHTML = invoice.order_date
    document.querySelector('#invoice-detail-time').innerHTML = invoice.time_order
  }



  </script>
   <script>
        const $btnExportar = document.querySelector("#btnExportar"),
            $tabla = document.querySelector("#tabla");

        $btnExportar.addEventListener("click", function() {
            let tableExport = new TableExport($tabla, {
                exportButtons: false, // No queremos botones
                filename: "Lista de ventas realizadas", //Nombre del archivo de Excel
                sheetname: "Lista de ventas realizadas", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });
    </script>
 <?php
    include_once'inc/footer_all.php';
 ?>