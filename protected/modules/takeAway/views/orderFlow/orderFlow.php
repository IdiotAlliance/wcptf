		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/order-flow.css" rel="stylesheet" type="text/css">
		<div id="action-name">
		</div>
		<div class="order">
			<div class="order-header">
				<?php $this->widget('bootstrap.widgets.TbTabs', array(
					'id'=>'order-header-content',
				    'type'=>'tabs', // 'tabs' or 'pills'
				    'tabs'=>array(
				        array(
				        	'id'=>'tab1',
				        	'label'=>'未派送(10)', 
				        	'content'=>$this->renderPartial('_orderList', null, true, false),
				        	'active'=>true),
				        array(
				        	'id'=>'tab2',
				        	'label'=>'已派送(30)', 
				        	'content'=>'loading',
				        	),
				    ),
				    'events'=>array('shown'=>'js:loadContent'),
				)); ?>
				<script type="text/javascript">
				//加载订单列表
				function loadContent(e){

				    var tabId = e.target.getAttribute("href");

				    var ctUrl = ''; 

				    if(tabId == '#tab1') {
						ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/notSend';
				    } else if(tabId == '#tab2') {
				        ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/sended';
				    } 

				    if(ctUrl != '') {
				        $.ajax({
				            url      : ctUrl,
				            type     : 'POST',
				            dataType : 'html',
				            cache    : false,
				            success  : function(html)
				            {
				            	//alert(html);
				                jQuery(tabId).html(html);
				            },
				            error:function(){
				                    alert('Request failed');
				            }
				        });
				    }
				    return false;
				}
				</script>
			</div>
			<div class="order-footer">
				<ul>
					<li><div class="footer-left-btn area-picker">片区高亮</div></li>
					<li><div class="footer-left-btn type-picker">显示全部</div></li>
					<li>
						<div class="footer-btn order-left"><i class="icon-chevron-left"></i></div>
					</li>
					<li>
						<label class="order-footer-title">今天：2013-10-1</br>
				总销量：10 总订单数：5 总收入520￥</label>
					</li>
					<li>
						<div class="footer-btn order-right"><i class="icon-chevron-right"></i></span></div>
					</li>
					<li><div class="footer-right-btn all-edit">批量</div></li>
					<li><div class="footer-right-btn new-order">+订单</div></li>
				</ul>
			</div>
		</div>
		<div class='order-detail'>
			<?php 
				echo $this->renderPartial('_orderItems', null, true, false);
			?>
		</div>
		<script type="text/javascript">
			//获取订单Items
			function getOrderItems(){

			    //var tabId = e.target.getAttribute("href");

			    var ctUrl = ''; 

				ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/getOrderItems'; 

			    if(ctUrl != '') {
			        $.ajax({
			            url      : ctUrl,
			            type     : 'POST',
			            dataType : 'html',
			            cache    : false,
			            success  : function(html)
			            {
			            	//alert(html);
			                jQuery('.order-detail').html(html);
			            },
			            error:function(){
			                    alert('Request failed');
			            }
			        });
			    }
			    return false;
			}
		</script>
		