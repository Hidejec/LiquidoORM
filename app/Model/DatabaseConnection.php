<?php

namespace Liquido\Model;
use \PDO;

class DatabaseConnection{

	public static $instance;
	public function __construct( $db_dsn, $db_username, $db_password ){
		$instance = new PDO( $db_dsn, $db_username, $db_password );
		self::$instance = $instance;
	}
}