<?php

namespace Liquido;
use Liquido\Model as Model;

class App{
	public static function index(){
        return 'Hello World, Composer!';
    }
    public static function add($num1, $num2){
    	$model = new Model\BaseModel;
    	$output = $model->add($num1, $num2);
    	return $output;
    }
}