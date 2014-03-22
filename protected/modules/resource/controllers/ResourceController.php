<?php

class ResourceController extends Controller{

	public $layout = '/layouts/main';
	public $defaultAction = "js";

	public function actionJs($name){
		$this->render($name);
	}

}