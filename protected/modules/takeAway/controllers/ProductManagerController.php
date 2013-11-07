<?php

class ProductManagerController extends Controller
{
	public $layout = '/layouts/main';
    public $defaultAction = 'allProducts';

	public function actionAllProducts($productType)
	{	
		
		$productDesc = ProductTypeAR::model()->getProductDesc($productType);
		$productList = ProductsAR::model()->getCategoryProducts($productType, Yii::app()->user->sellerId);
		$this->render('allProducts',array(
			'productType'=>$productType,
			'productList'=>$productList,
			'productDesc'=>$productDesc,
		));

	}
	//ajax:编辑类别和其描述
	public function actionUpdateCategory()
	{
		if(isset($_POST['typeName']) && isset($_POST['changeName']) && isset($_POST['changeDesc'])){

			ProductTypeAR::model()->updateProductType($_POST['typeName'],$_POST['changeName'],$_POST['changeDesc']);
			$pdTypeList = ProductTypeAR::model()->getSellerProductType(Yii::app()->user->sellerId);
			Yii::app()->session[UserIdentity::SESSION_TYPECOUNT] = $pdTypeList;

			$unCategory = ProductsAR::model()->getSpCategoryNum(1);
			Yii::app()->session[UserIdentity::SESSION_UNCATEGORY] = $unCategory;
			
			$starCategory = ProductsAR::model()->getSpCategoryNum(2);
			Yii::app()->session[UserIdentity::SESSION_STARCATEGORY] = $starCategory;	
		}
	}

	public function accessRules(){
        return array(
            array(
                'allow',
                'actions'=>array('allProducts'),
                'users'=>array('?'),
                ),
            array(
                'deny',
                'actions'=>array('login'),
                'users'=>array('@'),
                ),
            );
    }
}