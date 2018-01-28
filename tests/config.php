<?php
    
    define('LOCAL_SERVER',true);
    //Archetype configuration
    define('LIBS','libs/');
    define('MYLIBS','libs/');
    define('MODELS','models/');
    define('BS','bussinesLogic/');
    define('INTERFACES','interfaces/');
    define('BRIDGES','bridges/');
    define('FACTORIES','factories/');
    //Database configuration
    define('_DB_TYPE', 'mysql');
    define('_DB_HOST' , 'localhost');
    define('_DB_USER' , 'root' );
    define('_DB_PASS' , '' );
    define('_DB_NAME' , 'RedFoxGYM');
    //Security Configuration
    define('HASH_ALGO' , 'sha512');
    define('HASH_KEY' , 'my_key');
    define('HASH_SECRET' , 'my_secret');
    define('SECRET_WORD' , 'so_secret');
    
//Lazy Load Classes Regiser
require "loader.php";