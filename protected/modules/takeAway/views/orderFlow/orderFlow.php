		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/order-flow.css" rel="stylesheet" type="text/css">
		<div id="action-name">
		</div>
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
				        	'content'=>$this->actionInit(),
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
				<script type="text/javascript">
				var currentTab = "#tab1";
				//加载订单列表
				function loadContent(e){

				    var tabId = e.target.getAttribute("href");

				    var ctUrl = ''; 
				    currentTab = tabId;
				   // alert(currentTab);
				    var day = $('.order-footer .order-date-container').attr("id");
				    if(tabId == '#tab1') {
						ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/notSend';
				    } else if(tabId == '#tab2') {
				        ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/sended';
				    } else if(tabId == '#tab3') {
				    	ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/cancel';
				    }

				    if(ctUrl != '') {
				        $.ajax({
				            url      : ctUrl,
				            type     : 'POST',
				            dataType : 'html',
				            data	 :{day:day},
				            cache    : false,
				            success  : function(html)
				            {
				            	//alert(html);
				                jQuery(tabId).html(html);
				                var orderId = $((tabId+" .order-body ul>li .order-item ul>li.order-content")).attr("id");
				                getOrderItems(orderId);

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
					<li><div class="footer-right-btn new-order">+订单</div></li>
				</ul>
			</div>
		</div>
		<div class='order-detail'>
			<?php 
				echo $this->actionfirstGetOrderItems();
			?>
		</div>
		<script type="text/javascript">

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
			    updateListener();
			    $('.order-footer .footer-btn.order-left').click(function(){
			    	dayBack();
			    });
			    $('.order-footer .footer-btn.order-right').click(function(){
			    	dayFront();
			    });
			    var currentDate = new Date().Format("yyyy-MM-dd");
				$('.order-footer .order-footer-wrap .order-footer-date').html(currentDate);
			});

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
				//alert(date);
			}

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
				}else{
					alert("已经是最新的日期");
				}
				//alert(date);
			}

			/*
				当有新订单来时更新订单和TabTitle
			*/
			function updateListener(){
			    var orders=[];
			    var tempList = $('.order-body ul>li .order-item ul>li.order-content').each(function(){
    				//alert($(this).html());\
    				orders.push($(this).attr("id"));
  				});
  				//获取tab头
  				var nums = [];
  				nums.push(getTabHeaders("#tab1"));
  				nums.push(getTabHeaders("#tab2"));
  				nums.push(getTabHeaders("#tab3"));
			    var date = "xx";
			    var place = "xx";
			    $.ajax({
			        type:'POST',
			        dataType: 'json',
			        url:  '/wcptf/index.php?r=takeAway/orderFlow/update',
			        timeout: 60000,
			        data:{time:'2', existList:orders, nums:nums, date:date, place:place, filter:currentTab},
			        success:function(data,textStatus){
			            if(data.success=='1'){
			                updateTabContent(currentTab);
			              //  alert(nums[1]!=(data.nums[1]));
			                updateTabHeaders("#tab1", data.nums[0]);
			                updateTabHeaders("#tab2", data.nums[1]);
			                updateTabHeaders("#tab3", data.nums[2]);
			                updateListener();
			            }
			            if(data.success=='2'){
			            	updateTabHeaders("#tab1", data.nums[0]);
			                updateTabHeaders("#tab2", data.nums[1]);
			                updateTabHeaders("#tab3", data.nums[2]);
			                updateListener();
			            }
			            if(data.success=='0'){
			                updateListener();
			            }
			        },
			        error:function(XMLHttpRequest,textStatus,errorThrown){    
			            if(textStatus=="timeout"){    
			                updateListener();    
			            }    
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
			//更新订单Tab头
			function updateTabHeaders(tabId, num){
				$('.order-header ul.nav.nav-tabs>li a').each(function(){
					if(tabId==$(this).attr("href")){
						var content = $(this).html();
						var pattern = /\(\d*\)/;
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
			    currentTab = tabId;
			   // alert(currentTab);
			   var day = $('.order-footer .order-date-container').attr("id");
			    if(tabId == '#tab1') {
					ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/notSend';
			    } else if(tabId == '#tab2') {
			        ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/sended';
			    } else if(tabId == '#tab3') {
			    	ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/cancel';
			    }

			    if(ctUrl != '') {
			        $.ajax({
			            url      : ctUrl,
			            type     : 'POST',
			            dataType : 'html',
			            data 	 : {day: day},
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
			//获取订单Items
			function getOrderItems(orderId){

			    var ctUrl = ''; 

				ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/getOrderItems'; 

			    if(ctUrl != '') {
			        $.ajax({
			            url      : ctUrl,
			            type     : 'POST',
			            data     :  {'orderId': orderId},
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
		