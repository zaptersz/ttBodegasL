<?php
    include_once("conexion/conexion.php");
    $conn = Cconexion::conexionBD();

    $bodegaId         = trim($_POST['idBodega']);
    $bodegaNombre       = trim($_POST['nombre']);
    $bodegaDireccion    = trim($_POST['direccion']);
    $bodegaDotacion     = trim($_POST['dotacion']);
    $bodegaFecha        = trim($_POST['fecha']);
    $bodegaHora         = trim($_POST['hora']);
    $bodegaEstado       = trim($_POST['estado']);

    
    $sql = "UPDATE bodegas  
            SET
                nombre = '$bodegaNombre', 
                direccion = '$bodegaDireccion', 
                dotacion = '$bodegaDotacion', 
                fecha = '$bodegaFecha', 
                hora = '$bodegaHora', 
                estado = '$bodegaEstado'
            WHERE id = '$bodegaId'";

    $stmt = $conn->query($sql);
    
    //Bodega creaActualizada. ahora hay que desasignar los encargados para luego volverlos a asignar
    $sqlQuitar = "UPDATE encargados SET idbodega = null WHERE idbodega = '$bodegaId'";
    $stmt = $conn->query($sqlQuitar);
 
    //ahora a asignar los encargados, en caso de que se haya selecionado al menos 1
    if (isset($_POST['encargados'])){
        //verifico que se marcaron por lo menos 1 encargado
        $cont = 0;
        $condicion = "";
        //armo la condicion para modificar los encargados y enalzarlos a la bodega
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
    
    header("Location: index.php?zz=modi_exi");
?>