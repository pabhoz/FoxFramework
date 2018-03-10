<?php
/**
 *
 * @author pabhoz
 */
namespace Fox\Abstractions;

interface IServiceController {

    public function get($method,$params = null);
    public function post($method,$params = null);
    public function put($method,$params = null);
    public function delete($method,$params = null);
    
}
