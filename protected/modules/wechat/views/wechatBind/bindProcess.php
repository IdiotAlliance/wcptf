<?php ?>
<style>
<!--
.process_img {
	position: absolute;
	width: 800px;
	height: 450px;
	box-shadow: 0px 0px 5px #808080;
	display: none;
	left: 50%;
	margin-left: -400px;
	top: 50%;
	margin-top: -220px;
}

.opaque {
	display: none;
	position: absolute;
	left: 50%;
	top: 50%;
	width: 100px;
	z-index: 10;
}

#bind_process_title {
	margin-left: 150px;
}

#bind1 {
	display: block;
}

#bind_process_action {
	position: absolute;
	left: 50%;
	margin-left: -100px;
	bottom: 40px;
}

#copy_token {
	margin-top: -28px;
	margin-left: 160px;
}

#copy_url {
	margin-top: -60px;
	margin-left: 160px;	
}
-->
</style>
<div class="row">
	<h5 class="span4" id="bind_process_title">绑定微信公众平台--第一步：登陆微信公众平台</h5>
</div>
<button class="opaque" id="copy_url" alt="点击复制url" onclick="copyUrl()">Url</button>
<button class="opaque" id="copy_token" alt="点击复制token" onclick="copyToken()">token</button>

<div id="bind_process_gallery">
	<img id="bind1" class="process_img" alt="" src="../../img/wechat_bind1.png">
	<img id="bind2" class="process_img" alt="" src="../../img/wechat_bind2.png">
	<img id="bind3" class="process_img" alt="" src="../../img/wechat_bind3.png">
	<img id="bind4" class="process_img" alt="" src="../../img/wechat_bind4.png">
</div>
<div id="bind_process_action">
	<button class="btn" id="previous" disabled onclick="previous()">上一步</button>
	<button class="btn btn-primary" id="next" onclick="next()">下一步</button>
</div>

<script>
	var token  = "<?php echo $user->token?>";
	var url    = "<?php echo $user->wechat_url?>";
	
	var titles = ['绑定微信公众平台--第一步：登陆微信公众平台',
		          '绑定微信公众平台--第二步：进入开发模式',
		          '绑定微信公众平台--第三步：点击成为开发者',
		          '绑定微信公众平台--第四步：输入您的token和回调地址']
	var cur = 1;
	function previous(){
		if(cur == 4){
			$('#next').html('下一步');
			$('#copy_token').fadeOut();
			$('#copy_url').fadeOut();
		}
		if(cur != 1){
			$('#bind'+cur).fadeOut();
			cur--;
			$('#bind'+cur).fadeIn();
			$('#bind_process_title').html(titles[cur - 1]);
			if(cur == 1){
				$('#previous').attr('disabled', 'true');
			}
		}
	}

	function next(){
		if(cur == 4){
			window.location = "<?php echo Yii::app()->createUrl('wechat/wechatBind/bindComplete')?>";
		}
		if(cur == 1){
			$('#previous').removeAttr('disabled');
		}
		if(cur != 4){
			$('#bind'+cur).fadeOut();
			cur++;
			$('#bind'+cur).fadeIn();
			$('#bind_process_title').html(titles[cur - 1]);
			if(cur == 4){
				$('#next').html('已完成');
				$('#copy_token').fadeIn();
				$('#copy_url').fadeIn();
			}
		}
	}

	function copyToken(){
		window.prompt ("使用Ctrl+C复制token", token);
		
	}

	function copyUrl(){
		window.prompt ("使用Ctrl+C复制回调地址", url);
	}
</script>