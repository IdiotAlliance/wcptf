<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/product.css" rel="stylesheet" type="text/css">

<div id='task'>
	<div class="batch">
		<span class='bt-header'><?php echo $productType;?></span>
		<br>
		<span class='bt-desc'><?php echo $productList[0]->type->type_description;?></span>
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

<script type="text/javascript">
	$(document).ready(function(){
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
                data: {'typeName':'<php echo $productType;?>','changeDesc':changeDesc,
                'changeName':changeName},
                dataType: 'json',
                
                success:function(json){
                	$(".batch .bt-header").html(changeName);
                	$(".batch .bt-desc").html(changeDesc);
                	$("#task .batch").eq(0).css('display','block');
					$("#task .batch").eq(1).css('display','none');
                },
                error:function(){
                	alert('更新失败！');
                },
            })  
		})

	})
</script>