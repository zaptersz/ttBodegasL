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
            $html.= "<strong>Rut: </strong> {$enc['run']}<br>";
            $html.= "<strong>Nombre: </strong> {$enc['nombre']} {$enc['apellido1']} {$enc['apellido2']}<br>";
            $html.= "<strong>Telefono: </strong> {$enc['telefono']}<br>";
            $html.= "<strong>Dirección: </strong> {$enc['direccion']}<br>";
            $html.= "</li>";
        }
        $html.= "</ul><br><button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Cerrar</button>";
    }else{
        $html.= "No hay encargados registrados para esta bodega.";

    }
  echo $html;
?>