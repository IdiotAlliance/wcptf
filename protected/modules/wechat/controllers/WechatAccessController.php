<?php
class WechatAcccessController extends Controller {
	/**
	 * 微信的回调接口
	 */
	public function actionWechatAccess() {
		if ($this->request->isPostRequest) {
			// 处理消息
			$this->handleMsg();
			
		} else if ($this->request->isGetRequest) {
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
				echo echostr . "fuck you tencent";
			}
		}
	}
	
	/**
	 * 处理post消息的函数
	 */
	public function handleMsg() {
		// get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
	
		// extract post data
		if (! empty ( $postStr )) {
	
			$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$msgType = $postObj->MsgType;
			$keyword = trim ( $postObj->Content );
			$time = time();
			$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
						</xml>";
			
			if (! empty ( $keyword )) {
				$msgType = "text";
				$contentStr = "Welcome to wechat world!";
				$resultStr = sprintf ( $textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr );
				echo $resultStr;
			} else {
				echo "Input something...";
			}
		} else {
			echo "";
			exit();
		}
	}
	
	public function handleEvent(){
		
	}
}