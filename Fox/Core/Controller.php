<?php
/**
 * Description of Controller
 *
 * @author Pabhoz
 */
namespace Fox\Core;

class Controller {
    
    function __construct() {
        $this->view = new View();
        Session::init();
    }
    
    function validateKeys($keys,$where){
        foreach ( $keys as $key ){
            if(empty($where[$key]) or !isset($where[$key])){
                exit("No se encuentra el campo ".$key."!");
            }
        }
        return true;
    }
    
    public function toUppercase(&$arr){
        $arr = array_map(function($el){
            return (is_string($el)) ? strtoupper($el) : $el;
        }, $arr);
    } 
    
}

spl_autoload_register(function($class){
    if(file_exists("./controllers/".$class.".php")){
        require "./controllers/".$class.".php";
    }
});