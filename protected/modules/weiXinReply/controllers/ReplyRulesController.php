<?php

class ReplyRulesController extends Controller
{
	public $layout = '/layouts/main';
    public $defaultAction = 'allRules';

    public function actionAllRules(){
    	$user = UsersAR::model()->getUserById(Yii::app()->user->sellerId);
    	//用户没有定义自动回复和默认回复
    	if($user->auto_id==null || $user->default_id==null){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$autoMsgs = new SdmsgsAR;
	    		$autoMsgs->type = 0;
	    		$autoMsgs->save();
	    		$defaultMsgs = new SdmsgsAR;
	    		$defaultMsgs->type = 1;
	    		$defaultMsgs->save();
	    		$user->auto_id = $autoMsgs->id;
	    		$user->default_id = $defaultMsgs->id;
	    		$user->update();
	    		$transaction->commit();
	    		$default = array();
	    		$default[0]['id'] = $autoMsgs->id;
	    		$default[0]['type_name'] = '文本';
	    		$default[1]['id'] = $defaultMsgs->id;
	    		$default[1]['type_name'] = '文本';
	    		$autoItem = new SdmsgItemsAR;
	    		$autoItem->sdmsg_id = $autoMsgs->id;
	    		$autoItem->type = 0;
	    		$defaultItem->save();
	    		$defaultItem = new SdmsgItemsAR;
	    		$defaultItem->sdmsg_id = $defaultMsgs->id;
	    		$defaultItem->type = 0;
	    		$defaultItem->save();
			}catch(Exception $e){
                $transaction->rollback();
            } 		
    	}else{
    		$default = array();
            $default[0]['id'] = $user->auto_id;         
    		$default[0]['id'] = $user->auto_id;    		
    		$default[0]['type_name'] = SdmsgItemsAR::model()->getTypeName($user->auto_id);
    		$default[1]['id'] = $user->default_id;
			$default[1]['type_name'] = SdmsgItemsAR::model()->getTypeName($user->default_id);
    	}
    	$itemList = SdmsgItemsAR::model()->getAllCustomizedItem(Yii::app()->user->sellerId);
    	$storeList = StoreAR::getStoreByUserId(Yii::app()->user->sellerId);
        $this->render('allRules',array(
			'default'=>$default,
			'itemList'=>$itemList,
		));
    }

    //返回图文内容
    public function actionGetDefaultRule(){
    	if(isset($_POST['sdmsg_id']))
    	$result = SdmsgItemsAR::model()->getImageTexts($_POST['sdmsg_id']);
    	echo json_encode($result);
    }

    //单图文图片上传
    public function actionImgUp($sdmsgsId){
		$pictureId = UpPicture::uploadPicture("upload/imgText/","coverImg");
		$picture = PicturesAR::model()->findByPK($pictureId);
    	$sdmsgsItem = SdmsgItemsAR::model()->find('sdmsg_id=?',array($sdmsgsId));
    	$sdmsgsItem->picurl = $picture->pic_url;
    	$sdmsgsItem->update();
    }

    //多图文图片上传
    public function actionTypeImgUp($itemId){
		$pictureId = UpPicture::uploadPicture("upload/imgText/","typeImg");
		$picture = PicturesAR::model()->findByPK($pictureId);
    	$sdmsgsItem = SdmsgItemsAR::model()->findByPK($itemId);
    	$sdmsgsItem->picurl = $picture->pic_url;
    	$sdmsgsItem->update();
    }

    //多图文里添加一个图文，$serial是指该图文在多图文里的顺序，如为第10个，则该值为9
    public function actionAddItem(){
    	if(isset($_POST['sdmsg_id']) && isset($_POST['serial'])){
	    	$item = new SdmsgItemsAR;
	    	$item->sdmsg_id = $_POST['sdmsg_id'];
	    	$item->store_id = 0;
	    	$item->type = 256*($_POST['serial']+1)+1;//将值默认设置外部链接
	    	
	    	$item->save();
	    	$itemArray = SdmsgItemsAR::model()->getItemById($item->id);
	    	echo json_encode($itemArray);
    	}
    }

    //删除多图文里某个图文
    public function actionDelItem(){
    	if(isset($_POST['itemId'])){
    		$delItem = SdmsgItemsAR::model()->findByPK($_POST['itemId']);
    		SdmsgItemsAR::model()->deleteByPK($_POST['itemId']);
    		$itemList = SdmsgItemsAR::model()->findAll('sdmsg_id=?',array($delItem->sdmsg_id));  
    		foreach ($itemList as $item) {
    			if($item->type > $delItem->type){
    				$item->type = $item->type-256;
    				$item->update();
    			}
    		}
    		$result = SdmsgItemsAR::model()->getImageTexts($delItem->sdmsg_id);
    		echo json_encode($result);
    	}
    }

}