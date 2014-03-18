
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
		ctUrl = '/index.php/takeAway/orderFlow/notSend';
    } else if(tabId == '#tab2') {
        ctUrl = '/index.php/takeAway/orderFlow/sended';
    } else if(tabId == '#tab3') {
    	ctUrl = '/index.php/takeAway/orderFlow/cancel';
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