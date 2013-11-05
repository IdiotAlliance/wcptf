<?php

class ProductManagerController extends Controller
{
	public $layout = '/layouts/main';
    public $defaultAction = 'allProducts';

	public function actionAllProducts()
	{
		$productType ='未分类';
		$productList = ProductsAR::model()->getCategoryProducts($productType, Yii::app()->user->sellerId);


		$this->render('allProducts',array(
			'productType'=>$productType,
			'productList'=>$productList,
		));
	}
}