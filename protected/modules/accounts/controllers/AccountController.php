<?php
/**
 * @author lvxiang
 */
class AccountController extends Controller{

	public $currentPage = null;
	public $layout = 'account';
	public $defaultAction = "stores";
	public $typeAtrributes    = ['type_name', 'type_description', 'pic_url'];
	public $productAttributes = ['pname', 'price', 'credit', 'description', 
								 'stime', 'etime', 'status', 'instore', 'richtext', 
								 'cover'];
	public $districtAttributes = ['name', 'description'];
	public $posterAttributes   = ['name', 'phone', 'description'];

	public function actions()
    { 
            return array( 
                    // captcha action renders the CAPTCHA image displayed on the contact page
                    'captcha'=>array(
                            'class'=>'CCaptchaAction',
                            'backColor'=>0xFFFFFF, 
                            'maxLength'=>'4',       // 最多生成几个字符
                             'minLength'=>'4',       // 最少生成几个字符
                           'height'=>'40'
                    ), 
            ); 
    }


	public function actionStores(){
		$this->pageTitle = "店铺管理";
		if(Yii::app()->user->isGuest){
			$this->redirect('index.php/accounts/login');
		}else{
			$this->currentPage = 'stores';
			$errmsg = null;
			// edit store name
			if(isset($_POST['EditStoreForm'])){
				// var_dump(123);
				// exit();
				$uid = Yii::app()->user->sellerId;
				$model = new EditStoreForm();
				$model->attributes = $_POST['EditStoreForm'];
				$store = StoreAR::model()->findByPK($model->sid); 
				if($store && !StoreAR::model()->nameExsits($uid, $model->newname)){
					$store->name = $model->newname;
					$store->update();
				}else{
					$errmsg = "修改失败，店铺名称不能重复";
				}
			}
			if(isset($_POST['DeleteStoreForm'])){
				$uid = Yii::app()->user->sellerId;
				$user  = UsersAR::model()->findByPK($uid);
				$model = new DeleteStoreForm();
				$model->attributes = $_POST['DeleteStoreForm'];
				if(md5($model->pass) == $user->password){
					$store = StoreAR::model()->findByPK($model->sid);
					if($store){
						$store->deleted = 1;
						$store->update();
					}else{
						$errmsg = "指定的店铺不存在";
					}
				}else{
					$errmsg = "密码错误，无法删除店铺";
				}
			}
			$editForm = new EditStoreForm();
			$deleteForm = new DeleteStoreForm();
			$uid = Yii::app()->user->sellerId;
			$user   = UsersAR::model()->findByPK($uid);
			$stores = StoreAR::model()->getUndeletedStoreByUserId($uid);
			$this->render("account", array('user'=>$user, 
										   'stores'=>$stores, 
										   'editForm'=>$editForm,
										   'deleteForm'=>$deleteForm,
										   'errmsg'=>$errmsg));

		}
	}

	public function actionCreateStore(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must log in to take this operation");
		}else{
			if(isset($_POST['name']) && isset($_POST['type'])){
				$uid    = Yii::app()->user->sellerId;
				$stores = StoreAR::model()->getStoreByUserId($uid);
				foreach ($stores as $store) {
					if($store->name == $_POST['name']){
						echo json_encode(array('result'=>1));
						exit;
					}
				}
				$store = new StoreAR();
				$store->name = $_POST['name'];
				$store->type = $_POST['type'];
				$store->seller_id = $uid;
				$store->save();
				echo json_encode(array('result'=>0, 'sid'=>$store->id));
			}else{
				throw new CHttpException(403, "Error Processing Request, Illegal Arguments");
			}
		}
	}

	public function actionCopy(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must log in to take this operation");
		}else{
			if(isset($_POST['src']) && isset($_POST['dst'])){
				$src = StoreAR::model()->findByPK($_POST['src']);
				$dst = StoreAR::model()->findByPK($_POST['dst']);
				if($src && $dst && ($src->type == $dst->type)){
					if(isset($_POST['info']) && $_POST['info'] == 1){
						$dst->broadcast = $src->broadcast;
						$dst->stime     = $src->stime;
						$dst->etime     = $src->etime;
						$dst->phone     = $src->phone;
						$dst->address   = $src->address;
						$dst->logo      = $src->logo;
						$dst->update();    
					}
					if(isset($_POST['prod']) && $_POST['prod'] == 1){
						$types = ProductTypeAR::model()->getUndeletedProductTypeByStoreId($src->id);
						foreach ($types as $type) {
							$oldid = $type->id;
							$type->isNewRecord = true;
							$type->store_id = $dst->id;
							unset($type->id);
							$type->save();
							
							$products = ProductsAR::model()->getUndeletedProductsByProductType($oldid);
							foreach ($products as $product) {
								$product->isNewRecord = true;
								$product->store_id = $dst->id;
								$product->type_id  = $type->id;
								unset($product->id);
								$product->save();
							}
						}
					}
					if(isset($_POST['tkaw']) && $_POST['tkaw'] == 1){
						$dst->start_price    = $src->start_price;
						$dst->takeaway_fee   = $src->takeaway_fee;
						$dst->threshold      = $src->threshold;
						$dst->estimated_time = $src->estimated_time;
						$dst->update();
					}
					if(isset($_POST['dist']) && $_POST['dist'] == 1){
						$districts = DistrictsAR::model()->getUndeletedDistrictsByStoreId($src->id);
						foreach ($districts as $district) {
							$district->isNewRecord = true;
							$district->store_id = $dst->id;
							unset($district->id);
							$district->save();
						}
					}
					if(isset($_POST['post']) && $_POST['post'] == 1){
						$posters = PostersAR::model()->getUndeletedPostersByStoreId($src->id);
						foreach ($posters as $poster) {
							$poster->isNewRecord = true;
							$poster->store_id = $dst->id;
							unset($poster->id);
							$poster->save();
						}
					}
					echo json_encode(array('result'=>0));
				}else{
					throw new CHttpException(403, "Error Processing Request, Illegal Arguments");
				}
			}else{
				throw new CHttpException(403, "Error Processing Request, Illegal Arguments");
			}
		}
	}
}
