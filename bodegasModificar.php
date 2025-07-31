<?php $bodegaId = trim($_GET['id']);?>
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
    <title>Modificar Bodega</title>
</head>
<body style="background-color: #f8f9fa">
    <div class="d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-mt-5">
            <h1 class="text-center mb-4">Modificar Bodegas</h1>
            <?php
                include_once("conexion/conexion.php");
                $conn = Cconexion::conexionBD();
                //Tomaos los datos actuales de la bodega con el id obtenido x GET
                $sqlBodega = "SELECT nombre, direccion, dotacion, fecha, hora, estado FROM bodegas WHERE id = '$bodegaId'";
                $stmt = $conn->query($sqlBodega);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                //Traspaso a variables para mas comodidad.
                $bodegaNombre       = $row['nombre'];
                $bodegaDireccion    = $row['direccion'];
                $bodegaDotacion     = $row['dotacion'];
                $bodegaFecha        = $row['fecha'];
                $bodegahora         = $row['hora'];
                $bodegaEstado       = $row['estado'];
            ?>
            <div class="container">
                <a href="index.php" class="btn btn-info mt-3">← Volver al Inicio</a>
                <div class="card shadow-sm mx-auto w-50">
                    <div class="card-body">
                        <form action="bodegasModificarP.php" method="post">
                            <input type="hidden" id="idBodega" name="idBodega" value="<?php echo $bodegaId?>">
                            
                            <div class="mb-3">
                                <label for="nombre" class="form-floating">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $bodegaNombre?>">
                            </div>
                        
                            <div class="mb-3">
                                <label for="direccion" class="form-floating">Direccion</label>
                                <textarea for="direccion" class="form-control" aria-label="With textarea" id="direccion" name="direccion"><?php echo $bodegaDireccion?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="dotacion" class="form-floating">Dotacion</label>
                                <input type="number" class="form-control" id="dotacion" name="dotacion" value="<?php echo $bodegaDotacion?>" min="0">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-floating">Encargados De la Nueva Bodega</label>
                                <br>
                                <div class="form-check form-switch">
                                    <?php
                                        //Debo buscar los encargados actuales y los disponibles
                                        $sqlEn = "SELECT run, nombre, apellido1, apellido2, idbodega 
                                                FROM encargados 
                                                WHERE idbodega is null OR idbodega = '$bodegaId' 
                                                ORDER BY nombre;";
                                        $stmt = $conn->query($sqlEn);
                                        $encargados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        if (empty($encargados)){
                                            echo "
                                            <div class='alert alert-primary' role='alert'>No Hay Encargados Disponibles</div>";
                                        }
                                        foreach ($encargados as $enc) {
                                            $run = $enc['run']; 
                                            $nombre = $enc['nombre']; 
                                            $apell1 = $enc['apellido1']; $apell2 = $enc['apellido2'];
                                            //Solo debo marcar los encargados actuales
                                            if($enc['idbodega']){
                                                echo "<input checked class='form-check-input' type='checkbox' role='switch' id='$run' name='encargados[]' value='$run'>";
                                            }else{
                                                echo "<input class='form-check-input' type='checkbox' role='switch' id='$run' name='encargados[]' value='$run'>";
                                            }
                                            echo "<label class='form-check-label' for='switchCheckDefault'>$nombre $apell1 $apell2</label><br>";
                                        } ?>
                                    
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fecha" class="form-floating">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $bodegaFecha?>">
                            </div>

                            <div class="mb-3">
                                <label for="hora" class="form-floating">Hora</label>
                                <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $bodegahora?>">
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-floating">Estado</label>
                                <select class="form-select" aria-label="Estado" id="estado" name="estado">
                                    <?php 
                                        //marcando la opcion actual
                                        if($bodegaEstado){
                                            $op1 = "selected"; $op2 = "";
                                        }else{
                                            $op1 = ""; $op2 = "selected";
                                        }
                                        echo "
                                            <option $op1 value='1'>Activada</option>
                                            <option $op2 value='0'>Desactivada</option>
                                        ";        
                                    ?>
                                    
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Modificar</button>
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
        const nombreInput = document.getElementById("nombre");
        if (nombreInput.value.length > 100) {
            event.preventDefault();
            alert("El campo NOMBRE Bodega no puede tener más de 100 caracteres.");
        }
  });
</script>