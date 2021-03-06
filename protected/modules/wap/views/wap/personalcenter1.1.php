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
	background-color:#f9f9f9;
	font-size:16px;
	font-weight:normal;
	font-family:"Arial",Helvetica,sans-serif;
	padding:0;
	margin:0
}
footer{
	position: fixed;
	bottom: 0;
	background-color: rgba(255,255,255,0.8);
	width: 100%;
}
.body-with-header {
	padding-bottom:0;
	padding-top:50px
}
.body-with-footer {
	padding-bottom:50px;
	padding-top:0
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
	z-index:1;
	text-align: center;
	padding-top: 6px;
	padding-left: 5px;
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
	background:#f5f5f5
}
.tips>.tips-content>p {
	color:#505050;
	margin:0
}
.ul-sort-listview {
	margin:0;
	padding:0
}
.sort-item-rec {
	background:#f5f5f5;
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
	background:#505050;
	opacity:0.75;
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
.catalog-item {
	background:#f5f5f5;
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
.catalog-item:active {
	background:#c1c1c1;
	-webkit-box-shadow:none
}
.catalog-item>.list-item-img {
	float:left;
	position:relative;
	margin: 24px 10px;
	height:32px;
	width:32px;
	border-width:0;
	white-space:nowrap;
	overflow:hidden
}
.catalog-item>.list-item-icon {
	height:20px;
	margin:30px 0;
	width:20px;
	float:right;
	position:relative;
	display:inline-block;
	border-width:0;
	white-space:nowrap;
	overflow:hidden;
	margin-right:10px
}
.catalog-item>.mainarea-in-list {
	height:100%;
	display:block;
	width:auto;
	margin-left:45px;
	margin-right:40px;
	padding:20px 10px
}
.catalog-item>.mainarea-in-list>h4,.catalog-item>.mainarea-in-list>h5 {
	text-align:left;
	position:relative;
	text-overflow:ellipsis;
	-webkit-background-clip:padding;
	background-clip:padding-box;
	white-space:nowrap;
	overflow:hidden
}
.catalog-item>.mainarea-in-list>h5 {
	margin-top:5px
}
.ul-catalog-listview {
	margin:0;
	padding:0;
	margin-bottom:10px
}
.catalog-item-back {
	display:block;
	position:relative;
	padding:0;
	width:100%;
	height:100%;
	margin:0;
	background:#f5f5f5;
	box-shadow:0 0 2px rgba(0,0,0,0.2);
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.2);
	list-style:none;
	border:0;
	overflow:hidden;
	white-space:nowrap;
	text-align:left
}
.catalog-item-back-showdesc {
	-webkit-box-shadow:0 1px 2px rgba(0,0,0,0.25) inset;
	background-color:#fffafe
}
.catalog-item-back>.mainarea-in-list {
	position:relative;
	display:block;
	margin-right:100px;
	padding:18px 0;
	padding-left:10px;
	height:100%;
	width:auto
}
.catalog-item-back>.mainarea-in-list>h4,.catalog-item-back>.mainarea-in-list>h5 {
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
.catalog-item-back>.mainarea-in-list>h5 {
	margin-top:8px
}
.catalog-item-back>.showmore {
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
.catalog-item-back>.p-aside {
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
.catalog-item-back>.btnarea-in-list {
	float:right;
	height:100%;
	padding:20px 0;
	padding-right:10px;
	position:relative;
	display:inline-block
}
.catalog-item-back>.tipsarea-in-list {
	display:inline-block;
	float:right;
	height:100%;
	padding:30px 10px;
	position:relative;
	border:0
}
.catalog-item-back>.descarea-in-list {
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
.catalog-item-back>.descarea-in-list>img {
	height:auto;
	width:100%;
	display:block;
	position:relative
}
.catalog-item-back>.descarea-in-list>p {
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
#catalog-first-item,#order-first-item {
	height:100%;
	min-height:0;
	background:#e9e9e9
}
#catalog-first-item>.mainarea-in-list {
	margin-right:0
}
#catalog-first-item>.mainarea-in-list>h5 {
	white-space:pre-wrap
}
#catalog-first-item>.mainarea-in-list,#order-first-item>.mainarea-in-list {
	padding:8px 10px
}
#catalog-first-item>.mainarea-in-list>h5,#order-first-item>.mainarea-in-list>h5 {
	margin-top:4px
}
#order-first-item>.btnarea-in-list {
	padding:8px
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
	background:#f1f1f1;
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.4)
}
.btn-icon:active {
	background:#c1c1c1;
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
	background:#f1f1f1;
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.4)
}
.btn-icon-text:active {
	background:#c1c1c1;
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
	color:#505050
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
	-webkit-box-shadow:-1px 0 2px rgba(0,0,0,0.4)
}
#pay-btn:active,#pay-btn:disabled {
	-webkit-box-shadow:none
}
#back-btn,#sort-btn {
	height:100%
}
#havelook-btn,#clear-btn {
	height:40px
}
#reload-btn,#newstart-btn,#submit-btn,#phonebindnext-btn,#phonebindsubmit-btn{
	height:50px;
	width:100%
}
.info {
	background:#e9e9e9;
	margin-bottom:10px;
	-webkit-box-shadow:0 0 1px rgba(0,0,0,0.2)
}
.info>header {
	padding:8px 10px
}
.info>header>h4 {
	color:#505050
}
.info-content {
	padding:8px 10px;
	background:#f5f5f5;
	display:block
}
.form-content{
	margin-top:10px;
	margin-bottom: 10px;
}
.form-content>.label-main {
	margin-bottom:3px;
	margin-right:20px;
	display:inline-block;
	vertical-align:text-top
}
.form-content>.label-tips {
	color:#b00;
	margin-bottom:3px;
	display:inline-block;
	vertical-align:text-top
}
.form-content>.label-desc {
	width:100%;
	margin-top:3px;
	display:block;
	opacity:.45
}
.form-content>input {
	width:100%;
	padding:0;
	margin:0;
	height:30px;
	font-size:16px;
	font-family:"Arial",Helvetica,sans-serif;
	border:0
}
#checkcodeinput{
	padding:0;
	margin:0;
	height:30px;
	font-size:16px;
	font-family:"Arial",Helvetica,sans-serif;
	border:0
}
.form-content>select {
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
.form-content>textarea {
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
.verifycode-area{
	width:100%;
	height: 50px;
	padding:0;
	margin:0;
	display: block;
}
.verifycode-area>input{
	display: inline;
	width:48%;
	padding:0;
	margin:0;
	height:30px;
	font-size:16px;
	float: left;
	vertical-align: text-top;
	font-family:"Arial",Helvetica,sans-serif;
	border:0
}
.verifycode-area>img{
	display: inline;
	width:48%;
	padding:0;
	margin:0;
	float: right;
	height:30px;
	vertical-align: text-top;
	border:0
}
.verifycode-area>.label-desc{
	display: block;
	float: right;
	margin-top:3px;
	opacity:.45
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
	background-color:#f9f9f9
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

.code   {   
    background-image:url(code.jpg);   
    font-family:Arial;   
    font-style:italic;   
    color:#ca0000;   
    border:0;   
    padding:2px 3px;   
    letter-spacing:3px;   
    font-weight:bolder;   
    width: 80px;
	display: inline;
	margin:0;
	height:30px;
	float: right;
	vertical-align: text-top;
}   
.unchanged   {   
    border:0;   
}  


.title{
	width: 100%;
	height: auto;
	padding: 10px 10px;
	margin-bottom: 10px;
	background: #ebebeb;
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
	background:#c1c1c1;
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
	background:#ebebeb
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

#makecall-btn{
	line-height: 40px;
}

</style>
<title>个人中心</title>
<div id="warning" style="display:none"><h4 id="warning-desc"></h4></div>
<div id="maincontent" class="content-frame" style="display:none">
	<div class="title" id="storestitle">
		<h4>个人中心</h4>
		<h5></h5>
	</div>
	<ul id="main-list" class="ul-catalog-listview">
		<li class="catalog-item" id="historyorder" onclick="showordercontent()">
			<div class="list-item-img"></div>
			<div class="list-item-icon"></div>
			<div class="mainarea-in-list"><h4>历史订单</h4><h5 id="historyorder-desc"></h5></div>
		</li>
		<li class="catalog-item" id="phonebind" onclick="showbindphone()">
			<div class="list-item-img"></div>
			<div class="list-item-icon"></div>
			<div class="mainarea-in-list">
				<h4>绑定手机</h4>
				<?php 
				if($phone){?>
				<h5>您已绑定号码：<?php echo $phone?></h5>
				<?php 
					}else{
				?>
				<h5 id="phonebind-desc">您当前尚未绑定手机</h5>
				<?php }?>
			</div>
		</li>
		<li class="catalog-item" id="cardbind" onclick="showbindcard()">
			<div class="list-item-img"></div>
			<div class="list-item-icon"></div>
			<div class="mainarea-in-list"><h4>绑定会员卡</h4><h5 id="cardbind-desc">你当前尚未绑定会员卡</h5></div>
		</li>
	</ul>
</div>

<div id="ordercontent" class="content-frame" style="display:none">
	<ul id='orderhistory-list' class="ul-orderhistory-listview">
		<li class="orderhistory-item" id="orderhistory-first-item">
			<div class="btnarea-in-list">
			</div>
			<div class="mainarea-in-list">
				<h4>历史订单</h4>
				<h5>如有任何疑问，请联系商家</h5>
			</div>
		</li>
	</ul>
	<div class="single-btnarea" id="loadmore-btnarea">
	</div> 
</div>
<div id="phonebinding" class="content-frame" style="display:none">
	<h4>请输入要绑定的手机号码</h4>
	<input type="text" id="phone_binding_number" class="large_text">
	<div id="phone_binding_step2">
		<h4>请输入您收到的验证码</h4>
		<div>
			<input type="text" id="phone_binding_code" class="middle_text">
			<button id="phone_binding_resend"></button>
		</div>
	</div>
	<button id="phone_binding_next">确认</button>
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
<div class="backkit-hide" id="backkit" style="display:none">
<span class="backtolist" id="backtolist" >
<h4>返回列表</h4>
</span>
<span class="tiny" id="tiny"></span>
</div>
<div class="foo" style="height: 30px;"></div>
<footer id="personalcenterfooter" class="footer-to-bottom" style="display: none;">
<div class="left-footer">
	<div onclick = "showmaincontent()" id="back-btn" class="btn-icon">
		<span class="img-in-btn"></span>
	</div>
</div>
<div class="center-footer"><h4 id="personaltitle"></h4></div>
<div class="right-footer"></div>
</footer>

<script type="text/javascript">
    //fake
	var storeid="<?php echo $storeid?>";
	var sellerid="<?php echo $sellerId?>";
	var openid="<?php echo $openId?>";
	var isfromfather=(('<?php echo $referer?>')=='1');
	//fake
	var identitykey='<?php echo $key?>';
	var publicID='<?php echo $wxname?>';
	// //baseid
	// var sellerid="<?php echo $sellerId?>";
	// var openid="<?php echo $openId?>";
	// var identitykey="<?php echo ($key?$key:'');?>";
	
	//错误常量
	var WRONGURL='wrongurl';
	var WRONGKEY='wrongkey';
	var WRONGDATA='wrongdata';
	var WRONGINIT='wronginit';

	//基地址
	var BASEURL='/weChat/';
	//fake
	BASEURLSMALLICON='<?php echo Yii::app()->baseUrl?>/img/wap/myicon-personalcenter.png';
	BASEURLBIGICON='<?php echo Yii::app()->baseUrl?>/img/wap/myicon-personalcenter-middle.png';
	//var BASEURLSMALLICON='/weChat/img/wap/myicon-personalcenter.png';
	//var BASEURLBIGICON='/weChat/img/wap/myicon-personalcenter-big.png';

	var MYJQUERY='http://libs.baidu.com/jquery/2.0.3/jquery.min.js';
	//fake
	var MYOWNJS='<?php echo Yii::app()->baseUrl?>/js/wap/personalcenter1.1.js';
	// var MYOWNJS='<?php echo Yii::app()->baseUrl?>/js/wap/personalcenter.js';


	//fake
	var AJAXFORRESULT='<?php echo Yii::app()->baseUrl?>/index.php/wap/order/getPartOrders';
	var AJAXFORBASEINFO='<?php echo Yii::app()->baseUrl?>/index.php/wap/wap/getPersonalInfo';
	// var AJAXFORDATA='<?php echo Yii::app()->createUrl('wap/wap/getData'); ?>';
	// var AJAXFORSUBMIT='<?php echo Yii::app()->createUrl('wap/order/order'); ?>';
	// var AJAXFORRESULT='<?php echo Yii::app()->createUrl('wap/order/getPartOrders'); ?>';

	
	//全局运行变量
	var memberid = "<?php echo $memberid?>";
	var bindon=<?php echo $bindon?>;
	var boundphone="<?php echo $phone?>";
	var isverified=true;
	var myanimation=null;

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
    	if(myanimation==null){
    		myanimation=new loadinganimation();
			myanimation.firstinit();
    	}
    	myanimation.start(myanimation,tips==null?'载入中…':tips);
    }

    stoploading=function(){
    	myanimation.stop();
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
		document.getElementById("warning-desc").innerHTML='您当前处于非验证状态，页面仅供浏览。如需使用本页面服务，敬请关注微信号:'+publicID;
		isverified=false;
		document.getElementById('warning').style.display = 'block';
	}	
</script>
</body>
</html>