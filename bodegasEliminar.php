<?php

    include_once("conexion/conexion.php");
    $conn = Cconexion::conexionBD();
    $bodegaId = trim($_GET['id']);

    //primero hay que desligar los encargados
    $sqlQuitar = "UPDATE encargados SET idbodega = null WHERE idbodega = '$bodegaId'";
    $stmt = $conn->query($sqlQuitar);
    
    //ahora si hay que eliminar la bodega 
    $sqlElim ="DELETE FROM bodegas WHERE id = '$bodegaId'";
    $stmt = $conn->query($sqlElim);

    header("Location: index.php?zz=eli_exi");
?>