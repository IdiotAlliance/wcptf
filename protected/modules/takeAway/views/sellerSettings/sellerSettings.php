<?php 
	$utils = new Utils;
?>
<style>
	#product_types form{
		margin-bottom: 0 !important;
	}
	.checkbox{
		margin-top: -5px;
	}
	.input_label{
		line-height: 28px;
	}
	.textaligned:{
		line-height: 30px;
	}
	.index_switch:hover{
		cursor: pointer;
		text-decoration: underline;
	}
	.index_switch_disabled:hover{
		cursor: default;
		text-decoration: none;
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
	<form style="display: none" id="settings_json_form" 
		  action="<?php echo Yii::app()->createUrl('takeAway/sellerSettings/sellerSettings')?>" method="post">
		<input type="text" name="json" id="form_json_input">
		<input type="submit" id="form_json_submit">
	</form>
	<div id="seller_settings_actions">
		<button id="seller_settings_save" class="btn btn-primary action_btn" onclick="submit()">保存</button>
		<button id="seller_settings_cancel" class="btn action_btn" onclick="cancel()">放弃更改</button>
	</div>
	<hr>
	<b><?php echo Utils::getDate('y-m-d w');?></b><br><br>
	<div>
		店铺状态：
		<select name="store_status" id="store_status">
			<option value="0">正常经营</option>
			<option value="1">暂停外卖</option>
			<option value="2">暂停营业</option>
		</select>
	</div>
	<div class="row">
		<div class="span1">店铺公告：</div>
		<textarea id="broadcast" rows="5" cols="" class="span5"></textarea>
	</div>
	
	
	<hr>
	<h5>品类促销</h5>
	<div id="product_types"></div>
	
	<hr>
	<h5>今日外送片区（请勾选外送片区）</h5>
	<div id="districts" class="row"></div>
	
	<hr>
	<h5>今日外送人员（请勾选外送人员）</h5>
	<div id="posters" class="row"></div>
	
	<hr>
	<h5>今日库存管理（请勾选今日库存告急的产品）</h5>
	<div id="instore_management"></div>
	
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.form.js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	var data = eval('(' + '<?php echo $json?>' + ')');
	
	// 设置容器宽度，并使其随着窗口大小改变而改变
	$(document).ready(function(){
		setContainerWidth();
		window.onresize = setContainerWidth;
		initView();
		$('#form_json_input').val(escape(JSON.stringify(data)));


		for(typeindex in data['types']){
			var type = data['types'][typeindex];
			$("#fileupload_" + type.id).change(function(){
				var id = this.id.substr(11);
				$("#myupload_" + id).ajaxSubmit({
					dataType:  'json',
					success: function(data) {
						var img = "<?php echo Yii::app()->baseUrl;?>"+"/"+data.pic_path;
						$('#pic_url_'+id).html(img);
					},
					error:function(xhr){
						alert("上传失败");
					}
				});
			});
		}	
	});

	function setContainerWidth(){
		width = document.body.clientWidth;
		$('#seller_settings_container').css("width", width - 220 + "px");
	}

	function initView(){
		initShopInfo();
		initTypes();
		initDistricts();
		initPosters();
		initInstore();		
	}

	function initShopInfo(){
		$('#store_status').val(data['shopinfo']['status']);
		$('#broadcast').val(data['shopinfo']['broadcast']);
	}

	function initTypes(){
		var types = $('#product_types');
		for(typeindex in data['types']){
			var type = data['types'][typeindex];
			console.log(type);
			types.append('<div class="row">' + 
							'<div class="span8 row">' + 
								'<b class="span1">' + type.type_name + '</b>' +
								'<div class="span3" id="pic_url_' + type.id + '">' + (type.picurl?type.picurl:"未上传图片") + '</div>' +
								'<input type="file" id="fileupload_' + type.id +'" name="hots">' + 
								'<div class="span1"></div>' + 
								'<select onchange="select(this)" class="span1" id="select_' + type.id + '">' +
									'<option value="无">无</option>' +
									'<option value="热卖">热卖</option>' +
									'<option value="推荐">推荐</option>' +
									'<option value="新品">新品</option>' +
								'</select>' +
							'</div>' +
							'<div onclick="setIndex(this)" href="#" class="span1 index_switch" id="set_index_' + type.id + '">设为首页</div>' +
						 '</div>');
			//设置选项
			$('#select_' + type.id).val(type.tag);
			if(!type.hot){
				$('#fileupload_' + type.id).attr('disabled', true);
				$('#set_index_' + type.id).addClass('index_switch_disabled');
			}else{
				if(type.onindex == '1')
					$('#set_index_' + type.id).html('首页推荐');
			}
			
			/*图片上传*/
			$("#fileupload_" + type.id).wrap("<form class='span2' id=\"myupload_" + type.id + "\" action='<?php echo Yii::app()->createUrl('takeAway/sellerSettings/imgUpload')?>/typeId/" + type.id + "' method='post' enctype='multipart/form-data'></form>");
		}
	}


	function initDistricts(){
		var districts = $('#districts');
		for(index in data['districts']){
			var district = data['districts'][index];
			districts.append(
					('<div class="span2 textaligned">' + 
							'<input type="checkbox" id="dis_checkbox_' + 
							+ district.id + '" ' + (district.daily_status=="0"?'checked':'') + '>' 
							+ district.name +
					'</div>'));
		}
	}

	function initPosters(){
		var posters = $('#posters');
		var array = new Array();
		for(index in data['posters']){
			var poster = data['posters'][index];
			posters.append('<div class="span2 textaligned">' +
								'<input type="checkbox" id="pos_checkbox_' + 
								+ poster.id + '" ' + (poster.daily_status=="0"?'checked':'') + '>' 
								+ poster.name +
						   '</div>');
		}
	}

	function initInstore(){
		var instore = $('#instore_management');
		for(index1 in data['types']){
			var type = data['types'][index1];
			if(type)
			instore.append('<div class="row">' +
								'<div class="span1">' + 
									'<input onclick="ontype(this)" type="checkbox" id="instore_type_cb_' + type.id + 
									'" ' + (type.insufficient=="1"?'checked':'') + '>' +
									'<b>' + type.type_name + '</b>' +
								'</div>' +
						   '</div>'
					);
			var html = '<div class="row" style="padding-left:20px;">';
			for(index2 in type['products']){
				var product = type['products'][index2];
				html += '<div class="span2">' + 
							'<input onclick="onpro(this)" type="checkbox" id="instore_pro_cb_' + product.id + 
							'" name="' + type.id + '"' +
							'" ' + (product.insufficient=="1"?'checked':'') + '/>' + 
							product.pname + 
						'</div>'
			}
			html += '</div><br>';
			instore.append(html);
		}
	}

	// 推荐商品事件
	function select(elem){
		typeid = elem.id.substr(7);
		if($(elem).val()=='无'){
			if($('#set_index_' + typeid).html() == '首页推荐'){
				$('#set_index_' + typeid).html('设为首页');
			}
			$('#set_index_' + typeid).addClass('index_switch_disabled');
			$('#fileupload_' + typeid).attr('disabled', true);
		}else{
			$('#set_index_' + typeid).removeClass('index_switch_disabled');
			$('#fileupload_' + typeid).attr('disabled', false);
		}
	}

	// 点击商品类型事件
	function ontype(elem){
		var typeid = elem.id.substr(16);
		var check = false;
		if($(elem).attr('checked')){
			check = true;
		}
		for(typeindex in data['types']){
			var type = data['types'][typeindex];
			if(type.id == parseInt(typeid)){
				for(proindex in type['products']){
					var product = type['products'][proindex];
					var proid   = product.id;
					$('#instore_pro_cb_' + proid).attr('checked', check);
				}
				break;
			}
		}
	}

	// 点击单个商品事件
	function onpro(elem){
		var proid  = elem.id.substr(15);
		var typeid = elem.name;
		if(!$(elem).attr('checked') && $('#instore_type_cb_' + typeid).attr('checked')){
			$('#instore_type_cb_' + typeid).attr('checked', false);
		}
	}

	function setIndex(elem){
		if($(elem).html() == '设为首页' && !$(elem).hasClass('index_switch_disabled')){
			$('.index_switch').html('设为首页');
			$(elem).html('首页推荐');
		}
	}

	function submit(){
		// 获得商铺信息
		data['shopinfo']['status'] = $('#store_status').val();
		data['shopinfo']['broadcast'] = $('#broadcast').val();

		// 获得推荐信息
		for(typeindex in data['types']){
			var typeid = data['types'][typeindex].id;
			var picurl = $('#pic_url_' + typeid).html();
			var tag    = $('#select_' + typeid).val();
			var index  = $('#set_index_' + typeid).html() == '首页推荐';
			var insufficient = $('#instore_type_cb_' + typeid).attr('checked');
			if(picurl != '未上传图片')
				data['types'][typeindex].picurl = picurl;
			else
				data['types'][typeindex].picurl = "";
				
			if(tag != '无'){
				data['types'][typeindex].tag = tag;
				data['types'][typeindex].hot = true;
			}else{
				data['types'][typeindex].hot = false;
				data['types'][typeindex].tag = null;
			}
			
			if(index)
				data['types'][typeindex].onindex = 1;
			else
				data['types'][typeindex].onindex = 0;
			
			if(insufficient)
				data['types'][typeindex].insufficient = 1;
			else
				data['types'][typeindex].insufficient = 0;

			for(proindex in data['types'][typeindex]['products']){
				var proid = data['types'][typeindex]['products'][proindex].id;
				var pinsufficient = $('#instore_pro_cb_' + proid).attr('checked');
				if(pinsufficient)
					data['types'][typeindex]['products'][proindex].insufficient = 1;
				else
					data['types'][typeindex]['products'][proindex].insufficient = 0;
			}
		}

		// 获得片区信息
		for(disindex in data['districts']){
			var disid = data['districts'][disindex].id;
			if($('#dis_checkbox_' + disid).attr('checked')){
				data['districts'][disindex].daily_status = 0;
			}else{
				data['districts'][disindex].daily_status = 1;
			}
		}

		// 获得派送信息
		for(posindex in data['posters']){
			var posid = data['posters'][posindex].id;
			if($('#pos_checkbox_' + posid).attr('checked')){
				data['posters'][posindex].daily_status = 0;
			}else{
				data['posters'][posindex].daily_status = 1;
			}
		}

		document.charset = "utf-8";
		$('#form_json_input').val(escape(JSON.stringify(data)));
		$('#form_json_submit').click();
	}

	function cancel(){
		window.location.reload();
	}
</script>