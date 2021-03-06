<?php ?>
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
	color:#95067f
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
	background-color:#f4f2f4;
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
	background:#f3eaf2;
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
	background:#ecdaea;
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
	background:#f3eaf2
}
.tips>.tips-content>p {
	color:#95067f;
	margin:0
}
.ul-sort-listview {
	margin:0;
	padding:0
}
.sort-item-rec {
	background:#f3eaf2;
	-webkit-box-shadow:0 1px 2px rgba(0,0,0,0.2);
	list-style:none;
	width:100%;
	height:100%;
	min-height:80px;
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
.sort-item-rec:active {
	-webkit-box-shadow:none
}
.sort-item-rec>img {
	height:auto;
	width:100%;
	display:block;
	position:relative
}
.sort-item-rec>.mainarea-in-list {
	height:auto;
	display:block;
	position:absolute;
	width:100%;
	bottom:0;
	padding:8px 10px;
	background:rgba(125,14,108,.8)
}
.sort-item-rec>.mainarea-in-list>h4,.sort-item-rec>.mainarea-in-list>h5 {
	width:100%;
	position:relative;
	text-overflow:ellipsis;
	white-space:nowrap;
	overflow:hidden;
	color:#fff
}
.sort-item-rec>.mainarea-in-list>h5 {
	margin-top:5px
}
.sort-item-rec>.p-aside {
	padding:2px 10px;
	position:absolute;
	width:auto;
	height:auto;
	top:0;
	left:auto;
	right:0;
	bottom:auto;
	color:#fff;
	background:rgba(216,14,95,.85)
}
.sort-item-nor {
	background:#f3eaf2;
	-webkit-box-shadow:0 1px 2px rgba(0,0,0,0.2);
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
.sort-item-nor:active {
	background:#c56bb8;
	-webkit-box-shadow:none
}
.sort-item-nor>img {
	float:left;
	position:relative;
	height:80px;
	width:80px;
	border-width:0;
	white-space:nowrap;
	overflow:hidden
}
.sort-item-nor>.list-item-icon {
	height:20px;
	margin:30px 0;
	width:20px;
	float:right;
	position:relative;
	display:inline-block;
	border-width:0;
	white-space:nowrap;
	overflow:hidden;
	margin-right:20px
}
.sort-item-nor>.mainarea-in-list {
	height:100%;
	display:block;
	width:auto;
	margin-left:80px;
	margin-right:40px;
	padding:20px 10px
}
.sort-item-nor>.mainarea-in-list>h4,.sort-item-nor>.mainarea-in-list>h5 {
	text-align:left;
	position:relative;
	text-overflow:ellipsis;
	-webkit-background-clip:padding;
	background-clip:padding-box;
	white-space:nowrap;
	overflow:hidden
}
.sort-item-nor>.mainarea-in-list>h5 {
	margin-top:5px
}
.ul-product-listview {
	margin:0;
	padding:0;
	margin-bottom:10px
}
.product-item {
	display:block;
	position:relative;
	padding:0;
	width:100%;
	height:100%;
	margin:0;
	background:#f3eaf2;
	box-shadow:0 0 2px rgba(0,0,0,0.2);
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.2);
	list-style:none;
	border:0;
	overflow:hidden;
	white-space:nowrap;
	text-align:left
}
.product-item-showdesc {
	-webkit-box-shadow:0 1px 2px rgba(0,0,0,0.25) inset;
	background-color:#fffafe
}
.product-item>.mainarea-in-list {
	position:relative;
	display:block;
	margin-right:100px;
	padding:18px 0;
	padding-left:10px;
	height:100%;
	width:auto
}
.product-item>.mainarea-in-list>h4,.product-item>.mainarea-in-list>h5 {
	text-align:left;
	margin:0;
	width:auto;
	position:relative;
	text-overflow:ellipsis;
	-webkit-background-clip:padding;
	background-clip:padding-box;
	white-space:nowrap;
	overflow:hidden
}
.product-item>.mainarea-in-list>h5 {
	margin-top:8px
}
.product-item>.showmore {
	width:100%;
	margin:0;
	padding-bottom:2px;
	position:absolute;
	text-align:center;
	top:auto;
	bottom:0;
	opacity:.45;
	font-size:8px;
	border:0
}
.product-item>.p-aside {
	max-width:85px;
	padding:1px 5px;
	margin:0;
	position:absolute;
	top:0;
	bottom:auto;
	color:#fff;
	background:#95067f;
	-webkit-box-shadow:1px .5px 1px rgba(0,0,0,0.45);
	border:0
}
.product-item>.btnarea-in-list {
	float:right;
	height:100%;
	padding:20px 0;
	padding-right:10px;
	position:relative;
	display:inline-block
}
.product-item>.tipsarea-in-list {
	display:inline-block;
	float:right;
	height:100%;
	padding:30px 10px;
	position:relative;
	border:0
}
.product-item>.descarea-in-list {
	padding:0;
	position:relative;
	min-height:100px;
	width:100%;
	height:auto;
	display:block;
	overflow:hidden;
	border-width:0;
	white-space:nowrap
}
.product-item>.descarea-in-list>img {
	height:auto;
	width:100%;
	display:block;
	position:relative
}
.product-item>.descarea-in-list>p {
	padding:10px 10px;
	height:auto;
	width:auto;
	left:0;
	right:0;
	bottom:0;
	margin:0;
	color:#fff;
	background:rgba(196,110,182,0.8);
	position:absolute;
	text-overflow:ellipsis;
	white-space:normal;
	overflow:hidden;
	display:block
}
#product-first-item,#order-first-item {
	height:100%;
	min-height:0;
	background:#ecdaea
}
#product-first-item>.mainarea-in-list {
	margin-right:0
}
#product-first-item>.mainarea-in-list>h5 {
	white-space:pre-wrap
}
#product-first-item>.mainarea-in-list,#order-first-item>.mainarea-in-list {
	padding:8px 10px
}
#product-first-item>.mainarea-in-list>h5,#order-first-item>.mainarea-in-list>h5 {
	margin-top:4px
}
#order-first-item>.btnarea-in-list {
	padding:8px
}
.ul-orderhistory-listview{
	margin:0;
	padding:0;
	margin-bottom:10px
}
.orderhistory-item {
	display:block;
	position:relative;
	padding:0;
	width:100%;
	height:100%;
	margin:0;
	background:#f3eaf2;
	box-shadow:0 0 2px rgba(0,0,0,0.2);
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.2);
	list-style:none;
	border:0;
	overflow:hidden;
	white-space:nowrap;
	text-align:left
}
.orderhistory-item>.mainarea-in-list {
	position:relative;
	display:block;
	margin-right:10px;
	padding:18px 0;
	padding-left:10px;
	height:100%;
	width:auto
}
.orderhistory-item>.mainarea-in-list>h4,.orderhistory-item>.mainarea-in-list>h5 {
	text-align:left;
	margin:0;
	width:auto;
	position:relative;
	text-overflow:ellipsis;
	-webkit-background-clip:padding;
	background-clip:padding-box;
	white-space:nowrap;
	overflow:hidden
}
.orderhistory-item>.mainarea-in-list>h5 {
	margin-top:8px;
	white-space:pre-wrap
}
.orderhistory-item>.btnarea-in-list {
	float:right;
	height:100%;
	padding:20px 0;
	padding-right:10px;
	position:relative;
	display:inline-block
}
#orderhistory-first-item {
	height:100%;
	min-height:0;
	background:#ecdaea
}
#orderhistory-first-item>.mainarea-in-list {
	margin-right: 100px;
	padding:8px 10px
}
#orderhistory-first-item>.mainarea-in-list>h5 {
	margin-top:4px;
	white-space:pre-wrap
}
#orderhistory-first-item>.btnarea-in-list {
	padding:8px
}
.ul-personal-list{

}
.single-btnarea {
	width:100%;
	margin-bottom:10px
}
.btn-icon {
	position:relative;
	display:block;
	margin:0;
	padding:0;
	width:50px;
	border:0;
	background:#f7ecf5;
	-webkit-box-shadow:0 0 1px rgba(80,0,70,0.4)
}
.btn-icon:active {
	background:#c56bb8;
	-webkit-box-shadow:none;
	transition:all 100ms ease-out;
	-webkit-transition:all 100ms ease-out
}
.btn-icon:disabled {
	background:#fbf3fa;
	-webkit-box-shadow:none
}
.btn-icon>.img-in-btn {
	height:20px;
	width:20px;
	vertical-align:text-top;
	display:inline-block;
	position:relative
}
.btn-icon-text {
	display:block;
	margin:0;
	padding:0;
	width:auto;
	position:relative;
	border:0;
	background:#f7ecf5;
	-webkit-box-shadow:0 0 1px rgba(80,0,70,0.4)
}
.btn-icon-text:active {
	background:#c56bb8;
	-webkit-box-shadow:none;
	transition:all 100ms ease-out;
	-webkit-transition:all 100ms ease-out
}
.btn-icon-text:disabled {
	background:#fbf3fa;
	-webkit-box-shadow:none
}
.btn-icon-text>.text-in-btn {
	font-size:16px;
	margin-left:10px;
	margin-right:10px;
	line-height:20px;
	vertical-align:text-top;
	display:inline-block;
	font-weight:700;
	color:#95067f
}
.btn-icon-text>.img-in-btn {
	margin-right:10px;
	height:20px;
	width:20px;
	vertical-align:text-top;
	display:inline-block;
	position:relative
}
.btn-highlight {
	background-color:#f8ccec
}
.btn-icon.button-minus,.btn-icon.button-plus {
	height:40px;
	width:45px
}
#pay-btn {
	height:100%;
	width:auto;
	-webkit-box-shadow:-1px 0 2px rgba(80,0,70,0.4)
}
#pay-btn:active,#pay-btn:disabled {
	-webkit-box-shadow:none
}
#back-btn,#sort-btn {
	height:100%
}
#havelook-btn,#clear-btn{
	height:40px
}
#makecall-btn{
	line-height: 40px;
}
#reload-btn,#newstart-btn,#submit-btn,#loadmore-btn {
	height:50px;
	width:100%
}
#phonebind {
	background:#ecdaea;
	margin-bottom:10px;
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.2)
}
#phonebind>header {
	padding:8px 10px
}
#phonebind>header>h4 {
	color:#95067f
}
#phonebind-content {
	padding:8px 10px;
	background:#f3eaf2;
	display:block
}
#phonebind-content>.label-main {
	margin-top:10px;
	margin-bottom:3px;
	margin-right:20px;
	display:inline-block;
	vertical-align:text-top
}
#phonebind-content>.label-tips {
	color:#b00;
	margin-bottom:3px;
	margin-top:10px;
	display:inline-block;
	vertical-align:text-top
}
#phonebind-content>.label-desc {
	width:100%;
	margin-top:3px;
	display:block;
	opacity:.45
}
#phonebind-content>input {
	width:100%;
	padding:0;
	margin:0;
	height:30px;
	font-size:16px;
	font-family:"Arial",Helvetica,sans-serif;
	border:0
}
#phonebind-content>select {
	width:100%;
	padding:0;
	margin:0;
	height:30px;
	font-size:16px;
	font-family:"Arial",Helvetica,sans-serif;
	background-color:#fff;
	border:0;
	-webkit-appearance:none
}
#phonebind-content>textarea {
	width:100%;
	padding:0;
	margin:0;
	height:70px;
	resize:none;
	white-space:pre-wrap;
	font-size:16px;
	font-family:"Arial",Helvetica,sans-serif;
	border:0
}
.toast {
	background:rgba(0,0,0,0.5);
	width:auto;
	padding:0 2.5%;
	left:-105%;
	min-width:100px;
	max-width:100%;
	min-height:40px;
	color:#fff;
	line-height:40px;
	text-align:center;
	position:fixed;
	float:center;
	top:30px;
	z-index:999999;
	font-weight:bold
}
.toast-hide {
	left:-105%;
	-webkit-transition:all 200ms ease;
	-webkit-transition-property:left
}
.toast-show {
	left:0;
	-webkit-transition:all 200ms ease;
	-webkit-transition-property:left
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
	background-color:#f4f2f4
}
#error {
	z-index:1000
}
#loading {
	position:fixed;
	top:0;
	opacity:.75
}
#loading>#loadingtips {
	position:absolute;
	padding:0;
	margin:0;
	font-size:16px;
	padding-top:75px;
	top:40%
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
.bar {
	width:50px;
	height:50px;
	top:50%;
	-webkit-border-radius:7.5em;
	border-radius:7.5em;
	margin-right:2px;
	position:absolute;
	-webkit-box-shadow:0 3px 16px rgba(149,6,127,0.35)
}
#loadingshapedark {
	background:#f3eaf2;
	top:40%;
	z-index:1
}
#loadingshapelight {
	background:#95067f;
	top:40%;
	z-index:0
}
</style>
<title>个人中心</title>
<div id="warning" style="display:none"><h4>您当前处于非验证状态，页面仅供浏览。如需使用预约服务，敬请关注微信号:iFruits_cn。</h4></div>
<div  id="maincontent" class="content-frame" style="display:none;">
	<ul id="personal-list" class="ul-personal-listview">
		<li class="personal-item" id="personal-first-item">
		</li>
		<li class="personal-item" id="memcard-bind-item">
		<div class="list-item-icon" style="background:url(/weChat/img/wap/myicon.png) no-repeat -160px 0;"></div>
		<div class="mainarea-in-list"><h4>商家会员卡</h4><h5>请您绑定商家会员卡</h5></div>
		</li>
	</ul>
</div>
<div id="bindcontent" class="content-frame" style="display:none;">
	<section id="phonebind">
		<header>
			<h4>请输入您的手机号</h4>
		</header>
		<div id="phonebind-content">
		</div>
	</section>
</div>
<div id="vipactive" class="content-frame" style="display:none;">
</div>
<div  id="ordercontent" class="content-frame" style="display:none;">
	<ul id='orderhistory-list' class="ul-orderhistory-listview">
		<li class="orderhistory-item" id="orderhistory-first-item">
			<div class="btnarea-in-list">
			</div>
			<div class="mainarea-in-list">
				<h4>历史订单</h4>
				<h5>如有任何疑问，请直接联系商家</h5>
			</div>
		</li>
	</ul>
	<div class="single-btnarea" id="loadmore-btnarea">
	</div>
</div>
<div  id="error" class="up-frame" style="display:none;">
	<section class="tips" id='tips-error'>
		<header>
			<h4 id="tips-title-error"> >_<~ 出错了</h4>
		</header>
		<div class="tips-content"><p id="tips-errordesc-error"></p>	
		</div>
	</section>	
	<div class="single-btnarea" id="reload-btnarea">
		<button class="btn-icon-text" id="reload-btn">
		    <p class="text-in-btn">重试</p>
		</button>
	</div>
</div>

<div id="loading" class="up-frame" style="display:none;">
	<div id="loadingshapedark" class="bar"></div>
	<div id="loadingshapelight" class="bar"></div>
	<p id="loadingtips"></p>
</div> 
<footer id="personalcenterfooter" style="display: none;">
<div class="left-footer"></div>
<div class="center-footer"></div>
<div class="right-footer"></div>
</footer>
<div class="toast" id="mytoast"></div>
</body>

<script type="text/javascript">
//baseid
var sellerid="<?php echo $sellerid?>";
var openid="<?php echo $openid?>";
var identitykey=null;
//错误常量
var WRONGURL='wrongurl';
var WRONGKEY='wrongkey';
var WRONGDATA='wrongdata';
//基地址
var BASEURL='/weChat/';
var BASEURLICON='/weChat/img/wap/myicon-personalcenter.png';

var MYJQUERY='http://libs.baidu.com/jquery/1.9.0/jquery.min.js';
var MYOWNJS='<?php echo Yii::app()->baseUrl?>/js/wap/history1.1.js';

var AJAXFORRESULT='/weChat/index.php/wap/order/getPartOrders';

//全局运行变量
var isverified=true;
var myloading=null;

window.onload = function(){
	if(verifybaseid()){
		if(!verifyidentitykey()){
			callwrongkey();
		}
		jsinit();
	}else{
		callerror(WRONGURL);
	}	
}
		

//初始化js
function jsinit(){
	var isjqueryready=false;
	var isownjsready=false;
	startloading('正在初始化');
	jsloader.load(MYJQUERY , function () {
		readytogo(MYJQUERY);
	});
	jsloader.load(MYOWNJS, function () {
    	readytogo(MYOWNJS);
	});
	setTimeout(function(){
		if(isjqueryready==false||isownjsready==false){
	    	stoploading();
			callerror(WRONGINIT,jsinit);
		}
	},15000);
	//等待script全部载入
	function readytogo(ready){
    	switch(ready){
    		case MYJQUERY:
    		isjqueryready=true;
    		break;
    		case MYOWNJS:
    		isownjsready=true;
    		break;
    	}
    	if(isjqueryready==true&&isownjsready==true){
	    	stoploading();
			firstinit();
    	}
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

//工具 异步载入js
var jsloader = function(){
	var scripts = {}; 
	function getScript(url){
		var script = scripts[url];
		if (!script){
            script = {loaded:false, funs:[]};
            scripts[url] = script;
		}    
		return script;
	}
	function run(script){
		var funs = script.funs,
		            len = funs.length,
		            i = 0;
		for (; i<len; i++){
		var fun = funs.pop();
		            fun();
	    }
	}
	function add(script, url){
		var scriptdom = document.createElement('script');
        scriptdom.type = 'text/javascript';
        scriptdom.loaded = false;
        scriptdom.src = url;
        scriptdom.onload = function(){
            scriptdom.loaded = true;
            run(script);
            scriptdom.onload = scriptdom.onreadystatechange = null;
        };
	    document.getElementsByTagName('head')[0].appendChild(scriptdom);
	    
	}
	return {
		load: function(url){
			var arg = arguments,
		    len = arg.length,
		    i = 1,
		    script = getScript(url),
		    loaded = script.loaded;
			for (; i<len; i++){
				var fun = arg[i];
				if (typeof fun === 'function'){
					if (loaded) {
				        fun();
				    }else{
				        script.funs.push(fun);
				    }
				}
			}
            add(script, url);
		}
	};
}();

//工具 loading动画
function loadinganimation(){
	var wwidth=0;
	var wheight=0;
	var tipswidth=0;
	var barwidth = 50;
	var movex = 54;
	var animation=null;
	var darkleft=true;
	this.firstinit=function(){
		document.getElementById('loading').style.display='block';
		wwidth = document.getElementById('loading').clientWidth;
		wheight = document.getElementById('loading').clientHeight;
		document.getElementById('loadingshapedark').style.left = (wwidth/2) - barwidth-2+'px';
		document.getElementById('loadingshapelight').style.left = (wwidth/2)+4+'px';
		
	}
    function moveleft(el) {
        document.getElementById(el).style.zIndex=-100;
        document.getElementById(el).style.left = (wwidth/2) - barwidth-2+'px';
        document.getElementById(el).style.webkitTransition='all 800ms ease-out';
        document.getElementById(el).style.webkitTransitionProperty="left";
        document.getElementById(el).style.transition='all 800ms ease-out';
        document.getElementById(el).style.transitionProperty="left";
    }

    function moveright(el) {
        document.getElementById(el).style.zIndex=100;
        document.getElementById(el).style.left = (wwidth/2)+4+'px';
        document.getElementById(el).style.webkitTransition='all 800ms ease-out';
        document.getElementById(el).style.webkitTransitionProperty="left";
        document.getElementById(el).style.transition='all 800ms ease-out';
        document.getElementById(el).style.transitionProperty="left";
    }
    this.isloading=function(){
    	return animation==null;
    }
    this.playanimation=function(){
    	if(darkleft){
	        moveleft('loadingshapelight');
	       	moveright('loadingshapedark');
    	}else{
    		moveleft('loadingshapedark');
	        moveright('loadingshapelight');
    	}
    	darkleft=!darkleft;
    }
    this.start=function(content,tips){
		document.getElementById('loading').style.display='block';
		document.getElementById('loadingtips').innerHTML=tips;
		tipswidth=document.getElementById('loadingtips').clientWidth;
		document.getElementById('loadingtips').style.left=(wwidth/2)-(tipswidth/2)+'px';
		content.playanimation();
		if(animation==null){
	    	animation=window.setInterval(function(){content.playanimation();},800);
	    }
    }
   	this.stop=function(){
		document.getElementById('loading').style.display='none';
    	animation=window.clearInterval(animation);
    	animation=null;
    }
}

//全局唤起loading
startloading=function(tips){
	if(myloading==null){
		myloading=new loadinganimation();
		myloading.firstinit();
	}
	myloading.start(myloading,tips==null?'载入中…':tips);
}

stoploading=function(){
	myloading.stop();
}

//全局唤起出错
function callerror(error, method){
	switch(error){
		case WRONGURL:
		document.getElementById('error').style.display='block';
		document.getElementById('tips-error').style.display='block';
		document.getElementById('reload-btnarea').style.display='none';
		document.getElementById('tips-errordesc-error').innerHTML='检测到您的url异常，请确保从微信公众账号访问哦~';
		break;
		case WRONGKEY:
		document.getElementById('error').style.display='block';
		document.getElementById('tips-error').style.display='block';
		document.getElementById('reload-btnarea').style.display='none';
		document.getElementById('tips-errordesc-error').innerHTML='身份校验失败，请按如下步骤操作：<br />1.返回公众账号对话页面，回复关键字得到“菜单”<br />2.从“菜单”中点击“在线点单”';
		break;
		case WRONGDATA:
		document.getElementById('error').style.display='block';
		document.getElementById('tips-error').style.display='block';
		document.getElementById('reload-btnarea').style.display='block';
		document.getElementById('tips-errordesc-error').innerHTML='数据载入错误，请检查您当前的网络环境，并重试';
		document.getElementById("reload-btn").onclick=function(){
			document.getElementById('error').style.display='none';
			method();
		};
		break;
		case WRONGINIT:
		document.getElementById('error').style.display='block';
		document.getElementById('tips-error').style.display='block';
		document.getElementById('reload-btnarea').style.display='block';
		document.getElementById('tips-errordesc-error').innerHTML='初始化失败，请检查您当前的网络环境，并重试';
		document.getElementById("reload-btn").onclick=function(){
			document.getElementById('error').style.display='none';
			method();
		};
		break;
	}

}

//key错误
function callwrongkey(){
	isverified=false;
	document.getElementById('warning').style.display = 'block';
}
</script>
</body>
