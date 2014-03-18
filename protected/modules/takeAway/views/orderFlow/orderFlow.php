<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/order-flow.css" rel="stylesheet" type="text/css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
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
			   			<label class="order-usecard">({{:head.orderData.useCard}})</label>
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
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.json-2.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jsrender.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/orderFlow/orderFlow.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/orderFlow/operate.js"></script>
<script src="<?php echo Yii::app()->createUrl('/resource/resource/js/name/orderflowv0_7'); ?>"></script>