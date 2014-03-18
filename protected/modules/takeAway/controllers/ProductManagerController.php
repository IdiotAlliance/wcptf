<?php
include 'TakeAwayController.php';

class ProductManagerController extends TakeAwayController
{
	public $layout = '/layouts/main';
    public $defaultAction = 'allProducts';

	public function actionAllProducts($typeId,$prodId)
	{	
		if(isset($_GET['sid']) && $_GET['sid'] >= 0 && $this->setCurrentStore($_GET['sid'])){
			$this->typeCount = ProductTypeAR::model()->getProductsByType($_GET['sid']);
			if($this->typeCount == null){
					$this->render('noProducts');	
			}else{
				if($typeId==0){
					$typeId = $typeCount[0]['typeId'];
				}
				$productList = ProductsAR::model()->getCategoryProducts($typeId);
				$prodList = ProductsAR::model()->getAllProducts($productList);
				$productInfo = null;
				$images = null;
				if($productList != null && $prodId==0){
					$productInfo = $productList[0];
					$images = ProductImageAR::model()->getImagesByPid($productInfo['id']);
				}

				if($prodId!=0){
					$productInfo = ProductsAR::model()->findByPK($prodId);
					if($productInfo){
						$now = date('Y-m-d h:m:s');
						if($now< $productInfo->stime) $productInfo->status = "未到期";
						else if($now > $productInfo->etime) $productInfo->status = "已过期";
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
						$images = ProductImageAR::model()->getImagesByPid($productInfo['id']);
					}
					else{
						throw new CHttpException(404, "The page is not found");
					}
				}
				$productType = ProductTypeAR::model()->findByPK($typeId);
				$this->render('allProducts',array(
					'productType'=>$productType,
					'prodList'=>$prodList,
					'productInfo'=>$productInfo,
					'images'=>$images
				));	
			}			
		}		
	}

	public function actionGetDiscounts($pid){
		$discounts = TimelyDiscountsAR::model()->findAll('pid=:pid', array(':pid' => $pid));
		$arr = array();
		foreach ($discounts as $discount) {
			array_push($arr, array('id'=>$discount->id,
								   'sdate'=>$discount->cdate,
								   'edate'=>$discount->edate,
								   'stime'=>$discount->ctime,
								   'etime'=>$discount->etime));
		}
		echo json_encode($arr);
	}

	public function actionAddDiscount(){
		if(isset($_POST['pid']) && isset($_POST['sdate']) && isset($_POST['edate']) &&
		   isset($_POST['stime']) && isset($_POST['etime'])){
			$discount = new TimelyDiscountsAR();
			$discount->pid   = $_POST['pid'];
			$discount->cdate = $_POST['sdate'];
			$discount->edate = $_POST['edate'];
			$discount->ctime = $_POST['stime'];
			$discount->etime = $_POST['etime'];
			$discount->save();
			echo $discount->id;
		}
		echo '-1';
	}

	public function actionUpdateDiscount(){
		if(isset($_POST['id']) && isset($_POST['sdate']) && isset($_POST['edate']) &&
		   isset($_POST['stime']) && isset($_POST['etime'])){
			$discount = TimelyDiscountsAR::model()->find("id=:id", array(":id"=>$_POST['id']));
			if($discount){
				$discount->cdate = $_POST['sdate'];
				$discount->edate = $_POST['edate'];
				$discount->ctime = $_POST['stime'];
				$discount->etime = $_POST['etime'];
				$discount->update();
				echo '0';
				return;
			}
		}
		throw new CHttpException(403, "Invalid parameter");
	}

	public function actionDeleteDiscount($id){
		$count = TimelyDiscountsAR::model()->deleteAll("id=:id", array(":id"=>$id));
		echo $count;
	}

	public function actionNoProducts(){
		if(isset($_GET['sid']) && $_GET['sid'] >= 0 && $this->setCurrentStore($_GET['sid'])){
			$this->typeCount = ProductTypeAR::model()->getProductsByType($_GET['sid']);			
			$this->render('noProducts');
		}
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
			}
		}
	}


	public function actionGetProduct()
	{
		if(isset($_POST['id'])){
			$product = ProductsAR::model()->getDetailProductById($_POST['id']);
			$prodArray = ProductsAR::model()->getProductArray($product);
			$images = ProductImageAR::model()->getImagesByPid($_POST['id']);
			$prodArray['images'] = $images;
			echo json_encode($prodArray);
		}
	}

	public function actionAddProduct()
	{
		if(isset($_POST["pname"]) && isset($_POST["price"]) && isset($_POST["typeId"]) 
			&& isset($_POST["credit"]) && isset($_POST["stime"]) && isset($_POST["etime"])){
			$product = new ProductsAR();
			$product->store_id = $_POST['sid'];
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
				$category->store_id = $_POST['sid'];
				$category->type_name = $_POST["typeName"];
				$category->save();
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
            	$types = ProductTypeAR::model()->getUndeletedProductTypeByStoreId($_POST['sid']);
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
			$types = ProductTypeAR::model()->getUndeletedProductTypeByStoreId($_POST['sid']);
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
			// $product->richtext = $_POST['richtext'];
			$product->type_id = $_POST['typeId'];
			$product->update();
		}

	}

	public function actionDelProduct(){
		if(isset($_POST['id'])){
			$product = ProductsAR::model()->findByPK($_POST["id"]);
			$product->deleted = 1;
			$product->update();
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

	public function actionProdImgUp($productId){
		$result = UpPicture::uploadPictureWithoutEcho("upload/detail/","prodImg");
		$prodimg   = new ProductImageAR();
		$prodimg->pid = $productId;
		$prodimg->iid = $result['pid'];
		$prodimg->save();
		$result['piid'] = $prodimg->id;
		echo json_encode($result);
	}

	public function actionDelimg($id){
		$count = ProductImageAR::model()->deleteAll('id=:id', array(":id"=>$id));
		echo json_encode(array('count' => $count));
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

                $transaction->commit();
            }catch(Exception $e){
                $transaction->rollback();
            } 
		}
	}
}