<?php

define('__FOX',__DIR__."/Fox/");

spl_autoload_register(function($class){
    
    /*
     *  Fox Framework Classes.
     */
    if(file_exists(__FOX."Core/".$class.".php")){
        require __FOX."Core/".$class.".php";
        return 0;
    }
    
    if(file_exists(__FOX."Utils/".$class.".php")){
        require __FOX."Utils/".$class.".php";
        return 0;
    }
    
    /*
     *  User Classes
     */
    if(file_exists(LIBS.$class.".php")){
        require LIBS.$class.".php";
        return 0;
    }
    
    if(file_exists(MODELS.$class.".php")){
        require MODELS.$class.".php";
        return 0;
    }
    
    if(file_exists(BS.$class.".php")){
        require BS.$class.".php";
        return 0;
    }
    
    if(file_exists(MYLIBS.$class.".php")){
        require MYLIBS.$class.".php";
        return 0;
    }
    
    if(file_exists(INTERFACES.$class.".php")){
        require INTERFACES.$class.".php";
        return 0;
    }
    
    if(file_exists(BRIDGES.$class.".php")){
        require BRIDGES.$class.".php";
        return 0;
    }
    
    if(file_exists(FACTORIES.$class.".php")){
        require FACTORIES.$class.".php";
        return 0;
    }

});