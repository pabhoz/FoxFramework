<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelFactory
 *
 * @author pabhoz
 */
namespace Fox;

abstract class FoxModel extends \Fox\Core\Model implements \Fox\Abstractions\IModel{ 

    protected static $table;
    protected $_table;
    
    public function __construct() {
        self::$table = get_class($this);
        $this->_table = get_class($this);
    }
    
    abstract public function getMyVars();
    
    public function getTable() {
        return $this->_table;
    }
    
}
