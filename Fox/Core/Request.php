<?php

class Request {
    
    public $method;
    public $parameters;
    public $phpinput;
    private $format;
    private $status;
 
    public function __construct() {

        $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
        $this->phpinput = file_get_contents('php://input');
        
        $this->parseIncomingParams();
        
        $this->format = 'application/json';
        $this->status = 200;
        
        if(isset($this->parameters['format'])) {
            $this->format = $this->parameters['format'];
        }
        
        //Por defecto la respuesta del servicio será JSON
        Request::setHeader($this->status,$this->format);
        
        return true;
    }
 
    private function parseIncomingParams() {
        $parameters = array();
 
        if ($_SERVER['QUERY_STRING'] != null) {
            parse_str($_SERVER['QUERY_STRING'], $parameters);
        }

        $body = file_get_contents("php://input");
        $content_type = ( isset($_SERVER["CONTENT_TYPE"])) ?
                $_SERVER["CONTENT_TYPE"] : false;
        $this->getContentType($content_type,$body);
        $this->parameters = $parameters;
    }
    
    private function getContentType($content_type,$body){
        switch($content_type) {
            case "application/json":
                $body_params = json_decode($body);
                if($body_params) {
                    foreach($body_params as $param_name => $param_value) {
                        $parameters[$param_name] = $param_value;
                    }
                }
                $this->format = "application/json";
                break;
            case "application/x-www-form-urlencoded":
                $postvars = [];
                parse_str($body, $postvars);
                foreach($postvars as $field => $value) {
                    $parameters[$field] = $value;
 
                }
                $this->format = "html";
                break;
        }
    }
    
    public static function getCodEstado($codigo) {  
     $estado = array(  
       200 => 'OK',  
       201 => 'Created',  
       202 => 'Accepted',  
       204 => 'No Content',  
       301 => 'Moved Permanently',  
       302 => 'Found',  
       303 => 'See Other',  
       304 => 'Not Modified',  
       400 => 'Bad Request',  
       401 => 'Unauthorized',  
       403 => 'Forbidden',  
       404 => 'Not Found',  
       405 => 'Method Not Allowed',  
       500 => 'Internal Server Error');  
     return $estado[$codigo]; 
   } 
   
   public static function setHeader($status,$format="application/json") {  
     header("HTTP/1.1 " . $status . " " . Request::getCodEstado($status));  
     header("Content-Type:" .$format. ';charset=utf-8');  
   }
   
   public static function error($msg,$status,$format="application/json"){
       Request::setHeader($status,$format);
       $response = ["status"=>$status,
                    "msg"=>$msg];
       Penelope::printJSON($response);
   }
   
   public static function response($msg,$args,$error = 0){
       $response = [
               "error"=>$error,
                "msg"=>$msg
            ];
       
            foreach ($args as $key => $value) {
                $response[$key] = $value;
            }
        return $response;
   }
}
