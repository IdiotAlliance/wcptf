<?php ?>
<style>
	form{
		margin-left: 20px;
	}
	.input_label{
		line-height: 28px;
	}
	#seller_profile_config{
		position: absolute;
		left: 200px;
		top: 41px;
		bottom: 0px;
		overflow-y: auto;
		overflow-x: hidden;
		width: expression(document.width - 200 + "px");
	}
	#seller_profile_actions{
		width: 100%;
		padding-left: 20px;
		margin-top: 20px;
	}
</style>
<div id="seller_profile_config">
	<div id="seller_profile_actions">
		<button id="seller_profile_save" class="btn btn-primary action_btn" onclick="saveProxy()">保存</button>
		<button id="seller_profile_cancel" class="btn action_btn" onclick="cancel()">放弃更改</button>
	</div>
	<hr>
	<form action="index.php?r=takeAway/sellerProfile" method="post">
		<h5>店铺信息</h5>
		<div class="row">
			<div class="row span3">
				店铺名称：<input class="span2" name="store_name" type="text">
			</div>
			<div class="span2">
				店铺类型：
				<span class="label label-info"><?php echo $model->store_type == 0 ? "外卖" : "其他"?></span>
			</div>
		</div>
		<div class="row">
			<div class="span1 input_label">点单电话：</div>
			<input class="span2" name="phone" type="text">
		</div>
		<div class="row">
			<div class="span1 input_label">经营时间：</div>
			<input class="span2" name="stime" type="text">
			&nbsp;至&nbsp;
			<input class="span2" name="etime" type="text">
		</div>
		<div class="row">
			<div class="span1 input_label">店铺地址：</div>
			<input class="span4" name="store_address" type="text" >
		</div>
		<!-- 上传logo -->
		<div class="row">
			<div class="span1 input_label">logo：</div>
			<?php echo $value = getLogo($model);?>
		</div>
		<!-- 上传店内环境照，最多十张 -->
		<div class="row">
			<?php foreach ($env as $env_pic):?>
				
			<?php endforeach;?>
		</div>
		<hr>
		<h5>外送设定</h5>
		<div class="row">
			<div class="row span3">
				起送价格：<input type="text" name="start_price" class="span2"/>
			</div>
			<div class="row span3">
				外卖费用：<input type="text" name="takeaway_fee" class="span2"/>
			</div>
		</div>
		<div class="row">
			<div class="row span5 input_label">
				运费阈值：<input type="text" name="threshold" class="span2">（超过该价格则免运费）
			</div>
		</div>
		<div class="row">
			<div class="row span3 input_label">
				预计时间：<input type="text" name="estimated_time" class="span2">分钟
			</div>
		</div>
		<div>
			配送片区：<select>
				<option>教学楼</option>
				<option>图书馆</option>
			</select>
			&nbsp;&nbsp;<a href="#">添加新片区</a>&nbsp;<a href="#">删除该片区</a>
			<div class="row" >
				<div class="span1">详细描述：</div>
				<textarea rows="5" cols="10" class="span5"></textarea>
			</div>
		</div>
		<div>
			配送人员：<select>
				<option>小王</option>
				<option>小张</option>
			</select>
			&nbsp;&nbsp;<a href="#">添加新送货员</a>&nbsp;<a href="#">删除该送货员</a>
			<div class="row">
				<div class="span1">详细描述：</div>
				<textarea rows="5" cols="10" class="span5"></textarea>
			</div>
		</div>
		<!-- 隐藏的表单提交按钮 -->
		<input id="seller_profile_submit" type="submit" name="保存" style="display: none">
	</form>
	
</div>

<script type="text/javascript">

	// 设置容器宽度，并使其随着窗口大小改变而改变
	$(document).ready(function(){
		setContainerWidth();
		window.onresize = setContainerWidth;
	});

	function setContainerWidth(){
		width = document.body.clientWidth;
		$('#seller_profile_config').css("width", width - 200 + "px");
	}
		
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
