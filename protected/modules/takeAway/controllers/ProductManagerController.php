<?php

class ProductManagerController extends Controller
{
	public $layout = '/layouts/main';
    public $defaultAction = 'allProducts';

	public function actionAllProducts($productType)
	{	
		$productList = ProductsAR::model()->getCategoryProducts($productType,Yii::app()->user->sellerId);
		$prodList = ProductsAR::model()->getAllProducts($productList);
		$productInfo = null;
		if($productList != null){
			$productInfo = $productList[0];
			$productDesc = $productList[0]->type->type_description;
		}else{
			$productDesc = ProductTypeAR::model()->getProductDesc($productType);
		}
		$this->render('allProducts',array(
			'productType'=>$productType,
			'prodList'=>$prodList,
			'productDesc'=>$productDesc,
			'productInfo'=>$productInfo,
		));

	}
	//ajax:编辑类别和其描述
	public function actionUpdateCategory()
	{
		if(isset($_POST['typeName']) && isset($_POST['changeName']) && isset($_POST['changeDesc'])){

			ProductTypeAR::model()->updateProductType($_POST['typeName'],$_POST['changeName'],$_POST['changeDesc']);
			$this->updateSession();
		}
	}

	public function actionGetProduct()
	{
		if(isset($_POST['pname'])){
			$product = ProductsAR::model()->getProduct($_POST['pname']);
			$prodArray = ProductsAR::model()->getProductArray($product);
			echo json_encode($prodArray);
		}
	}

	public function actionUpdateProduct()
	{
		if(isset($_POST['id'])){
			$product = ProductsAR::model()->findByPK($_POST['id']);
			$product->pname = $_POST['pname'];
			$product->price = $_POST['price'];
			$product->credit = $_POST['credit'];
			$product->description = $_POST['description'];
			$product->stime = $_POST['stime'];
			$product->etime = $_POST['etime'];
			$product->instore = $_POST['instore'];
			$product->richtext = $_POST['richtext'];
			$newTypeId = 1;
			if($_POST['productType']=='未分类')
				$newTypeId = 1;
			else if($_POST['productType']=='星标类')
				$newTypeId = 2;
			else{
				$pdType	= ProductTypeAR::model()->getProductType($_POST['productType']);
				$newTypeId = $pdType->id;
			}


			//商品类别未发生修改
			if($newTypeId == $product->type_id){
				$product->update();
			}else{
				if($newTypeId != 1 &&  $newTypeId!=2){
					$oldPdType = ProductTypeAR::model()->findByPK($product->type_id);
					$oldPdType->product_num = $oldPdType->product_num-1;
					$pdType->product_num = $pdType->product_num+1;
					$oldPdType->update();
					$pdType->update();
				}			
				$product->type_id = $newTypeId;
				$product->update();
				$this->updateSession();
			}
		}

	}

	public function actionCoverUp($productId)
	{	
		$pictureId = UpPicture::uploadPicture("upload/cover/","cover");
        //存储到数据库中

        $product = ProductsAR::model()->findByPK($productId);
        $product->cover = $pictureId;
        $product->update();
	}

	private function updateSession()
	{
		$pdTypeList = ProductTypeAR::model()->getSellerProductType(Yii::app()->user->sellerId);
		Yii::app()->session[UserIdentity::SESSION_TYPECOUNT] = $pdTypeList;

		$unCategory = ProductsAR::model()->getSpCategoryNum(1);
		Yii::app()->session[UserIdentity::SESSION_UNCATEGORY] = $unCategory;
		
		$starCategory = ProductsAR::model()->getSpCategoryNum(2);
		Yii::app()->session[UserIdentity::SESSION_STARCATEGORY] = $starCategory;
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