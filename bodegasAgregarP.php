<?php
    include_once("conexion/conexion.php");
    $conn = Cconexion::conexionBD();

    $bodegaId           = trim($_POST['idBodega']);
    $bodegaNombre       = trim($_POST['nombre']);
    $bodegaDireccion    = trim($_POST['direccion']);
    $bodegaDotacion     = trim($_POST['dotacion']);
    $bodegaFecha        = trim($_POST['fecha']);
    $bodegaHora         = trim($_POST['hora']);
    
    //en caso que no se marque dotacion, se difina con 0
    if(!isset($_POST['dotacion']) || $_POST['dotacion'] == ''){
        $bodegaDotacion = 0;
    }

    $sql = "INSERT INTO bodegas (
                id, 
                nombre, 
                direccion, 
                dotacion, 
                fecha, 
                hora, 
                estado
        )VALUES(
            '$bodegaId', 
            '$bodegaNombre', 
            '$bodegaDireccion', 
            '$bodegaDotacion', 
            '$bodegaFecha', 
            '$bodegaHora', 
            '1')";

    $stmt = $conn->query($sql);

    //Bodega creada. ahora hay que asignar los encargados
    if (isset($_POST['encargados'])){
        //verifico que se marcaron por lo menos 1 encargado
        $cont = 0;
        $condicion = "";
        //armo la condicion para modificar los encargados y enlazarlos a la bodega
        //anido la condicion para no realizar query por cada encargado y asi no saturar
        foreach ($_POST['encargados'] as $encargado) {
            //el primer campo no lleva ","
            if($cont == 0)
                $condicion.= "'$encargado'";
            else
                $condicion.= ", '$encargado'";
           $cont++;
        }

        $sql2 = "UPDATE encargados SET idbodega = '$bodegaId' WHERE run IN($condicion)";
        $stmt = $conn->query($sql2);
        
    }
    
    header("Location: index.php?zz=add_exi");
?>