<?php
class WechatAccessController extends Controller {
	
	public $defaultAction = "wechatAccess";
	
	/**
	 * 微信的回调接口
	 */
	public function actionWechatAccess() {

		if (Yii::app()->request->isPostRequest) {
			// 处理消息
			$url = Yii::app()->request->getUrl();
			// 用正则表达式从url获取seller id
			preg_match('/.*wechatAccess\/(\d+)\/(\w+)/i', $url, $matches);
			$sellerId = $matches[1];
			
			// 获取post过来的xml消息
			$postStr = file_get_contents("php://input");
			if($sellerId && $postStr){
				echo $postStr;
				handleMsg($sellerId, $postStr);
			}
			else{
				echo 'invalid arguments';
			}
		} else {
			if(isset($_GET['signature']) && 
			   isset($_GET['timestamp']) && 
			   isset($_GET['nonce']) && 
			   isset($_GET['echostr'])){
				// 接口验证请求
				$signature = $_GET["signature"];
				$timestamp = $_GET["timestamp"];
				$nonce = $_GET["nonce"];
				$echostr = $_GET["echostr"];
				
				$token = TOKEN;
				$tmpArr = array (
						$token,
						$timestamp,
						$nonce 
				);
				sort ( $tmpArr );
				$tmpStr = implode ( $tmpArr );
				$tmpStr = sha1 ( $tmpStr );
				
				if ($tmpStr == $signature) {
					echo echostr;
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
		echo '1';
		if($postObj){
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$msgType = $postObj->MsgType;
			$keyword = trim($postObj->Content);
			$time = time();
			$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
						</xml>";
			
			if (! empty($keyword)) {
				$msgType = "text";
				$contentStr = "Welcome to wechat world!";
				$resultStr = sprintf( $textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr );
				echo $resultStr;
			} else {
				echo "Input something...";
			}
		}else{
			echo "invalid xml message!";
		}
	}
	
	public function handleEvent(){
		
	}
}