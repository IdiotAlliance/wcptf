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
		$user      = UsersAR::model()->getUserById($sellerId);
		$time      = time();
		switch ($eventType){
			case 'subscribe':{
				// 存储该用户到会员表中
 				$member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openId);
 				if(!$member){
 					$member = new MembersAR();
 					$member->seller_id = $sellerId;
 					$member->openid    = $openId;
 					$member->save();
 				}else{
 					$member->unsubscribed = 0;
 					$member->update();
 				}
				// 返回消息
				$textTpl = "<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[text]]></MsgType>
								<Content><![CDATA[%s]]></Content>
							</xml>
						";
				$resultStr = sprintf($textTpl, $msg->FromUserName, $msg->ToUserName, $time,
						     "感谢您关注".$user->store_name."!回复 菜单 以察看主菜单");
				echo $resultStr;
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
	
	public function handleTextMsg($rawmsg, $msg, $sellerId){
		$openid = $msg->FromUserName;
		$content = trim($msg->Content);
		$time = time();
		if($content){
			switch($content){
				case '菜单':{
					// 返回消息
					$textTpl = "<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[news]]></MsgType>
								<ArticleCount>6</ArticleCount>
								<Articles>
									<item>
										<Title><![CDATA[您好~(^O^)~,我是茹果！]]></Title> 
										<Description><![CDATA[欢迎使用茹果微信点单工具]]></Description>
										<PicUrl><![CDATA[http://210.209.70.43/wcptf/img/wap/fruitjuice.jpg]]></PicUrl>
										<Url><![CDATA[%s]]></Url>
									</item>
									<item>
										<Title><![CDATA[在线点单]]></Title>
										<PicUrl><![CDATA[]]></PicUrl>
										<Url><![CDATA[%s]]></Url>
									</item>
									<item>
										<Title><![CDATA[热卖产品]]></Title>
										<PicUrl><![CDATA[]]></PicUrl>
										<Url><![CDATA[%s]]></Url>
									</item>
									<item>
										<Title><![CDATA[个人中心]]></Title>
										<PicUrl><![CDATA[]]></PicUrl>
										<Url><![CDATA[%s]]></Url>
									</item>
									<item>
										<Title><![CDATA[提出建议]]></Title>
										<PicUrl><![CDATA[]]></PicUrl>
										<Url><![CDATA[%s]]></Url>
									</item>
									<item>
										<Title><![CDATA[关于我们]]></Title>
										<PicUrl><![CDATA[]]></PicUrl>
										<Url><![CDATA[%s]]></Url>
									</item>
								</Articles>
							</xml>
						";
					$order_url = Yii::app()->createAbsoluteUrl('wap/index/'.$sellerId.'#'.$openid);
					$hots_url  = Yii::app()->createAbsoluteUrl('wap/index/'.$sellerId.'#'.$openid);
					$personal_url = "";
					$propose_url = "";
					$about_url = "";
					$resultStr = sprintf( $textTpl, $msg->FromUserName, $msg->ToUserName, $time, 
										  $order_url, $order_url, $hots_url, $personal_url, 
										  $propose_url, $about_url);
					echo $resultStr;
					break;
				}
				default:{
					// 存储消息
					$wcmsg = new WechatmsgsAR();
					$wcmsg->seller_id = $sellerId;
					$wcmsg->openid = $openid;
					$wcmsg->rawid  = $msg->MsgId;
					$wcmsg->msgtype = $msg->MsgType;
					$wcmsg->createtime = $msg->CreateTime;
					$wcmsg->rawmsg = $rawmsg;
					$wcmsg->save();
					break;
				}
			}
		}
	}
}