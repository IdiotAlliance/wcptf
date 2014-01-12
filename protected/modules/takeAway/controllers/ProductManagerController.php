<?php
include 'TakeAwayController.php';

class ProductManagerController extends TakeAwayController
{
	public $layout = '/layouts/main';
    public $defaultAction = 'allProducts';

	public function actionAllProducts($typeId,$prodId)
	{	
		if($typeId==0){
			$typeId = Yii::app()->session['typeCount'][0]['typeId'];
		}

		$productList = ProductsAR::model()->getCategoryProducts($typeId,Yii::app()->user->sellerId);
		$prodList = ProductsAR::model()->getAllProducts($productList);
		$productInfo = null;
		if($productList != null && $prodId==0){
			$productInfo = $productList[0];
		}
		if($prodId!=0){
			$productInfo = ProductsAR::model()->findByPK($prodId);
			$now = date('Y-m-d');
			if($now< $productInfo->stime )
				$productInfo->status = "未到期";
			else if($now > $productInfo->etime)
				$productInfo->status = "已过期";
			else{
				switch ($productInfo->status) {
					case 1:
						$productInfo->status = '已上架';
						break;
					case 2:
						$productInfo->status = '已下架';
						break;
					default:
						$productInfo->status = '已上架';
						break;
				}
			}
		}
		$productType = ProductTypeAR::model()->findByPK($typeId);

		$this->render('allProducts',array(
			'productType'=>$productType,
			'prodList'=>$prodList,
			'productInfo'=>$productInfo,
		));	
	}
	
	public function actionNoProducts()
	{
		$this->render('noProducts');
	}
	//ajax:编辑类别和其描述
	public function actionUpdateCategory()
	{
		if(isset($_POST['id']) && isset($_POST['changeName']) && isset($_POST['changeDesc'])){
			$type = ProductTypeAR::model()->getCategoryByName($_POST["changeName"]);
			if($type!=null && $type->id != $_POST['id']){
				throw new CHttpException(500,'商品类别名字重复！');
			}else{
				ProductTypeAR::model()->updateProductType($_POST['id'],$_POST['changeName'],$_POST['changeDesc']);
				$this->updateSession();
			}
		}
	}

	public function actionGetProduct()
	{
		if(isset($_POST['id'])){
			$product = ProductsAR::model()->getDetailProductById($_POST['id']);
			$prodArray = ProductsAR::model()->getProductArray($product);
			echo json_encode($prodArray);
		}
	}

	public function actionAddProduct()
	{
		if(isset($_POST["pname"]) && isset($_POST["price"]) && isset($_POST["typeId"]) 
			&& isset($_POST["credit"]) && isset($_POST["stime"]) && isset($_POST["etime"])){
			$product = new ProductsAR();
			$product->seller_id = Yii::app()->user->sellerId;
			$product->pname = $_POST["pname"];
			$product->type_id = $_POST["typeId"];
			$product->price = $_POST["price"];
			$product->credit = $_POST["credit"];
			$product->description = $_POST["description"];
			$product->stime = $_POST["stime"];
			$product->etime = $_POST["etime"];
			$product->instore = $_POST["instore"];
			$product->daily_instore = $_POST["instore"];
			$product->save();
			$this->updateSession();
			$info = array();
			$info['prodId']=$product->id;
			echo json_encode($info);
		}else{
			throw new CHttpException(500,'商品信息缺失！');
		}
	}

	public function actionAddCategory()
	{
		if(isset($_POST["typeName"])){
			$type = ProductTypeAR::model()->getCategoryByName($_POST["typeName"]);
			$info = array();
			if($type!=null){
				throw new CHttpException(500,'商品类别名字重复！');
			}else{
				$category = new ProductTypeAR();
				$category->seller_id = Yii::app()->user->sellerId;
				$category->type_name = $_POST["typeName"];
				$category->save();
				$this->updateSession();
				$info["success"] = $category->id;
				echo json_encode($info);
			}

		}else{
			throw new CHttpException(500,'类别信息缺失！');
		}
	}

	public function actionDelCategory()
	{
		if(isset($_POST['id']) && isset($_POST['deleteOr'])){
			$transaction = Yii::app()->db->beginTransaction();
			$deleteOr = $_POST['deleteOr'];
            try{
            	$category = ProductTypeAR::model()->findByPK($_POST['id']);
            	$category->deleted = 1;
            	$category->save();
            	if($deleteOr=='true'){
    				ProductsAR::model()->updateAll(array('deleted'=>1),'type_id=:type_id',array(':type_id'=>$_POST['id']));
            	}else{
            		$products = ProductsAR::model()->findAll('type_id=:type_id and deleted=0',array(':type_id'=>$_POST["id"]));
            		foreach ($products as $product) {
            			$product->type_id = $_POST["newTypeId"];
            			$product->update();
            		}
            	}
                $transaction->commit();
            	$this->updateSession();
            	$types = ProductTypeAR::model()->getUndeletedProductTypeBySellerId(Yii::app()->user->sellerId);
            	if(!empty($types)){
            		echo json_encode(array('empty'=>0, 'id'=>$types[0]->id));
            	}else{
            		echo json_encode(array('empty'=>1));
            	}
            }catch(Exception $e){
                $transaction->rollback();
            } 
		}
	}
	
	public function actionDelTypeNone()
	{
		if(isset($_POST['id'])){
			$category = ProductTypeAR::model()->findByPK($_POST['id']);
			$category->deleted = 1;
			$category->save();
			$this->updateSession();
			$types = ProductTypeAR::model()->getUndeletedProductTypeBySellerId(Yii::app()->user->sellerId);
			if(!empty($types)){
				echo json_encode(array('empty'=>0, 'id'=>$types[0]->id));
			}else{
				echo json_encode(array('empty'=>1));
			}
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
			$product->type_id = $_POST['typeId'];
			$product->update();
			$this->updateSession();
		}

	}

	public function actionDelProduct(){
		if(isset($_POST['id'])){
			$product = ProductsAR::model()->findByPK($_POST["id"]);
			$product->deleted = 1;
			$product->update();
			$this->updateSession();
		}else{
			throw new CHttpException(500,'删除失败！');
		}
	}

	public function actionShelfProduct(){
		if(isset($_POST['id']) && isset($_POST['status'])){
			$product = ProductsAR::model()->findByPK($_POST["id"]);
			$product->status = $_POST['status'];
			$product->save();
		}else{
			throw new CHttpException(500,'上下架失败！');
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

	public function actionTypeImgUp($typeId)
	{
		$category = ProductTypeAR::model()->findByPK($typeId);
		$pictureId = UpPicture::uploadPicture("upload/category/","typeImg");
		$picture = PicturesAR::model()->findByPK($pictureId);
		$category->pic_url = $picture->pic_url;
		$category->update();
	}

	public function actionBatchCategory()
	{
		if(isset($_POST['newTypeId']) && isset($_POST['idList'])){
			$idList = $_POST['idList'];
			$num = count($idList);
			$transaction = Yii::app()->db->beginTransaction();
            try{
            	foreach ($idList as $id){
        			$product = ProductsAR::model()->findByPK($id);
            		$product->type_id = $_POST['newTypeId'];
            		$product->update();									
            	}
                $transaction->commit();
            	$this->updateSession();
            }catch(Exception $e){
                $transaction->rollback();
            } 
		}
	}

	public function actionBatchStock()
	{
		if(isset($_POST['stock']) && isset($_POST['idList']) ){
			$idList = $_POST['idList'];
			$transaction = Yii::app()->db->beginTransaction();
            try{
            	foreach ($idList as $id){
        			$product = ProductsAR::model()->findByPK($id);
            		$product->instore = $_POST['stock'];
            		$product->update();									
            	}
                $transaction->commit();
            }catch(Exception $e){
                $transaction->rollback();
            } 
		}
	}
	
	public function actionBatchShelf()
	{
		if(isset($_POST['status']) && isset($_POST['idList']) ){
			$idList = $_POST['idList'];
			$transaction = Yii::app()->db->beginTransaction();
            try{
            	foreach ($idList as $id){
        			$product = ProductsAR::model()->findByPK($id);
            		$product->status = $_POST['status'];
            		$product->update();									
            	}
                $transaction->commit();
            }catch(Exception $e){
                $transaction->rollback();
            } 
		}
	}

	public function actionBatchDel()
	{
		if(isset($_POST['idList']) ){
			$idList = $_POST['idList'];
			$transaction = Yii::app()->db->beginTransaction();
            try{
            	foreach ($idList as $id){
        			$product = ProductsAR::model()->findByPK($id);
            		$product->deleted = 1;
            		$product->update();									
            	}
            	$this->updateSession();

                $transaction->commit();
            }catch(Exception $e){
                $transaction->rollback();
            } 
		}
	}

	private function updateSession()
	{
		$typeCount = ProductTypeAR::model()->getProductsByType(Yii::app()->user->sellerId);
		Yii::app()->session[UserIdentity::SESSION_TYPECOUNT] = $typeCount;
	}
}