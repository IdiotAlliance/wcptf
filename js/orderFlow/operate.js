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
	// 添加item
	$('#orderAddItemModal .btn.btn-primary').click(function(){
		addItem();
	});
	//获取派送人员
	$('#choosePosterModal').on('show', function (e) {
	    getPosters();
	});
	// 设置派送人员
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
	// 修改保存
	$('#modifyOrderHeaderModal .btn.btn-primary').click(function(){
		saveOrderHeaderModify();
	});
	//时间向后一天
    $('.order-footer .footer-btn.order-left').click(function(){
    	dayBack();
    });
    // 时间向前一天
    $('.order-footer .footer-btn.order-right').click(function(){
    	dayFront();
    });
    // 获取当前区域
    var currentDate = new Date().Format("yyyy-MM-dd");
	$('.order-footer .order-footer-wrap .order-footer-date').html(currentDate);
	$('.order-footer .footer-left-btn.area-picker').click(function(){
		$(".order-footer #popup").toggle();
		fetchAreas();
	});
	//动态绑定 区域列表click事件
	$('.order-footer #popup').delegate('li .area', 'click', function(e){
		var id = $(this).attr('id');
		var name = $(this).html();
		chooseArea(id, name);
	});
	//批量操作
	$('.footer-right-btn.all-edit').click(function(){
		$('#batOperate').toggle();
	});
	//全选
	$('.footer-right-btn.all-pick').click(function(){
		pickAll();
	});
	// 批量派送订单
	$('#batOperate .bat-dispatch').click(function(){
		$('#batOperate').toggle();
		if(currentTab=='#tab3'){
			alert('该订单处于取消状态，无法派送');
		}else{
			var orders = getBatOrders();
			if(orders.length==0){
				alert("请选择一个订单！");
			}else{
				$('.order-footer .isBatOperate').attr('id', 1);
				$('#choosePosterModal').modal('show');
			}
		}
		// batDispatchOrders();
	});
	//test clean all localstorge
	$(".footer-left-btn.new-order").click(function(){
		cleanAllLocalCache();
		alert("clean all the cache!");
	});
	// 批量取消订单
	$('#batOperate .bat-cancel').click(function(){
		$('#batOperate').toggle();
		batCancelOrders();
	});
	// 批量完成订单
	$('#batOperate .bat-finish').click(function(){
		$('#batOperate').toggle();
		batfinishOrders();
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
	        data 	 : {orderId:orderId, storeid: getStoreId()},
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
		        data 	 : {orderId:orderId, posterId:posterId, storeid: getStoreId()},
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

//clean all order the localstorage
function cleanAllLocalCache(){
	var storage = window.localStorage;
	len = storage.length;
	for (var i=storage.length; i >=0; i--){
		var key = storage.key(i);
		if(key!=null && key!= undefined && key.substring(0,5) == 'order'){
			storage.removeItem(key);
		}
	}
}

// 获取派送地区
function fetchAreas(){
	var ctUrl = '/weChat/index.php/takeAway/orderFlow/fetchAreas';
	$.ajax({
	    url      : ctUrl,
	    type     : 'POST',
	    dataType : 'json',
	    data 	 : {storeid: getStoreId()},
	    cache    : false,
	    success  : function(data)
	    {
	    	//alert(html);
	        if(data.success == 1){
	        	var areas = data.area;
	        	var html = '<li><a class="area "id='+0+'>全部</a></li>';
	        	for (var i = 0; i < areas.length; i++) {
	        		var id = areas[i]['id'];
	        		var name = areas[i]['name'];
	        		html = html+'<li><a class="area "id='+id+'>'+name+'</a></li>';
	        	};
	        	$('.order-footer #popup').html(html);
	        } else{
	        	alert('Request failed');
	        }
	    },
	    error:function(){
	            alert('Request failed');
	    }
	});
}
// 选择区域
function chooseArea(areaid, areaname){
	$('.order-footer .order-area-container').attr('id', areaid);
	if(areaid == 0){
		$('.order-footer .footer-left-btn.area-picker').html('片区筛选');
	}else{
		$('.order-footer .footer-left-btn.area-picker').html(areaname);
	}
	dynamicAreaOrderList(currentTab);
	//更新头
	updateTabHeadersByLocal();
	//updateOperate();
	$(".order-footer #popup").toggle();
}
// 日期向后
function dayBack(){
	var day = $('.order-footer .order-date-container').attr("id");
	day = parseInt(day) -1;
	$('.order-footer .order-date-container').attr("id", day);
	var date = $('.order-footer .order-footer-wrap .order-footer-date').html();
	var a = new Date();
	a = a.valueOf();
	a = a + parseInt(day) * 24 * 60 * 60 * 1000;
	//a = new Date(a);
	var currentDate = new Date(a).Format("yyyy-MM-dd");
	$('.order-footer .order-footer-wrap .order-footer-date').html(currentDate);
	loadTab(currentTab);
	updateTabHeadersByLocal();
}
// 日期向前
function dayFront(){
	var day = $('.order-footer .order-date-container').attr("id");
	if(parseInt(day)<0){
		day = parseInt(day) + 1;
		$('.order-footer .order-date-container').attr("id", day);
		var date = $('.order-footer .order-footer-wrap .order-footer-date').html();
		var a = new Date();
		a = a.valueOf();
		a = a + parseInt(day) * 24 * 60 * 60 * 1000;
		//a = new Date(a);
		var currentDate = new Date(a).Format("yyyy-MM-dd");
		$('.order-footer .order-footer-wrap .order-footer-date').html(currentDate);
		loadTab(currentTab);
		updateTabHeadersByLocal();
	}else{
		alert("已经是最新的日期");
	}
	//alert(date);
}
/*
	实时更新
*/
function updateOperate(){
    var day = $('.order-footer .order-date-container').attr("id");
    var areaId = $('.order-footer .order-area-container').attr("id");
    $.ajax({
        type:'POST',
        dataType: 'json',
        url:  '/weChat/index.php/takeAway/orderFlow/updateOperate',
        timeout: 60000,
        data:{day:day, areaId:areaId},
        success:function(data,textStatus){
            if(data.operate=='1'){
                updateTabContent(currentTab);
                updateTabHeaders("#tab1", data.header[0]);
                updateTabHeaders("#tab2", data.header[1]);
                updateTabHeaders("#tab3", data.header[2]);
            }
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){    
            alert("更新超时");
        }
    });
}
/*#new 新的订单更新接口*/
function updateListener(){

	//获取当前的偏移时间
    var day = $('.order-footer .order-date-container').attr("id");
    var areaId = $('.order-footer .order-area-container').attr("id");
    var tabOneOrderList = null;
    var tabTwoOrderList = null;
    var tabThreeOrderList = null;
    if(MyOrderList.getList(getStoreId(), day, "#tab1") != null || MyOrderList.getList(getStoreId(), day, "#tab1") != undefined){
    	tabOneOrderList =  MyOrderList.getList(getStoreId(), day, "#tab1").list;
    }else{
    	setTimeout('updateListener()', 10000);
    	return;
    }
    if(MyOrderList.getList(getStoreId(), day, "#tab2") != null || MyOrderList.getList(getStoreId(), day, "#tab2") != undefined){
    	tabTwoOrderList =  MyOrderList.getList(getStoreId(), day, "#tab2").list;
    }else{
    	setTimeout('updateListener()', 10000);
    	return;
    }
    if(MyOrderList.getList(getStoreId(), day, "#tab3") != null || MyOrderList.getList(getStoreId(), day, "#tab3") != undefined){
    	tabThreeOrderList =  MyOrderList.getList(getStoreId(), day, "#tab3").list;
    }else{
    	setTimeout('updateListener()', 10000);
    	return;
    }
	//获取tab头
	var nums = [];
	var temp1 = getTabHeaders("#tab1");
	var temp2 = getTabHeaders("#tab2");
	var temp3 = getTabHeaders("#tab3");
	nums.push(temp1);
	nums.push(temp2);
	nums.push(temp3);
	
    $.ajax({
        type:'POST',
        dataType: 'json',
        url:  '/weChat/index.php/takeAway/orderFlow/update',
        timeout: 60000,
        data:{storeid: getStoreId(), time:'1', day:day},
        success:function(data,textStatus){
            if(data.success=='1'){
                // updateTabContent(currentTab);
                if(currentTab == "#tab1"){
                	var len  = data.tabOneOrderIdList.length;
                	//current tab update
                	if (data.tabOneOrderIdList!=null && len>0) {
                		//add & render order
                		for(var i=0; i<len; i++){
                			updateAndRenderOrder(day, currentTab, data.tabOneUpdateQueue[i], data.tabOneOrderIdList[i]);
                			if($.inArray(data.tabOneOrderIdList[i], tabOneOrderList) == -1){
                				fetchAndRenderOrder(day, currentTab, data.tabOneOrderIdList[i]);
                			}
                		}
                		//delete order
                		if(tabOneOrderList!=null){
                			len = tabOneOrderList.length;
                			for(var i=0; i<len; i++){
                				if($.inArray(tabOneOrderList[i]+"", data.tabOneOrderIdList) == -1){
                					renderDeleOrder(day, currentTab, tabOneOrderList[i]);
                				}
                			}
                		}
                	};
                	// 更新订单
                	//#tab2
                	len = data.tabTwoOrderIdList.length;
                	for (var i = 0; i < len; i++) {
                		fetchOrder(data.tabTwoOrderIdList[i]);
                		updateOrder(data.tabTwoUpdateQueue[i], data.tabTwoOrderIdList[i]);
                	};                               
                	var myOrderList = MyOrderList.getList(getStoreId(), day, "#tab2");
                	myOrderList.list = data.tabTwoOrderIdList;
                	myOrderList.save();
                	//#tab3
                	len = data.tabThreeOrderIdList.length;
                	for (var i = 0; i < len; i++) {
                		fetchOrder(data.tabThreeOrderIdList[i]);
                		updateOrder(data.tabThreeUpdateQueue[i], data.tabThreeOrderIdList[i]);
                	};
                	myOrderList = MyOrderList.getList(getStoreId(), day, "#tab3");
                	myOrderList.list = data.tabThreeOrderIdList;
                	myOrderList.save();
                }
                if(currentTab == "#tab2"){
                	var len  = data.tabTwoOrderIdList.length;
                	//current tab update
                	if (data.tabTwoOrderIdList!=null && len>0) {
                		//add & render order
                		for(var i=0; i<len; i++){
                			updateAndRenderOrder(day, currentTab, data.tabTwoUpdateQueue[i], data.tabTwoOrderIdList[i]);
                			if($.inArray(data.tabTwoOrderIdList[i], tabTwoOrderList) == -1){
                				// alert("update #tab2");
                				fetchAndRenderOrder(day, currentTab, data.tabTwoOrderIdList[i]);
                			}
                		}
                		//delete order
                		if(tabTwoOrderList!=null){
                			len = tabTwoOrderList.length;
                			for(var i=0; i<len; i++){
                				if($.inArray(tabTwoOrderList[i], data.tabTwoOrderIdList) == -1){
                					renderDeleOrder(day, currentTab, tabTwoOrderList[i]);
                				}
                			}
                		}
                	};
                	// 更新订单 
                	//#tab1
                	len = data.tabOneOrderIdList.length;
                	for (var i = 0; i < len; i++) {
                		fetchOrder(data.tabOneOrderIdList[i]);
                		updateOrder(data.tabOneUpdateQueue[i], data.tabOneOrderIdList[i]);
                	};
                	var myOrderList = MyOrderList.getList(getStoreId(), day, "#tab1");
                	myOrderList.list = data.tabOneOrderIdList;
                	myOrderList.save();
                	//#tab3
                	len = data.tabThreeOrderIdList.length;
                	for (var i = 0; i < len; i++) {
                		fetchOrder(data.tabThreeOrderIdList[i]);
                		updateOrder(data.tabThreeUpdateQueue[i], data.tabThreeOrderIdList[i]);
                	};
                	myOrderList = MyOrderList.getList(getStoreId(), day, "#tab3");
                	myOrderList.list = data.tabThreeOrderIdList;
                	myOrderList.save();
                }
                if(currentTab == "#tab3"){
                	var len  = data.tabThreeOrderIdList.length;
                	//current tab update
                	if (data.tabThreeOrderIdList!=null && len>0) {
                		//add & render order
                		for(var i=0; i<len; i++){
                			updateAndRenderOrder(day, currentTab, data.tabThreeUpdateQueue[i], data.tabThreeOrderIdList[i]);
                			if($.inArray(data.tabThreeOrderIdList[i], tabThreeOrderList) == -1){
                				fetchAndRenderOrder(day, currentTab, data.tabThreeOrderIdList[i]);
                			}
                		}
                		//delete order
                		if(tabThreeOrderList!=null){
                			len = tabThreeOrderList.length;
                			for(var i=0; i<len; i++){
                				if($.inArray(tabThreeOrderList[i], data.tabThreeOrderIdList) == -1){
                					renderDeleOrder(day, currentTab, tabThreeOrderList[i]);
                				}
                			}
                		}
                	};
                	// 更新订单 
                	//#tab1
                	len = data.tabOneOrderIdList.length;
                	for (var i = 0; i < len; i++) {
                		fetchOrder(data.tabOneOrderIdList[i]);
                		updateOrder(data.tabOneUpdateQueue[i], data.tabOneOrderIdList[i]);
                	};
                	myOrderList = MyOrderList.getList(getStoreId(), day, "#tab1");
                	myOrderList.list = data.tabOneOrderIdList;
                	myOrderList.save();
                	//#tab2
                	len = data.tabTwoOrderIdList.length;
                	for (var i = 0; i < len; i++) {
                		fetchOrder(data.tabTwoOrderIdList[i]);
                		updateOrder(data.tabTwoUpdateQueue[i], data.tabTwoOrderIdList[i]);
                	};
                	var myOrderList = MyOrderList.getList(getStoreId(), day, "#tab2");
                	myOrderList.list = data.tabTwoOrderIdList;
                	myOrderList.save();
                }

            }
                
            //更新头
            updateTabHeadersByLocal();
            setTimeout('updateListener()', 10000);
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){    
            if(textStatus=="timeout"){
                alert("更新超时");
            }
            setTimeout('updateListener()', 10000);
        }
    });
}
//获取订单Tab头num
function getTabHeaders(tabId){
	var content = 0;
	$('.order-header ul.nav.nav-tabs>li a').each(function(){
		if(tabId==$(this).attr("href")){
			content = $(this).html();
			var pattern = /\d+/;
			content = content.match(pattern);
		}
    	//alert($(this).attr("href"));
    });
    return content;
}
// 根据本地数据更新头
function updateTabHeadersByLocal(){
	var day = $('.order-footer .order-date-container').attr("id");
	var areaId = $('.order-footer .order-area-container').attr("id");
	var tabOneOrderList = MyOrderList.getList(getStoreId(), day, "#tab1");
	var tabTwoOrderList = MyOrderList.getList(getStoreId(), day, "#tab2");
	var tabThreeOrderList = MyOrderList.getList(getStoreId(), day, "#tab3");
	if(tabOneOrderList!=null && tabOneOrderList!=undefined && 
		tabTwoOrderList!=null && tabTwoOrderList!=undefined &&
		tabThreeOrderList!=null && tabThreeOrderList!=undefined){
		var totalNums = tabOneOrderList.list.length + tabTwoOrderList.list.length + tabThreeOrderList.list.length;
		var orderInfo = "当日订单数：" + totalNums;
		$('.order-footer-info').html(orderInfo);
	}
	//所有区域
	if(areaId == 0){
		if(tabOneOrderList!=null && tabOneOrderList!=undefined){
			updateTabHeaders("#tab1", tabOneOrderList.list.length);
		}
		if(tabTwoOrderList!=null && tabTwoOrderList!=undefined){
			updateTabHeaders("#tab2", tabTwoOrderList.list.length);
		}
		if(tabThreeOrderList!=null && tabThreeOrderList!=undefined){
			updateTabHeaders("#tab3", tabThreeOrderList.list.length);
		}
	}else{

		if(tabOneOrderList!=null && tabOneOrderList!=undefined){
			var len = tabOneOrderList.list.length;
			var size = 0;
			for(var i=0; i<len; i++){
				var myOrder = MyOrder.getOrder(tabOneOrderList.list[i]);
				if(myOrder.orderData.areaId == areaId){
					size++;
				}
			}
			updateTabHeaders("#tab1", size);
		}
		if(tabTwoOrderList!=null && tabTwoOrderList!=undefined){
			var len = tabTwoOrderList.list.length;
			var size = 0;
			for(var i=0; i<len; i++){
				var myOrder = MyOrder.getOrder(tabTwoOrderList.list[i]);
				if(myOrder.orderData.areaId == areaId){
					size++;
				}
			}
			updateTabHeaders("#tab2", size);
		}
		if(tabThreeOrderList!=null && tabThreeOrderList!=undefined){
			var len = tabThreeOrderList.list.length;
			var size = 0;
			for(var i=0; i<len; i++){
				var myOrder = MyOrder.getOrder(tabThreeOrderList.list[i]);
				if(myOrder.orderData.areaId == areaId){
					size++;
				}
			}
			updateTabHeaders("#tab3", size);
		}
	}
}
//更新订单Tab头
function updateTabHeaders(tabId, num){
	$('.order-header ul.nav.nav-tabs>li a').each(function(){
		if(tabId==$(this).attr("href")){
			var content = $(this).html();
			var pattern = /\(\d+\)/;
			content = content.replace(pattern, "("+num+")");
			// alert(content);
			$(this).html(content);
		}
    	//alert($(this).attr("href"));
    });
}
//更新订单内容
function updateTabContent(tabId){
    var ctUrl = ''; 
    setBatOrdersCache();
   // alert(currentTab);
    var day = $('.order-footer .order-date-container').attr("id");
    var areaId = $('.order-footer .order-area-container').attr("id");
    if(tabId == '#tab1') {
		ctUrl = '/weChat/index.php/takeAway/orderFlow/notSend';
    } else if(tabId == '#tab2') {
        ctUrl = '/weChat/index.php/takeAway/orderFlow/sended';
    } else if(tabId == '#tab3') {
    	ctUrl = '/weChat/index.php/takeAway/orderFlow/cancel'; 
    }

    if(ctUrl != '') {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'html',
            data 	 : {day: day, areaId: areaId},
            cache    : false,
            success  : function(html)
            {
            	//alert(html);
                jQuery(tabId).html(html);
                $('.footer-right-btn.all-pick').html("全选");
                var orderId = $(tabId+' .order-body .order-list li .order-item .order-content').first().attr("id");
				$((tabId+" .order-body ul>li .order-item ul>li.order-content")).first().css("background-color", "#e7e7e7");
                if(orderId != null){
                	getOrderItems(orderId);
                }else{
                	getOrderItems(-1);
                }
                getBatOrdersCache();
                var h1 = getTabHeaders('#tab1');
        		var h2 = getTabHeaders('#tab2');
        		var h3 = getTabHeaders('#tab3');
        		h1 = parseInt(h1) + parseInt(h2) + parseInt(h3);
				var orderInfo = "当日订单数："+h1;
				$('.order-footer-info').html(orderInfo);
				//更新未读
            },
            error:function(){
                    alert('Request failed');
            }
        });
    }
    return false;
}
//获取订单Items
function getOrderItems(orderId){
	fetchOrderItems(orderId);
    return false;
}