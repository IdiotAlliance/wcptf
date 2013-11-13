<?php 
	$utils = new Utils;
?>
<style>
	form{
		margin-left: 20px;
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

<script type="text/javascript">
	var data = eval('(' + '<?php echo $json?>' + ')');
	
	// 设置容器宽度，并使其随着窗口大小改变而改变
	$(document).ready(function(){
		setContainerWidth();
		window.onresize = setContainerWidth;
		initView();
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
								'<div class="span3">' + (type.picurl?type.picurl:"未上传图片") + '&nbsp;</div>' +
								'<button class="span2">上传图片</button>' + 
								'<div class="span1"></div>' + 
								'<select class="span1" id="select_' + type.id + '">' +
									'<option value="无">无</option>' +
									'<option value="热销">热销</option>' +
									'<option value="推荐">推荐</option>' +
									'<option value="新品">新品</option>' +
								'</select>' +
							'</div>' +
							'<div class="span1">设为首页</div>' +
						 '</div>');
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
							'" ' + (product.insufficient=="1"?'checked':'') + '/>' + 
							product.pname + 
						'</div>'
			}
			html += '</div><br>';
			instore.append(html);
		}
	}

	// 点击商品类型事件
	function ontype(elem){
		typeid = elem.id.substr(16);
		for(typeindex in data['types']){
			var type = data['types'][typeindex];
			if(type.id == parseInt(typeid)){
				for(proindex in type['products']){
					var product = type['products'][proindex];
					var proid   = product.id;
				}
				break;
			}
		}
	}

	// 点击单个商品事件
	function onpro(elem){
		
	}

	function submit(){
		// 获得商铺信息
		data['shopinfo']['status'] = $('#store_status').val();
		data['shopinfo']['broadcast'] = $('#broadcast').val();
	}
</script>