<?php

/**
 * Description of PushNotifications
 *
 * @author pabhoz
 */
class PushNotifications {
    //put your code here
    private static $appId = "XYXRnQICHR0fGu3h1GIOizqpJVv0hskIM3rXzARb";
    private static $restKey = "FR7HvkKu4smUvAjxCFmCd6YbpQOAeKzp8Ba22Yga";
    
    public static function push($deviceToken, $msg){
        

        $url = 'https://api.parse.com/1/push';

        $push_payload = json_encode(array(
            "where" => array(
                "deviceToken" => $deviceToken,
            ),
            "data" => array(
                "alert" => $msg
            )
        ));

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_PORT, 443);
        curl_setopt($rest, CURLOPT_POST, 1);
        curl_setopt($rest, CURLOPT_POSTFIELDS, $push_payload);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rest, CURLOPT_HTTPHEADER, array("X-Parse-Application-Id: " . self::$appId,
            "X-Parse-REST-API-Key: " . self::$restKey,
            "Content-Type: application/json"));

        $response = curl_exec($rest);
        
    }
    
    public static function schedulePush($deviceToken, $msg, $date){
        
        $url = 'https://api.parse.com/1/push';

        $push_payload = json_encode(array(
            "where" => array(
                "deviceToken" => $deviceToken,
            ),
            "push_time"=>$date,
            "data" => array(
                "alert" => $msg
            )
        ));

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_PORT, 443);
        curl_setopt($rest, CURLOPT_POST, 1);
        curl_setopt($rest, CURLOPT_POSTFIELDS, $push_payload);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rest, CURLOPT_HTTPHEADER, array("X-Parse-Application-Id: " . self::$appId,
            "X-Parse-REST-API-Key: " . self::$restKey,
            "Content-Type: application/json"));

        $response = curl_exec($rest);
        
    }
    
}
