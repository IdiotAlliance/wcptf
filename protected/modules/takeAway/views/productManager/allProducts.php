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
				<option value='0'>全部</option>			
				<option value='1'>未到期</option>
				<option value='2'>已上架</option>
				<option value='3'>已下架</option>
				<option value='4'>已过期</option>
			</select>
		</div>
		<div class='inline-display'>
			<input type='text' placeholder='搜索' id="search"></input>
		</div>
	</div>

	<?php if($prodList != null):?>
	<ul id='product-list'>
		<?php foreach($prodList as $product):?>
		<li class='product <?php if($productInfo->id==$product['id']) echo 'active';?>'>
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
						<?php foreach ($this->typeCount as $tc):?>						
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
						<?php foreach ($this->typeCount as $tc):?>
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

<div id="change-area" tabindex='-3'>
<div id='loading' style="display:none">
	<div id="circular" class="marginLeft">
		<div id="circular_1" class="circular"></div>
		<div id="circular_2" class="circular"></div>
		<div id="circular_3" class="circular"></div>
		<div id="circular_4" class="circular"></div>
		<div id="circular_5" class="circular"></div>
		<div id="circular_6" class="circular"></div>
		<div id="circular_7" class="circular"></div>
		<div id="circular_8" class="circular"></div>
		<div id="clearfix"></div>
	</div> 
</div>
<div class='task-detail'>
	<?php if($productInfo!=null):?>
    <div class='prod'>
    	<div id='prod-id' style="display:none"><?php echo $productInfo->id;?></div>
        <div id='showimg'>
        	<span class="image-center-helper"></span>
        	<img class='img-rounded left' width='200' height='160' src="<?php echo Yii::app()->baseUrl.'/'.$productInfo->cover0->pic_url?>">
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
					<?php foreach ($this->typeCount as $tc):?>						
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
    	<div class="image-group">
    		<label class="title-label">更多图片</label>
    		<?php foreach ($images as $image) {
    			echo "<div class='image-item image-item-img' id='imageitem_".$image['id']."' name='".$image['id']."'><span class='image-item-img-container'></span><img src='".Yii::app()->baseUrl.'/'.$image['url']."' /></div>";
    		}?>
    		<div class="image-item image-item-add" id="image-item-add">
    			<span class="image-item-img-container"></sapn>
    			<img src="<?php echo Yii::app()->baseUrl."/img/berry_add.png";?>" />
    			<input type="file" id="moreimgupload" name='prodImg' />
    		</div>
    	</div>
    </div>

	<!--
		<textarea id="myEditor" style="width:500px;padding:0 10px 0 10px;"><?php echo $productInfo->richtext;?></textarea>
	-->
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
			<li><a href="javascript:;" id='discount'>限时优惠</a></li>
			<li><a href="javascript:;" id='saveProd'>保存</a></li>
			<li><a href="javascript:;" id='cancelChange'>取消修改</a></li>			
			<li><a href="javascript:;" id='delProd'>删除</a></li>
		</ul>
	</div>
	<?php endif;?>
</div>
</div>
<div id="image-gallery">
	<div id="image-gallery-container">
		<div id="image-gallery-container-img">
			<span class="image-center-helper"></span>
		</div>
		<div id="image-gallery-delete">删除该图片</div>
	</div>
</div>
<div id="discount-manager">
	<div id="discount-manager-container">
		<div id="discount-manager-header">
			限时优惠
		</div>
		<div id="discount-manager-list">
			<div class='discount-manager-edit'>
				<div><label>日期</label></div>
				<div class="discount-manager-input-group">
					<input type="text" id="sdate_picker" style="width:200px" readonly class="form_dateime"/>
	    			至
	    			<input type="text" id="edate_picker"style="width:200px" readonly class="form_dateime"/> 
				</div>
				<div><label>时间</label></div>
				<div class="discount-manager-input-group">
					<input type="text" id="stime_picker" style="width:200px" readonly />
	    			至
	    			<input type="text" id="etime_picker" style="width:200px" readonly /> 
				</div>
				<div class="discount-edit-btn-container">
					<div class="btn btn-primary" id="discount-save">保存</div>
					<div class="btn btn-info" id="discount-cancel">取消</div>
				</div>
			</div>
		</div>
		<div id="discount-manager-footer">
			<div class="modal-btn modal-cancel" id="discount-close">关闭</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/bootstrap-datetimepicker.min.js"></script>
<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ueditor/ueditor.all.js"></script>
-->
<script charset="utf-8" type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.form.js"></script>
<script charset="utf-8" type="text/javascript">
	(function(win){
		win.PRODUCTS = {};
		win.PRODUCTS.imagetodel = -1;
		win.PRODUCTS.isfocus  = false;
		win.PRODUCTS.typeId   = <?php echo $productType->id; ?>;
		win.PRODUCTS.pdinfo   = <?php echo CJSON::encode($productInfo); ?>;
		win.PRODUCTS.prodList = <?php echo json_encode($prodList);?>;
		win.PRODUCTS.sid      = <?php echo $this->currentStore->id; ?>;
	})(window);
</script>
<script charset="utf-8" type="text/javascript" src="<?php echo Yii::app()->createUrl('/resource/resource/js/name/allProductsv0_7');?>"></script>