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
				<option value='0'>上架中</option>
				<option value='1'>已上架</option>
				<option value='2'>已下架</option>
			</select>
		</div>
		<div class='inline-display'>
			<input type='text' placeholder='搜索' id="search"></input>
		</div>
	</div>

	<ul id='product-list'>
		<?php foreach($prodList as $product):?>
		<li class='product'>
            <div class='left shift'><input name="chkItem" type="checkbox"></div>
            <img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl."/".$product['cover'];?>'>
            <a class="left prod-link">
                <div class='prod-name'><?php echo $product['pname'];?> </div>
                <div class='prod-price'>价格：<?php echo $product['price'];?>￥</div>
                <div class='prod-price'>
                	有效期：<span class="label label-info"><?php echo $product['stime'];?> </span> 至
                	<span class="label label-info"><?php echo $product['etime'];?></span>
                </div>                       
            </a>
            <a class="seal"><?php echo $product['status'];?></a>
        </li>	
		<?php endforeach;?>
	</ul>
	<div class='batch-menu'>
		<ul>
			<li>
				<input id='checkAll' type='checkbox'>  全选
			</li>
			<li><a href="javascript:;">批量操作</a></li>
			<li><a href="javascript:;">添加新商品</a></li>
		</ul>
	</div>
</div>

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


		<textarea id="myEditor"><?php echo $productInfo->richtext;?></textarea>

		<div class='info-button'>
			<button class="btn btn-success" id="saveProd">保存</button>
			<a href="javascript:;"><i class='icon-trash'></i>删除</a>
		</div>
    </div>
	<?php endif;?>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/ueditor/ueditor.all.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.form.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var editor = new UE.ui.Editor();
	    editor.render("myEditor");
		editor.addListener("ready", function () {
	        // editor准备好之后才可以使用
	        editor.setHeight(149);

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
		}).on('changeDate', function(ev){
		    if ($(".prod input").eq(4).val() > $(".prod input").eq(5).val()){
		        alert("有效期起始时间不能超过结束时间");
		    }
		});

		/*图片上传*/
		var prodId = $("#prod-id").html();
		var btn =$(".cover-desc span");
		var showimg = $("#showimg");
		var wrap_content = "<form id='myupload' action='<?php echo Yii::app()->createUrl('takeAway/productManager/coverUp');?>"+"/productId/"+prodId+"' method='post' enctype='multipart/form-data'></form>"
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
					window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+'/productType/'+changeName;
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
                	var img = "<?php echo Yii::app()->baseUrl;?>"+"/"+json.cover;
					$("#showimg").html("<img  width='200' class='left img-rounded'  src='"+img+"'>");
        			editor.ready(function(){
        				editor.setContent(json.richtext);
        			})
                },
                error:function(){
                	alert('更新失败！');
                },				
			})
		})

		$(".prod input").eq(0).blur(function(){
			var pname = $(this).val();
			if(pname == "")
				alert("商品名称不能为空");
		})

		$(".prod input").eq(1).blur(function(){
			var price = $(this).val();
			if(price == "")
				alert("商品价格不能为空");
		})	

		$(".prod input").eq(2).blur(function(){
			var credit = $(this).val();
			if(credit == "")
				alert("商品积分不能为空");
		})

		$("#saveProd").click(function(){
			var prodId = $("#prod-id").html();
			var pname = $(".prod input").eq(0).val();
			var productType = $(".prod .sp-select").find('option:selected').val();
			var price = $(".prod input").eq(1).val();
			var credit = $(".prod input").eq(2).val();
			var description = $(".prod input").eq(4).val();
			var stime = $(".prod input").eq(5).val();
			var etime = $(".prod input").eq(6).val();
			var instore = $(".prod input").eq(7).val();	
			var richtext = editor.getContent();
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/updateProduct'));?>",
                data: {'id':prodId,'pname':pname,'productType':productType,'price':price,
                		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore,
            			'richtext':richtext},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+'/productType/'+productType;
                },
                error:function(){
                	alert('保存失败');
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
				case '上架中':
					for(var i=0;i<prodList.length;i++){
						if(prodList[i].status!='上架中'){
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
				default:
					break;
			}
			var content="";
			for(var i=0;i<prodList.length;i++){
				if(prodList[i]!=null)
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
							pageContent ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
							+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
							+prodList[i].pname+"</div><div class='prod-price'>价格："
							+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
							+prodList[i].stime+"</span> 至<span class='label label-info'>"
							+prodList[i].etime+"</span></div></a><a class='seal'>"
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

		
	})
</script>