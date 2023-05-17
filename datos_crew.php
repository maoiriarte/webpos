<?php
    include_once'db/connect_db.php';

    $datos = array();

    $statement = $mysqli->prepare("SELECT * FROM datos_crew");

    $statement->execute();

    $resultado = $statement->get_result();

    while($row = $resultado->fetch_assoc()) $datos[] = $row;

    $mysqli->close();
?>