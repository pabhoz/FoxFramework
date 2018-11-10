<?php

/**
 * Description of Model
 *
 * @author pabhoz
 *  
 */
namespace Fox\Core;

class Model {

    private static $db;
    protected static $table;
    private static $simpleRelations = ["hasOne","hasMany","belongsTo"];
    
    /******************************************+*******************************
     ** STATIC CONFIGURATIONS
     *************************************************************************/
    
    private static function getConnection() {
        if (!isset(self::$db)) {
            self::$db = new Database(_DB_TYPE, _DB_HOST, _DB_NAME, _DB_USER, _DB_PASS);
        }
    }

    public static function setTable($table) {
        self::$table = $table;
    }
    
    public static function setTableForStaticCall($table = false) {
        if (!$table) {
            static::$table = get_called_class();
        } else {
            static::$table = $table;
        }
    }
    
    /******************************************+*******************************
     ** OBJECT SELECTION AND SEARCH
     *************************************************************************/
    
    public static function search($table, $what, $where, $data = array(), $limit = null) {
        self::setTableForStaticCall($table);
        self::getConnection();
        if (is_null($limit)) {
            $limit = "";
        } else {
            $limit = "LIMIT " . $limit;
        }
        $sql = "SELECT $what FROM " . static::$table . " WHERE " . $where . " " . $limit;
        //print_r($sql);
        return $results = self::$db->select($sql, $data);
    }

    public static function searchForOrder($table, $what, $order, $limit = null) {
        self::setTableForStaticCall($table);
        self::getConnection();
        if (is_null($limit)) {
            $limit = "";
        } else {
            $limit = "LIMIT " . $limit;
        }
        $sql = "SELECT $what FROM " . static::$table . " " . $order . " " . $limit;
        //print_r($sql);
        return $results = self::$db->select($sql);
    }

    public static function searchFor($attr, $val, $limit = null) {
        self::setTableForStaticCall();
        self::getConnection();
        if (is_null($limit)) {
            $limit = "";
        } else {
            $limit = "LIMIT " . $limit;
        }
        $sql = "SELECT * FROM " . static::$table . " WHERE " . $attr . " LIKE '%" . $val . "%' " . $limit;
        return $results = self::$db->select($sql);
    }

    public static function getAll($order = false) {
        self::setTableForStaticCall();
        self::getConnection();
        if (!$order) {
            $sql = "SELECT * FROM " . static::$table . ";";
        } else {
            $sql = "SELECT * FROM " . static::$table . " ORDER BY " . $order . " DESC;";
        }
        //print_r($sql);
        return $results = self::$db->select($sql);
    }

    public static function where($field, $value, $objects = true) {
        self::setTableForStaticCall();
        self::getConnection();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . $field . " = :" . $field;
        //print_r($sql);
        $results = self::$db->select($sql, array(":" . $field => $value));
        if($objects && !empty($results)){
            $results = self::toObject($results);
        }
        return $results;
    }

    public static function whereR($attr, $field, $value, $tableR) {
        self::setTableForStaticCall($tableR);
        self::getConnection();
        $sql = "SELECT " . $attr . " FROM " . static::$table . " WHERE " . $field . " = :" . $field;
        //print_r($sql);
        $results = self::$db->select($sql, array(":" . $field => $value));

        return $results;
    }

    public static function whereN($attr, $field, $tableR) {
        self::setTableForStaticCall();
        self::getConnection();
        $sql = "SELECT " . $attr . " FROM " . $tableR . " WHERE " . $field . " IS NULL";
        $results = self::$db->select($sql);

        return $results;
    }
    
    public static function advancedWhere($condition, $values) {
        self::setTableForStaticCall();
        self::getConnection();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . $condition;
        $results = self::$db->select($sql, $values);
        return $results;
    }
    
    public static function getOrderedBy($field, $value, $by,$order="DESC") {
        self::setTableForStaticCall();
        self::getConnection();
        $sql = "SELECT * FROM " . static::$table . " WHERE $field=:$field ORDER BY `$by` $order";
        $results = self::$db->select($sql,[$field=>$value]);

        return $results;
    }
    
    public static function getIn($field,$range) {
        self::setTableForStaticCall();
        self::getConnection();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . $field . " IN(".$range.")";
        $results = self::$db->select($sql);

        return $results;
    }
    
    public static function getById($id,$objects = true) {
        self::setTableForStaticCall();
        $self = self::where("id", $id, $objects);
        $result = array_shift($self);
        return $result;
    }

    public static function getBy($field, $data) {
        self::setTableForStaticCall();
        $smth = self::where($field, $data);
        $result = array_shift($smth);
        return $result;
    }

    public function getAttrTable($table) {
        self::getConnection();
        $attr = self::$db->getAttr($table);
        return $attr;
    }

     /******************************************+*******************************
     ** OBJECT INSERTION & UPDATE
     *************************************************************************/
    
    public function create($noId = false) {
        self::getConnection();

        $values = $this->getMyVars($this);
        unset($values["_table"]);
        
        $belongsToMany = self::checkRelationship("belongsToMany", $values);
        
        foreach (self::$simpleRelations as $relation) {
            self::checkRelationship($relation, $values);
        }
        
        $result = self::$db->insert($this->getTable(), $values);

        if ($result === true) {
            $response = array('error' => 0, 'getID' => self::$db->lastInsertId(), 'msg' => get_class($this) . ' Created');
            if (!$noId) {
                $this->setId($response["getID"]);
            }
        } else {
            $response = array('error' => 1, 'msg' => 'Error ' . $result);
        }
        if ($belongsToMany) {
            $rStatus = self::saveRelationships($belongsToMany);
            if ($rStatus["error"]) {
                //Logger::alert("Error saving relationships",$rStatus["trace"],"create");
            }
        }

        return $response;
    }

    public function update($where = false) {

        self::getConnection();

        $values = $this->getMyVars($this);
        unset($values["_table"]);
        
        $belongsToMany = self::checkRelationship("belongsToMany", $values);
        //Logger::debug("Has_many",$belongsToMany,$dump = false,$method = false);
        self::checkRelationship("hasOne", $values);
        self::checkRelationship("belongsTo", $values);


        if ($where) {
            $result = self::$db->update($this->getTable(), $values, $where);
        } else {
            $result = self::$db->update($this->getTable(), $values, "id = " . $values["id"]);
        }

        if ($result) {
            $response = array('error' => 0, 'msg' => get_class($this) . ' Updated');
        } else {
            $response = array('error' => 1, 'msg' => 'Error ' . $result);
        }
        if ($belongsToMany) {
            $rStatus = self::saveRelationships($belongsToMany);
            if ($rStatus["error"]) {
                Logger::alert("Error saving relationships", $rStatus["trace"], "save");
            }
        }
        //Logger::debug("result",$result,"save");
        return $response;
    }

    /******************************************+*******************************
    ** OBJECT RELATIONS
    *************************************************************************/
    
    private function saveRelationships($relationships) {
        $log = array("error" => 0, "trace" => array());
        foreach ($relationships as $name => $rules) {
            if (isset($rules['relationships'])) {
                foreach ($rules['relationships'] as $key => $relacion) {
                    $table = $rules["join_table"];
                    $result = self::$db->insert($table, $relacion);
                    //TODO Check result
                }
            }
        }
        return $log;
    }
    
    private static function processHMRData($data, &$toSave) {

        foreach ($data as $key => $atributo) {
            $toSave[$key] = $atributo;
        }
    }
    
    //Many To Many relationships
    public function belongsToMany($rName, $obj, $data = array()) {
        $belongsToMany = $this->getBelongsToMany();
        if ($belongsToMany[$rName] != null) {
            $rule = $belongsToMany[$rName];
            $rule['my_key'] = ucfirst($rule['my_key']);
            $rule['other_key'] = ucfirst($rule['other_key']);
            if (get_class($obj) == $rule["class"]) {
                if ($this->{"get" . $rule['my_key']}() != null && $obj->{"get" .
                        $rule['other_key']}() != null) {
                    //Logger::debug("rule",$rule);
                    $toSave = array(
                        $rule['join_as'] => $this->{"get" . $rule['my_key']}(),
                        $rule['join_with'] => $obj->{"get" . $rule['other_key']}()
                    );

                    if (isset($data)) {
                        self::processHMRData($data, $toSave);
                    }

                    $rule['relationships'][] = $toSave;
                    $belongsToMany[$rName] = $rule;
                    $this->setBelongsToMany($belongsToMany);
                } else {
                    print("Primary keys must be defined.");
                }
            } else {
                print("Object of type ".get_class($obj)." doesn't match ".$rule["class"].".");
            }
        } else {
            print("Relation of type $rName doesn't exists.");
        }
    }
    public function basicRelation($relation,$rName, $obj,$relacion) {
        if (isset($relacion[$rName])) {
            $rule = $relacion[$rName];
            if (get_class($obj) == $rule["class"]) {
                switch ($relation) { 
                    case "hasOne": //print"hasOne";
                        $obj->{"set" . ucfirst($rule["join_with"])}($this->{"get" . 
                            ucfirst($rule["join_as"])}());
                        break;
                    case "hasMany": //print"hasMany";
                        $obj->{"set" . ucfirst($rule["join_with"])}($this->{"get" . 
                            ucfirst($rule["join_as"])}());
                        break;
                    case "belongsTo": //print"belongsTo";
                        $this->{"set" . ucfirst($rule["join_with"])}($obj->{"get" . 
                            ucfirst($rule["join_as"])}());
                        break;
                }
                //$obj->update();
            } else {
                print("Object of type ".get_class($obj)." doesn't match ".$rule["class"].".");
            }
        } else {
            print("No existe este tipo de relación");
        }
    }
    //One To One
    public function hasOne($rName, $obj) {
        $relacion = $this->getHasOne();
        $this->basicRelation("hasOne",$rName, $obj, $relacion);
    }
    //One To Many
    public function hasMany($rName, $obj){
        $relacion = $this->getHasMany();
        $this->basicRelation("hasMany",$rName, $obj, $relacion);
    }
    //Inverse Of A One to one
    public function belongsTo($rName, $obj) {
        $relacion = $this->getBelongsTo();
        $this->basicRelation("belongsTo",$rName, $obj, $relacion);
    }
    //Set an object attribute
    public function set($attr, $value) {
        $this->{$attr} = $value;
    }

    public function checkRelationship($rType, &$data) {
        if (isset($data[$rType])) {
            $relationship = $data[$rType];
            unset($data[$rType]);
            return $relationship;
        } else {
            return false;
        }
    }
    
    /** statics **/
            
    public static function getManyToMany($join_table,  $class ,$join_as, $id, 
            $join_with, $other_key) {
        self::getConnection();
        $query = "SELECT U.* FROM " . $join_table . " P INNER JOIN " . $class . 
                " U ON P." . $join_as . " = " . $id . " AND  P." . $join_with . 
                " = U." . $other_key;

        $table = self::$db->select($query);
        return $table;
    }
    
    /******************************************+*******************************
    ** OBJECT RELATIONS QUERYING
    *************************************************************************/
    
    public function has($rType,$rName){
        $rule = null;
        $has = true;
        
        switch ($rType) {
            case "one":
                $rule = $this->getHasOne();
                break;
            case "many":
                $rule = $this->getHasMany();
                break;
            case "from":
                $rule = $this->getBelongsTo();
                $has = false;
                break;
        }
        
        if(isset($rule[$rName])){
            if($has){
                $class = $rule[$rName]["class"];
                $r = $class::where($rule[$rName]["join_with"],
                $this->{"get".ucfirst($rule[$rName]["join_as"])}());
            }else{
                $class = $rule[$rName]["class"];
                $r = $class::where($rule[$rName]["join_as"],
                $this->{"get".ucfirst($rule[$rName]["join_with"])}());
            }
        }else{
            $r = null;
        }
        return $r;
    }
    
    public function belongsTM($rName){
        
        $rule = $this->getBelongsToMany()[$rName];
        $r = self::whereR("*", $rule['join_as'], 
                $this->{"get". ucfirst($rule["my_key"])}(), 
                $rule["join_table"]);
        return $r;
    }
    
    /******************************************+*******************************
    ** OBJECT POPULATION
    *************************************************************************/
    
    public function populate($rType,$rName,$array = false){

        if($rType == "belongsToMany"){
            $objs = $this->belongsTM($rName);
        }else{
            $objs = $this->has($rType, $rName);
        }
        if($array){
            foreach ($objs as $key => $obj) {
                $objs[$key] = $obj->toArray();
            }
        }
        //TODO: if class has $obj as attr, assign it to it (setAttr) isntead of
        //using arrays;
        $this->{lcfirst($rName)} = $objs;
        
    }
    
    public function populateAll($array=false){
        
        //populate all has one rules
        if(method_exists($this,"getHasOne")){
            foreach ($this->getHasOne() as $key => $rule) {
               $this->populate("one",$key,$array);
            }
        }
        
        //populate all belongs to rules
        if(method_exists($this,"getBelongsTo")){
            foreach ($this->getBelongsTo() as $key => $rule) {
               $this->populate("from",$key,$array);
            }
        }
        
        //populate all has many rules
        if(method_exists($this,"getHasMany")){
            foreach ($this->getHasMany() as $key => $rule) {
               $this->populate("many",$key,$array);
            }
        }
        
        //populate all m to n rules
        if(method_exists($this,"getBelongsToMany")){
            foreach ($this->getBelongsToMany() as $key => $rule) {
               $this->populate("belongsToMany",$key,$array);
            }
        }
    }
    
     /******************************************+*******************************
     ** OBJECT DELETION
     *************************************************************************/

    public function delete($where = false) {
        self::getConnection();
        if ($where) {
            $result = self::$db->delete(static::$table, $where);
        } else {
            $result = self::$db->delete(static::$table, "id = " . $this->getId());
        }

        if ($result === true || $result === 1) {
            $result = array('error' => 0, 'message' => 'Objeto Eliminado');
        } else {
            if (isset($result->errorInfo)) {
                if ($result->errorInfo[0] == "23000") {
                    
                    $result = array('error' => 1, 'message' => get_class($this).
                        " can't be deleted because is used as reference"
                        . " in a foreign key.");
                }
            } else {
                $result = array('error' => 1, 'message' => $result);
            }
        }
        return $result;
    }
    
    public static function deleteHasMany($join_table ,$join_as, $id) {
        self::getConnection();
        
        $result = self::$db->delete($join_table, $join_as." = ".$id);
        
        if ($result) {
            $response = array('error' => 0, 'msg' => 'Delete');
        } else {
            $response = array('error' => 1, 'msg' => 'Error ' . $result);
        }
        
        return $response;
    }
    
    /******************************************+*******************************
    ** OBJECT UTILITIES, TRANSFORMATIONS ADN MORE
    *************************************************************************/
    
    public function toArray() {
        //Get reflection
        $reflection = new \ReflectionObject($this);
        //Get Public properties to avoid getter methods
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $arr = [];
        $isPublic = null;
        foreach ($this->getMyVars() as $key => $value) {
            if ($key != "hasOne" && $key != "belongsToMany" && $key != "belongsTo") {
                foreach ($properties as $property) {
                    $isPublic = ($property->name == $key) ? true : false;
                    break;
                }
                if (is_object($value)) {
                    $arr[$key] = $value->toArray();
                } else {
                    if (!$isPublic) {
                        if($key != "_table"){
                           $arr[$key] = $this->{"get" . $key}(); 
                        }else{
                           $arr[$key] = $this->getTable();
                        }
                    } else {
                        $arr[$key] = $value;
                    }
                }
            }
        }
        return $arr;
    }

    public static function getKeys() {
        $refMethod = new \ReflectionMethod(get_called_class(), '__construct');
        $params = $refMethod->getParameters();
        $keys = [];
        foreach ($params as $key => $param) {
            $keys[$key] = $param->getName();
        }
        return $keys;
    }
    
    public static function instanciate($args) {

        if(is_array($args)){
            if (count($args) > 1) {
                $refMethod = new \ReflectionMethod(get_called_class(), '__construct');
                $params = $refMethod->getParameters();
                $re_args = array();
                foreach ($params as $key => $param) {
                    if ($param->isPassedByReference()) {
                        $re_args[$param->getName()] = &$args[$param->getName()];
                    } else {
                        $re_args[$param->getName()] = $args[$param->getName()];
                    }
                }

                $refClass = new \ReflectionClass(get_called_class());
                return $refClass->newInstanceArgs((array) $re_args);
            }
        }
    }
    
    public static function toObject($arr) {
        $results = [];
        foreach ($arr as $key => $obj) {
            $results[$key] = self::instanciate($obj);
        }
        return $results;
    }

}
