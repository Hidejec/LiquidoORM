<?php

namespace Liquido\Model;

use Liquido\Model\DatabaseConnection;
use \PDO;

class LiquidoORM extends DatabaseConnection{

	protected $table;
	private static $con;

	public function __construct() {
		self::$con = parent::$instance;
        $path = explode('\\', get_class($this));
    	$childClass = strtolower(array_pop($path));
    	$this->table = $childClass."s";
    }

    public function all(){
    	$sql = "SELECT * FROM `$this->table`";
		$query = self::$con->prepare($sql);
		$query->execute();
		$list = $query->fetchAll(PDO::FETCH_ASSOC);
		if($list){
			return json_encode($list);
		}
		else{
			return "Error Processing Request";
		}
    }

    public function getTable(){
    	echo $this->table;
    }
}