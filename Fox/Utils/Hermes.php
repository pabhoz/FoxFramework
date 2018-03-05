<?php

/**
 * Description of Hermes
 *
 * @author pabhoz
 */

class Hermes {
    
    public static function send($to,$subject,$from,$message,$reply ="",$cc = ""){
        
        $headers = "From: " . strip_tags($from) . "\r\n";
        if($reply != ""){
        $headers .= "Reply-To: ". strip_tags($reply) . "\r\n";
        }
        if($cc != ""){
            $headers .= "CC: $cc\r\n";    
        }
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        return mail($to, $subject, $message, $headers);
    }
    
    public static function newEvaluation($client){
       return "<!DOCTYPE html>
        <html>
        <body>
                <div>Hola, ".$client->getName()."</div>
                <p>En el siguiente link podrás ver la información de tu evaluación:</p>
                <p><a href='http://redfoxgym.redfoxme.com/site/Users/evaluation/".
               $client->getId()."' target='_BLANK'>Clic para ver evaluación</a></p></br>
                <p>Atentamente, club Deportivo Megagym</p>
        </body>
        </html>";
    }
    
}
