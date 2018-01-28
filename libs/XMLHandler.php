<?php
/**
 * XMLHandler v1.0
 * Author: Pablo Bejarano
 * Date: Sábado 6 de Abril 2013
 * Description: A library to handle SimpleXML objects to write, update and save
 * XML documents easier.
 * Contact: Vía Twitter: @pabhoz, email: pabhoz[a]gmail.com
 */

class XMLHandler {

    /**
     * 
     * @param String $rootNode
     * @return \SimpleXMLElement
     */
    public function createXML($rootNode) {

        $xml_content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                        <" . $rootNode . "></" . $rootNode . ">";

        $xml = new SimpleXMLElement($xml_content);

        return $xml;
    }

    /**
     * function based on php snippet by :http://stackoverflow.com/users/748813/hanmant
     * you can see it right here: http://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
     * 
     * @param Array $data
     * @param SimpleXML $xml
     */
    function array_to_xml($data, &$xml) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild("$key");
                    self::array_to_xml($value, $subnode);
                } else {
                    self::array_to_xml($value, $xml);
                }
            } else {
                $xml->addChild("$key", "$value");
            }
        }
    }
    
    /**
     * 
     * @param XML $xml
     * @param String $node
     * @param String $element
     * @param int/string $targetVal
     * @param String $targetE
     * @param int/String $newVal
     */
    public function updateXML(&$xml,$node,$element,$targetVal,$targetE,$newVal){
                
        foreach( $xml->xpath($node."[".$element."='".$targetVal."']") as $t ) {
            
            $t->$targetE = $newVal;

        }
        
    }

    /**
     * 
     * @param SimpleXML $xml
     * @param String $path
     */
    public function save($xml, $path) {

        $xml->asXML($path);
    }

    /**
     * 
     * @param String $path
     */
    public function getXML($path) {

        if (file_exists($path)) {

            return simplexml_load_file($path);
        } else {

            return "Error: XML doesn't exist.";
        }
    }
    
    /**
     * 
     * @param SimpleXML $xml
     * @param String $parentNode
     * @param String $element
     * @param int/String $val
     * @return boolean
     */
    public function findValue($xml,$parentNode,$element,$val) {
        
        foreach ($xml->$parentNode as $parentNode) {
            if (isset($parentNode->$element)){
                if((string)$val == $parentNode->$element){
                   return true;
                }else{
                    return false;
                }
               
            }
                
        }
    }
    
    /**
     * 
     * @param SimpleXML $xml
     * @param String $parentNode
     * @param String $element
     * @param int/String $val
     * @return boolean
     */
    public function findNode($xml,$parentNode,$element,$val) {
        
        foreach ($xml->$parentNode as $parentNode) {
            if (isset($parentNode->$element)){
                if((string)$val == $parentNode->$element){
                   return $parentNode;
                }
               
            }
                
        }
    }
    
    /**
     * 
     * @param XML $xml
     * @return JSON
     */
    function XMLtoJSON($xml){
        return json_encode($xml);
    }
    
    /**
     * 
     * @param XML $xml
     * @return XML
     */
    function XMLtoArray($xml){
        
        self::XMLtoJSON($xml);
        return get_object_vars(json_decode($json));
        
    }
    
    function parseToAdd(&$array,$parentNode){

                $array = array($parentNode => $array);
        
    }
    
    

}

?>
