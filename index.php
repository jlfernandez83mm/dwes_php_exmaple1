<?php

/***** Inicialización del entorno ******/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('./lib/funciones.php');


/***** Lógica de negocio ******/
//procesaRedirect();
$posPersonaje = procesarInput();

//$arrows = getArrows($posPersonaje);

$tablero = leerArchivoCSV('./data/tablero1.csv');
//$mensajes =  getMensajes($posPersonaje);


//*****Lógica de presentación*******
$tableroMarkup = getTableroMarkup($tablero, $posPersonaje);
//$mensajesUsuarioMarkup = getMensajesMarkup($mensajes);
$formMarkup = getFormMarkup($posPersonaje);

include_once('./templates/index.tpl.php');

?>