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
						ctUrl = '/weChat/index.php?r=takeAway/orderFlow/notSend';
				    } else if(tabId == '#tab2') {
				        ctUrl = '/weChat/index.php?r=takeAway/orderFlow/sended';
				    } else if(tabId == '#tab3') {
				    	ctUrl = '/weChat/index.php?r=takeAway/orderFlow/cancel';
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
				                $('.footer-right-btn.all-pick').html("全选");
				                var orderId = $((tabId+" .order-body ul>li .order-item ul>li.order-content")).attr("id");
				                $((tabId+" .order-body ul>li .order-item ul>li.order-content")).first().css("background-color", "#e7e7e7");
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
			<?php 
				echo $this->actionfirstGetOrderItems();
			?>
		</div>
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
					var orders = getBatOrders();
					if(orders.length==0){
						alert("请选择一个订单！");
					}else{
						$('.order-footer .isBatOperate').attr('id', 1);
						$('#choosePosterModal').modal('show');
					}
					// batDispatchOrders();
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
			});

			// 全选订单 或取消
			function pickAll(){
				var menu = $('.footer-right-btn.all-pick').html();
				var ele = ' .order-body ul>li .order-item ul>li.order-content .order-checkbox input';
				ele = currentTab + ele;
				if(menu=='全选'){
					$(ele).each(function(){
    				//alert($(this).html());
	    				$(this).attr("checked", true);
	    				$('.footer-right-btn.all-pick').html("取消全选");
  					});
				}else{
					$(ele).each(function(){
    				//alert($(this).html());
	    				$(this).attr("checked", false);
	    				$('.footer-right-btn.all-pick').html("全选");
  					});
				}
			}

			// 批量派送订单
			function batDispatchOrders(){
				var orders = getBatOrders();
				if(orders.length==0){
					alert("请选择一个订单！");
					return false;
				}
				var posterId = $("input[name='ChoosePosterForm[poster]']:checked").val();
				alert(posterId);
				if(posterId==null){
					alert("没有选择派送人员!");
				}else{
					ctUrl = '/weChat/index.php/takeAway/orderFlow/batSetPosters';
					if(ctUrl != '') {
					    $.ajax({
					        url      : ctUrl,
					        type     : 'POST',
					        dataType : 'json',
					        data 	 : {orderIds:orders, posterId:posterId},
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
			// 批量完成订单
			function batfinishOrders(){
				var orders = getBatOrders();
				if(orders.length==0){
					alert("请选择一个订单！");
					return false;
				}
				ctUrl = '/weChat/index.php/takeAway/orderFlow/batFinishOrder';
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
				        data 	 : {orderIds:orders},
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
				        			h2 = parseInt(h2)+orders.length;
				        			h1 = parseInt(h1)-orders.length;
				        			updateTabHeaders('#tab1', h1);
				        			updateTabHeaders('#tab2', h2);
				        		}
				        		if(currentTab == '#tab3'){
				        			h2 = parseInt(h2)+orders.length;
				        			h3 = parseInt(h3)-orders.length;
				        			updateTabHeaders('#tab3', h3);
				        			updateTabHeaders('#tab2', h2);
				        		}
				        		alert("订单已完成");
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
			// 批量取消订单
			function batCancelOrders(){
				var orders = getBatOrders();
				if(orders.length==0){
					alert("请选择一个订单！");
					return false;
				}
				ctUrl = '/weChat/index.php/takeAway/orderFlow/batCancelOrder';
				if(currentTab=='#tab3'){
					alert('该订单处于取消状态！');
					return false;
				}
				if(ctUrl != '') {
				    $.ajax({
				        url      : ctUrl,
				        type     : 'POST',
				        dataType : 'json',
				        data 	 : {orderIds:orders},
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
				        			h3 = parseInt(h3)+orders.length;
				        			h1 = parseInt(h1)-orders.length;
				        			updateTabHeaders('#tab1', h1);
				        			updateTabHeaders('#tab3', h3);
				        		}
				        		if(currentTab == '#tab2'){
				        			h2 = parseInt(h2)-orders.length;
				        			h3 = parseInt(h3)+orders.length;
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
			// 获取批量订单
			function getBatOrders(){
				var chosenOrders=[];
				var ele = ' .order-body ul>li .order-item ul>li.order-content .order-checkbox input';
				ele = currentTab + ele;
			    $(ele).each(function(){
    				if($(this).is(':checked')){
    					chosenOrders.push($(this).attr("value"));
    				}
  				});
  				return chosenOrders;
			}
			// 缓存选中订单
			function setBatOrdersCache(){
				var orders = getBatOrders();
				//alert(orders);
				$('.order-footer .batOrderCache').attr("id", orders);
			}
			// 获取缓存选中订单
			function getBatOrdersCache(){
				var orders = $('.order-footer .batOrderCache').attr("id");
				//alert(orders);
				var ele = ' .order-body ul>li .order-item ul>li.order-content .order-checkbox input';
				var ele = currentTab + ele;
			    $(ele).each(function(){
    				if($.inArray($(this).attr('value'), orders) != -1){
    					$(this).attr('checked', true);
    				}
  				});
  				$('.order-footer .batOrderCache').attr("id", 0);
			}
			// 获取派送地区
			function fetchAreas(){
				var ctUrl = '/weChat/index.php/takeAway/orderFlow/fetchAreas';
				$.ajax({
				    url      : ctUrl,
				    type     : 'POST',
				    dataType : 'json',
				    cache    : false,
				    success  : function(data)
				    {
				    	//alert(html);
				        if(data.success == 0){
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
				updateOperate();
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
				updateOperate();
				var currentDate = new Date(a).Format("yyyy-MM-dd");
				$('.order-footer .order-footer-wrap .order-footer-date').html(currentDate);
				//alert(date);
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
					updateOperate();
					var currentDate = new Date(a).Format("yyyy-MM-dd");
					$('.order-footer .order-footer-wrap .order-footer-date').html(currentDate);
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
			function updateListener(){
			    var orders=[];
			    $(currentTab+' .order-body ul>li .order-item ul>li.order-content').each(function(){
    				//alert($(this).html());\
    				orders.push($(this).attr("id"));
  				});
  				//获取tab头
  				var nums = [];
  				var temp1 = getTabHeaders("#tab1");
  				var temp2 = getTabHeaders("#tab2");
  				var temp3 = getTabHeaders("#tab3");
  				nums.push(temp1);
  				nums.push(temp2);
  				nums.push(temp3);
  				//获取当前的偏移时间
			    var day = $('.order-footer .order-date-container').attr("id");
			    var areaId = $('.order-footer .order-area-container').attr("id");
			    $.ajax({
			        type:'POST',
			        dataType: 'json',
			        url:  '/weChat/index.php/takeAway/orderFlow/update',
			        timeout: 60000,
			        data:{time:'1', existList:orders, nums:nums, day:day, areaId:areaId, filter:currentTab},
			        success:function(data,textStatus){
			            if(data.success=='1'){
			                updateTabContent(currentTab);
			              //  alert(nums[1]!=(data.nums[1]));
			                updateTabHeaders("#tab1", data.nums[0]);
			                updateTabHeaders("#tab2", data.nums[1]);
			                updateTabHeaders("#tab3", data.nums[2]);
			            }
			            if(data.success=='2'){
			            	updateTabHeaders("#tab1", data.nums[0]);
			                updateTabHeaders("#tab2", data.nums[1]);
			                updateTabHeaders("#tab3", data.nums[2]);
			            }
			            if(data.success=='0'){
			            }
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

				ctUrl = '/weChat/index.php/takeAway/orderFlow/getOrderItems'; 

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
		