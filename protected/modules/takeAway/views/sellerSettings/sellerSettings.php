<?php 
	$utils = new Utils;
?>
<style>
	form{
		margin-left: 20px;
	}
	.input_label{
		line-height: 28px;
	}
	#seller_settings_container{
		position: absolute;
		left: 220px;
		top: 41px;
		bottom: 0px;
		overflow-y: auto;
		overflow-x: hidden;
		width: expression(document.width - 200 + "px");
	}
	#seller_settings_actions{
		width: 100%;
		margin-top: 20px;
	}
</style>

<div id="seller_settings_container">
	<div id="seller_settings_actions">
		<button id="seller_settings_save" class="btn btn-primary action_btn" onclick="saveProxy()">保存</button>
		<button id="seller_settings_cancel" class="btn action_btn" onclick="cancel()">放弃更改</button>
	</div>
	<hr>
	<b><?php echo Utils::getDate('y-m-d w');?></b><br>
	<div>
		店铺状态：
		<select name="store_status">
			<option>正常经营</option>
			<option>暂停外卖</option>
			<option>暂停营业</option>
		</select>
	</div>
	<div class="row">
		<div class="span1">店铺公告：</div>
		<textarea rows="5" cols="" class="span5"></textarea>
	</div>
	<hr>
	<h5>品类促销</h5>
	
	<hr>
	<h5>今日外送片区（请勾选外送片区）</h5>
	
	<hr>
	<h5>今日外送人员（请勾选外送人员）</h5>
	
	<hr>
	<h5>今日库存管理（请勾选今日库存告急的产品）</h5>
	
</div>

<script type="text/javascript">

	// 设置容器宽度，并使其随着窗口大小改变而改变
	$(document).ready(function(){
		setContainerWidth();
		window.onresize = setContainerWidth;
	});

	function setContainerWidth(){
		width = document.body.clientWidth;
		$('#seller_settings_container').css("width", width - 220 + "px");
	}
</script>