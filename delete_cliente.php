<?php
 include_once'db/connect_db.php';
 session_start();
 if($_SESSION['role']!=="Admin"){
   header('location:index.php');
 }

$delete = $pdo->prepare("DELETE FROM tbl_crew WHERE id_cliente = '".$_GET['id']." '");
if($delete->execute()){
    header('location:clientes.php');
}


