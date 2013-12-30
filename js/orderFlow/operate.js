/***
*用户界面操作模块
***/
$(document).ready(function(){
	//取消订单
	$(".order-detail").delegate(".order-cancel-menu", "click", function(e){
		cancel();
	});
	// 完成订单
	$(".order-detail").delegate("#btn-confirm", "click", function(e){
		finish();
	});
	// 添加订单子项
	$(".order-detail").delegate(".order-item.add-item", "click", function(e){
		$('#orderAddItemModal').modal('show');
	});
	
	$('#orderAddItemModal .btn.btn-primary').click(function(){
		addItem();
	});
	//设置派送人员
	$('#choosePosterModal').on('show', function (e) {
	    getPosters();
	});

	$('#choosePosterModal .btn.btn-primary').click(function(){
		var isBatOperate = $('.order-footer .isBatOperate').attr('id');
		if(isBatOperate==0){
			setPosters();
		}else{
			batDispatchOrders();
			$('.order-footer .isBatOperate').attr('id', 0);
		}
	});
	$('#modifyOrderHeaderModal').on('shown', function (e) {
	    initOrderHeaderModal();
	});
	$('#modifyOrderHeaderModal .btn.btn-primary').click(function(){
		saveOrderHeaderModify();
	});

});
//添加订单子项
function addItem(){
	var orderId = $('.order-detail-header .order-name').attr("id");
	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/orderAddItemForm';
	var productId = $('#OrderAddItemForm_productId').attr("value");
	var num = $('#OrderAddItemForm_num').attr("value");
	if(ctUrl != '') {
	    $.ajax({
	        url      : ctUrl,
	        type     : 'POST',
	        dataType : 'json',
	        data 	 : {orderId:orderId, productId:productId, num:num},
	        cache    : false,
	        success  : function(data)
	        {
	        	alert('添加成功！');
	        	updateTabContent(currentTab);
	        },
	        error:function(){
	            alert('添加失败！');
	        }
	    });
	}
	return false;
}
//保存订单头修改
function saveOrderHeaderModify(){
	var orderId = $('.order-detail-header .order-name').attr("id");
	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/modifyOrderHeaderForm';
	var name = $('#ModifyOrderHeaderForm_username').attr("value");
	var phone = $('#ModifyOrderHeaderForm_phone').attr("value");
	var desc = $('#ModifyOrderHeaderForm_desc').attr("value");
	var total = $('#ModifyOrderHeaderForm_total').attr("value");
	var timestamp = (new Date()).valueOf();
	alert(timestamp);
	if(ctUrl != '') {
	    $.ajax({
	        url      : ctUrl,
	        type     : 'POST',
	        dataType : 'json',
	        data 	 : {orderId:orderId, orderName:name, phone:phone, desc:desc, total:total, updateTime:timestamp},
	        cache    : false,
	        success  : function(data)
	        {

	        	if(data.success==1){
	        		/*修改本地缓存*/
	        		var myOrder = MyOrder.getOrder(orderId);
	        		myOrder.orderData.name = name;
	        		myOrder.orderData.phone = phone;
	        		myOrder.orderData.desc = desc;
					myOrder.orderData.total = total;
					myOrder.save();
	        		/*修改详情*/
	        		// 姓名
	        		$('.order-detail-header .order-username').html("姓名："+name);
	        		// 电话
					$('.order-detail-header .order-phone').html("手机：" + phone);
					// 订单备注
					$('.order-detail-header .order-desc').html("备注：" +  desc);
					// 订单总价
					$('.order-detail-header .order-total').html("总价：" + total);

					/*修改订单列表*/
					var ele = getModifyOrderEle(orderId);
					//姓名
					var temp = $('.order-content .order-username', ele).html();
					$('.order-content .order-username', ele).html(updateQuote(temp, name));
					// 电话
					temp = $('.order-content .order-phonenumber', ele).html();
					$('.order-content .order-phonenumber', ele).html(updateQuote(temp, phone));
					// 订单备注
					temp = $('.order-content .order-desc', ele).html();
					$('.order-content .order-desc', ele).html(updateQuote(temp, desc));
					// 订单总价
					temp = $('.order-content .order-total', ele).html();
					$('.order-content .order-total', ele).html(updateQuote(temp, total));
	        		alert('修改成功！');
	        		// updateTabContent(currentTab);
	        		return false;
	        	}else if(data.success==0){
	        		alert('修改失败！');
	        	}else{
	        		alert('含有非法字符');
	        	}
	        	
	        },
	        error:function(){
	            alert('修改失败！');
	        }
	    });
	}
	return false;
}
//获取订单头初始值
function initOrderHeaderModal(){
	var name = filterContent($('.order-detail-header .order-username').html());
	var phone = filterContent($('.order-detail-header .order-phone').html());
	var desc = filterContent($('.order-detail-header .order-desc').html());
	var total = filterContent($('.order-detail-header .order-total').html());
	$('#ModifyOrderHeaderForm_username').attr("value", name);
	$('#ModifyOrderHeaderForm_phone').attr("value", phone);
	$('#ModifyOrderHeaderForm_desc').attr("value", desc);
	$('#ModifyOrderHeaderForm_total').attr("value", total);
}
//过滤内容
function filterContent(content){
	var len = content.length;
	for (var i = 0; i <len; i++) {
		if(content.charAt(i)=='：'){
			return content.substring(i+1, len);
		}
	}
	return content;
}
//更新内容在：后
function updateQuote(old, newContent){
	var len = old.length;
	for (var i = 0; i <len; i++) {
		if(old.charAt(i)=='：'){
			return (old.substring(0, i+1)+newContent);
		}
	}
	return old;
}
//获取orderList 中的修改内容 获取修改订单的li元素
function getModifyOrderEle(orderId){
	var ele = currentTab + " .order-body .order-list";
	var s= $(ele);
	var t=s.children().length;
	for (var i=0;i<t;i++)
	{
		if($(".order-item.item-wait .order-content", s.children()[i]).attr("id") == orderId){
			return $(s.children()[i]);
		}
	}
	return null;
}
//获取派送人员
function getPosters(){
	var orderId = $('.order-detail-header .order-name').attr("id");
	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/getPosters';
	if(ctUrl != '') {
	    $.ajax({
	        url      : ctUrl,
	        type     : 'POST',
	        dataType : 'html',
	        data 	 : {orderId:orderId},
	        cache    : false,
	        success  : function(html)
	        {
	        	jQuery("#choosePosterModal .modal-body").html(html);
	        },
	        error:function(){
	            alert('Request failed');
	        }
	    });
	}
	return false;
}
//设置跑送人员
function setPosters(){
	var orderId = $('.order-detail-header .order-name').attr("id");
	var day = $('.order-footer .order-date-container').attr("id");
	var posterId = $("input[name='ChoosePosterForm[poster]']:checked").val();
	if(posterId==null){
		alert("没有选择派送人员!");
	}else{
		ctUrl = '/weChat/index.php?r=takeAway/orderFlow/setPosters';
		if(ctUrl != '') {
		    $.ajax({
		        url      : ctUrl,
		        type     : 'POST',
		        dataType : 'json',
		        data 	 : {orderId:orderId, posterId:posterId},
		        cache    : false,
		        success  : function(data)
		        {
		        	if(data.success==1){
		        		//移动订单
			        	var myOrder = MyOrder.getOrder(orderId);
			        	myOrder.orderData.status = "派送中";
		        		myOrder.save();
			        	renderDeleOrder(day, currentTab, orderId);
			        	dynamicAddOrderToList(day, "#tab2", myOrder);
		        		alert("订单派送成功！");
		        	}else{
		        		alert("订单派送失败！");
		        	}
		        	
		        },
		        error:function(){
		                alert('Request failed');
		        }
		    });
		}
	}
	return false;
}
// 批量派送订单
function batDispatchOrders(){
	var orders = getBatOrders();
	var day = $('.order-footer .order-date-container').attr("id");
	if(orders.length==0){
		alert("请选择一个订单！");
		return false;
	}
	var posterId = $("input[name='ChoosePosterForm[poster]']:checked").val();
	if(posterId==null){
		alert("没有选择派送人员!");
	}else{
		ctUrl = '/weChat/index.php/takeAway/orderFlow/batSetPosters';
		if(ctUrl != '') {
		    $.ajax({
		        url      : ctUrl,
		        type     : 'POST',
		        dataType : 'json',
		        data 	 : {orderIds:orders, posterId:posterId},
		        cache    : false,
		        success  : function(data)
		        {
		        	if(data.success==1){
		        		//移动订单
		        		var len = orders.length;
		        		for(var i = 0; i<len; i++){
				        	var myOrder = MyOrder.getOrder(orders[i]);
				        	myOrder.orderData.status = "派送中";
			        		myOrder.save();
				        	renderDeleOrder(day, currentTab, orders[i]);
				        	dynamicAddOrderToList(day, "#tab2", myOrder);
		        		}
		        		alert("订单派送成功！");
		        	}else{
		        		alert("订单派送失败！");
		        	}
		        	
		        },
		        error:function(){
		                alert('Request failed');
		        }
		    });
		}
	}
	return false;
}
function cancel(){
	var orderId = $('.order-detail-header .order-name').attr("id");
	var day = $('.order-footer .order-date-container').attr("id");
	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/cancelOrder';
	if(currentTab=='#tab3'){
		alert('该订单处于取消状态！');
		return false;
	}
	if(ctUrl != '') {
	    $.ajax({
	        url      : ctUrl,
	        type     : 'POST',
	        dataType : 'json',
	        data 	 : {orderId:orderId, storeid: getStoreId()},
	        cache    : false,
	        success  : function(data)
	        {
	        	//alert(html);
	        	if(data.success==1){
		        	// 预刷新头
		        	var myOrder = MyOrder.getOrder(orderId);
		        	myOrder.orderData.status = "已取消";
	        		myOrder.save();
		        	renderDeleOrder(day, currentTab, orderId);
		        	dynamicAddOrderToList(day, "#tab3", myOrder);
		        	//alert("取消成功！");
	        	}else{
	        		alert("取消失败！");
	        	}
	        	
	        },
	        error:function(){
	            alert('Request failed');
	        }
	    });
	}
	return false;
}
// 批量取消订单
function batCancelOrders(){
	var orders = getBatOrders();
	var day = $('.order-footer .order-date-container').attr("id");
	if(orders.length==0){
		alert("请选择一个订单！");
		return false;
	}
	ctUrl = '/weChat/index.php/takeAway/orderFlow/batCancelOrder';
	if(currentTab=='#tab3'){
		alert('该订单处于取消状态！');
		return false;
	}
	if(ctUrl != '') {
	    $.ajax({
	        url      : ctUrl,
	        type     : 'POST',
	        dataType : 'json',
	        data 	 : {orderIds:orders, storeid: getStoreId()},
	        cache    : false,
	        success  : function(data)
	        {
	        	//alert(html);
	        	if(data.success==1){
	        		//移动订单
	        		var len = orders.length;
	        		for(var i = 0; i<len; i++){
			        	var myOrder = MyOrder.getOrder(orders[i]);
			        	myOrder.orderData.status = "已取消";
		        		myOrder.save();
			        	renderDeleOrder(day, currentTab, orders[i]);
			        	dynamicAddOrderToList(day, "#tab3", myOrder);
	        		}
	        		alert("取消成功！");
	        	}else{
	        		alert("取消失败！");
	        	}
	        },
	        error:function(){
	                alert('Request failed');
	        }
	    });
	}
	return false;
}
function finish(){
	var orderId = $('.order-detail-header .order-name').attr("id");
	var day = $('.order-footer .order-date-container').attr("id");
	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/finishOrder';
	// if(currentTab=='#tab3'){
	// 		alert('该订单已经取消无法完成！');
	// 		return false;
	// }
	if(ctUrl != '') {
	    $.ajax({
	        url      : ctUrl,
	        type     : 'POST',
	        dataType : 'json',
	        data 	 : {orderId:orderId, storeid: getStoreId()},
	        cache    : false,
	        success  : function(data)
	        {
	        	if(data.success==1){
	        		//alert(html);
	        		var myOrder = MyOrder.getOrder(orderId);
	        		myOrder.orderData.status = "已完成";
	        		myOrder.save();
		        	renderDeleOrder(day, currentTab, orderId);
		        	dynamicAddOrderToList(day, "#tab2", myOrder);
		        	alert("订单已成功完成");
	        	}else{
	        		alert("订单完成失败！");
	        	}
	        },
	        error:function(){
	            alert('Request failed');
	        }
	    });
	}
	return false;
}
// 批量完成订单
function batfinishOrders(){
	var orders = getBatOrders();
	var day = $('.order-footer .order-date-container').attr("id");
	if(orders.length==0){
		alert("请选择一个订单！");
		return false;
	}
	ctUrl = '/weChat/index.php/takeAway/orderFlow/batFinishOrder';
	// if(currentTab=='#tab3'){
	// 	alert('该订单已经取消无法完成！');
	// 	return false;
	// }
	if(ctUrl != '') {
	    $.ajax({
	        url      : ctUrl,
	        type     : 'POST',
	        dataType : 'json',
	        data 	 : {orderIds:orders, storeid: getStoreId()},
	        cache    : false,
	        success  : function(data)
	        {
	        	//alert(html);
	        	if(data.success==1){
	        		//移动订单
	        		var len = orders.length;
	        		// alert(orders);
	        		for(var i = 0; i<len; i++){
			        	var myOrder = MyOrder.getOrder(orders[i]);
		        		myOrder.orderData.status = "已完成";
		        		myOrder.save();
			        	renderDeleOrder(day, currentTab, orders[i]);
			        	dynamicAddOrderToList(day, "#tab2", myOrder);
	        		}
	        		alert("订单已完成");
	        	}else{
	        		alert("订单完成失败！");
	        	}
	        	
	        },
	        error:function(){
	                alert('Request failed');
	        }
	    });
	}
	return false;
}
// 全选订单 或取消
function pickAll(){
	var menu = $('.footer-right-btn.all-pick').html();
	var ele = ' .order-body ul>li .order-item ul>li.order-content .order-checkbox input';
	ele = currentTab + ele;
	if(menu=='全选'){
		$(ele).each(function(){
		//alert($(this).html());
			$(this).attr("checked", true);
			$('.footer-right-btn.all-pick').html("取消全选");
			});
	}else{
		$(ele).each(function(){
		//alert($(this).html());
			$(this).attr("checked", false);
			$('.footer-right-btn.all-pick').html("全选");
			});
	}
}
// 获取批量订单
function getBatOrders(){
	var chosenOrders=[];
	var ele = ' .order-body ul>li .order-item ul>li.order-content .order-checkbox input';
	ele = currentTab + ele;
    $(ele).each(function(){
		if($(this).is(':checked')){
			chosenOrders.push($(this).attr("value"));
		}
		});
		return chosenOrders;
}
// 缓存选中订单
function setBatOrdersCache(){
	var orders = getBatOrders();
	//alert(orders);
	$('.order-footer .batOrderCache').attr("id", orders);
}
// 获取缓存选中订单
function getBatOrdersCache(){
	var orders = $('.order-footer .batOrderCache').attr("id");
	//alert(orders);
	var ele = ' .order-body ul>li .order-item ul>li.order-content .order-checkbox input';
	var ele = currentTab + ele;
    $(ele).each(function(){
		if($.inArray($(this).attr('value'), orders) != -1){
			$(this).attr('checked', true);
		}
		});
		$('.order-footer .batOrderCache').attr("id", 0);
}