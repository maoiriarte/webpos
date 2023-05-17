<?php
include_once("db/connect_db.php");


$id = $_POST['id'];
$id_cliente = $_POST['id_cliente'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$monto = $_POST['monto'];

$sentencia=$pdo->prepare("UPDATE tbl_crew SET id_cliente=:id_cliente, nombre=:nombre,direccion=:direccion,ciudad=:ciudad,telefono=:telefono,email=:email,monto=:monto WHERE id_cliente=:id_cliente");
 
$sentencia->bindParam(':id',$id);
$sentencia->bindParam(':id_cliente',$id_cliente);
$sentencia->bindParam(':nombre',$nombre);
$sentencia->bindParam(':direccion',$direccion);
$sentencia->bindParam(':ciudad',$ciudad);
$sentencia->bindParam(':telefono',$telefono);
$sentencia->bindParam(':email',$email);
$sentencia->bindParam(':monto',$monto);

if($sentencia->execute()){
    echo'<script type="text/javascript">
    jQuery(function validation(){
    swal.fire("Success", "Actualizado correctamente", "success", {
    button: "Continue",
        });
    });
    
    </script>';
    return header("Location:clientes.php");
}
?>