<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/order-flow.css" rel="stylesheet" type="text/css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.json-2.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jsrender.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/orderFlow/orderFlow.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/orderFlow/operate.js"></script>
<script type="text/javascript">
	var currentTab = "#tab1";
	$(document).ready(function(){	
		//点击订单
		//var storeid = <?php $this->currentStore; ?>;
		$('.order-header').delegate('.order-body ul>li .order-item ul>li.order-content', 'mousedown', function(e){
			if($(this).css("background-color") == 'rgb(247, 247, 247)'){
				$('.order-body ul>li .order-item ul>li.order-content').css("background-color", "#f7f7f7");
			}
			$(this).css("background-color", "#e7e7e7");
			$(this).css("color", "#000000");
		});

		$('.order-header').delegate('.order-body ul>li .order-item ul>li.order-content', 'mouseup', function(e){
			//更新订单详情
			var orderId = $(this).attr("id");
			//alert(orderId);
			fetchAndRenderOrderItems(orderId);
			// getOrderItems(orderId);
		});
		initTab();
	});
	// 初始化加载订单列表
	function initTab(){
		var tabId = "#tab1";
		var day = $('.order-footer .order-date-container').attr("id");
		fetchAndRenderOrderList(getStoreId(), day, tabId);
		fetchOrderList(getStoreId(), day, "#tab2");
		fetchOrderList(getStoreId(), day, "#tab3");
	}
	//加载页面日期
	function loadTab(tabId){
		var day = $('.order-footer .order-date-container').attr("id");
		fetchAndRenderOrderList(getStoreId(), day, tabId);
		fetchOrderList(getStoreId(), day, "#tab1");
		fetchOrderList(getStoreId(), day, "#tab2");
		fetchOrderList(getStoreId(), day, "#tab3");
	}
	//加载切换TAB订单列表
	function loadContent(e){
	    var tabId = e.target.getAttribute("href");
	    var ctUrl = ''; 
	    currentTab = tabId;
	    var areaId = $('.order-footer .order-area-container').attr("id");
	    var day = $('.order-footer .order-date-container').attr("id");
	    if(tabId == '#tab1') {
			ctUrl = '/weChat/index.php?r=takeAway/orderFlow/notSend';
	    } else if(tabId == '#tab2') {
	        ctUrl = '/weChat/index.php?r=takeAway/orderFlow/sended';
	    } else if(tabId == '#tab3') {
	    	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/cancel';
	    }
	    fetchAndRenderOrderList(getStoreId(), day, tabId);
	    $('.footer-right-btn.all-pick').html("全选");
	    return false;
	}
	//获取当前店铺id
	function getStoreId(){
		return $('.store-id').attr("id");
	}
</script>
<div id="action-name">
</div>
<?php echo '<div class="store-id" id='.$this->currentStore->id.'></div>'; ?>
<div class="order">
	<div class="order-header">
		<div class="order-unread-num seal">

		</div>
		<?php $this->init(); ?>
		<?php $this->widget('bootstrap.widgets.TbTabs', array(
			'id'=>'order-header-content',
		    'type'=>'tabs', // 'tabs' or 'pills'
		    'tabs'=>array(
		        array(
		        	'id'=>'tab1',
		        	'label'=>'未派送('.$this->notSendNum.')',
		        	'active'=>true),
		        array(
		        	'id'=>'tab2',
		        	'label'=>'已派送('.$this->sendedNum.')', 
		        	'encodeLabel'=>true,
		        	'htmlOptions'=>array('data-html'=>true),
		        	'content'=>'loading',
		        	),
		        array(
		        	'id'=>'tab3',
		        	'label'=>'已取消('.$this->cancelNum.')', 
		        	'content'=>'loading',
		        	),
		    ),
		    'events'=>array('shown'=>'js:loadContent'),
		)); ?>
		<!-- Templates -->
		<!-- 订单模板 -->
		<script type="text/x-jsrender" id="orderListTemplate">
			<div class="order-body">
				<div class="order-body-scroll">
					<ul class="order-list">
					    {{for list}}
					    	<li>
					    		<div class="order-item item-wait" id={{:orderData.areaId}}>
					    			<ul>
					    				<li class="order-state ">
					    					<div class="state">
					    						<label>{{:orderData.status}}</label>
					    					</div>
					    				</li>
					    				<li class="order-content" id={{:orderData.order_id}}>
					    					<div class="content">
					    						<div class="item-line item-line1">
					    							<label class="order-username">预约人：{{:orderData.name}}</label>
					    							<label class="order-phonenumber">电话：{{:orderData.phone}}</label>
					    							<label class="order-id">订单号：{{:orderData.order_no}}</label>
					    							<span class="order-checkbox">
					    								<input type="checkbox" value ={{:orderData.order_id}}>
					    								</span>
					    						</div>
					    						<div class="item-line item-line2">
					    							<label class="order-address">配送地址：{{:orderData.address}}</label>
					    						</div>
					    						<div class="item-line item-line3">
					    							<label class="order-total">订单总价：{{:orderData.total}}</label>
					    							<label class="order-discount">派送人员：{{:orderData.poster_name}}</label>
					    							<div class="discount-icon">
					    								<span class='glyphicon glyphicon-trash'></span>
					    							</div>
					    						</div>
					    						<div class="item-line item-line4">
					    						</div>
					    						<div class="item-line item-line5">
					    							<label class="order-subitem-header">订单子项：</label>
					    							<label class="order-subitem order-1">{{:orderData.order_item}}</label>
					    						</div>
					    						<div class="item-line item-line6">
					    							<label class="order-desc">备注：{{:orderData.desc}}</label>
					    							<label class="order-date">下单时间：{{:orderData.ctime}}</label>
					    						</div>
					    					</div>
					    				</li>
					    			</ul>
					    		</div>
					    	</li>
					    {{/for}}
		    		</ul>
		    	</div>
		    </div>
		</script>
		<!-- 单个订单模板 -->
		<script type="text/x-jsrender" id="orderTemplate">
    		<div class="order-item item-wait" id={{:orderData.areaId}}>
    			<ul>
    				<li class="order-state ">
    					<div class="state">
    						<label>{{:orderData.status}}</label>
    					</div>
    				</li>
    				<li class="order-content" id={{:orderData.order_id}}>
    					<div class="content">
    						<div class="item-line item-line1">
    							<label class="order-username">预约人：{{:orderData.name}}</label>
    							<label class="order-phonenumber">电话：{{:orderData.phone}}</label>
    							<label class="order-id">订单号：{{:orderData.order_no}}</label>
    							<span class="order-checkbox">
    								<input type="checkbox" value ={{:orderData.order_id}}>
    								</span>
    						</div>
    						<div class="item-line item-line2">
    							<label class="order-address">配送地址：{{:orderData.address}}</label>
    						</div>
    						<div class="item-line item-line3">
    							<label class="order-total">订单总价：{{:orderData.total}}</label>
    							<label class="order-discount">派送人员：{{:orderData.poster_name}}</label>
    							<div class="discount-icon">
    								<span class='glyphicon glyphicon-trash'></span>
    							</div>
    						</div>
    						<div class="item-line item-line4">
    						</div>
    						<div class="item-line item-line5">
    							<label class="order-subitem-header">订单子项：</label>
    							<label class="order-subitem order-1">{{:orderData.order_item}}</label>
    						</div>
    						<div class="item-line item-line6">
    							<label class="order-desc">备注：{{:orderData.desc}}</label>
    							<label class="order-date">下单时间：{{:orderData.ctime}}</label>
    						</div>
    					</div>
    				</li>
    			</ul>
    		</div>
		</script>
		<!-- 订单详情模板 -->
		<script type="text/x-jsrender" id="orderDetailTemplate">
		   <div class="order-detail-scroll">
			   	<div class='order-detail-header'>
			   		<div class="order-name" id={{:head.orderData.order_id}}></div>
			   		<div class="order-line line-1">
			   			<label class="order-id">订单号：{{:head.orderData.order_no}}</label>
			   			<label class="order-come-type">{{:head.orderData.orderType}}</label>
			   		</div>
			   		<div class="order-line line-2">
			   			<label class="order-username">姓名：{{:head.orderData.name}}</label>
			   			<label class="order-date">下单时间：{{:head.orderData.ctime}}</label>
			   		</div>
			   		<div class="order-line line-3">
			       		<label class="order-phone">手机：{{:head.orderData.phone}}</label>
			   		</div>
			   		<div class="order-line line-4">
			   			<label class="order-desc">备注：{{:head.orderData.desc}}</label>
			   		</div>
			   		<div class="order-line line-5">
			   			<label class="order-total">总价：{{:head.orderData.total}}</label>
			   		</div>
			   		<div class="order-line line-6">
			   			<a href="#" class='order-cancel-menu'>取消订单</a>
			   			<a href="#" data-toggle='modal' data-target='#choosePosterModal' class='order-modify-menu'>指定派送人员</a>
			   			<a href="#" data-toggle='modal' data-target='#modifyOrderHeaderModal' class='order-modify-menu'>修改</a>
			   			<button type="button" id="btn-confirm" class="btn btn-default btn-xs">完成</button>
			   		</div>
			   	</div>
		   		<div class="order-detail-body">
		   			{{for list}}
		   				<div class="order-item item-1">
		   					<div class="order-line line-1">
		   						<label class="name">名称：{{:itemData.product}}</label>
		   						<label class="type">类型：{{:itemData.productType}}</label>
		   					</div>
		   					<div class="order-line line-2">
		   						<label class="number">数量：{{:itemData.number}}</label>
		   						<label class="price">价格：{{:itemData.price}}</label>
		   					</div>
		   				</div>
		   			{{/for}}
		   			<div class="order-item add-item">
		   				<label class="add-item-text">添加条目</label>
		   			</div>
		   		</div>
		   	</div>
		</script>
	</div>
	<div class="order-footer">
		<ul>
			<li>
				<div class="order-area-container" id="0"></div>
				<div class="footer-left-btn area-picker">片区筛选</div>
			</li>
			<li><div class="footer-left-btn new-order">+订单</div></li>
			<li>
				<div class="footer-btn order-left"><i class="icon-chevron-left"></i></div>
			</li>
			<li>
				<div class="order-date-container" id="0">
				</div>
				<div class="order-footer-wrap">
					<label class="order-footer-date"></label>
					<label class="order-footer-info">订单总量:120</label>
				</div>
			</li>
			<li>
				<div class="footer-btn order-right"><i class="icon-chevron-right"></i></span></div>
			</li>
			<li><div class="footer-right-btn all-edit">批量</div></li>
			<li><div class="footer-right-btn all-pick">全选</div></li>
		</ul>
		<!--popover菜单-->
		<ul id='popup' style="display:none">
		</ul>
		<ul id='batOperate' style="display:none">
			<li><a class="bat-dispatch">批量派送</a></li>
			<li><a class="bat-cancel">批量取消</a></li>
			<li><a class="bat-finish">批量完成</a></li>
		</ul>
		<!-- 控制批量操作 -->
		<div class="isBatOperate" id="0">
		</div>
		<!-- 批量缓存 -->
		<div class="batOrderCache" id="0">
		</div>
	</div>
</div>
<div class='order-detail'>
</div>

<!-- 选择派送人员 -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'choosePosterModal')); ?>
 
	<div class="modal-header">
	    <a class="close" data-dismiss="modal">&times;</a>
	    <h4>选取派送人员</h4>
	</div>

	<div class="modal-body">
		
	</div>
	 
	<div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'buttonType'=>'submit', 
	        'type'=>'primary', 
	        'htmlOptions'=>array('data-dismiss'=>'modal'),
	        'label'=>'确定')); ?>

	    <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'label'=>'关闭',
	        'url'=>'#',
	        'htmlOptions'=>array('data-dismiss'=>'modal'),
	    )); ?>
	</div>
 
<?php $this->endWidget(); ?>
<!-- 修改订单头 -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modifyOrderHeaderModal')); ?>
 
	<div class="modal-header">
	    <a class="close" data-dismiss="modal">&times;</a>
	    <h4>修改订单</h4>
	</div>

	<div class="modal-body">
		<?php $this->initModifyOrderHeaderForm(); ?>
	</div>

	<div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'buttonType'=>'submit', 
	        'type'=>'primary', 
	        'htmlOptions'=>array('data-dismiss'=>'modal'),
	        'label'=>'确定')); ?>

	    <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'label'=>'关闭',
	        'url'=>'#',
	        'htmlOptions'=>array('data-dismiss'=>'modal'),
	    )); ?>
	</div>
<?php $this->endWidget(); ?>
<!-- 添加订单子项 -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'orderAddItemModal')); ?>
 
	<div class="modal-header">
	    <a class="close" data-dismiss="modal">&times;</a>
	    <h4>添加订单子项</h4>
	</div>

	<div class="modal-body">
		<?php $this->initOrderAddItemForm(); ?>
	</div>

	<div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'buttonType'=>'submit', 
	        'type'=>'primary', 
	        'htmlOptions'=>array('data-dismiss'=>'modal'),
	        'label'=>'确定')); ?>

	    <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'label'=>'关闭',
	        'url'=>'#',
	        'htmlOptions'=>array('data-dismiss'=>'modal'),
	    )); ?>
	</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	var lastIntervalId = "weChat_default";

	// 对Date的扩展，将 Date 转化为指定格式的String
	// 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符， 
	// 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字) 
	// 例子： 
	// (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423 
	// (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18 
	Date.prototype.Format = function (fmt) { //author: meizz 
	    var o = {
	        "M+": this.getMonth() + 1, //月份 
	        "d+": this.getDate(), //日 
	        "h+": this.getHours(), //小时 
	        "m+": this.getMinutes(), //分 
	        "s+": this.getSeconds(), //秒 
	        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
	        "S": this.getMilliseconds() //毫秒 
	    };
	    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
	    for (var k in o)
	    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
	    return fmt;
	}

	$(function(){
		//初次加载获取区域列表
		fetchAreas();
	   	updateListener();
	    $('.order-footer .footer-btn.order-left').click(function(){
	    	dayBack();
	    });
	    $('.order-footer .footer-btn.order-right').click(function(){
	    	dayFront();
	    });
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
		$('#batOperate .bat-cancel').click(function(){
			$('#batOperate').toggle();
			batCancelOrders();
		});
		$('#batOperate .bat-finish').click(function(){
			$('#batOperate').toggle();
			batfinishOrders();
		});
		var h1 = getTabHeaders('#tab1');
		var h2 = getTabHeaders('#tab2');
		var h3 = getTabHeaders('#tab3');
		h1 = parseInt(h1) + parseInt(h2) + parseInt(h3);
		var orderInfo = "当日订单数："+h1;
		$('.order-footer-info').html(orderInfo);

		resetUnread();
	});

	//clean all the localstorage
	function cleanAllLocalCache(){
		localStorage.clear();
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
	/*
		当有新订单来时更新订单和TabTitle
	*/
	// function updateListener(){
	//     var orders=[];
	//     $(currentTab+' .order-body ul>li .order-item ul>li.order-content').each(function(){
	// 		//alert($(this).html());\
	// 		orders.push($(this).attr("id"));
	// 		});
	// 		//获取tab头
	// 		var nums = [];
	// 		var temp1 = getTabHeaders("#tab1");
	// 		var temp2 = getTabHeaders("#tab2");
	// 		var temp3 = getTabHeaders("#tab3");
	// 		nums.push(temp1);
	// 		nums.push(temp2);
	// 		nums.push(temp3);
	// 		//获取当前的偏移时间
	//     var day = $('.order-footer .order-date-container').attr("id");
	//     var areaId = $('.order-footer .order-area-container').attr("id");
	//     $.ajax({
	//         type:'POST',
	//         dataType: 'json',
	//         url:  '/weChat/index.php/takeAway/orderFlow/update',
	//         timeout: 60000,
	//         data:{time:'1', existList:orders, nums:nums, day:day, areaId:areaId, filter:currentTab},
	//         success:function(data,textStatus){
	//             if(data.success=='1'){
	//                 updateTabContent(currentTab);
	//               //  alert(nums[1]!=(data.nums[1]));
	//                 updateTabHeaders("#tab1", data.nums[0]);
	//                 updateTabHeaders("#tab2", data.nums[1]);
	//                 updateTabHeaders("#tab3", data.nums[2]);
	//             }
	//             if(data.success=='2'){
	//             	updateTabHeaders("#tab1", data.nums[0]);
	//                 updateTabHeaders("#tab2", data.nums[1]);
	//                 updateTabHeaders("#tab3", data.nums[2]);
	//             }
	//             if(data.success=='0'){
	//             }
	//             setTimeout('updateListener()', 10000);
	//         },
	//         error:function(XMLHttpRequest,textStatus,errorThrown){    
	//             if(textStatus=="timeout"){  
	//                 alert("更新超时");
	//             }
	//             setTimeout('updateListener()', 10000);
	//         }  
	//     });       
	// }
	// /*#new 新的订单更新接口*/
	// function updateListener(){
	//     var orders=[];
	//     $(currentTab+' .order-body ul>li .order-item ul>li.order-content').each(function(){
	// 		//alert($(this).html());\
	// 		orders.push($(this).attr("id"));

	// 	});
	// 	//获取tab头
	// 	var nums = [];
	// 	var temp1 = getTabHeaders("#tab1");
	// 	var temp2 = getTabHeaders("#tab2");
	// 	var temp3 = getTabHeaders("#tab3");
	// 	nums.push(temp1);
	// 	nums.push(temp2);
	// 	nums.push(temp3);
	// 	//获取当前的偏移时间
	//     var day = $('.order-footer .order-date-container').attr("id");
	//     var areaId = $('.order-footer .order-area-container').attr("id");
	//     $.ajax({
	//         type:'POST',
	//         dataType: 'json',
	//         url:  '/weChat/index.php/takeAway/orderFlow/update',
	//         timeout: 60000,
	//         data:{time:'1', existList:orders, nums:nums, day:day, areaId:areaId, filter:currentTab},
	//         success:function(data,textStatus){
	//             if(data.success=='1'){
	//                 // updateTabContent(currentTab);
	//                 var len = data.updateOrders.length;
	//                 for(var i=0; i<len; i++){
	//                 	fetchAndRenderOrder(day, currentTab, data.updateOrders[i]);
	//                 }
	//                 // alert(data.updateOrders);
	//               //  alert(nums[1]!=(data.nums[1]));
	//                 updateTabHeaders("#tab1", data.nums[0]);
	//                 updateTabHeaders("#tab2", data.nums[1]);
	//                 updateTabHeaders("#tab3", data.nums[2]);
	//             }
	//             if(data.success=='2'){
	//             	updateTabHeaders("#tab1", data.nums[0]);
	//                 updateTabHeaders("#tab2", data.nums[1]);
	//                 updateTabHeaders("#tab3", data.nums[2]);
	//             }
	//             if(data.success=='0'){
	//             }
	//             setTimeout('updateListener()', 10000);
	//         },
	//         error:function(XMLHttpRequest,textStatus,errorThrown){    
	//             if(textStatus=="timeout"){
	//                 alert("更新超时");
	//             }
	//             setTimeout('updateListener()', 10000);
	//         }
	//     });
	// }
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
	                				if(data.tabOneUpdateQueue[i])
	                			}
	                		}
	                	};
	                	// 更新订单
	                	//#tab2
	                	len = data.tabTwoOrderIdList.length;
	                	for (var i = 0; i < len; i++) {
	                		fetchOrder(data.tabTwoOrderIdList[i]);
	                	};                               
	                	var myOrderList = MyOrderList.getList(getStoreId(), day, "#tab2");
	                	myOrderList.list = data.tabTwoOrderIdList;
	                	myOrderList.save();
	                	//#tab3
	                	len = data.tabThreeOrderIdList.length;
	                	for (var i = 0; i < len; i++) {
	                		fetchOrder(data.tabThreeOrderIdList[i]);
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
	                	};
	                	var myOrderList = MyOrderList.getList(getStoreId(), day, "#tab1");
	                	myOrderList.list = data.tabOneOrderIdList;
	                	myOrderList.save();
	                	//#tab3
	                	len = data.tabThreeOrderIdList.length;
	                	for (var i = 0; i < len; i++) {
	                		fetchOrder(data.tabThreeOrderIdList[i]);
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
	                	};
	                	myOrderList = MyOrderList.getList(getStoreId(), day, "#tab1");
	                	myOrderList.list = data.tabOneOrderIdList;
	                	myOrderList.save();
	                	//#tab2
	                	len = data.tabTwoOrderIdList.length;
	                	for (var i = 0; i < len; i++) {
	                		fetchOrder(data.tabTwoOrderIdList[i]);
	                	};
	                	var myOrderList = MyOrderList.getList(getStoreId(), day, "#tab2");
	                	myOrderList.list = data.tabTwoOrderIdList;
	                	myOrderList.save();
	                }

	            }
	                // var len = data.updateOrders.length;
	                // for(var i=0; i<len; i++){
	                // 	fetchAndRenderOrder(day, currentTab, data.updateOrders[i]);
	                // }
	                // alert(data.updateOrders);
	              //  alert(nums[1]!=(data.nums[1]));
	            //     updateTabHeaders("#tab1", data.nums[0]);
	            //     updateTabHeaders("#tab2", data.nums[1]);
	            //     updateTabHeaders("#tab3", data.nums[2]);
	            // }
	            // if(data.success=='2'){
	            // 	updateTabHeaders("#tab1", data.nums[0]);
	            //     updateTabHeaders("#tab2", data.nums[1]);
	            //     updateTabHeaders("#tab3", data.nums[2]);
	            // }
	            // if(data.success=='0'){
	            // }
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
					resetUnread();
	            },
	            error:function(){
	                    alert('Request failed');
	            }
	        });
	    }
	    return false;
	}
	function resetUnread(){
		var unread = $(".order-body ul>li .order-item ul>li.order-content.unread").size();
		if(unread>0){
			$(".order-unread-num").show();
		}else{
			$(".order-unread-num").hide();
		}
	}
	//获取订单Items
	function getOrderItems(orderId){
		fetchOrderItems(orderId);
	    return false;
	}
</script>
