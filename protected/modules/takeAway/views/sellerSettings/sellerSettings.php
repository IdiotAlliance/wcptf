<?php 
	$utils = new Utils;
?>
<style>
	#product_types form{
		margin-bottom: 0 !important;
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
	.set_index{
		color: red;
	}
	#seller_settings_container{
		position: absolute;
		left: 200px;
		right: 0px;
		top: 41px;
		bottom: 0px;
		overflow-y: auto;
		overflow-x: hidden;
		width: expression(document.width - 200 + "px");
	}
	#seller_settings_actions{
		position:fixed;
		background-color: #ffffff;
		width: 100%;
		padding-top: 10px;
		padding-bottom: 10px;
		padding-left: 20px;
		box-shadow: 0px 1px 3px #808080;
		-moz-box-shadow: 0px 1px 3px #808080;
	}
	#seller_settings_main_container{
		margin-top: 60px;
		padding-left: 20px;
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
	
	<div id="seller_settings_main_container">
		<h4><?php echo Utils::getDate('y-m-d w');?></h4>
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
		<h4>品类促销</h4>
		<div id="product_types"></div>
		
		<hr>
		<h4>今日外送片区（请勾选外送片区）</h4>
		<div id="districts" class="row"></div>
		
		<hr>
		<h4>今日外送人员（请勾选外送人员）</h4>
		<div id="posters" class="row"></div>
		
		<hr>
		<div class="row">
			<h4 class="span2">今日库存管理</h4>
			<span class="btn span2" onclick="showEditModal()">
				<span class="icon-edit"></span>&nbsp;编辑产品库存
			</span>
		</div><br>
		<div id="instore_management"></div>
	</div>
</div>

<!-- Modal -->
<div id="instore_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">修改库存</h3>
  </div>
  <div class="modal-body">
  	<div id="instore_modal_info"></div><br>
  	<input type="text" id="instore_modal_num">
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
    <button class="btn btn-primary" onclick="editInstore()">确认修改</button>
  </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.form.js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	var data = eval('(' + '<?php echo $json?>' + ')');
	var info_threshold = 30;
	var warn_threshold = 10;
	
	// 设置容器宽度，并使其随着窗口大小改变而改变
	$(document).ready(function(){
		initView();
		$('#form_json_input').val(escape(JSON.stringify(data)));
		for(typeindex in data['types']){
			var type = data['types'][typeindex];
			$("#fileupload_" + type.id).change(function(){
				var id = this.id.substr(11);
				$("#myupload_" + id).ajaxSubmit({
					dataType:  'json',
					success: function(data) {
						var img = data.pic_path;
						$('#pic_url_'+id).html(img);
					},
					error:function(xhr){
						alert("上传失败");
					}
				});
			});
		}
	});


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
				if(type.onindex == '1'){
					$('#set_index_' + type.id).html('首页推荐');
					$('#set_index_' + type.id).addClass('set_index');
				}
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
					('<label class="checkbox span2 textaligned">' + 
							'<input type="checkbox" id="dis_checkbox_' + 
							+ district.id + '" ' + (district.daily_status=="0"?'checked':'') + '>' 
							+ district.name +
					'</label>'));
		}
	}

	function initPosters(){
		var posters = $('#posters');
		var array = new Array();
		for(index in data['posters']){
			var poster = data['posters'][index];
			posters.append('<label class="checkbox span2 textaligned">' +
								'<input type="checkbox" id="pos_checkbox_' + 
								+ poster.id + '" ' + (poster.daily_status=="0"?'checked':'') + '>' 
								+ poster.name +
						   '</label>');
		}
	}

	function initInstore(){
		var instore = $('#instore_management');
		for(index1 in data['types']){
			var type = data['types'][index1];
			if(type)
			instore.append('<div class="row-fluid">' +
								'<label class="span2 checkbox">' + 
									'<input onclick="ontype(this)" type="checkbox" id="instore_type_cb_' + type.id + '" ' + 
									'<b>' + type.type_name + '</b>' +
								'</label>' +
						   '</div>'
					);
			var html = '<div class="row-fluid" style="padding-left:20px;">';
			for(index2 in type['products']){
				var product = type['products'][index2];
				html += '<div class="span3">' + 
							'<label class="checkbox label">' +
								'<input onclick="onpro(this)" type="checkbox" id="instore_pro_cb_' + 
								product.id + '" name="' + type.id + '"/>' + 
								product.pname +
								'<div class="badge badge-' + (product.daily_instore>info_threshold?'success':(product.daily_instore>warn_threshold?'warning':'important')) + 
								'" id="daily_instore_' + product.id + '">' + product['daily_instore'] + '</div>' +
							'</label>' +
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

	// 设置产品首页
	function setIndex(elem){
		if($(elem).html() == '设为首页' && !$(elem).hasClass('index_switch_disabled')){
			$('.index_switch').html('设为首页');
			$('.index_switch').removeClass('set_index');
			$(elem).html('首页推荐');
			$(elem).addClass('set_index');
		}
	}

	function showEditModal(){
		var selection = 0;
		var html = "修改&nbsp;<b>";
		for(typeindex in data['types']){
			var type = data['types'][typeindex];
			for(proindex in type['products']){
				var product = type['products'][proindex];
				var proid   = product.id;
				if($('#instore_pro_cb_' + proid).attr('checked')){
					if(selection == 0)
						html += product.pname;
					selection ++;
				}
			}
		}
		if(selection > 0){
			html += '</b>&nbsp;等&nbsp;<b>' + selection + '</b>&nbsp;件商品的库存为：';
			$('#instore_modal_info').html(html);
			$('#instore_modal').modal('show');
		}else{
			alert('您未选中任何商品');
		}
	}

	// 编辑库存信息
	function editInstore(){
		var num = $('#instore_modal_num').val();
		if(/\d+/.test(num)){
			if(parseInt(num) < 0){
				alert('无效的数字');
				$('#instore_modal_num').val('');
				return;
			}else{
				for(typeindex in data['types']){
					var type = data['types'][typeindex];
					for(proindex in type['products']){
						var product = type['products'][proindex];
						var proid   = product.id;
						if($('#instore_pro_cb_' + proid).attr('checked')){
							$('#daily_instore_' + proid).html(num);
							$('#daily_instore_' + proid + '.badge-success').removeClass('badge-success');
							$('#daily_instore_' + proid + '.badge-warning').removeClass('badge-warning');
							$('#daily_instore_' + proid + '.badge-important').removeClass('badge-important');
							if(parseInt(num) > info_threshold){
								$('#daily_instore_' + proid).addClass('badge-success');
							}else if(parseInt(num) > warn_threshold){
								$('#daily_instore_' + proid).addClass('badge-warning');
							}else{
								$('#daily_instore_' + proid).addClass('badge-important');
							}
						}
					}
				}
				$('#instore_modal_num').val('');
				$('#instore_modal').modal('hide');
			}
		}else{
			alert('无效的数字');
			$('#instore_modal_num').val('');
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

			for(proindex in data['types'][typeindex]['products']){
				var proid = data['types'][typeindex]['products'][proindex].id;
				var daily_instore = $('#daily_instore_' + proid).html();
				data['types'][typeindex]['products'][proindex]['daily_instore'] = daily_instore;
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