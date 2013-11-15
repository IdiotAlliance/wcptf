<div class="order-detail-scroll">
	<div class='order-detail-header'>
		<div class="order-name" <?php echo 'id="'.$order->id.'">'; ?></div>
		<div class="order-line line-1">
			<label class="order-id">订单号：<?php echo $order->order_no; ?></label>
			<label class="order-come-type"><?php echo $order->type; ?></label>
		</div>
		<div class="order-line line-2">
			<label class="order-username">姓名：<?php echo $order->member_id; ?></label>
			<label class="order-date">下单时间：<?php echo $order->ctime; ?></label>
		</div>
		<div class="order-line line-3">
    		<label class="order-phone">手机：<?php echo $order->phone; ?></label>
    		<a href="#" class='order-setblack-menu'>设为黑名单</a>
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
			<a href="#" class='order-modify-menu'>修改</a>
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

			$('#choosePosterModal').on('show', function (e) {
			    getPosters();
			});

			$('.btn.btn-primary').click(function(){
				setPosters();
			});

		});
		function getPosters(){
			var orderId = $('.order-detail-header .order-name').attr("id");
			ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/getPosters';
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
		function setPosters(){
			var orderId = $('.order-detail-header .order-name').attr("id");
			var posterId = $("input[name='ChoosePosterForm[poster]']:checked").val()
			if(posterId==false){
				alert("not choose anything!");
			}else{
				ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/setPosters';
				if(ctUrl != '') {
				    $.ajax({
				        url      : ctUrl,
				        type     : 'POST',
				        dataType : 'json',
				        data 	 : {orderId:orderId, posterId:posterId},
				        cache    : false,
				        success  : function(data)
				        {
				        	updateTabContent("#tab1");
			        		updateTabContent("#tab2");
			        		updateTabContent("#tab3");
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
			ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/cancelOrder';
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
			        	updateTabContent("#tab1");
			        	updateTabContent("#tab2");
			        	updateTabContent("#tab3");
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
			ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/finishOrder';
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
			        	updateTabContent("#tab1");
			        	updateTabContent("#tab2");
			        	updateTabContent("#tab3");
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

	
	<div class="order-detail-body">
		<?php foreach ($orderItems as $item):?>
			<div class="order-item item-1">
				<div class="order-line line-1">
					<label class="name">名称：<?php echo $item->product_id; ?></label>
					<label class="type">类型：无</label>
					<a class="modify" data-toggle="modal" href="#event-editor">修改</a>
				</div>
				<div class="order-line line-2">
					<label class="number">数量：<?php echo $item->number; ?></label>
					<label class="price">价格：<?php echo $item->price; ?></label>
				</div>
				<div class="order-line line-4">
					<div class="discount-icon">
						<span class='glyphicon glyphicon-trash'></span>
					</div>
					<label class="total">总价：<?php echo $item->price*$item->number; ?></label>
				</div>
			</div>
		<?php endforeach;?>
		<div class="order-item add-item">
			<label class="add-item-text">添加条目</label>
		</div>

	</div>
</div>