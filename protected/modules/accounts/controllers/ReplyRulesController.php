<?php

class ReplyRulesController extends Controller
{
    public $currentPage = 'msgs';
	public $layout = 'account';
    public $defaultAction = 'allRules';

    public function actionAllRules(){
        $auto = SdmsgsAR::model()->getAutoReply(Yii::app()->user->sellerId);
        $default = SdmsgsAR::model()->getDefaultReply(Yii::app()->user->sellerId);
    	//用户没有定义自动回复和默认回复
    	if($auto == null || $default == null){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$autoMsgs = new SdmsgsAR;
	    		$autoMsgs->type = 0;
                $autoMsgs->seller_id = Yii::app()->user->sellerId;
	    		$autoMsgs->save();
	    		$defaultMsgs = new SdmsgsAR;
	    		$defaultMsgs->type = 1;
                $defaultMsgs->seller_id = Yii::app()->user->sellerId;                         
	    		$defaultMsgs->save();
	    		$autoItem = new SdmsgItemsAR;
	    		$autoItem->sdmsg_id = $autoMsgs->id;
	    		$autoItem->type = 0;
	    		$autoItem->save();
	    		$defaultItem = new SdmsgItemsAR;
	    		$defaultItem->sdmsg_id = $defaultMsgs->id;
	    		$defaultItem->type = 0;
	    		$defaultItem->save();
                $transaction->commit();
			}catch(Exception $e){
                $transaction->rollback();
            } 
            $setup = array();
            $setup[0]['id'] = $autoMsgs->id;
            $setup[0]['type_name'] = '文本';
            $setup[1]['id'] = $defaultMsgs->id;
            $setup[1]['type_name'] = '文本';		
    	}else{
    		$setup = array();
            $setup[0]['id'] = $auto->id;         
    		$setup[0]['type_name'] = SdmsgItemsAR::model()->getTypeName($auto->id);
    		$setup[1]['id'] = $default->id;
			$setup[1]['type_name'] = SdmsgItemsAR::model()->getTypeName($default->id);
    	}
    	$itemList = SdmsgItemsAR::model()->getAllCustomizedItem(Yii::app()->user->sellerId);
    	$storeList = StoreAR::getStoreByUserId(Yii::app()->user->sellerId);
        $this->render('allRules',array(
			'setup'=>$setup,
			'itemList'=>$itemList,
            'storeList'=>$storeList,
		));
    }

    //返回图文内容
    public function actionGetDefaultRule(){
    	if(isset($_POST['sdmsg_id']))
    	$result = SdmsgItemsAR::model()->getImageTexts($_POST['sdmsg_id']);
    	echo json_encode($result);
    }

    //添加规则
    public function actionAddRule(){
        if(isset($_POST['title']) && isset($_POST['type'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $sdmsgs = new SdmsgsAR;
                $sdmsgs->type = 2;
                $sdmsgs->seller_id = Yii::app()->user->sellerId;
                $sdmsgs->menu_name = $_POST['title'];
                $sdmsgs->save();
                $item = new SdmsgItemsAR;
                $item->sdmsg_id = $sdmsgs->id;
                $item->store_id = 0;
                if($_POST['type']=='文本'){
                    $item->type = 0;
                    $item->save();
                }
                else if($_POST['type']=='单图文'){
                    $item->type = 1;
                    $item->save();
                }
                else if($_POST['type']=='多图文'){
                    $item->type = 257;
                    $item->save();
                    $item1 = new SdmsgItemsAR;
                    $item1->sdmsg_id = $sdmsgs->id;
                    $item1->store_id = 0;
                    $item1->type = 513;
                    $item1->save();
                }
                $transaction->commit();
                echo CJSON::encode($sdmsgs);
 
            }catch(Exception $e){
                $transaction->rollback();
            }             
                  
        }
    }

    public function actionDelRule(){
        $transaction = Yii::app()->db->beginTransaction();
        try{          
            SdmsgItemsAR::model()->deleteAll('sdmsg_id=?',array($_POST['sdmsgId']));
            SdmsgsAR::model()->deleteByPK($_POST['sdmsgId']);
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollback();
        }
    }

    public function actionBatchDelRule(){
        $idList = $_POST['idList'];
        $transaction = Yii::app()->db->beginTransaction();
        try{   
            foreach ($idList as $id) {
                SdmsgItemsAR::model()->deleteAll('sdmsg_id=?',array($id));
                SdmsgsAR::model()->deleteByPK($id);
            }       
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollback();
        }
    }

    //保存自定义规则的文本
    public function actionSaveText(){
        $transaction = Yii::app()->db->beginTransaction();
        try{
            if($_POST['current_rule']=="customize"){
                $sdmsgs = SdmsgsAR::model()->findByPK($_POST['sdmsgId']);
                $sdmsgs->menu_name = $_POST['ruleName'];
                $sdmsgs->keyword = $_POST['keyword'];
                $sdmsgs->match_rule = $_POST['match_rule'];
                $sdmsgs->update();
            }           
            $item = SdmsgItemsAR::model()->find('sdmsg_id=?',array($_POST['sdmsgId']));
            $item->content = $_POST['content'];
            $item->type = 0;
            $item->update();
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollback();
        }
        $result = SdmsgItemsAR::model()->getImageTexts($_POST['sdmsgId']);
        echo json_encode($result);        
    }

    //保存自定义规则的单图文
    public function actionSaveImageText(){
        $transaction = Yii::app()->db->beginTransaction();
        try{
            if($_POST['current_rule']=="customize"){
                $sdmsgs = SdmsgsAR::model()->findByPK($_POST['sdmsgId']);
                $sdmsgs->menu_name = $_POST['ruleName'];
                $sdmsgs->keyword = $_POST['keyword'];
                $sdmsgs->match_rule = $_POST['match_rule'];
                $sdmsgs->update();
            }         
            $item = SdmsgItemsAR::model()->find('sdmsg_id=?',array($_POST['sdmsgId']));
            $item->title = $_POST['title'];
            $item->content = $_POST['content'];
            $item->store_id = $_POST['store_id'];
            if($_POST['resource']=='外部链接'){
                $item->type = 1;
                $item->url = $_POST['url'];
            }
            else if($_POST['resource']=='在线订单')
                $item->type = 128;
            else if($_POST['resource']=='个人中心')
                $item->type = 129;
            else if($_POST['resource']=='首页推荐')
                $item->type = 130;
            else if($_POST['resource']=='联系我们')
                $item->type = 131;
            $item->update();
            $transaction->commit();

        }catch(Exception $e){
            $transaction->rollback();
        }
        $result = SdmsgItemsAR::model()->getImageTexts($_POST['sdmsgId']);
        echo json_encode($result);
    }

    //保存自定义规则的多图文
    public function actionSaveImageTexts(){       
        $transaction = Yii::app()->db->beginTransaction();
        try{
            if($_POST['current_rule']=="customize"){
                $sdmsgs = SdmsgsAR::model()->findByPK($_POST['sdmsgId']);
                $sdmsgs->menu_name = $_POST['ruleName'];
                $sdmsgs->keyword = $_POST['keyword'];
                $sdmsgs->match_rule = $_POST['match_rule'];
                $sdmsgs->update();
            }           
            $current_json = json_decode($_POST['current_json'],true);
            $length = count($current_json);
            for($i=0;$i<$length;$i++){
                $item = SdmsgItemsAR::model()->findByPK($current_json[$i]['id']);
                $item->store_id =  $current_json[$i]['store_id'];
                $item->title = $current_json[$i]['title'];
                if($current_json[$i]['resource']=='外部链接'){
                    $item->type = 256*($i+1)+1;
                    $item->url = $current_json[$i]['url'];
                }
                else if($current_json[$i]['resource']=='在线订单')
                    $item->type = 256*($i+1)+128;
                else if($current_json[$i]['resource']=='个人中心')
                    $item->type = 256*($i+1)+129;
                else if($current_json[$i]['resource']=='首页推荐')
                    $item->type = 256*($i+1)+130;
                else if($current_json[$i]['resource']=='联系我们')
                    $item->type = 256*($i+1)+131;

                $item->update();
            }
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollback();
        } 
        $result = SdmsgItemsAR::model()->getImageTexts($_POST['sdmsgId']);
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
            $current_json = SdmsgItemsAR::model()->getImageTexts($_POST['sdmsg_id']);
            $result = array();
            $result[] = $itemArray;
            $result[] = $current_json;
	    	echo json_encode($result);
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

    //下拉框切换回复类型为多图文
    public function actionChangeToImageTexts(){
        if(isset($_POST['sdmsgId'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                SdmsgItemsAR::model()->deleteAll("sdmsg_id=?",array($_POST['sdmsgId']));
                $item0 = new SdmsgItemsAR;
                $item0->sdmsg_id = $_POST['sdmsgId'];
                $item0->store_id = 0;
                $item0->type = 257;
                $item0->save();
                $item1 = new SdmsgItemsAR;
                $item1->sdmsg_id = $_POST['sdmsgId'];
                $item1->store_id = 0;
                $item1->type = 513;
                $item1->save();
                $result = SdmsgItemsAR::model()->getImageTexts($_POST['sdmsgId']);
                $transaction->commit();
                echo json_encode($result);                      
            }catch(Exception $e){
                $transaction->rollback();
            } 
            
        }
    }

    //下拉框切换回复类型为单图文
    public function actionChangeToImageText(){
        if(isset($_POST['sdmsgId'])){
            SdmsgItemsAR::model()->deleteAll("sdmsg_id=?",array($_POST['sdmsgId']));
            $item = new SdmsgItemsAR;
            $item->sdmsg_id = $_POST['sdmsgId'];
            $item->store_id = 0;
            $item->type = 1;
            $item->save();
        }
    }

    //下拉框切换回复类型为文本
    public function actionChangeToText(){
        if(isset($_POST['sdmsgId'])){
            SdmsgItemsAR::model()->deleteAll("sdmsg_id=?",array($_POST['sdmsgId']));
            $item = new SdmsgItemsAR;
            $item->sdmsg_id = $_POST['sdmsgId'];
            $item->type = 0;
            $item->save();
        }
    }


}