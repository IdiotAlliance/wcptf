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
				            	getOrderItems(orderId);
				                jQuery(tabId).html(html);
				                var orderId = $((tabId+" .order-body ul>li .order-item ul>li.order-content")).attr("id");
				               
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
				<!--popover菜单-->
				<ul id='popup' style="display:none">
				</ul>
			</div>
		</div>
		<div class='order-detail'>
			<?php 
				echo $this->actionfirstGetOrderItems();
			?>
		</div>
		<script type="text/javascript">
			var lastIntervalId = "wcptf_default";

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
			});
			// 获取
			function fetchAreas(){
				var ctUrl = '/wcptf/index.php?r=takeAway/orderFlow/fetchAreas';
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
			        url:  '/wcptf/index.php?r=takeAway/orderFlow/updateOperate',
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
			    var tempList = $('.order-body ul>li .order-item ul>li.order-content').each(function(){
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
			        url:  '/wcptf/index.php?r=takeAway/orderFlow/update',
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
			   // alert(currentTab);
			    var day = $('.order-footer .order-date-container').attr("id");
			    var areaId = $('.order-footer .order-area-container').attr("id");
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
			            data 	 : {day: day, areaId: areaId},
			            cache    : false,
			            success  : function(html)
			            {
			            	//alert(html);
			                jQuery(tabId).html(html);
			                var orderId = $('#tab1 .order-body .order-list li .order-item .order-content').first().attr("id");
			                if(orderId != null){
			                	getOrderItems(orderId);
			                }else{
			                	getOrderItems(-1);
			                }
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
		