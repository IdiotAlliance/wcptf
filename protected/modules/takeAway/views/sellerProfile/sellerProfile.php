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
	#config_main_container{
		padding-left: 20px;
	}
	#seller_profile_actions{
		width: 100%;
		padding-left: 20px;
		margin-top: 20px;
	}
</style>
<div id="seller_profile_config">
	<div id="seller_profile_actions">
		<button id="seller_profile_save" class="btn btn-primary action_btn" onclick="submit()">保存</button>
		<button id="seller_profile_cancel" class="btn action_btn" onclick="window.location.reload()">放弃更改</button>
	</div>
	<hr>
	<form style="display: none" action="<?php echo Yii::app()->createUrl('takeAway/sellerProfile')?>" method="post">
		<input type="text" name="json" id="form_json_input"/>
		<input type="submit" id="form_submit">
	</form>
	<div id="config_main_container">
		<h5>店铺信息</h5>
		<div class="row">
			<div class="row span3">
				店铺名称：<input class="span2" id="store_name" name="store_name" type="text">
			</div>
			<div class="span2">
				店铺类型：
				<span class="label label-info" id="store_type"></span>
			</div>
		</div>
		<div class="row">
			<div class="span1 input_label">点单电话：</div>
			<input class="span2" id="phone_number" name="phone" type="text">
		</div>
		<div class="row">
			<div class="span1 input_label">经营时间：</div>
			<input class="span2" id="stime" name="stime" type="text">
			&nbsp;至&nbsp;
			<input class="span2" id="etime" name="etime" type="text">
		</div>
		<div class="row">
			<div class="span1 input_label">店铺地址：</div>
			<input class="span4" id="store_address" name="store_address" type="text" >
		</div>
		
		<!-- 上传logo -->
		<div class="row">
			<div class="span1 input_label">logo：</div>
			<img class="span2" alt="" src="" id="logoimg" />
			<form id="uploadLogoForm" method="post" 
					action="<?php echo Yii::app()->createUrl('takeAway/sellerProfile/imgUpload')?>">
				<input id="uploadlogo" type="file" name="logo" >
			</form>
		</div>
		<!-- 上传店内环境照，最多十张 -->
		<div class="row">
		
		</div>
		<hr>
		<h5>外送设定</h5>
		<div class="row">
			<div class="row span3">
				起送价格：<input type="text" id="start_price" name="start_price" class="span2"/>
			</div>
		</div>
		<div class="row">
			<div class="row span3">
				外卖费用：<input type="text" id="takeaway_fee" name="takeaway_fee" class="span2" />
			</div>
			<div class="span3 input_label">
				<input type="checkbox" id="threshold" name="threshold">超过起送价格免运费
			</div>
		</div>
		<div class="row">
			<div class="row span3 input_label">
				预计时间：<input type="text" id="es_time" name="estimated_time" class="span2">分钟
			</div>
		</div>
		<div>
			配送片区：<select id="districts_select" onchange="setDistrict()">
			</select>
			&nbsp;&nbsp;<a href="#dismodal" role="button" data-toggle="modal">添加新片区</a>
			&nbsp;<a href="#" onclick="deleteDistrict()">删除该片区</a>
			<div class="row" >
				<div class="span1">详细描述：</div>
				<textarea id="district_desc" rows="5" cols="10" class="span5" onkeyup="setDisDesc()"></textarea>
			</div>
		</div>
		<div>
			配送人员：<select id="posters_select" onchange="setPoster()">
			</select>
			&nbsp;&nbsp;<a href="#posmodal" role="button" data-toggle="modal">添加新送货员</a>&nbsp;
			<a href="#" onclick="deletePoster()">删除该送货员</a>
			<div class="row">
				<div class="span1">联系方式：</div>
				<input type="text" class="span5" id="poster_phone" onkeyup="setPosPhone()"/>
			</div>
			<div class="row">
				<div class="span1">详细描述：</div>
				<textarea rows="5" cols="10" class="span5" id="poster_desc" onkeyup="setPosDesc()"></textarea>
			</div>
		</div>
		<!-- Modal -->
		<div id="dismodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">新建片区</h3>
		  </div>
		  <div class="modal-body">
		  	<label>片区名：</label><input type="text" id="add_district_name">
		  	<label>详细描述：</label><textarea id="add_district_desc"></textarea>
		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		    <button class="btn btn-primary" onclick="addDistrict()">添加片区</button>
		  </div>
		</div>
		
		<!-- Modal -->
		<div id="posmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">添加送货员</h3>
		  </div>
		  <div class="modal-body">
		  	<label>姓名：</label><input type="text" id="add_poster_name">
		  	<label>电话：</label><input type="text" id="add_poster_phone">
		  	<label>描述：</label><textarea id="add_poster_desc" ></textarea>
		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
		    <button class="btn btn-primary" onclick="addPoster()">添加</button>
		  </div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.form.js" charset="utf-8"></script>
<script type="text/javascript">

	var selected_dis = -1;
	var selected_pos = -1;
	
	var data = eval('(' + '<?php echo $json_data?>' + ')');

	// 设置容器宽度，并使其随着窗口大小改变而改变
	$(document).ready(function(){
		setContainerWidth();
		window.onresize = setContainerWidth;
		$('#form_json_input').val(escape(JSON.stringify(data)));
		initView();
		$('#store_name').focusout(function(){
			setStoreName();
		});
		$('#phone_number').focusout(function(){
			setPhone();
		});
		$('#stime').focusout(function(){
			setStime();
		});
		$('#etime').focusout(function(){
			setEtime();
		});
		$('#store_address').focusout(function(){
			setStoreAddress();
		});
		$('#start_price').focusout(function(){
			setStartPrice();
		});
		$('#takeaway_fee').focusout(function(){
			setThreshold();
		});
		$('#es_time').focusout(function(){
			setESTime();
		});
		$('#uploadlogo').change(function(){
			uploadLogo();
		});
	});

	function uploadLogo(){
		$("#uploadLogoForm").ajaxSubmit({
			dataType:  'json',
			success: function(result) {
				var img = "<?php echo Yii::app()->baseUrl;?>"+"/"+result.pic_path;
				$('#logoimg').attr('src', img);
				data['shopinfo']['logo'] = img;
			},
			error:function(xhr){
				alert("上传失败");
			}
		});
	}

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

	function initView(){
		$('#store_name').val(data['shopinfo']['store_name']);
		$('#store_type').html(data['shopinfo']['store_type'] == '0' ? '外卖' : '其他');
		$('#phone_number').val(data['shopinfo']['phone']);
		$('#stime').val(data['shopinfo']['stime']);
		$('#etime').val(data['shopinfo']['etime']);
		$('#store_address').val(data['shopinfo']['address']);
		$('#logoimg').attr('src', data['shopinfo']['logo']);
		$('#start_price').val(data['shopinfo']['start_price']);
		$('#takeaway_fee').val(data['shopinfo']['takeaway_fee']);
		if(data['shopinfo']['takeaway_fee'] > "0" && data['shopinfo']['threshold'] == "1")
			$('#threshold').attr('checked', true);
		else if(data['shopinfo']['takeaway_fee'] == "0"){
			$('#threshold').attr('disabled', true);
		}
		
		$('#es_time').val(data['shopinfo']['es_time']);

		if(data['districts'].length > 0){
			for(disindex in data['districts']){
				var district = data['districts'][disindex];
				$('#districts_select').append(
					'<option value="' + disindex + '" id="dis_option_' + disindex + '">' + district.name + '</option>'
				);
			}
			$('#district_desc').val(data['districts'][0].desc);
			selected_dis = 0;
		}else{
			$('#district_desc').attr('disabled', true);
		}

		if(data['posters'].length > 0){
			for(posindex in data['posters']){
				var poster = data['posters'][posindex];
				$('#posters_select').append(
					'<option value="' + posindex + '" id="pos_option_' + posindex + '">' + poster.name + '</option>'
				);	
			}
			$('#poster_phone').val(data['posters'][0].phone);
			$('#poster_desc').val(data['posters'][0].desc);
			selected_pos = 0;
		}else{
			$('#poster_phone').attr('disabled', true);
			$('#poster_desc').attr('disabled', true);
		}
	}

	function setDistrict(){
		if($('#districts_select').val()){
			var disindex = parseInt($('#districts_select').val());
			$('#district_desc').val(data['districts'][disindex].desc);
			$('#district_desc').attr('disabled', false);
			selected_dis = disindex;
		}else{
			$('#district_desc').val(null);
			$('#district_desc').attr('disabled', true);
			selected_dis = -1;
		}
	}

	function setPoster(){
		if($('#posters_select').val()){
			var posindex = parseInt($('#posters_select').val());
			$('#poster_phone').val(data['posters'][posindex].phone);
			$('#poster_desc').val(data['posters'][posindex].desc);
			$('#poster_phone').attr('disabled', false);
			$('#poster_desc').attr('disabled', false);
			selected_pos = posindex;
		}else{
			$('#poster_phone').val(null);
			$('#poster_desc').val(null);
			$('#poster_phone').attr('disabled', true);
			$('#poster_desc').attr('disabled', true);
			selected_pos = -1;
		}
	}

	function setDisDesc(){
		data['districts'][selected_dis].desc = $('#district_desc').val();
	}

	function setPosPhone(){
		data['posters'][selected_pos].phone = $('#poster_phone').val();
	}

	function setPosDesc(){
		data['posters'][selected_pos].desc = $('#poster_desc').val();
	}

	/**
	* 检查店铺名称
	*/
	function setStoreName(){
		var store_name = $('#store_name').val();
		if(!store_name){
			alert('店铺名称不能为空！');
			$('#store_name').val(data['shopinfo']['store_name']);
		}else{
			data['shopinfo']['store_name'] = store_name;
		}
	}

	/**
	 * 检查电话格式
	 */
	function setPhone(){
		var phone = $('#phone_number').val();
		if(phone && /(\d+[-])*\d{3,16}/.test(phone)){
			data['shopinfo']['phone'] = phone;
		}else if(phone){
			alert('无效的号码！');
			$('#phone_number').val(data['shopinfo']['phone']);
		}
	}
	
	/**
	 * 检查起始时间
	 **/
	function setStime(){
		var stime = $('#stime').val();
		if(/(([0-1]*[0-9])|2[0-4]):[0-5]*[0-9](:[0-5]*[0-9])*/.test(stime)){
			data['shopinfo']['stime'] = stime;
		}else{
			$('#stime').val(data['shopinfo']['stime']);
		}
	}

	/**
	 * 检查结束时间
	 */
	function setEtime(){
		var etime = $('#etime').val();
		if(/(([0-1]*[0-9])|2[0-4]):[0-5]*[0-9](:[0-5]*[0-9])*/.test(etime)){
			data['shopinfo']['etime'] = etime;
		}else{
			$('#etime').val(data['shopinfo']['etime']);
		}
	}

	function setStoreAddress(){
		var addr = $('#store_address').val();
		if(addr.length <= 140){
			data['shopinfo']['address'] = addr;
		}else{
			alert('地址过长！');
			$('#store_address').val(data['shopinfo']['address']);
		}
	}

	/**
	 * 检查起送价格
	 */
	function setStartPrice(){
		var p = $('#start_price').val();
		if(/\d+(\.\d+)*/.test(p) && parseFloat(p) >= 0){
			data['shopinfo']['start_price'] = p;
		}else{
			$('#start_price').val(data['shopinfo']['start_price']);
		}
	}

	/**
	 * 检查外卖费
	 */	
	function setThreshold(){
		var fee = $('#takeaway_fee').val();
		if(/\d+(\.\d+)*/.test(fee)){
			if(parseFloat(fee) > 0)
				$('#threshold').attr('disabled', false);
			else if(parseFloat(fee) == 0){
				$('#threshold').attr('disabled', true);
				$('#threshold').attr('checked', false);
			}else if(parseFloat(fee) < 0){
				$('#takeaway_fee').val(data['shopinfo']['takeaway_fee']);
				return;
			}
			data['shopinfo']['takeaway_fee'] = fee;
			$('#takeaway_fee').val(parseFloat(fee));
		}else if(fee){
			$('#takeaway_fee').val(data['shopinfo']['takeaway_fee']);
		}else{
			$('#takeaway_fee').val(data['shopinfo']['takeaway_fee']);
		}
	}

	/**
	 * 检查送达时间
	 */
	function setESTime(){
		var t = $('#es_time').val();
		if(/\d+(\.\d+)*/.test(t) && parseFloat(t) > 0){
			data['shopinfo']['es_time'] = t;
		}else{
			$('#es_time').val(data['shopinfo']['es_time']);
		}
	}

	function addDistrict(){
		var found = false;
		var name = $('#add_district_name').val();
		var desc = $('#add_district_desc').val();
		var length = data['districts'].length;
			
		if(!name){
			alert('片区名称不能为空！');
			return;
		}
		if(!desc){
			alert('片区描述不能为空！');
			return;
		}
		
		for(disindex in data['districts']){
			var district = data['districts'][disindex];
			if(!district.deleted && district.name == name){
				alert('该片区已存在！');
				return;
			}
		}
		data['districts'][length] = {};
		data['districts'][length].name = name;
		data['districts'][length].desc = desc;
		$('#dismodal').modal('hide');
		$('#districts_select').append(
			'<option value="' + length + '" id="dis_option_' + length + '">' + name + '</option>'
		);
		if(selected_dis == -1)
			setDistrict();
		alert('添加成功！');
	}

	function deleteDistrict(){
		if(selected_dis >= 0){
			$('#dis_option_' + selected_dis).remove();
			data['districts'][selected_dis].deleted = true;
			setDistrict();
		}
	}

	function addPoster(){
		var found = false;
		var name = $('#add_poster_name').val();
		var phone = $('#add_poster_phone').val();
		var desc = $('#add_poster_desc').val();
		var length = data['posters'].length;
			
		if(!name){
			alert('派送员名称不能为空！');
			return;
		}
		
		data['posters'][length] = {};
		data['posters'][length].name = name;
		data['posters'][length].phone = phone;
		data['posters'][length].desc = desc;
		$('#posmodal').modal('hide');
		$('#posters_select').append(
			'<option value="' + length + '" id="pos_option_' + length + '">' + name + '</option>'
		);
		if(selected_pos == -1)
			setPoster();
		alert('添加成功！');
	}

	function deletePoster(){
		if(selected_pos >= 0){
			$('#pos_option_' + selected_pos).remove();
			data['posters'][selected_pos].deleted = true;
			setPoster();
		}
	}

	function submit(){
		data['shopinfo']['threshold'] = ($('#threshold').attr('checked')?1:0);
		$('#form_json_input').val(escape(JSON.stringify(data)));
		$('#form_submit').click();
	}


</script>

<?php 
	function getLogo($model){
		if($model->logo == 0)
			return '<img src="">';
		return "";
	}
?>
