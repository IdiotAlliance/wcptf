<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/product.css" rel="stylesheet" type="text/css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">

<div id='action-name' class='productManager'></div>
<div id='task'>
	<div class="batch">
		<span class='bt-header'><?php echo $productType;?></span>
		<br>
		<span class='bt-desc'><?php echo $productDesc;?></span>
	</div>
	<div class="batch" style="display:none">
		<input type="text" placeholder='输入类别'></input>
		<button id='saveCategory'class='btn btn-success' data-loading-text="正在保存...">保存</button>
		<input type="text" placeholder='输入商品描述'></input>
		<button id='cancelCategory' class='btn-tow btn-tow-x'>取消</button>
	</div>

	<?php if($productType!='未分类' && $productType!='星标类'):?>
	<div class='batch-link'>
		<div class='item'>
			<a href="javascript:;" id='editCategory'>编辑</a>
		</div>
		<div class='item'>
			<a href="javascript:;">删除</a>
		</div>
	</div>
	<?php endif;?>

	<div class="listTitle">
		<div class='inline-display'>
			<label class='inline-display'>排序：</label>
			<select class='sp-select'>
				<option value='0'>名称</option>
				<option value='1'>有效期起始</option>
				<option value='2'>有效期终止</option>
				<option value='3'>价格</option>
			</select>
		</div>
		<div class='inline-display'>
			<label class='inline-display'>筛选：</label>
			<select class='sp-select'>
				<option value='0'>上架中</option>
				<option value='1'>下架中</option>
				<option value='2'>已过期</option>
			</select>
		</div>
		<div class='inline-display'>
			<input type='text' placeholder='搜索'></input>
		</div>
	</div>

	<ul id='product-list'>
		<?php foreach($productList as $product):?>
		<li class='product'>
            <div class='left shift'><input type="checkbox"></div>
            <img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl.$product->cover0->pic_url;?>'>
            <a class="left prod-link">
                <div class='prod-name'><?php echo $product->pname;?> </div>
                <div class='prod-price'>价格：<?php echo $product->price;?>￥</div>
                <div class='prod-price'>
                	有效期：<span class="label label-info"><?php echo $product->stime;?> </span> 至
                	<span class="label label-info"><?php echo $product->etime;?></span>
                </div>                       
            </a>
            <a class="seal"><?php echo $product->status;?></a>
        </li>	
		<?php endforeach;?>
	</ul>
	<div class='batch-menu'>
		<ul>
			<li>
				<input type='checkbox'>  全选
			</li>
			<li><a href="javascript:;">批量操作</a></li>
			<li><a href="javascript:;">添加新商品</a></li>
		</ul>
	</div>
</div>

<div class='task-detail'>
    <div class='prod' action='<?php echo CHtml::normalizeUrl(array('productManager/updateCategory'));?>'>
        <img class='img-rounded left' width='200' src="<?php echo Yii::app()->baseUrl.'/img/prod1.png'?>">
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
					<option>未分类</option>
					<option>星标类</option>
					<?php foreach (Yii::app()->session['typeCount'] as $tc):?>						
					<option <?php if($productInfo->type_id == $tc->id){echo 'Selected';}?>><?php echo $tc->type_name?></option>
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
    		<a href="javascript:;">选择新封面</a>
    		<p class='desc'>你可以选择jpg/png图片(200*150)作为封面</p>
    	</div>
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


		<textarea id="myEditor"><?php echo $productInfo->richtext;?></textarea>

		<div class='info-button'>
			<button class="btn btn-success" id="saveProd">保存</button>
			<a href="javascript:;"><i class='icon-trash'></i>删除</a>
		</div>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var editor = new UE.ui.Editor();
	    editor.render("myEditor");
		editor.addListener("ready", function () {
	        // editor准备好之后才可以使用
	        editor.setHeight(150);

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
		});

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
                data: {'typeName':'<?php echo $productType;?>','changeDesc':changeDesc,
                'changeName':changeName},
                dataType: 'json',
                
                success:function(json){
					window.location.href = "http://localhost/weChat/index.php?r=takeAway/productManager/allProducts&productType="+changeName;
                },
                error:function(){
                	alert('更新失败！');
                },
            })  
		})

		$("#product-list li").click(function(){
			var pname = $(this).find('.prod-name').html();

			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/getProduct'));?>",
                data: {'pname':pname},
                dataType: 'json',
                
                success:function(json){
                	$(".task-detail input").eq(0).val(json.pname);
                	$(".task-detail input").eq(1).val(json.price+'￥');
                	$(".task-detail input").eq(2).val(json.credit);
                	$(".task-detail input").eq(3).val(json.description);
                	$(".task-detail input").eq(4).val(json.stime);
                	$(".task-detail input").eq(5).val(json.etime);
                	$(".task-detail input").eq(6).val(json.instore);
        			editor.ready(function(){
        				editor.setContent(json.richtext);
        			})
                },
                error:function(){
                	alert('更新失败！');
                },				
			})
		})

		$("#saveProd").click(function(){

		})

	})
</script>