<?php ?>
<style>
	#members_member_list_container{
		position: absolute;
		width: 400px;
		left: 200px;
		top: 41px;
		bottom: 0px;
	}
	#members_detail_container{
		position: absolute;
		left: 600px;
		top: 41px;
		bottom: 0px;
		right: 0px;
		overflow: auto;
		box-sizing: border-box;
		-moz-box-shadow: 0 0 5px rgba(0,0,0,0.15);
		-webkit-box-shadow: 0 0 5px rgba(0,0,0,0.15);
		box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	}
	.members_title{
		position: fixed;
		width: 390px;
		padding-top: 10px;
		padding-bottom: 10px;
		padding-left: 10px;
		box-shadow: -1px 1px 3px #808080;
		margin-top: 0px;
		overflow: hidden;
	}
	.filter_right{
		float: right;
		margin-right: 10px;
		margin-top: -35px;
	}
	.members_list{
		position: absolute;
		left: 0px;
		top: 68px;
		bottom: 0px;
		width: 100%;
		overflow-x: hidden !important;
		overflow-y: auto !important;
	}
	.member_item{
		width: 100%;
		height: 54px;
		padding: 8px 0 13px 10px;
		overflow: hidden;
		border-bottom: 1px solid #d3d3d3;
	}
	.member_item:hover{
		cursor: pointer;
		background-color:#ecf2f5;
  		background-image:-moz-linear-gradient(top, #f4fafd, #e0e5e8);
  		background-image:-ms-linear-gradient(top, #f4fafd, #e0e5e8);
  		background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#f4fafd), to(#e0e5e8));
 	 	background-image:-webkit-linear-gradient(top, #f4fafd, #e0e5e8);
  		background-image:-o-linear-gradient(top, #f4fafd, #e0e5e8);
 		background-image:linear-gradient(top, #f4fafd, #e0e5e8);
	}
	.member_item.selected{
		background-color: #f4fafd;
	}
	.subscribe_label{
		float: right;
		margin-right: 15px;
	}
	#flikr_loading{
		position: absolute;
		left: 0px;
		top: 0px;
		right: 0px;
		bottom: 0px;
		background-color: #ffffff;
		opacity: 0.8;
	}
	.bar {
		width: 50px;
		height: 50px;
		-webkit-border-radius: 7.5em;
		-moz-border-radius: 7.5em;
		border-radius: 7.5em;
		margin-right: 2px;
		position: absolute;
		top: 50%;
		margin-top: -50px;
	}
	#shapeblue {
		background: #0063dc;
		z-index: 1;
	}
	#shapepink {
		background: #ff0084;
		z-index: 0;
	}
	.tab{
		padding-left: 20px;
		padding-right: 20px;
	}
	#tab1 .mem-comfirm-btn{
		float: right;
	}
	.table-btn-container{
		float: right;
	}
	.img-btn{
		width: 25px;
		height: 25px;
		margin-left: 5px;
		border: 1px solid #ffffff;		
	}
	.img-btn:hover{
		cursor: pointer;
		border: 1px solid #808080;
	}
	#chart_container{
		position: absolute;
		left: 0px;
		top: 41px;
		right: 0px;
		bottom: 0px;
		background-color: #ffffff;
		opacity: 0.95;
		z-index: 3000;
		display: none;
	}
	#container{
		position: absolute;
		width: 800px;
		height: 500px;
		top: 50%;
		margin-top: -250px;
		left: 50%;
		margin-left: -400px;
	}
</style>
<div id="members_member_list_container">
	<div class="members_title">
		<h4>会员列表</h4>
		<div class="filter_right">
			<select onchange="filterMembers()" id="member_filter_select">
				<option id="option_all" value="all">全部(<?php echo $stats['total'];?>)</option>
				<option id="option_sub" value="subscribed">已关注(<?php echo $stats['sub'];?>)</option>
				<option id="option_bnd" value="bound">已绑定会员卡(<?php echo $stats['bound'];?>)</option>
				<option id="option_req" value="request">请求绑定会员卡(<?php echo $stats['request'];?>)</option>
				<option id="option_usb" value="unsubscribed">已取消关注(<?php echo $stats['unsub']?>)</option>
			</select>
		</div>
		<div class="sort_container">

		</div>
	</div>
	<ul class="members_list">
		<?php foreach ($model as $member):?>
			<li name="<?php echo $member['id']?>" class="member_item 
				<?php echo $member['unsubscribed']==1?'unsubscribed':'subscribed';
					  echo isset($member['bound']) && $member['bound'] == 1 ? ' bound' : '';
					  echo isset($member['request']) && $member['request'] == 1 ? ' request' : '';
				?>" 
				id="member_item_<?php echo $member['id']?>" onclick="onMemberItemClick(this)">
				<div class="member_no">
					用户编号：<?php echo $member['id'];?>
					<span id="item_label_<?php echo $member['id']?>" class="subscribe_label label 
						<?php echo $member['unsubscribed']==1?'label-important':
								   (isset($member['bound']) && $member['bound']==1?'label-success':
								   (isset($member['request']) && $member['request']==1?'label-warning':'label-info'));?>">
						<?php echo $member['unsubscribed']==1?'已取消关注':
								   (isset($member['bound']) && $member['bound']==1?'已绑定':
								   (isset($member['request']) && $member['request']==1?'请求绑定':'已关注'));?>
					</span>
					<div>
						<span id="order_count_<?php echo $member['id'];?>">订单数量：<?php echo $member['order_count'];?></span>
						<span id="comment_count_<?php echo $member['id'];?>">评论数量：<?php echo $member['comment_count'];?></span>
					</div>
					<div>关注日期：<?php echo $member['ctime']?></div>
				</div>
			</li>
		<?php endforeach;?>
	</ul>
</div>
<div id="members_detail_container">
  	<div class="tabbable" style="margin-bottom: 18px;">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">基本信息</a></li>
			<li class=""><a href="#tab2" data-toggle="tab">订单</a></li>
			<li class=""><a href="#tab3" data-toggle="tab">评论</a></li>
		</ul>
		<div class="tab-content" style="padding-bottom: 9px;">
			<div class="tab-pane tab active" id="tab1">
				<p></p>
			</div>
			<div class="tab-pane tab" id="tab2">
				<p></p>
			</div>
			<div class="tab-pane tab" id="tab3">
				<p></p>
			</div>
		</div>
	</div>
	<div id="flikr_loading">
		<div id="shapeblue" class="bar"></div>
		<div id="shapepink" class="bar"></div>
	</div>
</div>
<div id="chart_container">
	<div id="container"></div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/highstock1.3.7.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/highstock-exporting1.3.7.min.js" charset="utf-8"></script>
<script type="text/javascript">
	
	var cbound   = <?php echo $stats['bound']?>;
	var crequest = <?php echo $stats['request']?>;
	var member   = null;
	var orders   = null;
	var comments = null;
	var chartData = null;

	$(document).ready(function() {
	    flikr.prepare();
	    // flikr.start();
	    $('#flikr_loading').hide();
	    $('#chart_container').click(function(){
	    	dismissOrderChart();
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
			url: "<?php echo Yii::app()->createUrl('takeAway/members/getHistory')?>/memberId/" + memid + "?sid=<?php echo $this->currentStore->id?>",
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
		member   = data['member'];
		orders   = data['orders'];
		comments = data['comments'];
		// messages = data['messages'];
		chartData = new Array();
		
		$('#order_count_' + member['id']).html('订单数量：' + orders.length);
		$('#comment_count_' + member['id']).html('评论数量：' + comments.length);
		// 设置基本信息
		$('#tab1').html(
			'<h4>用户编号：' + member['id'] + '</h4>' +
			'<div>关注状态：<span class="label label-' + (member['unsubscribed']=="1"?'important':'info') + 
			'">' + (member['unsubscribed']=="1"?'已取消关注':'已关注') + '</span>&nbsp;&nbsp;&nbsp;&nbsp;' +
			'绑定状态:&nbsp;&nbsp;<span class="label label-' + (member['bound']=="1"?"success":(member['request']=="1"?"warning":"info")) + '">' +
			(member['bound']=="1"?"已绑定":(member['request']=="1"?"请求绑定":"未绑定")) + '</span>' +
			'<span>&nbsp;&nbsp;&nbsp;关注日期：' + member['ctime'] + '</span></div><br>' +
			'<table class="table table-bordered">' + 
				'<thead><tr>' + 
					'<th colspan="2">' + 
						'会员信息' + (member['request'] == "1" ? '<div class="btn btn-primary mem-comfirm-btn" onclick="confirmMember()">确认</div>':'') + 
					'</th></tr>' + 
				'</thead>' + 
				'<tbody>' + 
					'<tr><td>会员号</td><td>' + (member['cardno']?member['cardno']:'未设置') + '</td></tr>' + 
					'<tr><td>会员积分</td><td>' + member['credits'] + '</td></tr>' + 
					'<tr><td>电话号码</td><td>' + (member['phone']?member['phone']:'未设置') + '</td></tr>' +
				'</tbody>' +
			'</table>' + 
			'<table class="table table-bordered">' +
				'<thead><tr><th>微信信息</th></tr></thead>' +
				'<tbody>' +
					'<tr><td>微信openid</td><td>' + member['openid'] + '</td></tr>' +
					'<tr><td>微信昵称</td><td>' + (member['wxnickname']?member['wxnickname']:'未知') + '</td></tr>' +
				'</tbody>' +
			'</table>'
		);
		
		// 设置订单信息
		if(orders.length > 0){
			var html = '<b>历史订单</b>' + 
							  '<span class="table-btn-container">' + 
									'<img src="../../img/icon-chart.jpg" class="img-btn" onclick="showOrderChart()">' + 
									'<img src="../../img/icon-excel.jpg" class="img-btn" onclick="downloadExcel()">' + 
							  '</span>' +
							  '<table class="table">' +
							  	'<tbody><tr><td>编号</td><td>下单日期</th><td>状态</td><td>总价</td><td>详情</td></tr>';
			chartData = new Array();
			for(index in orders){
				var order = orders[index];
				var status = order['status']=='1'?'已完成':(order['status']=='3'?'已取消':'进行中');
				var trclass = order['status']=='1'?'success':(order['status']=='3'?'error':'warning');
				html += '<tr class="' + trclass + '">' + 
							'<td>' + order['order_no'] + '</td>' +
							'<td>' + order['ctime'] + '</td>' +
							'<td >' + status + '</td>' +
							'<td>' + order['price'] + '</td>' +
							'<td>' + order['items'] + '</td>' +
						'</tr>';
				chartData[index] = new Array();
				chartData[index].push(Date.parse(order['ctime']));
				chartData[index].push(parseFloat(order['price']));
			}
			chartData.sort(function(a, b){return a[0] > b[0]?1:-1});
			html += '</tbody></table>'
			$('#tab2').html(html);
			
		}else{
			$('#tab2').html(
				'<div>这位用户还木有下过单呐</div>'
			);
		}
		
		// 设置评论信息
		if(comments.length > 0){
			var html = '<table class="table">' + 
					   		'<thead><tr><th>历史评论</th></tr></thead>' +
					   		'<thead><tr><th>评论日期</th><th>评论内容</th></thead>';
			for(index in comments){
				var comment = comments[index];
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

		// 
		// if(messages.length > 1){
		// 	var html = '<table class="table">' + 
		// 			   		'<thead><tr><th>历史消息</th></tr></thead>' +
		// 			   		'<thead><tr><th>发送日期</th><th>消息内容</th><th>回复状态</th></tr></thead>';
		// 	for(index in messages){
		// 		var message = messages[index];
		// 		html += '<tr><td>' + message['ctime'] + '</td>' +
		// 				    '<td>' + message['content']['0'] + '</td>' +
		// 				    '<td>' + message['replied'] + '</td>' + 
		// 				'</tr>';
		// 		console.log(message['content']);
		// 	}
		// 	html += '</table>';
		// 	$('#tab4').html(
		// 			html
		// 	);
		// }else{
		// 	$('#tab4').html(
		// 		'<div>这位用户还木有发过消息</div>'
		// 	);
		// }
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
		if(orders.length > 0){
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
					data : chartData,
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
		if(member && confirm("确认该用户的会员资格？")){
			$.ajax({
				url: "<?php echo Yii::app()->createUrl('takeAway/members/confirmMember/memberId/')?>" + 
					 "/" + member['id'] + "?sid=<?php echo $this->currentStore->id?>"
			}).success(function (data){
				if (data == 'ok'){
					var item = $('#member_item_' + member['id']);
					$('#option_bnd').html("已绑定会员卡(" + (++cbound) + ")");
					$('#option_req').html("请求绑定会员卡(" + (--crequest) + ")");
					item.removeClass('request');
					item.addClass('bound');
					if(member['unsubscribed'] != '1'){
						var label = item.find('#item_label_' + member['id']);
						label.removeClass('label-warning');
						label.addClass('label-success');
						label.html('已绑定');
					}
					item.click();
					filterMembers();
				}else{
					alert('绑定失败');
				}
			});
		}
	}
	

	function downloadExcel(){
		
	}
</script>