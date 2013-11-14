/*全局常量*/
//店铺状态
var INNORMAL = 'innormal';
var NODELIVERY = 'nodelivery';
var ENCLOSED = 'enclosed';
//面板
var SORTCONTENT='sortcontent';
var PRODUCTCONTENT='productcontent';
var PAYCONTENT='paycontent';
var PAYSUCCESS='paysuccess';
//推荐类型
var RECSORT='recsort';
var RECPRODUCT='recproduct';

//基地址
var BASEURL='/weChat/img/wap/';

//单次订单最大数量
var LIMITORDERNUM=30;

/*全局变量*/
//运行特征值
var sortcontentscroll=0;
var productcontentscroll=0;
var paycontentscroll=0;
var orderidindex = 0;//orderarray的自增id
var currentsort = -1;//当前选中的sort类型
var lastcontent = '';
var currentcontent = '';
var ispayable=true;//是否服务中
var needdeliveryfee=false;//当前订单是否需要外送费
var issubmittable=false;//当前订单是否满足提交条件
var mytoasttimeout=null;
var myshowcontenttimeout=null;
var totalpay=0;
var totalordernum=0;

//源数据
var sellerid=-1;
var openid=-1;
var firstsortid=-1;
var sortarray = new Array();
var productarray = new Array
var deliveryareaarray = new Array();
var orderarray = new Array();
var recommendarray = new Array();
var myshopinfo=null;
var mypersonalinfo=null;

/*对象*/
function shopinfo(announcement1,shopstatus1,begintime1,endtime1,servertime1,isdeliveryfree1,sendingfee1,deliveryfee1,expecttime1){
	this.announcement = announcement1;
	this.shopstatus = shopstatus1;
	this.begintime=begintime1;
	this.endtime=endtime1;
	this.servertime=servertime1;
	this.isdeliveryfree=isdeliveryfree1;
	this.sendingfee=sendingfee1;
	this.deliveryfee=deliveryfee1;
	this.expecttime=expecttime1;
}
function sort(sortid1,sortname1,sortdesc1,sortimg1) {
	this.sortid = sortid1;
    this.sortname = sortname1;
    this.sortdesc = sortdesc1;
    this.sortimg = sortimg1;
    this.isrcommend = false;
}
function product(productid1,sortid1,price1,productname1,productleft1) {
	this.productid = productid1;
    this.sortid = sortid1;
    this.price = price1;
    this.productname = productname1;
    this.productleft = productleft1;
    this.isrcommend = false;
}
function deliveryarea(areaid1,areaname1,areadesc1,areastatus1){
	this.areaid=areaid1;
	this.areaname=areaname1;
	this.areadesc=areadesc1;
	this.areastatus=areastatus1;
}
function order(productid) {
	this.orderid = orderidindex;
    this.productid = productid;
    this.count = 0;
    orderidindex++;
}
function recommend(recommendid1,recommendtype1,recommendtag1,recommendimg1,objectid1){
	this.recommendid=recommendid1;
	this.recommendtype=recommendtype1;
	this.recommendtag=recommendtag1;
	this.recommendimg=recommendimg1;
	this.objectid=objectid1;
}
function personalinfo(name1,phonenumber1,areaid1,areadesc1,tips1){
	this.uesrname=name1;
	this.phonenumber=phonenumber1;
	this.areaid=areaid1;
	this.areadesc=areadesc1;
	this.tips=tips1;
}

/*数据初始化*/
function sortdatainit(){
	for(var i=0;i<sortdata.length;i++){
		sortarray[i]=new sort(sortdata[i].sortid,sortdata[i].sortname,sortdata[i].sortdesc,sortdata[i].sortimg);
	}
}

function productdatainit(){
	for(var i=0;i<productdata.length;i++){
		productarray[i]=new product(productdata[i].productid,productdata[i].sortid,productdata[i].price,productdata[i].productname,productdata[i].productleft);
	}
}

function deliveryareadatainit(){
	for(var i=0;i<deliveryareadata.length;i++){
		deliveryareaarray[i]=new deliveryarea(deliveryareadata[i].areaid,deliveryareadata[i].areaname,deliveryareadata[i].areadesc,deliveryareadata[i].areastatus);
	}
}

function recommenddatainit(){
	for(var i=0;i<recommenddata.length;i++){
		recommendarray[i]=new recommend(recommenddata[i].recommendid,recommenddata[i].recommendtype,recommenddata[i].recommendtag,recommenddata[i].recommendimg,recommenddata[i].objectid);
	}
}
function shopinfoinit(){
	myshopinfo=new shopinfo(shopinfodata.announcement,shopinfodata.shopstatus,shopinfodata.begintime,shopinfodata.endtime,shopinfodata.servertime,shopinfodata.isdeliveryfree,shopinfodata.sendingfee,shopinfodata.deliveryfee,shopinfodata.expecttime)
}

//获得缓存数据
function readhistory(){
	readorderlocal();
	readinfolocal();
}
//设置可付款状态
function payableinit(){
	if(myshopinfo.shopstatus==NODELIVERY||myshopinfo.shopstatus==ENCLOSED||myshopinfo.servertime<myshopinfo.begintime||myshopinfo.servertime>myshopinfo.endtime){
		ispayable=false;
	}
}


//全局数据准备
function firstinit(){
	var mybaseidarray=window.location.href.substr(window.location.href.indexOf('index/')+6).split('?');
	if(mybaseidarray.length==2){
		sellerid=mybaseidarray[0];
		openid=mybaseidarray[1];
	}else if(mybaseidarray.length==3){
		sellerid=mybaseidarray[0];
		openid=mybaseidarray[1];
		firstsortid=mybaseidarray[2]
	}
	// sellerid=$.getUrlParam('sellerid');
	// openid=$.getUrlParam('openid');
	sortdatainit();
    productdatainit();
    deliveryareadatainit();
    recommenddatainit();
    shopinfoinit();
    payableinit();
    readhistory();
    if(mybaseidarray.length==3){
    	callproduct(firstsortid);
    }else{
    	callsort();
    }
}

/*界面调取方法*/
function showsortcontent(){
	 $('#productcontent').hide();
	 $('#paycontent').hide();
	 $('#back-btn').hide();
	 $('#sort-btn').hide();
	 $('#pay-btn').show();
	 $('.waiting').show();
	 contentshow('#sortcontent');
}

function showproductcontent(sortid){
	 $('#sortcontent').hide();
	 $('#paycontent').hide();
	 $('#back-btn').hide();
	 $('#sort-btn').show();
	 $('#pay-btn').show();
	 $('.waiting').show();
	 contentshow('#productcontent',sortid);
	}

function showpaycontent(){
	 $('#sortcontent').hide();
	 $('#productcontent').hide();
	 $('#back-btn').show();
	 $('#sort-btn').hide();
	 $('#pay-btn').hide();
	 $('.waiting').show();
	 contentshow('#paycontent');
	}

function contentshow(content,sortid){
	var rightin=true;
	switch(content){
		case '#sortcontent':
		switch(currentcontent){
			case PAYCONTENT:
			rightin=false;
			break;
			case PRODUCTCONTENT:
			rightin=false;
			break;
		}
		break;
		case '#productcontent':
		switch(currentcontent){
			case PAYCONTENT:
			rightin=false;
			break;
		}
		break;
	}
	$(content).removeAttr('style');
	$(content).css('position','absolute');
	if(rightin){
		$(content).css('right','-100%');
	}else{
		$(content).css('left','-100%');
	}
	
	myshowcontenttimeout=setTimeout(function() {
		switch(content){
			case '#sortcontent':
			fillsortcontent();
			break;
			case '#productcontent':
			fillproductcontent(sortid);
			break;
			case '#paycontent':
			fillpaycontent();
			break;
		}
		$(content).show();
		if(rightin){
			$(content).css('right','0');
		}else{
			$(content).css('left','0');
		}
	    $(content).css('transition', 'all 200ms ease');
	    $(content).css('position','relative');
	    $('.waiting').hide();
	    switch(content){
	    	case '#sortcontent':
		    window.scrollTo(sortcontentscroll,0);
			break;
			case '#productcontent':
			if(sortid==currentsort){
				window.scrollTo(productcontentscroll,0);
			}else{
				window.scrollTo(0,0);
			}
			break;
			case '#paycontent':
			window.scrollTo(paycontentscroll,0);
			break;
		}
	}, 300);;
}


/*页面初始化类，初始化固定内容*/
function fillsortcontent(){
	lastcontent=currentcontent;
	currentcontent=SORTCONTENT;
	switch(myshopinfo.shopstatus){
		case INNORMAL:
		if(!(myshopinfo.servertime<myshopinfo.endtime&&myshopinfo.servertime>myshopinfo.begintime)){
			$('#tips-title-sort').html('休息中(￣o￣). z Z');
			if(myshopinfo.announcement!=''){
				var myannouncement='营业时间：'+myshopinfo.begintime+'-'+myshopinfo.endtime;
				myannouncement+='<br />今日公告：'+myshopinfo.announcement;
				$('#tips-announcement-sort').html(myannouncement);
			}else{
				var myannouncement='营业时间：'+begintime+'-'+endtime;
				$('#tips-announcement-sort').html(myannouncement);
			}
		}else if(myshopinfo.announcement!=''){
			$('#tips-title-sort').html('今日公告');
			$('#tips-announcement-sort').html(myshopinfo.announcement);
		}else{
			$('#tips-sortcontent').hide();
		}
		break;
		case NODELIVERY:
		$('#tips-title-sort').html('今天不能送外卖啦>_<');
		if(myshopinfo.announcement!=''){
			$('#tips-announcement-sort').html(myshopinfo.announcement);
		}else{
			$('#tips-announcement-sort').html('偷偷告诉你哦，实体店还是营业的，欢迎前来光临！');
		}
		break;
		case ENCLOSED:
		$('#tips-title-sort').html('歇业中>_<');
		if(myshopinfo.announcement!=''){
			$('#tips-announcement-sort').html(myshopinfo.announcement);
		}else{
			$('#tips-announcement-sort').html('今天不开张啦，改日再会哦~')
		}
		break;
		default:
		$('#tips-sortcontent').hide();
	}
	var insert='';
	for(var i =0;i<recommendarray.length;i++){
		if(recommendarray[i].recommendtype==RECSORT){
			for(var t=0;t<sortarray.length;t++){
				if(sortarray[t].sortid==recommendarray[i].objectid){
					insert+='<li>'+
					'<div calss="sort-item-rec" onclick = showproductcontent(\''+sortarray[t].sortid+'\') >'+
					'<img src="'+recommendarray[i].recommendimg+'"alt="image">'+
					'<h4>'+sortarray[t].sortname+'</h4>'+
					'<p>'+sortarray[t].sortdesc+'</p>'+
					'<p class="p-aside">'+recommendarray[i].recommendtag+'</p>'+
					'</div>'+
					'</li>';
					sortarray[t].isrcommend=true;
				}

			}
		}
	}
	$('#sort-recommendlist').html(insert);
	insert='';
	for(var i=0;i<sortarray.length;i++){
		if(sortarray[i].isrcommend==false){
			insert+='<li>'+
			'<div class="sort-item-nor" onclick = showproductcontent(\''+sortarray[i].sortid+'\')>'+
			'<img src="'+sortarray[i].sortimg+'">'+
			'<h4>'+sortarray[i].sortname+'</h4>'+
			'<p>'+sortarray[i].sortdesc+'</p>'+
			'<img src="'+BASEURL+'carat-r-purple.png" class="list-item-icon">'+
			'</div>'+
			'</li>';
		}
	}
	$('#sort-normallist').html(insert);
	setbtnshow(SORTCONTENT);

	//实时获得下滑位移
	// $(window).scroll(function() {
	// 	sortcontentscroll=$(this).scrollTop();
 //    });
}

function fillproductcontent(sortid1){
	var sortindex=findsortbyid(sortid1);
	var insert='';
	currentsort=sortid1;
	lastcontent=currentcontent;
	currentcontent=PRODUCTCONTENT;
	if(sortindex>=0){
		insert+='<li id="product-first-item"><h4 class="head-title">'+sortarray[sortindex].sortname+'</h4><p class="head-desc">'+sortarray[sortindex].sortdesc+'</p></li>'
	}
	for(var i=0;i<productarray.length;i++){
		if(productarray[i].sortid==sortid1){
			insert+='<li>'+
				'<div class="product-item" id="product-'+productarray[i].productid+'">'+
		        '<h4 class="head-title">'+productarray[i].productname+'</h4>'+
		        '<p class="head-desc">￥'+productarray[i].price+'</p>'+
	    		'<p class="p-aside2"></p>'+
	    		'<div class="tipsarea-in-list" disabled="disabled">'+
		    	'<p class="tips-in-list"></p>'+
		    	'</div>'+
	        	'<div class="button-group-inlist" >'+
		        '<button class="btn-icon button-minus" onclick=deleteorder(\''+productarray[i].productid+'\',\''+PRODUCTCONTENT+'\') style="display:inline"><img src="'+BASEURL+'minus-purple.png"></button>'+
		        '<button class="btn-icon button-plus" onclick=addorder(\''+productarray[i].productid+'\',\''+PRODUCTCONTENT+'\') style="display:inline"><img src="'+BASEURL+'plus-purple.png"></button>'+
	        	'</div>'+
        		'</div>'+
        		'</li>';
            }
		}
	
	$('#product-list').html(insert);
	setbtnshow(PRODUCTCONTENT);

	$(window).scroll(function() {
		productcontentscroll=$(this).scrollTop();
    });
}

function fillpaycontent(){
	lastcontent=currentcontent;
	currentcontent=PAYCONTENT;
	var myannouncement='送达时间：约'+myshopinfo.expecttime+'分钟';
	if(myshopinfo.deliveryfee>0&&myshopinfo.isdeliveryfree&&myshopinfo.sendingfee>0){
		myannouncement+='<br />外送费用：￥'+myshopinfo.deliveryfee+'（订单超过￥'+myshopinfo.sendingfee+'免外送费）';
	}else if(myshopinfo.deliveryfee>0&&!myshopinfo.isdeliveryfree&&myshopinfo.sendingfee>0){
		myannouncement+='<br />外送费用：￥'+myshopinfo.deliveryfee+'<br />起送价格：￥'+myshopinfo.sendingfee;
	}else if(myshopinfo.deliveryfee>0&&!(myshopinfo.sendingfee>0)){
		myannouncement+='<br />外送费用：￥'+myshopinfo.deliveryfee+'<br />起送价格：无';
	}else if(!(myshopinfo.deliveryfee>0)&&myshopinfo.sendingfee>0){
		myannouncement+='<br />外送费用：无<br />起送价格：￥'+myshopinfo.sendingfee;
	}else if(!(myshopinfo.deliveryfee>0)&&!(myshopinfo.sendingfee>0)){
		myannouncement+='<br />外送费用：无<br />起送价格：无';
	}
	$('#tips-announcement-order').html(myannouncement);

	var insert='';
	insert+='<li id="order-first-item"><h4 class="head-title"></h4><p class="head-desc"></p>'+
		'<button class="btn-icon-text" onclick=havelook() id="havelook-btn">'+
		'<p class="text-in-btn" id="havelook">去逛逛</p>'+
		'<img class="img-in-btn" src="'+BASEURL+'eye-purple.png">'+
		'</button>'+
		'<button class="btn-icon-text" onclick=toclearorder() id="clear-btn">'+
		'<p class="text-in-btn" id="clear">清空</p>'+
		'<img class="img-in-btn" src="'+BASEURL+'delete-purple.png">'+
		'</button>'+
		'</li>';
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				insert+='<li>'+
					'<div class="product-item" id="order-'+orderarray[i].productid+'">'+
			        '<h4 class="head-title">'+productarray[productindex].productname+'</h4>'+
			        '<p class="head-desc">￥'+productarray[productindex].price+'</p>'+
		    		'<p class="p-aside2" src="'+BASEURL+'flagtips-purple.png"></p>'+
		    		'<div class="tipsarea-in-list" disabled="disabled">'+
		    		'<p class="tips-in-list"></p>'+
		    		'</div>'+
		        	'<div class="button-group-inlist" >'+
			        '<button class="btn-icon button-minus" onclick=deleteorder(\''+orderarray[i].productid+'\',\''+PAYCONTENT+'\') style="display:inline"><img src="'+BASEURL+'minus-purple.png"></button>'+
			        '<button class="btn-icon button-plus" onclick=addorder(\''+orderarray[i].productid+'\',\''+PAYCONTENT+'\') style="display:inline"><img src="'+BASEURL+'plus-purple.png"></button>'+
		        	'</div>'+
	        		'</div>'+
	        		'</li>';
        	}else{
        		orderarray[i].count=0;
        	}
            }
		}
	
	$('#order-list').html(insert);
	setbtnshow(PAYCONTENT);

	$(window).scroll(function() {
		paycontentscroll=$(this).scrollTop();
    });
	//输入时禁用footer沉底
	$("input").focus(function(){
	    $(".footer-order").css('position','relative');
	});
	$("input").blur(function(){
	    $(".footer-order").css('position','fixed');
	});

	$("textarea").focus(function(){
	    $(".footer-order").css('position','relative');
	});
	$("textarea").blur(function(){
	    $(".footer-order").css('position','fixed');
	});

}

/*设定当前页面动态属性*/
function setbtnshow(contenttype){
	switch(contenttype){
		case SORTCONTENT:
		var mytotalpay=totalpay;
		if(ispayable==false){
    		$('#pay-btn').attr('disabled','disabled');
    		$('#pay-btn').children('p').html('休息中');
		}else{
    		$('#pay-btn').removeAttr('disabled');
			$('#pay-btn').children('p').html('结算 ￥'+mytotalpay);
		}
		break;
		case PRODUCTCONTENT:
		for(var i=0;i<productarray.length;i++){
			if(productarray[i].sortid==currentsort){
				var orderindex=findorderbyid(productarray[i].productid);
				if(ispayable==false){
					$('#product-'+productarray[i].productid).children('.p-aside2').hide();
					$('#product-'+productarray[i].productid).children('.tipsarea-in-list').show();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').hide();
					$('#product-'+productarray[i].productid).children('.tipsarea-in-list').children('p').html('休息中');
				}else if(orderindex<0){
					$('#product-'+productarray[i].productid).children('.p-aside2').hide();
					if(productarray[i].productleft<=0){
						$('#product-'+productarray[i].productid).children('.tipsarea-in-list').show();
						$('#product-'+productarray[i].productid).children('.button-group-inlist').hide();
						$('#product-'+productarray[i].productid).children('.tipsarea-in-list').children('p').html('已售罄');
					}else{
						$('#product-'+productarray[i].productid).children('.tipsarea-in-list').hide();
						$('#product-'+productarray[i].productid).children('.button-group-inlist').show();
						$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-minus').attr('disabled',true);
						$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-plus').attr('disabled',false);
					}
				}else if(orderarray[orderindex].count==0){
					$('#product-'+productarray[i].productid).children('.p-aside2').hide();
					$('#product-'+productarray[i].productid).children('.tipsarea-in-list').hide();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').show();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-minus').attr('disabled',true);
					$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-plus').attr('disabled',false);
				}else if(orderarray[orderindex].count>0&&orderarray[orderindex].count<productarray[i].productleft){
				
					$('#product-'+productarray[i].productid).children('.p-aside2').show();
					$('#product-'+productarray[i].productid).children('.tipsarea-in-list').hide();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').show();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-minus').attr('disabled',false);
					$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-plus').attr('disabled',false);
					var insert='已点数量:'+orderarray[orderindex].count;
					$('#product-'+productarray[i].productid).children('.p-aside2').html(insert);
				}else if(orderarray[orderindex].count==productarray[i].productleft){
					$('#product-'+productarray[i].productid).children('.p-aside2').show();
					$('#product-'+productarray[i].productid).children('.tipsarea-in-list').hide();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').show();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-minus').attr('disabled',false);
					$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-plus').attr('disabled',true);
					var insert='已点数量:'+orderarray[orderindex].count;
					$('#product-'+productarray[i].productid).children('.p-aside2').html(insert);
				}else if(orderarray[orderindex].count>productarray[i].productleft){
				
					$('#product-'+productarray[i].productid).children('.p-aside2').show();
					$('#product-'+productarray[i].productid).children('.tipsarea-in-list').hide();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').show();
					$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-minus').attr('disabled',false);
					$('#product-'+productarray[i].productid).children('.button-group-inlist').children('.button-plus').attr('disabled',true);
					var insert='已点数量:'+orderarray[orderindex].count;
					$('#product-'+productarray[i].productid).children('.p-aside2').html(insert);
				}
			}
		}
		var mytotalpay=totalpay;
		if(ispayable==false){
    		$('#pay-btn').attr('disabled','disabled');
    		$('#pay-btn').children('p').html('休息中');
		}else{
    		$('#pay-btn').removeAttr('disabled');
			$('#pay-btn').children('p').html('结算 ￥'+mytotalpay);
		}
		break;
		case PAYCONTENT:
		for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				if(ispayable==false){
					$('#order-'+orderarray[i].productid).children('.p-aside2').hide();
					$('#order-'+orderarray[i].productid).children('.tipsarea-in-list').show();
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').hide();
					$('#order-'+orderarray[i].productid).children('.tipsarea-in-list').children('p').html('休息中');
				}else if(orderarray[i].count>0&&orderarray[i].count<productarray[productindex].productleft){
					$('#order-'+orderarray[i].productid).children('.p-aside2').show();
					$('#order-'+orderarray[i].productid).children('.tipsarea-in-list').hide();
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').show();
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').children('.button-minus').attr('disabled',false);
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').children('.button-plus').attr('disabled',false);
					var insert='已点数量:'+orderarray[i].count;
					$('#order-'+orderarray[i].productid).children('.p-aside2').html(insert);
				}else if(orderarray[i].count==productarray[productindex].productleft){
					$('#order-'+orderarray[i].productid).children('.p-aside2').show();
					$('#order-'+orderarray[i].productid).children('.tipsarea-in-list').hide();
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').show();
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').children('.button-minus').attr('disabled',false);
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').children('.button-plus').attr('disabled',true);
					var insert='已点数量:'+orderarray[i].count;
					$('#order-'+orderarray[i].productid).children('.p-aside2').html(insert);
				}else if(orderarray[i].count>productarray[productindex].productleft){
					$('#order-'+orderarray[i].productid).children('.p-aside2').show();
					$('#order-'+orderarray[i].productid).children('.tipsarea-in-list').hide();
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').show();
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').children('.button-minus').attr('disabled',false);
					$('#order-'+orderarray[i].productid).children('.button-group-inlist').children('.button-plus').attr('disabled',true);
					var insert='已点数量:'+orderarray[i].count;
					$('#order-'+orderarray[i].productid).children('.p-aside2').html(insert);
				}
			}
		}
		}
		var mytotalpay=totalpay;
		if(ispayable==false){
    		$('#order-first-item').children('h4').html('休息中');
    		$('#order-first-item').children('p').html('当前无法交易');
    		$('#submit-btn').children('p').html('休息中');
			$('#submit-btn').attr('disabled',true);
		}else if(!(totalordernum>0)){
    		$('#order-first-item').children('h4').html('当前订单');
    		$('#order-first-item').children('p').html('您还没有选中任何订单');
    		$('#submit-btn').children('p').html('提交订单');
			$('#submit-btn').attr('disabled',false);
		}else{
    		$('#order-first-item').children('h4').html('当前订单');
    		if(needdeliveryfee){
    			$('#order-first-item').children('p').html('总计：￥'+mytotalpay+'（含外送费：￥'+myshopinfo.deliveryfee+'）');
    		}else{
    			$('#order-first-item').children('p').html('总计：￥'+mytotalpay);
    		}
    		$('#submit-btn').children('p').html('提交订单');
			$('#submit-btn').attr('disabled',false);
		}
		if((totalordernum>0)){
    		$('#clear-btn').show();
    		$('#havelook-btn').hide();
		}else{
			$('#clear-btn').hide();
    		$('#havelook-btn').show();
		}
		break;
	}
}


/*订单增减与清空*/
function deleteorder(productid,contenttype){
	var orderindex = findorderbyid(productid);
	var bechanged = false;
	var beclear = false;
	if(orderarray[orderindex].count>=1){
		orderarray[orderindex].count--;
		bechanged = true;
	}
	if(orderarray[orderindex].count==0){
		beclear=true;
	}
	if(bechanged){
		switch(contenttype){
			case PRODUCTCONTENT:
			writeorderlocal();
			setbtnshow(PRODUCTCONTENT);
			break;
			case PAYCONTENT:
			if(beclear){
				writeorderlocal();
				fillpaycontent();
			}else{
				writeorderlocal();
				setbtnshow(PAYCONTENT);
			}
			break;
		}
	}
}
function addorder(productid,contenttype){
	var productindex = findproductbyid(productid);
	var orderindex = findorderbyid(productid);
	var bechanged = false;
	if(totalordernum<LIMITORDERNUM){
		if(productindex>=0&&orderindex>=0){
			if(orderarray[orderindex].count>=0&&orderarray[orderindex].count<productarray[productindex].productleft){
				orderarray[orderindex].count++;
				bechanged = true;
				if(orderarray[orderindex].count==productarray[productindex].productleft){
				var tips='您选购的'+productarray[productindex].productname+'已达库存上限！';
				Toast(tips,2000);
			}
			}
		}else if(productindex>=0&&orderindex<0){
			var newindex = orderarray.length;
			orderarray[newindex]=new order(productid);
			orderarray[newindex].count++;
			bechanged = true;
			if(orderarray[newindex].count==productarray[productindex].productleft){
				var tips='您选购的'+productarray[productindex].productname+'已达库存上限！';
				Toast(tips,2000);
			}
		}
	}else{
		var tips='您的单次订单量已达上限！';
		Toast(tips,2000);
	}
	if(bechanged){
		switch(contenttype){
			case PRODUCTCONTENT:
			writeorderlocal();
			setbtnshow(PRODUCTCONTENT);
			break;
			case PAYCONTENT:
			writeorderlocal();
			setbtnshow(PAYCONTENT);
		}
	}
}
function clearorder(contenttype){
	orderarray=new Array();
	writeorderlocal();
	switch(contenttype){
		case PAYCONTENT:
		fillpaycontent();
		break;
	}
}


/*本地读写*/
//从本地读订单缓存
function readorderlocal(){
	if (localStorage) {
		if(localStorage.getItem(openid+'order')){
			var orderarraytemp=localStorage.getItem(openid+'order').split('&');
			for(var i=0;i<orderarraytemp.length;i++){
				var ordertemp=orderarraytemp[i].split('*');
				orderarray[i]=new order(ordertemp[0]);
				orderarray[i].count=ordertemp[1];
			}
		}
	}
	calctotalpay();
}
//向本地写订单缓存
function writeorderlocal(){
	if(localStorage){
		var orderstring='';
		for(var i=0;i<orderarray.length;i++){
			if(orderarray[i].count>0&&orderstring==''){
				orderstring+=orderarray[i].productid+'*'+orderarray[i].count;
			}else if(orderarray[i].count>0&&orderstring!=''){
				orderstring+='&';
				orderstring+=orderarray[i].productid+'*'+orderarray[i].count;
			}
		}
		localStorage.setItem(openid+'order',orderstring);
	}
	calctotalpay();
}

//从本地读收货信息缓存
function readinfolocal(){
	var insert='';
	for(var i=0;i<deliveryareaarray.length;i++){
		if(deliveryareaarray[i].areastatus==false){
			insert+='<option value="'+deliveryareaarray[i].areaid+'" disabled="disabled">'+deliveryareaarray[i].areaname+'</option>';
		}else{
			insert+='<option value="'+deliveryareaarray[i].areaid+'">'+deliveryareaarray[i].areaname+'</option>';
		}
	}
	$('#select-area').html(insert);
	if (localStorage) {
		if(localStorage.getItem(openid+'info')){
			var personalinfotemp=localStorage.getItem(openid+'info').split('&');
			mypersonalinfo=new personalinfo(personalinfotemp[0],personalinfotemp[1],personalinfotemp[2],personalinfotemp[3],null);
			$('#name').val(mypersonalinfo.uesrname);
			$('#number').val(mypersonalinfo.phonenumber);
			$('#select-area').val(mypersonalinfo.areaid);
			$('#areadesc').val(mypersonalinfo.areadesc);
		}
	}
	if(mypersonalinfo==null){
		mypersonalinfo=new personalinfo(null,null,null,null,null);
	}
	checkselect('#select-area');
}
//向本地写收货信息缓存
function writeinfolocal(){
	if(localStorage){
		var personalinfostring=mypersonalinfo.uesrname+'&'+mypersonalinfo.phonenumber+'&'+mypersonalinfo.areaid+'&'+mypersonalinfo.areadesc;
		localStorage.setItem(openid+'info',personalinfostring);
	}
}


/*工具方法*/
//查询语句
function findproductbyid(productid1){
	for(var i=0;i<productarray.length;i++){
		if(productarray[i].productid==productid1){
			return i;
			break;
		}
	}
	return -1;
}

function findorderbyid(productid1){
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].productid==productid1){
			return i;
			break;
		}
	}
	return -1;
}

function findsortbyid(sortid1){
	for(var i=0;i<sortarray.length;i++){
		if(sortarray[i].sortid==sortid1){
			return i;
			break;
		}
	}
	return -1;
}

function findarerbyid(areaid1){
	for(var i=0;i<deliveryareaarray.length;i++){
		if(deliveryareaarray[i].areaid==areaid1){
			return i;
			break;
		}
	}
	return -1;
}



//toast提示
function Toast(msg,duration){
	$('#mytoast').html(msg);
	$('#mytoast').show();
	$('#mytoast').css('left','0px');
    $('#mytoast').css('transition', 'all 200ms ease');
	duration=isNaN(duration)?3000:duration;
    clearTimeout(mytoasttimeout);
	mytoasttimeout=setTimeout(function() {
		$('#mytoast').removeAttr('style');
		$('#mytoast').css('display','none');
	}, duration);
}
//获取url参数
(function($){
    $.getUrlParam = function(name)
    {
        var reg = new RegExp("(^|&)"+ name +"?([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) return unescape(r[2]); return null; 
    }
})(jQuery);


//计算应付总价,兼检查是否需要外送费用和满足下单条件
function calctotalpay(){
	var pay=0;
	var mytotalordernum=0;
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				mytotalordernum+=parseInt(orderarray[i].count);
				pay+=productarray[productindex].price*orderarray[i].count;
			}
		}
	}
	if(pay<myshopinfo.sendingfee&&mytotalordernum>0&&myshopinfo.deliveryfee>0){
		pay+=parseInt(myshopinfo.deliveryfee);
		needdeliveryfee=true;
	}else if(pay>=myshopinfo.sendingfee&&mytotalordernum>0&&!myshopinfo.isdeliveryfree&&myshopinfo.deliveryfee>0){
		pay+=parseInt(myshopinfo.deliveryfee);
		needdeliveryfee=true;
	}else{
		needdeliveryfee=false;
	}
	if(pay<myshopinfo.sendingfee&&mytotalordernum>0&&myshopinfo.isdeliveryfree){
		issubmittable=true;
	}else if(pay>=myshopinfo.sendingfee&&mytotalordernum>0){
		issubmittable=true;
	}else{
		issubmittable=false;
	}
	totalpay=pay;
	totalordernum=mytotalordernum;
	return pay;
}



//事件调用函数
function callsort(){
	showsortcontent();
}

function callproduct(sortid){
	var mysortid=isNaN(sortid)?currentsort:sortid;
	showproductcontent(mysortid);
}

function payback(){
	switch(lastcontent){
		case SORTCONTENT:
		callsort();
		break;
		case PRODUCTCONTENT:
		callproduct();
		break;
		default:
		callsort();
	}
}

function topay(){
	showpaycontent();
}

function submit(){
		var products=new Array();
		var nums=new Array();
		var myindex=0;
		for(var i=0;i<orderarray.length;i++){
			var productindex=findproductbyid(orderarray[i].productid);
			if(orderarray[i].count>0&&productindex>=0){
				products[myindex]=orderarray[i].productid;
				nums[myindex]=orderarray[i].count;
				myindex++;
			}
		}
		if(!checkinput('#name')){
			Toast('请正确输入您的姓名',2000);
            $('#name').focus();
		}else if(!checkinput('#number')){
			Toast('请正确输入您的手机号或电话号码',2000);
            $('#number').focus();
		}else if(!checkselect('#select-area')){
			Toast('请选择合适的外送片区',2000);
		}else if(!checkinput('#areadesc')){
			Toast('请正确输入您的详细外送地址',2000);
            $('#areadesc').focus();
		}else if(!checkinput('#tips')){
			Toast('请正确输入您的备注',2000);
            $('#tips').focus();
		}else if(!(totalordernum>0)){
			Toast('您尚未选择任何商品',2000);
        	$('html, body').animate({scrollTop: 0}, 500);
		}else if(!issubmittable){
			Toast('您的订单尚未达到起送价格',2000);
        	$('html, body').animate({scrollTop: 0}, 500);
		}else{
			mypersonalinfo.uesrname=$('#name').val();
			mypersonalinfo.phonenumber=$('#number').val();
			mypersonalinfo.areaid=$('#select-area').val();
			mypersonalinfo.areadesc=$('#areadesc').val();
			mypersonalinfo.tips=$('#tips').val();
			writeinfolocal();
				$.ajax({
			        type:'POST',
			        dataType: 'json',
			        url:  'http://192.168.1.196/wcptf/index.php?r=mobile/order/order',
			        			        data:{sellerid:sellerid,openid:openid,name:mypersonalinfo.uesrname,phone:mypersonalinfo.phonenumber, areaid:mypersonalinfo.areaid,areadesc:mypersonalinfo.areadesc,tips:mypersonalinfo.tips, products:products, nums:nums},
			        success:function(data,textStatus){
			            if(data.success=='1'){
							Toast('下单成功',2000);
							clearorder(PAYCONTENT);
							paysuccess();
			            }
			            if(data.success=='0'){
							Toast('下单失败，若多次失败请尝试清空购物车并重新进入点单页面',4000);
			            }
			            if(data.success=='2'){
							Toast('下单失败，若多次失败请尝试清空购物车并重新进入点单页面',4000);
			            }
			        },
			        error:function(XMLHttpRequest,textStatus,errorThrown){    
			            if(textStatus=="timeout"){ 
							Toast('下单失败，若多次失败请尝试清空购物车并重新进入点单页面',4000);
			            }    
			        }  
			    });    
	  }

}

function paysuccess(){
	$.ajax({
        type:'POST',
        dataType: 'json',
        url:  'http://192.168.1.196/wcptf/index.php?r=mobile/order/getOrders',
        			        data:{sellerid:sellerid,openid:openid},
        success:function(data,textStatus){
            if(data.success=='1'){
            	$('.success').show();
            	$('#reload-btn').hide();
            	$('#newstart-btn').show();
            	$('#tips-ordersuccess').show();
            	var insert='';
            	if(data.result.length>0){
            		myindex=data.result.length-1;
            		insert+='订单号：'+data.result[myindex].order_no+
            		'<br />订单状态：'+data.result[myindex].status+
            		'<br />'+
            		'<br />联系人姓名：'+data.result[myindex].name+
            		'<br />联系人电话：'+data.result[myindex].phone+
            		'<br />收货地点：'+data.result[myindex].address+
            		'<br />下单时间：'+data.result[myindex].ctime+
            		'<br />'+
            		'<br />订单明细：'+data.result[myindex].order_items+
            		'<br />订单总价：'+data.result[myindex].total;
            	}
            	$('#tips-orderdesc-ordersuccess').html(insert);
            }
            if(data.success=='0'){
            	$('.success').show();
            	$('#reload-btn').show();
            	$('#newstart-btn').hide();
            	$('#tips-ordersuccess').hide();
            }
            if(data.success=='2'){
            	$('.success').show();
            	$('#reload-btn').show();
            	$('#newstart-btn').hide();
            	$('#tips-ordersuccess').hide();
            }
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){    
            if(textStatus=="timeout"){ 
            	$('.success').show();
            	$('#reload-btn').show();
            	$('#newstart-btn').hide();
            	$('#tips-ordersuccess').hide();
            }    
        }  
    });    
}
function toclearorder(){
	if (confirm('您确定清空购物车吗？')) { 
		clearorder(PAYCONTENT);
	}  
    else {  
    }
}
function havelook(){
	var max=sortarray.length-1;
	var luky=parseInt(Math.random()*(max+1));
	callproduct(luky);
}

function reloadcontent(){
	paysuccess();
}
function newstart(){
	location.reload();
}

//检查输入
function checkinput(element1) {
    if ($.trim($(element1).val()).length<=0&&$(element1).data('nonull')==true) {//输入框里值为空，或者为一些特定的文字时，都提示输入不能为空
		$(element1).prev('label').html('输入不能为空');
        return false;
    }else if($(element1).attr('type')=='tel'&&!checkphonenumber($(element1).val())){
    	$(element1).prev('label').html('请输入正确的手机号或电话号码');
    }else if($.trim($(element1).val()).length>$(element1).data('maxinput')){
    	$(element1).prev('label').html('输入过长（'+$(element1).data('maxinput')+'字以内）');
        return false;
    }else{
    	$(element1).prev('label').html('');
        return true;
    }
}

//检查电话输入
function checkphonenumber(number){
	String.prototype.isMobile = function() {  
		return (/^(1[3|4|5|8][0-9]\d{4,8})$/.test($.trim(this)));  
	} 

	String.prototype.isTel = function()
	{
	    return (/^((0\d{2,3})-?)?(\d{7,8})(-?(\d{3,}))?$/.test($.trim(this)));
	}
	if (number.isMobile()||number.isTel())  {  
            return true;  
        } 
        else {  
            return false;        
        } 
}

//修改选择框描述
function checkselect(element1){
	var areaindex=findarerbyid($(element1).val());
	if(areaindex>=0&&deliveryareaarray[areaindex].areastatus){
		$(element1).next('label').html(deliveryareaarray[areaindex].areadesc);
		$(element1).prev('label').html('');
		return true;
	}else {
		$(element1).next('label').html('');
		$(element1).prev('label').html('该片区今日不外送，请重新选择');
		return false;
	}
}
