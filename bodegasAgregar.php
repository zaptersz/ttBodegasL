<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Librería de bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Agregar Bodega</title>
</head>
<body style="background-color: #f8f9fa">
    <div class="d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-mt-5">

            <h1 class="text-center mb-4">Agregar Bodega</h1>
            <div class="container">
            <div class="card shadow-sm mx-auto w-50">
                <div class="card-body">
                    <a href="index.php" class="btn btn-outline-info d-inline-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-arrow-left-circle"></i> Volver al Inicio
                    </a>

                    <form action="bodegasAgregarP.php" method="post">
                        <div class="mb-3">
                            <label for="idBodega" class="form-floating">Id</label>
                            <input type="text" class="form-control" id="idBodega" name="idBodega" maxlength="5" aria-describedby="Id Del Container" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-floating">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="direccion" class="form-floating">Direccion</label>
                            <textarea for="direccion" class="form-control" aria-label="With textarea" id="direccion" name="direccion"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="dotacion" class="form-floating">Dotacion</label>
                            <input type="number" class="form-control" id="dotacion" name="dotacion" min="0">
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-floating">Encargados De la Nueva Bodega</label>
                            <div class="border rounded p-3 bg-light mt-3 w-75 mx-auto">
                            <br>
                                <div class="form-check form-switch">
                                    <?php
                                        include_once("conexion/conexion.php");
                                        $conn = Cconexion::conexionBD();
                                        //solo muestro Encargados Sin bodegas
                                        $sql = "SELECT run, nombre, apellido1, apellido2, idbodega FROM encargados WHERE idbodega is null;";
                                        $stmt = $conn->query($sql);
                                        $encargados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        if (empty($encargados)){
                                            //si no hay encargados
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
                        
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-floating">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>

                        <div class="mb-3">
                            <label for="hora" class="form-floating">Hora</label>
                            <input type="time" class="form-control" id="hora" name="hora" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Agregar</button>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </main>
    <?php include_once("footer.php"); ?>
    </div>
</body>
</html>
<script>
    //validaciones del formulario
    document.querySelector("form").addEventListener("submit", function(event) {
        const idInput = document.getElementById("idBodega");
        const nombreInput = document.getElementById("nombre");
        if (idInput.value.length > 5) {
            //en caso que intenten forzar agregar campo mayo a 5 caracteres
            event.preventDefault();
            alert("El campo ID Bodega no puede tener más de 5 caracteres.");
        }else if (nombreInput.value.length > 100) {
            event.preventDefault();
            alert("El campo NOMBRE Bodega no puede tener más de 100 caracteres.");
        }
  });
</script>