<?php
  /* alertas de estado al cargar pagina */
    switch ($_GET['zz']) {
        case 'add_exi':
            $alerta_tipo = "info";
            $alerta_texto = "¡Bodega Creada Con Éxito!";
            $alerta = true;
            break;
    }
?>