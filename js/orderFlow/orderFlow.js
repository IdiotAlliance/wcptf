/**
 * 数据model 模块
 * 所有数据对象中都使用json对象，存储使用json字符串
 */
// 订单数据model 
var MyOrder = {
	createNew: function(orderId, orderData){
		var order = {};
		order.orderId = orderId;
		order.orderData = orderData;
		order.save = function(){
			localStorage.setItem('orderId'+this.orderId, $.toJSON(this.orderData));
		};
		order.get = function(){
			var data = localStorage.getItem('orderId'+this.orderId);
			data = $.evalJSON(data);
			return data;
		}
		order.orderDelete = function(){
			localStorage.removeItem('orderId'+this.orderId);
		}
　　　　　　return order;
　　　　},
	getOrder : function(orderId){
		var data = localStorage.getItem('orderId'+orderId);
		if(data!=null && data!=undefined){
			data = $.evalJSON(data);
			var order = this.createNew(orderId, data);
			return order;
		}else{
			return null;
		}	
	}
};
// 订单列表Model
var MyOrderList = {
	createNew: function(storeid, listDate, listFilter, list){
		var orderList = {};
		orderList.list = list;
		orderList.storeid = storeid;
		orderList.listDate = listDate;
		orderList.listFilter = listFilter;
		orderList.save = function(){
			localStorage.setItem('orderList'+this.storeid+'$'+this.listDate+listFilter, $.toJSON(this.list));
		};
		orderList.get = function(){
			var data = localStorage.getItem('orderList'+this.storeid+'$'+this.listDate+this.listFilter);
			data = $.evalJSON(data);
			return data;
		}
		orderList.delete = function(){
			localStorage.removeItem('orderList'+this.storeid+'$'+listDate+listFilter);
		}
　　　　　　return orderList;
　　　　},
	getList : function(storeid, listDate, listFilter){
		var list = localStorage.getItem('orderList'+storeid+'$'+listDate+listFilter);
		if(list!=null && list!=undefined){
			list = $.evalJSON(list);
			var orderList = this.createNew(storeid, listDate, listFilter, list);
			return orderList;
		}else{
			return null;
		}
	}
};
// 订单子项列表
var MyOrderItemList = {
	createNew: function(orderId, list){
		var orderItemList = {};
		orderItemList.orderId = orderId;
		orderItemList.list = list;
		orderItemList.save = function(){
			localStorage.setItem('orderItemList'+this.orderId, $.toJSON(this.list));
		};
		orderItemList.get = function(){
			var data = localStorage.getItem('orderItemList'+this.orderId);
			data = $.evalJSON(data);
			return data;
		}
		orderItemList.orderDelete = function(){
			localStorage.removeItem('orderItemList'+this.orderId);
		}
　　　　　　return orderItemList;
　　　　},
	getItemList : function(orderId){
		var itemList = localStorage.getItem('orderItemList'+orderId);
		if(itemList!=null && itemList!=undefined){
			itemList = $.evalJSON(itemList);
			var orderItemList = this.createNew(orderId, itemList);
			return orderItemList;
		}else{
			return null;
		}
	}
};
// 订单子项数据
var MyOrderItemInfo = {
	createNew: function(itemId, itemData){
		var orderItem = {};
		orderItem.itemId = itemId;
		orderItem.itemData = itemData;
		orderItem.save = function(){
			localStorage.setItem('orderItemId'+this.itemId, $.toJSON(this.itemData));
		};
		orderItem.get = function(){
			var data = localStorage.getItem('orderItemId'+this.itemId);
			data = $.evalJSON(data);
			return data;
		}
		orderItem.orderDelete = function(){
			localStorage.removeItem('orderItemId'+this.itemId);
		} 
　　　　　　return orderItem;
　　　　},
	getItemInfo : function(itemId){
		var data = localStorage.getItem('orderItemId'+itemId);
		if(data!=null && data!=undefined){
			data = $.evalJSON(data);
			var orderItem = this.createNew(itemId, data);
			return orderItem;
		}else{
			return null;
		}
	}
};
//订单筛选项
var MyOrderFilter = {
	createNew: function(){
		var order = {};
		order.orderId = "1";
		order.orderData = "123";
		order.save = function(){
			localStorage.setItem('orderId'+this.orderId, this.orderData);
		};
		order.get = function(){
			var data = localStorage.getItem('orderId'+this.orderId);
			return data;
		};
		order.orderDelete = function(){
			localStorage.removeItem('orderId'+this.orderId);
		};
　　　　　　return order;
　　　　}
};
// 获取会员id
function fetchMemberStatusByOrderId(orderId){
	var myOrder = MyOrder.getOrder(orderId);
	return myOrder.orderData.memberStatus;
}
// 确认会员状态id
function saveMemberStatusByOrderId(orderId){
	var myOrder = MyOrder.getOrder(orderId);
	myOrder.orderData.memberId = "0";
	myOrder.save();
}

// 获取订单列表&并且刷新界面inclue cache
function fetchAndRenderOrderList(storeid, day, filter){
	ctUrl = baseUrl + '/index.php?r=takeAway/orderFlow/filterOrderList';
	var myOrderList = MyOrderList.getList(storeid, day, filter);
	//检查本地缓存是否
    if(myOrderList ==null || myOrderList == undefined) {
    	// 加载动画
    	var html  = $("#orderProgress").render();
		$(filter).html(html);
		$(".order-detail").html(html);
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'json',
            data	 :{storeid:storeid, day:day, filter:filter},
            cache    : false,
            success  : function(data)
            {
            	if(data.success == 1){
            		var orderList = new Array();
            		for (var i = 0; i < data.orderList.length; i++) {
            			var orderId = data.orderList[i].order_id;
            			orderList[i] = orderId;
            			var order = MyOrder.createNew(orderId, data.orderList[i]);
            			order.save();
            		};
            		orderList = arrayToJsonArray(orderList);
            		var myOrderList = MyOrderList.createNew(storeid, day, filter, orderList);
            		myOrderList.save();
            		// 更新头
            		updateTabHeaders(filter, myOrderList.list.length);
            		// alert("stop");
            		renderOrderListByOrders(filter, myOrderList);
        			//默认选取第一个订单
        		    var orderId = $((filter+" .order-body ul>li .order-item ul>li.order-content")).attr("id");
        		    $((filter+" .order-body ul>li .order-item ul>li.order-content")).first().css("background-color", "#e7e7e7");
        		    fetchAndRenderOrderItems(orderId);
            	}
            },
            error:function(){
                alert('Request failed');
            }
        });
    }else{
    	renderOrderListByOrders(filter, myOrderList);
    	//默认选取第一个订单
	    var orderId = $((filter+" .order-body ul>li .order-item ul>li.order-content")).attr("id");
	    $((filter+" .order-body ul>li .order-item ul>li.order-content")).first().css("background-color", "#e7e7e7");
	    fetchAndRenderOrderItems(orderId);
    }
    return false;
}
// 获取订单列表inclue cache
function fetchOrderList(storeid, day, filter){
	ctUrl = baseUrl + '/index.php?r=takeAway/orderFlow/filterOrderList';
	var myOrderList = MyOrderList.getList(storeid, day, filter);
	//检查本地缓存是否
    if(myOrderList ==null || myOrderList == undefined) {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'json',
            data	 :{storeid:storeid, day:day, filter:filter},
            cache    : false,
            success  : function(data)
            {
            	//alert(html);
            	if(data.success == 1){
            		var orderList = new Array();
            		for (var i = 0; i < data.orderList.length; i++) {
            			var orderId = data.orderList[i].order_id; 
            			orderList[i] = orderId;
            			var order = MyOrder.createNew(orderId, data.orderList[i]);
            			order.save();
            		};
            		orderList = arrayToJsonArray(orderList);
            		var myOrderList = MyOrderList.createNew(storeid, day, filter, orderList);
            		myOrderList.save();
            		// 更新头
            		updateTabHeaders(filter, myOrderList.list.length);
            		updateTabHeadersByLocal();
            	}
            },
            error:function(){
                alert('Request failed');
            }
        });
    }
    return false;
}
// 获取订单数据include cache
function fetchOrder(orderId){
	ctUrl = baseUrl + '/index.php?r=takeAway/orderFlow/filterOrder';
	var myOrder = MyOrder.getOrder(orderId);
	//检查本地缓存是否
    if(myOrder ==null || myOrder == undefined) {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'json',
            async	 : 'false',
            data	 :{orderId:orderId},
            cache    : false,
            success  : function(data)
            {
            	//alert(html);
            	if(data.success == 1){
            		myOrder = MyOrder.createNew(orderId, data.order);
            		myOrder.save();
            	}
            },
            error:function(){
                    alert('Request failed');
            }
        });
    }
    return myOrder;
}
// 获取订单数据和刷新新订单
function fetchAndRenderOrder(day, filter, orderId){
	ctUrl = baseUrl + '/index.php?r=takeAway/orderFlow/filterOrder';
	// alert("fetchAndRenderOrder");
	var myOrder = MyOrder.getOrder(orderId);
	//检查本地缓存是否
    if(myOrder ==null || myOrder == undefined) {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'json',
            async	 : 'false',
            data	 :{orderId:orderId},
            cache    : false,
            success  : function(data)
            {
            	if(data.success == 1){
            		myOrder = MyOrder.createNew(orderId, data.order);
            		myOrder.save();
            		// 获取订单列表位置
            		var pos = dynamicAddOrderToList(day, filter, myOrder);
					renderAddOrder(day, filter, pos, myOrder);
            	}
            },
            error:function(){
                    alert('Request failed');
            }
        });
    }else{
    	// 一定是本地不存在的
    }
    return myOrder;
}
//更新订单内容
function updateOrder(updateTime, orderId){
	ctUrl = baseUrl + '/index.php?r=takeAway/orderFlow/filterOrder';
	var myOrder = MyOrder.getOrder(orderId);
	if(myOrder !=null && myOrder != undefined){
		if(parseInt(myOrder.orderData.update_time)<parseInt(updateTime)){
	        $.ajax({
	            url      : ctUrl,
	            type     : 'POST',
	            dataType : 'json',
	            async	 : 'false',
	            data	 :{orderId:orderId},
	            cache    : false,
	            success  : function(data)
	            {
	            	if(data.success == 1){
	            		myOrder.orderData = data.order;
	            		myOrder.save();
	            	}
	            },
	            error:function(){
	                    alert('Request failed');
	            }
	        });
		}
	}
    return myOrder;

}

//更新订单内容 并且刷新订单显示
function updateAndRenderOrder(day, filter, updateTime, orderId){
	ctUrl = baseUrl + '/index.php?r=takeAway/orderFlow/filterOrder';
	var myOrder = MyOrder.getOrder(orderId);
	if(myOrder !=null && myOrder != undefined){
		if(parseInt(myOrder.orderData.update_time)<parseInt(updateTime)){
	        $.ajax({
	            url      : ctUrl,
	            type     : 'POST',
	            dataType : 'json',
	            async	 : 'false',
	            data	 :{orderId:orderId},
	            cache    : false,
	            success  : function(data)
	            {
	            	if(data.success == 1){
	            		myOrder.orderData = data.order;
	            		myOrder.save();
	            		var ele = filter+" .order-body .order-list";
	            		var s= $(ele);
	            		var t = s.children().length;
	            		var pos = dynamicQueryOrderToList(day, filter, orderId)
	            		$(s.children()[pos]).html($("#orderTemplate").render(myOrder));
	            	}
	            },
	            error:function(){
	                    alert('Request failed');
	            }
	        });
		}
	}
    return myOrder;
}
//动态查询订单在列表&&h获取订单在列表中的位置
function dynamicQueryOrderToList(day, filter, orderId){
	var myOrderList = MyOrderList.getList(getStoreId(), day, filter);
	var pos = -1;
	if(myOrderList!=null){
		var len = myOrderList.list.length;
		for(var i=0; i<len; i++){
			if(myOrderList.list[i] == orderId){
				pos = i;
				break;
			}
		}
	}else{
		//
	}
	return pos;
}

// 获取订单子项&刷新订单子项
function fetchAndRenderOrderItems(orderId){
	ctUrl = baseUrl + '/index.php?r=takeAway/orderFlow/filterOrderItems';
	var html  = $("#orderProgress").render();
	$(".order-detail").html(html);
	if(orderId == null || orderId == undefined){
		$(".order-detail").html("无订单数据");
		return false;
	}
	var myOrderItemList = MyOrderItemList.getItemList(orderId);
	//检查本地缓存是否
    if(myOrderItemList ==null || myOrderItemList == undefined) {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'json',
            data	 :{orderId: orderId},
            cache    : false,
            success  : function(data)
            {
            	if(data.success == 1){
            		var itemList = new Array();
            		var len = data.itemList.length;
            		for (var i = 0; i < len; i++) {
            			var itemId = data.itemList[i].itemId; 
            			itemList[i] = itemId;
            			var itemInfo = MyOrderItemInfo.createNew(itemId, data.itemList[i]);
            			itemInfo.save();
            		};
            		itemList = arrayToJsonArray(itemList);
            		myOrderItemList = MyOrderItemList.createNew(orderId, itemList);
            		myOrderItemList.save();
            		renderOrderDetailByData(orderId, myOrderItemList);
            	}
            },
            error:function(){
				alert('Request failed');
            }
        });
    }else{
    	renderOrderDetailByData(orderId, myOrderItemList);
    }
    return false;
}
// 获取订单子项
function fetchOrderItems(orderId){
	ctUrl = baseUrl + '/index.php?r=takeAway/orderFlow/filterOrderItems';
	var myOrderItemList = MyOrderItemList.getItemList(orderId);
	//检查本地缓存是否
    if(myOrderItemList ==null || myOrderItemList == undefined) {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'json',
            data	 :{orderId: orderId},
            cache    : false,
            success  : function(data)
            {
            	if(data.success == 1){
            		var itemList = new Array();
            		var len = data.itemList.length;
            		for (var i = 0; i < len; i++) {
            			var itemId = data.itemList[i].itemId; 
            			itemList[i] = itemId;
            			var itemInfo = MyOrderItemInfo.createNew(itemId, data.itemList[i]);
            			itemInfo.save();
            		};
            		itemList = arrayToJsonArray(itemList);
            		myOrderItemList = MyOrderItemList.createNew(orderId, itemList);
            		myOrderItemList.save();
            	}
            },
            error:function(){
                    alert('Request failed');
            }
        });
    }
    return false;
}

//Render 订单列表
function renderOrderList(day, filter){
	var myOrderList = MyOrderList.getList(storeid, day, filter);
	var orderList = new Array();
	if(myOrderList!=null){
		var len = myOrderList.list.length;
		for(var i=0; i<len; i++){
			var myOrder = MyOrder.getOrder(myOrderList.list[i]);
			if(myOrder!=null){
				orderList[i] = myOrder;
			}
		}
		orderList = arrayJsonToJsonArray(orderList);
		var orderViews = {};
		orderViews.head = "head";
		orderViews.list = orderList;
		var html  = $("#orderListTemplate").render(orderViews);
		$(filter).html(html);
	}
}
//Render 订单列表by固定列表
function renderOrderListByOrders(filter, myOrderList){
	var orderList = new Array();
	if(myOrderList!=null){
		var len = myOrderList.list.length;
		for(var i=0; i<len; i++){
			var myOrder = MyOrder.getOrder(myOrderList.list[i]);
			if(myOrder!=null){
				orderList[i] = myOrder;
			}
		}
		orderList = arrayJsonToJsonArray(orderList);
		var orderViews = {};
		orderViews.head = "head";
		orderViews.list = orderList;
		var html  = $("#orderListTemplate").render(orderViews);
		$(filter).html(html);
		// 根据区域做过滤
		dynamicAreaOrderList(filter);
	}
}
//渲染订单详细
function renderOrderDetail(orderId){
	var myOrderItemList = MyOrderItemList.getItemList(orderId);
	var itemList = new Array();
	if(orderId==null || orderId==undefined){
		$(".order-detail").html("无订单数据");
	}
	if(myOrderItemList!=null){
		var len = myOrderItemList.list.length;
		for(var i=0; i<len; i++){
			var myItem = MyOrderItemInfo.getItemInfo(myOrderItemList.list[i]);
			if(myItem!=null){
				itemList[i] = myItem;
			}
		}
		itemList = arrayJsonToJsonArray(itemList);
		var myOrder = MyOrder.getOrder(orderId);
		var itemViews = {};
		itemViews.head = myOrder;
		itemViews.list = itemList;
		var html  = $("#orderDetailTemplate").render(itemViews);
		$(".order-detail").html(html);
	}
}
//渲染订单详细by固定的订单
function renderOrderDetailByData(orderId, myOrderItemList){
	var itemList = new Array();
	if(myOrderItemList!=null){
		var len = myOrderItemList.list.length;
		for(var i=0; i<len; i++){
			var myItem = MyOrderItemInfo.getItemInfo(myOrderItemList.list[i]);
			if(myItem!=null){
				itemList[i] = myItem;
			}
		}
		itemList = arrayJsonToJsonArray(itemList);
		var myOrder = MyOrder.getOrder(orderId);
		var itemViews = {};
		itemViews.head = myOrder;
		itemViews.list = itemList;
		var html  = $("#orderDetailTemplate").render(itemViews);
		$(".order-detail").html(html);
		$(".order-detail-header").animate({opacity: 0.0}, 1);
		$(".order-detail-header").fadeTo("slow", 1);
	}
}
//动态增加订单到列表&&h获取订单在列表中的位置
function dynamicAddOrderToList(day, filter, myOrder){
	var myOrderList = MyOrderList.getList(getStoreId(), day, filter);
	var pos = -1;
	if(myOrderList!=null){
		var len = myOrderList.list.length;
		if (len == 0){
			myOrderList.list = new Array(myOrder.orderId);
		}
		for(var i=0; i<len; i++){
			var tempOrder = MyOrder.getOrder(myOrderList.list[i]);
			var tempOrderTime = new Date(Date.parse(tempOrder.orderData.ctime.replace(/-/g, "/")));
			var myOrderTime = new Date(Date.parse(myOrder.orderData.ctime.replace(/-/g, "/")));
			if(tempOrderTime<myOrderTime){
				myOrderList.list.splice(i, 0, myOrder.orderId);
				pos = i;
				break;
			}
			if(i == len - 1){
				myOrderList.list.splice(len, 0, myOrder.orderId);
				pos = i;
			}
		}
		myOrderList.save();
		// 更新头
		updateTabHeadersByLocal();
	}else{
		//
	}
	return pos;
}
//动态增加订单
function renderAddOrder(day, filter, pos, myOrder){
	var ele = filter+" .order-body .order-list";
	var s= $(ele);
	var t=s.children().length;
	var li= document.createElement("li");
	li.innerHTML= $("#orderTemplate").render(myOrder);
	$('.order-content',li).css("color","#d10000");
	//根据区域做过滤
	if(t == 0){
		s.append(li);
	}
	for (var i=0;i<t;i++)
	{
		if (pos == -1)
		{
			s.append(li);
		}
		else if(i == pos)
		{
			//s.insertBefore(li, s.children()[i]);  
			$(s.children()[i]).before(li);
		}
	}
	dynamicAreaOrderList(filter);
}

//动态删除订单
function renderDeleOrder(day, filter, orderId){
	var ele = filter+" .order-body .order-list";
	var s= $(ele);
	var t = s.children().length;
	var pos = dynamicDeleOrderToList(day, filter, orderId);
	$(s.children()[pos]).remove();
}

//动态删除订单在列表&&h获取删除订单在列表中的位置
function dynamicDeleOrderToList(day, filter, orderId){
	var myOrderList = MyOrderList.getList(getStoreId(), day, filter);
	var pos = -1;
	if(myOrderList!=null){
		var len = myOrderList.list.length;
		for(var i=0; i<len; i++){
			if(myOrderList.list[i] == orderId){
				myOrderList.list.splice(i, 1);
				pos = i;
				break;
			}
		}
		myOrderList.save();
		// 更新头
		updateTabHeadersByLocal();
	}else{
		//
	}
	return pos;
}
//动态根据地点显示和隐藏订单
function dynamicAreaOrderList(filter){
	var areaId = $('.order-footer .order-area-container').attr("id");
	var ele = filter+" .order-body .order-list";
	var s= $(ele);
	var t=s.children().length;
	if(areaId == 0){
		for (var i=0;i<t;i++)
		{
			$(s.children()[i]).show();
		}
	}else{
		for (var i=0;i<t;i++)
		{
			if($(".order-item.item-wait", s.children()[i]).attr("id") == areaId){
				$(s.children()[i]).show();
			}else{
				$(s.children()[i]).hide();
			}
		}
	}
	
}

//将数组转换成json数组 只限于1纬
function arrayToJsonArray(arr){
	var jsonArray = "[";
	var len = arr.length;
	for(var i=0;i<len;i++)
    {
        jsonArray = jsonArray + arr[i];
        if(i!=(len-1)){
        	jsonArray = jsonArray+",";
        }
    }
    jsonArray = jsonArray + "]";
    jsonArray = jQuery.parseJSON(jsonArray);
    return jsonArray;
}
//将数组转换成json数组 只限于1纬
function arrayJsonToJsonArray(arr){
	var jsonArray = "[";
	var len = arr.length;
	for(var i=0;i<len;i++)
    {
        jsonArray = jsonArray + $.toJSON(arr[i]);
        if(i!=(len-1)){
        	jsonArray = jsonArray+",";
        }
    }
    jsonArray = jsonArray + "]";
    jsonArray = jQuery.parseJSON(jsonArray);
    return jsonArray;
}