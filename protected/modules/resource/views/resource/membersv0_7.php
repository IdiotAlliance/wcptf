
$(document).ready(function() {
    flikr.prepare();
    // flikr.start();
    $('#flikr_loading').hide();
    $('#chart_container').click(function(){
    	dismissOrderChart();
    });
    $('.switch_container .onoff_switch').click(function(){
    	if(window.MEMBERS.switchon){
	    	$.ajax({
				url: '<?php echo Yii::app()->createUrl("takeAway/members/memberBoundOff/sid")?>/' + window.MEMBERS.sid,
				success: function(result){
					if(result == '0'){
						$('.switch_container .onoff_switch').removeClass('on');
						$('.switch_container .onoff_switch').addClass('off');
						window.MEMBERS.switchon = 0;
					}
				},
				fail: function(){
					alert('未能关闭该功能，请稍后重试');
				}
			});
    	}else{
    		if(confirm('您将要开启会员卡绑定功能, 开启该功能需要使用短信服务，系统将会向您收取0.1元/条的短信服务费，是否确定开启？')){
    			
    			$.ajax({
    				url: '<?php echo Yii::app()->createUrl("takeAway/members/memberBoundOn")?>/sid/' + window.MEMBERS.sid,
    				success: function(result){
    					if(result == '0'){
    						$('.switch_container .onoff_switch').removeClass('off');
    						$('.switch_container .onoff_switch').addClass('on');
    						window.MEMBERS.switchon = 1;
    					}
    				},
    				fail: function(){
    					alert('未能开启该功能，请稍后重试');
    				}
    			});
    			window.MEMBERS.switchon = 1;
    		}
    	}
    });
});
var flikr = {
		playHandler: null,
		movex: null,
		
		moveleft: function (el) {
	        $(el).animate({
	            left: '+='+movex
	        }, 800, function() {
	            $(el).css("z-index", "-100");
	        });
	    },
		moveright: function (el) {
	        $(el).animate({
	            left: '-='+movex
	        }, 800, function() {
	            $(el).css("z-index", "100");
	        });
	    },
	    playAnimation: function () {
	        flikr.moveleft("#shapeblue");
	        flikr.moveright("#shapeblue");
	        flikr.moveright("#shapepink");
	        flikr.moveleft("#shapepink");
	    },
	    prepare: function(){
	    	var wwidth = $('#flikr_loading').width();
		    var bluewidth = $("#shapeblue").width();
		    $("#shapeblue").css("left", (wwidth/2) - bluewidth);
		    var bluepos = $("#shapeblue").position();
		    movex = $("#shapeblue").width() + 4;
		    $("#shapepink").css("left", bluepos.left + movex);	
		},
	    start: function(){
		    flikr.playAnimation();
			playHandler = setInterval(flikr.playAnimation, 800);
		},
		stop: function(){
			clearInterval(playHandler);
		}
}

function onMemberItemClick(item){
	showLoading();
	$('.member_item').removeClass('selected');
	$(item).addClass('selected');
	memid = $(item).attr('name');
	$.ajax({
		type: 'GET',
		url: "<?php echo Yii::app()->createUrl('takeAway/members/getHistory')?>/memberId/" + memid + "?sid=" + window.MEMBERS.sid,
		dataType: 'json',
		success: function(result){
			refreshDetailsBoard(result);
			dismissLoading();
		},
		error: function(result){
			dismissLoading();
		},
	});
}

/**
 * 刷新详细信息面板
 */
function refreshDetailsBoard(data){
	// console.log(data);
	window.MEMBERS.member   = data['member'];
	window.MEMBERS.orders   = data['orders'];
	window.MEMBERS.comments = data['comments'];
	// messages = data['messages'];
	window.MEMBERS.chartData = new Array();
	
	$('#order_count_' + window.MEMBERS.member['id']).html('订单数量：' + window.MEMBERS.orders.length);
	$('#comment_count_' + window.MEMBERS.member['id']).html('评论数量：' + window.MEMBERS.comments.length);
	// 设置基本信息
	$('#tab1').html(
		'<h4>用户编号：' + window.MEMBERS.member['id'] + '</h4>' +
		'<div>关注状态：<span class="label label-' + (window.MEMBERS.member['unsubscribed']=="1"?'important':'info') + 
		'">' + (window.MEMBERS.member['unsubscribed']=="1"?'已取消关注':'已关注') + '</span>&nbsp;&nbsp;&nbsp;&nbsp;' +
		'绑定状态:&nbsp;&nbsp;<span class="label label-' + (window.MEMBERS.member['bound']=="1"?"success":(window.MEMBERS.member['request']=="1"?"warning":"info")) + '">' +
		(window.MEMBERS.member['bound']=="1"?"已绑定":(window.MEMBERS.member['request']=="1"?"请求绑定":"未绑定")) + '</span>' +
		'<span>&nbsp;&nbsp;&nbsp;关注日期：' + window.MEMBERS.member['ctime'] + '</span></div><br>' +
		'<table class="table table-bordered">' + 
			'<thead><tr>' + 
				'<th colspan="2">' + 
					'会员信息' + 
					(window.MEMBERS.member['request'] == "1" ? 
						'<div class="btn btn-primary mem-op-btn" onclick="confirmMember()">确认</div>' +
						'<div class="btn btn-danger mem-op-btn" onclick="cancelMember()">取消</div>'
						:(window.MEMBERS.member['bound']=="1"?
							'<div class="btn btn-danger mem-op-btn" onclick="deleteMember()">删除会员</div>':'')
					) + 
				'</th></tr>' + 
			'</thead>' + 
			'<tbody>' + 
				'<tr><td>会员号</td><td>' + (window.MEMBERS.member['cardno']?window.MEMBERS.member['cardno']:'未设置') + '</td></tr>' + 
				'<tr><td>会员积分</td><td>' + window.MEMBERS.member['credits'] + '</td></tr>' + 
				'<tr><td>电话号码</td><td>' + (window.MEMBERS.member['phone']?window.MEMBERS.member['phone']:'未设置') + '</td></tr>' +
			'</tbody>' +
		'</table>' + 
		'<table class="table table-bordered">' +
			'<thead><tr><th>微信信息</th></tr></thead>' +
			'<tbody>' +
				'<tr><td>微信openid</td><td>' + window.MEMBERS.member['openid'] + '</td></tr>' +
				'<tr><td>微信昵称</td><td>' + (window.MEMBERS.member['wxnickname']?window.MEMBERS.member['wxnickname']:'未知') + '</td></tr>' +
			'</tbody>' +
		'</table>'
	);
	
	// 设置订单信息
	if(window.MEMBERS.orders.length > 0){
		var html = '<b>历史订单</b>' + 
						  '<span class="table-btn-container">' + 
								'<img src="<?php echo Yii::app()->baseUrl?>/img/icon-chart.jpg" class="img-btn" onclick="showOrderChart()">' + 
								'<a href="' + '<?php echo Yii::app()->createUrl("takeAway/members/downloadExcel")?>/memberId/' + window.MEMBERS.member['id'] +
								'">' + '<img src="<?php echo Yii::app()->baseUrl?>/img/icon-excel.jpg" class="img-btn"></a>' + 
						  '</span>' +
						  '<table class="table">' +
						  	'<tbody><tr><td>编号</td><td>下单日期</th><td>状态</td><td>总价</td><td>详情</td></tr>';
		window.MEMBERS.chartData = new Array();
		for(index in window.MEMBERS.orders){
			var order = window.MEMBERS.orders[index];
			var status = order['status']=='1'?'已完成':(order['status']=='3'?'已取消':'进行中');
			var trclass = order['status']=='1'?'success':(order['status']=='3'?'error':'warning');
			html += '<tr class="' + trclass + '">' + 
						'<td>' + order['order_no'] + '</td>' +
						'<td>' + order['ctime'] + '</td>' +
						'<td >' + status + '</td>' +
						'<td>' + order['price'] + '</td>' +
						'<td>' + order['items'] + '</td>' +
					'</tr>';
			window.MEMBERS.chartData[index] = new Array();
			window.MEMBERS.chartData[index].push(Date.parse(order['ctime']));
			window.MEMBERS.chartData[index].push(parseFloat(order['price']));
		}
		window.MEMBERS.chartData.sort(function(a, b){return a[0] > b[0]?1:-1});
		html += '</tbody></table>'
		$('#tab2').html(html);
		
	}else{
		$('#tab2').html(
			'<div>这位用户还木有下过单呐</div>'
		);
	}
	
	// 设置评论信息
	if(window.MEMBERS.comments.length > 0){
		var html = '<table class="table">' + 
				   		'<thead><tr><th>历史评论</th></tr></thead>' +
				   		'<thead><tr><th>评论日期</th><th>评论内容</th></thead>';
		for(index in window.MEMBERS.comments){
			var comment = window.MEMBERS.comments[index];
			html += '<tr><td>' + comment['ctime'] + '</td>' +
					    '<td>' + comment['comment'] + '</td>' + 
					'</tr>';
		}
		html += '</table>';
		$('#tab3').html(
				html
		);
	}else{
		$('#tab3').html(
			'<div>这位用户还木有发表过评论</div>'
		);
	}
}

function filterMembers(){
	var value = $('#member_filter_select').val();
	if(value == 'all'){
		$('.member_item').removeClass('hidden');
	}else if(value == 'subscribed'){
		$('.member_item').addClass('hidden');
		$('.member_item.subscribed').removeClass('hidden');
	}else if(value == 'bound'){
		$('.member_item').addClass('hidden');
		$('.member_item.bound').removeClass('hidden');
	}else if(value == 'request'){
		$('.member_item').addClass('hidden');
		$('.member_item.request').removeClass('hidden');
	}
	else if(value=='unsubscribed'){
		$('.member_item').addClass('hidden');
		$('.member_item.unsubscribed').removeClass('hidden');
	}
}

function showLoading(){
	flikr.start();
	$('#flikr_loading').fadeIn();
}

function dismissLoading(){
	flikr.stop();
	$('#flikr_loading').fadeOut();
}

function showOrderChart(){
	if(window.MEMBERS.orders.length > 0){
		$('#chart_container').fadeIn();
		// 创建highchart表
		$('#container').html('');
		$('#container').highcharts('StockChart', {
			rangeSelector : {
				selected : 1
			},

			title : {
				text : '用户订单消费记录'
			},
			
			series : [{
				name : '消费',
				data : window.MEMBERS.chartData,
				marker : {
					enabled : true,
					radius : 3
				},
				shadow : true,
				tooltip : {
					valueDecimals : 2
				}
			}]
		});
	}
}

function dismissOrderChart(){
	$('#chart_container').fadeOut();
}

function confirmMember() {
	if(window.MEMBERS.member && confirm("确认该用户的会员资格？")){
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('takeAway/members/confirmMember/memberId/')?>" + 
				 "/" + window.MEMBERS.member['id'] + "?sid=" + window.MEMBERS.sid
			}).success(function (data){
			if (data == 'ok'){
				var item = $('#member_item_' + window.MEMBERS.member['id']);
				$('#option_bnd').html("已绑定会员卡(" + (++window.MEMBERS.cbound) + ")");
				$('#option_req').html("请求绑定会员卡(" + (--window.MEMBERS.crequest) + ")");
				item.removeClass('request');
				item.addClass('bound');
				if(window.MEMBERS.member['unsubscribed'] != '1'){
					var label = item.find('#item_label_' + window.MEMBERS.member['id']);
					label.removeClass('label-warning');
					label.addClass('label-success');
					label.html('已绑定');
				}else{
					var label = item.find('#item_label_' + window.MEMBERS.member['id']);
					label.removeClass('label-warning');
					label.addClass('label-important');
					label.html('已取消关注');
				}
				item.click();
				filterMembers();
			}else{
				alert('绑定失败');
			}
		});
	}
}

function cancelMember(){
	if(window.MEMBERS.member && confirm("您确定要拒绝该用户的会员绑定申请吗？")){
		$.ajax({
				url: "<?php echo Yii::app()->createUrl('takeAway/members/cancelMember/memberId/')?>" + 
				 "/" + window.MEMBERS.member['id'] + "?sid=" + window.MEMBERS.sid
			}).success(function (data){
			if (data == 'ok'){
				var item = $('#member_item_' + window.MEMBERS.member['id']);
				$('#option_req').html("请求绑定会员卡(" + (--window.MEMBERS.crequest) + ")");
				item.removeClass('request');
				if(window.MEMBERS.member['unsubscribed'] != '1'){
					var label = item.find('#item_label_' + window.MEMBERS.member['id']);
					label.removeClass('label-warning');
					label.addClass('label-info');
					label.html('已关注');
				}else{
					var label = item.find('#item_label_' + window.MEMBERS.member['id']);
					label.removeClass('label-warning');
					label.addClass('label-important');
					label.html('已取消关注');
				}
				item.click();
				filterMembers();
			}else{
				alert('操作失败');
			}
		});
	}
}

function deleteMember(){
	if(window.MEMBERS.member && confirm("您确定要删除该会员吗？这会导致丢失该会员的积分等信息")){
		$.ajax({
				url: "<?php echo Yii::app()->createUrl('takeAway/members/deleteMember/memberId/')?>" + 
				 "/" + window.MEMBERS.member['id'] + "?sid=" + window.MEMBERS.sid
			}).success(function (data){
			if (data == 'ok'){
				var item = $('#member_item_' + window.MEMBERS.member['id']);
				$('#option_bnd').html("已绑定会员卡(" + (--window.MEMBERS.cbound) + ")");
				item.removeClass('bound');
				if(window.MEMBERS.member['unsubscribed'] != '1'){
					var label = item.find('#item_label_' + window.MEMBERS.member['id']);
					label.removeClass('label-success');
					label.addClass('label-info');
					label.html('已关注');
				}else{
					var label = item.find('#item_label_' + window.MEMBERS.member['id']);
					label.removeClass('label-success');
					label.addClass('label-important');
					label.html('已取消关注');
				}
				item.click();
				filterMembers();
			}else{
				alert('操作失败');
			}
		});
	}
}