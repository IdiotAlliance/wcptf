<?php ?>
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
<div id="json_data"><?php echo $json_data;?></div>
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
	var HOST = "http://localhost/weChat/"
	var BASEURL='/weChat/';
	var BASEURLICON='weChat/img/myicon.png';

	var MYJQUERY='http://libs.baidu.com/jquery/1.9.0/jquery.min.js';
	var MYOWNJS='<?php echo Yii::app()->baseUrl?>/js/wap/wechat.js';

	var AJAXFORDATA=  HOST + 'index.php/mobile/order/order';
	var AJAXFORSUBMIT= HOST + 'index.php/mobile/order/order';
	var AJAXFORRESULT= HOST + 'index.php/mobile/order/getOrders';

	//运行变量
	var myanimate=null;
	var isloading=false;

	var isjqueryready=false;
	var isownjsready=false;

	window.onload = function(){
		startLoading('正在初始化');
		if(mybaseidinit()){
			if(verifyidentitykey()){
				JSLoader.load(MYJQUERY , function () {
					callready(MYJQUERY);
				});
				JSLoader.load(MYOWNJS, function () {
			    	callready(MYOWNJS);
				});
			}else{
				callerror(WRONGKEY);
			}
		}else{
			callerror(WRONGURL);
		}
			
	}

    function startLoading(tips){
    	if(myanimate==null){
    		myanimate=new nojqanimate();
    		myanimate.firstinit();
    	}
    	myanimate.start(tips==null?'载入中…':tips);
    	isloading=true;
    }

    function stopLoading(){
    	myanimate.stop();
    	isloading=false;
    }

    function callerror(error, method){
    	if(isloading){
    		stopLoading();
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

    function callready(ready){
    	switch(ready){
    		case MYJQUERY:
    		isjqueryready=true;
    		break;
    		case MYOWNJS:
    		isownjsready=true;
    		break;
    	}
    	if(isjqueryready&&isownjsready){
	    	stopLoading();
			firstinit();
    	}
    }


	//基础id获取
	function mybaseidinit(){
		var mybaseidarray=window.location.href.substr(window.location.href.indexOf('index/')+6).split('?');
		if(mybaseidarray.length!=2||mybaseidarray[0]==null){
			return false;
		}else{
			sellerid=mybaseidarray[0];
			otheridarray=mybaseidarray[1].split('&');
			if(otheridarray.length<2||otheridarray.length>3){
				return false;
			}else if(otheridarray.length==2){
				var myopenidarray=otheridarray[0].split('=');
				if(myopenidarray[0]!='openid'){
					return false;
				}else{
					openid=myopenidarray[1];
					return true;
				}
			}else{
				var myopenidarray=otheridarray[0].split('=');
				var mysortidarray=otheridarray[2].split('=');
				if(myopenidarray[0]!='openid'||mysortidarray[0]!='sortid'){
					return false;
				}else{
					openid=myopenidarray[1];
					sortid=mysortidarray[1];
					return true;
				}
			}
		}
	}

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
		if(identitykey==null){
			return false;
		}else{
			return true;
		}

	}


    //loading动画
	function nojqanimate(){
		var nojqwwidth=0;
		var nojqwheight=0;
		var nojqtipswidth=0;
		var nojqdarkwidth = 50;
		var nojqmovex = 54;
		var nojqplayAnimate=null;
		var nojqdarkleft=true;
		this.firstinit=function(){
			document.getElementById('loading').style.display='block';
			nojqwwidth = document.getElementById('loading').clientWidth;
			nojqwheight = document.getElementById('loading').clientHeight;
			document.getElementById('loadingshapedark').style.left = (nojqwwidth/2) - nojqdarkwidth-2+'px';
			document.getElementById('loadingshapelight').style.left = (nojqwwidth/2)+4+'px';
			
		}
	    this.moveleft=function(el) {
	        document.getElementById(el).style.zIndex=-100;
	        document.getElementById(el).style.left = (nojqwwidth/2) - nojqdarkwidth-2+'px';
	        document.getElementById(el).style.transition='all 800ms ease-out';
	        document.getElementById(el).style.transitionProperty="left";
	    }

	    this.moveright=function(el) {
	        document.getElementById(el).style.zIndex=100;
	        document.getElementById(el).style.left = (nojqwwidth/2)+4+'px';
	        document.getElementById(el).style.transition='all 800ms ease-out';
	        document.getElementById(el).style.transitionProperty="left";
	    }
	    this.playAnimation=function(){
	    	if(nojqdarkleft){
		        this.moveleft('loadingshapelight');
		       this.moveright('loadingshapedark');
	    	}else{
	    		this.moveleft('loadingshapedark');
		        this.moveright('loadingshapelight');
	    	}
	    	nojqdarkleft=!nojqdarkleft;
	    }
	    this.start=function(tips){
			document.getElementById('loading').style.display='block';
			document.getElementById('loadingtips').innerHTML=tips;
			nojqtipswidth=document.getElementById('loadingtips').clientWidth;
			document.getElementById('loadingtips').style.left=(nojqwwidth/2)-(nojqtipswidth/2)+'px';
			if(nojqplayAnimate==null){
		    	nojqplayAnimate=window.setInterval('myanimate.playAnimation()',800);
		    }
	    }
	    this.stop=function(){
			document.getElementById('loading').style.display='none';
	    	nojqplayAnimate=window.clearInterval(nojqplayAnimate);
	    	nojqplayAnimate=null;
	    }
	}

	//异步载入js
	var JSLoader = function(){
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
</script>