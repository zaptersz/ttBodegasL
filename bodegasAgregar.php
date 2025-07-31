<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Librería de bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Agregar Bodega</title>
</head>
<body>
    
<div class="container">
        <h1>Listado Bodegas</h1>
        <div class="container-sm">
        <form action="bodegasAgregarP.php" method="post">
            <div class="mb-3">
                <label for="idBodega" class="form-label">Id</label>
                <input type="text" class="form-control" id="idBodega" name="idBodega" aria-describedby="Id Del Container">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
          
            <div class="mb-3">
                <label for="direccion" class="form-label">Direccion</label>
                <textarea for="direccion" class="form-control" aria-label="With textarea" id="direccion" name="direccion"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="dotacion" class="form-label">Dotacion</label>
                <input type="number" class="form-control" id="dotacion" name="dotacion" min="0">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Encargados De la Nueva Bodega</label>
                <br>
                <div class="form-check form-switch">
                    <?php
                        include_once("conexion/conexion.php");
                        $conn = Cconexion::conexionBD();
                        $sql = "SELECT run, nombre, apellido1, apellido2, idbodega FROM encargados WHERE idbodega is null;";
                        $stmt = $conn->query($sql);
                        $encargados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (empty($encargados)){
                            echo "
                            <div class='alert alert-primary' role='alert'>No Hay Encargados Disponibles</div>";
                        }
                        foreach ($encargados as $enc) {
                            $run = $enc['run']; $nombre = $enc['nombre']; $apell1 = $enc['apellido1']; $apell2 = $enc['apellido2'];
                            echo "<input class='form-check-input' type='checkbox' role='switch' id='$run' name='encargados[]' value='$run'>";
                            echo "<label class='form-check-label' for='switchCheckDefault'>$nombre $apell1 $apell2</label><br>";
                        } ?>
                    
                </div>
             
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha">
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora">
            </div>

            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
        </div>
</div>
</body>
</html>