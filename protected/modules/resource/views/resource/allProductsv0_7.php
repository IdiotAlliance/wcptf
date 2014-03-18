$(document).ready(function(event){
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
		if(window.PRODUCTS.isfocus){
			var target = event.target;
			var isin = false;
			while(!$(target).is('body')){
				if($(target).is("#change-area") || 
				   $(target).is('#image-gallery') ||
				   $(target).is('.datetimepicker') ||
				   $(target).is('#discount-manager')){
					isin = true;
				}
				target = $(target).parent();
			}
			if(!isin){
				window.PRODUCTS.isfocus = false;
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
				window.PRODUCTS.pdinfo.price = window.PRODUCTS.pdinfo.price+"￥";
				if(pname!=window.PRODUCTS.pdinfo.pname || typeId!=window.PRODUCTS.pdinfo.type_id || 
				   price!=window.PRODUCTS.pdinfo.price || credit!=window.PRODUCTS.pdinfo.credit || 
				   description!=window.PRODUCTS.pdinfo.description || stime!=window.PRODUCTS.pdinfo.stime ||
				   etime!=window.PRODUCTS.pdinfo.etime || instore!=window.PRODUCTS.pdinfo.instore){
						event.stopPropagation();
						event.preventDefault();						
					if(confirm("您对商品作了修改，在结束商品编辑前，请先保存商品")){
						$.ajax({
			                type: 'POST',
			                url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/updateProduct'));?>",
			                data: {'id':prodId,'pname':pname,'typeId':typeId,'price':price,
			                		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore
			            			//,'richtext':richtext
			            		  },
			                dataType: 'json',
			                
			                success:function(json){
								TOAST.success("保存成功！");
			                },	
			                error:function(){
			                	TOAST.err('保存失败');
			                },				
						})
					}else{
						window.PRODUCTS.isfocus = true;
					}
				}
			}
		}
	},true)


	/*图片上传*/
	var prodId = $("#prod-id").html();
	var btn =$(".cover-desc span");
	var showimg = $("#showimg");
	var wrap_content = "<form id='myupload' action='<?php echo Yii::app()->createUrl('/takeAway/productManager/coverUp');?>" + "/productId/" + prodId + "' method='post' enctype='multipart/form-data'></form>";
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
					    "action='<?php echo Yii::app()->createUrl('/takeAway/productManager/prodImgUp');?>/productId/" + prodId +
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
			url: '<?php echo Yii::app()->createUrl("/takeAway/productManager/delimg")?>/id/' + window.PRODUCTS.imagetodel,
			dataType: 'json',
			success: function(data){
				if(parseInt(data['count']) > 0){
					$('#image-gallery').fadeOut('fast');
					$('#imageitem_' + window.PRODUCTS.imagetodel).remove();
					TOAST.success("图片删除成功!");
				}
			},
			error: function(xhr){
				TOAST.err("删除失败");
				$('#image-gallery').fadeOut('fast');
			}
		});
	});
	

	/*类别图片上传*/
	var up = $(".type-img-desc span");
	var showTypeImg = $("#showTypeImg");
	var wrap_content = "<form id='myupload1' action='<?php echo Yii::app()->createUrl('/takeAway/productManager/typeImgUp/typeId');?>/" + window.PRODUCTS.typeId + "' method='post' enctype='multipart/form-data'></form>";
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
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/updateCategory'));?>",
            data: {'id': window.PRODUCTS.typeId,'changeDesc':changeDesc,
            'changeName':changeName},
            dataType: 'json',
            
            success:function(json){
				window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts/typeId')?>/" + window.PRODUCTS.typeId + "/prodId/0/sid/" + window.PRODUCTS.sid;
            },
            error:function(){
            	TOAST.warn('商品类别名重复');
            },
        })  
	})
	
	
	$("#delTypeNone").click(function(){
		if(confirm('您确定要删除该空类别吗')){
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/delTypeNone'));?>",
                data: {'id': window.PRODUCTS.typeId,'sid':window.PRODUCTS.sid},
                dataType: 'json',
                
                success:function(json){
                	if(json.empty == 1){
						window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/noProducts/sid/');?>" + window.PRODUCTS.sid;
					}else{
						window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>/typeId/" + json.id+"/prodId/0/sid/"+window.PRODUCTS.sid;
					}		            
				},
                error:function(){
                	TOAST.err('保存失败');
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
                url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/delCategory'));?>",
                data: {'newTypeId':choice,'deleteOr':deleteOr,'id':window.PRODUCTS.typeId,'sid':window.PRODUCTS.sid},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>"+"/typeId/"+choice+"/prodId/0"+"/sid/"+window.PRODUCTS.sid;
                },
                error:function(){
                	TOAST.err('保存失败');
                },				
			})
		}else{
			deleteOr = true;
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/delCategory'));?>",
                data: {'newTypeId':choice,'deleteOr':deleteOr,'id':window.PRODUCTS.typeId,'sid':window.PRODUCTS.sid},
                dataType: 'json',
                
                success:function(json){
                	if(json.empty == 1){
						window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/noProducts/sid/'); ?>" + window.PRODUCTS.sid;
					}else{
						window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>/typeId/" + json.id+"/prodId/0"+"/sid/"+window.PRODUCTS.sid;
					}
                },
                error:function(){
                	TOAST.err('保存失败');
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
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/getProduct'));?>",
            data: {'id':id},
            dataType: 'json',
            
            beforeSend:function(){
            	$("#loading").show();
            	$(".task-detail").hide();
            },
            success:function(json){
            	$(".task-detail").show();
            	$("#loading").hide();
            	var tmp = "<?php echo Yii::app()->createUrl('/takeAway/productManager/coverUp');?>"+"/productId/"+json.id;
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
    			$('.image-group .image-item-img').remove();
    			if(json.images){
    				for(i = 0; i < json.images.length; i ++){
    					var image = json.images[i];
    					var node  = $("<div class='image-item image-item-img' id='imageitem_" + image['id'] + "' name='" + image['id'] + "'><span class='image-item-img-container'></span><img src='<?php echo Yii::app()->baseUrl;?>/" + image['url'] + "' /></div>");
    					node.click(function(event){onImageItemClick(event);});
    					node.insertBefore('.image-item-add');
    				}
    			}
				// var wrap_content = "<form id='more_img_upload' " +
				// 				   "action='<?php echo Yii::app()->createUrl('/takeAway/productManager/prodImgUp');?>/productId/" + json.id +
				// 				   "' method='post' enctype='multipart/form-data'>" +
				// 				   "</form>";
				$('#moreimgupload').parent().attr("action", "<?php echo Yii::app()->createUrl('/takeAway/productManager/prodImgUp');?>/productId/" + json.id);
    			window.PRODUCTS.pdinfo = json;
    			prodId = window.PRODUCTS.pdinfo.id;
            },
            error:function(){
            	TOAST.err('获取产品失败！');
            },				
		});
	});

	$("#shelfProd").click(function(){
		var prodId = $("#prod-id").html();
		var shelf = $("#shelfProd").html();
		if(shelf == '上架产品'){
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/shelfProduct'));?>",
                data: {'id':prodId,'status':1},
                dataType: 'json',	                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts/typeId');?>/" + window.PRODUCTS.typeId +"/prodId/"+prodId+"/sid/"+window.PRODUCTS.sid;
                },
                error:function(){
                	TOAST.err('保存失败');
                },				
			});
		}
		else if(shelf=='下架产品'){
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/shelfProduct'));?>",
                data: {'id':prodId,'status':2},
                dataType: 'json',	                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts/typeId');?>/" + window.PRODUCTS.typeId + "/prodId/"+prodId+"/sid/"+window.PRODUCTS.sid;
                },
                error:function(){
                	TOAST.err('保存失败');
                },				
			});		
		}
	});
	
	$("#change-area").click(function(){
		window.PRODUCTS.isfocus = true;
	});

	$('#discount').click(function(){
		$('#discount-manager').fadeIn('fast');
		$('#discount-manager .discount-manager-item').remove();
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("/takeAway/productManager/getDiscounts")?>/pid/' + window.PRODUCTS.pdinfo.id,
			dataType: 'json',
			success: function(data){
				for(var i in data){
					$(
						"<div name='" + data[i]['id'] + "' class='discount-manager-item'>" +
							"<div class='discount-item-date'>" +
								"日期: " + data[i]['sdate'] + "&nbsp;到&nbsp;" + data[i]['edate'] +
							"</div>" +
							"<div class='discount-item-time'>" +
								"时间: " + data[i]['stime'] + "&nbsp;到&nbsp;" + data[i]['etime'] +
							"</div>" +
							"<div class='discount-item-delete' onclick='deleteDiscountItem(event)'>x</div>" +
						"</div>"
					).insertBefore('.discount-manager-edit');
				}
			},
			error: function(xhr){
				TOAST.err('无法获取数据');
				$('#discount-manager').fadeOut('fast');
			}
		});
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
		if(pname == null){
			TOAST.warn("商品名字不能为空");
			return;
		}
		else if(price==null){
			TOAST.warn("价格不能为空");
			return;
		}						
		else if(credit==null){
			TOAST.warn("积分不能为空");
			return;
		}						
		else if(instore==null){
			TOAST.warn("库存不能为空");
			return;
		}		
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/updateProduct'));?>",
            data: {'id':prodId,'pname':pname,'typeId':typeId,'price':price,
            		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore
            	 	// , 'richtext':richtext
            	  },
            dataType: 'json',
            
            success:function(json){
            	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>"+"/typeId/"+typeId+"/prodId/"+prodId+"/sid/"+window.PRODUCTS.sid;
            },	
            error:function(){
            	TOAST.err('保存失败');
            },				
		});
	});
	
	$("#cancelChange").click(function(){
		$(".prod input").eq(0).val(window.PRODUCTS.pdinfo.pname);
		$(".prod .sp-select").val(window.PRODUCTS.pdinfo.type_id);
		$(".prod input").eq(1).val(window.PRODUCTS.pdinfo.price);
		$(".prod input").eq(2).val(window.PRODUCTS.pdinfo.credit);
		$(".prod input").eq(4).val(window.PRODUCTS.pdinfo.description);
		$(".prod input").eq(5).val(window.PRODUCTS.pdinfo.stime);
		$(".prod input").eq(6).val(window.PRODUCTS.pdinfo.etime);
		$(".prod input").eq(7).val(window.PRODUCTS.pdinfo.instore);	
	});

	$("#delProd").click(function(){
		var prodId = $("#prod-id").html();
		if(confirm("您确定要删除商品吗？"))
			$.ajax({
                type: 'POST',
                url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/delProduct'));?>",
                data: {'id':prodId},
                dataType: 'json',
                
                success:function(json){
                	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>/typeId/" + window.PRODUCTS.typeId + "/prodId/0/sid/" + window.PRODUCTS.sid;
                },
                error:function(){
                	TOAST.err('删除失败');
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
		window.PRODUCTS.prodList = eval(window.PRODUCTS.prodList);

		var option = $(this).find("option:selected").text();
		switch(option){
			case '名称':
				sortByName(window.PRODUCTS.prodList);
				break;
			case '价格':
				sortByPrice(window.PRODUCTS.prodList);
				break;
			case '有效期起始':
				sortByStime(window.PRODUCTS.prodList);
				break;
			case '有效期终止':
				sortByEtime(window.PRODUCTS.prodList);
				break;
			default:
				break;
		}
		var content="";
		for(var i=0;i<window.PRODUCTS.prodList.length;i++){
			if(window.PRODUCTS.prodList[i].display=='block'){
				if(window.PRODUCTS.prodList[i].status=='未到期' || window.PRODUCTS.prodList[i].status=='已过期')
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+window.PRODUCTS.prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+window.PRODUCTS.prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+window.PRODUCTS.prodList[i].pname+"</div><div class='prod-price'>价格："
					+window.PRODUCTS.prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+window.PRODUCTS.prodList[i].stime+"</span> 至<span class='label label-info'>"
					+window.PRODUCTS.prodList[i].etime+"</span></div></a><a class='grey-seal'>"
					+window.PRODUCTS.prodList[i].status+"</a></li>" +content;
				else
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+window.PRODUCTS.prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+window.PRODUCTS.prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+window.PRODUCTS.prodList[i].pname+"</div><div class='prod-price'>价格："
					+window.PRODUCTS.prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+window.PRODUCTS.prodList[i].stime+"</span> 至<span class='label label-info'>"
					+window.PRODUCTS.prodList[i].etime+"</span></div></a><a class='seal'>"
					+window.PRODUCTS.prodList[i].status+"</a></li>" +content;
			}
		}
		$("#product-list").html(content);
	})
	

	$("#filt").change(function(){
		for (var i = 0; i < window.PRODUCTS.prodList.length; i++) {
			window.PRODUCTS.prodList[i].display = 'block';
		};
		var option = $(this).find("option:selected").text();
		switch(option){
			case '全部':
				for(var i=0;i<window.PRODUCTS.prodList.length;i++){
					window.PRODUCTS.prodList[i].display = 'block';
				}
				break;
			case '未到期':
				for(var i=0;i<window.PRODUCTS.prodList.length;i++){
					if(window.PRODUCTS.prodList[i].status!='未到期'){
						window.PRODUCTS.prodList[i].display='none';
					}
				}
				break;
			case '已上架':
				for(var i=0;i<window.PRODUCTS.prodList.length;i++){
					if(window.PRODUCTS.prodList[i].status!='已上架'){
						window.PRODUCTS.prodList[i].display='none';
					}
				}
				break;
			case '已下架':
				for(var i=0;i<window.PRODUCTS.prodList.length;i++){
					if(window.PRODUCTS.prodList[i].status!='已下架'){
						window.PRODUCTS.prodList[i].display='none';
					}
				}
				break;
			case '已过期':
				for(var i=0;i<window.PRODUCTS.prodList.length;i++){
					if(window.PRODUCTS.prodList[i].status!='已过期'){
						window.PRODUCTS.prodList[i].display='none';
					}
				}
				break;
			default:
				break;
		}
		var content="";
		for(var i=0;i<window.PRODUCTS.prodList.length;i++){
			if(window.PRODUCTS.prodList[i].display=='block')
				if(window.PRODUCTS.prodList[i].status=='未到期' || window.PRODUCTS.prodList[i].status=='已过期')
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+window.PRODUCTS.prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+window.PRODUCTS.prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+window.PRODUCTS.prodList[i].pname+"</div><div class='prod-price'>价格："
					+window.PRODUCTS.prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+window.PRODUCTS.prodList[i].stime+"</span> 至<span class='label label-info'>"
					+window.PRODUCTS.prodList[i].etime+"</span></div></a><a class='grey-seal'>"
					+window.PRODUCTS.prodList[i].status+"</a></li>" +content;
				else
					content ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+window.PRODUCTS.prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
					+window.PRODUCTS.prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
					+window.PRODUCTS.prodList[i].pname+"</div><div class='prod-price'>价格："
					+window.PRODUCTS.prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
					+window.PRODUCTS.prodList[i].stime+"</span> 至<span class='label label-info'>"
					+window.PRODUCTS.prodList[i].etime+"</span></div></a><a class='seal'>"
					+window.PRODUCTS.prodList[i].status+"</a></li>" +content;
		}
		$("#product-list").html(content);
	})

	$("#search").keyup(function(event){
		var key = event.which;
		var content = $("#search").val();
		if(key == 13){
			if(content==null)
				TOAST.warn("搜索内容那个不能为空");
			else{
				var pageContent = "";
				for(var i=0;i<window.PRODUCTS.prodList.length;i++){
					if(window.PRODUCTS.prodList[i].pname.indexOf(content)>=0){
						if(window.PRODUCTS.prodList[i].status=='未到期' || window.PRODUCTS.prodList[i].status=='已过期')
							pageContent ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+window.PRODUCTS.prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
							+window.PRODUCTS.prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
							+window.PRODUCTS.prodList[i].pname+"</div><div class='prod-price'>价格："
							+window.PRODUCTS.prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
							+window.PRODUCTS.prodList[i].stime+"</span> 至<span class='label label-info'>"
							+window.PRODUCTS.prodList[i].etime+"</span></div></a><a class='seal'>"
							+window.PRODUCTS.prodList[i].status+"</a></li>" +pageContent;
						else
							pageContent ="<li class='product'><div class='left shift'><input name='chkItem' type='checkbox' value='"+window.PRODUCTS.prodList[i].id+"'></div><img class='img-rounded left avatar' src='<?php echo Yii::app()->baseUrl;?>"+"/"
							+window.PRODUCTS.prodList[i].cover+"'><a class='left prod-link'><div class='prod-name'>"
							+window.PRODUCTS.prodList[i].pname+"</div><div class='prod-price'>价格："
							+window.PRODUCTS.prodList[i].price+"</div><div class='prod-price'>有效期：<span class='label label-info'>"
							+window.PRODUCTS.prodList[i].stime+"</span> 至<span class='label label-info'>"
							+window.PRODUCTS.prodList[i].etime+"</span></div></a><a class='grey-seal'>"
							+window.PRODUCTS.prodList[i].status+"</a></li>" +pageContent;								
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
			TOAST.warn("请选中某一商品");
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
			TOAST.warn("请选中某一商品");
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/batchStock'));?>",
            data: {'stock':stock,'idList':idList},
            dataType: 'json',
            
            success:function(json){
            	$("#stockModal").modal('hide');
            	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>/typeId/" + window.PRODUCTS.typeId + "/prodId/0/sid/" + window.PRODUCTS.sid;
            },
            error:function(){
            	TOAST.err('保存失败');
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
			TOAST.warn("请选中某一商品");
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/batchCategory'));?>",
            data: {'newTypeId':typeId,'idList':idList},
            dataType: 'json',
            
            success:function(json){
            	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>"+"/typeId/"+window.PRODUCTS.typeId+'/prodId/0'+"/sid/"+window.PRODUCTS.sid;
            },
            error:function(){
            	TOAST.err('保存失败');
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
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/addProduct'));?>",
            data: {'pname':pname,'typeId':window.PRODUCTS.typeId,'price':price,
            		'credit':credit,'description':description,'stime':stime,'etime':etime,'instore':instore,'sid':window.PRODUCTS.sid},
            dataType: 'json',
            
            success:function(json){
            	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>/typeId/"+ window.PRODUCTS.typeId +"/prodId/"+json.prodId+"/sid/"+ window.PRODUCTS.sid;
            },
            error:function(){
            	TOAST.err('添加商品失败');
            },				
		});
	});

	$("#popup li a").eq(2).click(function(){
		var idList = [];
		var size = $("#product-list input:checkbox").length;
		var count = 0;
		var status = false;
		var pdList = window.PRODUCTS.prodList;

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
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/batchShelf'));?>",
            data: {'status':1,'idList':idList},
            dataType: 'json',
            
            success:function(json){
            	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>" +"/typeId/"+window.PRODUCTS.typeId+'/prodId/0'+"/sid/"+window.PRODUCTS.sid;
            },
            error:function(){
            	TOAST.err('保存失败');
            },				
		})
	})
	
	$("#popup li a").eq(3).click(function(){
		var idList = [];
		var size = $("#product-list input:checkbox").length;
		var count = 0;
		var status = false;
		var pdList = window.PRODUCTS.prodList;

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
			TOAST.warn("请选中某一商品");
		if(status)
			alert("您选中的商品有未到期或已过期的，只有有效期范围内的商品才能下架");
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/batchShelf'));?>",
            data: {'status':2,'idList':idList},
            dataType: 'json',
            
            success:function(json){
            	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>" +"/typeId/"+window.PRODUCTS.typeId+'/prodId/0'+"/sid/"+window.PRODUCTS.sid;
            },
            error:function(){
            	TOAST.err('保存失败');
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
			TOAST.warn("请选中某一商品");
		$.ajax({
            type: 'POST',
            url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/batchDel'));?>",
            data: {'idList':idList},
            dataType: 'json',
            
            success:function(json){
            	window.location.href = "<?php echo Yii::app()->createUrl('/takeAway/productManager/allProducts');?>" +"/typeId/"+window.PRODUCTS.typeId+'/prodId/0'+"/sid/"+window.PRODUCTS.sid;
            },
            error:function(){
            	TOAST.err('保存失败');
            },				
		});
	});
	$('#sdate_picker').datetimepicker({
		format:'yyyy-mm-dd',
		autoclose:true,
		minView:2,
		language:'zh-CN'});
	$('#edate_picker').datetimepicker({
		format:'yyyy-mm-dd',
		autoclose:true,
		minView:2,
		language:'zh-CN'
	});
	$('#stime_picker').datetimepicker({
		format:'hh:ii',
		autoclose:true,
		minView:0,
		startView: 1,
		language:'zh-CN'
	});
	$('#etime_picker').datetimepicker({
		format:'hh:ii',
		autoclose:true,
		minView:0,
		startView: 1,
		language:'zh-CN'
	});
	$('#discount-close').click(function(){
		$('#discount-manager').fadeOut('fast');
	});
	$('#discount-cancel').click(function(){
		clearDiscountEditor();
	});
	$('#discount-save').click(function(){
		sdate = $('#sdate_picker').val();
		edate = $('#edate_picker').val();
		stime =	$('#stime_picker').val();
		etime = $('#etime_picker').val();
		if(sdate && edate && sdate != '' && edate != null && sdate < edate){
			console.log(edate);
			if(stime && etime && stime != '' && etime != '' && stime < etime){
				$.ajax({
					url: '<?php echo Yii::app()->createUrl("/takeAway/productManager/addDiscount")?>',
					type: 'post',
					data: {'pid': window.PRODUCTS.pdinfo.id, 'sdate': sdate, 'edate': edate, 'stime': stime, 'etime': etime},
					success: function(data){
						console.log(data);
						if(data && parseInt(data) > 0){
							TOAST.success('保存成功');
							$(
								"<div name='" + data + "' class='discount-manager-item'>" +
									"<div class='discount-item-date'>" +
										"日期: " + sdate + "&nbsp;到&nbsp;" + edate +
									"</div>" +
									"<div class='discount-item-time'>" +
										"时间: " + stime + "&nbsp;到&nbsp;" + etime +
									"</div>" +
									"<div class='discount-item-delete' onclick='deleteDiscountItem(event)'>x</div>" +
								"</div>"
							).insertBefore(".discount-manager-edit");
						}else{
							console.log('234');
							TOAST.err('保存失败');
						}
					},
					error: function(xhr){
						console.log('123');
						TOAST.err('保存失败');
					}
				});
			}else{
				TOAST.warn('无效的时间');
			}
		}else{
			TOAST.warn('无效的日期');
		}
	});
});
function onImageItemClick(event){
	var source = event.target;
	$('#image-gallery-container-img img').remove();
	$('#image-gallery-container-img').append(
		'<img src="' + $(source).attr('src') + '" />'
	);
	$('#image-gallery').fadeIn('fast');
	window.PRODUCTS.imagetodel = parseInt($(source).parent().attr('name'));
}
function clearDiscountEditor(){
	$('#sdate_picker').val('');
	$('#edate_picker').val('');
	$('#stime_picker').val('');
	$('#etime_picker').val('');
}
function addDiscountItem(sdate, edate, stime, etime){
	
}
function getDate(){
	d = new Date();
	return (d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate());
}
function deleteDiscountItem(event){
	target = event.target;
		id = $(target).parent().attr('name');
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('/takeAway/productManager/deleteDiscount')?>/id/" + id,
			success: function(data){
				$(target).parent().remove();
				TOAST.success('删除成功');
			},
			error: function(){
				TOAST.err('删除失败');
			}
		});
}