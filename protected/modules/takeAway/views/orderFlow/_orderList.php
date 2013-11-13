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
						getOrderItems();
					})
				});
			</script>
			<div class="order-body">
				<div class="order-body-scroll">
					<ul class="order-list">
						<li>
							<div class="order-item item-wait">
								<ul>
									<li class="order-state ">
										<div class="state">
											<label>待派送</label>
										</div>
									</li>
									<li class="order-content">
										<div class="content">
											<div class="item-line item-line1">
												<label class="order-username">预约人：李先生</label>
												<label class="order-phonenumber">电话：14009787649</label>
												<label class="order-id">订单号：s92012839898</label>
												<label class="order-type">(微信下单)</label>
												<span class="order-checkbox">
        											<input type="checkbox">
      											</span>
											</div>
											<div class="item-line item-line2">
												<label class="order-address">配送地址：南大鼓楼图书馆 图书馆1楼</label>
											</div>
											<div class="item-line item-line3">
												<label class="order-total">订单总价：78元</label>
												<label class="order-discount">优惠：</label>
												<div class="discount-icon">
													<span class='glyphicon glyphicon-trash'></span>
												</div>
											</div>
											<div class="item-line item-line4">
											</div>
											<div class="item-line item-line5">
												<label class="order-subitem-header">订单子项：</label>
												<label class="order-subitem order-1">xxx1*4</label>
												<label class="order-subitem order-2">xxx3*2</label>
											</div>
											<div class="item-line item-line6">
												<label class="order-desc">备注：快一点，慢了不要啊</label>
												<label class="order-date">下单时间：2013-09-13 09:02</label>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</li>
						<li>
							<div class="order-item item-produce">
								<ul>
									<li class="order-state">
										<div class="state">
											<label>待生产</label>
										</div>
									</li>
									<li class="order-content">
										<div class="content">
											<div class="item-line item-line1">
												<label class="order-username">预约人：李先生</label>
												<label class="order-phonenumber">电话：14009787649</label>
												<label class="order-id">订单号：s92012839898</label>
												<label class="order-type">(微信下单)</label>
        										<span class="order-checkbox">
	        										<input type="checkbox">
    	  										</span>
											</div>
											<div class="item-line item-line2">
												<label class="order-address">配送地址：南大鼓楼图书馆 图书馆1楼</label>
											</div>
											<div class="item-line item-line3">
												<label class="order-total">订单总价：78元</label>
												<label class="order-discount">优惠：</label>
												<div class="discount-icon">
													<span class='glyphicon glyphicon-trash'></span>
												</div>
											</div>
											<div class="item-line item-line4">
											</div>
											<div class="item-line item-line5">
												<label class="order-subitem-header">订单子项：</label>
												<label class="order-subitem order-1">xxx1*4</label>
												<label class="order-subitem order-2">xxx3*2
													<a href="#">未完成</a>
												</label>
											</div>
											<div class="item-line item-line6">
												<label class="order-desc">备注：快一点，慢了不要啊</label>
												<label class="order-date">下单时间：2013-09-13 09:02</label>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</li>
						<li>
							<div class="order-item">
								xxxxx
							</div>
						</li>
					</ul>
				</div>
			</div>