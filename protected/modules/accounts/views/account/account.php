<style type="text/css">
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
	}

	#tab_stores .store_item .store_folder .store_folder_name{
		position: relative;
		width: 152px;
		top: 45px;
		text-align: center;
		color: #ffffff;
		text-shadow: 1px 1px rgba(0, 0, 0, 0.5);
		text-decoration: none;
	}

	#tab_stores .store_item .store_item_padding{
		position: absolute;
	}

	#tab_stores .store_item .store_item_padding.padding1{
		width: 45px;
		height: 220px;
		left: 0;
		top: 0;
	}

	#tab_stores .store_item .store_item_padding.padding2{
		width: 152px;
		height: 20px;
		left: 45px;
		top: 0;
	}

	#tab_stores .store_item .store_item_padding.padding3{
		width: 45px;
		height: 220px;
		left: 196px;
		top: 0;
	}

	#tab_stores .store_item .store_item_padding.padding4{
		width: 152px;
		height: 100px;
		left: 45px;
		top: 132px;
	}

	#tab_stores .store_item .store_tools{
		position: absolute;
		width: 152px;
		height: 0;
		bottom: 1px;
		left: 0;
		overflow: hidden;
		border-bottom-left-radius: 5px;
		border-bottom-right-radius: 5px;
		background-color: #222;
		opacity: 0.5;
	}

	#tab_stores .store_item .store_tools .store_tool_btn{
		float: right;
		margin-top: 7px;
		width: 14px;
		height: 14px;
		border-radius: 4px;
		border: 1px solid #fff;
		margin-right: 5px;
	}

	#tab_stores .store_item .store_tools .store_tool_btn:hover{
		cursor: pointer;
		background-color: #888;
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
	.modal .modal_content{
		overflow: auto;
		width: 100%;
		height: 280px;
		padding: 10px;
	}
	.modal .modal_footer{
		float: bottom;
		border-top: 1px solid #ddd;
		background-color: #d3e8db;
		height: 50px;
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
	#modal_edit_store form{
		background-color: #fff;
		padding-left: 10px;
		padding-bottom: 5px;
		margin-left: 15px;
		margin-top: 20px;
		width: 715px;
	}
	#modal_delete_store form{
		background-color: #fff;
		padding-left: 10px;
		padding-bottom: 5px;
		margin-left: 15px;
		margin-top: 20px;
		width: 715px;
	}
</style>
	
<div id="tab_container">
	<div>
	<?php if($errmsg) 
	echo '<div class="alert alert-error" id="error_alert">'.
	  		 	'<button type="button" class="close" data-dismiss="alert">&times;</button>'.
	  		 	'<strong>错误&nbsp;</strong>'.$errmsg.'</div>' ?>
	</div>
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
				echo '<div class="store_item">'.
					 '<div class="store_item_padding padding1"></div>'.
					 '<div class="store_item_padding padding2"></div>'.
					 '<div class="store_item_padding padding3"></div>'.
					 '<div class="store_item_padding padding4"></div>'.
					 '<a href="'.
					 Yii::app()->createUrl('takeAway/members').
					 '?sid='.$store->id.'" class="store_folder">'.
					 '<span class="store_folder_name">'.$store->name.'</span>'.
					 	'<div class="store_tools" id="'.$store->id.'" name="'.$store->name.'">'.
					 		'<i class="store_tool_remove store_tool_btn icon-remove icon-white"></i>'.
					 		'<i class="store_tool_edit store_tool_btn icon-edit icon-white"></i>'.
					 	'</div>'.
					 '</a>'.
					 '</div>';
			}
			// add the default store
		?>
		<div class="store_item">
			<a href="#" onclick="addStore()" class="store_new"></a>
		</div>
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
		<div class="modal_cancel modal_btn" data-toggle="modal_add_store">取消</div>
	</div>
</div>
<div id="modal_edit_store" class="modal">
	<div class="modal_header">
		编辑店铺
		<a href="javascript:" class="modal_close" data-toggle="modal_edit_store"></a>
	</div>
	<div class="modal_content">
		
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		    'id'=>'edit_store_form',
		    'enableClientValidation'=>true,
		    'clientOptions'=>array(
		        'validateOnSubmit'=>true,
		    ),
		    'htmlOptions'=>array('class'=>'well row'),
		)); ?>
		<div class="hidden">
		<?php echo $form->textFieldRow($editForm, 'sid', 
	                                array(
	                                    'class'=>'input-large', 
	                                    )); ?>
        </div>
	    <?php echo $form->textFieldRow($editForm, 'newname', 
	                                array(
	                                    'class'=>'input-large', 
	                                    'prepend'=>'<i class="icon-home"></i>',
	                                    'placeholder'=>'请输入新的店铺名称',
	                                    'tabindex'=>'1',
	                                    )); ?>
	    <?php echo $form->captchaRow($editForm, 'vericode', 
	    							array(
										'class'=>'input-large',
										'prepend'=>'<i class="icon-ok-circle"></i>',
										'captchaOptions'=>array(
	                                        'clickableImage'=>true,
	                                        'showRefreshButton'=>true,
	                                        'buttonLabel'=>'换一张',
                                        ),
                                    'enableAjaxValidation'=>false,
                                    )); ?>
		<input type="submit" class="submit hidden" id="modal_edit_submit">
		<?php $this->endWidget(); ?>
	</div>
	<div class="modal_footer">
		<div class="modal_ok modal_btn" onclick="submitEdit()">确定</div>
		<div class="modal_cancel modal_btn" data-toggle="modal_edit_store">取消</div>
	</div>
</div>
<div id="modal_delete_store" class="modal">
	<div class="modal_header">
		删除店铺
		<a href="javascript:" class="modal_close" data-toggle="modal_delete_store"></a>
	</div>
	<div class="modal_content">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		    'id'=>'delete_store_form',
		    'enableClientValidation'=>true,
		    'clientOptions'=>array(
		        'validateOnSubmit'=>true,
		    ),
		    'htmlOptions'=>array('class'=>'well row'),
		)); ?>
		<div class="hidden">
		<?php echo $form->textFieldRow($deleteForm, 'sid', 
	                                array(
	                                    'class'=>'input-large', 
	                                    )); ?>
        </div>
	    <?php echo $form->passwordFieldRow($deleteForm, 'pass', 
	                                array(
	                                    'class'=>'input-large', 
	                                    'prepend'=>'<i class="icon-lock"></i>',
	                                    'placeholder'=>'请输入密码',
	                                    'tabindex'=>'1',
	                                    )); ?>
	    <?php echo $form->captchaRow($deleteForm, 'vericode', 
	    							array(
										'class'=>'input-large',
										'prepend'=>'<i class="icon-ok-circle"></i>',
										'captchaOptions'=>array(
	                                        'clickableImage'=>true,
	                                        'showRefreshButton'=>true,
	                                        'buttonLabel'=>'换一张',
                                        ),
                                    'enableAjaxValidation'=>false,
                                    )); ?>
		<input type="submit" class="submit hidden" id="modal_delete_submit">
		<?php $this->endWidget(); ?>
	</div>
	<div class="modal_footer">
		<div class="modal_ok modal_btn" onclick="submitDelete()">确定</div>
		<div class="modal_cancel modal_btn" data-toggle="modal_delete_store">取消</div>
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
		// $('.nav_item').click(function(event){
		// 	src = event.target;
		// 	$('.nav_item').removeClass('active');
		// 	$(src).addClass('active');
		// 	$('.tab').removeClass('active');
		// 	if(src.getAttribute('data-toggle')){
		// 		$('#' + src.getAttribute('data-toggle')).addClass('active');
		// 	}else{

		// 	}
		// });
		$('.modal_close').click(function(event){
			// if(event.srcElement) console.log('foo');
			src = event.target;
			if(src.getAttribute('data-toggle')){
				$('#' + src.getAttribute('data-toggle')).hide('fast');
				$('#' + src.getAttribute('data-toggle')).find('input').val('');
			}
			$('#mask').hide('fast');
		});
		$('.modal_cancel').click(function(event){
			src = event.target;
			if(src.getAttribute('data-toggle')){
				$('#' + src.getAttribute('data-toggle')).hide('fast');
				$('#' + src.getAttribute('data-toggle')).find('input').val('');
			}
			$('#mask').hide('fast');
		});
		$('.store_item_padding').mouseenter(function(event){
			$(event.target).parent().find('.store_tools').animate({height: "0"}, 'fast');
		});
		$('.store_folder').mouseenter(function(event){
			src = event.target;
			$(src).find('.store_tools').animate({height: "30px"}, 'fast');
			// $('.store_tools', $(src).parent()).animate({height: "30px"}, 'fast');
		});
		$('.store_tool_edit').click(function(event){
			src = $(event.target);
			event.preventDefault();
			$('#mask').show('fast');
			$('#modal_edit_store').show('fast');
			$('#mask').click(function(){
				$('#modal_edit_store').hide('fast');
				$('#mask').hide('fast');
			});
			$('.store_tools').animate({height: "0"}, 'fast');
			$('#EditStoreForm_sid').val(src.parent().attr('id'));
			$('#EditStoreForm_newname').val(src.parent().attr('name'));
			$('#EditStoreForm_vericode').val('');
		});
		$('.store_tool_remove').click(function(){
			src = $(event.target);
			event.preventDefault();
			$('#mask').show('fast');
			$('#modal_delete_store').show('fast');
			$('#mask').click(function(){
				$('#modal_delete_store').hide('fast');
				$('#mask').hide('fast');
			});
			$('.store_tools').animate({height: "0"}, 'fast');
			$('#DeleteStoreForm_sid').val(src.parent().attr('id'));
			$('#DeleteStoreForm_pass').val('');
			$('#DeleteStoreForm_vericode').val('');
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

	function submitEdit(){
		$('#modal_edit_submit').click();
	}

	function submitDelete(){
		$('#modal_delete_submit').click();	
	}
</script>