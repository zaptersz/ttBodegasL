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
    //Despliego listado de bodegas
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $bodegaId = $row['id'];
        //Personalizo el estado
        if ($row['estado']){
            $bodegaEstado = "Activada";
            $estadoEstilo = "success";
        }else{
            $bodegaEstado = "desactivada";
             $estadoEstilo = "danger";
        }
        $html.="
            <tr>
                <td>$bodegaId</td> 
                <td>".$row['nombre']."</td>
                <td>".$row['direccion']."</td>
                <td class='text-center'>".$row['dotacion']."</td>
                <td class='text-center'> <button id='btnEncargados' class='btn btn-primary' data-id='$bodegaId' onclick='ajaxEncargado(".'"'.$bodegaId.'"'.");'>Ver</button></td>
                <td>".$row['fecha']."</td>
                <td>".$row['hora']."</td>
                
                <td class='text-center'><span class='badge bg-$estadoEstilo'>$bodegaEstado</span></td>
                <td>
                    <a href='bodegasModificar.php?id=$bodegaId'><button type='button' class='btn btn-primary'>Editar</button><a>
                    <button type='button' class='btn btn-danger' onclick='ajaxEliminar(".'"'.$bodegaId.'"'.");'>Eliminar</button>
                </td>
            </tr>
        ";
    }

    echo $html;

?>