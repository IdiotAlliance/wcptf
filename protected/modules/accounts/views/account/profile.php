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
		background-color: #d3e8db;
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
	#profile_tab1 #profile_tab1_plugins{
		width: 100%;
		height: 70px;
		line-height: 70px;
		font-size: 30px;
		color: #a0a0a0;
		font-weight: bold;
		text-align: center;
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
		position: absolute;
		left: 15px;
		top: 50px;
		right: 15px;
		bottom: 15px;
		background-color: #fff;
	}
	#profile_tab3 #bill_loading_mask{
		position: absolute;
		left: 15px;
		top: 50px;
		right: 15px;
		bottom: 15px;
		background-color: #fff;
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
					<td><?php echo $model['balance']; ?>元&nbsp;&nbsp;<a href="#" onclick="showBillsTab()">查看账单</a></td>
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
		<div id="profile_tab1_plugins">
			该功能暂未开放
		</div>
	</div>
	<div id="profile_tab2" class="profile_tab">
		
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
							'<td>'.($bill->type==0?'每日维护支出':($bill->type==1?'短信服务支出':'')).'</td>'.
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
			
		</div>
		<div id="bill_loading_mask"></div>
	</div>
</div>

<script type="text/javascript">
	var billCount   = <?php echo $bcount; ?>;
	var pageCount   = <?php echo $pcount; ?>;
	var currentPage = 1;

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
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("accounts/account/billDetail")?>/bid/' + billId,
				dataType: 'json',
				success: function(data){
					$('#bill_loading_mask').hide();
					$('#bill_detail_container').show();

				},
				fail: function(data){

				}
			});
		});
		setCurrentPage(1);
	});

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
					for(index = data.length - 1; index >= 0; index --){
						$('#profile_bill_table_body').append(
							'<tr>' + 
								'<td>' + data[index]['flowid'] + '</td>' +
								'<td>' + (data[index]['type']=='0'?'每日维护支出':(data[index]['type']=='1'?'短信服务支出':'')) + '</td>' +
								'<td>' + data[index]['ctime'] + '</td>' +
								'<td>' + data[index]['income'] + '</td>' +
								'<td>' + data[index]['payment'] + '</td>' +
								'<td>' + data[index]['balance'] + '</td>' +
								'<td><a href="#" class="bill_detail_btn" id="bill_detail_' + data[index]['id'] + '">查看详情</a></td>' +
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
</script>