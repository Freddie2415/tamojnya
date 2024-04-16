<?php
namespace app\controllers;

class BaseController extends \yii\rest\ActiveController{
	public $modelClass = ''; // no single table dependent
    
	public function init(){
        parent::init();
    }

	public function actions() {
	}
	
	protected function verbs() {
	   $verbs = parent::verbs();
	    $verbs =  [
			'index' => ['GET', 'POST', 'HEAD'],
			'view' => ['GET', 'HEAD'],
			'create' => ['POST'],
			'update' => ['PUT', 'PATCH'],
			'anyOtherAction' => ['DELETE'],
		];
	   return $verbs;
	}
}
?>