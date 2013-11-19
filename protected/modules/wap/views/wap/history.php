<?php ?>
<style>
body {
	background-color: #f7f3f6;  font-size: 16px;
	font-weight: normal;
	font-family: "Arial", Helvetica, sans-serif;
	padding:  0;
	margin: 0;
}
img{
	padding:0;
	border:0;
}
a:link; a:visited; a:hover; a:active{
	text-decoration: none;
	color: inherit;
	font-weight: normal;
}
*{
	-webkit-touch-callout: none;
	-webkit-text-size-adjust: none;
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	/*-webkit-user-select: none;
		user-select: none;*/
}
a:focus,input:focus,textarea:focus{
	-webkit-tap-highlight-color:rgba(0,0,0,0);
}
p{
	font-size: 13px;
}
.content-frame{
	margin:0 0.5%;
	width: 99%;
	position: relative;
}
.tips{
	background: #ecdaea;
	margin: 1% 1%;
	margin-top: 10px;
	-webkit-box-shadow: 0 0px 3px rgba(0,0,0,0.2);
	box-shadow: 0 0px 3px rgba(0,0,0,0.2);
	border: none;
}
.tips header{
	padding: 8px 10px;
}
.tips h4, .tips-content p{
	color: #95067f;
	margin: 0;
}
.tips-content{
	padding: 8px 10px;
	background: #f3eaf2;
	-webkit-box-shadow: 0 0px 1px rgba(0,0,0,0.2);
	box-shadow: 0 0px 1px rgba(0,0,0,0.2);
}
.btn-icon-text{
	padding: 0;
	display: block;
	margin: 0;
	text-align:center;
	position: relative;
	border:0;
	background: #ecdaea;
}
.btn-icon-text:active{
	background: #fbe6f8;
	box-shadow: none;
}
.btn-icon-text:disabled{
	background: #fbe6f8;
	box-shadow: none;
}
.btn-icon-text>.text-in-btn{
	font-size: 16px;
	margin-left: 10px;
	margin-right: 8px;
	padding-top: 1px;
	margin-top:auto;
	margin-bottom:auto;
	vertical-align: text-top;
	display: inline-block;
	font-weight: 700;
	color: #95067f;
}
.btn-icon-text>.img-in-btn{
	margin-right: 10px;
	height: 20px;
	width: 20px;
	vertical-align: text-top;
	display: inline-block;
}

#loadmore-btn,#reload-btn{
width: 98%;
margin: 1%;
display: block;
height: 50px;
margin-top: 10px;
border:none;
box-shadow: -0.5px 0 1px rgba(0,0,0,0.2);
}
#loadmore-btn:active,#reload-btn:active{
box-shadow: none;
}
#loadmore-btn:disabled,#reload-btn:disabled{
box-shadow: none;
}

.toast{
	background:rgba(0,0,0,0.5);
	width: auto;
	padding: 0 5px;
	left:-150px;
	min-width:100px;
	min-height:40px;
	color:#fff;
	line-height:40px;
	text-align:center;
	position:fixed;
	float: center;
	top:30px;
	z-index:999999;
	font-weight:bold;
}


#loading{
top:0;
color: #95067f;
background-color: rgba(247,243,246,0.75);
}
#loading>#loadingtips{
position: absolute;
padding: 0;
margin: 0;
font-size: 16px;
padding-top: 75px;
top: 40%;
}

#error{
z-index: 1000;
background-color: #f7f3f6;
}

#tips-orders{
position: relative;
width: 98%;
margin: 1%;
margin-top: 10px;
top: 0;
}

.up-frame{
	position: fixed;
	height: 100%;
	width: 100%;
	left:0;
	right: 0;
	top:0;
	bottom: 0;
	z-index: 200;

}

.bar {
	width: 50px;
	height: 50px;
	top:50%;
	-webkit-border-radius: 7.5em;
	-moz-border-radius: 7.5em;
	border-radius: 7.5em;
	margin-right: 2px;
	position: absolute;
	-webkit-box-shadow: 0 3px 16px rgba(149,6,127,0.35);
	box-shadow: 0 3px 16px rgba(149,6,127,0.35);
}
#loadingshapedark {
background: #f3eaf2;
top: 40%;
z-index: 1;
}
#loadingshapelight {
background: #95067f;
top: 40%;
z-index: 0;
}

</style>
<div  id="order" class="content-frame" style="display:none;">
<section class="tips" id='tips-orders'><header><h4 id="tips-title-orders">历史订单</h4></header></section>
<section class="single-btnarea" id="newstart-btnarea">
</section>
</div>
<div  id="error" class="up-frame" style="display:none;">
<section class="tips" id='tips-error'>
<header><h4 id="tips-title-error"> >_&lt;~ 出错了</h4></header>
<div class="tips-content"><p id="tips-errordesc-error"></p>
</div>
</section>
<button class="btn-icon-text" id="reload-btn">
<p class="text-in-btn">重试</p>
</button>
</div>

<div id="loading" class="up-frame" style="display:none;">
<div id="loadingshapedark" class="bar"></div>
<div id="loadingshapelight" class="bar"></div>
<p id="loadingtips"></p>
</div>
<footer class="footer-order" id="mainfooter" style="display:none;">
</footer>
<div class="toast" id="mytoast" style="display: none;"></div>
</body>

<script type="text/javascript">
//fake
var sellerid="<?php echo $sellerid;?>";
var openid="<?php echo $openid; ?>";
var identitykey='123123123123123123123';
// //baseid
// var sellerid=-1;
// var openid=null;
// var firstsortid=-1;
// var identitykey=null;
//错误常量
var WRONGURL='wrongurl';
var WRONGKEY='wrongkey';
var WRONGDATA='wrongdata';
//基地址
var BASEURL='/weChat/';
var BASEURLICON='/weChat/img/wap/myicon.png';

var MYJQUERY='http://libs.baidu.com/jquery/1.9.0/jquery.min.js';
var MYOWNJS='<?php echo Yii::app()->baseUrl?>/js/wap/history.js';

var AJAXFORRESULT='/weChat/index.php/wap/order/getPartOrders';

//运行变量
var myanimation=null;
var isloading=false;

var isjqueryready=false;
var isownjsready=false;

window.onload = function(){
	startloading('正在初始化');

	//fake
	jsloader.load(MYJQUERY , function () {
		readytogo(MYJQUERY);
	});
	jsloader.load(MYOWNJS, function () {
		readytogo(MYOWNJS);
	});
	// if(baseidinit()){
	// 	if(verifyidentitykey()){
	// 		jsloader.load(MYJQUERY , function () {
		// 			readytogo(MYJQUERY);
		// 		});
		// 		jsloader.load(MYOWNJS, function () {
		// 	    	readytogo(MYOWNJS);
		// 		});
		// 	}else{
		// 		callerror(WRONGKEY);
		// 	}
		// }else{
		// 	callerror(WRONGURL);
		// }
			
	}

	//基础id获取及url校验
	function baseidinit(){
		var baseidarray=window.location.href.substr(window.location.href.indexOf('index/')+6).split('?');
		if(baseidarray.length!=2||baseidarray[0]==null){
			return false;
		}else{
			sellerid=baseidarray[0];
			otheridarray=baseidarray[1].split('&');
			if(otheridarray.length!=2){
				return false;
			}else {
				var openidarray=otheridarray[0].split('=');
				if(openidarray[0]!='openid'){
					return false;
				}else{
					openid=openidarray[1];
					return true;
				}
			}
		}
	}

	//身份key校验
	function verifyidentitykey(){

		if(identitykey==null){
			if (localStorage) {
				if(localStorage.getItem(sellerid+'-'+openid+'-'+'identitykey')){
					identitykey=localStorage.getItem(sellerid+'-'+openid+'-'+'identitykey');
				}
			}else{
				var cookiestring=document.cookie.split(';');
				for(var i=0;i<cookiestring.length;i++){
					var cookieitem=cookiestring[i].split('&=');
					if(cookieitem[0]==sellerid+'-'+openid+'-'+'identitykey'){
						identitykey=cookieitem[1];
					}
				}
			}
		}else{
			if (localStorage) {
				var identitykeystring=identitykey;
				localStorage.setItem(sellerid+'-'+openid+'-'+'identitykey',identitykeystring);
			}else{
				var cookiestring=sellerid+'-'+openid+'-'+'identitykey'+'&='+identitykey;
				var date=new Date();
				date.setTime(date.getTime()+30*24*3600*1000);
				cookiestring=cookiestring+'; expires='+date.toGMTString();
				document.cookie=cookiestring;
			}
		}

		if(identitykey==null||identitykey==''){
			return false;
		}else{
			return true;
		}
	}

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

	//工具 异步载入js
	var jsloader = function(){
		var scripts = {};
		function getScript(url){
			var script = scripts[url];
			if (!script){
				script = {loaded:false, funs:[]};
				scripts[url] = script;
				add(script, url);
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
		this.moveleft=function(el) {
			document.getElementById(el).style.zIndex=-100;
			document.getElementById(el).style.left = (wwidth/2) - barwidth-2+'px';
			document.getElementById(el).style.webkitTransition='all 800ms ease-out';
			document.getElementById(el).style.webkitTransitionProperty="left";
		}

		this.moveright=function(el) {
			document.getElementById(el).style.zIndex=100;
			document.getElementById(el).style.left = (wwidth/2)+4+'px';
			document.getElementById(el).style.webkitTransition='all 800ms ease-out';
			document.getElementById(el).style.webkitTransitionProperty="left";
		}
		this.playanimation=function(){
			if(darkleft){
				this.moveleft('loadingshapelight');
				this.moveright('loadingshapedark');
			}else{
				this.moveleft('loadingshapedark');
				this.moveright('loadingshapelight');
			}
			darkleft=!darkleft;
		}
		this.start=function(tips){
			document.getElementById('loading').style.display='block';
			document.getElementById('loadingtips').innerHTML=tips;
			tipswidth=document.getElementById('loadingtips').clientWidth;
			document.getElementById('loadingtips').style.left=(wwidth/2)-(tipswidth/2)+'px';
			if(animation==null){
				animation=window.setInterval('myanimation.playanimation()',800);
			}
		}
		this.stop=function(){
			document.getElementById('loading').style.display='none';
			animation=window.clearInterval(animation);
			animation=null;
		}
	}



	//全局唤起loading
	function startloading(tips){
		if(myanimation==null){
			myanimation=new loadinganimation();
			myanimation.firstinit();
		}
		myanimation.start(tips==null?'载入中…':tips);
		isloading=true;
	}

	function stoploading(){
		myanimation.stop();
		isloading=false;
	}

	//全局唤起出错
	function callerror(error, method){
		if(isloading){
			stoploading();
		}
		switch(error){
			case WRONGURL:
				document.getElementById('error').style.display='block';
				document.getElementById('tips-error').style.display='block';
				document.getElementById('reload-btn').style.display='none';
				document.getElementById('tips-errordesc-error').innerHTML='检测到您的url异常，请确保从微信公众账号访问哦~';
				break;
			case WRONGKEY:
				document.getElementById('error').style.display='block';
				document.getElementById('tips-error').style.display='block';
				document.getElementById('reload-btn').style.display='none';
				document.getElementById('tips-errordesc-error').innerHTML='身份校验失败，如果在本设备上初次操作，请先使用在线点单功能。操作步骤如下：<br />1.返回公众账号对话页面，回复关键字得到“菜单”<br />2.从“菜单”中点击“在线点单”进入点单页面，完成一份订单';
				break;
			case WRONGDATA:
				document.getElementById('error').style.display='block';
				document.getElementById('tips-error').style.display='block';
				document.getElementById('reload-btn').style.display='block';
				document.getElementById('tips-errordesc-error').innerHTML='数据载入错误，请检查您当前的网络环境，并重试';
				document.getElementById("reload-btn").onclick=function(){
					document.getElementById('error').style.display='none';
					method();
				};
				break;
		}

	}
	</script>