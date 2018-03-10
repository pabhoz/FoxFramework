<?php

class Index_controller extends \Fox\FoxServiceController {

    function __construct() {
        parent::__construct();
    }

    public function getIndex() {
        \Fox\Core\Request::setHeader(202, "text/html");
        echo "Get method Index controller";
    }

    public function postIndex() {
        \Fox\Core\Request::setHeader(202, "text/html");
        echo "Post method Index controller";
    }

    public function getSaludo($nombre, $apellido) {
        if (!isset($nombre) || !isset($apellido)) {
            throw new Exception('Paremetros insuficientes.');
        }
        \Fox\Core\Request::setHeader(200, "text/plain");
        echo "Hey a" . $nombre . " " . $apellido . "!";
    }

}
