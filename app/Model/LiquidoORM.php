<?php

namespace Liquido\Model;

use Liquido\Model\DatabaseConnection;
use \PDO;

class LiquidoORM extends DatabaseConnection{

    protected static $table;

    public static function set($class) {
        $path = explode('\\', $class);
        $childClass = strtolower(array_pop($path));
        if(static::$table == ""|| static::$table == null){
            if (substr($childClass, -1) == 's'){
                return $childClass."es"; 
            }
            else{
                return $childClass."s";
            }
        }
        else{
            return static::$table;  
        }
    }

    public function json($data){
        return json_encode($data);
    }

    public static function all($column = "*"){
        $table = self::set(get_called_class());
        $con = parent::$instance;
        $sql = "SELECT $column FROM `".$table."`";
        $query = $con->prepare($sql);
        $query->execute();
        $list = $query->fetchAll(PDO::FETCH_ASSOC);
        if($list){
            return $list;
        }
        else{
            return "Error Processing Request";
        }
        $con = null;
        $table = null;
    }

    public static function withId($id, $column="*"){
        $table = self::set(get_called_class());
        $con = parent::$instance;
        $sql = "SELECT $column FROM `".$table."` WHERE id = :id";
        $query = $con->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        $list = $query->fetch(PDO::FETCH_COLUMN);
        if($list){
            return $list;
        }
        else{
            return "Error Processing Request";
        }
        $con = null;
        $table = null;
    }

    public static function with($argument, $column="*"){
        $table = self::set(get_called_class());
        $con = parent::$instance;
        $where = "";
        $condition = array_keys($argument);
        for($x = 0; $x < count($condition); $x++){
            if(is_array($argument[$condition[$x]])){
                for($y = 0; $y < count($argument[$condition[$x]]); $y++){
                    if($y < count($argument[$condition[$x]])-1){
                        $where .= " (".$condition[$x]." = '".$argument[$condition[$x]][$y]."' OR";
                    }else{
                        $where .= " ".$condition[$x]." = '".$argument[$condition[$x]][$y]."')";
                    }
                }
                continue;
            }
            if($x < count($condition)-2){
                $where .= " ".$condition[$x]." = '".$argument[$condition[$x]]."' ".$argument['condition-type'];
            }else{
                $where .= " ".$condition[$x]." = '".$argument[$condition[$x]]."' ";
            }       
        }
        $sql = "SELECT $column FROM `".$table."` WHERE $where";
        $query = $con->prepare($sql);
        $query->execute();
        $list = $query->fetchAll(PDO::FETCH_COLUMN);
        if($list){
            return $list;
        }
        else{
            return "Error Processing Request";
        }
        $con = null;
        $table = null;
    }

    public static function where($columnCondition, $condition, $value, $column="*"){
        $table = self::set(get_called_class());
        $con = parent::$instance;
        $where = "$columnCondition $condition '$value'";
        $sql = "SELECT $column FROM `".$table."` WHERE $where";
        $query = $con->prepare($sql);
        $query->execute();
        $list = $query->fetch(PDO::FETCH_COLUMN);
        if($list){
            return $list;
        }
        else{
            return "No Results";
        }

        $con = null;
        $table = null;
    }

    public static function add($argument){
        $table = self::set(get_called_class());
        $con = parent::$instance;
        $condition = array_keys($argument);
        $assignTo = "";
        $assignment = "";
        for($x = 0; $x < count($condition); $x++){
            $cond = $condition[$x];
            $assignTo .= ($x < count($condition)-1) ? "$condition[$x]," : "$condition[$x]";
            $assignment .= ($x < count($condition)-1) ? "'$argument[$cond]'," : "'$argument[$cond]'";
        }
        $sql = "INSERT INTO `".$table."`($assignTo) VALUES ($assignment)";  
        $query = $con->prepare($sql);
        $query->execute();
        $last = $con->lastInsertId();
        $query = $con->prepare("SELECT * FROM `".$table."` WHERE id = $last");
        $query->execute();
        $list = $query->fetch(PDO::FETCH_ASSOC);
        if($list){
            return $list;
        }
        else{
            return "No Results";
        }

        $con = null;
        $table = null;
    }

}