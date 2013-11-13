var INNORMAL = 'innormal';
var NODELIVERY = 'nodelivery';
var ENCLOSED = 'enclosed';

var SORTCONTENT='sortcontent';
var PRODUCTCONTENT='productcontent';
var PAYCONTENT='paycontent';
var PAYSUCCESS='paysuccess';

var RECSORT='recsort';
var RECPRODUCT='recproduct';


var orderidindex = 0;
var currentsort = -1;
var openid='';
var sortarray = new Array();
var productarray = new Array
var deliveryareaarray = new Array();
var orderarray = new Array();
var recommendarray = new Array();
var myshopinfo=null;
var ispayable=true;

/*对象方法*/
function shopinfo(announcement1,shopstatus1,begintime1,endtime1,severtime1,isdeliveryfree1,sendingfee1,deliveryfee1,expecttime1){
	this.announcement = announcement1;
	this.shopstatus = shopstatus1;
	this.begintime=begintime1;
	this.endtime=endtime1;
	this.severtime=severtime1;
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
	myshopinfo=new shopinfo(shopinfodata.announcement,shopinfodata.shopstatus,shopinfodata.begintime,shopinfodata.endtime,shopinfodata.severtime,shopinfodata.isdeliveryfree,shopinfodata.sendingfee,shopinfodata.deliveryfee,shopinfodata.expecttime)
}
//获得缓存数据
function readhistory(){
	readorderlocal();
	// readaddresslocal();
}
//设置可付款状态
function payableinit(){
	if(myshopinfo.shopstatus==NODELIVERY||myshopinfo.shopstatus==ENCLOSED||myshopinfo.severtime<myshopinfo.begintime||myshopinfo.severtime>myshopinfo.endtime){
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
    readhistory();
    shopinfoinit();
    payableinit();
}
/*界面调取方法*/
function callsort(){
	showsortcontent();
}

function payback(){
	showsortcontent();
}

function topay(){
	showpay();
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

// function showpaycontent(){
// 	 $("#sortcontent").hide();
// 	 $("#productcontent").hide();
// 	 $("#paycontent").show();
// 	 $("#back-btn").show();
// 	 $("#sort-btn").hide();
// 	 $("#pay-btn").hide();
// 	 fillproduct();
// 	}

/*页面初始化类*/
function fillsortcontent(){
	switch(myshopinfo.shopstatus)
		{
		case INNORMAL:
		if(!(myshopinfo.severtime<myshopinfo.endtime&&myshopinfo.severtime>myshopinfo.begintime)){
			$('#tips-title').html('休息中(￣o￣). z Z');
			if(myshopinfo.announcement!=''){
				var myannouncement='营业时间：'+myshopinfo.begintime+'-'+myshopinfo.endtime;
				myannouncement+='<br />今日公告：'+myshopinfo.announcement;
				$('#tips-announcement').html(myannouncement);
			}else{
				var myannouncement='营业时间：'+begintime+'-'+endtime;
				$('#tips-announcement').html(myannouncement);
			}
		}else if(myshopinfo.announcement!=''){
			$('#tips-title').html('今日公告');
			$('#tips-announcement').html(myshopinfo.announcement);
		}else{
			$('#tips-sortcontent').hide();
		}
		break;
		case NODELIVERY:
		$('#tips-title').html('今天不能送外卖啦>_<');
		if(myshopinfo.announcement!=''){
			$('#tips-announcement').html(myshopinfo.announcement);
		}else{
			$('#tips-announcement').html('偷偷告诉你哦，实体店还是营业的，欢迎前来光临！');
		}
		break;
		case ENCLOSED:
		$('#tips-title').html('歇业中>_<');
		if(myshopinfo.announcement!=''){
			$('#tips-announcement').html(myshopinfo.announcement);
		}else{
			$('#tips-announcement').html('今天不开张啦，改日再会！')
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
			'<img src="/wcptf/img/wap/carat-r-purple.png" class="list-item-icon">'+
			'</div>'+
			'</li>';
		}
	}
	$('#sort-normallist').html(insert);
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
	    		'<p class="text-in-btn">已售空</p>'+
	    		'</button>'+
	        	'<div class="button-group-inlist" >'+
		        '<button class="btn-icon button-minus" onclick=deleteorder(\''+productarray[i].productid+'\') style="display:inline"><img src="/wcptf/img/wap/minus-purple.png"></button>'+
		        '<button class="btn-icon button-plus" onclick=addorder(\''+productarray[i].productid+'\') style="display:inline"><img src="/wcptf/img/wap/plus-purple.png"></button>'+
	        	'</div>'+
        		'</div>'+
        		'</li>';
            }
		}
	
	$('#product-list').html(insert);
	setbtnshow(PRODUCTCONTENT);
}

function deleteorder(productid){
	var orderindex = findorderbyid(productid);
	var bechanged = false;
	if(orderarray[orderindex].count>=1){
		orderarray[orderindex].count--;
		bechanged = true;
	}
	if(bechanged){
		setbtnshow(PRODUCTCONTENT);
		writeorderlocal();
	}
}
function addorder(productid){
	var productindex = findproductbyid(productid);
	var orderindex = findorderbyid(productid);
	var bechanged = false;
	if(productindex>=0&&orderindex>=0){
		if(orderarray[orderindex].count>=0&&orderarray[orderindex].count<productarray[productindex].productleft){
			orderarray[orderindex].count++;
			bechanged = true;
		}
	}else if(productindex>=0&&orderindex<0){
		var newindex = orderarray.length;
		orderarray[newindex]=new order(productid);
		orderarray[newindex].count++;
		bechanged = true;
	}
	if(bechanged){
		setbtnshow(PRODUCTCONTENT);
		writeorderlocal();
	}
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
//设定当前页面按钮属性
function setbtnshow(contenttype){
	switch(contenttype){
		case SORTCONTENT:
		if(ispayable==false){
    		$('#pay-btn').attr('disabled','disabled');
    		$('#pay-btn').children('p').html('休息中');
		}else{
    		$('#pay-btn').removeAttr('disabled');
			$('#pay-btn').children('p').html('结算 ￥'+totalpay());
		}
		break;
		case PRODUCTCONTENT:
		var mytotalpay=0;
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
					}else{
						$('#product-'+i).children('.button-single-inlist').hide();
						$('#product-'+i).children('.button-group-inlist').show();
						$('#product-'+i).children('.button-minus').attr("disabled",true);
						$('#product-'+i).children('.button-plus').attr("disabled",false);
					}
				}else if(orderarray[orderindex].count==0){
					$('#product-'+i).children('.p-aside2').hide();
					$('#product-'+i).children('.button-single-inlist').hide();
					$('#product-'+i).children('.button-group-inlist').show();
					$('#product-'+i).children('.button-minus').attr("disabled",true);
					$('#product-'+i).children('.button-plus').attr("disabled",false);
				}else if(orderarray[orderindex].count>0&&orderarray[orderindex].count<productarray[i].productleft){
				
					$('#product-'+i).children('.p-aside2').show();
					$('#product-'+i).children('.button-single-inlist').hide();
					$('#product-'+i).children('.button-group-inlist').show();
					$('#product-'+i).children('.button-minus').attr("disabled",false);
					$('#product-'+i).children('.button-plus').attr("disabled",false);
					var insert='已点数量:'+orderarray[orderindex].count+' 总价:'+orderarray[orderindex].count*productarray[i].price;
					$('#product-'+i).children('.p-aside2').html(insert);
				}else if(orderarray[orderindex].count==productarray[i].productleft){
				
					$('#product-'+i).children('.p-aside2').show();
					$('#product-'+i).children('.button-single-inlist').hide();
					$('#product-'+i).children('.button-group-inlist').show();
					$('#product-'+i).children('.button-minus').attr("disabled",false);
					$('#product-'+i).children('.button-plus').attr("disabled",true);
					var insert='已点数量:'+orderarray[orderindex].count+' 总价:'+orderarray[orderindex].count*productarray[i].price+' 已达库存上限';
					$('#product-'+i).children('.p-aside2').html(insert);
				}else if(orderarray[orderindex].count>productarray[i].productleft){
				
					$('#product-'+i).children('.p-aside2').show();
					$('#product-'+i).children('.button-single-inlist').hide();
					$('#product-'+i).children('.button-group-inlist').show();
					$('#product-'+i).children('.button-minus').attr("disabled",false);
					$('#product-'+i).children('.button-plus').attr("disabled",true);
					var insert='已点数量:'+orderarray[orderindex].count+' 总价:'+orderarray[orderindex].count*productarray[i].price+' 已超库存上限！';
					$('#product-'+i).children('.p-aside2').html(insert);
				}
			}
		}
		if(ispayable==false){
    		$('#pay-btn').attr('disabled','disabled');
    		$('#pay-btn').children('p').html('休息中');
		}else{
    		$('#pay-btn').removeAttr('disabled');
			$('#pay-btn').children('p').html('结算 ￥'+totalpay());
		}
		break;
	}
}
//从本地读订单缓存
function readorderlocal(){
	if (localStorage) {
		if(localStorage.getItem(openid)){
			var orderarraytemp=localStorage.getItem(openid).split('&');
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
		localStorage.setItem(openid,orderstring);
	}
}
//计算应付总价
function totalpay(){
	var pay=0;
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				pay=productarray[productindex].price*orderarray[i].count+pay;
			}
		}
	}
	return pay;
}
//计算每订单商品总价
function productpay(productid){
	var pay=0;
	var productindex = findproductbyid(productid);
	var orderindex = findorderbyid(productid);
	if(productindex>=0&&orderindex>=0){
		pay = productarray[productindex].price*orderarray[orderindex].count;
	}
	return pay;
}




