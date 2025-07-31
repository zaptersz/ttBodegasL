<?php
    include ('../conexion/conexion.php');
    $conn = Cconexion::conexionBD();
    $idBodega = $_POST['idBodega'] ?? '';
    $sql = "SELECT nombre FROM bodegas WHERE id = '$idBodega'";
    $stmt = $conn->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $bodegaNombre = $row['nombre'];
    $html = "
    
      <div class='modal-header bg-danger text-white'>
        <h5 class='modal-title'><i class='bi bi-trash-fill'></i> Eliminar Bodega $idBodega</h5>
        <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='cerrar'></button>
      </div>
      <div class='modal-body'>
        <p>¿Está Seguro De Eliminar La Bodega <strong>$bodegaNombre </strong>? <br></p>
        
        <div class='alert alert-warning d-flex aling-items-center' role='alert'>
            <i class='bi bi-exclamation-triangle-fill'></i>  
            <div>Esta acción <strong>no se puede deshacer.</strong></div>
        </div>
        
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Cerrar</button>
        <a href='bodegasEliminar.php?id=$idBodega'><button type='button' class='btn btn-primary'>Eliminar</button></a>
      </div>
    ";

    echo $html;
?>