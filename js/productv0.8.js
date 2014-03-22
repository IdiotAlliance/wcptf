
var imagetodel   = -1; 
$(document).ready(function(event){
	var pdinfo = <?php 
						echo CJSON::encode($productInfo);
				?>;//商品信息的全局变量
	var isfocus = false;//当前编辑区域是否被选中
	var prodList = <?php echo json_encode($prodList);?>;//类别下的商品列表
	var sid = <?php echo $this->currentStore->id;?>;
	///var editor = new UE.ui.Editor();
    //editor.render("myEditor");
	//editor.addListener("ready", function () {
    //    // editor准备好之后才可以使用
    //    var height = $("body").height()-101-$(".task-detail .prod").height()-$("#change-area .batch-menu").height();
    //    editor.setHeight(height);

	//});
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

	function loading(){
		var load = "<div id='circular' class='marginLeft'>"
			+"<div id='circular_1' class='circular'></div>"
			+"<div id='circular_2' class='circular'></div>"
			+"<div id='circular_3' class='circular'></div>"
			+"<div id='circular_4' class='circular'></div>"
			+"<div id='circular_5' class='circular'></div>"
			+"<div id='circular_6' class='circular'></div>"
			+"<div id='circular_7' class='circular'></div>"
			+"<div id='circular_8' class='circular'></div>"
			+"<div id='clearfix'></div></div>";
		return load;
	}

	document.addEventListener('click',function(event){
		if(isfocus){
			var target = event.target;
			var isin = false;
			while(!$(target).is('body')){
				if($(target).is("#change-area") || 
				   $(target).is('#image-gallery') ||
				   $(target).is('.datetimepicker')){
					isin = true;
				}
				target = $(target).parent();
			}
			if(!isin){
				isfocus = false;
				var prodId = $("#prod-id").html();
				var pname = $(".prod input").eq(0).val();
				var typeId = $(".prod .sp-select").find('option:selected').val();
				var price = $(".prod input").eq(1).val();
				var credit = $(".prod input").eq(2).val();
				var description = $(".prod input").eq(4).val();
				var stime = $(".prod input").eq(5).val();
				var etime = $(".prod input").eq(6).val();
				var instore = $(".prod input").eq(7).val();	
				// var richtext = editor.getContent();
				pdinfo.price = pdinfo.price+"￥";
				if(pname!=pdinfo.pname || typeId!=pdinfo.type_id || 
				   price!=pdinfo.price || credit!=pdinfo.credit || 
				   description!=pdinfo.description || stime!=pdinfo.stime ||
				   etime!=pdinfo.etime || instore!=pdinfo.instore){
						event.stopPropagation();
						event.preventDefault();						
					if(confirm("您对商品作了修改，在结束商品编辑前，请先保存商品")){
						$.ajax({
			                type: 'POST',
			                url: "<?php echo CHtml::normalizeUrl(array('productManager/updateProduct'));?>",
			                data: {'id':prodId,'pname':pname,'typeId':typeId,'price':price,
			                		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore
			            			//,'richtext':richtext
			            		  },
			                dataType: 'json',
			                
			                success:function(json){
								alert("保存成功！");
			                },	
			                error:function(){
			                	alert('保存失败');
			                },				
						})
					}else{
						isfocus = true;
					}
				}
			}
		}
	},true)


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


	var wrap_content = "<form id='more_img_upload' " +
					    "action='<?php echo Yii::app()->createUrl('takeAway/productManager/prodImgUp');?>/productId/" + prodId +
						"' method='post' enctype='multipart/form-data'>" +
					   "</form>";
	
	$('#moreimgupload').wrap(wrap_content);
	$('#moreimgupload').change(function(){
		var tempid = (new Date()).getTime();
		$('#more_img_upload').ajaxSubmit({
			dataType: 'json',
			beforeSend: function() {
				$("<div class='image-item image-item-img' id='" + tempid + "'></div>").insertBefore($('#image-item-add'));
				$('#' + tempid).html('上传中...');
			},
			uploadProgress: function(event, posistion, total, percentComplete) {
				$('#' + tempid).html('上传中 ' + percentComplete + '%');
			},
			success: function(data) {
				$('#moreimgupload').val("");
				$('#' + tempid).html("<span class='image-item-img-container'></span><img onclick='onImageItemClick(event)' src='<?php echo Yii::app()->baseUrl;?>/" + data['pic_path'] + "' />");
				$('#' + tempid).attr('name', data['piid']);
				$('#' + tempid).attr('id', 'imageitem_' + data['piid']);
			},
			error: function(xhr) {
				$('#moreimgupload').val("");
				$('#' + tempid).remove();
			}
		});
	});
	$('.image-item-img img').click(function(event){
		onImageItemClick(event);
	});
	$('#image-gallery').click(function(){
		$('#image-gallery').fadeOut('fast');
	});
	$('#image-gallery-delete').click(function(event){
		event.preventDefault();
		event.stopPropagation();
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("takeAway/productManager/delimg")?>/id/' + imagetodel,
			dataType: 'json',
			success: function(data){
				if(parseInt(data['count']) > 0){
					$('#image-gallery').fadeOut('fast');
					$('#imageitem_' + imagetodel).remove();
				}
			},
			error: function(xhr){
				alert("删除失败");
				$('#image-gallery').fadeOut('fast');
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
				window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id,'prodId'=>0,'sid'=>$this->currentStore->id));?>";
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
                data: {'id':<?php echo $productType->id;?>,'sid':sid},
                dataType: 'json',
                
                success:function(json){
                	if(json.empty == 1){
						window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/noProducts',array('sid'=>$this->currentStore->id));?>";
					}else{
						window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>/typeId/" + json.id+"/prodId/0"+"/sid/"+sid;
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
                data: {'newTypeId':choice,'deleteOr':deleteOr,'id':<?php echo $productType->id;?>,'sid':sid},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+"/typeId/"+choice+"/prodId/0"+"/sid/"+sid;
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
                data: {'newTypeId':choice,'deleteOr':deleteOr,'id':<?php echo $productType->id;?>,'sid':sid},
                dataType: 'json',
                
                success:function(json){
                	if(json.empty == 1){
						window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/noProducts',array('sid'=>$this->currentStore->id)); ?>";
					}else{
						window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>/typeId/" + json.id+"/prodId/0"+"/sid/"+sid;
					}
                },
                error:function(){
                	alert('保存失败');
                },				
			})
		}


	})
	
	$("#product-list li").live('click',function(){
		var typeId = $(".prod .sp-select").find('option:selected').val();
		var id = $(this).find('input:checkbox').val();
		$("#product-list li").removeClass('active');
		$(this).addClass("active");
	
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('productManager/getProduct'));?>",
            data: {'id':id},
            dataType: 'json',
            
            beforeSend:function(){
            	$("#loading").show();
            	$(".task-detail").hide();
            },
            success:function(json){
            	$(".task-detail").show();
            	$("#loading").hide();
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
	               	$("#shelfProd").html("当前不在有效期内");
	            else if(json.status=='已上架')
	               	$("#shelfProd").html("下架产品");
	            else if(json.status=='已下架')
	               	$("#shelfProd").html("上架产品");
            	var img = "<?php echo Yii::app()->baseUrl;?>"+"/"+json.cover;
				$("#showimg").html("<img  width='200' class='left img-rounded'  src='"+img+"'>");
    			// editor.ready(function(){
    			// 	editor.setContent(json.richtext);
    			// })
    			pdinfo = json;
            },
            error:function(){
            	alert('获取产品失败！');
            },				
		});
	});

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
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>"+"/prodId/"+prodId+"/sid/"+sid;
                },
                error:function(){
                	alert('保存失败');
                },				
			});
		}
		else if(shelf=='下架产品'){
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/shelfProduct'));?>",
                data: {'id':prodId,'status':2},
                dataType: 'json',	                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>"+"/prodId/"+prodId+"/sid/"+sid;
                },
                error:function(){
                	alert('保存失败');
                },				
			});		
		}
	});
	
	$("#change-area").click(function(){
		isfocus = true;
	});

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
		//var richtext = editor.getContent();
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
            		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore
            	 	// , 'richtext':richtext
            	  },
            dataType: 'json',
            
            success:function(json){
            	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+"/typeId/"+typeId+"/prodId/"+prodId+"/sid/"+sid;
            },	
            error:function(){
            	alert('保存失败');
            },				
		});
	});
	
	$("#cancelChange").click(function(){
		$(".prod input").eq(0).val(pdinfo.pname);
		$(".prod .sp-select").val(pdinfo.type_id);
		$(".prod input").eq(1).val(pdinfo.price);
		$(".prod input").eq(2).val(pdinfo.credit);
		$(".prod input").eq(4).val(pdinfo.description);
		$(".prod input").eq(5).val(pdinfo.stime);
		$(".prod input").eq(6).val(pdinfo.etime);
		$(".prod input").eq(7).val(pdinfo.instore);	
	});

	$("#delProd").click(function(){
		var prodId = $("#prod-id").html();
		if(confirm("您确定要删除商品吗？"))
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('productManager/delProduct'));?>",
                data: {'id':prodId},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id,'prodId'=>0,'sid'=>$this->currentStore->id));?>";
                },
                error:function(){
                	alert('删除失败');
                },				
			});
	});

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
			if(prodList[i].display=='block'){
				if(prodList[i].status=='未到期' || prodList[i].status=='已过期')
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+prodList[i].pname+"</div><div class='prod-price'>价格："
					+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+prodList[i].stime+"</span> 至<span class='label label-info'>"
					+prodList[i].etime+"</span></div></a><a class='grey-seal'>"
					+prodList[i].status+"</a></li>" +content;
				else
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+prodList[i].pname+"</div><div class='prod-price'>价格："
					+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+prodList[i].stime+"</span> 至<span class='label label-info'>"
					+prodList[i].etime+"</span></div></a><a class='seal'>"
					+prodList[i].status+"</a></li>" +content;
			}
		}
		$("#product-list").html(content);
	})
	

	$("#filt").change(function(){
		for (var i = 0; i < prodList.length; i++) {
			prodList[i].display = 'block';
		};
		var option = $(this).find("option:selected").text();
		switch(option){
			case '全部':
				for(var i=0;i<prodList.length;i++){
					prodList[i].display = 'block';
				}
				break;
			case '未到期':
				for(var i=0;i<prodList.length;i++){
					if(prodList[i].status!='未到期'){
						prodList[i].display='none';
					}
				}
				break;
			case '已上架':
				for(var i=0;i<prodList.length;i++){
					if(prodList[i].status!='已上架'){
						prodList[i].display='none';
					}
				}
				break;
			case '已下架':
				for(var i=0;i<prodList.length;i++){
					if(prodList[i].status!='已下架'){
						prodList[i].display='none';
					}
				}
				break;
			case '已过期':
				for(var i=0;i<prodList.length;i++){
					if(prodList[i].status!='已过期'){
						prodList[i].display='none';
					}
				}
				break;
			default:
				break;
		}
		var content="";
		for(var i=0;i<prodList.length;i++){
			if(prodList[i].display=='block')
				if(prodList[i].status=='未到期' || prodList[i].status=='已过期')
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+prodList[i].pname+"</div><div class='prod-price'>价格："
					+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+prodList[i].stime+"</span> 至<span class='label label-info'>"
					+prodList[i].etime+"</span></div></a><a class='grey-seal'>"
					+prodList[i].status+"</a></li>" +content;
				else
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
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
				var pageContent = "";
				for(var i=0;i<prodList.length;i++){
					if(prodList[i].pname.indexOf(content)>=0){
						if(prodList[i].status=='未到期' || prodList[i].status=='已过期')
							pageContent ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
							+prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
							+prodList[i].pname+"</div><div class='prod-price'>价格："
							+prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
							+prodList[i].stime+"</span> 至<span class='label label-info'>"
							+prodList[i].etime+"</span></div></a><a class='seal'>"
							+prodList[i].status+"</a></li>" +pageContent;
						else
							pageContent ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
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
            	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id,'prodId'=>0,'sid'=>$this->currentStore->id));?>";
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
            	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+"/typeId/"+typeId+'/prodId/0'+"/sid/"+sid;
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
            		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore,'sid':sid},
            dataType: 'json',
            
            success:function(json){
            	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id));?>"+"/prodId/"+json.prodId+"/sid/"+sid;
            },
            error:function(){
            	alert('添加商品失败');
            },				
		});
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
            	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id,'prodId'=>0,'sid'=>$this->currentStore->id));?>";
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
            	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id,'prodId'=>0,'sid'=>$this->currentStore->id));?>";
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
            	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$productType->id,'prodId'=>0,'sid'=>$this->currentStore->id));?>";
            },
            error:function(){
            	alert('保存失败');
            },				
		});
	});
});
function onImageItemClick(event){
	var source = event.target;
	$('#image-gallery-container-img img').remove();
	$('#image-gallery-container-img').append(
		'<img src="' + $(source).attr('src') + '" />'
	);
	$('#image-gallery').fadeIn('fast');
	imagetodel = parseInt($(source).parent().attr('name'));
}