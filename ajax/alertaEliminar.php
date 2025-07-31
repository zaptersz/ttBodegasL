<?php
    include ('../conexion/conexion.php');
    $conn = Cconexion::conexionBD();
    $idBodega = $_POST['idBodega'] ?? '';
    $sql = "SELECT nombre FROM bodegas WHERE id = '$idBodega'";
    $stmt = $conn->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $bodegaNombre = $row['nombre'];
    $html = "
    
      <div class='modal-headerv'>
        <h5 class='modal-title'>Eliminar Bodega $idBodega</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>
        <p>¿Está Seguro De Eliminar La Bodega $idBodega, con nombre $bodegaNombre? <br></p>
        
        <div class='alert alert-warning' role='alert'>
            Esta acción no se puede deshacer.</p>
        </div>
        
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
        <a href='bodegasEliminar.php?id=$idBodega'><button type='button' class='btn btn-primary'>Eliminar</button></a>
      </div>
    ";

    echo $html;
?>