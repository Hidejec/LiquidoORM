<?php

namespace Liquido;
use Liquido\Model as Model;

require_once 'dbconfig.liquido.php';

class App{

	public function __construct(){
		new Model\DatabaseConnection( DB_DSN, DB_USERNAME, DB_PASSWORD );
	}
	public static function index(){
        return 'Hello World, Composer!';
    }
    public static function add($num1, $num2){
    }
}