<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author PabloAnibal
 */
class Session {
    
    public static function init(){
        
        if(session_id() == ''){
            session_start();
        }
     
    }
    
    public static function set($key,$value){
        
        $_SESSION[$key] = $value;
        
    }
    
    public static function get($key){
        
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return false;
        }
        
    }
    
    public static function remove($key){
        
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
        
    }
    
    public static function destroy(){
        session_destroy();
        unset($_SESSION);
    }
    
}
