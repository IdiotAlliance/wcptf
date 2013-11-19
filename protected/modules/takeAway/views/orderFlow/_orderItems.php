<div class="order-detail-scroll">
	<div class='order-detail-header'>
		<div class="order-name" <?php echo 'id="'.$order->id.'"'; ?>></div>
		<div class="order-line line-1">
			<label class="order-id">订单号：<?php echo $order->order_no; ?></label>
			<label class="order-come-type"><?php echo $order->type; ?></label>
		</div>
		<div class="order-line line-2">
			<label class="order-username">姓名：<?php echo $order->order_name; ?></label>
			<label class="order-date">下单时间：<?php echo $order->ctime; ?></label>
		</div>
		<div class="order-line line-3">
    		<label class="order-phone">手机：<?php echo $order->phone; ?></label>
		</div>
		<div class="order-line line-4">
			<label class="order-desc">备注：<?php echo $order->description;?></label>
		</div>
		<div class="order-line line-5">
			<label class="order-total">总价：<?php echo $order->total; ?></label>
		</div>
		<div class="order-line line-6">
			<a href="#" class='order-cancel-menu'>取消订单</a>
			<a href="#" data-toggle='modal' data-target='#choosePosterModal' class='order-modify-menu'>指定派送人员</a>
			<a href="#" data-toggle='modal' data-target='#modifyOrderHeaderModal' class='order-modify-menu'>修改</a>
			<button type="button" id="btn-confirm" class="btn btn-default btn-xs">完成</button>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			//取消订单
			$(".order-cancel-menu").click(function(){
				cancel();
			});
			// 完成订单
			$("#btn-confirm").click(function(){
				finish();
			});
			// 添加订单子项
			$(".order-item.add-item").click(function(){
				$('#orderAddItemModal').modal('show');
			});
			$('#orderAddItemModal .btn.btn-primary').click(function(){
				addItem();
			});

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
			alert("add");
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
			if(ctUrl != '') {
			    $.ajax({
			        url      : ctUrl,
			        type     : 'POST',
			        dataType : 'json',
			        data 	 : {orderId:orderId, orderName:name, phone:phone, desc:desc, total:total},
			        cache    : false,
			        success  : function(data)
			        {

			        	alert('修改成功！');
			        	updateTabContent(currentTab);
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
				        		updateTabContent(currentTab);
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
			        data 	 : {orderId:orderId},
			        cache    : false,
			        success  : function(data)
			        {
			        	//alert(html);
			        	if(data.success==1){
			        		updateTabContent(currentTab);
				        	// 预刷新头
				        	var h1 = getTabHeaders('#tab1');
				        	var h2 = getTabHeaders('#tab2');
				        	var h3 = getTabHeaders('#tab3');
				        	if(currentTab == '#tab1'){
				        		h3 = parseInt(h3)+1;
				        		h1 = parseInt(h1)-1;
				        		updateTabHeaders('#tab1', h1);
				        		updateTabHeaders('#tab3', h3);
				        	}
				        	if(currentTab == '#tab2'){
				        		h2 = parseInt(h2)-1;
				        		h3 = parseInt(h3)+1;
				        		updateTabHeaders('#tab3', h3);
				        		updateTabHeaders('#tab2', h2);
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
			ctUrl = '/weChat/index.php?r=takeAway/orderFlow/finishOrder';
			if(currentTab=='#tab2'){
				alert('该订单已经完成');
				return false;
			}
			if(currentTab=='#tab3'){
					alert('该订单已经取消无法完成！');
					return false;
			}
			if(ctUrl != '') {
			    $.ajax({
			        url      : ctUrl,
			        type     : 'POST',
			        dataType : 'json',
			        data 	 : {orderId:orderId},
			        cache    : false,
			        success  : function(data)
			        {
			        	if(data.success==1){
			        		//alert(html);
				        	updateTabContent(currentTab);
				        	// 预刷新头
				        	var h1 = getTabHeaders('#tab1');
				        	var h2 = getTabHeaders('#tab2');
				        	var h3 = getTabHeaders('#tab3');
				        	if(currentTab == '#tab1'){
				        		h2 = parseInt(h2)+1;
				        		h1 = parseInt(h1)-1;
				        		updateTabHeaders('#tab1', h1);
				        		updateTabHeaders('#tab2', h2);
				        	}
				        	if(currentTab == '#tab3'){
				        		h2 = parseInt(h2)+1;
				        		h3 = parseInt(h3)-1;
				        		updateTabHeaders('#tab3', h3);
				        		updateTabHeaders('#tab2', h2);
				        	}
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
	</script>
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
	<div class="order-detail-body">
		<?php foreach ($orderItems as $item):?>
			<div class="order-item item-1">
				<div class="order-line line-1">
					<label class="name">名称：<?php
						$pos = strpos($item->product_id, ':');
						echo substr($item->product_id, 0, $pos); 
					?></label>
					<label class="type">类型：<?php 
						$pos = strpos($item->product_id, ':');
						echo substr($item->product_id, $pos);
					 ?></label>
				</div>
				<div class="order-line line-2">
					<label class="number">数量：<?php echo $item->number; ?></label>
					<label class="price">价格：<?php echo $item->price; ?></label>
				</div>
			</div>
		<?php endforeach;?>
		<div class="order-item add-item">
			<label class="add-item-text">添加条目</label>
		</div>

	</div>
</div>