<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/rules.css" rel="stylesheet" type="text/css">
<div id='rule-left'>
	<ul id='rule-list'>
		<li id='<?php echo $setup[0]['id'];?>'>
			<h5>关注后自动回复</h5>
			<label>回复类型：<?php echo $setup[0]['type_name'];?></label>
        </li>
		<li id='<?php echo $setup[1]['id'];?>'>
			<h5>无匹配默认回复</h5>
			<label>回复类型：<?php echo $setup[1]['type_name'];?></label>
        </li> 	
	</ul>
	<ul id='custom-list'>
        <?php foreach($itemList as $item):?> 
        <li>
        	<div class='reply-checkbox'><input type='checkbox' name='chkItem' value="<?php echo $item['sdmsgs_id']?>"></div>
        	<div class="left">
	        	<h5><?php echo $item['menu_name'];?></h5>
	        	<label>回复类型：<?php echo $item['type_name'];?></label>
        	</div>
        </li>
        <?php endforeach;?>  
	</ul>

	<!--popover菜单-->
	<ul id='popup' style="display:none">
		<li><a  href="javascript:;">批量删除</a></li>
	</ul>

	<div class='batch-menu'>
		<ul>
			<li>
				<input id='checkAll' type='checkbox'>  全选
			</li>
			<li><a id='batch-option' href="javascript:;">批量操作</a></li>
			<li><a href="#addModal" role="button" data-toggle="modal">添加新规则</a></li>
		</ul>
	</div>

	<div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>添加回复规则</h3>
		</div>
		<div class="modal-body">
	    	<div class='modal-group'>
	    		<label class='title-label'>功能名称</label>
	    		<div class='content-label'>
					<input type='text' placeholder='请输入功能名称'>
	    		</div>
	    	</div>
	    	<div class='modal-group'>
	    		<label class='title-label'>回复类型</label>
	    		<div class='content-label'>
	    			<select class='sp-select'>
						<option value='0'>文本</option>
						<option value='1'>单图文</option>
						<option value='2'>多图文</option>
	    			</select>
	    		</div>
	    	</div>	    	
		</div>
		<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		<button class="btn btn-success" id="addRule">添加</button>
		</div>
	</div>
</div>
<div id="rule-right">
	<div class='reply-detail'>
		<div id='auto-reply' style="display:none">
			<label class='title-change resize'>规则名称：关注后自动回复（用户关注该公告账号后，收到的第一条回复）</label>
			<div class='modal-group'>
				<label class='title-label resize'>回复类型：</label>
				<div class='content-label'>
					<select class='sp-select'>
						<option value='0'>文本</option>
						<option value='1'>单图文</option>
						<option value='2'>多图文</option>
					</select>
				</div>
			</div>
		</div>
		<div id='default-reply' style="display:none">
			<label class='title-change resize'>规则名称：无匹配默认回复（用户输入的关键字没有匹配项时，系统返回的默认回复）</label>
			<div class='modal-group'>
				<label class='title-label resize'>回复类型：</label>
				<div class='content-label'>
					<select class='sp-select'>
						<option value='0'>文本</option>
						<option value='1'>单图文</option>
						<option value='2'>多图文</option>
					</select>
				</div>
			</div>
		</div>
		<div id='customize-reply' style="display:none">
			<label class='title-change resize'>规则名称：</label>
			<input type='text' class='title-change' placeholder='输入规则名称...'>
			<label class='title-change resize'>关键词：（以‘英文,’分隔）</label>
			<input type='text' class='title-change' placeholder='输入关键词...'>
			<div class='modal-group'>
				<label class='title-label resize'>匹配规则：</label>
				<div class='content-label'>
					<select class='sp-select'>
						<option value='0'>全匹配</option>
						<option value='1'>半匹配</option>
					</select>
				</div>
			</div>
			<div class='modal-group'>
				<label class='title-label resize'>回复类型：</label>
				<div class='content-label'>
					<select class='sp-select'>
						<option value='0'>文本</option>
						<option value='1'>单图文</option>
						<option value='2'>多图文</option>
					</select>
				</div>
			</div>
		</div>
		<label class='title-change resize'>回复内容：</label>
		<!--文本-->
		<div class='reply-content' style="display:none" id='text'>
			<textarea placeholder='请输入文本' style="width:90%;height:150px;overflow-y:auto;"></textarea>
		</div>
		<!--单图文-->
		<div class='reply-content' style="display:none" id='image-text'>
			<label>标题</label>
			<input type='text' placeholder='输入标题...'>
			<label>封面图片（建议360*200）</label>
			<img width='360' height='auto' src="<?php echo Yii::app()->baseUrl."/img/replyCover.png";?>">
	    	<div class="cover-desc">
				<span>上传图片</span>
				<input type='file' id='coverimgupload' name='coverImg'>
	    	</div>
	    	<label style="margin-top:5px;">内容简介</label>
			<input type='text' placeholder='输入内容简介...'>
	    	<label><input type='radio' name='link' value='outer-link'>外部链接</label>
	    	<input type='text' placeholder='输入外链url...'>
	    	<label><input type='radio' name='link' value='inner-link'>素材和功能</label>
	    	<select class="sp-select">
	    		<option value='在线订单'>在线订单</option>
	    		<option value='个人中心'>个人中心</option>
	    		<option value='首页推荐'>首页推荐</option>
	    		<option value='联系我们'>联系我们</option>
	    	</select>
	    	<select class="sp-select">
	    		<option value="0">全部</option>
    		<?php foreach($storeList as $store):?>
    		<?php if($store->deleted== 0):?>
    			<option value="<?php echo $store->id;?>"><?php echo $store->name;?></option>
    		<?php endif;?>
    		<?php endforeach;?>
    	</select>
		</div>
		<!--多图文-->
		<div class='reply-content' style="display:none" id='image-texts'>
			<div class="image-text">
				<label class='resize'>封面图文</label>
				<label>标题</label>
				<input type='text' placeholder='输入标题...'>
				<label>封面图片（建议360*200）</label>
				<img width="360" height="auto" src="<?php echo Yii::app()->baseUrl."/img/replyCover.png";?>">
		    	<div class="cover-desc">
					<span>上传图片</span>
					<input type='file' name='typeImg'>
		    	</div>
		    	<label><input type='radio' name='link0' value='outer-link'>外部链接</label>
		    	<input type='text' placeholder='输入外链url...'>
		    	<label><input type='radio' name='link0' value='inner-link'>功能</label>
		    	<select class="sp-select">
		    		<option value='在线订单'>在线订单</option>
		    		<option value='个人中心'>个人中心</option>
		    		<option value='首页推荐'>首页推荐</option>
		    		<option value='联系我们'>联系我们</option>
		    	</select>
		    	<select class="sp-select">
		    			<option value="0">全部</option>
		    		<?php foreach($storeList as $store):?>
		    		<?php if($store->deleted== 0):?>
		    			<option value="<?php echo $store->id;?>"><?php echo $store->name;?></option>
		    		<?php endif;?>
		    		<?php endforeach;?>
		    	</select>
			</div>
			<div class="image-text">
				<a class='del-item'>删除</a>
				<label class='resize'>普通图文 1</label>
				<label>标题</label>
				<input type='text' placeholder='输入标题...'>
				<label>缩略图片（建议200*200）</label>
				<img src='/weChat/img/thumbnail.png'>
		    	<div class="cover-desc">
					<span>上传图片</span>
					<input type='file' id='coverimgupload' name='typeImg'>
		    	</div>
		    	<label><input type='radio' name='link1' value='outer-link'>外部链接</label>
		    	<input type='text' placeholder='输入外链url...'>
		    	<label><input type='radio' name='link1' value='inner-link'>功能</label>
		    	<select class="sp-select">
		    		<option value='在线订单'>在线订单</option>
		    		<option value='个人中心'>个人中心</option>
		    		<option value='首页推荐'>首页推荐</option>
		    		<option value='联系我们'>联系我们</option>
		    	</select>
		    	<select class="sp-select">
		    			<option value="0">全部</option>
		    		<?php foreach($storeList as $store):?>
		    		<?php if($store->deleted== 0):?>
		    			<option value="<?php echo $store->id;?>"><?php echo $store->name;?></option>
		    		<?php endif;?>
		    		<?php endforeach;?>
		    	</select>	    	
			</div>
			<div id='subitems'>
			</div>
 			<div class="imagetext-add">
				<a href="javascript:void(0);" id='addImageText'>添加图文</a>
			</div>	
		</div>
				
	</div>

	<div class='batch-menu'>
		<ul>
			<li><a href="javascript:;" id='saveRule'>保存</a></li>
			<li><a href="javascript:;" id='cancelChange'>取消修改</a></li>			
			<li><a href="javascript:;" id='delRule'>删除</a></li>
		</ul>
	</div>	
</div>


<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.form.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.json-2.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(event){
	var current_sdmsgs_id = 0;//当前sdmsg的id
	var customize_li = null;//当前自定义规则在dom里的li对象
	var current_json = null;//存储多图文内容
	var current_text = null;//存储文本内容
	var current_imageText = null;//存储单图文内容
	var current_type = "单图文";//存储当前回复类型，其实无须全局存储，但也无伤大雅
	var current_rule = 'default';//存储当前规则是自定义还是默认
	var is_focus = false;//当前是否在规则编辑区域
	var current_store = <?php echo CJSON::encode($storeList);?>;
	var id_deleted = new Array();
	var id_name = new Array();
	var select_store = "<option value='0'>全部</option>";
	for(var j=0;j<current_store.length;j++){
		id_deleted[current_store[j].id]= current_store[j].deleted;
		id_name[current_store[j].id]= current_store[j].name;

		if(current_store[j].deleted == 0)
			select_store = select_store + "<option value='"+current_store[j].id+"'>"+current_store[j].name+"</option>";
	}

	//全选
	$("#checkAll").click(function(){
		if($("#checkAll").attr("checked")=='checked')
			$("[name = chkItem]:checkbox").attr("checked", true);
		else
			$("[name = chkItem]:checkbox").attr("checked", false);

	});

	$("#batch-option").click(function(){
		var size = $("#custom-list input:checkbox").length;
		var count = 0;
		for(var i=0;i<size;i++){
			if($("#custom-list input:checkbox").eq(i).attr("checked")){
				count++;
			}
		}
		if(count==0)
			alert("请选中某一商品");
		else
			$("#popup").toggle();
	})

	$("#batch-option").blur(function(){
		alert("ss");
		$("#popup").toggle();
	})

	$("#popup li a").click(function(){
		if(confirm("删除规则不可恢复，按确定规则即被删除")){
			var idList = [];
			var size = $("#custom-list input:checkbox").length;
			var count = 0;
			for(var i=0;i<size;i++){
				if($("#custom-list input:checkbox").eq(i).attr("checked")){
					idList[count] = $("#custom-list input:checkbox").eq(i).val();
					count++;
				}
			}
			if(count==0)
				alert("请选中某一商品");
			$.ajax({
	            type: 'POST',
	            url: "<?php echo CHtml::normalizeUrl(array('replyRules/batchDelRule'));?>",
	            data: {'idList':idList},
	            dataType: 'json',
	            success:function(json){
					window.location.href = "<?php echo Yii::app()->createUrl('accounts/replyRules/allRules');?>";
	            },
	            error:function(){
	            	alert('删除规则失败！');
	            },				
			})
		}
	})


	//保存自定义多图文
	function saveCustomImageTexts(ruleName,keyword,match_rule){
		var ruleName = $("#customize-reply input").eq(0).val();
		var keyword = $("#customize-reply input").eq(1).val();
		var match_rule = $("#customize-reply select").eq(0).val();
		if(ruleName == ""){
			alert("规则名称不能为空！");
		}
		for(var i =0;i<current_json.length;i++){
			current_json[i].title = $("#image-texts input:text").eq(2*i).val();
			var func_val = $("input:radio[name='link"+i+"']:checked").val();

			if(func_val == 'outer-link'){
				current_json[i].resource = '外部链接';
				current_json[i].url = $("#image-texts input:text").eq(2*i+1).val();
			}
			else{
				current_json[i].resource = $("#image-texts select").eq(2*i).val();
				current_json[i].store_id = $("#image-texts select").eq(2*i+1).val();
				}
		}
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/saveImageTexts'));?>",
            data: {'current_rule':'customize','sdmsgId':current_sdmsgs_id,'ruleName':ruleName,'match_rule':match_rule,'keyword':keyword,'current_json':$.toJSON(current_json)},
            dataType: 'json',
             
            success:function(json){
            	customize_li.find("h5").text(ruleName);
            	customize_li.find("label").eq(1).text("回复类型："+current_type);
            	current_json = json;
            	alert('保存成功！');
            },
            error:function(){
            	alert('保存多图文失败！');
            },				
		})			
	}

	//保存自定义单图文
	function saveCustomImageText(ruleName,keyword,match_rule){
		var ruleName = $("#customize-reply input").eq(0).val();
		var keyword = $("#customize-reply input").eq(1).val();
		var match_rule = $("#customize-reply select").eq(0).val();
		var title = $("#image-text input:text").eq(0).val();
		var content = $("#image-text input:text").eq(1).val();
		var func_val = $("input:radio[name='link']:checked").val();
		var resource = "";
		var url = "";
		var store_id = 0;
		if(func_val == 'outer-link'){
			resource = '外部链接';
			url = $("#image-text input:text").eq(2).val();
		}
		else{
			resource = $("#image-text select").eq(0).val();
			store_id = $("#image-text select").eq(1).val();
		}
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/saveImageText'));?>",
            data: {'current_rule':'customize','sdmsgId':current_sdmsgs_id,'ruleName':ruleName,'match_rule':match_rule,'keyword':keyword,
        			'resource':resource,'url':url,'store_id':store_id,'title':title,'content':content},
            dataType: 'json',
             
            success:function(json){
            	customize_li.find("h5").text(ruleName);
            	customize_li.find("label").eq(1).text("回复类型："+current_type);
            	current_imageText = json;
            	alert('保存成功！');
            },
            error:function(){
            	alert('保存单图文失败！');
            },				
		})
	}
	//保存自定义文本
	function saveCustomText(ruleName,keyword,match_rule){
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/saveText'));?>",
            data: {'current_rule':'customize','sdmsgId':current_sdmsgs_id,'ruleName':ruleName,'match_rule':match_rule,'keyword':keyword,'content':content},
            dataType: 'json',
             
            success:function(json){
            	customize_li.find("h5").text(ruleName);
            	customize_li.find("label").eq(1).text("回复类型："+current_type);
            	current_text = json;
            	alert('保存成功！');
            },
            error:function(){
            	alert('保存单图文失败！');
            },				
		})
	}
	//保存默认和自动回复的多图文
	function saveDefaultImageTexts(){
		for(var i =0;i<current_json.length;i++){
			current_json[i].title = $("#image-texts input:text").eq(2*i).val();
			var func_val = $("input:radio[name='link"+i+"']:checked").val();

			if(func_val == 'outer-link'){
				current_json[i].resource = '外部链接';
				current_json[i].url = $("#image-texts input:text").eq(2*i+1).val();
			}
			else{
				current_json[i].resource = $("#image-texts select").eq(2*i).val();
				current_json[i].store_id = $("#image-texts select").eq(2*i+1).val();
				}
		}
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/saveImageTexts'));?>",
            data: {'current_rule':'default','sdmsgId':current_sdmsgs_id,'current_json':current_json},
            dataType: 'json',
             
            success:function(json){
            	if(current_rule=='auto'){
            		$("#rule-list").eq(0).find("h5").text(ruleName);
            		$("#rule-list").eq(0).find("label").eq(1).text("回复类型："+current_type);
            	}else{
            		$("#rule-list").eq(1).find("h5").text(ruleName);
            		$("#rule-list").eq(1).find("label").eq(1).text("回复类型："+current_type);
            	}
            	
            	current_json = json;
            	alert('保存成功！');
            },
            error:function(){
            	alert('保存多图文失败！');
            },				
		})
	}

	function saveDefaultImageText(){
		var title = $("#image-text input:text").eq(0).val();
		var content = $("#image-text input:text").eq(1).val();
		var func_val = $("input:radio[name='link']:checked").val();
		var resource = "";
		var url = "";
		var store_id = 0;
		if(func_val == 'outer-link'){
			resource = '外部链接';
			url = $("#image-text input:text").eq(2).val();
		}
		else{
			resource = $("#image-text select").eq(0).val();
			store_id = $("#image-text select").eq(1).val();
			}
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/saveImageText'));?>",
            data: {'current_rule':'default','sdmsgId':current_sdmsgs_id,'resource':resource,'url':url,'store_id':store_id,'title':title,'content':content},
            dataType: 'json',
             
            success:function(json){
            	if(current_rule=='auto'){
            		$("#rule-list").eq(0).find("label").eq(1).text("回复类型："+current_type);
            	}else{
            		$("#rule-list").eq(1).find("label").eq(1).text("回复类型："+current_type);
            	}
            	current_imageText = json;
            	alert('保存成功！');
            },
            error:function(){
            	alert('保存单图文失败！');
            },				
		})
	}

	function saveDefaultText(){
		var content = $("#text textarea").val();
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/saveText'));?>",
            data: {'current_rule':'customize','sdmsgId':current_sdmsgs_id,'content':content},
            dataType: 'json',
             
            success:function(json){
            	if(current_rule=='auto'){
            		$("#rule-list").eq(0).find("h5").text(ruleName);
            		$("#rule-list").eq(0).find("label").eq(1).text("回复类型："+current_type);
            	}else{
            		$("#rule-list").eq(1).find("h5").text(ruleName);
            		$("#rule-list").eq(1).find("label").eq(1).text("回复类型："+current_type);
            	}
            	current_text = json;
            	alert('保存成功！');
            },
            error:function(){
            	alert('保存单图文失败！');
            },				
		})
	}

	//监测全局click事件
	document.addEventListener('click',function(event){
		if(is_focus){
			var target = event.target;
			var isin = false;
			while(!$(target).is('body')){
				if($(target).is("#rule-right")){
					isin = true;
				}
				target = $(target).parent();
			}
			if(!isin){
				is_focus = false;
				var is_change = false;
				if(current_rule == 'customize'){
					var now_ruleName = $("#customize-reply input").eq(0).val();
					var keyword = $("#customize-reply input").eq(1).val();
					var match_rule = $("#customize-reply select").eq(0).val();
					var prev_ruleName = customize_li.find("h5").text();
					var prev_type = customize_li.find("label").text();
					if(prev_ruleName!=now_ruleName || prev_type!="回复类型："+current_type )
						is_change = true;
					if(current_type == '文本'){
						if(current_text[0].content != $("#text textarea").val() || keyword!=current_text[0].keyword
							|| match_rule!=current_text[0].match_rule)
							is_change = true;
						if(is_change) {
							if( confirm("您对该规则做了修改，按确定保存对规则的修改，按取消则停留在该页面") ){
								saveCustomText(now_ruleName,keyword,match_rule);
							}else{
								is_focus = true;
								event.stopPropagation();
								event.preventDefault();
							}
						}
					}else if(current_type == '单图文'){
						if(current_imageText[0].title!= $("#image-text input:text").eq(0).val() 
							|| current_imageText[0].content!= $("#image-text input:text").eq(1).val() 
							|| keyword!=current_imageText[0].keyword || match_rule!=current_imageText[0].match_rule)
							is_change = true;
						var func_val = $("input:radio[name='link']:checked").val();
						if(func_val == 'outer-link'){
							if(current_imageText[0].url!= $("#image-text input:text").eq(2).val())
								is_change = true;
						}
						else{
							if(current_imageText[0].resource != $("#image-text select").eq(0).val()
								|| current_imageText[0].store_id != $("#image-text select").eq(1).val())
								is_change = true;
	 					}
	 					if(is_change) {
							if( confirm("您对该规则做了修改，按确定保存对规则的修改，按取消则停留在该页面") ){
								saveCustomImageText(now_ruleName,keyword,match_rule);
							}else{
								is_focus = true;
								event.stopPropagation();
								event.preventDefault();
							}
						}

					}else{
						if(keyword!=current_json[0].keyword || match_rule!=current_json[0].match_rule)
							is_change = true;
						for(var i =0;i<current_json.length;i++){
							if(current_json[i].title != $("#image-texts input:text").eq(2*i).val() )
								is_change = true;
							var func_val = $("input:radio[name='link"+i+"']:checked").val();
							if(func_val == 'outer-link'){
								if(current_json[i].url!=$("#image-texts input:text").eq(2*i+1).val())
									is_change = true;
							}
							else{
								if(current_json[i].resource != $("#image-texts select").eq(2*i).val()
									|| current_json[i].store_id != $("#image-texts select").eq(2*i+1).val())
									is_change = true;								
							}
						}
						if(is_change){
							if( confirm("您对该规则做了修改，按确定保存对规则的修改，按取消则停留在该页面") ){
								saveCustomImageTexts(now_ruleName,keyword,match_rule);
							}else{
								is_focus = true;
								event.stopPropagation();
								event.preventDefault();
							}
						}	
					}
				}else{
					if(current_type == '文本'){
						if(current_text[0].content != $("#text textarea").val())
							is_change = true;
						if(is_change) {
							if( confirm("您对该规则做了修改，按确定保存对规则的修改，按取消则停留在该页面") ){
								saveDefaultText();
							}else{
								is_focus = true;
								event.stopPropagation();
								event.preventDefault();
							}
						}
					}else if(current_type == '单图文'){
						if(current_imageText[0].title!= $("#image-text input:text").eq(0).val() 
							|| current_imageText[0].content!= $("#image-text input:text").eq(1).val())
							is_change = true;
						var func_val = $("input:radio[name='link']:checked").val();
						if(func_val == 'outer-link'){
							if(current_imageText[0].url!= $("#image-text input:text").eq(2).val())
								is_change = true;
						}
						else{
							if(current_imageText[0].resource != $("#image-text select").eq(0).val()
								|| current_imageText[0].store_id != $("#image-text select").eq(1).val())
								is_change = true;
	 					}
	 					if(is_change) {
							if( confirm("您对该规则做了修改，按确定保存对规则的修改，按取消则停留在该页面") ){
								saveDefaultImageText();
							}else{
								is_focus = true;
								event.stopPropagation();
								event.preventDefault();
							}
						}

					}else{
						for(var i =0;i<current_json.length;i++){
							if(current_json[i].title != $("#image-texts input:text").eq(2*i).val() )
								is_change = true;
							var func_val = $("input:radio[name='link"+i+"']:checked").val();
							if(func_val == 'outer-link'){
								if(current_json[i].url!=$("#image-texts input:text").eq(2*i+1).val())
									is_change = true;
							}
							else{
								if(current_json[i].resource != $("#image-texts select").eq(2*i).val()
									|| current_json[i].store_id != $("#image-texts select").eq(2*i+1).val())
									is_change = true;								
							}
						}
						if(is_change){
							if( confirm("您对该规则做了修改，按确定保存对规则的修改，按取消则停留在该页面") ){
								saveDefaultImageTexts();
							}else{
								is_focus = true;
								event.stopPropagation();
								event.preventDefault();
							}
						}	
					}
				}
			}
		}
	},true)

	$("#addRule").click(function(){
		var title = $("#addModal input").eq(0).val();
		var type = $("#addModal select").find('option:selected').text();
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/addRule'));?>",
            data: {'title':title,'type':type},
            dataType: 'json',
            success:function(json){
				var li = "<li><div class='reply-checkbox'><input type='checkbox' value='"+json.id+"'></div><div class='left'><h5>"+ title +"</h5><label>回复类型："+type+"</label></div></li>";
				$("#custom-list").append(li);
				$("#addModal").modal('hide');

            },
            error:function(){
            	alert('创建规则失败！');
            },				
		})

	});

	$("#delRule").click(function(){
		if(confirm("删除规则不可恢复，按确定规则即被删除")){
			$.ajax({
	            type: 'POST',
	            url: "<?php echo CHtml::normalizeUrl(array('replyRules/delRule'));?>",
	            data: {'sdmsgId':current_sdmsgs_id},
	            dataType: 'json',
	            success:function(json){
					window.location.href = "<?php echo Yii::app()->createUrl('accounts/replyRules/allRules');?>";
	            },
	            error:function(){
	            	alert('删除规则失败！');
	            },				
			})
		}	
	})

	$("#auto-reply select").eq(0).change(function(){
		var old_type = current_type;
		current_type = $("#auto-reply select").find('option:selected').text();
		if(confirm("离开则"+old_type+"内容会消失")){
			if(current_type == '文本'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToText'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                success:function(json){
						$("#text textarea").val("");
						$("#text").show();
						$("#image-text").hide();
						$("#image-texts").hide();
	                },
	                error:function(){
	                	alert('创建文本失败！');
	                },				
				})	
			}else if(current_type == '单图文'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToImageText'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                success:function(json){
						$("#image-text input:text").eq(0).val("");
						$("#image-text input:text").eq(1).val("");
						$("#image-text input:text").eq(2).val("");

						$("#image-text img").attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/replyCover.png");
						$("#image-text").show();
						$("#text").hide();
						$("#image-texts").hide();
	                },
	                error:function(){
	                	alert('创建单图文失败！');
	                },				
				})
			}else if(current_type == '多图文'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToImageTexts'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                 
	                success:function(json){
	                	current_json = json;
	                	$("#subitems").html("");
						$("#image-texts input:text").eq(0).val("");
						$("#image-texts input:text").eq(1).val("");
						$("#image-texts input:text").eq(2).val("");
						$("#image-texts input:text").eq(3).val("");
						$("#image-texts input:file").eq(0).attr("id","coverimgupload0_"+json[0].id);
						$("#image-texts input:file").eq(1).attr("id","coverimgupload1_"+json[1].id);							
						$("#image-texts img").eq(0).attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/replyCover.png");
						$("#image-texts img").eq(1).attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/thumbnail.png");		                	
		                $("#image-texts").show();
						$("#text").hide();
						$("#image-text").hide();
	                },
	                error:function(){
	                	alert('创建多图文失败！');
	                },				
				})		
			}
		}else{
			$("#auto-reply select").val(old_type);
		}
	})

	$("#default-reply select").eq(0).change(function(){
		var old_type = current_type;
		current_type = $("#default-reply select").find('option:selected').text();
		if(confirm("离开则"+old_type+"内容会消失")){
			if(current_type == '文本'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToText'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                success:function(json){
						$("#text textarea").val("");
						$("#text").show();
						$("#image-text").hide();
						$("#image-texts").hide();
	                },
	                error:function(){
	                	alert('创建文本失败！');
	                },				
				})
			}else if(current_type == '单图文'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToImageText'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                success:function(json){
						$("#image-text input:text").eq(0).val("");
						$("#image-text input:text").eq(1).val("");
						$("#image-text input:text").eq(2).val("");

						$("#image-text img").attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/replyCover.png");
						$("#image-text").show();
						$("#text").hide();
						$("#image-texts").hide();
	                },
	                error:function(){
	                	alert('创建单图文失败！');
	                },				
				})
			}else if(current_type == '多图文'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToImageTexts'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                 
	                success:function(json){
	                	current_json = json;
	                	$("#subitems").html("");
						$("#image-texts input:text").eq(0).val("");
						$("#image-texts input:text").eq(1).val("");
						$("#image-texts input:text").eq(2).val("");
						$("#image-texts input:text").eq(3).val("");
						$("#image-texts input:file").eq(0).attr("id","coverimgupload0_"+json[0].id);
						$("#image-texts input:file").eq(1).attr("id","coverimgupload1_"+json[1].id);							
						$("#image-texts img").eq(0).attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/replyCover.png");
						$("#image-texts img").eq(1).attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/thumbnail.png");		                	
		                $("#image-texts").show();
						$("#text").hide();
						$("#image-text").hide();
	                },
	                error:function(){
	                	alert('创建多图文失败！');
	                },				
				})
			}
		}else{
			$("#default-reply select").val(old_type);				
		}
	})

	$("#customize-reply select").eq(1).change(function(){
		var old_type = current_type;
		current_type = $("#customize-reply select").eq(1).find('option:selected').text();
		if(confirm("离开则"+old_type+"内容会消失")){
			if(current_type == '文本'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToText'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                success:function(json){
						$("#text textarea").val("");
						$("#text").show();
						$("#image-text").hide();
						$("#image-texts").hide();
	                },
	                error:function(){
	                	alert('创建文本失败！');
	                },				
				})
			}else if(current_type == '单图文'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToImageText'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                success:function(json){
						$("#image-text input:text").eq(0).val("");
						$("#image-text input:text").eq(1).val("");
						$("#image-text input:text").eq(2).val("");

						$("#image-text img").attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/replyCover.png");
						$("#image-text").show();
						$("#text").hide();
						$("#image-texts").hide();
	                },
	                error:function(){
	                	alert('创建单图文失败！');
	                },				
				})
			}else if(current_type == '多图文'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('replyRules/changeToImageTexts'));?>",
	                data: {'sdmsgId':current_sdmsgs_id},
	                dataType: 'json',
	                 
	                success:function(json){
	                	current_json = json;
	                	$("#subitems").html("");
						$("#image-texts input:text").eq(0).val("");
						$("#image-texts input:text").eq(1).val("");
						$("#image-texts input:text").eq(2).val("");
						$("#image-texts input:text").eq(3).val("");
						$("#image-texts input:file").eq(0).attr("id","coverimgupload0_"+json[0].id);
						$("#image-texts input:file").eq(1).attr("id","coverimgupload1_"+json[1].id);							
						$("#image-texts img").eq(0).attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/replyCover.png");
						$("#image-texts img").eq(1).attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/img/thumbnail.png");		                	
		                $("#image-texts").show();
						$("#text").hide();
						$("#image-text").hide();
	                },
	                error:function(){
	                	alert('创建多图文失败！');
	                },				
				})
			}
		}else{
			$("#customize-reply select").val(old_type);				
		}
	})

	$("#rule-list li").eq(0).click(function(){
		customize_li = $(this);
		is_focus = true;
		current_rule = 'auto';
		var autoId = $("#rule-list li").eq(0).attr("id");
		var typeName = $("#rule-list li label").eq(0).text();
		current_sdmsgs_id = autoId;
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/getDefaultRule'));?>",
            data: {'sdmsg_id':autoId},
            dataType: 'json',
            
            success:function(json){
            	$("#delRule").hide();
            	if(typeName == "回复类型：文本"){
            		current_text = json;
            		current_type = "文本";
            		$("#auto-reply select").val(0);
					$("#auto-reply").show();
					$("#default-reply").hide();
					$("#customize-reply").hide();
					$("#text textarea").val(json[0].content);
					$("#text").show();
					$("#image-text").hide();
					$("#image-texts").hide();
            	}else if(typeName == "回复类型：单图文"){
            		current_imageText = json;
            		current_type = "单图文";
            		$("#auto-reply select").val(1);
					$("#auto-reply").show();
					$("#default-reply").hide();
					$("#customize-reply").hide();
					$("#image-text input").eq(0).val(json[0].title);
					$("#image-text input").eq(2).val(json[0].content);
					$("#image-text img").attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/"+json[0].picurl);
					if(json[0].resource=='外部链接'){
						$("#image-text select").eq(1).html(select_store);
						$("#image-text input:radio[name='link'][value='outer-link']").attr('checked',"true");
						$("#image-text input").eq(4).val(json[0].url);
					}
					else{
						if(id_deleted[json[0].store_id]==1)
							var item_store = select_store+"<option value="+json[0].store_id+">"+id_name[json[0].store_id]+"(该店铺已被删除，请不要选择)</option>";
						$("#image-text select").eq(1).html(item_store);
						$("#image-text input:radio[name='link'][value='inner-link']").attr('checked',"true");
						$("#image-text select").eq(0).val(json[0].resource);
						$("#image-text select").eq(1).val(json[0].store_id);
					}

					$("#image-text").show();
					$("#text").hide();
					$("#image-texts").hide();

            	}else{
            		current_json = json; 
            		current_type = "多图文";        
            		$("#auto-reply select").val(2);
					$("#auto-reply").show();
					$("#default-reply").hide();
					$("#customize-reply").hide();

					for(var i=0;i<json.length;i++){
						$("#image-texts input:text").eq(2*i).val(json[i].title);
						$("#image-texts input:file").eq(i).attr("id","coverimgupload"+i+"_"+json[i].id);
						if(json[i].resource=='外部链接'){
							$("#image-texts select").eq(2*i+1).html(select_store);
							$("#image-texts input:radio[name='link"+i+"'][value='outer-link']").attr('checked',"true");
							$("#image-texts input:text").eq(2*i+1).val(json[i].url);
						}
						else{
							if(id_deleted[json[i].store_id]==1)
								var item_store = select_store+"<option value="+json[i].store_id+">"+id_name[json[i].store_id]+"(该店铺已被删除，请不要选择)</option>";
							$("#image-text select").eq(2*i+1).html(item_store);
							$("#image-texts input:radio[name='link"+i+"'][value='inner-link']").attr('checked',"true");
							$("#image-texts select").eq(2*i).val(json[i].resource);
							$("#image-texts select").eq(2*i+1).val(json[i].store_id);
						}
					}
					
					if(json.length>2){
						var item = "";
						for(var i=2;i<json.length;i++){
							item =item + "<div class='image-text' id='"+json[i].id+"'><a class='del-item'>删除</a><label class='resize'>普通图文 "+i+"</label><label>标题</label><input type='text' placeholder='输入标题...' value='"
							+json[i].title+"'><label>缩略图片（建议200*200）</label><img width='80' height='auto' src='<?php echo Yii::app()->baseUrl;?>"+"/"+json[i].picurl+"'><div class='cover-desc'><span>上传图片</span><input type='file' id='coverimgupload"+i+"_"+json[i].id+"' name='typeImg'></div>";
							if(json[i].resource=='外部链接'){
								var item_store = select_store+"</select></div>";
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link' checked>外部链接</label><input type='text' placeholder='输入外链url...' value='"
								+json[i].url+"'><label><input type='radio' name='link"+i+"' value='inner-link'>功能</label><select class='sp-select'><option value='在线订单'>在线订单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select><select class='sp-select' value='"
								+json[i].store_id+"'>"+item_store;
								item = item + itemThen;
							}else{
								var item_store = "";
								if(id_deleted[json[i].store_id]==1)
									item_store = select_store+"<option value='"+json[i].store_id+"'>"+id_name[json[i].store_id]+"(该店铺已被删除，请不要选择)</option></select></div>";
								else
									item_store = select_store+"</select></div>";
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link'>外部链接</label><input type='text' placeholder='输入外链url...'><label><input type='radio' name='link"+i+"' value='inner-link' checked>功能</label><select class='sp-select' value='"
								+json[i].resource+"'><option value='在线订单'>在线订单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select><select class='sp-select' value='"+json[i].store_id+"'>"+item_store;
								item = item + itemThen;
							}
						}
						$("#subitems").html(item);
						for(var i=2;i<json.length;i++){
							if(json[i].resource!='外部链接'){
								$("#image-texts select").eq(2*i).val(json[i].resource);
								$("#image-texts select").eq(2*i+1).val(json[i].store_id);																
							}
						}
					}						
					$("#image-texts").show();
					$("#text").hide();
					$("#image-text").hide();
            	}
            },
            error:function(){
            	alert('没有找到对应的规则！');
            },				
		})
	})

	$("#rule-list li").eq(1).click(function(){
		customize_li = $(this);
		is_focus = true;
		current_rule = 'default';
		var defaultId = $(this).attr("id");
		var typeName = $("#rule-list li label").eq(1).text();
		current_sdmsgs_id = defaultId;
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/getDefaultRule'));?>",
            data: {'sdmsg_id':defaultId},
            dataType: 'json',
            
            success:function(json){
        	    $("#delRule").hide();
            	if(typeName == "回复类型：文本"){
            		current_text = json;
            		current_type = "文本";                		
            		$("#default-reply select").val(0);
					$("#default-reply").show();
					$("#auto-reply").hide();
					$("#customize-reply").hide();
					$("#text textarea").val(json[0].content);
					$("#text").show();
					$("#image-text").hide();
					$("#image-texts").hide();
            	}else if(typeName == "回复类型：单图文"){
            		current_imageText = json;
            		current_type = "单图文";                		
            		$("#default-reply select").val(1);
					$("#default-reply").show();
					$("#auto-reply").hide();
					$("#customize-reply").hide();
					$("#image-text input").eq(0).val(json[0].title);
					$("#image-text input").eq(2).val(json[0].content);
					$("#image-text img").attr('src',"<?php echo Yii::app()->baseUrl;?>"+"/"+json[0].picurl);						
					if(json[0].resource=='外部链接'){
						$("#image-text select").eq(1).html(select_store);
						$("#image-text input:radio[name='link'][value='outer-link']").attr('checked',"true");
						$("#image-text input").eq(4).val(json[0].url);
					}
					else{
						if(id_deleted[json[0].store_id]==1)
							var item_store = select_store+"<option value="+json[0].store_id+">"+id_name[json[0].store_id]+"(该店铺已被删除，请不要选择)</option>";
						$("#image-text select").eq(1).html(item_store);
						$("#image-text input:radio[name='link'][value='inner-link']").attr('checked',"true");
						$("#image-text select").eq(0).val(json[0].resource);
						$("#image-text select").eq(1).val(json[0].store_id);
					}

					$("#image-text").show();
					$("#text").hide();
					$("#image-texts").hide();
            	}else{
            		current_json = json; 
            		current_type = "多图文";        
            		$("#default-reply select").val(2);
					$("#default-reply").show();
					$("#auto-reply").hide();
					$("#customize-reply").hide();

					for(var i=0;i<json.length;i++){
						$("#image-texts input:text").eq(2*i).val(json[i].title);
						$("#image-texts input:file").eq(i).attr("id","coverimgupload"+i+"_"+json[i].id);
						if(json[i].resource=='外部链接'){
							$("#image-texts select").eq(2*i+1).html(select_store);
							$("#image-texts input:radio[name='link"+i+"'][value='outer-link']").attr('checked',"true");
							$("#image-texts input:text").eq(2*i+1).val(json[i].url);
						}
						else{
							if(id_deleted[json[i].store_id]==1)
								var item_store = select_store+"<option value="+json[i].store_id+">"+id_name[json[i].store_id]+"(该店铺已被删除，请不要选择)</option>";
							$("#image-text select").eq(2*i+1).html(item_store);
							$("#image-texts input:radio[name='link"+i+"'][value='inner-link']").attr('checked',"true");
							$("#image-texts select").eq(2*i).val(json[i].resource);
							$("#image-texts select").eq(2*i+1).val(json[i].store_id);
						}
					}
					
					if(json.length>2){
						var item = "";
						for(var i=2;i<json.length;i++){
							item =item + "<div class='image-text' id='"+json[i].id+"'><a class='del-item'>删除</a><label class='resize'>普通图文 "+i+"</label><label>标题</label><input type='text' placeholder='输入标题...' value='"
							+json[i].title+"'><label>缩略图片（建议200*200）</label><img width='80' height='auto' src='<?php echo Yii::app()->baseUrl;?>"+"/"+json[i].picurl+"'><div class='cover-desc'><span>上传图片</span><input type='file' id='coverimgupload"+i+"_"+json[i].id+"' name='typeImg'></div>";
							if(json[i].resource=='外部链接'){
								var item_store = select_store+"</select></div>";
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link' checked>外部链接</label><input type='text' placeholder='输入外链url...' value='"
								+json[i].url+"'><label><input type='radio' name='link"+i+"' value='inner-link'>功能</label><select class='sp-select'><option value='在线订单'>在线订单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select><select class='sp-select' value='"
								+json[i].store_id+"'>"+item_store;
								item = item + itemThen;
							}else{
								var item_store = "";
								if(id_deleted[json[i].store_id]==1)
									item_store = select_store+"<option value='"+json[i].store_id+"'>"+id_name[json[i].store_id]+"(该店铺已被删除，请不要选择)</option></select></div>";
								else
									item_store = select_store+"</select></div>";
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link'>外部链接</label><input type='text' placeholder='输入外链url...'><label><input type='radio' name='link"+i+"' value='inner-link' checked>功能</label><select class='sp-select' value='"
								+json[i].resource+"'><option value='在线订单'>在线订单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select><select class='sp-select' value='"+json[i].store_id+"'>"+item_store;
								item = item + itemThen;
							}
						}
						$("#subitems").html(item);
						for(var i=2;i<json.length;i++){
							if(json[i].resource!='外部链接'){
								$("#image-texts select").eq(2*i).val(json[i].resource);
								$("#image-texts select").eq(2*i+1).val(json[i].store_id);																
							}
						}
					}						
					$("#image-texts").show();
					$("#text").hide();
					$("#image-text").hide();

            	}
            },
            error:function(){
            	alert('没有找到对应的规则！');
            },				
		})
	})

	$("#custom-list li").live('click',function(){
		customize_li = $(this);
		is_focus = true;
		current_rule = 'customize';
		var sdmsgId = $(this).find('input:checkbox').val();
		var typeName = $(this).find("label").text();
		var ruleName = $(this).find("h5").text();
		current_sdmsgs_id = sdmsgId;
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/getDefaultRule'));?>",
            data: {'sdmsg_id':sdmsgId},
            dataType: 'json',
            
            success:function(json){
            	$("#customize-reply input").eq(0).val(ruleName);
            	$("#customize-reply input").eq(1).val(json[0].keyword);
            	$("#customize-reply select").eq(0).val(json[0].match_rule);

            	if(typeName == "回复类型：文本"){
            		current_text = json;
            		current_type = "文本";
            		$("#customize-reply select").eq(1).val(0);
					$("#customize-reply").show();
					$("#auto-reply").hide();
					$("#default-reply").hide();
					$("#text textarea").val(json[0].content);
					$("#text").show();
					$("#image-text").hide();
					$("#image-texts").hide();
            	}else if(typeName == "回复类型：单图文"){
            		current_imageText = json;
            		current_type = "单图文";               		
            		$("#customize-reply select").eq(1).val(1);
					$("#customize-reply").show();
					$("#auto-reply").hide();
					$("#default-reply").hide();
					$("#image-text input").eq(0).val(json[0].title);
					$("#image-text input").eq(2).val(json[0].content);
					if(json[0].resource=='外部链接'){
						$("#image-text select").eq(1).html(select_store);
						$("#image-text input:radio[name='link'][value='outer-link']").attr('checked',"true");
						$("#image-text input").eq(4).val(json[0].url);
					}
					else{
						if(id_deleted[json[0].store_id]==1)
							var item_store = select_store+"<option value="+json[0].store_id+">"+id_name[json[0].store_id]+"(该店铺已被删除，请不要选择)</option>";
						$("#image-text select").eq(1).html(item_store);
						$("#image-text input:radio[name='link'][value='inner-link']").attr('checked',"true");
						$("#image-text select").eq(0).val(json[0].resource);
						$("#image-text select").eq(1).val(json[0].store_id);
					}
					$("#image-text").show();
					$("#text").hide();
					$("#image-texts").hide();
            	}else{
            		current_json = json;  
            		current_type = "多图文";                		              		
            		$("#customize-reply select").eq(1).val(2);
					$("#customize-reply").show();
					$("#default-reply").hide();
					$("#auto-reply").hide();

					for(var i=0;i<json.length;i++){
						$("#image-texts input:text").eq(2*i).val(json[i].title);
						$("#image-texts input:file").eq(i).attr("id","coverimgupload"+i+"_"+json[i].id);
						if(json[i].resource=='外部链接'){
							$("#image-texts select").eq(2*i+1).html(select_store);
							$("#image-texts input:radio[name='link"+i+"'][value='outer-link']").attr('checked',"true");
							$("#image-texts input:text").eq(2*i+1).val(json[i].url);
						}
						else{
							if(id_deleted[json[i].store_id]==1)
								var item_store = select_store+"<option value="+json[i].store_id+">"+id_name[json[i].store_id]+"(该店铺已被删除，请不要选择)</option>";
							$("#image-text select").eq(2*i+1).html(item_store);
							$("#image-texts input:radio[name='link"+i+"'][value='inner-link']").attr('checked',"true");
							$("#image-texts select").eq(2*i).val(json[i].resource);
							$("#image-texts select").eq(2*i+1).val(json[i].store_id);
						}
					}
					$("#subitems").html("");
					if(json.length>2){
						var item = "";
						for(var i=2;i<json.length;i++){
							item =item + "<div class='image-text' id='"+json[i].id+"'><a class='del-item'>删除</a><label class='resize'>普通图文 "+i+"</label><label>标题</label><input type='text' placeholder='输入标题...' value='"
							+json[i].title+"'><label>缩略图片（建议200*200）</label><img width='80' height='auto' src='<?php echo Yii::app()->baseUrl;?>"+"/"+json[i].picurl+"'><div class='cover-desc'><span>上传图片</span><input type='file' id='coverimgupload"+i+"_"+json[i].id+"' name='typeImg'></div>";
							if(json[i].resource=='外部链接'){
								var item_store = select_store+"</select></div>";
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link' checked>外部链接</label><input type='text' placeholder='输入外链url...' value='"
								+json[i].url+"'><label><input type='radio' name='link"+i+"' value='inner-link'>功能</label><select class='sp-select'><option value='在线订单'>在线订单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select><select class='sp-select' value='"
								+json[i].store_id+"'>"+item_store;
								item = item + itemThen;
							}else{
								var item_store = "";
								if(id_deleted[json[i].store_id]==1)
									item_store = select_store+"<option value='"+json[i].store_id+"'>"+id_name[json[i].store_id]+"(该店铺已被删除，请不要选择)</option></select></div>";
								else
									item_store = select_store+"</select></div>";
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link'>外部链接</label><input type='text' placeholder='输入外链url...'><label><input type='radio' name='link"+i+"' value='inner-link' checked>功能</label><select class='sp-select' value='"
								+json[i].resource+"'><option value='在线订单'>在线订单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select><select class='sp-select' value='"+json[i].store_id+"'>"+item_store;
								item = item + itemThen;
							}
						}
						$("#subitems").html(item);
						for(var i=2;i<json.length;i++){
							if(json[i].resource!='外部链接'){
								$("#image-texts select").eq(2*i).val(json[i].resource);
								$("#image-texts select").eq(2*i+1).val(json[i].store_id);																
							}
						}
					}						
					$("#image-texts").show();
					$("#text").hide();
					$("#image-text").hide();

            	}
            },
            error:function(){
            	alert('没有找到对应的规则！');
            },				
		})

	})


	$("#coverimgupload").change(function(){
		var up = $("#image-text span");
		var showTypeImg = $("#image-text img");
		var wrap_content = "<form id='myupload1' action='<?php echo Yii::app()->createUrl('weiXinReply/replyRules/imgUp');?>"+"/sdmsgsId/"+current_sdmsgs_id+"' method='get' enctype='multipart/form-data'></form>";
		$("#coverimgupload").wrap(wrap_content);
		$("#myupload1").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
				up.html("上传中...");
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
				up.html("上传中...");
    		},
			success: function(data) {
				showTypeImg.attr("src","<?php echo Yii::app()->baseUrl;?>"+"/"+data.pic_path);
				up.html("上传图片");
			},
			error:function(xhr){
				up.html("上传失败");
			}
		});
	})

	$("#image-texts input:file[name='typeImg']").live('change',function(){
		var id = $(this).attr("id");
		var serial = id.substring(14,15);
		var item_id = id.substring(16);
		var up = $(this).prev();
		var showTypeImg = $(this).parent().prev();
		var wrap_content = "<form action='<?php echo Yii::app()->createUrl('weiXinReply/replyRules/typeImgUp');?>"+"/itemId/"+item_id+"' method='get' enctype='multipart/form-data'></form>";
		$(this).wrap(wrap_content);
		var form = $(this).parent();
		form.ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
				up.html("上传中...");
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
				up.html("上传中...");
    		},
			success: function(data) {
				showTypeImg.attr("src","<?php echo Yii::app()->baseUrl;?>"+"/"+data.pic_path);
				up.html("上传图片");
			},
			error:function(xhr){
				up.html("上传失败");
			}
		});
	})
	
	$("#addImageText").click(function(){
		var serial = current_json.length;
		if(serial==10)
			alert("您最多能添加10条图文！");
		else if(serial<=9)
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('replyRules/addItem'));?>",
                data: {'sdmsg_id':current_sdmsgs_id,'serial':serial},
                dataType: 'json',
                
                success:function(json){
                	var item ="<div class='image-text' id='"+json.id+"'><a class='del-item'>删除</a><label class='resize'>普通图文</label><label>标题</label>"
					+"<input type='text' placeholder='输入标题...'><label>缩略图片（建议200*200）</label><img width='80' height='auto'  src='<?php echo Yii::app()->baseUrl;?>"
					+"/img/thumbnail.png'><div class='cover-desc'><span>上传图片</span><input type='file' id='coverimgupload"+serial+"_"+json[0].id+"' name='typeImg'></div><label>"
					+"<input type='radio' name='link' value='outer-link'>外部链接</label><input type='text' placeholder='输入外链url...'><label>"
					+"<input type='radio' name='link' value='inner-link'>功能</label><select class='sp-select'><option value='在线订单'>在线订单</option>"
			    	+"<option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select><select class='sp-select'>"+select_store;
			    	$("#subitems").append(item);
			    	current_json[serial] = json;
                },
                error:function(){
                	alert('添加图文失败！');
                },				
			})
	})

	$(".del-item").live('click',function(){
		var id = $(this).parent().attr("id");
		var delnode = $(this).parent();
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('replyRules/delItem'));?>",
            data: {'itemId':id},
            dataType: 'json',
            
            success:function(json){
            	delnode.remove();
            	current_json = json;
            },
            error:function(){
            	alert('删除图文失败！');
            },				
		})
	})

	$("#saveRule").click(function(){
		if(current_rule == 'customize'){
			var ruleName = $("#customize-reply input").eq(0).val();
			var keyword = $("#customize-reply input").eq(1).val();
			var match_rule = $("#customize-reply select").eq(0).val();
			var content = $("#text textarea").val();
			if(current_type == '多图文')
				saveCustomImageTexts(ruleName,keyword,match_rule);
		    else if(current_type == '单图文')
				saveCustomImageText(ruleName,keyword,match_rule);
			else
				saveCustomText(ruleName,keyword,match_rule);
		}else{
			if(current_type == '多图文' )
				saveDefaultImageTexts();
			else if(current_type == '单图文')
				saveDefaultImageText();
			else
				saveDefaultText();
		}
	})

})
</script>