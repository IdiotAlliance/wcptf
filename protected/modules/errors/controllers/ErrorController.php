<?php
class ErrorController extends Controller{
	
	public $layout = "/layouts/main";
	public $defaultAction = '404';
	
	public function action404(){
		$this->render('404');
	}
	
}