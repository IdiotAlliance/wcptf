var INNORMAL = 'innormal';
var NODELIVERY = 'nodelivery';
var ENCLOSED = 'enclosed';

var SORTCONTENT='sortcontent';
var PRODUCTCONTENT='productcontent';
var ORDERCONTENT='ordercontent';
var PAYCONTENT='paycontent';
var PAYSUCCESS='paysuccess';

var RECSORT='recsort';
var RECPRODUCT='recproduct';

var limitordernum=20;

var orderidindex = 0;
var currentsort = -1;
var lastcontent = '';
var ispayable=true;
var needdeliveryfee=false;
var mytoasttimeout=null;

var openid='';
var sortarray = new Array();
var productarray = new Array
var deliveryareaarray = new Array();
var orderarray = new Array();
var recommendarray = new Array();
var myshopinfo=null;
var mypersonalinfo=null;

/*对象方法*/
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
	openid=window.location.hash;//获得openid
	sortdatainit();
    productdatainit();
    deliveryareadatainit();
    recommenddatainit();
    shopinfoinit();
    payableinit();
    readhistory();
}
/*界面调取方法*/
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
	}
}

function topay(){
	showpaycontent();
}

function showsortcontent(){
	 $("#sortcontent").show();
	 fillsortcontent();
	 $("#productcontent").hide();
	 $("#paycontent").hide();
	 $("#back-btn").hide();
	 $("#sort-btn").hide();
	 $("#pay-btn").show();
}

function showproductcontent(sortid){
	 $("#productcontent").show();
	 fillproductcontent(sortid);
	 $("#sortcontent").hide();
	 $("#paycontent").hide();
	 $("#back-btn").hide();
	 $("#sort-btn").show();
	 $("#pay-btn").show();
	}

function showpaycontent(){
	 $("#sortcontent").hide();
	 $("#productcontent").hide();
	 $("#paycontent").show();
	 $("#back-btn").show();
	 $("#sort-btn").hide();
	 $("#pay-btn").hide();
	 fillordercontent();
	}

/*页面初始化类*/
function fillsortcontent(){
	switch(myshopinfo.shopstatus)
		{
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
			'<img src="_assets/img/carat-r-purple.png" class="list-item-icon">'+
			'</div>'+
			'</li>';
		}
	}
	$('#sort-normallist').html(insert);
	lastcontent=SORTCONTENT;
	setbtnshow(SORTCONTENT);
	// insert=insert+'</ul>';
	// $("#sortcontent").append(insert);
    // check_sortcontent();
    // $("#recommendlist").listview('refresh');
}

function fillproductcontent(sortid1){
	var sortindex=findsortbyid(sortid1);
	var insert='';
	currentsort=sortid1;
	if(sortindex>=0){
		insert+='<li id="product-first-item"><h4>'+sortarray[sortindex].sortname+'</h4><p>'+sortarray[sortindex].sortdesc+'</p></li>'
	}
	for(var i=0;i<productarray.length;i++){
		if(productarray[i].sortid==sortid1){
			insert+='<li>'+
				'<div class="product-item" id="product-'+productarray[i].productid+'">'+
		        '<h4>'+productarray[i].productname+'</h4>'+
		        '<p>￥'+productarray[i].price+'</p>'+
	    		'<p class="p-aside2"></p>'+
	    		'<button class="btn-icon button-single-inlist" disabled="true">'+
	    		'<p class="text-in-btn"></p>'+
	    		'</button>'+
	        	'<div class="button-group-inlist" >'+
		        '<button class="btn-icon button-minus" onclick=deleteorder(\''+productarray[i].productid+'\',\''+PRODUCTCONTENT+'\') style="display:inline"><img src="_assets/img/minus-purple.png"></button>'+
		        '<button class="btn-icon button-plus" onclick=addorder(\''+productarray[i].productid+'\',\''+PRODUCTCONTENT+'\') style="display:inline"><img src="_assets/img/plus-purple.png"></button>'+
	        	'</div>'+
        		'</div>'+
        		'</li>';
            }
		}
	
	$('#product-list').html(insert);
	lastcontent=PRODUCTCONTENT;
	setbtnshow(PRODUCTCONTENT);
}

function fillordercontent(){
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
	insert+='<li id="order-first-item"><h4></h4><p></p>'+
		'<button class="btn-icon-text" onclick=havelook() id="havelook-btn">'+
		'<p class="text-in-btn" id="havelook">去逛逛</p>'+
		'<img class="img-in-btn" src="_assets/img/eye-purple.png">'+
		'</button>'+
		'<button class="btn-icon-text" onclick=toclearorder() id="clear-btn">'+
		'<p class="text-in-btn" id="clear">清空</p>'+
		'<img class="img-in-btn" src="_assets/img/delete-purple.png">'+
		'</button>'+
		'</li>';
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				insert+='<li>'+
					'<div class="product-item" id="order-'+orderarray[i].productid+'">'+
			        '<h4>'+productarray[productindex].productname+'</h4>'+
			        '<p>￥'+productarray[productindex].price+'</p>'+
		    		'<p class="p-aside2" src="_assets/img/flagtips-purple.png"></p>'+
		    		'<button class="btn-icon button-single-inlist" disabled="true">'+
		    		'<p class="text-in-btn"></p>'+
		    		'</button>'+
		        	'<div class="button-group-inlist" >'+
			        '<button class="btn-icon button-minus" onclick=deleteorder(\''+orderarray[i].productid+'\',\''+ORDERCONTENT+'\') style="display:inline"><img src="_assets/img/minus-purple.png"></button>'+
			        '<button class="btn-icon button-plus" onclick=addorder(\''+orderarray[i].productid+'\',\''+ORDERCONTENT+'\') style="display:inline"><img src="_assets/img/plus-purple.png"></button>'+
		        	'</div>'+
	        		'</div>'+
	        		'</li>';
        	}else{
        		orderarray[i].count=0;
        	}
            }
		}
	
	$('#order-list').html(insert);
	setbtnshow(ORDERCONTENT);

}

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
			case ORDERCONTENT:
			if(beclear){
				writeorderlocal();
				fillordercontent();
			}else{
				writeorderlocal();
				setbtnshow(ORDERCONTENT);
			}
			break;


		}
	}
}
function addorder(productid,contenttype){
	var productindex = findproductbyid(productid);
	var orderindex = findorderbyid(productid);
	var bechanged = false;
	var mytotalordernum=totalordernum();
	if(mytotalordernum<=limitordernum){
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
			case ORDERCONTENT:
			writeorderlocal();
			setbtnshow(ORDERCONTENT);
		}
	}
}

function clearorder(){
	orderarray=new Array();
	writeorderlocal();
}
/*查询语句*/
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

/*工具方法*/
function setshopstatus(){

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

//设定当前页面按钮属性
function setbtnshow(contenttype){
	switch(contenttype){
		case SORTCONTENT:
		var mytotalpay=totalpay();
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
					$('#product-'+i).children('.p-aside2').hide();
					$('#product-'+i).children('.button-single-inlist').show();
					$('#product-'+i).children('.button-group-inlist').hide();
					$('#product-'+i).children('.button-single-inlist').children('p').html('休息中');
				}else if(orderindex<0){
					$('#product-'+i).children('.p-aside2').hide();
					if(productarray[i].productleft<=0){
						$('#product-'+i).children('.button-single-inlist').show();
						$('#product-'+i).children('.button-group-inlist').hide();
						$('#product-'+i).children('.button-single-inlist').children('p').html('已售罄');
					}else{
						$('#product-'+i).children('.button-single-inlist').hide();
						$('#product-'+i).children('.button-group-inlist').show();
						$('#product-'+i).children('.button-minus').attr('disabled',true);
						$('#product-'+i).children('.button-plus').attr('disabled',false);
					}
				}else if(orderarray[orderindex].count==0){
					$('#product-'+i).children('.p-aside2').hide();
					$('#product-'+i).children('.button-single-inlist').hide();
					$('#product-'+i).children('.button-group-inlist').show();
					$('#product-'+i).children('.button-minus').attr('disabled',true);
					$('#product-'+i).children('.button-plus').attr('disabled',false);
				}else if(orderarray[orderindex].count>0&&orderarray[orderindex].count<productarray[i].productleft){
				
					$('#product-'+i).children('.p-aside2').show();
					$('#product-'+i).children('.button-single-inlist').hide();
					$('#product-'+i).children('.button-group-inlist').show();
					$('#product-'+i).children('.button-minus').attr('disabled',false);
					$('#product-'+i).children('.button-plus').attr('disabled',false);
					var insert='已点数量:'+orderarray[orderindex].count;
					$('#product-'+i).children('.p-aside2').html(insert);
				}else if(orderarray[orderindex].count==productarray[i].productleft){
					$('#product-'+i).children('.p-aside2').show();
					$('#product-'+i).children('.button-single-inlist').hide();
					$('#product-'+i).children('.button-group-inlist').show();
					$('#product-'+i).children('.button-minus').attr('disabled',false);
					$('#product-'+i).children('.button-plus').attr('disabled',true);
					var insert='已点数量:'+orderarray[orderindex].count;
					$('#product-'+i).children('.p-aside2').html(insert);
				}else if(orderarray[orderindex].count>productarray[i].productleft){
				
					$('#product-'+i).children('.p-aside2').show();
					$('#product-'+i).children('.button-single-inlist').hide();
					$('#product-'+i).children('.button-group-inlist').show();
					$('#product-'+i).children('.button-minus').attr('disabled',false);
					$('#product-'+i).children('.button-plus').attr('disabled',true);
					var insert='已点数量:'+orderarray[orderindex].count;
					$('#product-'+i).children('.p-aside2').html(insert);
				}
			}
		}
		var mytotalpay=totalpay();
		if(ispayable==false){
    		$('#pay-btn').attr('disabled','disabled');
    		$('#pay-btn').children('p').html('休息中');
		}else{
    		$('#pay-btn').removeAttr('disabled');
			$('#pay-btn').children('p').html('结算 ￥'+mytotalpay);
		}
		break;
		case ORDERCONTENT:
		for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				if(ispayable==false){
					$('#order-'+productindex).children('.p-aside2').hide();
					$('#order-'+productindex).children('.button-single-inlist').show();
					$('#order-'+productindex).children('.button-group-inlist').hide();
					$('#order-'+productindex).children('.button-single-inlist').children('p').html('休息中');
				}else if(orderarray[i].count>0&&orderarray[i].count<productarray[productindex].productleft){
				
					$('#order-'+productindex).children('.p-aside2').show();
					$('#order-'+productindex).children('.button-single-inlist').hide();
					$('#order-'+productindex).children('.button-group-inlist').show();
					$('#order-'+productindex).children('.button-minus').attr('disabled',false);
					$('#order-'+productindex).children('.button-plus').attr('disabled',false);
					var insert='已点数量:'+orderarray[i].count;
					$('#order-'+productindex).children('.p-aside2').html(insert);
				}else if(orderarray[i].count==productarray[productindex].productleft){
				
					$('#order-'+productindex).children('.p-aside2').show();
					$('#order-'+productindex).children('.button-single-inlist').hide();
					$('#order-'+productindex).children('.button-group-inlist').show();
					$('#order-'+productindex).children('.button-minus').attr('disabled',false);
					$('#order-'+productindex).children('.button-plus').attr('disabled',true);
					var insert='已点数量:'+orderarray[i].count;
					$('#order-'+productindex).children('.p-aside2').html(insert);
				}else if(orderarray[i].count>productarray[productindex].productleft){
				
					$('#order-'+productindex).children('.p-aside2').show();
					$('#order-'+productindex).children('.button-single-inlist').hide();
					$('#order-'+productindex).children('.button-group-inlist').show();
					$('#order-'+productindex).children('.button-minus').attr('disabled',false);
					$('#order-'+productindex).children('.button-plus').attr('disabled',true);
					var insert='已点数量:'+orderarray[i].count;
					$('#order-'+productindex).children('.p-aside2').html(insert);
				}
			}
		}
		}
		var mytotalpay=totalpay();
		var myhavevalidorder=havevalidorder();
		if(ispayable==false){
    		$('#order-first-item').children('h4').html('休息中');
    		$('#order-first-item').children('p').html('当前无法交易');
    		$('#submit-btn').children('p').html('休息中');
			$('#submit-btn').attr('disabled',true);
		}else if(!myhavevalidorder){
    		$('#order-first-item').children('h4').html('当前订单');
    		$('#order-first-item').children('p').html('您还没有选中任何订单');
    		$('#submit-btn').children('p').html('提交订单');
			$('#submit-btn').attr('disabled',true);
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
		if(myhavevalidorder){
    		$('#clear-btn').show();
    		$('#havelook-btn').hide();
		}else{
			$('#clear-btn').hide();
    		$('#havelook-btn').show();
		}
		break;
	}
}
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
}
//向本地写订单缓存
function writeorderlocal(){
	if(localStorage){
		var orderstring='';
		for(var i=0;i<orderarray.length;i++){
			if(orderarray[i].count>=0&&orderstring==''){
				orderstring+=orderarray[i].productid+'*'+orderarray[i].count;
			}else if(orderarray[i].count>=0&&orderstring!=''){
				orderstring+='&';
				orderstring+=orderarray[i].productid+'*'+orderarray[i].count;
			}
		}
		localStorage.setItem(openid+'order',orderstring);
	}
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
}
//向本地写收货信息缓存
function writeinfolocal(){
	if(localStorage){
		var personalinfostring=mypersonalinfo.uesrname+'&'+mypersonalinfo.phonenumber+'&'+mypersonalinfo.areaid+'&'+mypersonalinfo.areadesc;
		localStorage.setItem(openid+'info',personalinfostring);
	}
}


//计算应付总价
function totalpay(){
	var pay=0;
	var ordernum=0;
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				pay+=productarray[productindex].price*orderarray[i].count;
				ordernum+=parseInt(orderarray[i].count);
			}
		}
	}
	if(pay<myshopinfo.sendingfee&&ordernum>0&&myshopinfo.deliveryfee>0){
		pay+=parseInt(myshopinfo.deliveryfee);
		needdeliveryfee=true;
	}else if(pay>=myshopinfo.sendingfee&&!myshopinfo.isdeliveryfree&&myshopinfo.deliveryfee>0){
		pay+=parseInt(myshopinfo.deliveryfee);
		needdeliveryfee=true;
	}else{
		needdeliveryfee=false;
	}
	return pay;
}
// //计算每订单商品总价
// function productpay(productid){
// 	var pay=0;
// 	var productindex = findproductbyid(productid);
// 	var orderindex = findorderbyid(productid);
// 	if(productindex>=0&&orderindex>=0){
// 		pay = productarray[productindex].price*orderarray[orderindex].count;
// 	}
// 	return pay;
// }

//计算总订单数量
function totalordernum(){
	var ordernum=0;
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				ordernum+=parseInt(orderarray[i].count);
			}
		}
	}
	return ordernum;
}

function havevalidorder(){
	var haveorder=false;
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				haveorder=true;
			}
		}
	}
	return haveorder;
}


function submit(){
	
		var products=new Array();
		var nums=new Array();
		var myindex=0;
		for(var i=0;i<orderarray.length;i++){
			if(orderarray[i].count>0){
				products[myindex]=orderarray[i].productid;
				nums[myindex]=orderarray[i].count;
				myindex++;
			}
		}
		if($('#name').val()==''){
			Toast('请输入您的姓名',2000);
		}else if($('#number').val()==''){
			Toast('请输入您的电话号码',2000);
		}else if($('#select-area').val()==''){
			Toast('请选择外送片区',2000);
		}else if($('#areadesc').val()==''){
			Toast('请输入您的详细外送地址',2000);
		}else{

			mypersonalinfo.uesrname=$('#name').val();
			mypersonalinfo.phonenumber=$('#number').val();
			mypersonalinfo.areaid=$('#select-area').val();
			mypersonalinfo.areadesc=$('#areadesc').val();
			writeinfolocal();
			Toast('下单成功',2000);

        
        //利用对话框返回的值 （true 或者 false） 
		}

		 // $.ajax({
			//         type:'POST',
			//         dataType: 'json',
			//         url:  '/wcptf/index.php?r=mobile/orderController/makeOrder',
			//         timeout: 60000,
			//         data:{openid:openid,name:$('#name').val(),phone:$('#number').val(), areaid:$('#select-area').val(),areadesc:$('#areadesc').val(), products:products, nums:nums},
			//         success:function(data,textStatus){
			//             if(data.success=='1'){
			//             	alert('下单成功');
			// 				orderarray=new Array();
			// 				fillordercontent();
			//             }
			//             if(data.success=='0'){
			//             	alert('下单失败');
			//             }
			//         },
			//         error:function(XMLHttpRequest,textStatus,errorThrown){    
			//             if(textStatus=="timeout"){ 
			//             	alert('连接超时');
			//             }    
			//         }  
			//     });  
			//     }     

			// if (confirm("你确定提交吗？")) {    
	  //       }  
	  //       else {  
	  //       }  

}
function toclearorder(){
	clearorder();
	fillordercontent();
}
function havelook(){
	var max=sortarray.length-1;
	var luky=parseInt(Math.random()*(max+1));
	callproduct(luky);
}


