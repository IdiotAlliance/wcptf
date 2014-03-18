<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=100%, initial-scale=1.0, user-scalable=no">
	<meta content="telephone=no" name="format-detection">
</head>

<body ontouchstart="return true;">
<style>
* {
	-webkit-touch-callout:none;
	-webkit-text-size-adjust:none;
	-webkit-tap-highlight-color:rgba(0,0,0,0);
	-webkit-user-select:none;
	-webkit-box-sizing:border-box
}
a:link;
	a:visited;
	a:hover;
	a:active {
	text-decoration:none;
	color:inherit;
	font-weight:inherit
}
a,input,button,li {
	-ms-touch-action:none!important
}
h4,h5,p,label {
	color:#505050
}
h4 {
	font-size:16px;
	margin:0;
	font-weight:bold
}
p,label {
	font-size:13px;
	margin:0;
	font-weight:normal
}
h5 {
	opacity:.75;
	font-size:13px;
	margin:0;
	font-weight:normal
}
input,textarea {
	-webkit-user-select:auto
}
body {
	background-color:#fdfdfd;
	font-size:16px;
	font-weight:normal;
	font-family:"Arial",Helvetica,sans-serif;
	padding:0;
	margin:0
}
.body-with-header {
	padding-bottom:0;
	padding-top:50px
}
.body-with-footer {
	padding-bottom:50px;
	padding-top:0
}
footer {
	position:fixed;
	z-index:100;
	height:auto;
	width:100%;
	border:0;
	background:#f8f8f8;
	display:block;
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.2)
}
.footer-to-top {
	top:0;
	bottom:auto
}
.footer-to-bottom {
	top:auto;
	bottom:0
}
.left-footer {
	float:left;
	height:100%;
	width:auto;
	display:inline-block;
	z-index:1
}
.center-footer {
	height:100%;
	padding:8px 10px;
	width:auto;
	display:inline-block;
	z-index:-1
}
.right-footer {
	float:right;
	height:100%;
	width:auto;
	display:inline-block;
	z-index:1
}
#mainfooter {
	height:50px
}
#paytitle {
	position:relative;
	line-height:34px;
	float:left
}
.content-frame {
	margin:0;
	margin-top:10px;
	width:100%;
	position:relative
}
.tips {
	background:#e9e9e9;
	width:100%;
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.2);
	border:0;
	margin:0;
	margin-bottom:10px
}
.tips>header {
	padding:8px 10px
}
.tips>header>h5 {
	margin-top:3px
}
.tips>.tips-content {
	padding:8px 10px;
	background:#f8f8f8
}
.tips>.tips-content>p {
	color:#505050;
	margin:0
}
.ul-sort-listview {
	margin:0;
	padding:0
}
.store-item-nor {
	background:#f8f8f8;
	-webkit-box-shadow:0 1px 2px rgba(0,0,0,0.2) ;
	list-style:none;
	width:100%;
	height:80px;
	padding:0;
	border:0;
	margin:0;
	margin-bottom:10px;
	display:block;
	position:relative;
	overflow:hidden;
	white-space:nowrap;
	text-align:left
}
.store-item-nor:active {
	background:#c1c1c1;
	-webkit-box-shadow:none
}
.store-item-nor>img {
	float:left;
	height: 80px;
	width:auto;
	border-width:0;
	white-space:nowrap;
	overflow:hidden
	z-index:-1;
}
.store-item-nor>.list-item-tips {
	height:20px;
	margin:30px 0;
	float:right;
	position:relative;
	display:inline-block;
	border-width:0;
	white-space:nowrap;
	overflow:hidden;
	margin-right:10px
}
.store-item-nor>.list-item-icon {
	height:20px;
	width: 20px;
	margin:30px 0;
	float:right;
	position:relative;
	display:inline-block;
	border-width:0;
	white-space:nowrap;
	overflow:hidden;
	margin-right:10px
}
.store-item-nor>.mainarea-in-list {
	position: absolute;
	height:100%;
	display:block;
	width:100%;
	margin-left:80px;
	margin-right:40px;
	padding:12px 10px;
	padding-right: 120px;
	background:linear-gradient(to right, rgba(245, 245, 245, 0.75) -40px, #f8f8f8 30px, rgba(245, 245, 245, 0.75) 100%);
	-webkit-box-shadow:-3px 0px 2px rgba(0,0,0,0.2);

}
}
.store-item-nor>.mainarea-in-list>h4 {
	width: 100%;
	text-align:left;
	position:relative;
	text-overflow:ellipsis;
	-webkit-background-clip:padding;
	background-clip:padding-box;
	white-space:nowrap;
	overflow:hidden
}
.store-item-nor>.mainarea-in-list>h5 {
	width: 100%;
	text-align:left;
	position:relative;
	text-overflow:ellipsis;
	-webkit-background-clip:padding;
	background-clip:padding-box;
	white-space:nowrap;
	overflow:hidden;
	margin-top:3px
}
.up-frame {
	position:absolute;
	height:100%;
	width:100%;
	padding-top:10px;
	left:0;
	right:0;
	top:0;
	bottom:0;
	z-index:200;
	background-color:#f9f9f9
}
#error {
	z-index:1000
}
#warning {
	background:#e7322c;
	margin-top:10px;
	padding:8px 10px;
	color:#fff;
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.2);
	border:0
}
#warning>h4 {
	margin:0;
	padding:0;
	color:#fff;
	font-size:14px
}
.title{
	width: 100%;
	height: auto;
	padding: 10px 10px;
	margin-bottom: 10px;
	background: #ebebeb;
}
</style>
<title>店铺列表</title>
<div id="warning" style="display:none"><h4 id="warning-desc"></h4></div>
<div id="storelistcontent" class="content-frame">
</div>
<div id="error" class="up-frame" style="display: none;">
	<section class="tips" id='tips-error'>
		<header>
			<h4 id="tips-title-error">>_<~ 出错了</h4>
		</header>
		<div class="tips-content">
			<p id="tips-errordesc-error"></p>
		</div>
	</section>
	<div class="single-btnarea" id="reload-btnarea">
		<button class="btn-icon-text" id="reload-btn">
			<span class="text-in-btn">重试</span>
		</button>
	</div>
</div>
<div id="loading" class="up-frame" style="display: none;">
	<div id="loadingshapedark" class="bar"></div>
	<div id="loadingshapelight" class="bar"></div>
	<p id="loadingtips"></p>
</div>
<div class="toast" id="mytoast"></div>
<script type="text/javascript">

    //fake
	var sellerid=<?php echo $sellerId?>;
	var openid="<?php echo $openId?>";
	var identitykey="<?php echo $key?>";
	var publicID="<?php echo $wxid?>";
	//baseid
	// var sellerid="<?php echo $sellerId?>";
	// var openid="<?php echo $openId?>";
	// var identitykey="<?php echo ($key?$key:'');?>";
	
	//错误常量
	var WRONGURL='wrongurl';
	var WRONGKEY='wrongkey';
	var WRONGDATA='wrongdata';
	var WRONGINIT='wronginit';

	//fake
	var BASEURLICON='<?php echo Yii::app()->request->hostInfo?>/weChat/img/wap/myicon-storelist.png';
	// var BASEURL='/weChat/';
	// var BASEURLICON='/weChat/img/wap/myicon-storelist.png';

	//全局运行变量
	var isverified=true;

	window.onload = function(){
		if(verifybaseid()){
			if(!verifyidentitykey()){
				callwrongkey();
			}
			filllist();
		}else{
			callerror();
		}
	}

	//基础id获取及url校验
	function verifybaseid(){
		if(openid==null||openid==''||sellerid==null||sellerid==''){
			return false;
		}else{
			return true;
		}
	}

	//身份key校验
	function verifyidentitykey(){
		function writetocookie(){
			var cookiestring=sellerid+'-'+openid+'-'+'identitykey'+'&='+identitykey;
			var date=new Date(); 
			date.setTime(date.getTime()+30*24*3600*1000); 
			cookiestring=cookiestring+'; expires='+date.toGMTString()+';path=/'; 
			document.cookie=cookiestring; 
		}
		function readfromcookie(){
			var cookiestring=document.cookie.split('; ');
			var iskeyready=false;
			for(var i=0;i<cookiestring.length;i++){
				var cookieitem=cookiestring[i].split('&=');
				if(cookieitem[0]==sellerid+'-'+openid+'-'+'identitykey'){
					identitykey=cookieitem[1];
					iskeyready=true;
				}
			} 
			return iskeyready;
		}	
		function writetolocalstorage(){
			if (localStorage) {
				localStorage.setItem(sellerid+'-'+openid+'-'+'identitykey',identitykey);
			}
		}
		function readfromlocalstorage(){
			var iskeyready=false;
			if (localStorage) {
				if(localStorage.getItem(sellerid+'-'+openid+'-'+'identitykey')){
					identitykey=localStorage.getItem(sellerid+'-'+openid+'-'+'identitykey');
					var iskeyready=true;
				}
			}
			return iskeyready;
		}
		if(identitykey==null||identitykey==''){
			if(!readfromcookie()&&!readfromlocalstorage()){
				return false;
			}else{
				return true;
			}
		}else{
			writetocookie();
			writetolocalstorage();
			return true;
		}
	}

	function filllist(){
		var mystorelist=datasource.storelist;
		var totalphonebind=0;
		var totalvipbind=0;
		for(var i=0;i<mystorelist.length;i++){
			mystore=mystorelist[i];
			if(mystore.phonebind){
				totalphonebind++;
			}
			if(mystore.vipbind){
				totalvipbind++;
			}
		}
		insert='';
		insert+='<div class="title" id="storestitle">'+
		'<h4>请选择店铺</h4>'+
		'<h5>共'+mystorelist.length+'家店铺</h5>'+
		'</div>';
		for(var i=0;i<mystorelist.length;i++){
			mystore=mystorelist[i];
			insert+='<a class="store-item-nor" href="'+mystore.url+'">'+
			'<img src='+mystore.logo+'>'+
			'<div class="mainarea-in-list">'+
			'<h4>'+mystore.storename+'</h4>'+
			'<h5>最新订单：'+mystore.lastorder+'</h5>'+
			'<h5>'+showbind(mystore)+'</h5>'+
			'</div>'+
			'<div class="list-item-icon" style="background:url('+BASEURLICON+')"></div>'+
			'</a>';

		}
		document.getElementById("storelistcontent").innerHTML=insert;

		function showbind(mystore){
			bindinsert='';
			if(mystore.phonebind&&mystore.vipbind){
				bindinsert+='已绑定手机及会员卡';
			}else if(mystore.phonebind&&!mystore.vipbind){
				bindinsert+='已绑定手机，未绑定会员卡';
			}else if(!mystore.phonebind&&mystore.vipbind){
				bindinsert+='未绑定手机，已绑定会员卡';
			}else{
				bindinsert+='未绑定手机，未绑定会员卡';
			}
			return bindinsert;
		}
	}

	//fakedatasource
    var datasource=eval('(' + '<?php echo $pstores?>' + ')');
	//storestatus分true和false，当且仅当店铺处于正常状态并在营业时间内，值为true。

	//全局唤起出错
	function callerror(){
		document.getElementById('error').style.display='block';
		document.getElementById('tips-error').style.display='block';
		document.getElementById('reload-btnarea').style.display='none';
		document.getElementById('tips-errordesc-error').innerHTML='检测到您的url异常，请确保从微信公众账号访问哦~';

	}


	//key错误
	function callwrongkey(){
		isverified=false;
		document.getElementById("warning-desc").innerHTML='您当前处于非验证状态，页面仅供浏览。如需使用本页面服务，敬请关注微信号:'+publicID;
		document.getElementById('warning').style.display = 'block';
	}
	
</script>
</body>
</html>