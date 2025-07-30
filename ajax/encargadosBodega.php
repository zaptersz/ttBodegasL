<?php
    include ('../conexion/conexion.php');
    $conn = Cconexion::conexionBD();
    $idBodega = $_POST['idBodega'] ?? '';
    
    //Armo Query
    $sql = "select 
            run, 
            nombre,
            apellido1,
            apellido2,
            direccion, 
            telefono 
        FROM encargados 
        WHERE idbodega = '$idBodega';";

    $stmt = $conn->query($sql);
    $encargados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $html = "";
    //despliego listado de Encargados
    if($encargados){
        $html.= "<ul class='list-group'>";
        foreach ($encargados as $enc) {
            $html.= "<li class='list-group-item'>";
            $html.= "<strong>Nombre: </strong> {$enc['nombre']}<br>";
            $html.= "<strong>Nombre: </strong> {$enc['telefono']}<br>";
            $html.= "</li>";
        }
        $html.= "</ul>";
    }else{
        $html.= "No hay encargados registrados para esta bodega.";

    }
  echo $html;
?>