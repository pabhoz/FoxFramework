<?php
/**
 *  En memoria de Penelope.
 *  Penelope es una clase estatica para evitar errores de codificación (a nivel
 *  local, es decir, en entornos de desarrollo),al codificar un arreglo de PHP 
 *  a JSON; de esta manera evitamos tener
 *  que configurar el entorno de desarrollo.
 * 
 * @author Pabhoz
 */
class Penelope {

    public static function arrayToJSON($array) {
       
        array_walk_recursive($array, 'Penelope::encode_items');
        return (!LOCAL_SERVER)? utf8_decode(json_encode($array, JSON_UNESCAPED_UNICODE)) 
                : json_encode($array, JSON_UNESCAPED_UNICODE);
    }
    
    private static function encode_items(&$item) {
        $item = utf8_encode($item);
    }
    
    public static function printJSON($array) {
        
        print(Penelope::arrayToJSON($array));

    }

}
