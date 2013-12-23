<?php

class ReplyRulesController extends Controller
{
	public $layout = '/layouts/main';
    public $defaultAction = 'allRules';

    public function actionAllRules(){
    	Yii::app()->user
    	$this->render('allRules');
    }
}