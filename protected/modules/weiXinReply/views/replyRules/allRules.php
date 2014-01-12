<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/product.css" rel="stylesheet" type="text/css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/rules.css" rel="stylesheet" type="text/css">

<div id='task'>
	<ul id='rule-list'>
		<li id='<?php echo $default[0]['id'];?>'>
			<h5>关注后自动回复</h5>
			<label>回复类型：<?php echo $default[0]['type_name'];?></label>
        </li>
		<li id='<?php echo $default[1]['id'];?>'>
			<h5>无匹配默认回复</h5>
			<label>回复类型：<?php echo $default[1]['type_name'];?></label>
        </li> 	
	</ul>
	<ul id='custom-list'>
        <?php foreach($itemList as $item):?> 
        <li>
        	<div class='reply-checkbox'><input type='checkbox' value="<?php echo $item['sdmsgs_id']?>"></div>
        	<div class="left">
	        	<h5><?php echo $item['menu_name'];?></h5>
	        	<label>回复类型：<?php echo $item['type_name'];?></label>
        	</div>
        </li>
        <?php endforeach;?>  
	</ul>
	<div class='batch-menu'>
		<ul>
			<li>
				<input id='checkAll' type='checkbox'>  全选
			</li>
			<li><a href="javascript:;">批量操作</a></li>
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
<div id="change-area">
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
	    		<option value='在线点单'>在线点单</option>
	    		<option value='个人中心'>个人中心</option>
	    		<option value='首页推荐'>首页推荐</option>
	    		<option value='联系我们'>联系我们</option>
	    	</select>
		</div>
		<!--多图文-->
		<div class='reply-content' style="display:none" id='image-texts'>
			<div class="image-text">
				<label class='resize'>封面图文</label>
				<label>标题</label>
				<input type='text' placeholder='输入标题...'>
				<label>封面图片（建议360*200）</label>
				<img width="200" height="auto" src="<?php echo Yii::app()->baseUrl."/img/replyCover.png";?>">
		    	<div class="cover-desc">
					<span>上传图片</span>
					<input type='file' name='typeImg'>
		    	</div>
		    	<label><input type='radio' name='link' value='outer-link'>外部链接</label>
		    	<input type='text' placeholder='输入外链url...'>
		    	<label><input type='radio' name='link' value='inner-link'>功能</label>
		    	<select class="sp-select">
		    		<option value='在线点单'>在线点单</option>
		    		<option value='个人中心'>个人中心</option>
		    		<option value='首页推荐'>首页推荐</option>
		    		<option value='联系我们'>联系我们</option>
		    	</select>
			</div>
			<div id='subitems'>
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
		    	<label><input type='radio' name='link' value='outer-link'>外部链接</label>
		    	<input type='text' placeholder='输入外链url...'>
		    	<label><input type='radio' name='link' value='inner-link'>功能</label>
		    	<select class="sp-select">
		    		<option value='在线点单'>在线点单</option>
		    		<option value='个人中心'>个人中心</option>
		    		<option value='首页推荐'>首页推荐</option>
		    		<option value='联系我们'>联系我们</option>
		    	</select>
		    	<select class="sp-select">
		    		<option value='在线点单'>全部</option>
		    		<option value='个人中心'>店铺B</option>
		    		<option value='首页推荐'>首页推荐</option>
		    		<option value='联系我们'>联系我们</option>
		    	</select>		    	
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
<script type="text/javascript">
	$(document).ready(function(event){
		var current_sdmsgs_id = 0;//当前sdmsg的id
		var current_json = null;//存储多图文内容
		var current_type = "单图文";//存储当前回复类型
		$("#addRule").click(function(){
			var title = $("#addModal input").eq(0).val();
			var type = $("#addModal select").find('option:selected').text();
			var li = "<li><div class='reply-checkbox'><input type='checkbox'></div><div class='left'><h5>"+ title +"</h5><label>回复类型："+type+"</label></div></li>";

			$("#custom-list").append(li);
			$("#addModal").modal('hide');
		});

		$("#auto-reply").change(function(){
			current_type = $("#auto-reply select").find('option:selected').text();
			if(current_type == '文本'){
				$("#text").show();
				$("#image-text").hide();
				$("#image-texts").hide();
			}else if(current_type == '单图文'){
				$("#image-text").show();
				$("#text").hide();
				$("#image-texts").hide();
			}else if(current_type == '多图文'){
				$("#image-texts").show();
				$("#text").hide();
				$("image-text").hide();
			}
		})

		$("#auto-reply").change(function(){
			current_type = $("#auto-reply select").find('option:selected').text();
			if(current_type == '文本'){
				$("#text").show();
				$("#image-text").hide();
				$("#image-texts").hide();
			}else if(current_type == '单图文'){
				$("#image-text").show();
				$("#text").hide();
				$("#image-texts").hide();
			}else if(current_type == '多图文'){
				$("#image-texts").show();
				$("#text").hide();
				$("image-text").hide();
			}
		})

		$("#default-reply").change(function(){
			current_type = $("#default-reply select").find('option:selected').text();
			if(current_type == '文本'){
				$("#text").show();
				$("#image-text").hide();
				$("#image-texts").hide();
			}else if(current_type == '单图文'){
				$("#image-text").show();
				$("#text").hide();
				$("#image-texts").hide();
			}else if(current_type == '多图文'){
				$("#image-texts").show();
				$("#text").hide();
				$("image-text").hide();
			}
		})

		$("#customize-reply").change(function(){
			current_type = $("#customize-reply select").find('option:selected').text();
			if(current_type == '文本'){
				$("#text").show();
				$("#image-text").hide();
				$("#image-texts").hide();
			}else if(current_type == '单图文'){
				$("#image-text").show();
				$("#text").hide();
				$("#image-texts").hide();
			}else if(current_type == '多图文'){
				$("#image-texts").show();
				$("#text").hide();
				$("image-text").hide();
			}
		})

		$("#rule-list li").eq(0).click(function(){
			var autoId = $("#rule-list li").eq(0).attr("id");
			var typeName = $("#rule-list li label").eq(0).text();
			current_sdmsgs_id = autoId;

			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('replyRules/getDefaultRule'));?>",
                data: {'sdmsg_id':autoId},
                dataType: 'json',
                
                success:function(json){
                	if(typeName == "回复类型：文本"){
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
                		current_type = "单图文";
                		$("#auto-reply select").val(1);
						$("#auto-reply").show();
						$("#default-reply").hide();
						$("#customize-reply").hide();
						$("#image-text input").eq(0).val(json[0].title);
						$("#image-text input").eq(2).val(json[0].content);
						if(json[0].resource=='外部链接'){
							$("#image-text input:radio[name='link'][value='outer-link']").attr('checked',"true");
							$("#image-text input").eq(4).val(json[0].url);
						}
						else{
							$("#image-text input:radio[name='link'][value='inner-link']").attr('checked',"true");
							$("#image-text select").val(json[0].resource);
						}

						$("image-text").show();
						$("#text").hide();
						$("#image-texts").hide();

                	}else{
                		current_json = json; 
                		current_type = "多图文";        
                		$("#auto-reply select").val(2);
						$("#auto-reply").show();
						$("#default-reply").hide();
						$("#customize-reply").hide();
						$("#image-texts input").eq(0).val(json[0].title);
						var tempId = "coverimgupload0_"+ json[0].id;
						$("#image-texts input").eq(1).attr("id",tempId);
						if(json[0].resource=='外部链接'){
							$("#image-texts input:radio[name='link'][value='outer-link']").attr('checked',"true");
							$("#image-texts input").eq(3).val(json[0].url);
						}
						else{
							$("#image-texts input:radio[name='link'][value='inner-link']").attr('checked',"true");
							$("#image-texts select").val(json[0].resource);
						}
						var item = "";
						for(var i=1;i<json.length;i++){
							item =item + "<div class='image-text' id='"+json[i].id+"'><a class='del-item'>删除</a><label class='resize'>普通图文 "+i+"</label><label>标题</label><input type='text' placeholder='输入标题...' value='"
							+json[i].title+"'><label>缩略图片（建议200*200）</label><img width='80' height='auto' src='<?php echo Yii::app()->baseUrl;?>"+"/"+json[i].picurl+"'><div class='cover-desc'><span>上传图片</span><input type='file' id='coverimgupload"+i+"_"+json[i].id+"' name='typeImg'></div>";
							if(json[i].resource=='外部链接'){
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link' checked>外部链接</label><input type='text' placeholder='输入外链url...' value='"
								+json[i].url+"'><label><input type='radio' name='link"+i+"' value='inner-link'>功能</label><select class='sp-select'><option value='在线点单'>在线点单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select></div>";
								item = item + itemThen;
							}else{
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link'>外部链接</label><input type='text' placeholder='输入外链url...'><label><input type='radio' name='link"+i+"' value='inner-link' checked>功能</label><select class='sp-select' value='"
								+json[i].resource+"'><option value='在线点单'>在线点单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select></div>"; 
								item = item + itemThen;
							}
						}
						$("#subitems").html(item);
						$("#image-texts").show();
						$("#text").hide();
						$("image-text").hide();

                	}
                },
                error:function(){
                	alert('没有找到对应的规则！');
                },				
			})
		})

		$("#rule-list li").eq(1).click(function(){
			var defaultId = $(this).attr("id");
			var typeName = $("#rule-list li label").eq(1).text();
			current_sdmsgs_id = defaultId;
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('replyRules/getDefaultRule'));?>",
                data: {'sdmsg_id':defaultId},
                dataType: 'json',
                
                success:function(json){
                	if(typeName == "回复类型：文本"){
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
                		current_type = "单图文";                		
                		$("#default-reply select").val(1);
						$("#default-reply").show();
						$("#auto-reply").hide();
						$("#customize-reply").hide();
						$("#image-text input").eq(0).val(json[0].title);
						$("#image-text input").eq(2).val(json[0].content);
						if(json[0].resource=='外部链接'){
							$("#image-text input:radio[name='link'][value='outer-link']").attr('checked',"true");
							$("#image-text input").eq(4).val(json[0].url);
						}
						else{
							$("#image-text input:radio[name='link'][value='inner-link']").attr('checked',"true");
							$("#image-text select").val(json[0].resource);
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
						$("#image-texts input").eq(0).val(json[0].title);
						var tempId = "coverimgupload0_"+ json[0].id;
						$("#image-texts input").eq(1).attr("id",tempId);						
						if(json[0].resource=='外部链接'){
							$("#image-texts input:radio[name='link'][value='outer-link']").attr('checked',"true");
							$("#image-texts input").eq(3).val(json[0].url);
						}
						else{
							$("#image-texts input:radio[name='link'][value='inner-link']").attr('checked',"true");
							$("#image-texts select").val(json[0].resource);
						}
						var item = "";
						for(var i=1;i<json.length;i++){
							item = item+ "<div class='image-text' id='"+json[i].id+"'><a class='del-item'>删除</a><label class='resize'>普通图文 "+i+"</label><label>标题</label><input type='text' placeholder='输入标题...' value='"
							+json[i].title+"'><label>缩略图片（建议200*200）</label><img width='80' height='auto' src='<?php echo Yii::app()->baseUrl;?>"+"/"+json[i].picurl+"'><div class='cover-desc'><span>上传图片</span><input type='file' id='coverimgupload"+i+"_"+json[i].id+"' name='typeImg'></div>";
							if(json[i].resource=='外部链接'){
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link' checked>外部链接</label><input type='text' placeholder='输入外链url...' value='"
								+json[i].url+"'><label><input type='radio' name='link"+i+"' value='inner-link'>功能</label><select class='sp-select'><option value='在线点单'>在线点单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select></div>";
								item = item + itemThen;
							}else{
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link'>外部链接</label><input type='text' placeholder='输入外链url...'><label><input type='radio' name='link"+i+"' value='inner-link' checked>功能</label><select class='sp-select' value='"
								+json[i].resource+"'><option value='在线点单'>在线点单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select></div>"; 
								item = item + itemThen;
							}						}
						$("#subitems").html(item);
						$("#image-texts").show();
						$("#text").hide();
						$("image-text").hide();

                	}
                },
                error:function(){
                	alert('没有找到对应的规则！');
                },				
			})
		})

		$("#custom-list li").live('click',function(){
			var sdmsgId = $(this).find('input:checkbox').val();
			var typeName = $(this).find("label").eq(1).text();
			var ruleName = $(this).find("h5").eq(0).text();
			current_sdmsgs_id = sdmsgId;
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('replyRules/getDefaultRule'));?>",
                data: {'sdmsg_id':sdmsgId},
                dataType: 'json',
                
                success:function(json){
                	if(typeName == "回复类型：文本"){
                		current_type = "文本";
                		$("#customize-reply select").val(0);
						$("#customize-reply").show();
						$("#auto-reply").hide();
						$("#default-reply").hide();
						$("#text textarea").val(json[0].content);
						$("#text").show();
						$("#image-text").hide();
						$("#image-texts").hide();
                	}else if(typeName == "回复类型：单图文"){
                		current_type = "单图文";               		
                		$("#customize-reply select").val(1);
						$("#customize-reply").show();
						$("#auto-reply").hide();
						$("#default-reply").hide();
						$("#image-text input").eq(0).val(json[0].title);
						$("#image-text input").eq(2).val(json[0].content);
						if(json[0].resource=='外部链接'){
							$("#image-text input:radio[name='link'][value='outer-link']").attr('checked',"true");
							$("#image-text input").eq(4).val(json[0].url);
						}
						else{
							$("#image-text input:radio[name='link'][value='inner-link']").attr('checked',"true");
							$("#image-text select").val(json[0].resource);
						}
						$("#image-text").show();
						$("#text").hide();
						$("#image-texts").hide();
                	}else{
                		current_json = json;  
                		current_type = "多图文";                		              		
                		$("#customize-reply input").eq(0).val(ruleName);
                		$("#customize-reply input").eq(1).val(json[0].keyword);
                		$("#customize-reply select").val(2);
						$("#customize-reply").show();
						$("#default-reply").hide();
						$("#auto-reply").hide();
						$("#image-texts input").eq(0).val(json[0].title);
						var tempId = "coverimgupload0_"+ json[0].id;
						$("#image-texts input").eq(1).attr("id",tempId);
						if(json[0].resource=='外部链接'){
							$("#image-texts input:radio[name='link'][value='outer-link']").attr('checked',"true");
							$("#image-texts input").eq(3).val(json[0].url);
						}
						else{
							$("#image-texts input:radio[name='link'][value='inner-link']").attr('checked',"true");
							$("#image-texts select").val(json[0].resource);
						}
						var item = "";
						for(var i=1;i<json.length;i++){
							item = item+ "<div class='image-text' id='"+json[i].id+"'><a class='del-item'>删除</a><label class='resize'>普通图文 "+i+"</label><label>标题</label><input type='text' placeholder='输入标题...' value='"
							+json[i].title+"'><label>缩略图片（建议200*200）</label><img width='80' height='auto'  src='<?php echo Yii::app()->baseUrl;?>"+"/"+json[i].picurl+"'><div class='cover-desc'><span>上传图片</span><input type='file' id='coverimgupload"+i+"_"+json[i].id+"' name='typeImg'></div>";
							if(json[i].resource=='外部链接'){
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link' checked>外部链接</label><input type='text' placeholder='输入外链url...' value='"
								+json[i].url+"'><label><input type='radio' name='link"+i+"' value='inner-link'>功能</label><select class='sp-select'><option value='在线点单'>在线点单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select></div>";
								item = item + itemThen;
							}else{
								var itemThen = "<label><input type='radio' name='link"+i+"' value='outer-link'>外部链接</label><input type='text' placeholder='输入外链url...'><label><input type='radio' name='link"+i+"' value='inner-link' checked>功能</label><select class='sp-select' value='"
								+json[i].resource+"'><option value='在线点单'>在线点单</option><option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select></div>"; 
								item = item + itemThen;
							}
						}
						$("#subitems").html(item);

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
	                	var item ="<div class='image-text' id='"+json.id+"'><label class='resize'>普通图文</label><label>标题</label>"
						+"<input type='text' placeholder='输入标题...'><label>缩略图片（建议200*200）</label><img width='80' height='auto'  src='<?php echo Yii::app()->baseUrl;?>"
						+"/img/thumbnail.png'><div class='cover-desc'><span>上传图片</span><input type='file' id='coverimgupload"+serial+"_"+json[0].id+"' name='typeImg'></div><label>"
						+"<input type='radio' name='link' value='outer-link'>外部链接</label><input type='text' placeholder='输入外链url...'><label>"
						+"<input type='radio' name='link' value='inner-link'>功能</label><select class='sp-select'><option value='在线点单'>在线点单</option>"
				    	+"<option value='个人中心'>个人中心</option><option value='首页推荐'>首页推荐</option><option value='联系我们'>联系我们</option></select></div>";
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
			
		})
		// window.onbeforeunload=function(){
		//   	return "请点击取消留在此页";
		// }
	})
</script>