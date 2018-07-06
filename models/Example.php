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
class Example extends \Fox\FoxModel {

  private $attr1;
  private $attr2;

  private $hasOne = array(
      'RuleName'=>array(
          'class'=>'[Obj class expected]',
          'join_as'=>'[my primary key attr name]',
          'join_with'=>'[foreign key name in the other table]'
          )
      );
  
  private $belongsTo = array(
        
            'RuleName' => array(
                'class' => '[Obj class expected]',
                'join_as' => '[primary key name of the foreign key]',
                'join_with' => '[foreign key name in my table]'
            )
        
        );
  
    private $hasMany = array(
        
            'RuleName' => array(
                'class' => '[Obj class expected]',
                'join_as' => '[primary key name of the foreign key]',
                'join_with' => '[foreign key name in my table]'
            )
        
        );

    private $belongsToMany = array(
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

  function getHasOne() {
      return $this->hasOne;
  }

  function getHasMany() {
      return $this->hasMany;
  }

  function setHasOne($hasOne) {
      $this->hasOne = $hasOne;
  }

  function setHasMany($hasMany) {
      $this->hasMany = $hasMany;
  }

    public function getMyVars(){
        return get_object_vars($this);
    }

}
