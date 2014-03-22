<style type="text/css">
	*{
		margin: 0;
		padding: 0;
		background-size: 100%;
		font-size: 100%;
	}
	body{
		width: 100%;
		height: 100%;
		font-size: 100%;
		text-align: center;
		overflow: auto;
		margin: 0;
		background-color: #d0d0d0;
	}
	li{
		list-style: none;
		text-align: left;
		margin: auto;
		margin-bottom: 10px;
	}
	img{
		max-width: 100%;
		max-height: 100%;
	}
	.lpten{
		padding-left: 10px;
	}
	.rpten{
		padding-right: 10px;
	}
	.nav_bar{
		position: fixed;
		width: 100%;
		z-index: 1000;
		box-shadow: 1px 1px 3px #808080;
	}
	.header_bar{
		height: 70px;
		top: 0;
		left: 0;
		right: 0;
		background-color: #ea4b35;
	}
	.header_bar .header_logo{
		margin-left: 10px;
		margin-top: 15px;
		width: 75px;
		height: 40px;
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/logo.png') 0 0 no-repeat;
		background-size: 100% 100%;
	}
	.header_bar .header_order{
		float: right;
		padding-top: 35px;
		height: 50px;
		margin-right: 10px;
		color: #fff;
		margin-top: -40px;
		text-align: center;
		font-size: 0.7em;
		font-weight: bold;
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/icon.png') top center no-repeat;
		background-size: auto auto;
	}
	.footer_bar{
		height: 50px;
		right: 0;
		left: 0;
		bottom: 0;
		background-color: rgba(0,0,0,0.8);
	}
	.footer_bar .footer_nav_button{
		position: absolute;
		left: 10px;
		top: 12px;
		width: 35px;
		height: 25px;
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/return_icon.png') 0 0 no-repeat;
		display: none;
	}
	.footer_bar .footer_main_button{
		position: absolute;
		width: 50%;
		left: 50%;
		margin-left: -25%;
		border-radius: 10px;
		background-color: #d0d0d0;
		color: #fff;
		text-align: center;
		height: 44px;
		top: 3px;
		font-size: 1.2em;
		font-weight: bold;
		line-height: 44px;
	}
	.footer_bar .footer_main_button.active{
		background-color: #ea4b35;
		font-size: 1em;
	}
	.footer_bar .footer_main_button.active .info{
		font-size: 0.7em;
		height: 17px;
		line-height: 17px;
	}
	.footer_bar .footer_main_button.active .instruction{
		font-size: 1em;
		height: 30px;
		line-height: 30px;
	}
	.aqi_body{
		width: 100%;
		height: 100%;
	}
	.aqi_body .alert_container{
		width: 100%;
		color: #b94a48;
		background-color: #f2dede;
		border-color: #eed3d7;
		padding-top: 5px;
		padding-bottom: 5px;
		line-height: 20px;
		display: none;
	}
	.aqi_body .aqiframe_container{
		position: relative;
		left: 0;
		top: 0;
		width: 100%;
	}
	.aqi_body .aqiframe_container .frame{
		position: relative;
		left: 100%;
		right: 0;
		width: 100%;
		display: none;
		padding-bottom: 60px;
		padding-top: 70px;
	}
	.aqi_body .aqiframe_container .frame.active{
		left: 0;
		display: block;
	}
	.aqi_body .promotion_container{
		width: 100%;
	}
	.aqi_body .promotion_container .promotion_item{
		width: 100%;
		margin-bottom: 8px;
		box-shadow: 1px 1px 3px #808080;
	}
	.aqi_body .promotion_container .promotion_item .promotion_img{
		width: 100%;
		min-height: 180px;
		max-height: 250px;
		background-size: cover;
	}
	.aqi_body .promotion_container .promotion_banner{
		width: 150px;
		height: 40px;
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/activity_recommend.png') 0 0 no-repeat;
		background-size: 100%;
	}
	.aqi_body .promotion_container .promotion_desc{
		width: 100%;
		height: 45px;
		background: #fff;
		line-height: 45px;
		text-align: left;
	}
	.product_name{
		height: 100%;
		line-height: 100%;
		padding-left: 10px;
	}
	.product_price{
		height: 100%;
		line-height: 100%;
		font-size: 1.1em;
		color: #ff0000;
		float: center;
	}
	.product_detail{
		font-size: 1em;
		color: #a0a0a0;
		float: right;
		padding-right: 10px;
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/detail_icon.png') center right no-repeat;
		background-size: 6px 14px;
		margin-right: 10px;
	}
	.image_mask{
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.5) url('<?php echo Yii::app()->baseUrl?>/img/aqi/select_icon.png') center center no-repeat;
		background-size: 25px 25px;
		margin-bottom: 0;
		min-height: inherit;
	}
	.products_container{
		width: 100%;
	}
	.product_item_container{
		width: 100%;
	}
	.product_item{
		box-shadow: 1px 1px 3px #808080;
		width: 44%;
		display: inline-block;
		margin-left: 4%;
		margin-bottom: 0;
		background-color: #fff;
	}
	.product_item .product_image{
		width: 100%;
	}
	.product_desc{
		width: 100%;
		background-color: #fff;
		padding-top: 5px;
	}
	.product_desc .product_name{
		line-height: 100%;
	}
	.product_desc .product_info_group{
		height: 20px;
		line-height: 20px;
	}
	#frame_detail{
		padding-top: 70px;
		width: 100%;
		text-align: left;
	}
	#frame_detail img{
		width: 100%;
	}
	#frame_detail .detail_prod_name{
		font-size: 1.1em;
		font-weight: bold;
		padding-left: 10px;
		margin-top: 5px;
	}
	#frame_detail .detail_prod_price{
		color: #ff0000;
		font-weight: bold;
		font-size: 1.1em;
		padding-left: 10px;
		margin-top: 5px;
	}
	#frame_detail .img_group_title{
		margin-top: 5px;
		padding-left: 10px;
		font-size: 1.1em;
		font-weight: bold;
	}
	#frame_detail .detail_img_group img{
		margin-top: 0;
		margin-top: -5px;
	}
	#frame_detail .detail_prod_btn{
		width: 150px;
		height: 35px;
		line-height: 35px;
		background-color: #ea4b35;
		color: #ffffff;
		border-radius: 5px;
		text-align: center;
		margin-top: 5px;
		margin-left: 10px;
	}
	#frame_detail .detail_prod_btn.disabled{
		background-color: #808080;
		color: #ffffff;
	}
	#frame_order .order_title{
		text-align: center;
		border-bottom: 3px dotted #808080;
		padding-top: 15px;
		padding-bottom: 15px;
	}
	#frame_order #order_list{
		width: 100%;
	}
	#frame_order #order_list li{
		width: 100%;
		padding-top: 10px;
		padding-bottom: 10px;
		border-bottom: 1px solid #c0c0c0;
		box-shadow: 0px 1px 1px #f0f0f0;
	}
	#frame_order #order_list .info_group{
		display: inline-block;
		padding-left: 10px;
	}
	#frame_order #order_list .info_group .info_group_title{
		font-size: 1.1em;
	}
	#frame_order #order_list .info_group .price{
		color: #ff0000;
		padding-right: 10px;
	}
	#frame_order #order_list .control_group{
		float: right;
		padding-right: 10px;
		display: inline-block;
		margin-bottom: 0;
		padding-top: 3px;
		vertical-align: middle;
	}
	#frame_order #order_list .control_group .less{
		display: inline-block;
		width: 35px;
		height: 35px;
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/less.png') center center no-repeat; 
		background-size: cover;
	}
	#frame_order #order_list .control_group .less.disabled{
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/less_disabled.png') center center no-repeat;
		background-size: cover;
	}
	#frame_order #order_list .control_group .amount{
		display: inline-block;
		width: 35px;
		height: 33px;
		line-height: 33px;
		text-align: center;
		color: #fff;
		background: -webkit-gradient(linear, left top, left bottom, from(#aaa), to(#ddd));
		margin-bottom: 2px;
		overflow: hidden;
		vertical-align: top;
	}
	#frame_order #order_list .control_group .more{
		display: inline-block;
		width: 35px;
		height: 35px;
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/more.png') center center no-repeat;
		background-size: cover;
		margin-right: 25px;
	}
	#frame_order #order_list .control_group .discard{
		display: inline-block;
		width: 35px;
		height: 35px;
		background: url('<?php echo Yii::app()->baseUrl?>/img/aqi/delete_button.png') center center no-repeat;
		background-size: cover;
	}
	#frame_order #order_total{
		padding-left: 10px;
		font-size: 1.1em;
		font-weight: bold;
		color: #ff0000;
		text-align: left;
	}
	#frame_submit{
		text-align: left;
	}
	#frame_submit .label{
		width: 20%;
		text-align: right;
		display: inline-block;
		padding-right: 10px;
		margin-top: 0;
		height: 30px;
		line-height: 30px;
	}
	#frame_submit .submit_group{
		padding-top: 5px;
		padding-bottom: 5px;
	}
	#frame_submit select{
		width: 70%;
		padding: 0;
		margin: 0;
		outline-style: none;
		border: 0;
		height: 30px;
		margin-left: -5px;
		background-color: #fff;
	}
	#frame_submit input{
		width: 70%;
		border: 0px;
		border-color: #fff;
		font-family:arial,sans-serif;
		outline-style: none;
		height: 30px;
	}
	#frame_submit textarea{
		border: 0px;
		width: 70%;
		height: 100px;
		padding: 0px;
		border-color: #fff;
		font-family:arial,sans-serif;
		outline-style:none;
		resize: none;
		font-size: 100%;
		vertical-align: text-top;
	}
	#toast{
		position: fixed;
		width: 70%;
		left: 15%;
		bottom: 70px;
		height: 35px;
		line-height: 35px;
		padding-left: 10px;
		padding-right: 10px;
		font-weight: bold;
		font-size: 100%;
		color: #fff;
		box-shadow: 0 0 3px #808080;
		max-width: 100%;
		opacity: 0;
		display: none;
		background-color: #808080;
		z-index: 1002;
		-webkit-transition: opacity 1s ease-in-out;
		-moz-transition: opacity 1s ease-in-out;
		-o-transition: opacity 1s ease-in-out;
		-ms-transition: opacity 1s ease-in-out;
		transition: opacity 1s ease-in-out;
	}
	#toast.active{
		opacity: 1;
	}
</style>
<div id="aqi_header" class="nav_bar header_bar">
	<div class="header_logo" onclick="AQI.home();"></div>
	<div class="header_order">我的订单</div>
</div>
<div id="aqi_body" class="aqi_body">
	<div class="aqiframe_container">
		<div class="frame frame_index active" id="frame_home">
			<div class="alert_container" id="alert_container"></div>
			<div class="promotion_container" id="promotion_container"></div>
			<ul class="products_container" id="products_container">
			</ul>
		</div>
		<div class="frame frame_info" id="frame_detail">
			<img src="" class="detail_cover" />
			<div class="detail_info_group">
				<div class="detail_prod_name"></div>
				<div class="detail_prod_price"></div>
				<div class="detail_prod_btn" onclick="AQI.selectProduct(this);">加入购物车</div>
			</div>
			<div class="img_group_title">商品详情</div>
			<div class="detail_img_group" style="margin-top: 10px;"></div>
		</div>
		<div class="frame frame_order" id="frame_order">
			<div class="order_title"><h1>订单信息</h1></div>
			<ul id="order_list"></ul>
			<div id="order_total"></div>
		</div>
		<div class="frame frame_submit" id="frame_submit">
			<div style="text-align: center; padding-top: 10px; padding-left: 10px;padding-bottom: 10px;"><h1>收货信息(带*的为必填)</h1></div>
			<div class="submit_group">
				<div class="label">收货人*</div><input type="text" placeholder="请输入您的姓名" id="submit_name"/>
			</div>
			<div class="submit_group">
				<div class="label">联系电话*</div><input type="text" placeholder="非常重要，请保持电话通畅" id="submit_phone">
			</div>
			<div class="submit_group">
				<div class="label">配送区域*</div>
				<select id="submit_districts" id="submit_district"></select>
			</div>
			<div class="submit_group">
				<div class="label" style="display: inline-block;">详细地址*</div><textarea id="submit_address" warp="virtual" placeholder="请输入您的详细地址"></textarea><br>
			</div>
			<div class="submit_group">
				<div class="label">送货时间*</div>
				<select id="submit_times" id="submit_times">
					<option value="0">工作日</option>
					<option value="1">非工作日</option>
					<option value="2">工作日上午</option>
					<option value="3">工作日下午</option>
					<option value="4">非工作日上午</option>
					<option value="5">非工作日下午</option>
				</select>
			</div>
			<div class="submit_group">
				<div class="label">备注</div><textarea id="submit_comment" placeholder="请输入备注信息"></textarea>
			</div>
			<div class="submit_group">
				<div class="label">微信号</div><input id="submit_wechat" dtype="text" placeholder="输入微信号，方面卖家联系" />
			</div>
		</div>
		<div class="frame frame_myorder" id="frame_myorder"></div>
	</div>
</div>
<div id="aqi_footer" class="nav_bar footer_bar">
	<div id="footer_nav_button" class="footer_nav_button" onclick="AQI.back();"></div>
	<div id="footer_main_button" class="footer_main_button" onclick="AQI.order(this);">请先点单</div>
</div>
<div id="toast"></div>
<script type="text/javascript">
	(function(win){
		win.AQI = {};
		win.AQI.status = 0; // 0 for home; 1 for detail; 2 for order; 3 for orders; 4 for animation;
		win.AQI.STATUS_HOME      = 0;
		win.AQI.STATUS_DETAIL    = 1;
		win.AQI.STATUS_ORDER     = 2;
		win.AQI.STATUS_ORDERS    = 3;
		win.AQI.STATUS_ANIMATING = 4;
		win.AQI.STATUS_SUBMIT    = 5;
		win.AQI.RUNTIME = {};
		win.AQI.RUNTIME.cache = {};
		win.AQI.RUNTIME.sellerid = 9;
		win.AQI.RUNTIME.wapkey = "123123123";
		win.AQI.RUNTIME.openid = "lvxiang";

		// frame cache
		win.AQI.homeframe = document.getElementById('frame_home');
		win.AQI.detailframe = document.getElementById('frame_detail');
		win.AQI.orderframe = document.getElementById('frame_order');
		win.AQI.myorderframe = document.getElementById('frame_myorder');
		win.AQI.submitframe = document.getElementById('frame_submit');
		win.AQI.navbuton = document.getElementById('footer_nav_button');
		win.AQI.mainbutton = document.getElementById('footer_main_button');
		win.AQI.toast = document.getElementById('toast');
		win.AQI.currentframe = win.AQI.homeframe;
		win.AQI.home = function(){
			if(AQI.status != win.AQI.STATUS_HOME){
				AQI.homeframe.style.display = "block";
				AQI.homeframe.style.left    = '0';
				AQI.currentframe.style.left = '100%';
				AQI.currentframe.style.display = "none";
				AQI.currentframe = AQI.homeframe;
				AQI.navbuton.style.display = 'none';
				AQI.status = AQI.STATUS_HOME;
				AQI.setOrderButton();
			}
		};
		win.AQI.select = function(elem){
			if(!AQI.RUNTIME.selections){
				AQI.RUNTIME.selections = Array();
			}
			id = elem.getAttribute('name');
			if(!AQI.UTIL.hasClass(elem, "selected")){
				if(AQI.UTIL.hasClass(elem, 'promotion_img')){
					// check discount time
					product = AQI.RUNTIME.cache[id];
					date  = AQI.UTIL.getDate();
					time  = AQI.UTIL.getTime();
					disid = -1;
					price = -1;
					for(i = 0; i < product.discounts.length; i ++){
						discount = product.discounts[i];
						if(date >= discount.sdate && date <= discount.edate &&
						   time >= discount.stime && time <= discount.etime){
							disid = discount.id;
							price = discount.price;
							break;
						}
					}
					elem.innerHTML = '<div class="image_mask"><div class="promotion_banner"></div></div>';
					if(disid < 0){
						AQI.UTIL.TOAST.show("抱歉，优惠期已过，将按原价下单");
						AQI.RUNTIME.selections.push({'id': id, 'amount': 1});
					}else{
						AQI.RUNTIME.selections.push({'id': id, 'discount': disid, 'price': price, 'amount': 1});
					}
				}else{
					elem.innerHTML = '<div class="image_mask"></div>';
					AQI.RUNTIME.selections.push({'id': id, 'amount': 1});
				}
				elem.className += " selected";
			}else{
				if(AQI.UTIL.hasClass(elem, 'promotion_img'))
					elem.innerHTML = '<div class="promotion_banner"></div>';
				else
					elem.innerHTML = '';
				elem.className = elem.className.replace(/(\sselected$|\sselected\s)/, "");
				if(AQI.RUNTIME.selections){
					for(i = 0; i < AQI.RUNTIME.selections.length; i ++){
						selection = AQI.RUNTIME.selections[i];
						if(selection.id == parseInt(id)){
							AQI.RUNTIME.selections.splice(i, 1);
						}
					}
				}
			}
			AQI.setOrderButton();
		}
		win.AQI.detail = function(elem){
			if(AQI.status != AQI.STATUS_DETAIL){
				id = elem.getAttribute('name');
				AQI.detailframe.style.display = "block";
				AQI.detailframe.style.left    = '0';
				AQI.currentframe.style.left    = "100%";
				AQI.currentframe.style.display = "none";
				AQI.currentframe = AQI.detailframe;
				AQI.setOrderButton();
				AQI.navbuton.style.display = 'block';
				product = AQI.RUNTIME.cache[id];
				AQI.detailframe.getElementsByClassName('detail_cover')[0].setAttribute('src', product.cover);
				AQI.detailframe.getElementsByClassName('detail_prod_name')[0].innerHTML = product.desc;
				AQI.detailframe.getElementsByClassName('detail_prod_price')[0].innerHTML = '￥' + product.price;
				AQI.detailframe.getElementsByClassName('detail_img_group')[0].innerHTML = '';
				for(i = 0; i < product.imgs.length; i ++){
					AQI.detailframe.getElementsByClassName('detail_img_group')[0].innerHTML += ('<img src="' + product.imgs[i] + '"/>');
				}
				btn = AQI.detailframe.getElementsByClassName('detail_prod_btn')[0];
				btn.setAttribute('name', product.id);
				if(AQI.RUNTIME.selections){
					selected = false;
					for(i = 0; i < AQI.RUNTIME.selections.length; i ++){
						if(AQI.RUNTIME.selections[i].id == product.id){
							if(!AQI.UTIL.hasClass(btn, 'disabled')){
								btn.className += " disabled";
								btn.innerHTML  = "已加入购物车";
							}
							selected = true;
						}
					}
					if(!selected){
						btn.className = btn.className.replace(/(\sdisabled$|\sdisabled\s)/, '');
						btn.innerHTML = "加入购物车";
					}
				}
				AQI.status = AQI.STATUS_DETAIL;
			}
		};
		win.AQI.selectProduct = function(elem){
			id = elem.getAttribute('name');
			product = AQI.RUNTIME.cache[id];
			// push into shopping list
			if(!AQI.RUNTIME.selections) AQI.RUNTIME.selections = Array();
			AQI.RUNTIME.selections.push({'id': product.id, 'amount': 1});
			// disable the button
			btn = AQI.detailframe.getElementsByClassName('detail_prod_btn')[0];
			btn.className += " disabled";
			btn.innerHTML  = "已加入购物车";
			// set image mask
			elem = document.getElementById('promotion_' + product.id);
			if(elem){
				elem.innerHTML = '<div class="image_mask"><div class="promotion_banner"></div></div>';
			}else{
				elem = document.getElementById('product_' + product.id);
				elem.innerHTML = '<div class="image_mask"></div>';
			}
			elem.className += " selected";
			AQI.setOrderButton();
		}
		win.AQI.setOrderButton = function(){
			switch(AQI.status){
				case AQI.STATUS_HOME:
				case AQI.STATUS_DETAIL:
					if(AQI.RUNTIME.selections && AQI.RUNTIME.selections.length > 0){
						if(!AQI.UTIL.hasClass(AQI.mainbutton, 'active')){
							AQI.mainbutton.className += " active";
						}
						count = 0;
						price = 0;
						for(i = 0; i < AQI.RUNTIME.selections.length; i ++){
							selection = AQI.RUNTIME.selections[i];
							product = AQI.RUNTIME.cache[selection.id];
							count += AQI.RUNTIME.selections[i].amount;
							if(selection.discount){
								price += parseInt(selection.amount) * parseFloat(selection.price); 
							}else
								price += parseInt(selection.amount) * parseFloat(product.price);
						}
						AQI.mainbutton.innerHTML = '<div class="info">已点' + count + '份&nbsp;共' + price + '元</div><div class="instruction">点击下单</div>';
					}else{
						AQI.mainbutton.className = AQI.mainbutton.className.replace(/(\sactive$|\sactive\s)/, "");
						AQI.mainbutton.innerHTML = "请先点单";
					}
					break;
				case AQI.STATUS_ORDER:
					if(AQI.RUNTIME.selections && AQI.RUNTIME.selections.length > 0){
						if(!AQI.UTIL.hasClass(AQI.mainbutton, 'active'))
							AQI.mainbutton.className += " active";
					}else{
						AQI.mainbutton.className = AQI.mainbutton.className.replace(/(\sactive$|\sactive\s)/, '');
					}
					AQI.mainbutton.innerHTML = "下一步";
					break;
				case AQI.STATUS_SUBMIT:
					AQI.mainbutton.innerHTML = "提交订单";
					break;
			}
		}
		win.AQI.order = function(button){
			switch(AQI.status){
				case AQI.STATUS_HOME:
				case AQI.STATUS_DETAIL:
					if(AQI.UTIL.hasClass(button, 'active') &&
					   AQI.RUNTIME.selections && 
					   AQI.RUNTIME.selections.length > 0){
						AQI.currentframe.style.display = "none";
						AQI.currentframe.style.left    = "100%";
						AQI.orderframe.style.display   = "block";
						AQI.orderframe.style.left      = 0;
						AQI.currentframe = AQI.orderframe;
						AQI.status = AQI.STATUS_ORDER;
						AQI.navbuton.style.display = 'block';
						AQI.setOrderButton();
						// render the order page
						list  = document.getElementById('order_list');
						total = document.getElementById('order_total');
						list.innerHTML = '';
						total = 0;
						for(i = 0; i < AQI.RUNTIME.selections.length; i ++){
							selection = AQI.RUNTIME.selections[i];
							product   = AQI.RUNTIME.cache[selection.id];
							price     = parseFloat(product.price);
							if(selection.discount && selection.discount >= 0){
								price = parseFloat(selection.price);
							}
							list.innerHTML += '<li class="order_list_item" id="order_item_' + product.id + '">' +
												'<div class="info_group" id="info_group_' + product.id + '">' +
													'<div class="info_group_title">' + product.pname + '</div>' +
													'<div>' +
														'<span class="price">￥' + price + '</span>' +
														'<span class="amount">(' + price + 'x' + selection.amount + ')</span>' +
													'</div>' +
												'</div>' +
												'<div class="control_group">' +
													'<div class="less' + (selection.amount <= 1 ? ' disabled' : '') + '" name="' + product.id + 
													'" onclick="AQI.less(this);" id="less_' + product.id + '"></div>' +
													'<div class="amount" id="amount_' + product.id + '">' + selection.amount + '</div>' +
													'<div class="more" name="' + product.id + '" onclick="AQI.more(this);"></div>' +
													'<div class="discard" name="' + product.id + '" onclick="AQI.discard(this)"></div>' +
												'</div>' + 
											'</li>'
						}
						AQI.setTotal();
					}else{
						AQI.UTIL.TOAST.show("您还未选中任何商品");
					}
					break;
				case AQI.STATUS_ORDER:
					if(AQI.RUNTIME.selections && AQI.RUNTIME.selections.length > 0){
						AQI.currentframe.style.display = "none";
						AQI.currentframe.style.left    = "100%";
						AQI.submitframe.style.display   = "block";
						AQI.submitframe.style.left      = 0;
						AQI.currentframe = AQI.submitframe;
						AQI.status = AQI.STATUS_SUBMIT;
						AQI.navbuton.style.display = 'block';
						AQI.setOrderButton();
					}else{
						AQI.UTIL.TOAST.show('您还未选中任何商品');
					}
					break;
				case AQI.STATUS_SUBMIT:
					if(AQI.check()){

					}
					break;
				case AQI.STATUS_ORDERS:
					break;
			}
		};
		win.AQI.check = function(){
			if(AQI.RUNTIME.currentstore.status != 0 || AQI.RUNTIME.oos){
				AQI.UTIL.TOAST.show('目前无法下单');
				return false;
			}
			uname = document.getElementById('submit_name').value;
			if(!uname || uname == ""){
				AQI.UTIL.TOAST.show("请输入姓名");
				return false;
			}
			phone = document.getElementById('submit_phone').value;
			if(!phone || phone == ""){
				AQI.UTIL.TOAST.show("请输入电话号码");
				return false;
			}else if(!(/^\d+$/.test(phone))){
				AQI.UTIL.TOAST.show("无效的电话号码");
				return false;
			}
			dis   = document.getElementById('submit_districts').value;
			if(parseInt(dis) == 0){
				AQI.UTIL.TOAST.show("请选择配送区域");
				return false;
			}
			addr  = document.getElementById('submit_address').value;
			if(!addr){
				AQI.UTIL.TOAST.show("请输入地址信息");
				return false;
			}else if(addr.length > 128){
				AQI.UTIL.TOAST.show("地址过长");
				return false;
			}
			time  = document.getElementById('submit_times').value;
			info  = document.getElementById('submit_comment').value;
			if(info && info.length > 128){
				AQI.UTIL.TOAST.show("备注过长");
				return false;
			}
			wechat = document.getElementById('submit_wechat').value;
			AQI.RUNTIME.order = {};
			AQI.RUNTIME.order.name = uname;
			AQI.RUNTIME.order.phone = phone;
			AQI.RUNTIME.order.district = dis;
			AQI.RUNTIME.order.addr = addr;
			switch(time){
				case '0': AQI.RUNTIME.order.time = "工作日"; break;
				case '1': AQI.RUNTIME.order.time = "非工作日"; break;
				case '2': AQI.RUNTIME.order.time = "工作日上午"; break;
				case '3': AQI.RUNTIME.order.time = "工作日下午"; break;
				case '4': AQI.RUNTIME.order.time = "非工作日上午"; break;
				case '5': AQI.RUNTIME.order.time = "非工作日下午"; break;
			}
			AQI.RUNTIME.order.info = info;
			AQI.RUNTIME.order.wechat = wechat;
			if(AQI.UTIL.LOCALSTORAGE){
				AQI.UTIL.LOCALSTORAGE.set('uname', uname);
				AQI.UTIL.LOCALSTORAGE.set('phone', phone);
				AQI.UTIL.LOCALSTORAGE.set('addr', addr);
				AQI.UTIL.LOCALSTORAGE.set('wechat', wechat);
			}
			return true;
		}

		/*controller*/
		/*win.AQI.submit = function(){
			var products=new Array();
			var nums=new Array();
			var myindex=0;
			for(var i=0;i<orderarray.length;i++){
				var productindex=findproductbyid(orderarray[i].productid);
				if(orderarray[i].count>0&&productindex>=0){
					products[myindex]=orderarray[i].productid;
					nums[myindex]=orderarray[i].count;
					myindex++;
				}
			}
			if(!isverified){
				Toast('非验证状态无法下单',2000);
				$('html, body').animate({scrollTop: 0}, 500);
			}else if(!checkinput('#name')){
				Toast('请正确输入您的姓名',2000);
	            $('#name').focus();
			}else if(!checkinput('#number')){
				Toast('请正确输入您的手机号或电话号码',2000);
	            $('#number').focus();
			}else if(!checkselect('#select-area')){
				Toast('请选择合适的外送片区',2000);
			}else if(!checkinput('#areadesc')){
				Toast('请正确输入您的详细外送地址',2000);
	            $('#areadesc').focus();
			}else if(!checkinput('#tips')){
				Toast('请正确输入您的备注',2000);
	            $('#tips').focus();
			}else if(!(totalordernum>0)){
				Toast('您尚未选择任何商品',2000);
	        	$('html, body').animate({scrollTop: 0}, 500);
			}else if(!issubmittable){
				Toast('您的订单尚未达到起送价格',2000);
	        	$('html, body').animate({scrollTop: 0}, 500);
			}else if(overleft){
				Toast('您的订单中存在超额',2000);
	        	$('html, body').animate({scrollTop: 0}, 500);
			}else{
				
			myuesrname=$('#name').val();
			myphonenumber=$('#number').val();
			myareaid=$('#select-area').val();
			myareadesc=$('#areadesc').val();
			mytips=$('#tips').val();
			writeinfolocal(myuesrname,myphonenumber,myareaid,myareadesc);
			if(confirm('确认提交订单？')){
				$.ajax({
			        type:'POST',
			        dataType: 'json',
			        url:  AJAXFORSUBMIT,
			        data:{sellerid:sellerid,openid:openid,wapKey:identitykey,name:myuesrname,phone:myphonenumber, areaid:myareaid,areadesc:myareadesc,tips:mytips, products:products, nums:nums},
			        success:function(data,textStatus){
			            if(data.success=='1'){
							Toast('下单成功',2000);
							clearorder();
							orderload();
			            }else if(data.success=='2'){
			            	if(data.result=='user not exsit'||data.result=='wapKey is out'){
			            		callwrongkey();
			            		Toast('非验证状态无法下单',2000);
			            		showpaycontent();
			            	}else if(data.result=='order total is low'||data.result=='areaid is out'||data.result=='service is out'){
			            		if(confirm('数据冲突，是否立即更新？')){
				            		dataload(false,false,true,false,true);
				            	}
			            	}else if(data.result=='number is not enough'||data.result=='product id is out'){
			            		if(confirm('数据冲突，是否立即更新？')){
				            		dataload(true,true,false,false,false);
				            	}
			            	}else if(confirm('数据冲突，是否立即更新？')){
			            		dataload(true,true,true,true,true);
			            	}
			            }else if(data.success=='3'){
			            	Toast('存在异常输入',2000);
			            }else{
							callerror(WRONGKEY);
			            }
			        
			        },
			        error:function(XMLHttpRequest,textStatus,errorThrown){ 
			         	Toast('下单失败，请检查网络并重试',4000);
			        },
			    });  
		    }  
	  	}*/
		win.AQI.back = function(){
			switch(AQI.status){
				case AQI.STATUS_HOME:
				case AQI.STATUS_ORDER:
				case AQI.STATUS_DETAIL:
				case AQI.STATUS_ORDERS:
					AQI.home();
					break;
				case AQI.STATUS_SUBMIT:
					AQI.currentframe.style.display = "none";
					AQI.currentframe.style.left    = "100%";
					AQI.orderframe.style.display   = "block";
					AQI.orderframe.style.left      = 0;
					AQI.currentframe = AQI.orderframe;
					AQI.status = AQI.STATUS_ORDER;
					AQI.navbuton.style.display = 'block';
					AQI.setOrderButton();
					break;
			}
		};
		win.AQI.more = function(elem){
			id = elem.getAttribute('name');
			for(i = 0; i < AQI.RUNTIME.selections.length; i ++){
				selection = AQI.RUNTIME.selections[i];
				if(selection.id == id){
					selection.amount ++;
					price = parseFloat(AQI.RUNTIME.cache[selection.id].price);
					if(selection.discount && selection.discount >= 0)
						price = parseFloat(selection.price);
					info = document.getElementById('info_group_' + selection.id);
					info.getElementsByClassName('price')[0].innerHTML  = '￥' + (selection.amount * price);
					info.getElementsByClassName('amount')[0].innerHTML = '(' + price + 'x' + selection.amount + ')'
					document.getElementById('amount_' + id).innerHTML = selection.amount;
					if(selection.amount > 1){
						less = document.getElementById('less_' + selection.id);
						less.className = less.className.replace(/(\sdisabled$|\sdisabled\s)/, '');
					}
					break;
				}
			}
			AQI.setOrderButton();
			AQI.setTotal();
		};
		win.AQI.less = function(elem){
			id = elem.getAttribute('name');
			for(i = 0; i < AQI.RUNTIME.selections.length; i ++){
				selection = AQI.RUNTIME.selections[i];
				if(selection.id == id){
					if(selection.amount > 1){
						selection.amount --;
						price = parseFloat(AQI.RUNTIME.cache[selection.id].price);
						if(selection.discount && selection.discount >= 0)
							price = parseFloat(selection.price);
						info = document.getElementById('info_group_' + selection.id);
						info.getElementsByClassName('price')[0].innerHTML  = '￥' + (selection.amount * price);
						info.getElementsByClassName('amount')[0].innerHTML = '(' + price + 'x' + selection.amount + ')'
						document.getElementById('amount_' + id).innerHTML = selection.amount;
						if(selection.amount <= 1){
							less = document.getElementById('less_' + selection.id);
							less.className += ' disabled';
						}
					}
					break;
				}
			}
			AQI.setOrderButton();
			AQI.setTotal();
		};
		win.AQI.discard = function(elem){
			id = elem.getAttribute('name');
			for(i = 0; i < AQI.RUNTIME.selections.length; i ++){
				selection = AQI.RUNTIME.selections[i];
				if(selection.id == id){
					AQI.RUNTIME.selections.splice(i, 1);
					list = document.getElementById('order_list');
					item = document.getElementById('order_item_' + id);
					list.removeChild(item);
					break;
				}
			}
			p = document.getElementById('promotion_' + id);
			if(p){
				p.innerHTML = '<div class="promotion_banner"></div>';
			}else{
				p = document.getElementById('product_' + id);
				p.innerHTML = '';
			}
			p.className = p.className.replace(/(\sselected$|\sselected\s)/, '');
			AQI.setOrderButton();
			AQI.setTotal();
		};
		win.AQI.setTotal = function(){
			div = document.getElementById("order_total");
			if(AQI.RUNTIME.selections && AQI.RUNTIME.selections.length > 0){
				total = 0;
				for(i = 0; i < AQI.RUNTIME.selections.length; i ++){
					selection = AQI.RUNTIME.selections[i];
					price = parseFloat(AQI.RUNTIME.cache[selection.id].price);
					if(selection.discount && selection.discount >= 0)
						price = parseFloat(selection.price);
					total += selection.amount * price;
				}
				div.innerHTML = '共' + total + '元';
			}else{
				div.innerHTML = '';
			}
		};
		win.AQI.myorders = function(){

		};
		// data
		win.AQI.DATA = [
			{'store_name': '', 'store_id': '', 'broadcast': '', 'status': 0,
			 'stime': '08:00', 'etime': '18:00', 'servertime': '12:10', 'start_price': 20,
			 'takeaway_fee': 5, 'threshold': 1, 
			 'districts': [{'id': 1, 'name': '南大仙林校区'}, {'id': 2, 'name': '南大鼓楼校区'}],
			 'product_types': [{
			 	'typename': '', 'type_id': '', 'type_desc': '', 'type_cover':'',
			 	'products': [
			 	{
			 		'pname': '希腊猕猴桃', 'id': 11, 'price': '100', 'desc': '正宗希腊猕猴桃，生长在奥林匹斯山下的西方圣果', 
			 		'cover': '/weChat/img/aqi/activity_photo.png',
			 		'discounts': [{'id': 1, 'sdate': '2014-3-15', 'edate': '2014-3-31', 'stime': '00:30', 'etime':'24:00', 'price':'80'},
			 					  {'id': 2,'sdate': '2014-3-15', 'edate': '2014-3-31', 'stime': '17:00', 'etime':'18:00', 'price':'80'}],
			 		'imgs': ['/weChat/img/aqi/activity_photo.png', '/weChat/img/aqi/activity_photo.png', '/weChat/img/aqi/activity_photo.png']
			 	},
			 	{
			 		'pname': '美国大草莓 500g', 'id': 12, 'price': '70', 'desc': '正宗希腊猕猴桃，生长在奥林匹斯山下的西方圣果', 
			 		'cover': '/weChat/img/aqi/Strawberry_photo.png',
			 		'imgs': ['/weChat/img/aqi/Strawberry_photo.png', '/weChat/img/aqi/Strawberry_photo.png', '/weChat/img/aqi/Strawberry_photo.png']
			 	},
			 	{
			 		'pname': '天山人参果 1kg', 'id': 13, 'price': '50', 'desc': '正宗希腊猕猴桃，生长在奥林匹斯山下的西方圣果', 
			 		'cover': '/weChat/img/aqi/Strawberry_photo.png',
			 		'imgs': ['/weChat/img/aqi/activity_photo.png', '/weChat/img/aqi/activity_photo.png', '/weChat/img/aqi/Strawberry_photo.png']
			 	},
			 	{
			 		'pname': '阿尔卑斯香梨 500g', 'id': 14, 'price': '60', 'desc': '正宗希腊猕猴桃，生长在奥林匹斯山下的西方圣果', 
			 		'cover': '/weChat/img/aqi/Strawberry_photo.png',
			 		'imgs': ['/weChat/img/aqi/activity_photo.png', '/weChat/img/aqi/activity_photo.png', '/weChat/img/aqi/activity_photo.png']
			 	}
			 	]
			 }]
			}
		];
		// animation
		win.AQI.ANIMATION = {};
		win.AQI.ANIMATION.animateLeft = function(elem, percent){
			elem.style.left = (percent + '%');
			if(percent > 0){
				percent = Math.max(0, percent - 10);
				setTimeout(function(){
					AQI.ANIMATION.animateLeft(elem, percent);
				}, 15);
			}
		};
		// util
		win.AQI.UTIL = {};
		win.AQI.UTIL.init = function (){
			// render the index from data
			if(AQI.DATA.length == 1){
				AQI.UTIL.renderStore(AQI.DATA[0]);
			}else if(AQI.DATA.length > 1){

			}else{

			}
			lis = document.getElementsByClassName('product_item_container');
			for(var i = 0; i < lis.length; i ++){
				leftitem = rightitem = null;
				if(lis[i].getElementsByClassName('product_item').length > 1){
					leftitem  = lis[i].getElementsByClassName('product_item')[0];
					rightitem = lis[i].getElementsByClassName('product_item')[1];

					// align product name heights
					left  = leftitem.getElementsByClassName('product_name')[0];
					right = rightitem.getElementsByClassName('product_name')[0];	
					mh = Math.max(left.offsetHeight, right.offsetHeight);
					left.style.height = (mh + 'px');
					right.style.height = (mh + 'px');
				}else{
					leftitem  = lis[i].getElementsByClassName('product_item')[0];
				}
				// align product image heights
				if(leftitem) leftitem.getElementsByClassName('product_image')[0].style.height = (leftitem.offsetWidth * 3 / 4 + 'px');
				if(rightitem) rightitem.getElementsByClassName('product_image')[0].style.height = (rightitem.offsetWidth * 3 / 4 + 'px');	
			}
		};
		win.AQI.UTIL.renderStore = function (store){
			AQI.RUNTIME.currentstore = store;
			// render index
			if(store.status != 0){
				alertcontainer = document.getElementById('alert_container');
				alertcontainer.style.display = 'block';
				alertcontainer.innerHTML = '抱歉，本店铺已经暂停外卖，请您稍候再使用本服务';
			}else{
				// check time
				time = AQI.UTIL.getTime();
				if(time < store.stime || time > store.etime){
					alertcontainer = document.getElementById('alert_container');
					alertcontainer.style.display = 'block';
					alertcontainer.innerHTML = '目前不在外卖营业时间，您将无法下单';
					AQI.RUNTIME.oos = 1;
				}
				// render page
				promotion = document.getElementById('promotion_container');
				products  = document.getElementById('products_container');
				pcount    = 0;
				lastli    = 0;
				for(var i = 0; i < store.product_types.length; i ++){
					for(var j = 0; j < store.product_types[i].products.length; j ++){
						product = store.product_types[i].products[j];
						AQI.RUNTIME.cache[product.id] = product;
						isdiscount = false;
						if(product.discounts && product.discounts.length > 0){
							for(var k = 0; k < product.discounts.length; k ++){
								discount = product.discounts[k];
								date = AQI.UTIL.getDate();
								time = AQI.UTIL.getTime();
								if(date >= discount.sdate && date <= discount.edate
									&& time >= discount.stime && time <= discount.etime){
									isdiscount = true;
									promotion.innerHTML += '<div class="promotion_item">' +
																'<div id="promotion_' + product.id + '" name="' + product.id + '" class="promotion_img" ontouchend="AQI.select(this);" ' + 
																'style="background: url(\'' + product.cover + '\') center center no-repeat; background-size: cover;">' +
																	'<div class="promotion_banner"></div>' +
																'</div>' +
																'<div class="promotion_desc">' +
																	'<span class="product_name rpten">' + product.pname + '</span>' +
																	'<span class="product_price">￥' + discount.price + '</span>' +
																	'<span class="product_detail" name="' + product.id + '" ontouchend="AQI.detail(this);">详情</span>' +
																'</div>' +
															'</div>';
									break;
								}
							}
						}
						if(!isdiscount){
							if(pcount % 2 == 0){
								lastli = document.createElement('li');
								lastli.className = 'product_item_container';
								products.appendChild(lastli);
							}
							lastli.innerHTML += ('<div class="product_item">' +
													'<div id="product_' + product.id + '" name="' + product.id + '" class="product_image" ontouchend="AQI.select(this);" ' + 
													'style="background: url(\'' + product.cover + '\') center center no-repeat; background-size: 100% 100%;">' +
													'</div>' +
													'<div class="product_desc">' +
														'<div class="product_name rpten">' + product.pname + '</div>' +
														'<div class="product_info_group">' +
															'<span class="product_price lpten">￥' + product.price + '</span>' +
															'<span class="product_detail" name="' + product.id + '" ontouchend="AQI.detail(this);">详情</span>' +
														'</div>' +
													'</div>' + 
												'</div>');
							pcount ++;
						}
					}
				}
			}
			// render submit
			select = document.getElementById('submit_districts');
			select.innerHTML = '<option value="0">请选择配送区域</option>'
			if(store.districts){
				for(i = 0; i < store.districts.length; i ++){
					district = store.districts[i];
					select.innerHTML += "<option value='" + district.id + "'>" + district.name + "</option>"
				}
			}
			select.setAttribute('value', '0');
			if(AQI.UTIL.LOCALSTORAGE){
				document.getElementById('submit_name').value = AQI.UTIL.LOCALSTORAGE.get('uname');
				document.getElementById('submit_phone').value = AQI.UTIL.LOCALSTORAGE.get('phone');
				document.getElementById('submit_address').value = AQI.UTIL.LOCALSTORAGE.get('addr');
				document.getElementById('submit_wechat').value = AQI.UTIL.LOCALSTORAGE.get('wechat');
			}
		};
		win.AQI.UTIL.hasClass = function(elem, className){
			return ((" " + elem.className + " ").indexOf(" " + className + " ") >= 0);
		};
		win.AQI.UTIL.getTime = function(){
			d = new Date();
			return (d.getHours() + ':' + d.getMinutes());
		};
		win.AQI.UTIL.getDate = function(){
			d = new Date();
			return (d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate());
		};
		win.AQI.UTIL.TOAST = {
			show: function(text){
				AQI.toast.innerHTML = text;
				if(!AQI.UTIL.hasClass(AQI.toast, "active")){
					AQI.toast.style.display = 'block';
					AQI.toast.className += " active";
					setTimeout(AQI.UTIL.TOAST.hide, 2000);
				}
			},
			hide: function(){
				AQI.toast.className = AQI.toast.className.replace(/(\sactive$|\sactive\s)/, "");
				setTimeout(AQI.RUNTIME.TOAST.done, 1500);
			},
			done: function(){
				AQI.toast.style.display = 'none';
			}
		};
		if(win.localStorage){
			win.AQI.UTIL.LOCALSTORAGE = {};
			win.AQI.UTIL.LOCALSTORAGE.get = function(key){
				return window.localStorage.getItem(key);
			};
			win.AQI.UTIL.LOCALSTORAGE.set = function(key, val){
				AQI.UTIL.LOCALSTORAGE.del(key);
				window.localStorage.setItem(key, val);
			};
			win.AQI.UTIL.LOCALSTORAGE.del = function(key){
				window.localStorage.removeItem(key);
			};
		}
		document.body.onload = AQI.UTIL.init;
	})(window);
	
</script>