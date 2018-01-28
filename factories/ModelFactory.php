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
class ModelFactory implements IModelFactory{
    
    
    public function newExample($attr1, string $attr2): \Example {
        return new Example($attr1, $attr2);
    }

}
