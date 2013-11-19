<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=100%, initial-scale=1.0, user-scalable=no">
	<meta content="telephone=no" name="format-detection">

<style>
	body {  
    background-color: #fbeff9;  font-size: 16px;  
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
		/*-webkit-user-select: none;
		user-select: none;*/
}
footer{
	position: fixed;
	bottom: 0;
	z-index: 100;
}
p{
	font-size: 13px;
}

li:hover{
}

.content-frame{
	margin:0 0.5%;
	width: 99%;
	margin-bottom: 60px;
	position: relative;
}

.tips{
	background: #f1c6eb;
	margin: 1% 1%;
	margin-top: 10px;
	-webkit-box-shadow: 0 0px 3px rgba(0,0,0,0.2);
	box-shadow: 0 0px 3px rgba(0,0,0,0.2);
	border: 1px solid #e5badf;
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
		background: #f4d8f0;
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
	background: #f4d8f0; 
}
.btn-icon:active{
	background: #fbe6f8;
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
	background: #f1c6eb; 
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






.ul-listview{
	margin: 1%;
	margin-top: 10px;
	padding: 0;
}

	.ul-sort-recommend li,.ul-sort-normal li{
		background: #f4d8f0;
		-webkit-box-shadow: 0 0px 3px rgba(0,0,0,0.2);
		box-shadow: 0 0px 3px rgba(0,0,0,0.2);
		list-style: none;
		width: 100%;
		height: 100%;
		min-height: 80px;
		left: -1px;
		bottom: -1px;
		border: 1px solid #e5badf;
		margin-top: 10px;
		display: block;
		position: relative;
		overflow: hidden;
		white-space: nowrap;
		text-align: left;
	}


	.ul-sort-recommend li:active,.ul-sort-normal li:active{
		background: #fbe6f8;
		box-shadow: none;
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
		background: #fbe6f8;
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
		background: #f4d8f0;
		-webkit-box-shadow: 0 0px 3px rgba(0,0,0,0.2);
		box-shadow: 0 0px 3px rgba(0,0,0,0.2);
		list-style: none;
		width: 100%;
		height: 100%;
		min-height: 70px;
		left: -1px;
		bottom: -1px;
		border: 1px solid #e5badf;
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
		background: #f1c6eb;
		border-top-width: 1px;
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
		box-shadow: 1px 0.5px 3px rgba(0,0,0,0.75);
		border: 0;
	}


	#order-first-item{
		min-height: 55px;
		height: 55px;
		background: #f1c6eb;
		border-top-width: 1px;
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
		border:1px solid #e5badf;	
		box-shadow: 0 0 1px rgba(0,0,0,0.2);
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
		height: 40px;
		top:15px;
	}
	.button-minus{
		height: 100%;
		width: 60px;
		border:1px solid #e5badf;	
		box-shadow: -0.5px 0 1px rgba(0,0,0,0.2);
	}
	.button-plus{
		height: 100%;
		width: 60px;
		border:1px solid #e5badf;	
		box-shadow: 0.5px 0 1px rgba(0,0,0,0.2);
	}
	.button-minus:disabled,.button-plus:disabled{
		background: #fbe6f8;
		box-shadow: none;
	}
	.tipsarea-in-list{
		position: absolute;
		right:10px;
		height: 40px;
		top:15px;
		text-align:center;
		background: #f4d8f0;
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
	border: 1px solid #e5badf;
	border-left-width: 0;
	border-right-width: 0;
	background: #f4d8f0;
	display: block;
}







#back-btn{
	height: 50px;
	width: 50px;
	left: 0;
	float: left;
	border:0;
	border-right:1px solid #e5badf;	
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
	border-right:1px solid #e5badf;
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
	border-left:1px solid #e5badf;
	box-shadow: -0.5px 0 1px rgba(0,0,0,0.2);
}
#pay-btn:active{
	box-shadow: none;
}
#pay-btn:disabled{
	box-shadow: none;
}

#personalinfo{
	background: #f1c6eb;
	text-shadow: 0 0 0 #ffffff;
	margin: 1% 1%;
	margin-top: 10px;
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.2);
	box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}
#personalinfo>header{
	border: 1px solid #e5badf;
	padding: 8px 10px;
	}
	#personalinfo>header>h4{
		margin: 0;
		color: #95067f;
	}

#personalinfo-content{
	padding: 10px 10px;
	background: #f4d8f0;
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
	border:1px solid #e5badf;
}
#personalinfo-content select{
	width: 100%;
	padding: 0;
	margin: 0;
	height: 40px;
	margin-bottom: 3px;
	font-size: 16px;
	border:1px solid #e5badf;
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
	border:1px solid #e5badf;
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
	border:1px solid #e5badf;	
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
	background-color: rgba(251,239,249,0.5);
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
	background-color: #fbeff9;
}

#paysuccess{
	margin-bottom: 0;
}

#tips-ordersuccess{
	position: relative;
	width: 98%;
	margin: 1%;
	margin-top: 10px;
	top: 0;
}

.up-frame{
	position: absolute;
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
    background: #f4d8f0;
    top: 40%;
    z-index: 1;
}
#loadingshapelight {
    background: #95067f;
    top: 40%;
    z-index: 0;
}

</style>	
</head>
<body>
	<!-- 页面主体内容-->
    <?php echo $content; ?>     
</body>
</html>