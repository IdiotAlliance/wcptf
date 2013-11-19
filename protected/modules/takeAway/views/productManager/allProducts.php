<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/product.css" rel="stylesheet" type="text/css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">

<div id='action-name' class='productManager'></div>
<div id='task'>
	<div class="batch">
		<span class='bt-header'><?php echo $productType->type_name;?></span>
		<br>
		<span class='bt-desc'><?php echo $productType->type_description;?></span>
	</div>
	<div class="batch" style="display:none">
		<input type="text" placeholder='输入类别'></input>
		<button id='saveCategory'class='btn btn-success' data-loading-text="正在保存...">保存</button>
		<input type="text" placeholder='输入商品描述'></input>
		<button id='cancelCategory' class='btn-tow btn-tow-x'>取消</button>
    	<div class='row-fluid'>
	    	<div class="type-img-desc span4">
				<span>选择新封面</span>
				<input type='file' id='typeimgupload' name='typeImg'>
	    	</div>
	    	<div id='showTypeImg' class='span6'>
    			<img class='img-rounded'  width='90' src="<?php echo Yii::app()->baseUrl.'/'.$productType->pic_url?>">
    		</div>
    	</div>

	</div>

	<div class='batch-link'>
		<div class='item'>
			<a href="javascript:;" id='editCategory'>编辑</a>
		</div>
		<div class='item'>
			<?php if($prodList!=null):?>
			<a href="#delCategoryModal" role="button" data-toggle="modal">删除</a>
			<?php endif;?>
			<?php if($prodList==null):?>
			<a href="javascript:;" id='delTypeNone'>删除</a>
			<?php endif;?>			
		</div>
	</div>

	<div class="listTitle">
		<div class='inline-display'>
			<label class='inline-display'>排序：</label>
			<select class='sp-select' id='sort' onselect="sort()">
				<option value='0'>名称</option>
				<option value='1'>有效期起始</option>
				<option value='2'>有效期终止</option>
				<option value='3'>价格</option>
			</select>
		</div>
		<div class='inline-display'>
			<label class='inline-display'>筛选：</label>
			<select class='sp-select' id='filt'>
				<option value='0'>未到期</option>
				<option value='1'>已上架</option>
				<option value='2'>已下架</option>
				<option value='3'>已过期</option>
			</select>
		</div>
		<div class='inline-display'>
			<input type='text' placeholder='搜索' id="search"></input>
		</div>
	</div>

	<?php if($prodList != null):?>
	<ul id='product-list'>
		<?php foreach($prodList as $product):?>
		<li class='product'>
            <div class='left shift'><input name="chkItem" type="checkbox" value="<?php echo $product['id']?>"></div>
            <img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl."/".$product['cover'];?>'>
            <a class="left prod-link">
                <div class='prod-name'><?php echo $product['pname'];?> </div>
                <div class='prod-price'>价格：<?php echo $product['price'];?>￥</div>
                <div class='prod-price'>
                	有效期：<span class="label label-info"><?php echo $product['stime'];?> </span> 至
                	<span class="label label-info"><?php echo $product['etime'];?></span>
                </div>                       
            </a>
            <?php if($product['status']=='未到期' || $product['status']=='已过期'):?>
            <a class="grey-seal"><?php echo $product['status'];?></a>
        	<?php endif;?>
        	<?php if($product['status']!='未到期' && $product['status']!='已过期'):?>
        	<a class="seal" ><?php echo $product['status'];?></a>
			<?php endif;?>
        </li>	
		<?php endforeach;?>
	</ul>
	<?php endif;?>
	<!--popover菜单-->
	<ul id='popup' style="display:none">
		<li><a href="#stockModal" role="button" data-toggle="modal">调整库存</a></li>
		<li><a href="#categoryModal" role="button" data-toggle="modal">设置分类</a></li>
		<li><a href="javascript:;">全部上架</a></li>
		<li><a href="javascript:;">全部下架</a></li>
		<li><a href="javascript:;">删除</a></li>
	</ul>

	<div class='batch-menu'>
		<ul>
			<li>
				<input id='checkAll' type='checkbox'>  全选
			</li>
			<li><a href="javascript:;">批量操作</a></li>
			<li><a href="#addModal" role="button" data-toggle="modal">添加新商品</a></li>
		</ul>
	</div>
	<!-- Modal -->
	<div id="stockModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>调整库存</h3>
		</div>
		<div class="modal-body">
			<div class='modal-group'>
				<label class='title-label'>产量</label>
				<div class='content-label'>
					<input type='text' placeholder='请输入产量'>
				</div>
			</div>
		</div>
		<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		<button class="btn btn-success" id="stocksSave">保存</button>
		</div>
	</div>
	<?php if($productInfo!=null):?>
	<div id="categoryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>设置分类</h3>
		</div>
		<div class="modal-body">
	    	<div class='modal-group'>
	    		<label class='title-label'>类别</label>
	    		<div class='content-label'>
					<select class='sp-select'>
						<?php foreach (Yii::app()->session['typeCount'] as $tc):?>						
						<option value="<?php echo $tc['typeId'];?>" <?php if($productInfo->type_id == $tc['typeId']){echo 'Selected';}?> ><?php echo $tc['type_name'];?></option>
						<?php endforeach;?>
					</select>
	    		</div>
	    	</div>
		</div>
		<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		<button class="btn btn-success" id="categorysSave">保存</button>
		</div>
	</div>
	<?php endif;?>
	<div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>添加新商品</h3>
		</div>
		<div class="modal-body">
	    	<div class='modal-group'>
	    		<label class='title-label'>商品名称</label>
	    		<div class='content-label'>
					<input type='text' placeholder='请输入商品名称'>
	    		</div>
	    	</div>
	    	<div class='modal-group'>
	    		<label class='title-label'>价格</label>
	    		<div class='content-label'>
					<input type='text' placeholder='请输入商品价格'>
	    		</div>
	    	</div>	    	
	    	<div class='modal-group'>
	    		<label class='title-label'>积分</label>
	    		<div class='content-label'>
					<input type='text' placeholder='请输入商品积分'>
	    		</div>
	    	</div>	
	    	<div class='modal-group'>
	    		<label class='title-label'>描述</label>
	    		<div class='content-label'>
					<input type='text' placeholder='请输入商品简介'>
	    		</div>
	    	</div>

	    	<div class='modal-group'>
	    		<label class='title-label'>有效期起始</label>
	    		<div class='content-label'>
    	    		<input type="text"   name='stime'  readonly class='form_dateime'>
	    		</div>
	    	</div>		 
 	    	<div class='modal-group'>
	    		<label class='title-label'>有效期终止</label>
	    		<div class='content-label'>
    				<input type="text"  name='etime'  readonly class='form_dateime'>
	    		</div>
	    	</div> 
	    	<div class='modal-group'>
	    		<label class='title-label'>产量</label>
	    		<div class='content-label'>
					<input type='text' placeholder='请输入商品产量'>
	    		</div>
	    	</div> 	    	
		</div>
		<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		<button class="btn btn-success" id="addsSave">保存</button>
		</div>
	</div>

	<div id="delCategoryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>删除类别</h3>
		</div>
		<div class="modal-body">
	    	<div class='modal-group'>
	    		<label class='title-label'>类别</label>
	    		<div class='content-label'>
					<select class='sp-select' style="width:400px">
						<option value='0'>删除类别以及该类别下所有商品</option>
						<?php foreach (Yii::app()->session['typeCount'] as $tc):?>
						<?php if($tc['typeId']!=$productType->id):?>						
						<option value="<?php echo $tc['typeId'];?>"><?php echo "删除类别，并将该类别下所有商品转移到类别【".$tc['type_name']."】";?></option>
						<?php endif;?>
						<?php endforeach;?>
					</select>
	    		</div>
	    	</div>
		</div>
		<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		<button class="btn btn-success" id="delCategory">保存</button>
		</div>
	</div>	
</div>

<div id="change-area">
<div class='task-detail'>
	<?php if($productInfo!=null):?>
    <div class='prod'>
    	<div id='prod-id' style="display:none"><?php echo $productInfo->id;?></div>
        <div id='showimg'>
        	<img class='img-rounded left' width='200' src="<?php echo Yii::app()->baseUrl.'/'.$productInfo->cover0->pic_url?>">
    	</div>
    	<div class='info-group-left'>
    		<label class='title-label'>商品名称</label>
    		<div class='content-label'>
    			<input type="text" name='pname' value="<?php echo $productInfo->pname?>">
    		</div>
    	</div>
    	<div class='info-group-left'>
    		<label class='title-label'>类别</label>
    		<div class='content-label'>
				<select class='sp-select'>
					<?php foreach (Yii::app()->session['typeCount'] as $tc):?>						
					<option value="<?php echo $tc['typeId'];?>" <?php if($productInfo->type_id == $tc['typeId']){echo 'Selected';}?>><?php echo $tc['type_name']?></option>
					<?php endforeach?>
				</select>
    		</div>
    	</div>
    	<div class='info-group-left'>
    		<label class='title-label'>价格</label>
    		<div class='content-label'>
    			<input type="text" name='price' value="<?php echo $productInfo->price.'￥';?>">
    		</div>
    	</div>
    	<div class='info-group-left'>
    		<label class='title-label'>积分</label>
    		<div class='content-label'>
    			<input type="text" name='credit' value="<?php echo $productInfo->credit;?>">
    		</div>
    	</div>
    	<div class="cover-desc">
			<span>选择新封面</span>
			<input type='file' id='fileupload' name='cover'>
    	</div>
    	<p class="desc">你可以选择png/jpg图片作为封面</p>
    	<div class='info-group'>
    		<label class='title-label'>描述</label>
    		<div class='content-label'>
    			<input type="text"  style="width:446px" value="<?php echo $productInfo->description;?>" placeholder='请输入商品描述'>
    		</div>
    	</div>
    	<div class='date-group'>
    		<label>有效期</label>
    		<input type="text"  style="width:200px" name='stime' value="<?php echo $productInfo->stime;?>" readonly class='form_dateime'>
    		<label>至</label>
    		<input type="text"  style="width:200px" name='etime' value="<?php echo $productInfo->etime;?>" readonly class='form_dateime'>
    	</div>
    	<div class='info-group'>
    		<label class='title-label'>产量</label>
    		<div class='content-label'>
    			<input type="text" value="<?php echo $productInfo->instore;?>" placeholder='请输入商品产能'>
    		</div>
    	</div>
    </div>

	<textarea id="myEditor" style="width:500px;padding:0 10px 0 10px;"><?php echo $productInfo->richtext;?></textarea>
	<div class='batch-menu'>
		<ul>
			<li>
				<?php if($productInfo->status=="未到期" || $productInfo->status=="已过期"):?>
				<a href="javascript:;" id='shelfProd'>当前不在有效期内</a>
				<?php endif;?>
				<?php if($productInfo->status=="已上架"):?>
				<a href="javascript:;" id="shelfProd">下架产品</a>
				<?php endif;?>
				<?php if($productInfo->status=="已下架"):?>
				<a href="javascript:;" id="shelfProd">上架产品</a>
				<?php endif;?>								
			</li>
			<li><a href="javascript:;" id='saveProd'>保存</a></li>
			<li><a href="javascript:;" id='delProd'>删除</a></li>
		</ul>
	</div>
	<?php endif;?>
</div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ueditor/ueditor.all.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.form.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var pdinfo = <?php echo json_encode($productInfo);?>;
		var editor = new UE.ui.Editor();
	    editor.render("myEditor");
		editor.addListener("ready", function () {
	        // editor准备好之后才可以使用
	        var height = $("body").height()-101-$(".task-detail .prod").height()-$("#change-area .batch-menu").height();
	        editor.setHeight(height);

		});		
		$.fn.datetimepicker.dates['zh-CN'] = {
					days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
					daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
					daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
					months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
					monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
					today: "今日",
					suffix: [],
					meridiem: []
				};
		$(".form_dateime").datetimepicker({
			format:'yyyy-mm-dd',
			autoclose:true,
			minView:2,
			language:'zh-CN',
		}).on('changeDate', function(ev){});

		/*图片上传*/
		var prodId = $("#prod-id").html();
		var btn =$(".cover-desc span");
		var showimg = $("#showimg");
		var wrap_content = "<form id='myupload' action='<?php echo Yii::app()->createUrl('takeAway/productManager/coverUp');?>"+"/productId/"+prodId+"' method='post' enctype='multipart/form-data'></form>";
		$("#fileupload").wrap(wrap_content);
		$("#fileupload").change(function(){
			$("#myupload").ajaxSubmit({
				dataType:  'json',
				beforeSend: function() {
					btn.html("上传中...");
	    		},
	    		uploadProgress: function(event, position, total, percentComplete) {
					btn.html("上传中...");
	    		},
				success: function(data) {
					var img = "<?php echo Yii::app()->baseUrl;?>"+"/"+data.pic_path;
					showimg.html("<img  width='200' class='left img-rounded'  src='"+img+"'>");
					btn.html("添加附件");
				},
				error:function(xhr){
					btn.html("上传失败");
				}
			});
		});

		/*类别图片上传*/
		var up = $(".type-img-desc span");
		var showTypeImg = $("#showTypeImg");
		var wrap_content = "<form id='myupload1' action='<?php echo Yii::app()->createUrl('takeAway/productManager/typeImgUp',array('typeId'=>$productType->id));?>' method='post' enctype='multipart/form-data'></form>";
		$("#typeimgupload").wrap(wrap_content);		
		$("#typeimgupload").change(function(){
			$("#myupload1").ajaxSubmit({
				dataType:  'json',
				beforeSend: function() {
					up.html("上传中...");
	    		},
	    		uploadProgress: function(event, position, total, percentComplete) {
					up.html("上传中...");
	    		},
				success: function(data) {
					var img = "<?php echo Yii::app()->baseUrl;?>"+"/"+data.pic_path;
					showTypeImg.html("<img  width='40' class='left img-rounded'  src='"+img+"'>");
					up.html("添加附件");
				},
				error:function(xhr){
					up.html("上传失败");
				}
			});
		})

		// $("#changeArea").live('blur',function(){
		// 	var pname = $(".prod input").eq(0).val();
		// 	var typeId = $(".prod .sp-select").find('option:selected').val();
		// 	var price = $(".prod input").eq(1).val();
		// 	var credit = $(".prod input").eq(2).val();
		// 	var description = $(".prod input").eq(4).val();
		// 	var stime = $(".prod input").eq(5).val();
		// 	var etime = $(".prod input").eq(6).val();
		// 	var instore = $(".prod input").eq(7).val();	
		// 	var richtext = editor.getContent();
		// 	if(pdInfo.pname!=pname || pdInfo.typeId!=typeId || pdInfo.price!=price 
		// 		|| pdInfo.credit!=credit || pdInfo.description!=description || pdInfo.stime!=stime
		// 		|| pdInfo.etime!=etime || pdInfo.instore!=instore || pdInfo.richtext!=richtext){
		// 		if(confirm("您对商品"+pname+"作了修改，是否保存该商品")){
		// 			$.ajax({
		//                 type: 'POST',
		//                 url: "<?php echo CHtml::normalizeUrl(array('productManager/updateProduct'));?>",
		//                 data: {'id':prodId,'pname':pname,'typeId':typeId,'price':price,
		//                 		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore,
		//             			'richtext':richtext},
		//                 dataType: 'json',
		                
		//                 success:function(json){
		//                 	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
		//                 },
		//                 error:function(){
		//                 	alert('保存失败');
		//                 },				
		// 			})

		// 		}
		// 	}
		// })

		/*
			编辑、保存、取消类别的修改
		*/
		$("#editCategory").click(function(){
			$("#task .batch").eq(0).css('display','none');
			$("#task .batch").eq(1).css('display','block');
			$(".batch input").eq(0).val($(".batch .bt-header").html());
			$(".batch input").eq(1).val($(".batch .bt-desc").html());

		})

		$("#cancelCategory").click(function(){
			$("#task .batch").eq(0).css('display','block');
			$("#task .batch").eq(1).css('display','none');
		})

		$("#saveCategory").click(function(){
			var changeName = $(".batch input").eq(0).val();
			var changeDesc = $(".batch input").eq(1).val();
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/updateCategory'));?>",
                data: {'id':'<?php echo $productType->id;?>','changeDesc':changeDesc,
                'changeName':changeName},
                dataType: 'json',
                
                success:function(json){
					window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
                },
                error:function(){
                	alert('商品类别名重复');
                },
            })  
		})
		
		
		$("#delTypeNone").click(function(){
			if(confirm('您确定要删除该空类别吗')){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('productManager/delTypeNone'));?>",
	                data: {'id':<?php echo $productType->id;?>},
	                dataType: 'json',
	                
	                success:function(json){
	                	if(json.empty == 1){
							window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/noProducts'); ?>";
						}else{
							window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>/typeId/" + json.id;
						}		            
					},
	                error:function(){
	                	alert('保存失败');
	                },				
				})
			}
		});
		$("#delCategory").click(function(){
			var choice = $("#delCategoryModal select").find('option:selected').val();
			var deleteOr = true;
			if(choice != '0'){
				deleteOr = false;
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('productManager/delCategory'));?>",
	                data: {'newTypeId':choice,'deleteOr':deleteOr,'id':<?php echo $productType->id;?>},
	                dataType: 'json',
	                
	                success:function(json){
	                	$("#delCategoryModal").modal('hide');
	                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+"/typeId/"+choice;
		            },
	                error:function(){
	                	alert('保存失败');
	                },				
				})
			}else{
				deleteOr = true;
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('productManager/delCategory'));?>",
	                data: {'newTypeId':choice,'deleteOr':deleteOr,'id':<?php echo $productType->id;?>},
	                dataType: 'json',
	                
	                success:function(json){
	                	$("#delCategoryModal").modal('hide');
						if(json.empty == 1){
							window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/noProducts'); ?>";
						}else{
							window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>/typeId/" + json.id;
						}
		            },
	                error:function(){
	                	alert('保存失败');
	                },				
				})
			}


		})

		$("#product-list li").live('click',function(){
			var id = $(this).find('input:checkbox').val();
			$("#product-list li").removeClass('active');
			$(this).addClass("active");
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/getProduct'));?>",
                data: {'id':id},
                dataType: 'json',
                
                success:function(json){
                	var tmp = "<?php echo Yii::app()->createUrl('takeAway/productManager/coverUp');?>"+"/productId/"+json.id;
                	$("#myupload").attr('action',tmp);
                	$("#prod-id").html(json.id);
                	$(".task-detail input").eq(0).val(json.pname);
                	$(".task-detail input").eq(1).val(json.price+'￥');
                	$(".task-detail input").eq(2).val(json.credit);
                	$(".task-detail input").eq(4).val(json.description);
                	$(".task-detail input").eq(5).val(json.stime);
                	$(".task-detail input").eq(6).val(json.etime);
                	$(".task-detail input").eq(7).val(json.instore);
                	if(json.status=='未到期' || json.status=='已过期')
		               	$("#shelfProd").val("当前不在有效期内");
		            else if(json.status=='已上架')
		               	$("#shelfProd").val("下架产品");
		            else if(json.status=='已下架')
		               	$("#shelfProd").val("上架产品");
                	var img = "<?php echo Yii::app()->baseUrl;?>"+"/"+json.cover;
					$("#showimg").html("<img  width='200' class='left img-rounded'  src='"+img+"'>");
        			editor.ready(function(){
        				editor.setContent(json.richtext);
        			})

        			pdInfo = json;
                },
                error:function(){
                	alert('更新失败！');
                },				
			})
		})

		$("#shelfProd").click(function(){
			var prodId = $("#prod-id").html();
			var shelf = $("#shelfProd").html();
			if(shelf == '上架产品'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('productManager/shelfProduct'));?>",
	                data: {'id':prodId,'status':1},
	                dataType: 'json',	                
	                success:function(json){
	                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
	                },
	                error:function(){
	                	alert('保存失败');
	                },				
				})
			}
			else if(shelf=='下架产品'){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('productManager/shelfProduct'));?>",
	                data: {'id':prodId,'status':2},
	                dataType: 'json',	                
	                success:function(json){
	                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
	                },
	                error:function(){
	                	alert('保存失败');
	                },				
				})				
			}		})

		$("#saveProd").click(function(){
			var prodId = $("#prod-id").html();
			var pname = $(".prod input").eq(0).val();
			var typeId = $(".prod .sp-select").find('option:selected').val();
			var price = $(".prod input").eq(1).val();
			var credit = $(".prod input").eq(2).val();
			var description = $(".prod input").eq(4).val();
			var stime = $(".prod input").eq(5).val();
			var etime = $(".prod input").eq(6).val();
			var instore = $(".prod input").eq(7).val();	
			var richtext = editor.getContent();
			if(pname == null)
				alert("商品名字不能为空");
			else if(price==null)
				alert("价格不能为空");						
			else if(credit==null)
				alert("积分不能为空");						
			else if(instore==null)
				alert("库存不能为空");		
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/updateProduct'));?>",
                data: {'id':prodId,'pname':pname,'typeId':typeId,'price':price,
                		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore,
            			'richtext':richtext},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
                },
                error:function(){
                	alert('保存失败');
                },				
			})
		})

		$("#delProd").click(function(){
			var prodId = $("#prod-id").html();
			if(confirm("您确定要删除商品吗？"))
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('productManager/delProduct'));?>",
	                data: {'id':prodId},
	                dataType: 'json',
	                
	                success:function(json){
	                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
	                },
	                error:function(){
	                	alert('删除失败');
	                },				
				})
		})

		function sortByName(list){
			for(var i=1;i<list.length;i++){
				if(list[i-1].pinyin < list[i].pinyin){
					var tmp = list[i];
					var j = i;
					while(j>0 && list[j-1].pinyin<tmp.pinyin){
						list[j] = list[j-1];
						j--;
					}
					list[j] = tmp;
				}
			}
		}

		function sortByPrice(list){
			for(var i=1;i<list.length;i++){
				if(parseInt(list[i-1].price) > parseInt(list[i].price)){
					var tmp = list[i];
					var j = i;
					while(j>0 && parseInt(list[j-1].price)>parseInt(tmp.price)){
						list[j] = list[j-1];
						j--;
					}
					list[j] = tmp;
				}
			}
		}

		function sortByStime(list){
			for(var i=1;i<list.length;i++){
				if(compareDate(list[i].stime,list[i-1].stime)){
					var tmp = list[i];
					var j = i;
					while(j>0 && compareDate(tmp.stime,list[j-1].stime)){
						list[j] = list[j-1];
						j--;
					}
					list[j] = tmp;
				}
			}
		}

		function sortByEtime(list){
			for(var i=1;i<list.length;i++){
				if(compareDate(list[i].etime,list[i-1].etime)){
					var tmp = list[i];
					var j = i;
					while(j>0 && compareDate(tmp.etime,list[j-1].etime)){
						list[j] = list[j-1];
						j--;
					}
					list[j] = tmp;
				}
			}
		}

		function compareDate(date1,date2){
			var arr=date1.split("-");    
			var time1 = new Date(parseInt(arr[0]),parseInt(arr[1])-1,parseInt(arr[2]));
			var times1 = time1.getTime();

			var arr2 = date2.split("-");
			var time2 = new Date(parseInt(arr2[0]),parseInt(arr2[1])-1,parseInt(arr2[2]));
			var times2 = time2.getTime();
			if(times1>=times2)
				return false;
			else
				return true;
		}

		$("#sort").change(function(){
			var prodList = <?php echo json_encode($prodList);?>;
			prodList = eval(prodList);
			var option = $(this).find("option:selected").text();
			switch(option){
				case '名称':
					sortByName(prodList);
					break;
				case '价格':
					sortByPrice(prodList);
					break;
				case '有效期起始':
					sortByStime(prodList);
					break;
				case '有效期终止':
					sortByEtime(prodList);
					break;
				default:
					break;
			}
			var content="";
			for(var i=0;i<prodList.length;i++){

				if(prodList[i].status=='未到期' || prodList[i].status=='已过期')
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+prodList[i].pname+"</div><div class='prod-price'>价格："
					+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+prodList[i].stime+"</span> 至<span class='label label-info'>"
					+prodList[i].etime+"</span></div></a><a class='grey-seal'>"
					+prodList[i].status+"</a></li>" +content;
				else
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+prodList[i].pname+"</div><div class='prod-price'>价格："
					+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+prodList[i].stime+"</span> 至<span class='label label-info'>"
					+prodList[i].etime+"</span></div></a><a class='seal'>"
					+prodList[i].status+"</a></li>" +content;
			}
			$("#product-list").html(content);
		})
		

		$("#filt").change(function(){
			var prodList = <?php echo json_encode($prodList);?>;
			prodList = eval(prodList);	
			var option = $(this).find("option:selected").text();
			switch(option){
				case '未到期':
					for(var i=0;i<prodList.length;i++){
						if(prodList[i].status!='未到期'){
							delete prodList[i];
						}
					}
					break;
				case '已上架':
					for(var i=0;i<prodList.length;i++){
						if(prodList[i].status!='已上架'){
							delete prodList[i];
						}
					}
					break;
				case '已下架':
					for(var i=0;i<prodList.length;i++){
						if(prodList[i].status!='已下架'){
							delete prodList[i];
						}
					}
					break;
				case '已过期':
					for(var i=0;i<prodList.length;i++){
						if(prodList[i].status!='已过期'){
							delete prodList[i];
						}
					}
					break;
				default:
					break;
			}
			var content="";
			for(var i=0;i<prodList.length;i++){
				if(prodList[i]!=null)
					if(prodList[i].status=='未到期' || prodList[i].status=='已过期')
						content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
						+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
						+prodList[i].pname+"</div><div class='prod-price'>价格："
						+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
						+prodList[i].stime+"</span> 至<span class='label label-info'>"
						+prodList[i].etime+"</span></div></a><a class='grey-seal'>"
						+prodList[i].status+"</a></li>" +content;
					else
						content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
						+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
						+prodList[i].pname+"</div><div class='prod-price'>价格："
						+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
						+prodList[i].stime+"</span> 至<span class='label label-info'>"
						+prodList[i].etime+"</span></div></a><a class='seal'>"
						+prodList[i].status+"</a></li>" +content;
			}
			$("#product-list").html(content);
		})

		$("#search").keyup(function(event){
			var key = event.which;
			var content = $("#search").val();
			if(key == 13){
				if(content==null)
					alert("搜索内容那个不能为空");
				else{
					var prodList = <?php echo json_encode($prodList);?>;
					var pageContent = "";
					for(var i=0;i<prodList.length;i++){
						if(prodList[i].pname.indexOf(content)>=0){
							if(prodList[i].status=='未到期' || prodList[i].status=='已过期')
								pageContent ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
								+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
								+prodList[i].pname+"</div><div class='prod-price'>价格："
								+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
								+prodList[i].stime+"</span> 至<span class='label label-info'>"
								+prodList[i].etime+"</span></div></a><a class='seal'>"
								+prodList[i].status+"</a></li>" +pageContent;
							else
								pageContent ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
								+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
								+prodList[i].pname+"</div><div class='prod-price'>价格："
								+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
								+prodList[i].stime+"</span> 至<span class='label label-info'>"
								+prodList[i].etime+"</span></div></a><a class='grey-seal'>"
								+prodList[i].status+"</a></li>" +pageContent;								
						}
					}
					$("#product-list").html(pageContent);

				}
			}				
		});

		$("#checkAll").click(function(){
			if($("#checkAll").attr("checked")=='checked')
				$("[name = chkItem]:checkbox").attr("checked", true);
			else
				$("[name = chkItem]:checkbox").attr("checked", false);

		});

		$(".batch-menu li a").eq(0).click(function(){
			var size = $("#product-list input:checkbox").length;
			var count = 0;
			for(var i=0;i<size;i++){
				if($("#product-list input:checkbox").eq(i).attr("checked")){
					count++;
				}
			}
			if(count==0)
				alert("请选中某一商品");
			else
				$("#popup").toggle();

		});


		$("#stocksSave").click(function(){
			var stock = $("#stockModal input").val();
			var idList = [];
			var size = $("#product-list input:checkbox").length;
			var count = 0;
			for(var i=0;i<size;i++){
				if($("#product-list input:checkbox").eq(i).attr("checked")){
					idList[count] = $("#product-list input:checkbox").eq(i).val();
					count++;
				}
			}
			if(count==0)
				alert("请选中某一商品");
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/batchStock'));?>",
                data: {'stock':stock,'idList':idList},
                dataType: 'json',
                
                success:function(json){
                	$("#stockModal").modal('hide');
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
                },
                error:function(){
                	alert('保存失败');
                },				
			})
		});
		//需要修改
		$("#categorysSave").click(function(){
			var typeId = $("#categoryModal select").find('option:selected').val();
			var idList = [];
			var size = $("#product-list input:checkbox").length;
			var count = 0;
			for(var i=0;i<size;i++){
				if($("#product-list input:checkbox").eq(i).attr("checked")){
					idList[count] = $("#product-list input:checkbox").eq(i).val();
					count++;
				}
			}
			if(count==0)
				alert("请选中某一商品");
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/batchCategory'));?>",
                data: {'newTypeId':typeId,'idList':idList},
                dataType: 'json',
                
                success:function(json){
                	$("#categoryModal").modal('hide');
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+"/typeId/"+typeId;
                },
                error:function(){
                	alert('保存失败');
                },				
			})
		});

		$("#addsSave").click(function(){
			var pname = $("#addModal input").eq(0).val();
			var price = $("#addModal input").eq(1).val();
			var credit = $("#addModal input").eq(2).val();
			var description = $("#addModal input").eq(3).val();
			var stime = $("#addModal input").eq(4).val();
			var etime = $("#addModal input").eq(5).val();
			var instore = $("#addModal input").eq(6).val();	
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/addProduct'));?>",
                data: {'pname':pname,'typeId':"<?php echo $productType->id;?>",'price':price,
                		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore},
                dataType: 'json',
                
                success:function(json){
                	$("#categoryModal").modal('hide');
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
                },
                error:function(){
                	alert('保存失败');
                },				
			})
		});

		$("#popup li a").eq(2).click(function(){
			var idList = [];
			var size = $("#product-list input:checkbox").length;
			var count = 0;
			var status = false;
			var pdList = <?php echo json_encode($prodList);?>;

			for(var i=0;i<size;i++){
				if($("#product-list input:checkbox").eq(i).attr("checked")){
					idList[count] = $("#product-list input:checkbox").eq(i).val();
					if(!status){
						for(var j=0;j<pdList.length;j++){
							if(pdList[j]['id']==idList[count] && (pdList[j]['status']=='未到期' || pdList[j]['status']=='已过期')){
									status = true;
							}
						}
					}
					count++;
				}
			}
			if(status)
				alert("您选中的商品有未到期或已过期的，我们将不予以上架");
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/batchShelf'));?>",
                data: {'status':1,'idList':idList},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
                },
                error:function(){
                	alert('保存失败');
                },				
			})
		})
		
		$("#popup li a").eq(3).click(function(){
			var idList = [];
			var size = $("#product-list input:checkbox").length;
			var count = 0;
			var status = false;
			var pdList = <?php echo json_encode($prodList);?>;

			for(var i=0;i<size;i++){
				if($("#product-list input:checkbox").eq(i).attr("checked")){
					idList[count] = $("#product-list input:checkbox").eq(i).val();
					if(!status){
						for(var j=0;j<pdList.length;j++){
							if(pdList[j]['id']==idList[count] && (pdList[j]['status']=='未到期' || pdList[j]['status']=='已过期')){
									status = true;
							}
						}
					}
					count++;
				}
			}
			if(count==0)
				alert("请选中某一商品");
			if(status)
				alert("您选中的商品有未到期或已过期的，只有有效期范围内的商品才能下架");
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/batchShelf'));?>",
                data: {'status':2,'idList':idList},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
                },
                error:function(){
                	alert('保存失败');
                },				
			})
		})

		$("#popup li a").eq(4).click(function(){
			var idList = [];
			var size = $("#product-list input:checkbox").length;
			var count = 0;
			for(var i=0;i<size;i++){
				if($("#product-list input:checkbox").eq(i).attr("checked")){
					idList[count] = $("#product-list input:checkbox").eq(i).val();
					count++;
				}
			}
			if(count==0)
				alert("请选中某一商品");
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/batchDel'));?>",
                data: {'idList':idList},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>";
                },
                error:function(){
                	alert('保存失败');
                },				
			})
		})
	})
</script>