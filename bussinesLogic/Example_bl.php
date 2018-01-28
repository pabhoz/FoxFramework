<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Example_bl
 *
 * @author Pabhoz
 */
class Example_bl {

  public function myBussinesLogic(){
      $result = "Some hardcore logic here";
      return $result;
  }
  
  public function testSave(){
      $usr = User::getById(2);
      $rchildren = RustyChildren::getBy("code","A1B2C3");
      $rusty = Rusty::getById($rchildren->getParent());
      
      $rchildren->has_many("Savers",$usr,array("when"=>null));
      $rchildren->update();
  }
  
  public function testRedeemption(){
      $usr = User::getById(2);
      $rchildren = RustyChildren::getBy("code","A1B2C3");
      $rusty = Rusty::getById($rchildren->getParent());
      $realPrice = $rusty->getRealPrice();
      $priceAtRedeemtion = $realPrice - ($realPrice * ($rusty->getDiscount() / 100));
      $usr->has_many("RedeemedRusties",$rusty,array(
              'rustyChildrenCode'=>$rchildren->getCode(),
              'when'=>null,
              'priceAtRedeemption'=> $priceAtRedeemtion
            ));
      $usr->update();
      //TODO if updated, delete the rustyChildren
  }

}
