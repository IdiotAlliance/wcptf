<?php

class OrderFlowController extends Controller
{
	public $layout = '/layouts/main';
    public $defaultAction = 'orderFlow';

	public function actionOrderFlow()
	{
		$this->render('orderFlow');
	}
	/*
		ajax未派送订单
	*/
	public function actionNotSend(){
		echo $this->renderPartial('_orderList', null, true, false);
	}
	/*
		ajax获取已派送订单
	*/
	public function actionSended(){
		echo $this->renderPartial('_orderList1', null, true, false);
	}
	
	/*
		ajax获取订单子项
	*/
	public function actionGetOrderItems(){
		echo $this->renderPartial('_orderItems', null, true, false);
	}


	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}