<?php
/**
 * Description of Index_controller
 *
 * @author pabhoz
 */

class Index_controller extends \Fox\FoxController{
   
    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        //$this->view->debug = true;
        $this->view->render($this,"index","View Title");
    }
    
}
