
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("alertas.php");?>   

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Librería de bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Inicio</title>
</head>
<body>
    <?php
        //Conexion a BD
        include_once("conexion/conexion.php");
        $conn = Cconexion::conexionBD();
    ?>
    <div class="container">
    <h1>Listado Bodegas</h1>
    <br>
    <a href="bodegasAgregar.php"><button type="button" class="btn btn-primary">Agregar Bodega</button></a>
    <br>
    <br>

    <div class="container">
        <h2>Filtro Estado</h2>
            <select id="filtroEstado" class="form-select form-select-lg mb-3" aria-label="Filtrar Estado" onchange="ajaxFiltro();">
                <option selected value= "">Todos</option>
                <option value="1">Activadas</option>
                <option value="0">Desactivadas</option>
            </select>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Direccion</th>
                <th scope="col">Dotación</th>
                <th scope="col">Encargados</th>
                <th scope="col">Fecha Creacion</th>
                <th scope="col">Hora</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        <tbody id="bodegaCuerpo">
            <?php
                //formulo la Query
                $sql = "SELECT id, nombre, direccion, dotacion, fecha, hora, estado FROM bodegas ORDER BY id";
                //Genero la query
                $stmt = $conn->query($sql);

                //Despliego listadode bodegas
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $bodegaId = $row['id'];
                    if ($row['estado']){
                        $bodegaEstado = "Activada";
                    }else{
                        $bodegaEstado = "desactivada";
                    }
                    echo "
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
            ?>
        <tbody>
    
        </div>
            
        <!-- Modal para mostrar encargados de bodegas -->
       
        <div class="modal fade" id="modalEncargados" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Encargados de la Bodega</h5> 
            </div>
            <div class="modal-body" id="listaEncargados">
            <!-- Se insertarán los encargados aqui -->
            </div>
            </div>
        </div>
        </div>

        <div class="modal fade" tabindex="-1" id="modalAlerta">
            <div class="modal-dialog">
                <div class="modal-content" id="eliminarAlerta">
                </div>
        </div>
        </div>

</body>
</html>

    <script type="text/javascript">
        function ajaxEncargado(idBodega){
            console.log("hola"+idBodega);
            $.ajax({
                type: 'POST',
                url: 'ajax/encargadosBodega.php',
                data: { idBodega: idBodega },
                success: function(respuesta) {
                    $('#listaEncargados').html(respuesta);
                    $('#modalEncargados').modal('show');
                },
                error: function() {
                    $('#listaEncargados').html('<p>Error al obtener encargadoss.</p>');
                    $('#modalEncargados').modal('show');
                }
            });
        };
        function ajaxEliminar(idBodega){
            console.log("hola - llevo"+idBodega);
            $.ajax({
                type: 'POST',
                url: 'ajax/alertaEliminar.php',
                data: { idBodega: idBodega },
                success: function(respuesta) {
                    console.log("hola "+respuesta)
                    $('#eliminarAlerta').html(respuesta);
                    $('#modalAlerta').modal('show');
                },
                error: function() {
                    $('#eliminarAlerta').html('<p>Error</p>');
                    $('#modalAlerta').modal('show');
                }
            });
        };

        function ajaxFiltro(idBodega){
            var id_filtro = document.getElementById("filtroEstado").value;
            console.log("hola - llevo"+idBodega);
            $.ajax({
                type: 'POST',
                url: 'ajax/bodegasFiltro.php',
                data: { id_filtro: id_filtro },
                success: function(respuesta) {
                    console.log("hola "+respuesta)
                    $('#bodegaCuerpo').html(respuesta);
                 
                },
                error: function() {
                    $('#bodegaCuerpo').html('<p>Error</p>');
                
                }
            });
        };
      
    </script>
