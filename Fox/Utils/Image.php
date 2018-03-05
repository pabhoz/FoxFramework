<?php

/**
 * Description of Image
 *
 * @author Pabhoz
 */

class Image {
    
    public static function upload($carpeta,$file,$nombreImg = false,$sizeLimit = false, $checkFormat = false){
        
        $target_dir = $carpeta; //carpeta del servidor donde guardamos las imagenes
        $extension = explode(".",basename($file["name"]));
        $extension = $extension[count($extension)-1];
        $target_file = ($nombreImg) ? $target_dir.$nombreImg.".".$extension : $target_dir . basename($file["name"]); //ubicamos el fantasma
        $target = ($nombreImg) ? $nombreImg.".".$extension : basename($file["name"]);
        //echo 'target file:'.$target_file;
        $uploadOk = 1; //estado de la subida
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); //extraemos el tipo de fantasma
// pillamos si el fantasma es de verdad una imagen

        $check = getimagesize($file["tmp_name"]); //verificamos que sea imagen
        if ($check == false) {
            $uploadOk = 0;
        }
// Check file size
        if($sizeLimit>0){
            if ($file["size"] > $sizeLimit) {
                $uploadOk = 0;
            }
        }
// Allow certain file formats
        if($checkFormat){
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
//si el fantasma no fue imagen o si el peso es excesivo o si no cumple con el formato, entonces no lo atrape, pero si cumple todos los filtros, atrapelo
            if (move_uploaded_file($file["tmp_name"], $target_file)) {//si se completa la atrapada del fantasma (ubicandolo en la direcciòn deseada)
                //return $target_file;
                return $target;
            } else {
                return false;
            }
        }
        
    }
    
}
