<?php ?>
<style>
	#seller_profile_actions{
		width: 100%;
		padding-left: 20px;
		margin-top: 20px;
	}
	form{
		margin-left: 20px;
	}
</style>
<div class="task">
	<div id="seller_profile_actions">
		<button id="seller_profile_save" class="btn btn-primary action_btn" onclick="saveProxy()">保存</button>
		<button id="seller_profile_cancel" class="btn action_btn" onclick="cancel()">放弃更改</button>
	</div>
	<hr>
	<form action="index.php?r=takeAway/sellerProfile" method="post">
		<div class="row">
			<div class="row span3">
				<label class="span1">店铺名称：</label>
				<input class="span2" name="store_name" type="text">
			</div>
			<div class="span2">
				店铺类型：<b><?php echo $model->store_type == 0 ? "外卖" : "其他"?></b>
			</div>
		</div>
		<div class="row">
			<div class="span1">点单电话：</div>
			<input class="span2" name="phone" type="text">
		</div>
		<div class="row">
			<div class="span1">经营时间：</div>
			<input class="span2" name="stime" type="text">
			&nbsp;至&nbsp;
			<input class="span2" name="etime" type="text">
		</div>
		<div class="row">
			<div class="span1">店铺地址：</div>
			<input class="span4" name="store_address" type="text" >
		</div>
		<div class="row">
			<div class="span1">logo：</div>
			<?php echo $value = getLogo($model);?>
		</div>
		<div class="row">
			
		</div>
		<label></label>
		<input id="seller_profile_submit" type="submit" name="保存" style="display: none">
	</form>
	
</div>

<script type="text/javascript">
	function saveProxy(){
		$('#seller_profile_submit').click();
	}

	function cancel(){
		window.location = window.location;
	}
</script>

<?php 
	function getLogo($model){
		if($model->logo == 0)
			return '<img src="">';
		return "";
	}
?>
