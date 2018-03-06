<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Views
 *
 * @author PabloAnibal
 */
namespace Fox\Core;

class View {
    
    public function render($controller,$view,$title = ''){
        
        $controller = get_class($controller);
        $controller = substr($controller, 0, -11);
        $path = './views/'.$controller.'/'.$view;
        
        if(file_exists($path.".php")){
            if ($title != "") {
                $this->title = $title;
            }
            require $path.".php";
        }elseif (file_exists($path.".html")) {
            if ($title != "") {
                $this->title = $title;
            }
            require $path.".html";
        }else{
            die("Error: Invalid view ".$view." to render");
        }
    }
    
    public function asyncCreation($form,$url,$obj,$method="POST",$redirect = false){

        echo '<script>
                    $(function(){
                      $("'.$form.'").submit(function(e){
                        e.preventDefault();
                        var inputs = $(this)[0].querySelectorAll("input,select,radio,textarea");
                        //console.log(inputs);
                        var data = {};
                        for (var i = 0; i < inputs.length; i++) {
                          data[inputs[i].name] = inputs[i].value;
                        };
                        delete data[""];
                        delete data["undefined"];
                        //console.log(data);
                        $.ajax({
                          url:"'.URL.$url.'",
                          method:"'.$method.'",
                          data:data
                        }).done(function(r){
                            console.log(r);
                          if(JSON.parse(r)){
                            r = JSON.parse(r);
                            if(r.error == 0){
                              alert("'.$obj.' creado con éxito.");
                              ';
                            if($redirect != false){
                                $this->reloadThis($redirect);
                            }
                            echo '
                            }else{
                              alert("Error en la creación del '.$obj.', intente nuevamente o comuniquese con soporte");
                            }
                          }else{
                              alert("Error desconocido, intente nuevamente o comuniquese con soporte");
                            }
                        });
                      });
                    });
        </script>';

    }

    public function asyncEdition($form,$url,$obj,$method="POST",$redirect = false){

        echo '<script>
                    $(function(){
                      $("'.$form.'").submit(function(e){
                        e.preventDefault();
                        var inputs = $(this)[0].querySelectorAll("input,select,radio,textarea");
                        console.log("inputs");
                        console.log(inputs);
                        var data = {};
                        for (var i = 0; i < inputs.length; i++) {
                          data[inputs[i].name] = inputs[i].value;
                        };
                        console.log(data);
                        delete data[""];
                        delete data["undefined"];
                        
                        $.ajax({
                          url:"'.URL.$url.'",
                          method:"'.$method.'",
                          data:data
                        }).done(function(r){
                        console.log(r);
                          if(JSON.parse(r)){
                            r = JSON.parse(r);
                            if(r.error == 0){
                              alert("'.$obj.' editado con éxito.");
                              ';
                            if($redirect != false){
                                $this->reloadThis($redirect);
                            }
                            echo '
                            }else{
                              alert("Error en la edición del '.$obj.', intente nuevamente o comuniquese con soporte");
                            }
                          }else{
                              alert("Error desconocido, intente nuevamente o comuniquese con soporte");
                          } 
                          
                        });
                      });
                    });
        </script>';

    }
    
    public function reloadThis($uri){
      echo '$.ajax({
                  method:"GET",
                  url: "'.URL.$uri.'"
            }).done(function(response){
                  $("#asyncLoadArea").html(response);
      });';
    }
    
    public function loadModule($module,$params = []) {

        $linkStyles = (isset($params["linkStyles"])) ? $params["linkStyles"] : false;
        $stylesheets = "";
        
        if($linkStyles){
          
          $stylesheets = array_map(function($style){
            return $this->linkStyle($style);
          },$linkStyles);

          $stylesheets = join("\n",$stylesheets);
        }

        if (file_exists(MODULE . $module . '.php')) {
            require MODULE . $module . '.php';
        } else {
            die('Error, not valid Admin module: ' . $module . ' to load');
        }
    }

    public function linkStyle($stylesheet){
      $public = "public/styles/".$stylesheet.".css";
      return '<link rel="stylesheet" href="'.URL.$public.'"/>';
    }
}
