<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }
    include_once'inc/header_all.php';

    error_reporting(0);
    
    if ($_SESSION['compras']==1) {

?>
   <div class="content-wrapper">
   <!-- Main content -->
   <section class="content">

     <!-- Default box -->
     <div class="row">
       <div class="col-md-12">


</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
 <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
   <thead>
     <th>Opciones</th>
     <th>Fecha</th>
     <th>Proveedor</th>
     <th>Usuario</th>
     <th>Documento</th>
     <th>Número</th>
     <th>Total Compra</th>
     <th>Estado</th>
   </thead>
   <tbody>
    </div>
   <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a data-toggle="modal" href="#myModal">
      <button id="btnAgregarArt" type="button" class="btn btn-primary"><span class="fa fa-plus"></span>Agregar Articulos</button>
    </a>
   </div>
<div class="form-group col-lg-12 col-md-12 col-xs-12">
    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color:#A9D0F5">
       <th>Opciones</th>
       <th>Articulo</th>
       <th>Cantidad</th>
       <th>Precio Compra</th>
       <th>Precio Venta</th>
       <th>Subtotal</th>
      </thead>
      <tfoot>
        <th>TOTAL</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><h4 id="total">S/. 0.00</h4><input type="hidden" name="total_compra" id="total_compra"></th>
      </tfoot>
      <tbody>
        
      </tbody>
    </table>
   </div>
   <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
     <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
   </div>
 </form>
</div>
<!--fin centro-->
     </div>
     </div>
     </div>
     <!-- /.box -->

   </section>
   <!-- /.content -->
 </div>

 <!--Modal-->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h4 class="modal-title">Seleccione un Articulo</h4>
       </div>
       <div class="modal-body">
         <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
           <thead>
             <th>Opciones</th>
             <th>Nombre</th>
             <th>Categoria</th>
             <th>Código</th>
             <th>Stock</th>
             <th>Imagen</th>
           </thead>
           <tbody>
             
           </tbody>
           <tfoot>
             <th>Opciones</th>
             <th>Nombre</th>
             <th>Categoria</th>
             <th>Código</th>
             <th>Stock</th>
             <th>Imagen</th>
           </tfoot>
         </table>
       </div>
       <div class="modal-footer">
         <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
       </div>
     </div>
   </div>
 </div>
 <script src="dist/js/ingreso.js"></script>
 <!-- fin Modal-->
 <?php
    include_once'inc/footer_all.php';
 ?>

<?php 

}else{
require 'noacceso.php'; 
}

require 'footer.php';
?>


<?php 


ob_end_flush();
 ?>
 
