<style type="text/css">
	#profile_main_container{
		display: block;
		position: absolute;
		width: 890px;
		min-height: 500px;
		left: 50%;
		margin-left: -450px;
		top: 120px;
		background-color: #fff;
		border-radius: 1px;
		box-shadow: 0px 0px 10px #808080;
		padding-left: 10px;
	}
	#profile_nav_bar{
		position: relative;
		height: 40px;
		padding-left: 15px;
	}
	.profile_nav_item{
		text-align: center;
		height: 40px;
		width: 280px;
		display: inline-block;
		line-height: 40px;
	}
	.profile_nav_item:hover{
		cursor: pointer;
		border-bottom: 2px solid #aaa;
	}
	.profile_nav_item.active{
		border-bottom: 2px solid #222;
	}
	.profile_tab{
		display: none;
		position: absolute;
		height: 450px;
		left: 0;
		top: 50px;
		border-bottom-left-radius: 1px;
		border-bottom-right-radius: 1px;
		overflow: auto;
		padding-left: 25px;
		width: 850px;
		padding-right: 25px;
	}
	.profile_tab.active{
		display: block;
	}
	.profile_tab_title{
		padding-left: 10px;
		width: 840px;
		height: 35px;
		line-height: 35px;
		font-size: 16px;
		font-weight: bold;
		background-color: #84a099;
		color: #fff;
	}
	#profile_tab1 table tr td{
		overflow: hidden;
		height: 25px;
		line-height: 25px;
		font-size: 18px;
	}
	#profile_tab1 table tr td{
		font-size: 16px;
	}
	.profile_tab_unavailable{
		width: 100%;
		height: 70px;
		line-height: 70px;
		font-size: 30px;
		color: #a0a0a0;
		font-weight: bold;
		text-align: center;
	}
	#profile_tab1 #profile_deposite{
		display: none;
		position: absolute;
		left: 25px;
		top: 0px;
		right: 25px;
		bottom: 15px;
		background-color: #fff;
	}
	#profile_tab1 #profile_deposite label{
		font-size: 18px;
		font-weight: bold;
		height: 30px;
		line-height: 30px;
	}
	#profile_tab1 #profile_deposite input{
		width: 830px;
		height: 35px;
		font-size: 20px;
		line-height: 35px;
	}
	#profile_tab1 #profile_deposite .profile_btn{
		width: 120px;
		height: 30px;
		border-radius: 5px;
		border: 1px solid #ddd;
		display: inline-block;
		float: right;
		margin: 10px;
		text-align: center;
		line-height: 30px;
		border: 2px solid #fff;
	}
	#profile_tab1 #profile_deposite .profile_btn:hover{
		cursor: pointer;
	}
	.profile_btn.btn_ok{
		background-color: #84a099;
		color: #ffffff;
	}
	.profile_btn.btn_ok:hover{
		border: 2px solid #84a099;
	}
	.profile_btn.btn_cancel{
		background-color: #f6f6f6;
		color: #808080;
	}
	.profile_btn.btn_cancel:hover{
		border: 2px solid #f6f6f6;
	}
	#profile_tab1 #profile_deposite_step2{
		display: none;
	}
	#profile_tab2 #profile_tab2_load_more{
		padding-left: 10px;
		width: 840px;
		height: 35px;
		line-height: 35px;
		font-size: 16px;
		font-weight: bold;
		text-align: center;
		border: 1px solid #a0a0a0;
		margin-bottom: 5px;
		margin-top: -5px;
	}
	#profile_tab2 #profile_tab2_load_more:hover{
		cursor: pointer;
		background-color: #d3e8db;
	}
	#profile_tab3 table{
		overflow: auto;
	}
	#profile_tab3 #profile_bill_nav_container{
		float: right;
		font-size: 14px;
		height: 35px;
	}
	#profile_tab3 #profile_bill_nav_container input{
		width: 18px;
		height: 15px;
		vertical-align: middle;
		margin-top: 7px;
	}
	#profile_tab3 .profile_bill_nav_btn{
		display: inline-block;
		border: 1px solid #c0c0c0;
		border-radius: 3px;
		color: #a0a0a0;
		margin-left: 10px;
		padding-left: 5px;
		padding-right: 5px;
		line-height: 20px;
	}
	#profile_tab3 .profile_bill_nav_btn.active{
		color: #06C;
	}
	#profile_tab3 .profile_bill_nav_btn:hover{
		cursor: pointer;
	}
	#profile_tab3 .profile_bill_nav_btn.active:hover{
		color: #05b;
		text-decoration: underline;
	}
	#profile_tab3 #profile_bills_no_bills{
		width: 100%;
		height: 70px;
		line-height: 70px;
		font-size: 30px;
		color: #a0a0a0;
		font-weight: bold;
		text-align: center;
	}
	#profile_tab3 #bill_detail_container{
		display: none;
		position: absolute;
		left: 25px;
		top: 42px;
		right: 25px;
		bottom: 15px;
		background-color: #fff;
	}
	#profile_tab3 #bill_loading_mask{
		display: none;
		position: absolute;
		left: 25px;
		top: 42px;
		right: 25px;
		bottom: 15px;
		background-color: #fff;
		text-align: center;
	}
</style>

<div id="profile_main_container">
	<div id="profile_nav_bar">
		<div class="profile_nav_item active" id="profile_tag1" data-toggle="profile_tab1">基本信息</div>
		<div class="profile_nav_item" id="profile_tag2" data-toggle="profile_tab2">系统消息</div>
		<div class="profile_nav_item" id="profile_tag3" data-toggle="profile_tab3">账单</div>
	</div>

	<div id="profile_tab1" class="profile_tab active">
		<div class="profile_tab_title">我的账户</div>
		<div>
			<table class="table">
				<tr>
					<td>账户名称</td>
					<td><?php echo $model['account']; ?></td>
				</tr>
				<tr>
					<td>账户余额</td>
					<td><?php echo $model['balance']; ?>元&nbsp;&nbsp;
						<a href="#" onclick="showBillsTab()">查看账单</a>&nbsp;&nbsp;
						<a href="#" onclick="showDeposite()">充值</a>
					</td>
				</tr>
				<tr>
					<td>微信公众帐号昵称</td>
					<td><?php echo $model['wechat_name']; ?></td>
				</tr>
				<tr>
					<td colspan="2">您在微积分的订单总额为<span><?php echo $model['stats']; ?></span>元</td>
				</tr>
			</table>
		</div>
		<div class="profile_tab_title">我的插件</div>
		<div class="profile_tab_unavailable">
			该功能暂未开放
		</div>
		<div id="profile_deposite">
			<div id="profile_deposite_step1" class="profile_deposite">
				<div class="profile_tab_title">账户充值</div><br>
				<div id="deposite_step_alert_container">
					<div class="alert alert-info">
				  		<button type="button" class="close" data-dismiss="alert">&times;</button>
				  		<strong>提示</strong> 请输入您购买的充值卡账户和密码，如果没有充值卡，请到<a href="http://www.taobao.com/" target="_blank">这里</a>购买
					</div>
				</div>
				<label>卡号：</label>
				<input id="deposite_card_no" type="text" placeholder="请输入卡号"/>
				<label>密码：</label>
				<input id="deposite_card_pass" type="text" placeholder="请输入密码"/>
				<div id="profile_deposite_btn_container">
					<div class="profile_btn btn_ok" onclick="depositeNext()">下一步</div>
					<div class="profile_btn btn_cancel" onclick="depositeCancel()">取消</div>
				</div>
			</div>
			<div id="profile_deposite_step2" class="profile_deposite">
				<div class="profile_tab_title">请确认您的充值信息</div>
				<div id="deposite_step2_alert_container">

				</div>
				<table id="deposite_step2_table" class="table">

				</table>
				<div id="profile_deposite_btn_container">
					<div class="profile_btn btn_ok" onclick="depositeOk()">确定</div>
					<div class="profile_btn btn_cancel" onclick="depositeCancel()">取消</div>
				</div>
			</div>
		</div>
	</div>
	<div id="profile_tab2" class="profile_tab">
		<div class="profile_tab_title">系统消息列表</div>
		<?php if($sysmsgs){?>
		<table class="table">
			<thead>
				<tr>
					<th>消息收取时间</th>
					<th>消息内容</th>
				</tr>
			</thead>
			<tbody id="profile_msg_tbody">
			<?php	
				foreach ($sysmsgs as $msg) {
					echo '<tr><td>'.$msg['ctime'].'</td><td>'.$msg['info'].'</td></tr>';
				}?>
			</tbody>
		</table>
		<div id="profile_tab2_load_more" onclick="loadMoreMsgs()">加载更多</div>
		<?php } else { 
			echo '<div class="profile_tab_unavailable">暂时没有系统消息</div>';	
			}?>
	</div>
	<div id="profile_tab3" class="profile_tab">
		<div class="profile_tab_title">账户消费记录</div>
		<?php if($bcount > 0){?>
		<table id="profile_bill_table" class="table">
			<thead>
				<tr>
					<th>流水号</th>
					<th>交易类型</th>
					<th>交易日期</th>
					<th>收入</th>
					<th>支出</th>
					<th>余额</th>
					<th>详情</th>
				</tr>
			</thead>
			<tbody id="profile_bill_table_body">
				<?php foreach ($bills as $bill) {
					echo '<tr>'.
							'<td>'.$bill->flowid.'</td>'.
							'<td>'.$bill->type.'</td>'.
							'<td>'.$bill->ctime.'</td>'.
							'<td>'.$bill->income.'</td>'.
							'<td>'.$bill->payment.'</td>'.
							'<td>'.$bill->balance.'</td>'.
							'<td><a href="#" class="bill_detail_btn" id="bill_detail_'.$bill->id.'">查看详情</a></td>'.
						 '</tr>';
				}?>
			</tbody>
		</table>
		<div id="profile_bill_nav_container">
			第<input type="text" id="page_nav_input" value="1">页
			<div class="profile_bill_nav_btn active" id="profile_bill_nav_go">GO</div>
			共<?php echo $pcount; ?>页
			<div class="profile_bill_nav_btn" id="profile_bill_nav_first">首页</div>
			<div class="profile_bill_nav_btn" id="profile_bill_nav_pre">上一页</div>
			<div class="profile_bill_nav_btn" id="profile_bill_nav_next">下一页</div>
			<div class="profile_bill_nav_btn" id="profile_bill_nav_last">尾页</div>
		</div>
		<?php }else {?>
			<div id="profile_bills_no_bills">您还没有任何消费记录</div>
		<?php }?>
		<div id="bill_detail_container">
			<div id="bill_detail_table_container"></div>
			<div style="float:right;">
				<a href="#" onclick="$('#bill_detail_container').hide()">返回账单列表</a>
			</div>
		</div>
		<div id="bill_loading_mask">
			<div id="circular" class="marginLeft">
				<div id="circular_1" class="circular"></div>
				<div id="circular_2" class="circular"></div>
				<div id="circular_3" class="circular"></div>
				<div id="circular_4" class="circular"></div>
				<div id="circular_5" class="circular"></div>
				<div id="circular_6" class="circular"></div>
				<div id="circular_7" class="circular"></div>
				<div id="circular_8" class="circular"></div>
				<div id="clearfix"></div>
			</div> 
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery_md5.js"></script>
<script type="text/javascript">
	var cardno      = '';
	var cardpass    = '';
	var ctime       = 0;
	var stime       = 0;
	var maxmsgid    = <?php if($sysmsgs && count($sysmsgs) > 0)
								echo $sysmsgs[count($sysmsgs) - 1]['id']; 
							else echo 0;
					  ?>;
	var billCount   = <?php echo $bcount; ?>;
	var pageCount   = <?php echo $pcount; ?>;
	var currentPage = 1;
	var action = window.location.href.substr(window.location.href.indexOf('#') + 1);

	$(document).ready(function(){
		$('.profile_nav_item').click(function(event){
			target = event.target;
			if(!$(target).hasClass('active')){
				$('.profile_nav_item').removeClass('active');
				$(target).addClass('active');
				$('.profile_tab').removeClass('active');
				$('#' + target.getAttribute('data-toggle')).addClass('active');
			}
		});
		$('.profile_bill_nav_btn').click(function(event){
			target = event.target;
			if($(target).hasClass('active')){
				switch(target.id){
					case 'profile_bill_nav_go':
						onGoButtonClick();
						break;
					case 'profile_bill_nav_first':
						onFirstButtonClick();
						break;
					case 'profile_bill_nav_pre':
						onPreviousButtonClick();
						break;
					case 'profile_bill_nav_next':
						onNextButtonClick();
						break;
					case 'profile_bill_nav_last':
						onLastButtonClick();
						break;
				}
			}
		});
		$('.bill_detail_btn').click(function(event){
			$('#bill_loading_mask').show();
			billId = parseInt(event.target.id.substr(12));
			getDetail(billId);
		});
		if(action){
			switch(action){
				case 'msg':
					$('#profile_tag2').click();
					break;
			}
		}
		setCurrentPage(1);
	});

	function showDeposite(){
		$('#profile_deposite').show();
		$('#profile_deposite_step1').show();
	}

	function depositeNext(){
		cardno   = $('#deposite_card_no').val();
		cardpass = $('#deposite_card_pass').val();
		ctime    = new Date().getTime();
		if(!cardno || cardno == '' || !cardpass || cardpass == ''){
			$('#deposite_step_alert_container').find('.alert-error').remove();
			$('#deposite_step_alert_container').append(
				'<div class="alert alert-error" id="error_alert">' +
			  		'<button type="button" class="close" data-dismiss="alert">&times;</button>' + 
			  		'<strong>错误</strong> 充值卡卡号和密码不能为空' +
				'</div>'
			);
		}else{
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("accounts/account/checkCard")?>',
				type: 'post',
				data: {card_no: cardno, card_pass: cardpass, timestamp: ctime},
				dataType: 'json',
				success: function(data){
					if(data && data['success'] == '1'){
						stime = data['time'];
						md5 = $.md5(cardno + cardpass + ctime + stime);
						if(md5 == data['signature']){
							$('#deposite_step2_table').html('');
							$('#deposite_step2_table').append('<tr><td>卡号</td><td>' + cardno + '</td></tr>');
							$('#deposite_step2_table').append('<tr><td>面值</td><td>' + data['value'] + '</td></tr>');
							$('#deposite_step2_table').append('<tr><td>过期日期</td><td>' + data['duetime'] + '</td></tr>');
							$('#profile_deposite_step1').hide();
							$('#profile_deposite_step2').show();	
						}
					} else if(data['success'] == '0'){
						$('#deposite_step_alert_container').find('.alert-error').remove();
						$('#deposite_step_alert_container').append(
							'<div class="alert alert-error" id="error_alert">' +
						  		'<button type="button" class="close" data-dismiss="alert">&times;</button>' + 
						  		'<strong>错误</strong> ' + data['info'] + 
							'</div>'
						);
					}
				},
				fail: function(){
					$('#deposite_step_alert_container').find('.alert-error').remove();
					$('#deposite_step_alert_container').append(
						'<div class="alert alert-error" id="error_alert">' +
					  		'<button type="button" class="close" data-dismiss="alert">&times;</button>' + 
					  		'<strong>错误</strong> 请求发送失败，请稍后重试' + 
						'</div>'
					);
				}
			});
		}
	}

	function depositeOk(){
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("accounts/account/deposite"); ?>',
			type: 'post',
			dataType: 'json',
			data: {card_no: cardno, card_pass: cardpass, ctime: ctime, stime: stime},
			success: function(data){
				if(data['success'] == '1'){
					alert('恭喜您！充值成功！');
					window.location.reload();
				}else {
					$('#deposite_step2_alert_container').html('');
					$('#deposite_step2_alert_container').append(
						'<div class="alert alert-error" id="error_alert">' +
					  		'<button type="button" class="close" data-dismiss="alert">&times;</button>' + 
					  		'<strong>错误</strong> ' + data['info'] +
						'</div>'
					);
				}
			},
			fail: function(){
				$('#deposite_step2_alert_container').find('.alert-error').remove();
				$('#deposite_step2_alert_container').append(
					'<div class="alert alert-error" id="error_alert">' +
				  		'<button type="button" class="close" data-dismiss="alert">&times;</button>' + 
				  		'<strong>错误</strong> 请求发送失败，请稍后重试' + 
					'</div>'
				);
			}
		});
	}

	function depositeCancel(){
		$('#deposite_card_no').val('');
		$('#deposite_card_pass').val('');
		$('#profile_deposite_step2').hide();
		$('#profile_deposite').hide();
	}

	function showBillsTab(){
		$('#profile_tag3').click();
	}

	function setCurrentPage(page){
		currentPage = page;
		if(currentPage > 1){
			$('#profile_bill_nav_first').addClass('active');
			$('#profile_bill_nav_pre').addClass('active');
		}else{
			$('#profile_bill_nav_first').removeClass('active');
			$('#profile_bill_nav_pre').removeClass('active');
		}
		if(currentPage < pageCount){
			$('#profile_bill_nav_next').addClass('active');
			$('#profile_bill_nav_last').addClass('active');
		}else{
			$('#profile_bill_nav_next').removeClass('active');
			$('#profile_bill_nav_last').removeClass('active');
		}
		$('#page_nav_input').val(currentPage);
	}

	function onGoButtonClick(){
		var page = $('#page_nav_input').val();
		if(/^\d+$/.test(page)){
			page = parseInt(page);
			if(page != currentPage){
				loadPage(page);
			}
		}
	}

	function onFirstButtonClick(){
		loadPage(1);
	}

	function onPreviousButtonClick(){
		loadPage(currentPage - 1);
	}

	function onNextButtonClick(){
		loadPage(currentPage + 1);
	}

	function onLastButtonClick(){
		loadPage(pageCount);
	}

	function loadPage(page){
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('accounts/account/getBills')?>" + "/page/" + page,
			dataType: 'json',
			success: function(data){
				if(data && data.length > 0){
					setCurrentPage(page);
					$('#profile_bill_table_body').html('');
					for(index = 0; index < data.length; index ++){
						$('#profile_bill_table_body').append(
							'<tr>' + 
								'<td>' + data[index]['flowid'] + '</td>' +
								'<td>' + data[index]['type'] + '</td>' +
								'<td>' + data[index]['ctime'] + '</td>' +
								'<td>' + data[index]['income'] + '</td>' +
								'<td>' + data[index]['payment'] + '</td>' +
								'<td>' + data[index]['balance'] + '</td>' +
								'<td><a href="#" class="bill_detail_btn" ' + 
								'id="bill_detail_' + data[index]['id'] + 
								'" onclick="getDetail(' + data[index]['id'] + ')"' + 
								'>查看详情</a></td>' +
							'</tr>'
						);
					}
				}else{

				}
			},
			fail: function(){

			}
		});
	}

	function getDetail(billId){
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("accounts/account/billDetail")?>/bid/' + billId,
			dataType: 'json',
			success: function(data){
				$('#bill_loading_mask').hide();
				$('#bill_detail_table_container').html(
					'<table class="table">' + 
						'<tr><td colspan="3">账单流水号</td><td>' + data['flowid'] + '</td></tr>' +
						'<tr><td colspan="3">交易日期</td><td>' + data['ctime'] + '</td></tr>' +
						'<tr><td colspan="3">交易类型</td><td>' + data['type'] + '</td></tr>' + 
						'<tr><td>收入</td><td>' + data['income'] + '</td><td>支出</td><td>' + data['payment'] + '</td></tr>' +
						'<tr><td colspan="3">余额</td><td>' + data['balance'] + '</td></tr>' +
						'<tr><td colspan="1">交易详情</td><td colspan="3">' + data['info'] + '</td></tr>' +
					'</table>'
				);
				$('#bill_detail_container').show();
			},
			fail: function(data){

			}
		});
	}

	function loadMoreMsgs(){
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('accounts/account/loadSysmsgs/before/')?>/" + maxmsgid,
			dataType: 'json',
			success: function(data){
				if(data && data.length > 0){
					for(i = 0; i < data.length; i ++){
						$('#profile_msg_tbody').append(
							'<tr><td>' + data[i]['ctime'] + '</td><td>' + data[i]['info'] + '</td></tr>'
						);
					}
					maxmsgid = data[data.length - 1]['id'];
				}
			},
			fail: function(){

			}
		});
	}
</script>