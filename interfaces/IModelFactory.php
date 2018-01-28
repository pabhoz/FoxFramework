<?php

/**
 *
 * @author pabhoz
 */
interface IModelFactory {
    
    public function newExample($attr1, string $attr2): Example;
    
}
