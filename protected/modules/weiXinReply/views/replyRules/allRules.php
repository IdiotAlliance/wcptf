<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/product.css" rel="stylesheet" type="text/css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/rules.css" rel="stylesheet" type="text/css">

<div id='task'>
	<ul id='rule-list'>
		<li>
			<h5>关注后自动回复</h5>
			<label>回复类型：文本</label>
        </li>
		<li>
			<h5>无匹配默认回复</h5>
			<label>回复类型：单图文</label>
        </li> 
        <li>
        	<div class='reply-checkbox'><input type='checkbox'></div>
        	<div class="left">
	        	<h5>菜单回复</h5>
	        	<label>回复类型：单图文</label>
        	</div>
        </li>       	
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
		<label class='title-change resize'>名称：关注后自动回复（用户关注该公告账号后，收到的第一条回复）</label>
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
		<label class='title-change resize'>回复内容：</label>
		<!--文本-->
		<div class='reply-content' style="display:none">
			<textarea placeholder='请输入文本' style="width:90%;height:150px;overflow-y:auto;"></textarea>
		</div>
		<!--单图文-->
		<div class='reply-content' style="display:none">
			<label>标题</label>
			<input type='text' placeholder='输入标题...'>
			<label>封面图片（建议360*200）</label>
			<img src="<?php echo Yii::app()->baseUrl."/img/replyCover.png";?>">
	    	<div class="cover-desc">
				<span>上传图片</span>
				<input type='file' id='coverimgupload' name='typeImg'>
	    	</div>
	    	<label style="margin-top:5px;">内容简介</label>
			<input type='text' placeholder='输入内容简介...'>
	    	<label><input type='radio' name='link'>外部链接</label>
	    	<input type='text' placeholder='输入外链url...'>
	    	<label><input type='radio' name='link'>素材和功能</label>
	    	<select class="sp-select">
	    		<option>在线点单</option>
	    		<option>聚划算</option>
	    		<option>我的订单</option>
	    	</select>
		</div>
		<!--多图文-->
		<div class='reply-content'>
			<div class="image-text">
				<label class='resize'>封面图文</label>
				<label>标题</label>
				<input type='text' placeholder='输入标题...'>
				<label>封面图片（建议360*200）</label>
				<img src="<?php echo Yii::app()->baseUrl."/img/replyCover.png";?>">
		    	<div class="cover-desc">
					<span>上传图片</span>
					<input type='file' id='coverimgupload' name='typeImg'>
		    	</div>
		    	<label><input type='radio' name='link'>外部链接</label>
		    	<input type='text' placeholder='输入外链url...'>
		    	<label><input type='radio' name='link'>素材和功能</label>
		    	<select class="sp-select">
		    		<option>在线点单</option>
		    		<option>聚划算</option>
		    		<option>我的订单</option>
		    	</select>
			</div>
			<div class="image-text">
				<label class='resize'>普通图文</label>
				<label>标题</label>
				<input type='text' placeholder='输入标题...'>
				<label>缩略图片（建议200*200）</label>
				<img src="<?php echo Yii::app()->baseUrl."/img/thumbnail.png";?>">
		    	<div class="cover-desc">
					<span>上传图片</span>
					<input type='file' id='coverimgupload' name='typeImg'>
		    	</div>
		    	<label><input type='radio' name='link'>外部链接</label>
		    	<input type='text' placeholder='输入外链url...'>
		    	<label><input type='radio' name='link'>素材和功能</label>
		    	<select class="sp-select">
		    		<option>在线点单</option>
		    		<option>聚划算</option>
		    		<option>我的订单</option>
		    	</select>
			</div>

			<div class="imagetext-add image-text">
				<a href="javascript:void(0);">添加图文</a>
			</div>			
		</div>
	</div>

	<div class='batch-menu'>
		<ul>
			<li><a href="javascript:;" id='saveProd'>保存</a></li>
			<li><a href="javascript:;" id='cancelChange'>取消修改</a></li>			
			<li><a href="javascript:;" id='delProd'>删除</a></li>
		</ul>
	</div>	
</div>

<script type="text/javascript">
	$(document).ready(function(event){
		$("#addRule").click(function(){
			var title = $("#addModal input").eq(0).val();
			var type = $("#addModal select").find('option:selected').text();
			var li = "<li><div class='reply-checkbox'><input type='checkbox'></div><div class='left'><h5>"+ title +"</h5><label>回复类型："+type+"</label></div></li>";

			$("#rule-list").append(li);
			$("#addModal").modal('hide');
		});

		window.onbeforeunload=function(){
		  	return "请点击取消留在此页";
		}
	})
</script>