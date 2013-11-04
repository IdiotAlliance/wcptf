<?php

class ProductManagerController extends Controller
{
	public $layout = '/layouts/main';
    public $defaultAction = 'allProducts';

	public function actionAllProducts()
	{
		$this->render('allProducts');
	}
}