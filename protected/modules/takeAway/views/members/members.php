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
		z-index: 100;
		-moz-box-shadow: -1px 0 2px rgba(0,0,0,0.15);
		-webkit-box-shadow: -1px 0 2px rgba(0,0,0,0.15);
		box-shadow: -1px 0 2px rgba(0,0,0,0.15);
	}
	.members_title{
		position: fixed;
		width: 390px;
		padding-top: 10px;
		padding-bottom: 10px;
		padding-left: 10px;
		border-bottom: 1px solid #808080;
		margin-top: 0px;
		overflow: hidden;
		height: 75px;
	}
	.filter_right{
		float: right;
		margin-right: 10px;
		margin-top: -35px;
	}
	.members_list{
		position: absolute;
		left: 1px;
		top: 96px;
		bottom: 0px;
		right: 0;
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
	#tab1 .mem-op-btn{
		float: right;
		margin-left: 10px;
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
	.switch_container{
		position: absolute;
		left: 0px;
		top: 50px;
		right: 0px;
		bottom: 0px;
	}
	.switch_container .onoff_label{
		position: absolute;
		left: 10px;
		top: 12px;
		height: 25px;
		line-height: 25px;
		vertical-align: center;
		display: inline-block;
	}
	.switch_container .onoff_switch{
		position: absolute;
		left: 330px;
		top: 10px;
		width: 60px;
		height: 25px;
		display: inline-block;
	}
	.switch_container .onoff_switch:hover{
		cursor: pointer;
	}
	.switch_container .onoff_switch.on{
		background: url('<?php echo Yii::app()->baseUrl?>/img/on.png') 0 0 no-repeat;
		background-size: 100% 100%;
	}
	.switch_container .onoff_switch.off{
		background: url('<?php echo Yii::app()->baseUrl?>/img/off.png') 0 0 no-repeat;
		background-size: 100% 100%;
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
		<div class="switch_container">
			<label class="onoff_label" for="onoff_switch">会员绑定开关</label>
			<div class="onoff_switch <?php if($bindon) echo 'on'; else echo 'off'; ?>"></div>
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
	(function(win){
		window.MEMBERS = {};
		window.MEMBERS.cbound   = <?php echo $stats['bound']?>;
		window.MEMBERS.crequest = <?php echo $stats['request']?>;
		window.MEMBERS.switchon = <?php echo $bindon; ?>;
		window.MEMBERS.member   = null;
		window.MEMBERS.orders   = null;
		window.MEMBERS.comments = null;
		window.MEMBERS.chartData = null;
		window.MEMBERS.sid      = <?php echo $this->currentStore->id?>;
	})(window);
	
</script>
<script type="text/javascript" src="<?php echo Yii::app()->createUrl('/resource/resource/js/name/membersv0_7')?>"></script>