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
	createNew: function(listDate, listFilter, list){
		var orderList = {};
		orderList.list = list;
		orderList.listDate = listDate;
		orderList.listFilter = listFilter;
		orderList.save = function(){
			localStorage.setItem('orderList'+this.listDate+listFilter, $.toJSON(this.list));
		};
		orderList.get = function(){
			var data = localStorage.getItem('orderList'+this.listDate+this.listFilter);
			data = $.evalJSON(data);
			return data;
		}
		orderList.delete = function(){
			localStorage.removeItem('orderList'+listDate+listFilter);
		}
　　　　　　return orderList;
　　　　},
	getList : function(listDate, listFilter){
		var list = localStorage.getItem('orderList'+listDate+listFilter);
		if(list!=null && list!=undefined){
			list = $.evalJSON(list);
			var orderList = this.createNew(listDate, listFilter, list);
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
			localStorage.setItem('itemId'+this.itemId, $.toJSON(this.itemData));
		};
		orderItem.get = function(){
			var data = localStorage.getItem('itemId'+this.itemId);
			data = $.evalJSON(data);
			return data;
		}
		orderItem.orderDelete = function(){
			localStorage.removeItem('itemId'+this.itemId);
		} 
　　　　　　return orderItem;
　　　　},
	getItemInfo : function(itemId){
		var data = localStorage.getItem('itemId'+itemId);
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

// 获取订单列表inclue cache
function fetchOrderList(day, filter){
	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/filterOrderList';
	var myOrderList = MyOrderList.getList(day, filter);
	//检查本地缓存是否
    if(myOrderList ==null || myOrderList == undefined) {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'json',
            data	 :{day:day, filter:filter},
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
            		var myOrderList = MyOrderList.createNew(day, filter, orderList);
            		myOrderList.save();
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
	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/filterOrder';
	var myOrder = MyOrder.getOrder(orderId);
	//检查本地缓存是否
    if(myOrder ==null || myOrder == undefined) {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'json',
            data	 :{orderId:orderId},
            cache    : false,
            success  : function(data)
            {
            	//alert(html);
            	if(data.success == 1){
            		var order = MyOrder.createNew(orderId, data.order);
            		order.save();
            	}
            },
            error:function(){
                    alert('Request failed');
            }
        });
    }
    return false;
}
// 获取订单子项
function fetchOrderItems(orderId){
	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/filterOrderItems';
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
            	//alert(html);
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
	var myOrderList = MyOrderList.getList(day, "#tab1");
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
		$("#tab2").html(html);
	}
}
//渲染订单详细
function renderOrderDetail(orderId){
	var myOrderItemList = MyOrderItemList.getITemList(orderId);
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
		var myOrder = MyOrder.createNew(orderId);
		var itemViews = {};
		itemViews.head = myOrder;
		itemViews.list = itemList;
		alert($.toJSON(itemViews));
		// var str = $.toJSON(itemList);
		// var html  = $("#orderDetailTemplate").render(itemViews);
		// $(".order-detail").html(html);
		// alert(html);
	}
}

function renderOrder(){

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