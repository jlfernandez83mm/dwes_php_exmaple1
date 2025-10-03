<?php
/* Zona de declaración de funciones */
//*******Funciones de debugueo****
function dump($var){
    global $miVariable;
    echo $miVariable;
    echo '<pre>'.print_r($var,1).'</pre>';
}

//*******Función lógica presentación**********+
function getTableroMarkup ($tablero, $posPersonaje){
    $output = '';
    foreach ($tablero as $filaIndex => $datosFila) {
        foreach ($datosFila as $columnaIndex => $tileType) {
            if(isset($posPersonaje)&&($filaIndex == $posPersonaje['row'])&&($columnaIndex == $posPersonaje['col'])){
                $output .= '<div class = "tile ' . $tileType . '"><img src="./src/super_musculitos.png"></div>';    
            }else{
                $output .= '<div class = "tile ' . $tileType . '"></div>';
            }
        }
    }
    return $output;
}
function getMensajesMarkup($arrayMensajes){
    $output = '';
    foreach ($arrayMensajes as $mensaje){
        $output .= '<p>'.$mensaje.'</p>';
    }
    return $output;
    
}
function getArrowsMarkup($arrows){
    
    $output = '';
    if(isset($arrows)){
        foreach($arrows as $sentido => $arrayPos){
            $output .= '<a href="./index.php?col='.$arrayPos['col'].'&row='.$arrayPos['row'].'">'.$sentido.'</a> ';
        }
    }
    
    return $output;
    
}


//******+Función Lógica de negocio************
//El tablero es un array bidimensional en el que cada fila contiene 12 palabras cuyos valores pueden ser:
// agua
//fuego
//tierra
// hierba
function leerArchivoCSV($rutaArchivoCSV) {
    $tablero = [];

    if (($puntero = fopen($rutaArchivoCSV, "r")) !== FALSE) {
        while (($datosFila = fgetcsv($puntero)) !== FALSE) {
            $tablero[] = $datosFila;
        }
        fclose($puntero);
    }

    return $tablero;
}
function leerInput(){
    
    $col = filter_input(INPUT_GET, 'col', FILTER_VALIDATE_INT);
    $row = filter_input(INPUT_GET, 'row', FILTER_VALIDATE_INT);

    return (isset($col) && is_int($col) && isset($row) && is_int($row))? array(
            'row' => $row,
            'col' => $col
        ) : null;
}

function getMensajes(&$posPersonaje){
    if(!isset($posPersonaje)){
        return array('La posición del personaje no está bien definida');
    }
    return array('');
}

function getArrows($posPersonaje){
    if(isset($posPersonaje)){

        $arrows = array(
            'izquierda' => array(
                'row' => $posPersonaje['row'],
                'col' => $posPersonaje['col'] -1,
            ),
            'arriba' => array(
                'row' => $posPersonaje['row'] -1,
                'col' => $posPersonaje['col'] ,
            ),
            'derecha' => array(
                'row' => $posPersonaje['row'],
                'col' => $posPersonaje['col'] +1,
            ),
            'abajo' => array(
                'row' => $posPersonaje['row'] +1,
                'col' => $posPersonaje['col'],
            ),
        );
        return $arrows;
    }
    return null;

}

