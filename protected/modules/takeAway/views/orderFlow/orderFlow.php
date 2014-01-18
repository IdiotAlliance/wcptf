<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/order-flow.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/bootstrap-datetimepicker.min.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.json-2.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jsrender.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/orderFlow/orderFlow.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/orderFlow/operate.js"></script>
<script type="text/javascript">
	var currentTab = "#tab1";
	var baseUrl;
	var currentOrder = null;
	$(document).ready(function(){	
		baseUrl = $(".base-url").attr("id");
		//清除缓存
		cleanAllLocalCache();
		//点击订单
		$('.order-header').delegate('.order-body ul>li .order-item ul>li.order-content', 'mousedown', function(e){
			if($(this).css("background-color") == 'rgb(247, 247, 247)'){
				$('.order-body ul>li .order-item ul>li.order-content').css("background-color", "#f7f7f7");
			}
			currentOrder = $(this).attr("id");
			$(this).css("background-color", "#e7e7e7");
			$(this).css("color", "#000000");
		});
		// $(".order-detail ").delegate('.order-member-confirm', 'mouseup', function(e){
		// 	alert("0");
		// 	var memberId = $(".order-detail .order-memberid").attr("id");
		// 	alert(memberId);
		// 	fetchMember(memberId);
		// });
		$('.order-header').delegate('.order-body ul>li .order-item ul>li.order-content', 'mouseup', function(e){
			//更新订单详情
			var orderId = $(this).attr("id");
			//alert(orderId);
			fetchAndRenderOrderItems(orderId);
			// getOrderItems(orderId);
		});
		initView();
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
	// 初始化界面 new features
	function initView(){
		$('.order-header #order-header-content .nav.nav-tabs').after("<div class='order-list-divider'></div>");
		var initTabNums = 0;
		//tab 样式
		$('.order-header #order-header-content .nav.nav-tabs').children().each(function(){
			if(initTabNums == 0){
				$(this).prepend("<div class='head-line-one'></div>");
				$(this).hover(function (){
					$('.head-line-one', $(this)).css('background-color', 'red');
				},
				function (){
					$('.head-line-one', $(this)).css('background-color', '#737373');
				}
				);
			}
			if(initTabNums == 1){
				$(this).prepend("<div class='head-line-two'></div>");
				$(this).hover(function (){
					$('.head-line-two', $(this)).css('background-color', 'red');
				},
				function (){
					$('.head-line-two', $(this)).css('background-color', '#4986e7');
				}
				);
			}
			if(initTabNums == 2){
				$(this).prepend("<div class='head-line-three'></div>");
				$(this).hover(function (){
					$('.head-line-three', $(this)).css('background-color', 'red');
				},
				function (){
					$('.head-line-three', $(this)).css('background-color', '#16a765');
				}
				);
			}
			initTabNums++;
		});
		//date picker
		$.fn.datetimepicker.dates['zh-CN'] = {
					days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
					daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
					daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
					months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
					monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
					today: "今日",
					suffix: [],
					meridiem: []
				};
	    //bottom date picker
		$(".form_datetime").datetimepicker({
			format:'yyyy-mm-dd',
			autoclose:true,
			minView:2,
			todayHighlight:true,
			pickerPosition: "top-right",
			language:'zh-CN',
		}).on('changeDate', function(ev){
			var tempDate = $('.input-date').val();
			toChooseDay(tempDate);
		});
		//order download date picker

		$(".order_download_datetime").datetimepicker({
			format:'yyyy-mm-dd hh:ii',
			autoclose:true,
			minView:0,
			todayHighlight:true,
			initialDate: new Date(),
			pickerPosition: "bottom",
			language:'zh-CN',
		}).on('changeDate', function(ev){
			// var a = new Date();
			// if (ev.date.valueOf() > a.valueOf()){
			//     alert("已经是最新日期");
			// }
		});
		// var a = new Date();
		// var endDate = new Date(a).Format("yyyy-MM-dd hh:mm");
		// $('.order_download_datetime').datetimepicker('setEndDate', endDdate);
		$('.order-footer-date').click(function(){
			$('.form_datetime').datetimepicker('show');
		});
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
	    var ctUrl = baseUrl; 
	    currentTab = tabId;
	    var areaId = $('.order-footer .order-area-container').attr("id");
	    var day = $('.order-footer .order-date-container').attr("id");
	    if(tabId == '#tab1') {
			ctUrl = '/index.php?r=takeAway/orderFlow/notSend';
	    } else if(tabId == '#tab2') {
	        ctUrl = '/index.php?r=takeAway/orderFlow/sended';
	    } else if(tabId == '#tab3') {
	    	ctUrl = '/index.php?r=takeAway/orderFlow/cancel';
	    }
	    fetchAndRenderOrderList(getStoreId(), day, tabId);
	    $('.footer-right-btn.all-pick').html("全选");
	    return false;
	}
	//获取当前店铺id
	function getStoreId(){
		return $('.store-id').attr("id");
	}
	function onlyNum()
	{
	  if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
	    event.returnValue=false;
	}
</script>
<div id="action-name">
</div>
<div id="order-download"  data-toggle="tooltip" title="下载订单">
	<img src="../../../img/icon-excel.jpg" class="img-btn" data-toggle="modal" data-target="#order-download-modal">
</div>
<?php echo '<div class="store-id" id='.$this->currentStore->id.'></div>'; ?>
<?php echo '<div class="base-url" id='.Yii::app()->request->baseUrl.'></div>'; ?>
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
					    							<label class="order-subitem order-1">{{:orderData.order_items}}</label>
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
    							<label class="order-subitem order-1">{{:orderData.order_items}}</label>
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
			   			<label class="order-usecard">{{:head.orderData.useCard}}</label>
			   			{{if head.orderData.memberStatus != '0'}}
			   				<a href="#" data-toggle='modal' data-target='#order-member-confirm-modal' class='order-member-confirm'>{{:head.orderData.memberStatus}}</a>
			   			{{/if}}
			   			<div class="order-memberid" id={{:head.orderData.memberId}} style="display:none">
			   			</div>
			   		</div>
			   		<div class="order-line line-3">
			       		<label class="order-phone">手机：{{:head.orderData.phone}}</label>
			   		</div>
			   		<div class="order-line line-4">
			   			<label class="order-desc">备注：{{:head.orderData.desc}}</label>
			   		</div>
			   		<div class="order-line line-5">
			   			<label class="order-total">总价：{{:head.orderData.total}}</label>
			   			<label class="order-date">下单时间：{{:head.orderData.ctime}}</label>
			   		</div>
			   		<div class="order-line line-6">
			   			<a href="#" class='order-cancel-menu'>取消订单</a>
			   			<a href="#" class='order-choose-menu'>指定派送人员</a>
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
		<!-- 订单加载模板 -->
		<script type="text/x-jsrender" id="orderProgress">
			<div id="circular" class="marginLeft">
				<div id="circular_1" class="circular"></div>
				<div id="circular_2" class="circular"></div>
				<div id="circular_3" class="circular"></div>
				<div id="circular_4" class="circular"></div>
				<div id="circular_5" class="circular"></div>
				<div id="circular_6" class="circular"></div>
				<div id="circular_7" class="circular"></div>
				<div id="circular_8" class="circular"></div>
				<div id="clearfix"></div>
			</div> 
		</script>
	</div>
	<div class="order-footer">
		<ul>
			<li>
				<div class="order-area-container" id="0"></div>
				<div class="footer-left-btn area-picker">片区筛选</div>
			</li>
			<!-- <li><div class="footer-left-btn new-order">+订单</div></li> -->
			<li>
				<div class="footer-btn order-left"><i class="icon-chevron-left"></i></div>
			</li>
			<li>
				<div class="order-date-container" id="0">
				</div>
				<div class="order-footer-wrap">
					<!-- <input type="text"  name='order-date'  readonly class='order-footer-date'> -->
					<div class="input-append date form_datetime">
					    <input size="16" type="text" value="" class='input-date' style="display:none">
					    <label class="order-footer-date"></label>
					    <span class="add-on"><i class="icon-th"></i></span>
						<label class="order-footer-info">订单总量:0</label>
					</div>
					<!-- <input size="16" type="text" readonly class="form_datetime" style="display:none"> -->
					
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
<!-- 下载订单modal -->
<div id="order-download-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">导出订单excel</h3>
	</div>
	<div class="modal-body">
		<div class="time-pick">
			<p>开始时间</p>
			<input size="16" type="text" name="order-start-time" readonly class="order_download_datetime">
			<p>结束时间</p>
			<input size="16" type="text" name="order-end-time" readonly class="order_download_datetime">
		</div>
		
		<div class="tyoe-pick">
			<p>选择类型</p>
			<label class="checkbox inline">
			  	<input type="checkbox" name="order-notsend" id="inlineCheckbox1" value="#tab1">未派送
			</label>
			<label class="checkbox inline">
			  	<input type="checkbox" name="order-sended" id="inlineCheckbox2" value="#tab2">已派送
			</label>
			<label class="checkbox inline">
			  	<input type="checkbox" name="order-cancel" id="inlineCheckbox3" value="#tab3">已取消
			</label>
		</div>
		<div class="area-pick">
			
		</div>
	</div>
	<div class="modal-footer">
		<!-- <button class="btn" data-dismiss="modal" aria-hidden="true">只导本列表</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">只导出今天</button> -->
		<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
		<button class="btn btn-primary" data-dismiss="modal" >导出</button>
	</div>
</div>
<!-- 会员确认modal -->
<div id="order-member-confirm-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">会员确认</h3>
	</div>
	<div class="modal-body">
		<div class="member-pick">
			
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">跳过</button>
		<button class="btn btn-primary" data-dismiss="modal" >确认</button>
	</div>
</div>
<!-- 批量会员确认modal -->
<div id="order-members-confirm-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">会员确认</h3>
	</div>
	<div class="modal-body">
		<div class="member-pick">
			
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">跳过</button>
		<button class="btn btn-primary" data-dismiss="modal" >确认</button>
	</div>
</div>
