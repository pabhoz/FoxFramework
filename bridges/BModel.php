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
abstract class BModel extends Model implements IModel{ 

    protected static $table;
    
    public function __construct() {
        self::$table = get_class($this);
    }
    abstract public function getMyVars();
    
}
