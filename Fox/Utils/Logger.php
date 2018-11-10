<?php

namespace Fox\Utils;

Class Logger{

	public static function debug($name,$var,$dump = false,$method = false){
		$bt = debug_backtrace();
		$caller = array_shift($bt);
		$m = '';

		if($method) $m = "function: ".$method."()";

		print('</br><b>Logger::Debug</b> at File: <b>'.
				end(explode('\\',$caller['file'])).'</b> at line <b>'.
				$caller['line'].'</b> '.$m.'</br></br> <span style="margin-left:15px;">$'.$name.':</span>');
		if($dump) var_dump($var); else print_r($var);
		print('</br></br><b>End of debug</b></br></br>');	
	}
        
	public static function dd($var,$die = false){
	
		echo "<pre>";
        print_r($var);
        echo "</pre>";
		if($die){ die(); }
		
    }

	public static function msg($msg,$method = false){
		$bt = debug_backtrace();
		$caller = array_shift($bt);
		$m = '';

		if($method) $m = "function: ".$method."()";

		print('</br><b>Logger::msg</b> at File: <b>'.
			end(explode('\\',$caller['file'])).'</b> at line <b>'.
			$caller['line'].'</b> '.$m.': "'.$msg.'"</br></br>');
	}

	public static function alert($msg,$var,$method = false){
		$bt = debug_backtrace();
		$caller = array_shift($bt);
		$m = '';

		if($method) $m = "function: ".$method."()";

		print('</br><b>Logger::Alert</b> at File: <b>'.
				end(explode('\\',$caller['file'])).'</b> at line <b>'.
				$caller['line'].'</b> '.$m.'</br></br> <span style="margin-left:15px; color:rgb(217,30,24);">'.$msg.': </span>');
		print_r($var);
		print('</br></br><b>End of debug</b></br></br>');	
	}

}