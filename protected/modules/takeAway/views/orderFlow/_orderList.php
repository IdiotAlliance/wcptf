<script type="text/javascript">
	$(document).ready(function(){
		//点击订单
		$(".order-body ul>li .order-item ul>li.order-content").mousedown(function(){
			if($(this).css("background-color") == 'rgb(247, 247, 247)'){
				$('.order-body ul>li .order-item ul>li.order-content').css("background-color", "#f7f7f7");
			}
			$(this).css("background-color", "#e7e7e7");
		});
		$(".order-body ul>li .order-item ul>li.order-content").mouseup(function(){
			//更新订单详情
			var orderId = $(this).attr("id");
			//alert(orderId);
			getOrderItems(orderId);
		})
	});
</script>
<div class="order-body">
	<div class="order-body-scroll">
		<ul class="order-list">
			<?php foreach ($orders as $order):?>
				<li>
					<div <?php if($order->status=="待派送"){
						echo 'class="order-item item-wait">';}
						else {
							echo 'class="order-item item-produce">';
						}
						?>
						<ul>
							<li class="order-state ">
								<div class="state">
									<label><?php echo $order->status; ?></label>
								</div>
							</li>
							<li class="order-content" <?php echo 'id = "'.$order->id.'">'; ?>
								<div class="content">
									<div class="item-line item-line1">
										<label class="order-username">预约人：<?php echo $order->member_id; ?></label>
										<label class="order-phonenumber">电话：<?php echo $order->phone; ?></label>
										<label class="order-id">订单号：<?php echo $order->order_no; ?></label>
										<span class="order-checkbox">
											<input type="checkbox">
											</span>
									</div>
									<div class="item-line item-line2">
										<label class="order-address">配送地址：<?php echo $order->address; ?></label>
									</div>
									<div class="item-line item-line3">
										<label class="order-total">订单总价：<?php echo $order->total; ?></label>
										<label class="order-discount">派送人员：<?php echo $order->poster_id; ?></label>
										<div class="discount-icon">
											<span class='glyphicon glyphicon-trash'></span>
										</div>
									</div>
									<div class="item-line item-line4">
									</div>
									<div class="item-line item-line5">
										<label class="order-subitem-header">订单子项：</label>
										<label class="order-subitem order-1"><?php echo $order->seller_id; ?></label>
									</div>
									<div class="item-line item-line6">
										<label class="order-desc">备注：<?php echo $order->description; ?></label>
										<label class="order-date">下单时间：<?php echo $order->ctime; ?></label>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</li>
			<?php endforeach;?>
		</ul>
	</div>
</div>