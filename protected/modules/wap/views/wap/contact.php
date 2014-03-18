<style type="text/css">
	body{
		margin: 0px;
		text-align: center;
		font-size: 1.2em;
	}
	#contact_header{
		width: 100%;
		height: 44px;
		line-height: 44px;
		background-color: #f5f5f5;
		border-bottom: 1px #d9d9d9 solid;
		font-size: 1.3em;
		margin-left: 0px;
		margin-right: 0px;
	}
	#contact_content{
		border: 0px;
		width: 100%;
		min-height: 200px;
		padding: 0px;
		border-color: #fff;
		font-family:arial,sans-serif;
		outline-style:none;
		resize: none;
		font-size: 1.2em;
	}
	#contact_content:focus{
		border: 0px;
		padding: 0px;
		border-color: #fff;
	}
	#contact_select{
		width: 100%;
		height: 45px;
		background-color: #fff;
		border-top: 1px solid #d9d9d9;
		border-right: 1px solid #fff;
		border-left: 1px solid #fff;
		border-bottom: 1px solid #d9d9d9;
		outline-style:none;
		outline: none;
	}
	#contact_submit{
		width: 100%;
		font-weight: bold;
		color: #606060;
		background-color: #f5f5f5;
		height: 50px;
		line-height: 50px;
		border-left: 0;
		border-right: 0;
		border-top: 0;
	}
	#contact_sorry{
		margin-top: 100px;
	}
	#content_mask{
		position: absolute;
		left: 0;
		top: 44px;
		right: 0;
		height: 210px;
		line-height: 200px;
		font-size: 1.1em;
		color: #a0a0a0;
	}
	#footer{
		position: absolute;
		width: 100%;
		left: 0;
		right: 0;
		bottom: 0;
		border-top: 1px #d9d9d9 solid;
		font-size: 0.7em;
	}
</style>
<?php
	if(isset($stores) && count($stores) > 0){
?>
<div id="contact_header">意见反馈</div>
<div>
	<form id="contact_form" method="post" action="<?php echo Yii::app()->createUrl('wap/wap/contact/').'/'.$sellerid?>">
		<div>
			<input name="memberid" style="display:none" value="<?php echo $memberid?>"/>
			<textarea name="content" id="contact_content" wrap="virtual">
			</textarea>
			<br>
			<select name="store" id="contact_select">
				<?php
					foreach ($stores as $store) {
						echo "<option value='".$store['id']."'>${store['sname']}</option>";
					}
				?>
			</select>
		</div>
		<input type="submit" name="submit" value="走你" id="contact_submit" />
	</form>
</div>
<div id="content_mask" onclick="delegate()">
	告诉我们你想说什么吧: )
</div>
<?php 
} else if(isset($result)){
?>
<div id="contact_header">意见反馈</div>
<div id="contact_sorry">
	<?php echo $result; ?>
</div>
<?php }else{?>
<div id="contact_header">意见反馈</div>
<div id="contact_sorry">
	抱歉，因为卖家太懒，还没有任何店铺，所以您还不能发表评价哦╮(╯▽╰)╭
</div>
<?php }?>
<div id="footer">
	<div>2013-2014 微积分平台</div>
	<div>南京第九立方网络科技有限公司 荣誉出品</div>
</div>
<script type="text/javascript">
	function init () {
		// document.getElementById();
	}
	function delegate(){
		mask = document.getElementById("content_mask");
		mask.style.display = 'none';
		area = document.getElementById("contact_content");
		area.width = '100%';
		area.focus();
	}
</script>