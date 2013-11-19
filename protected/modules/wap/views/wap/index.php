<?php ?>
<style>
	body {  
    background-color: #f4f2f4;  font-size: 16px;  
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
footer{
	position: fixed;
	bottom: 0;
	z-index: 100;
	-webkit-box-shadow: 0 0px 3px rgba(0,0,0,0.2);
	box-shadow: 0 0px 3px rgba(0,0,0,0.2);
}
p{
	font-size: 13px;
}

li:hover{
}

.content-frame{
	margin:0 0.5%;
	width: 99%;
	margin-left: 3px;
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
	}
	#tips-announcement{
		font-size: 14px;
		line-height:20px;
	}




.btn-icon{
	position: relative;
	text-align:center;
	display: block;
	margin: 0;
	padding: 0;
	background: #f3eaf2; 
}
.btn-icon:active{
	background: #c56bb8;
	box-shadow: none;
}
.btn-icon:disabled{
	background: #fbe6f8;
	box-shadow: none;
}
.btn-icon>.img-in-btn{
	height: 20px;
	width: 20px;
	vertical-align: text-top;
	display: inline-block;
	position: relative;
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
	background: #c56bb8;
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






.ul-listview{
	margin: 1%;
	margin-top: 10px;
	padding: 0;
}

	.ul-sort-recommend li,.ul-sort-normal li{
		background: #f3eaf2;
		-webkit-box-shadow: 0 0px 3px rgba(0,0,0,0.2);
		box-shadow: 0 0px 3px rgba(0,0,0,0.2);
		list-style: none;
		width: 100%;
		height: 100%;
		min-height: 80px;
		left: -1px;
		bottom: -1px;
		border: none;
		margin-top: 10px;
		display: block;
		position: relative;
		overflow: hidden;
		white-space: nowrap;
		text-align: left;
	}


	.ul-sort-recommend li:active,.ul-sort-normal li:active{
		background: #c56bb8;
		box-shadow: none;
		-webkit-box-shadow: none;
	}

	.sort-item-rec{
		padding: 0;
		position: relative;
		width: 100%;
		height: 100%;
		display: block;
		overflow: hidden;
		border-width: 0;
		white-space: nowrap;
	}

	.sort-item-rec:active{
		background: #fbe6f8;
		box-shadow: none;
		-webkit-box-shadow: none;
	}
	.ul-sort-recommend img{
		height: auto;
		width: 100%;
		display: block;
		position: relative;
	}
	.ul-sort-recommend h4,.ul-sort-recommend p{
		padding:0 10px;
		height: 25px;
		width: auto;
		left: 0;
		right: 0;
		background: rgba(125,14,108,.8);
		position: absolute;
		text-overflow: ellipsis;
		white-space: nowrap;
		overflow: hidden;
		color: #fff;
		margin: 0;
		display: block;
	}
	.ul-sort-recommend h4{
		padding-top: 8px;
		bottom: 25px;
	}
	.ul-sort-recommend p{
		bottom: 0;
		color: #f7e1f4;
	}
	.ul-sort-recommend .p-aside{
		padding: 2px 10px;
		width: auto;
		height: auto;
		top: 0;
		left: auto;
		right: 0;
		bottom: auto;
		color: #ffffff;
		background: rgba(216,14,95,.85);
	}

	.sort-item-nor{
		padding: 10px 10px;
		padding-left: 90px;
		width: 100%;
		position: absolute;
		border-width: 0;
	}
	.sort-item-nor:active{
		background: #c56bb8;
		box-shadow: none;
		-webkit-box-shadow: none;
	}
	.ul-sort-normal img{
		top: 0;
		left: 0;
		float: left;
		position: absolute;
		height: 80px;
		width: 80px;
		border-width: 0;
		white-space: nowrap;
		overflow: hidden;
	}
	.ul-sort-normal .list-item-icon{
		top: 30px;
		left: auto;
		right:14px;
		height: 20px;
		width: 20px;
		float: right;
		position: absolute;
		border-width: 0;
		white-space: nowrap;
		overflow: hidden;
		margin-right: 100px;

	}
	.ul-sort-normal h4,.ul-sort-normal p{
		text-align: left;
		margin: 8px 0;
		width: auto;
		margin-right: 130px;
		position: relative;
		text-overflow: ellipsis;
		-webkit-background-clip: padding;
		background-clip: padding-box;
		white-space: nowrap;
		overflow: hidden;
		color: #95067f;
	}
	.ul-sort-normal p{
		color: #cb6bbc;
	}




	.ul-product li{
		background: #f3eaf2;
		-webkit-box-shadow: 0 0px 1px rgba(0,0,0,0.2);
		box-shadow: 0 0px 1px rgba(0,0,0,0.2);
		list-style: none;
		width: 100%;
		height: 100%;
		min-height: 70px;
		left: -1px;
		bottom: -1px;
		border: none;
		display: block;
		position: relative;
		overflow: hidden;
		white-space: nowrap;
		text-align: left;
		border-top-width: 0;
	}
	#product-first-item{
		min-height: 55px;
		height: 55px;
		background: #ecdaea;
	}

	#product-first-item>p{
		color:#cb6bbc;
	}

	.product-item{

		display: block;
		position: relative;
		padding: 10px 0;
		width: 100%;
		height: 100%;
		margin: 0;
		border-width: 0;
	}
	.product-item-showdesc{
		-webkit-box-shadow: 10px 10px 10px rgba(0,0,0,0.45);
		box-shadow: 0 0px 3px rgba(0,0,0,0.2);
		background-color: #fffafe;
	}

	.product-item-desc{
		padding: 0;
		position: relative;
		min-height: 35px;
		width: 100%;
		height: auto;
		display: block;
		overflow: hidden;
		border-width: 0;
		white-space: nowrap;
	}
	.product-item-desc img{
		height: auto;
		width: 100%;
		display: block;
		position: relative;
	}
	.product-item-desc p{
		padding:10px 10px;
		height:auto;
		width: auto;
		left: 0;
		right: 0;
		bottom: 0;
		margin: 0;
		color: #f7e1f4;
		background: rgba(196, 110, 182, 0.8);
		position: absolute;
		text-overflow: ellipsis;
		white-space: nowrap;
		overflow: hidden;
		display: block;
	}


	.ul-product .head-title,.ul-product .head-desc{

		text-align: left;
		margin: 0;
		width: auto;
		margin-left: 10px;
		position: relative;
		text-overflow: ellipsis;
		-webkit-background-clip: padding;
		background-clip: padding-box;
		white-space: nowrap;
		overflow: hidden;
		color: #95067f;
	}

	.ul-product .head-title{
		margin-top: 7.5px;
	}
	.ul-product .head-desc{
		margin-top: 3px;
	}
	.ul-product .p-aside2{
		max-width: 85px;
		padding: 1px 5px;
		margin: 0;
		height: 15px;
		float: center;
		position: absolute;
		top: 0;
		bottom: auto;
		/* Custom styling. */
		color: #ffffff;
		background: #95067f;
		box-shadow: 1px 0.5px 1px rgba(0,0,0,0.45);
		border: 0;
	}


	#order-first-item{
		min-height: 55px;
		height: 55px;
		background: #ecdaea;
	}

	#order-first-item>p{
		color:#cb6bbc;
	}


	#havelook-btn,#clear-btn{
		height: 40px;
		width: auto;
		position: absolute;
		top:7.5px;
		right: 10px;
		border:none;	
		-webkit-box-shadow: 0 0 1px rgba(80,0,70,0.4);
		box-shadow: 0 0 1px rgba(80,0,70,0.4);
	}
	#havelook-btn:active,#clear-btn:active{
		box-shadow: none;
	}
	#havelook-btn:disabled,#clear-btn:disabled{
		box-shadow: none;
	}




	.button-group-inlist{
		position: absolute;
		right:10px;
		height: 45px;
		top:12.5px;
	}
	.button-minus{
		height: 100%;
		width: 45px;
		border:none;	
		-webkit-box-shadow: 0 0 1px rgba(80,0,70,0.4);
		box-shadow: -1 0 1px rgba(80,0,70,0.4);
	}
	.button-plus{
		height: 100%;
		width: 45px;
		border:none;
		margin-left: 5px;	
		-webkit-box-shadow: 0 0 1px rgba(80,0,70,0.4);
		box-shadow: 1 0 1px rgba(80,0,70,0.4);
	}
	.button-minus:disabled,.button-plus:disabled{
		background: #fbf3fa;
		box-shadow: none;
	}
	.tipsarea-in-list{
		position: absolute;
		right:10px;
		height: 40px;
		top:15px;
		text-align:center;
		border:none;	
		box-shadow: none;
	}
	.tipsarea-in-list>.tips-in-list{
		font-size: 14px;
		margin: 13px 8px;
		font-weight: 700;
		color: #95067f;
	}


.footer-order{
	height: 50px;
	width: 100%;
	border: none;
	background: #f3eaf2;
	display: block;
}

.title-in-footer{
	position: absolute;
	left: 60px;
	color:#95067f;
	font-size: 16px;
	font-weight: 700;
}







#back-btn{
	height: 50px;
	width: 50px;
	left: 0;
	float: left;
	border:0;
	box-shadow: 0.5px 0 1px rgba(0,0,0,0.2);
}
#back-btn:active{
	box-shadow: none;
}
#sort-btn{
	height: 50px;
	width: 50px;
	left: 0;
	float: left;
	border:0;
	border-right:none;
	box-shadow: 0.5px 0 1px rgba(0,0,0,0.2);
}
#sort-btn:active{
	box-shadow: none;
}


#pay-btn{
	height: 50px;
	width: auto;
	right: 0;
	float: right;
	border-left:none;
	-webkit-box-shadow: -1px 0 2px rgba(80,0,70,0.4);
	box-shadow: -1px 0 2px rgba(80,0,70,0.4);
}
.pay-btn-highlight{
	background-color: #f8ccec;
}
#pay-btn:active{
	box-shadow: none;
}
#pay-btn:disabled{
	box-shadow: none;
}

#personalinfo{
	background: #ecdaea;
	text-shadow: 0 0 0 #ffffff;
	margin: 1% 1%;
	margin-top: 10px;
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.2);
	box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}
#personalinfo>header{
	border: none;
	padding: 8px 10px;
	}
	#personalinfo>header>h4{
		margin: 0;
		color: #95067f;
	}

#personalinfo-content{
	padding: 10px 10px;
	background: #f3eaf2;
	display: block;
}

#personalinfo-content .mylabel-main{
	font-size: 13px;
	color: #95067f;
	width: 100%;
	left:0;
	right:0;
	margin-bottom: 3px;
}
#personalinfo-content .mylabel-tips{
	font-size: 13px;
	color: #bb0000;
	margin-bottom: 3px;
	padding-left: 20px;
}
#personalinfo-content .mylabel-desc{
	font-size: 13px;
	width: 100%;
	display: block;
	color: #cb6bbc;
	margin-bottom: 10px;
}
#personalinfo-content input{
	width: 100%;
	padding: 0;
	margin: 0;
	height: 30px;
	font-size: 16px;
	margin-bottom: 10px;
	border:none;
}
#personalinfo-content select{
	width: 100%;
	padding: 0;
	margin: 0;
	height: 40px;
	margin-bottom: 3px;
	font-size: 16px;
	border:none;
	cursor: pointer;
	-webkit-appearance: none;
}
#personalinfo-content textarea{
	width: 100%;
	padding: 0;
	margin: 0;
	rows:3;
	height: 60px;
	font-size: 16px;
	margin-bottom: 10px;
	font-family: "Arial", Helvetica, sans-serif;
	border:none;
}
.select-area-desc{
	margin-top: 3px;
	width: 100%;
	font-size: 13px;
	color: #95067f;
	margin-bottom: 10px;

}


#reload-btn,#newstart-btn,#submit-btn{
	width: 98%;
	margin: 1%;
	display: block;
	height: 50px;
	margin-top: 10px;
	border:none;	
	box-shadow: -0.5px 0 1px rgba(0,0,0,0.2);
}
#reload-btn:active,#newstart-btn:active,#submit-btn:active{
	box-shadow: none;
}
#reload-btn:disabled,#newstart-btn:disabled,#submit-btn:disabled{
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
	background-color: rgba(244,242,244,0.75);
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
	background-color: #f4f2f4;
}

#paysuccess{
	margin-bottom: 0;
	background-color: #f4f2f4;
}

#tips-ordersuccess{
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
<div id="sortcontent"  class="content-frame" style="display: none;">
	<section class="tips" id='tips-sortcontent'><header><h4 id="tips-title-sort"></h4></header><div class="tips-content"><p id="tips-announcement-sort"></p></div></section>
	<ul id="sort-recommendlist" class="ul-listview ul-sort-recommend"></ul>
	<ul id="sort-normallist" class="ul-listview ul-sort-normal"></ul>
</div>
<div id="productcontent" class="content-frame" style="display: none;">
	<ul id="product-list" class="ul-listview ul-product">
    </ul>	 
</div>
<div id="paycontent" class="content-frame" style="display: none;" >
    <ul id="order-list" class="ul-listview ul-product">
    </ul>
    <section class="tips" id='tips-ordercontent'><header><h4 id="tips-title-order">外送须知</h4></header><div class="tips-content"><p id="tips-announcement-order"></p></div></section>
   	<section id="personalinfo"><header><h4>收货信息（*必填）</h4></header><div id="personalinfo-content" ></div>
    </section>
    <section class="single-btnarea" id="submit-btnarea">
	</section>
</div>
<div  id="paysuccess" class="up-frame" style="display:none;">
	<section class="tips" id='tips-ordersuccess'><header><h4 id="tips-title-ordersuccess">恭喜您，下单成功！</h4></header><div class="tips-content"><p id="tips-orderdesc-ordersuccess"></p></div></section>
	<section class="single-btnarea" id="newstart-btnarea">
	</section>
</div>
<div  id="error" class="up-frame" style="display:none;">
	<section class="tips" id='tips-error'>
		<header><h4 id="tips-title-error"> >_<~ 出错了</h4></header>
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
<script type="text/javascript">

	//baseid
	var sellerid=-1;
	var openid=null;
	var firstsortid=-1;
	var identitykey=null;
	//错误常量
	var WRONGURL='wrongurl';
	var WRONGKEY='wrongkey';
	var WRONGDATA='wrongdata';
	//基地址
	var BASEURL='/weChat/';
	var BASEURLICON='/weChat/img/wap/myicon.png';

	var MYJQUERY='http://libs.baidu.com/jquery/1.9.0/jquery.min.js';
	var MYOWNJS='<?php echo Yii::app()->baseUrl?>/js/wap/wechat.js';

	var AJAXFORDATA='<?php echo Yii::app()->createUrl('wap/wap/getData'); ?>';
	var AJAXFORSUBMIT='<?php echo Yii::app()->createUrl('wap/order/order'); ?>';
	var AJAXFORRESULT='<?php echo Yii::app()->createUrl('wap/order/getPartOrders'); ?>';

	//运行变量
	var myanimation=null;
	var isloading=false;

	var isjqueryready=false;
	var isownjsready=false;

	window.onload = function(){
		startloading('正在初始化');
		if(baseidinit()){
			if(verifyidentitykey()){
				jsloader.load(MYJQUERY , function () {
					readytogo(MYJQUERY);
				});
				jsloader.load(MYOWNJS, function () {
			    	readytogo(MYOWNJS);
				});
			}else{
				callerror(WRONGKEY);
			}
		}else{
			callerror(WRONGURL);
		}
			
	}

	//基础id获取及url校验
	function baseidinit(){
		var baseidarray=window.location.href.substr(window.location.href.indexOf('index/')+6).split('?');
		if(baseidarray.length!=2||baseidarray[0]==null){
			return false;
		}else{
			sellerid=baseidarray[0];
			otheridarray=baseidarray[1].split('&');
			if(otheridarray.length<2||otheridarray.length>3){
				return false;
			}else if(otheridarray.length==2){
				var openidarray=otheridarray[0].split('=');
				if(openidarray[0]!='openid'){
					return false;
				}else{
					openid=openidarray[1];
					return true;
				}
			}else{
				var openidarray=otheridarray[0].split('=');
				var sortidarray=otheridarray[2].split('=');
				if(openidarray[0]!='openid'||sortidarray[0]!='sortid'){
					return false;
				}else{
					openid=openidarray[1];
					sortid=sortidarray[1];
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

		alert(identitykey);
		if(identitykey==null){
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
    		document.getElementById('tips-errordesc-error').innerHTML='身份校验失败，请按如下步骤操作：<br />1.返回公众账号对话页面，回复关键字得到“菜单”<br />2.从“菜单”中点击“在线点单”';
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