<?php

/**
 * Description of Model
 *
 * @author pabhoz
 * @coauthors Sebas7103 - CamiloPochi
 */
namespace Fox\Core;

class Model {

    private static $db;
    protected static $table;

    private static function getConnection() {
        if (!isset(self::$db)) {
            self::$db = new Database(_DB_TYPE, _DB_HOST, _DB_NAME, _DB_USER, _DB_PASS);
        }
    }

    public function getRelationship($t) {
        self::getConnection();
        return self::$db->getRelationship($t);
    }

    public static function setTable($table) {
        self::$table = $table;
    }

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

    public static function where($field, $value) {
        self::setTableForStaticCall();
        self::getConnection();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . $field . " = :" . $field;
        //print_r($sql);
        $results = self::$db->select($sql, array(":" . $field => $value));
        return $results;
    }

    public static function advancedWhere($condition, $values) {
        self::setTableForStaticCall();
        self::getConnection();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . $condition;
        $results = self::$db->select($sql, $values);
        return $results;
    }

    public static function whereR($attr, $field, $value, $tableR) {
        self::setTableForStaticCall();
        self::getConnection();
        $sql = "SELECT " . $attr . " FROM " . $tableR . " WHERE " . $field . " = :" . $field;
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

    public function create($noId = false) {
        self::getConnection();

        $values = $this->getMyVars($this);
        $has_many = self::checkRelationship("has_many", $values);
        self::checkRelationship("has_one", $values);
        self::checkRelationship("known_as", $values);

        $result = self::$db->insert(static::$table, $values);

        if ($result === true) {
            $response = array('error' => 0, 'getID' => self::$db->lastInsertId(), 'msg' => get_class($this) . ' Created');
            if (!$noId) {
                $this->setId($response["getID"]);
            }
        } else {
            $response = array('error' => 1, 'msg' => 'Error ' . $result);
        }
        if ($has_many) {
            $rStatus = self::saveRelationships($has_many);
            if ($rStatus["error"]) {
                //Logger::alert("Error saving relationships",$rStatus["trace"],"create");
            }
        }

        return $response;
    }

    public function update($where = false) {

        self::getConnection();

        $values = $this->getMyVars($this);
        $has_many = self::checkRelationship("has_many", $values);
        //Logger::debug("Has_many",$has_many,$dump = false,$method = false);
        self::checkRelationship("has_one", $values);
        self::checkRelationship("known_as", $values);


        if ($where) {
            $result = self::$db->update(static::$table, $values, $where);
        } else {
            $result = self::$db->update(static::$table, $values, "id = " . $values["id"]);
        }

        if ($result) {
            $response = array('error' => 0, 'msg' => get_class($this) . ' Updated');
        } else {
            $response = array('error' => 1, 'msg' => 'Error ' . $result);
        }
        if ($has_many) {
            $rStatus = self::saveRelationships($has_many);
            if ($rStatus["error"]) {
                Logger::alert("Error saving relationships", $rStatus["trace"], "save");
            }
        }
        //Logger::debug("result",$result,"save");
        return $response;
    }

    public function saveRelationships($relationships) {
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

    public function has_many($rName, $obj, $data = array()) {
        $has_many = $this->getHas_many();
        if ($has_many[$rName] != null) {
            $rule = $has_many[$rName];
            $rule['my_key'] = ucfirst($rule['my_key']);
            $rule['other_key'] = ucfirst($rule['other_key']);
            if (get_class($obj) == $rule["class"]) {
                if ($this->{"get" . $rule['my_key']}() != null && $obj->{"get" . $rule['other_key']}() != null) {

                    //Logger::debug("rule",$rule);

                    $toSave = array(
                        $rule['join_as'] => $this->{"get" . $rule['my_key']}(),
                        $rule['join_with'] => $obj->{"get" . $rule['other_key']}()
                    );

                    if (isset($data)) {
                        $this->processHMRData($data, $toSave);
                    }

                    $rule['relationships'][] = $toSave;
                    $has_many[$rName] = $rule;
                    $this->setHas_many($has_many);
                } else {
                    print("Se requieren llaves primarias para la relación");
                }
            } else {
                print("No se cumple con el tipo de objeto");
            }
        } else {
            print("No existe este tipo de relación");
        }
    }

    private function processHMRData($data, &$toSave) {

        foreach ($data as $key => $atributo) {
            $toSave[$key] = $atributo;
        }
    }

    public function has_one($rName, $obj) {
        $has_one = $this->getHas_one();
        if (isset($has_one[$rName])) {

            $rule = $has_one[$rName];
            if (get_class($obj) == $rule["class"]) {
                $this->{"set" . $rule["join_as"]}($obj->{"get" . $rule["join_with"]}());
            } else {
                print("No se cumple con el tipo de objeto");
            }
        } else {
            print("No existe este tipo de relación");
        }
    }

    public function known_as($rName, $obj, $update = true) {
        $relacion = $this->getKnown_as();
        if (isset($relacion[$rName])) {

            $rule = $relacion[$rName];
            if (get_class($obj) == $rule["class"]) {

                print_r("set" . ucfirst($rule["join_with"]));
                $obj->{"set" . ucfirst($rule["join_with"])}($this->{"get" . ucfirst($rule["join_as"])}());
                $obj->update();
            } else {
                print("No se cumple con el tipo de objeto");
            }
        } else {
            print("No existe este tipo de relación");
        }
    }

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

                    switch (get_class($this)) {
                        case "Cancha":

                            $result = array('error' => 1, 'message' => "La cancha tiene res"
                                . "ervas asignadas. Elimine las reservas para poder elimina"
                                . "r la cancha.");

                            break;
                        case "Sitio":

                            $result = array('error' => 1, 'message' => "El sitio que intenta eliminar "
                                . "está asignado a una cuenta. Elimine la cuenta o asignele otro sitio para"
                                . " realizar ésta acción.");

                            break;
                        default:
                            $result = array('error' => 1, 'message' => "Error, violación de indices foraneos.");
                            break;
                    }
                }
            } else {
                $result = array('error' => 1, 'message' => $result);
            }
        }
        return $result;
    }

    public static function setTableForStaticCall($table = false) {
        if (!$table) {
            static::$table = get_called_class();
        } else {
            static::$table = $table;
        }
    }

    public static function getById($id) {
        self::setTableForStaticCall();
        $self = self::where("id", $id);
        $data = array_shift($self);
        //print_r($data);
        $result = self::instanciate($data);
        return $result;
    }

    public static function getBy($field, $data) {
        self::setTableForStaticCall();
        $data = array_shift(self::where($field, $data));
        $result = self::instanciate($data);
        return $result;
    }

    public function getAttrTable($table) {
        self::getConnection();
        $attr = self::$db->getAttr($table);
        return $attr;
    }

    public function toArray() {
        //Get reflection
        $reflection = new ReflectionObject($this);
        //Get Public properties to avoid getter methods
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        $arr = [];
        $isPublic = null;
        foreach ($this->getMyVars() as $key => $value) {
            if ($key != "has_one" && $key != "has_many" && $key != "known_as") {

                foreach ($properties as $property) {
                    $isPublic = ($property->name == $key) ? true : false;
                    break;
                }
                if (is_object($value)) {
                    $arr[$key] = $value->toArray();
                } else {
                    if (!$isPublic) {
                        $arr[$key] = $this->{"get" . $key}();
                    } else {
                        $arr[$key] = $value;
                    }
                }
            }
        }
        return $arr;
    }

    public static function instanciate($args) {

        if(is_array($args)){
            if (count($args) > 1) {
                $refMethod = new ReflectionMethod(get_called_class(), '__construct');
                $params = $refMethod->getParameters();
                $re_args = array();
                foreach ($params as $key => $param) {
                    if ($param->isPassedByReference()) {
                        $re_args[$param->getName()] = &$args[$param->getName()];
                    } else {
                        $re_args[$param->getName()] = $args[$param->getName()];
                    }
                }

                $refClass = new ReflectionClass(get_called_class());
                return $refClass->newInstanceArgs((array) $re_args);
            }
        }
    }

    public static function getKeys() {
        $refMethod = new ReflectionMethod(get_called_class(), '__construct');
        $params = $refMethod->getParameters();
        $keys = [];
        foreach ($params as $key => $param) {
            $keys[$key] = $param->getName();
        }
        return $keys;
    }

    public function objetize($arr) {
        $results = [];
        foreach ($arr as $key => $obj) {
            $results[$key] = $this->instanciate($obj);
        }
        return $results;
    }

    public static function getManyToMany($join_table,  $class ,$join_as, $id, 
            $join_with, $other_key) {
        self::getConnection();
        $query = "SELECT U.* FROM " . $join_table . " P INNER JOIN " . $class . 
                " U ON P." . $join_as . " = " . $id . " AND  P." . $join_with . 
                " = U." . $other_key;

        $table = self::$db->select($query);
        return $table;
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

}
