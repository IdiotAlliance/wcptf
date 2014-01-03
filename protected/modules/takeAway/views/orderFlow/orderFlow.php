<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/order-flow.css" rel="stylesheet" type="text/css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.json-2.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jsrender.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/orderFlow/orderFlow.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/orderFlow/operate.js"></script>
<script type="text/javascript">
	var currentTab = "#tab1";
	$(document).ready(function(){	
		//清除缓存
		cleanAllLocalCache();
		//点击订单
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
		//初次加载获取区域列表
		fetchAreas();
	   	updateListener();
		var h1 = getTabHeaders('#tab1');
		var h2 = getTabHeaders('#tab2');
		var h3 = getTabHeaders('#tab3');
		h1 = parseInt(h1) + parseInt(h2) + parseInt(h3);
		var orderInfo = "当日订单数："+h1;
		$('.order-footer-info').html(orderInfo);
	});
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
					    		{{if orderData.status == '待派送'}}
		    		    			<div class="order-item item-wait" id={{:orderData.areaId}}>
		    		    		{{else orderData.status == '待生产'}}
		    		    			<div class="order-item item-produce" id={{:orderData.areaId}}>
		    		    		{{else orderData.status == '派送中'}}
		    		    			<div class="order-item item-sending" id={{:orderData.areaId}}>
		    		    		{{else orderData.status == '已完成'}}
		    		    			<div class="order-item item-finish" id={{:orderData.areaId}}>
		    		    		{{else orderData.status == '已取消'}}
		    		    			<div class="order-item item-cancel" id={{:orderData.areaId}}>
		    		    		{{/if}}
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
			{{if orderData.status == '待派送'}}
    			<div class="order-item item-wait" id={{:orderData.areaId}}>
    		{{else orderData.status == '待生产'}}
    			<div class="order-item item-produce" id={{:orderData.areaId}}>
    		{{else orderData.status == '派送中'}}
    			<div class="order-item item-sending" id={{:orderData.areaId}}>
    		{{else orderData.status == '已完成'}}
    			<div class="order-item item-finish" id={{:orderData.areaId}}>
    		{{else orderData.status == '已取消'}}
    			<div class="order-item item-cancel" id={{:orderData.areaId}}>
    		{{/if}}
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

</script>
