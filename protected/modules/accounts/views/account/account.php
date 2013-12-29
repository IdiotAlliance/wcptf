<style type="text/css">
	body{
		background: #f6f7f1 url("<?php echo Yii::app()->baseUrl?>/img/account_foreground.png") repeat 0 0;
		font-size: 16px;
	}
	#main_container{
		position: absolute;
		left: 0px;
		top: 0px;
		right: 0px;
		bottom: 0px;
	}
	#nav_bar_container{
		position: absolute;
		width: 900px;
		left: 50%;
		margin-left: -450px;
		top: 40px;
	}
	#nav_bar_container .nav_item{
		color: #999999;
		font-size: 16px;
		line-height: 30px;
		display: block;
		text-shadow: 1px 1px rgba(255,255,255,0.75);
		cursor: pointer;
		display: inline-block;
		min-width: 120px;
		text-decoration: none;
	}
	#nav_bar_container .nav_item:hover{
		color: #666666;
	}
	#nav_bar_container .nav_item.active{
		color: #444444;
	}
	#nav_bar_container .nav_title{
		color: #6a8b82;
		font-size: 23px;
		line-height: 25px;
	}
	#tab_container{
		position: absolute;
		width: 900px;
		min-height: 500px;
		left: 50%;
		margin-left: -450px;
		top: 100px;
	}
	#tab_container .tab{
		position: absolute;
		left: 0px;
		top: 0px;
		right: 0px;
		bottom: 0px;
		display: none;
	}
	#tab_container .stab{
		background-color: #ffffff;
		border-radius: 1px;
		box-shadow: 0px 0px 5px #808080;
	}
	#tab_container .tab.active{
		display: block;
	}
	#tab_container .tab .tab_title{
		font-size: 24px;
		font-family: "Helvetica Neue", Helvetica, Arial,"Microsoft Yahei","SimHei",Sans-serif;
		line-height: 24px;
		margin: 20px 0 50px 0;
		color: #84a099;
		text-align: center;
	}

	#tab_stores .store_item{
		position: relative;
		float: left;
		width: 240px;
		height: 200px;
		overflow: hidden;
		padding-top: 20px;
		text-align: center;
	}

	#tab_stores .store_item .store_folder{
		position: relative;
		display: block;
		width: 152px;
		height: 113px;
		margin: 0 auto 15px;
		background: url("<?php echo Yii::app()->baseUrl?>/img/store-item-mask.png") top left no-repeat #cee6e9;
		outline: none;
		background-color: #ece8d5;
		border-color: #c8bfa5;
		text-decoration: none;
		color: #ffffff;
		text-shadow: 1px 1px rgba(0, 0, 0, 0.2);
		line-height: 110px;
	}

	#tab_stores .store_item .store_new{
		position: relative;
		display: block;
		width: 152px;
		height: 113px;
		margin: 0 auto 15px;
		margin-top: 2px;
		background: url("<?php echo Yii::app()->baseUrl?>/img/new_store.png") 0 0 no-repeat;
		outline: none;
		border-color: #c8bfa5;
		text-decoration: none;
		color: #ffffff;
		text-shadow: 1px 1px rgba(0, 0, 0, 0.2);
		line-height: 110px;
	}

	#tab_stores .store_item .store_new:hover{
		background: url("<?php echo Yii::app()->baseUrl?>/img/new_store.png") 0 -113px no-repeat;
	}

	#mask{
		position: absolute;
		display: none;
		left: 0px;
		top: 0px;
		right: 0px;
		bottom: 0px;
		background-color: #000000;
		opacity: 0.1;
	}
	.modals{
		position: absolute;
	}
	.modal{
		position: absolute;
		display: none;
		overflow: hidden;
		background-color: #ffffff;
		width: 800px;
		height: 400px;
		left: 50%;
		margin-left: -400px;
		top: 50%;
		margin-top: -300px;
		border-radius: 1px;
		box-shadow: 0px 0px 10px #b0b0b0;
	}
	.modal_header{
		border-bottom: 1px solid #ddd;
		background-color: #f6f6f6;
		height: 50px;
		color: #333;
		font-weight: bold;
		font-size: 20px;
		line-height: 50px;
		font-family: "Helvetica Neue", Helvetica, Arial,"Microsoft Yahei","SimHei",Sans-serif;
		padding-left: 15px;
	}
	.modal_close{
		width: 20px;
		height: 20px;
		float: right;
		float: top;
		margin-top: 17px;
		margin-right: 10px;
		background: url("<?php echo Yii::app()->baseUrl?>/img/close.png") 0 0 no-repeat;
	}
	.modal_btn{
		width: 120px;
		height: 30px;
		border-radius: 5px;
		border: 1px solid #ddd;
		display: inline-block;
		float: right;
		margin: 10px;
		text-align: center;
		line-height: 30px;
		border: 2px solid #d3e8db;
	}
	.modal_btn:hover{
		cursor: pointer;
	}
	.modal_cancel{
		background-color: #f6f6f6;
		color: #808080;
	}
	.modal_cancel:hover{
		border: 2px solid #f6f6f6;
	}
	.modal_ok{
		background-color: #84a099;
		color: #ffffff;
	}
	.modal_ok:hover{
		border: 2px solid #84a099;
	}
	.modal .alert{
		width: 725px;
	}
	#modal_add_store .modal_content{
		overflow: auto;
		width: 100%;
		height: 280px;
		padding: 10px;
	}
	#modal_add_store .modal_content table{
		margin-top: 17px;
	}
	#modal_add_store .modal_content .copy_table td{
		min-width: 100px;
	}
	#modal_add_store .modal_content .text_input{
		width: 755px;
		height: 35px;
		line-height: 35px;
		font-size: 20px;
		padding-left: 10px;
		padding-right: 10px;
	}
	#modal_add_store .modal_content .td_select{
		padding-left: 20px;
	}
	#modal_add_store .modal_footer{
		float: bottom;
		border-top: 1px solid #ddd;
		background-color: #d3e8db;
		height: 50px;
	}

	#modal_progress_progbar{
		width: 700px;
		margin: auto;
		margin-top: 130px;
	}

	#modal_progress_text{
		text-align: center;
		font-size: 16px;
		margin-top: 5px;
	}
	#modal_progress_ok{
		width: 150px;
		height: 40px;
		margin: auto;
		border-radius: 5px;
		border: 1px solid #666;
		background-color: #84a099;
		text-align: center;
		margin-top: 50px;
		line-height: 40px;
		opacity: 0.4;
	}
	#modal_progress_ok.active{
		opacity: 1;
	}
	#modal_progress_ok.active:hover{
		cursor: pointer;
	}
</style>

<div id="main_container">
	<div id="nav_bar_container" class="row">
		<span class="nav_title nav_item">微积分</span>
		<span class="nav_item active" data-toggle="tab_stores">店铺管理</span>
		<span class="nav_item" data-toggle="tab_sdmessages">消息设置</span>
		<span class="nav_item" data-toggle="tab_members">会员管理</span>
		<span class="nav_item" data-toggle="tab_settings">账户设置</span>
		<span class="nav_item" data-toggle="tab_help">帮助</span>
	</div>
	<div id="tab_container">
		<div class="tab active" id="tab_stores">
			<div class="tab_title">
				<?php 
					if(count($stores) <= 0) 
						echo "您还没有店铺，请先新建一个";
					else 
						echo "欢迎使用微积分，这些是您的店铺";
				?>
			</div>
			<?php
				foreach ($stores as $store) {
					echo '<div class="store_item"><a href="'.
						 Yii::app()->createUrl('takeAway/members').
						 '?sid='.$store->id.'" class="store_folder">'.
						 $store->name.'</a></div>';
				}
				// add the default store
			?>
			<div class="store_item">
				<a href="#" onclick="addStore()" class="store_new"></a>
			</div>
		</div>
		<div class="tab stab" id="tab_sdmessages"></div>
		<div class="tab stab" id="tab_members"></div>
		<div class="tab stab" id="tab_settings"></div>
		<div class="tab stab" id="tab_help"></div>
	</div>
</div>

<div id="mask"></div>
<div id="modal_add_store" class="modal">

	<div class="modal_header">
		新建店铺
		<a href="javascript:" class="modal_close" data-toggle="modal_add_store"></a>
	</div>
	<div class="modal_content">
		<div id="alert_container">
		</div>
		<input id="modal_add_store_name" class="text_input" type="text" name="store_name" placeholder="请输入店铺名称">
		<table class="info_table">
			<tr>
				<td><label>店铺类型</label></td>
				<td colspan="2" class="td_select">
					<select id="store_type_select">
						<option value="1">外卖</option>
					</select>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td><label>复制店铺</label></td>
				<td colspan="2" class="td_select">
					<select onchange="setCopyCheckboxes()" id="copy_select">
						<option value="-1">不复制</option>
						<?php
							foreach ($stores as $store) {
								echo '<option value="'.$store->id.'">'.$store->name.'</option>';
							}
						?>
					</select>
				</td>
			</tr>
		</table>
		<table class="copy_table">
			<tr>
				<td><label class="checkbox"><input id="copy_info" type="checkbox" class="copy_ckb" disabled>基本信息</label></td>
				<td><label class="checkbox"><input id="copy_prod" type="checkbox" class="copy_ckb" disabled>商品信息</label></td>
				<td><label class="checkbox"><input id="copy_tkaw" type="checkbox" class="copy_ckb" disabled>外卖设置</label></td>
				<td><label class="checkbox"><input id="copy_dist" type="checkbox" class="copy_ckb" disabled>配送地区</label></td>
				<td><label class="checkbox"><input id="copy_post" type="checkbox" class="copy_ckb" disabled>配送人员</label></td>
			</tr>
		</table>
	</div>
	<div class="modal_footer">
		<div class="modal_ok modal_btn" onclick="submitAddStore()">确定</div>
		<div class="modal_cancel modal_btn">取消</div>
	</div>
</div>
<div id="modal_progress" class="modal">
	<div class="modal_header">请稍候</div>
	<div class="progress progress-striped active" id="modal_progress_progbar">
	  <div id="modal_progress_bar" class="bar" style="width: 5%;"></div>
	</div>
	<div id="modal_progress_text"></div>
	<div id="modal_progress_ok">完成</div>
</div>
<script type="text/javascript">

	$(document).ready(function(){
		$('.nav_item').click(function(event){
			src = $(event.srcElement);
			$('.nav_item').removeClass('active');
			src.addClass('active');
			$('.tab').removeClass('active');
			$('#' + src.attr('data-toggle')).addClass('active');
		});
		$('.modal_close').click(function(event){
			src = $(event.srcElement);
			$('#' + src.attr('data-toggle')).hide('fast');
			$('#' + src.attr('data-toggle')).find('input').val('');
			$('#mask').hide('fast');
		});
	});

	// show add store modal
	function addStore(){
		$('#mask').show('fast');
		$('#modal_add_store').show('fast');
		$('#mask').click(function(){
			$('#modal_add_store').hide('fast');
			$('#mask').hide('fast');
		});
	}

	function setCopyCheckboxes(){
		if(parseInt($('#copy_select').val()) >= 0){
			$('.copy_ckb').removeAttr('disabled');
		}else{
			$('.copy_ckb').attr('disabled', true);
			$('.copy_ckb').attr('checked', false);	
		}
	}

	function submitAddStore(){
		// check user input
		storeName = $('#modal_add_store_name').val();
		if(storeName && storeName != ''){
			if(storeName.length > 64){
				$('#alert_container').html(
					'<div class="alert alert-error" id="toolong_alert">' +
		  				'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
		  				'<strong>错误</strong>店铺的名称过长' +
					'</div>'
				);
			}else{
				$('#modal_progress').show();
				$('#modal_add_store').hide();
				$('#mask').unbind();
				data = {
					"storeName": storeName,
					'type': $('#store_type_select').val()
				}
				copyid = parseInt($('#copy_select').val());
				if(copyid >= 0){
					data['copyid'] = copyid;
					if(document.getElementById('copy_info').checked) {data['copy'] = 1; data['info'] = 1;}
					if(document.getElementById('copy_prod').checked) {data['copy'] = 1; data['prod'] = 1;}
					if(document.getElementById('copy_tkaw').checked) {data['copy'] = 1; data['tkaw'] = 1;}
					if(document.getElementById('copy_dist').checked) {data['copy'] = 1; data['dist'] = 1;}
					if(document.getElementById('copy_post').checked) {data['copy'] = 1; data['post'] = 1;}
				}
				createStore(data);
			}
		}else{
			$('#alert_container').html(
				'<div class="alert alert-error" id="empty_alert">' +
		  		 	'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
		  		 	'<strong>错误&nbsp;</strong>店铺的名称不能为空' +
				'</div>'
			);
		}
	}

	function createStore(data){
		$('#modal_progress_text').html('正在创建店铺');
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl("accounts/account/createStore")?>',
			data: {'name': data['storeName'], 'type': data['type']},
			dataType: 'json',
			success: function(r){
				if(r['result'] == 0){
					if(data['copy'] == 1){
						$('#modal_progress_text').html('正在复制信息');
						$('#modal_progress_bar').css('width', '40%');
						$.ajax({
							type: 'post',
							url: '<?php echo Yii::app()->createUrl("accounts/account/copy")?>',
							data: {'src': data['copyid'], 
								   'dst': r['sid'], 
								   'info': data['info'] ? 1 : 0,
								   'prod': data['prod'] ? 1 : 0,
								   'tkaw': data['tkaw'] ? 1 : 0,
								   'dist': data['dist'] ? 1 : 0,
								   'post': data['post'] ? 1 : 0,
								  },
							dataType: 'json',
							success: function(r1){
								if(r1['result'] == 0){
									$('#modal_progress_bar').css('width', '100%');
									$('#modal_progress_ok').addClass('active');
									$('#modal_progress_ok').click(function(){
										window.location.reload();
									});
									$('#modal_progress_text').html('已创建店铺');
								}
							},
							fail: function(r1){

							}
						});
					}else{
						$('#modal_progress_text').html('已创建店铺');
						$('#modal_progress_bar').css('width', '100%');
						$('#modal_progress_ok').addClass('active');
						$('#modal_progress_ok').click(function(){
							window.location.reload();
						});
					}
				}else if(r['result'] == 1){
					$('#alert_container').html(
						'<div class="alert alert-error" id="duplicate_alert">' +
					  		'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
					  		'<strong>错误</strong>店铺的名称不能重复' +
						'</div>'
					);
					$('#modal_progress').hide();
					$('#modal_add_store').show();
					$('#mask').click(function(){
						$('#modal_add_store').hide('fast');
						$('#mask').hide('fast');
					});
				}
			},
			fail: function(r){
				console.log(r);
			}
		});
	}
</script>