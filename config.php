<?php
    
    $https = filter_input(INPUT_SERVER, 'HTTPS');
    $http_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
    $document_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
    $server_name = filter_input(INPUT_SERVER, 'SERVER_NAME');
    $request_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
    
    $_PROTOCOL = (!is_null($https) && $https != 'off') ? 'https://' : 'http://';
    define('ROOT',$_PROTOCOL.preg_replace('/[^a-zA-Z0-9]\.:/i','',$http_host)
    .str_replace('\\','/',substr(dirname(__FILE__),strlen($document_root))).'/');//Returns Project basedir
    define('REQUEST', $_PROTOCOL.$server_name.$request_uri);//Returns Request complete URL
    
    //Domains configuration
    switch ($_SOURCE){
     case "admin":
        define('URL', ROOT.'admin/');
     break;
     case "site":
         define('URL', ROOT.'site/');
     break;
     case "services":
         define('URL', ROOT.'services/');
     break;
    }
    define('LOCAL_SERVER',true);
    //Archetype configuration Don't touch if you don't know what are you doin'
    define('LIBS',__DIR__.'/libs/');
    define('MYLIBS','libs/');
    define('MODELS',__DIR__.'/models/');
    define('BS',__DIR__.'/bussinesLogic/');
    define('MODULE','./views/modules/');
    define('INTERFACES',__DIR__.'/interfaces/');
    define('BRIDGES',__DIR__.'/bridges/');
    define('FACTORIES',__DIR__.'/factories/');
    define('ROOT_PUBLIC',ROOT.'public/');
    define('G_PUBLIC',__DIR__.'/public/');
    //Database configuration CHANGE THIS TO YOUR VALUES
    define('_DB_TYPE', 'mysql');
    define('_DB_HOST' , 'localhost');
    define('_DB_USER' , 'root' );
    define('_DB_PASS' , '' );
    define('_DB_NAME' , '[db_name]');
    //Security Configuration SAME HERE
    define('HASH_ALGO' , 'sha512');
    define('HASH_KEY' , 'my_key');
    define('HASH_SECRET' , 'my_secret');
    define('SECRET_WORD' , 'so_secret');
    
//Lazy Load Classes Register
require "loader.php";