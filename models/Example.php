<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author Pabhoz
 */
class Example extends BModel {

  private $attr1;
  private $attr2;

  private $has_one = array(
      'RuleName'=>array(
          'class'=>'[Obj class expected]',
          'join_as'=>'[foreign key attr]',
          'join_with'=>'[obj primary key attr]'
          )
      );
  
  private $known_as = array(
        
            'Owner' => array(
                'class' => '[Obj class expected]',
                'join_as' => '[my key attr]',
                'join_with' => '[foreign key attr]'
            )
        
        );

  private $has_many = array(
      'RuleName'=>array(
          'class'=>'[Obj class expected]',
          'my_key'=>'[my primary key attr]',
          'other_key'=>'[the other entity primary key attr]',
          'join_as'=>'[my attr at n to n table]',
          'join_with'=>'[the other attr at n to n table]',
          'join_table'=>'[N to N table name]',
          'data'=> array(
             '[table attr]'=>'[variable type demo]' // 'aFloat' => 0.0, 'aString' => '' 
            )
          )
      );

  function __construct($attr1,$attr2) {
        parent::__construct();
        $this->attr1 = $attr1;
        $this->attr2 = $attr2;
  }

  function getAttr1() {
      return $this->attr1;
  }

  function getAttr2() {
      return $this->Attr2;
  }

  function setAttr1($value) {
      $this->attr1 = $value;
  }

  function setAttr2($value) {
      $this->attr2 = $value;
  }

  function getHas_one() {
      return $this->has_one;
  }

  function getHas_many() {
      return $this->has_many;
  }

  function setHas_one($has_one) {
      $this->has_one = $has_one;
  }

  function setHas_many($has_many) {
      $this->has_many = $has_many;
  }

    public function getMyVars(){
        return get_object_vars($this);
    }

}
