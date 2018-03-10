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

abstract class FoxServiceController extends \Fox\Core\ServiceController implements \Fox\Abstractions\IServiceController{ 

        function __construct() {
		parent::__construct();
	}
    
}
