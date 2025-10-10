<?php
/* Zona de declaración de funciones */
//*******Funciones de debugueo****
function dump($var){
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
function getFormMarkup($posPersonaje){
    
    $output = '<form action="'.$_SERVER['PHP_SELF'].'" method="post">
        <input type="submit" name="direccion" value="arriba">
        <input type="submit" name="direccion" value="izquierda">
        <input type="submit" name="direccion" value="derecha">
        <input type="submit" name="direccion" value="abajo">';
    if(isset($posPersonaje)){
        $output .= '<input type="hidden" name="pos_personaje" value="'.base64_encode(serialize($posPersonaje)).'">';
        //$output .= '<input type="hidden" name="col" value="'.$posPersonaje['col'].'">
        //<input type="hidden" name="row" value="'.$posPersonaje['row'].'">';
    }
    $output.='</form>';
    
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

/*function procesaRedirect(){
    if((!isset($_GET['col']))&&(!isset($_GET['row']))){
        header("HTTP/1.1 308 Permanent Redirect");
        header('Location: ./index.php?row=0&col=0');
    }
}*/

function procesarInput(){
    
    $posActual = filter_input(INPUT_POST, 'pos_personaje', FILTER_DEFAULT);
    
    
    $posActual = isset($posActual)?unserialize(base64_decode($posActual)):array(
        'row' => 0,
        'col' => 0,
    );
    
    $col = $posActual['col'];
    $row = $posActual['row'];

    

    $direccion = filter_input(INPUT_POST, 'direccion', FILTER_DEFAULT);
    
    if(isset($direccion)){
        switch($direccion){
            case 'arriba':
                $posActual['row']--;
            break;
            case 'abajo':
                $posActual['row']++;
            break;
            case 'derecha':
                $posActual['col']++;
           break;
           case 'izquierda':
                $posActual['col']--;
            break;    
        }
    }
    return $posActual;
}

function getMensajes(&$posPersonaje){
    if(!isset($posPersonaje)){
        return array('La posición del personaje no está bien definida');
    }
    return array('');
}

/*function getArrows($posPersonaje){
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

}*/

