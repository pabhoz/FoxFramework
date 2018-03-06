<?php

spl_autoload_register(function($class){
    //print_r(str_replace('\\','/',$class));
    /*
     *  Namespaced Classes
     */
    if(file_exists(__DIR__."/".str_replace('\\','/',$class).".php")){
        require_once __DIR__."/".str_replace('\\','/',$class).".php";
        return 0;
    }
    
    /*
     *  User Classes
     */
    if(file_exists(LIBS.$class.".php")){
        require_once LIBS.$class.".php";
        return 0;
    }
    
    if(file_exists(MODELS.$class.".php")){
        require_once MODELS.$class.".php";
        return 0;
    }
    
    if(file_exists(BS.$class.".php")){
        require_once BS.$class.".php";
        return 0;
    }
    
    if(file_exists(MYLIBS.$class.".php")){
        require_once MYLIBS.$class.".php";
        return 0;
    }
    
    if(file_exists(INTERFACES.$class.".php")){
        require_once INTERFACES.$class.".php";
        return 0;
    }
    
    if(file_exists(BRIDGES.$class.".php")){
        require_once BRIDGES.$class.".php";
        return 0;
    }
    
    if(file_exists(FACTORIES.$class.".php")){
        require_once FACTORIES.$class.".php";
        return 0;
    }
    
    //die("$class not found.");

});
