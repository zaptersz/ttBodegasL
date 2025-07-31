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

    //en caso que no se marco dotacion, se define como 0
    if(!isset($_POST['dotacion']) || $_POST['dotacion'] == ''){
        $bodegaDotacion = 0;
    }

    //En caso de no mandar fecha
    if(!isset($_POST['fecha']) || empty($bodegaFecha)){
        $bodegaFecha = "fecha = null,";
    }else{
        $bodegaFecha = "fecha = '$bodegaFecha',";
    }

    //En caso de no mandar hora
    if(!isset($_POST['hora']) || empty($bodegaHora)){
        $bodegaHora = "hora = null,";
    }else{
        $bodegaHora = "hora = '$bodegaHora',";
    }
    

    $sql = "UPDATE bodegas  
            SET
                nombre = '$bodegaNombre', 
                direccion = '$bodegaDireccion', 
                dotacion = '$bodegaDotacion', 
                $bodegaFecha 
                $bodegaHora 
                estado = '$bodegaEstado'
            WHERE id = '$bodegaId'";

    $stmt = $conn->query($sql);
    
    //Bodega Actualizada. ahora hay que desasignar los encargados para luego volverlos a asignar porque no se sabe cuantos se han desmarcado
    $sqlQuitar = "UPDATE encargados SET idbodega = null WHERE idbodega = '$bodegaId'";
    $stmt = $conn->query($sqlQuitar);
 
    //ahora a asignar los encargados, en caso de que se haya selecionado al menos 1
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
    
    header("Location: index.php?zz=modi_exi");
?>