<?php

    include ('../conexion/conexion.php');
    $conn = Cconexion::conexionBD();
    $bodegaEstado = $_POST['id_filtro'] ?? '';
    $condicion = "";
    if($bodegaEstado != ''){
        $condicion = "WHERE estado = '$bodegaEstado'";
    }
    $sql = "SELECT id, nombre, direccion, dotacion, fecha, hora, estado FROM bodegas $condicion ORDER BY id";
    //Genero la query
    $stmt = $conn->query($sql);
    $html = "";
    //Despliego listadode bodegas
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $bodegaId = $row['id'];
        if ($row['estado']){
            $bodegaEstado = "Activada";
        }else{
            $bodegaEstado = "desactivada";
        }
        $html.="
            <tr>
                <th>$bodegaId</th> 
                <th>".$row['nombre']."</th>
                <th>".$row['direccion']."</th>
                <th>".$row['dotacion']."</th>
                <th> <button id='btnEncargados' class='btn btn-primary' data-id='$bodegaId' onclick='ajaxEncargado(".'"'.$bodegaId.'"'.");'>Ver</button></th>
                <th>".$row['fecha']."</th>
                <th>".$row['hora']."</th>
                
                <th>$bodegaEstado</th>
                <th>
                    <a href='bodegasModificar.php?id=$bodegaId'><button type='button' class='btn btn-primary'>Editar</button><a>
                    <button type='button' class='btn btn-primary' onclick='ajaxEliminar(".'"'.$bodegaId.'"'.");'>Eliminar</button>
                </th>
            </tr>
        ";
    }

    echo $html;

?>