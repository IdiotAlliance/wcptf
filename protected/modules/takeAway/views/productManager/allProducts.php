<div id='task'>
	<div class="batch">
		<span class='bt-header'><?php echo $productType;?></span>
		<br>
		<span class='bt-desc'>密室类商品，欢迎预定</span>
	</div>
	<div class='batch-link'>
		<div class='item'>
			<a href="javascript:;">编辑</a>
		</div>
		<div class='item'>
			<a href="javascript:;">删除</a>
		</div>
	</div>

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
                	有效期：<span class="label label-info"><?php $stime = new DateTime($product->stime); echo $stime->format('Y-m-d');?> </span> 至
                	<span class="label label-info"><?php $etime = new DateTime($product->etime); echo $etime->format('Y-m-d');?></span>
                </div>                       
            </a>
            <a class="seal"><?php echo $product->status;?></a>
        </li>	
		<?php endforeach;?>
	</ul>
</div>