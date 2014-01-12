<?php
class WechatAccessController extends Controller {
	
	public $defaultAction = "wechatAccess";
	
	/**
	 * 微信的回调接口
	 */
	public function actionWechatAccess() {
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wechatAccess\/(\d+)\/(\w+)/i', $url, $matches);
		if(!$matches){
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
		$sellerId = $matches[1];
		
		if (Yii::app()->request->isPostRequest) {	
			// 获取post过来的xml消息
			$postStr = file_get_contents("php://input");
			if($sellerId && $postStr){
				$this->handleMsg($sellerId, $postStr);
			}
			else{
				echo 'invalid arguments';
			}
		} else {
// 			$token = UsersAR::model()->getUserTokenById($sellerId);
// 			echo $token;
			if(isset($_GET['signature']) && 
			   isset($_GET['timestamp']) && 
			   isset($_GET['nonce']) && 
			   isset($_GET['echostr'])){
				// 接口验证请求
				$signature = $_GET["signature"];
				$timestamp = $_GET["timestamp"];
				$nonce = $_GET["nonce"];
				$echostr = $_GET["echostr"];
				
				$token = UsersAR::model()->getUserTokenById($sellerId);
				$tmpArr = array (
						$token,
						$timestamp,
						$nonce 
				);
				sort ( $tmpArr );
				$tmpStr = implode ( $tmpArr );
				$tmpStr = sha1 ( $tmpStr );
				
				if ($tmpStr == $signature) {
					// 更新数据库状态
					UsersAR::model()->setBound($sellerId);
					echo $echostr;
				} else {
					echo "invalid arguments";
				}
			}else{
				echo 'invalid arguments';
			}
		}
	}
	
	/**
	 * 处理post消息的函数
	 */
	public function handleMsg($sellerId, $postStr) {
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		if($postObj){
			switch($postObj->MsgType){
				case 'event':{
					$this->handleEvent($postStr, $postObj, $sellerId);
					break;
				}
				case 'text':{
					$this->handleTextMsg($postStr, $postObj, $sellerId);
					break;
				}
				default:{
					break;
				}
			}
		}else{
			echo "invalid xml message!";
		}
	}
	
	public function handleEvent($rawmsg, $msg, $sellerId){
		$eventType = $msg->Event;
		$openId    = $msg->FromUserName;
		$selfId    = $msg->ToUserName;
		$user      = UsersAR::model()->getUserById($sellerId);
		$time      = time();
		if($user){
			switch ($eventType){
				case 'subscribe':{
					// 存储该用户到会员表中
	 				$member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openId);
	 				if(!$member){
	 					$member = new MembersAR();
	 					$member->seller_id = $sellerId;
	 					$member->openid    = $openId;
	 					$member->wapkey = SeriesGenerator::generateMemberKey();
	 					$member->save();
	 				}else{
	 					$member->unsubscribed = 0;
	 					$member->update();
	 				}
					// 返回消息
					$sdmsg = SdmsgsAR::model()->getMsgByType($sellerId, Constants::SDMSG_AUTO);
					if($sdmsg && $msgtpl = $this->constructMsg($sellerId, $openId, $selfId, $sdmsg)){
						echo $msgtpl;
						exit();
					}
					echo '欢迎您关注 '.$user->wechat_name.' !';
					break;
				}
				case 'unsubscribe':{
					// 修改会员状态
					$member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openId);
					if($member){
						$member->unsubscribed = 1;
						$member->update();
					}
					break;
				}
			}
		}
	}
	
	/**
	 * Handle msgs with the type 'text'. 
	 */
	public function handleTextMsg($rawmsg, $msg, $sellerId){
		$openid = $msg->FromUserName;
		$selfid = $msg->ToUserName;
		$content = trim($msg->Content);
		$msgtpl = null;
		if($content){
			$wcmsg = new WechatmsgsAR();
			$wcmsg->seller_id  = $sellerId;
			$wcmsg->openid     = $openid;
			$wcmsg->rawid      = $msg->MsgId;
			$wcmsg->rawmsg     = $rawmsg;
			$wcmsg->msgtype    = $msg->MsgType;
			$wcmsg->createtime = $msg->CreateTime;
			$wcmsg->replied    = Constants::REPLIED_NONE;
			
			$sdmsg = null;
			$matchId = SdmsgsAR::model()->findMatch($sellerId, $content);
			if($matchId >= 0){
				// get related sdmsg from db
				$sdmsg = SdmsgsAR::model()->findByPK($matchId);
				$wcmsg->replied = Constants::REPLIED_KEYWORD;
			}else{
				// get default msg from db
				$sdmsg = SdmsgsAR::model()->getMsgByType($sellerId, Constants::SDMSG_DEFAULT);
				$wcmsg->replied = Constants::REPLIED_DEFAULT;
			}
			
			if($sdmsg){
				if($msgtpl = $this->constructMsg($sellerId, $openid, $selfid, $sdmsg))
					echo $msgtpl;
				else
					$wcmsg->replied = Constants::REPLIED_NONE;
			}
			else 
				$wcmsg->replied = Constants::REPLIED_NONE;

			if($wcmsg->save() && 
			  ($wcmsg->replied == Constants::REPLIED_DEFAULT ||
			   $wcmsg->replied == Constants::REPLIED_NONE)){
				// create a message queue entry and insert into msg_queue table
				$mq = new MsgQueueAR();
				$mq->seller_id = $sellerId;
				$mq->msg_id    = $wcmsg->attributes['id'];
				$mq->type      = Constants::MSG_WECHAT;
				$mq->save();
			}
		}
	}

	public function constructMsg($sellerId, $openid, $selfid, $sdmsg){
		$time = time();
		$msgtpl = null;
		$items = SdmsgItemsAR::model()->getByMsgId($sdmsg->id);
		if($items && !empty($items)){
			if(count($items) == 1){
				$item = $items[0];
				switch ($item->type) {
					case 0:
						// dan tiao mu chun wen ben
						$msgtpl = "<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[text]]></MsgType>
									<Content><![CDATA[%s]]></Content>
								   </xml>";
						$msgtpl = sprintf($msgtpl, $openid, $selfid, $time, $item->content);
						break;
					case 1:
						// dan tiao mu tu wen
						$msgtpl = "<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[news]]></MsgType>
									<ArticleCount>1</ArticleCount>
									<Articles>
										<item>
											<Title><![CDATA[%s]]></Title> 
											<Description><![CDATA[%s]]></Description>
											<PicUrl><![CDATA[%s]]></PicUrl>
											<Url><![CDATA[%s]]></Url>
										</item>
									</Articles>
									</xml> ";
						$msgtpl = sprintf($msgtpl, $openid, $selfid, $time, 
										  $item->title, $item->content, $item->picurl, $item->url);
						break;
				}
			}else{
				$msgtpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>%s</ArticleCount>
							<Articles>%s</Articles>
						   </xml>
						   ";
				$msgitems = array();
				$token = null;
				foreach ($items as $item) {
				 	$itemtpl = "<item>
				 					<Title><![CDATA[%s]]></Title>
				 					<Description><![CDATA[%s]]></Description>
									<PicUrl><![CDATA[%s]]></PicUrl>
									<Url><![CDATA[%s]]></Url>
				 				</item>";
				 	$type = ($item->type & 0xFF);
				 	$index = (($item->type >> 8) & 0xFF) - 1;
				 	if(($type & 0x80) > 0){
				 		$url = null;
				 		// functional item
				 		// generate and save token
				 		if(!$token)
				 			$token = SeriesGenerator::generateMemeberToken();

				 		switch ($type) {
				 			case 0x80:
				 				# order
				 				$url = Yii::app()->createAbsoluteUrl('/wap/index/'.$sellerId.'?openid='.$openid.'&token='.$token);
				 				break;
				 			case 0x81:
				 				# history
								$url = Yii::app()->createAbsoluteUrl('/wap/wap/history/'.$sellerId.'?openid='.$openid.'&token='.$token).'#mp.weixin.qq.com';					 				
				 				break;
				 			case 0x82:
				 				# promotions
				 				$hot_url = $url = Yii::app()->createAbsoluteUrl('/wap/index/'.$sellerId.'?openid='.$openid.'&token='.$token);
				 				$hot_products = HotProductsAR::model()->getHotProductsById($sellerId);
				 				foreach ($hot_products as $hot) {
				 					$hot_url = $url.'&sortid='.$hot->product_id;
				 					if($hot->onindex == 1){
				 						break;
				 					}
				 				}
				 				$url = $hot_url;
				 				break;
				 			case 0x83:
				 				# contact us
				 				
				 				break;
				 		}
				 		$itemtpl = sprintf($itemtpl, $item->title, $item->content, $item->picurl, $url);
				 	}else{
				 		// non functional item
				 		$itemtpl = sprintf($itemtpl, $item->title, $item->content, $item->picurl, $item->url);
				 	}
				 	$msgitems[$index] = $itemtpl;
				}
				if($token){
					$memtoken = new MemberTokenAR();
					$memtoken->seller_id = $sellerId;
					$memtoken->openid    = $openid;
					$memtoken->token     = $token;
					$memtoken->save();
				}
				$itemstr = "";
				foreach ($msgitems as $msgitem) {
					$itemstr = $itemstr.$msgitem;
				}
				$msgtpl = sprintf($msgtpl, $openid, $selfid, $time, count($items), $itemstr);
			}
		}
		return $msgtpl;
	}
}