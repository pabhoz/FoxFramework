<?php
/**
 * Description of cUrlClient
 *
 * @author pablo bejarano
 * @pabhoz on twitter
 */
class CUrlClient {
    
    function __construct($url,$rt = 1,$JSON = true) {
        
        $this->url = $url;
        $this->returnTransfer = $rt;
        $this->jsonOutput = $JSON;
        
    }
    
    function execute($method = "GET", $data = array()){
        
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $this->url); 
        switch ($method){
            case "POST":
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $this->returnTransfer); 
        if($this->jsonOutput != false){
            $output = json_decode(curl_exec($ch),true);
        }else{
            $output = curl_exec($ch);
        }
        curl_close($ch);
        
        return $output;
    }
}