/*全局常量*/
//店铺状态
var INNORMAL = 'innormal';
var NODELIVERY = 'nodelivery';
var ENCLOSED = 'enclosed';
//推荐类型
var RECSORT='recsort';
var RECPRODUCT='recproduct';
//单次订单最大数量
var LIMITORDERNUM=30;
//数据异常特征值
var NOENOUGHINFO='noenoughinfo';

/*全局变量*/
//运行特征值
var ispayable=true;//店铺是否服务中
var needdeliveryfee=false;//当前订单是否需要外送费
var issubmittable=false;//当前订单是否满足提交条件
var totalpay=0;
var totalordernum=0;
var isfirstinit=true;


//源数据
var mydatasource=null;
//数据引用
var sortarray=null;
var productarray=null;
var deliveryareaarray=null;
var recommendarray=null;
var shopinfo=null;

var recommendsortmap=null;
var product2ordermap=null;
var sortmap=null;
var productmap=null;
var areamap=null;

//本地数据
var orderarray=null;
var mypersonalinfo=null;

/*对象*/
function order(productid) {
    this.productid = productid;
    this.count = 0;
}
function personalinfo(name1,phonenumber1,areaid1,areadesc1,tips1){
	this.uesrname=name1;
	this.phonenumber=phonenumber1;
	this.areaid=areaid1;
	this.areadesc=areadesc1;
	this.tips=tips1;
}
function hashMap(){  
    this.Set=function(key,value){this[key] = value},  
    this.Get=function(key){return this[key]},  
   	this.Contains=function(key){return this.Get(key) == null?false:true},  
    this.Remove=function(key){delete this[key]} 
}

/*数据初始化*/
//全局数据准备
function firstinit(){
	basebind();
	getdatasource(true,true,true,true,true); 
	
}

//初始事件绑定
function basebind(){
	$(document).ajaxStart(function () { 
		startLoading('载入数据中'); 
	});
	$(document).ajaxStop(function () { 
		stopLoading(); 
	});
	$(document).ajaxError(function () { 
		stopLoading(); 
	}); 
	
}



//源数据、数据关系重置
function datarefresh(content){
	//重置数据引用
	if(mydatasource==null){
		calldataerror(NOENOUGHINFO);
	}else{
		mydatasource.sortdata!=null?sortarray=mydatasource.sortdata:calldataerror(NOENOUGHINFO);
		mydatasource.productdata!=null?productarray=mydatasource.productdata:calldataerror(NOENOUGHINFO);
		mydatasource.deliveryareadata!=null?deliveryareaarray=mydatasource.deliveryareadata:calldataerror(NOENOUGHINFO);
		mydatasource.shopinfodata!=null?shopinfo=mydatasource.shopinfodata:calldataerror(NOENOUGHINFO);
		recommendarray=mydatasource.recommenddata;
	}
	datamaprefresh();
	//重置可付款状态
	if(shopinfo.shopstatus==NODELIVERY||shopinfo.shopstatus==ENCLOSED||shopinfo.servertime<shopinfo.begintime||shopinfo.servertime>shopinfo.endtime){
		ispayable=false;
	}
	readhistory();
	if(isfirstinit){
		isfirstinit=false;
		firstcallcontent();
	}else{
		refreshcontent();
	}
}

//获得缓存数据
function readhistory(){
	readorderlocal();
	readinfolocal();
}

//ajax获取源数据
function getdatasource(needsort,needproduct,needdeliveryarea,needrecommend,needshopinfo){

	$.ajax({
        type:'POST',
        dataType: 'json',
        url:  AJAXFORDATA,
        data:{sellerid:sellerid,needsort:needsort,needproduct:needproduct,needdeliveryarea:needdeliveryarea,needrecommend:needrecommend,needshopinfo:needshopinfo},
        success:function(data){
            if(data.error=='0'){
            	if(mydatasource==null){
            		mydatasource=data;
            	}else{
            		datasourcetemp=data;
					mydatasource.sortdata=needsort?datasourcetemp.sortdata:mydatasource.sortdata;
					mydatasource.productdata=needproduct?datasourcetemp.productdata:mydatasource.productdata;
					mydatasource.deliveryareadata=needdeliveryarea?datasourcetemp.deliveryareadata:mydatasource.deliveryareadata;
					mydatasource.recommenddata=needrecommend?datasourcetemp.recommenddata:mydatasource.recommenddata;
					mydatasource.shopinfodata=needshopinfo?datasourcetemp.shopinfodata:mydatasource.shopinfodata;
            	} 
            	datarefresh(); 	
            }else{
            	var restartgetdatasource=function (){ 
					getdatasource(needsort,needproduct,needdeliveryarea,needrecommend,needshopinfo);
				};
	           	callerror(WRONGDATA,restartgetdatasource); 
            }
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){  
        	var restartgetdatasource=function (){ 
				getdatasource(needsort,needproduct,needdeliveryarea,needrecommend,needshopinfo);
			};
           	callerror(WRONGDATA,restartgetdatasource); 
        }  
    });   
}

/*本地读写*/
//从本地读订单缓存
function readorderlocal(){
	orderarray=new Array();
	if (localStorage) {
		if(localStorage.getItem(sellerid+'-'+openid+'-'+'order')){
			var orderarraytemp=localStorage.getItem(sellerid+'-'+openid+'-'+'order').split('&');
			for(var i=0;i<orderarraytemp.length;i++){
				var ordertemp=orderarraytemp[i].split('*');
				if(findproductbyid(ordertemp[0])>=0){
					orderarray[i]=new order(ordertemp[0]);
					orderarray[i].count=ordertemp[1];
				}
			}
		}
	}
	ordermaprefresh();
	calctotalpay();
}
//向本地写订单缓存
function writeorderlocal(){
	if(localStorage){
		var orderstring='';
		for(var i=0;i<orderarray.length;i++){
			if(orderarray[i].count>0&&productmap.Contains(orderarray[i].productid)&&orderstring==''){
				orderstring+=orderarray[i].productid+'*'+orderarray[i].count;
			}else if(orderarray[i].count>0&&productmap.Contains(orderarray[i].productid)&&orderstring!=''){
				orderstring+='&';
				orderstring+=orderarray[i].productid+'*'+orderarray[i].count;
			}
		}
		localStorage.setItem(sellerid+'-'+openid+'-'+'order',orderstring);
	}
	calctotalpay();
}
//从本地读收货信息缓存
function readinfolocal(){
	mypersonalinfo=new personalinfo();
	if (localStorage) {
		if(localStorage.getItem(sellerid+'-'+openid+'-'+'info')){
			var personalinfotemp=localStorage.getItem(sellerid+'-'+openid+'-'+'info').split('&');
			mypersonalinfo=new personalinfo(personalinfotemp[0],personalinfotemp[1],personalinfotemp[2],personalinfotemp[3],null);
		}
	}
}
//向本地写收货信息缓存
function writeinfolocal(name1,number1,areaid1,areadesc){
	mypersonalinfo.uesrname=name1;
	mypersonalinfo.phonenumber=number1;
	mypersonalinfo.areaid=areaid1;
	mypersonalinfo.areadesc=areadesc;
	if(localStorage){	
		var personalinfostring=mypersonalinfo.uesrname+'&'+mypersonalinfo.phonenumber+'&'+mypersonalinfo.areaid+'&'+mypersonalinfo.areadesc;
		localStorage.setItem(sellerid+'-'+openid+'-'+'info',personalinfostring);
	}
}



/*订单增减与清空*/
function deleteorder(productid){
	var orderindex = findorderbyid(productid);
	var bechanged = false;
	var beclear = false;
	if(orderindex>=0){
		if(orderarray[orderindex].count>=1){
			orderarray[orderindex].count--;
			bechanged = true;
		}
		if(orderarray[orderindex].count==0){
			beclear=true;
		}
	}
	if(bechanged){
		if(!beclear){
			writeorderlocal();
		}else{
			writeorderlocal();
			readorderlocal();
		}
		return true;
	}else{
		return false;
	}
}
function addorder(productid){
	var productindex = findproductbyid(productid);
	var orderindex = findorderbyid(productid);
	var bechanged = false;
	var addnew = false;
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
			addnew = true;
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
		if(!addnew){
			writeorderlocal();
		}else{
			writeorderlocal();
			readorderlocal();
		}
		return true;
	}else{
		return false;
	}
}
function clearorder(){
	orderarray=new Array();
	writeorderlocal();
	readorderlocal();
	return true;
}

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
	if(pay<shopinfo.sendingfee&&mytotalordernum>0&&shopinfo.deliveryfee>0){
		pay+=parseInt(shopinfo.deliveryfee);
		needdeliveryfee=true;
	}else if(pay>=shopinfo.sendingfee&&mytotalordernum>0&&!shopinfo.isdeliveryfree&&shopinfo.deliveryfee>0){
		pay+=parseInt(shopinfo.deliveryfee);
		needdeliveryfee=true;
	}else{
		needdeliveryfee=false;
	}
	if(pay<shopinfo.sendingfee&&mytotalordernum>0&&shopinfo.isdeliveryfree){
		issubmittable=true;
	}else if(pay>=shopinfo.sendingfee&&mytotalordernum>0){
		issubmittable=true;
	}else{
		issubmittable=false;
	}
	totalpay=pay;
	totalordernum=mytotalordernum;
	return pay;
}


/*工具方法*/
//查询语句
function findproductbyid(productid1){
	return productmap.Contains(productid1)?productmap.Get(productid1):-1;
}

function findorderbyid(productid1){
	return product2ordermap.Contains(productid1)?product2ordermap.Get(productid1):-1;
}

function findsortbyid(sortid1){
	return sortmap.Contains(sortid1)?sortmap.Get(sortid1):-1;
}

function findarerbyid(areaid1){
	return deliveryareamap.Contains(areaid1)?deliveryareamap.Get(areaid1):-1;
}
function findrecommendbyid(sortid1){
	return recommendsortmap.Contains(sortid1)?recommendsortmap.Get(sortid1):-1;
}
//重置map
function ordermaprefresh(){
	//重置order与product关系map
	product2ordermap=new hashMap();
	for(var i=0;i<orderarray.length;i++){
		if(findproductbyid(orderarray[i].productid>=0)){
			product2ordermap.Set(orderarray[i].productid,i);
		}
	}
}
function datamaprefresh(){
	//重置源数据反映射
	sortmap=new hashMap();
	for(var i=0;i<sortarray.length;i++){
		sortmap.Set(sortarray[i].sortid,i);
	}
	productmap=new hashMap();
	for(var i=0;i<productarray.length;i++){
		productmap.Set(productarray[i].productid,i);
	}
	deliveryareamap=new hashMap();
	for(var i=0;i<deliveryareaarray.length;i++){
		deliveryareamap.Set(deliveryareaarray[i].areaid,i);
	}
	//重置推荐map
	recommendsortmap=new hashMap();
	for(var i=0;i<recommendarray.length;i++){
		if(recommendarray[i].recommendtype==RECSORT){
			recommendsortmap.Set(recommendarray[i].recommendid,i);
		}
	}
}







/*全局常量*/
//面板
var SORTCONTENT='#sortcontent';
var PRODUCTCONTENT='#productcontent';
var PAYCONTENT='#paycontent';
var PAYSUCCESS='#paysuccess';
var LOADING='#loading';
var ERROR='#error';

//button
var SUBMITBTN='#submit-btn';
var SORTBTN='#sort-btn';
var BACKBTN='#back-btn';
var PAYBTN='#pay-btn';
var CLEARBTN='#clear-btn';
var HAVELOOKBTN='#havelook-btn';
var MINUSBTN='.button-minus';
var PLUSBTN='.button-plus';
var SORTITEMNOR='.sort-item-nor';
var RELOAD='#reload-btn';
var NEWSTART='#newstart-btn';

//icon大小
var ICONSIZE=20;

/*全局变量*/
//运行特征值
var currentsort = -1;//当前选中的sort类型
var lastcontent = '';
var currentcontent = '';
var mytoasttimeout=null;

var ispersonalinfoprepared=false;
var contentrightin=true;


/*界面调取方法*/
function showsortcontent(){
	basecontentprepare(SORTCONTENT);
	contentshow(SORTCONTENT);
}

function showproductcontent(sortid){
	if(findsortbyid(sortid)>=0){
		basecontentprepare(PRODUCTCONTENT);
		contentshow(PRODUCTCONTENT,sortid);
	}else{
		showsortcontent();
		Toast('该类别不存在',2000);
	}
}

function showpaycontent(){
	basecontentprepare(PAYCONTENT);
	contentshow(PAYCONTENT);
}


function basecontentprepare(content){
	contentrightin=true;
	switch(content){
		case SORTCONTENT:
		switch(currentcontent){
			case PAYCONTENT:
			contentrightin=false;
			break;
			case PRODUCTCONTENT:
			contentrightin=false;
			break;
		}
		break;
		case PRODUCTCONTENT:
		switch(currentcontent){
			case PAYCONTENT:
			contentrightin=false;
			break;
		}
		break;
	}

	content!=SORTCONTENT?$(SORTCONTENT).hide():$(SORTCONTENT).show();
	content!=PRODUCTCONTENT?$(PRODUCTCONTENT).hide():$(PRODUCTCONTENT).show();
	content!=PAYCONTENT?$(PAYCONTENT).hide():$(PAYCONTENT).show();
	switch(content){
		case SORTCONTENT:
		$('#back-btn').hide();
		$('#sort-btn').hide();
		$('#pay-btn').show();
		break;
		case PRODUCTCONTENT:
		$('#back-btn').hide();
		$('#sort-btn').show();
		$('#pay-btn').show();
		break;
		case PAYCONTENT:	 
		$('#back-btn').show();
	 	$('#sort-btn').hide();
	 	$('#pay-btn').hide();
		break;
	}
	lastcontent=currentcontent;
	currentcontent=content;
}


function contentshow(content,sortid){
	$(content).removeAttr('style');
	$(content).css('position','absolute');
	if(contentrightin){
		$(content).css('right','-100%');
	}else{
		$(content).css('left','-100%');
	}
	
	switch(content){
		case SORTCONTENT:
		fillsortcontent();
		break;
		case PRODUCTCONTENT:
		fillproductcontent(sortid);
		break;
		case PAYCONTENT:
		fillpaycontent();
		break;
	}
	$(content).show();
	if(contentrightin){
		$(content).css('right','0');
	}else{
		$(content).css('left','0');
	}
    $(content).css('transition', 'all 200ms ease');
    $(content).css('position','relative');
	    
}


/*页面初始化类，初始化固定内容*/
function fillsortcontent(){
	switch(shopinfo.shopstatus){
		case INNORMAL:
		if(!(shopinfo.servertime<shopinfo.endtime&&shopinfo.servertime>shopinfo.begintime)){
			$('#tips-title-sort').html('休息中(￣o￣). z Z');
			if(shopinfo.announcement!=''){
				var myannouncement='营业时间：'+shopinfo.begintime+'-'+shopinfo.endtime;
				myannouncement+='<br />今日公告：'+shopinfo.announcement;
				$('#tips-announcement-sort').html(myannouncement);
			}else{
				var myannouncement='营业时间：'+begintime+'-'+endtime;
				$('#tips-announcement-sort').html(myannouncement);
			}
		}else if(shopinfo.announcement!=''){
			$('#tips-title-sort').html('今日公告');
			$('#tips-announcement-sort').html(shopinfo.announcement);
		}else{
			$('#tips-sortcontent').hide();
		}
		break;
		case NODELIVERY:
		$('#tips-title-sort').html('今天不能送外卖啦>_<');
		if(shopinfo.announcement!=''){
			$('#tips-announcement-sort').html(shopinfo.announcement);
		}else{
			$('#tips-announcement-sort').html('偷偷告诉你哦，实体店还是营业的，欢迎前来光临！');
		}
		break;
		case ENCLOSED:
		$('#tips-title-sort').html('歇业中>_<');
		if(shopinfo.announcement!=''){
			$('#tips-announcement-sort').html(shopinfo.announcement);
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
					'<img src="'+BASEURL+recommendarray[i].recommendimg+'"alt="image">'+
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
		if(findrecommendbyid(sortarray[i].sortid)==-1){
			insert+='<li>'+
			'<div class="sort-item-nor" onclick = showproductcontent(\''+sortarray[i].sortid+'\')>'+
			'<img src="'+BASEURL+sortarray[i].sortimg+'">'+
			'<h4>'+sortarray[i].sortname+'</h4>'+
			'<p>'+sortarray[i].sortdesc+'</p>'+
			'<div class="list-item-icon" style="'+getbackground(SORTITEMNOR)+'"></div>'+
			'</div>'+
			'</li>';
		}
	}
	$('#sort-normallist').html(insert);
	setbtnshow(SORTCONTENT);
	
}

function fillproductcontent(sortid1){
	var sortindex=findsortbyid(sortid1);
	var insert='';
	currentsort=sortid1;
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
		        '<button class="btn-icon button-minus" onclick=todeleteorder(\''+productarray[i].productid+'\') style="display:inline"><div class="img-in-btn" style="'+getbackground(MINUSBTN)+'"></div></button>'+
		        '<button class="btn-icon button-plus" onclick=toaddorder(\''+productarray[i].productid+'\') style="display:inline"><div class="img-in-btn" style="'+getbackground(PLUSBTN)+'"></button>'+
	        	'</div>'+
        		'</div>'+
        		'</li>';
            }
		}
	
	$('#product-list').html(insert);
	setbtnshow(PRODUCTCONTENT);

}

function fillpaycontent(){
	var myannouncement='送达时间：约'+shopinfo.expecttime+'分钟';
	if(shopinfo.deliveryfee>0&&shopinfo.isdeliveryfree&&shopinfo.sendingfee>0){
		myannouncement+='<br />外送费用：￥'+shopinfo.deliveryfee+'（购满￥'+shopinfo.sendingfee+'免外送费）';
	}else if(shopinfo.deliveryfee>0&&!shopinfo.isdeliveryfree&&shopinfo.sendingfee>0){
		myannouncement+='<br />外送费用：￥'+shopinfo.deliveryfee+'<br />起送价格：￥'+shopinfo.sendingfee;
	}else if(shopinfo.deliveryfee>0&&!(shopinfo.sendingfee>0)){
		myannouncement+='<br />外送费用：￥'+shopinfo.deliveryfee+'<br />起送价格：无';
	}else if(!(shopinfo.deliveryfee>0)&&shopinfo.sendingfee>0){
		myannouncement+='<br />外送费用：无<br />起送价格：￥'+shopinfo.sendingfee;
	}else if(!(shopinfo.deliveryfee>0)&&!(shopinfo.sendingfee>0)){
		myannouncement+='<br />外送费用：无<br />起送价格：无';
	}
	$('#tips-announcement-order').html(myannouncement);

	var insert='';
	insert+='<li id="order-first-item"><h4 class="head-title"></h4><p class="head-desc"></p>'+
		'<button class="btn-icon-text" onclick=havelook() id="havelook-btn">'+
		'<p class="text-in-btn" id="havelook">去逛逛</p>'+
		'<div class="img-in-btn" style="'+getbackground(HAVELOOKBTN)+'"></div>'+
		'</button>'+
		'<button class="btn-icon-text" onclick=toclearorder() id="clear-btn">'+
		'<p class="text-in-btn" id="clear">清空</p>'+
		'<div class="img-in-btn" style="'+getbackground(CLEARBTN)+'"></div>'+
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
		    		'<p class="p-aside2"></p>'+
		    		'<div class="tipsarea-in-list" disabled="disabled">'+
		    		'<p class="tips-in-list"></p>'+
		    		'</div>'+
		        	'<div class="button-group-inlist" >'+
			        '<button class="btn-icon button-minus" onclick=todeleteorder(\''+orderarray[i].productid+'\') style="display:inline"><div class="img-in-btn" style="'+getbackground(MINUSBTN)+'"></div></button>'+
			        '<button class="btn-icon button-plus" onclick=toaddorder(\''+orderarray[i].productid+'\') style="display:inline"><div class="img-in-btn" style="'+getbackground(PLUSBTN)+'"></div></button>'+
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
	if(!ispersonalinfoprepared){
		personalinfoprepare();
		ispersonalinfoprepared=true;
	}

	//输入时禁用footer沉底
	$("input").focus(function(){
	    $("#mainfooter").css('position','relative');
	});
	$("input").blur(function(){
	    $("#mainfooter").css('position','fixed');
	});

	$("textarea").focus(function(){
	    $("#mainfooter").css('position','relative');
	});
	$("textarea").blur(function(){
	    $("#mainfooter").css('position','fixed');
	});

}
function personalinfoprepare(){
	var insert='';
	insert+='<label class="mylabel-main">姓名:*</label><label class="mylabel-tips"></label>'+
    '<input type="text" placeholder="请输入姓名" data-maxinput="10" data-nonull="true" onblur=checkinput(this) id="name" value="">'+
    '<label class="mylabel-main">联系电话:*</label><label class="mylabel-tips"></label>'+
    '<input id="number" placeholder="请输入联系电话" data-maxinput="20" data-nonull="true" onblur=checkinput(this) type="tel" value="">'+
    '<label class="mylabel-main">请选择收货片区:*</label><label class="mylabel-tips"></label>'+
    '<select id="select-area" onchange=checkselect(this)>';
    for(var i=0;i<deliveryareaarray.length;i++){
		if(deliveryareaarray[i].areastatus==false){
			insert+='<option value="'+deliveryareaarray[i].areaid+'" disabled="disabled">'+deliveryareaarray[i].areaname+'</option>';
		}else{
			insert+='<option value="'+deliveryareaarray[i].areaid+'">'+deliveryareaarray[i].areaname+'</option>';
		}
	}
    insert+='</select>'+
    '<label class="mylabel-desc"></label>'+
    '<label class="mylabel-main">详细收货地点:*</label><label class="mylabel-tips"></label>'+
    '<textarea type="text" placeholder="请输入详细收货地址，如：仙1-202" data-maxinput="40" data-nonull="true" onblur=checkinput(this) id="areadesc" value=""></textarea>'+
    '<label class="mylabel-main">备注:</label><label class="mylabel-tips"></label>'+
    '<textarea type="text"  placeholder="请输入备注，如：xxx不要放生菜" data-maxinput="40" data-nonull="false" onblur=checkinput(this) id="tips" value=""></textarea>';
	$('#personalinfo-content').html(insert);
	insert='';
	insert+='<button class="btn-icon-text" onclick=submit() id="submit-btn">'+
    '<p class="text-in-btn"id="submit">提交订单</p>'+
    '<div class="img-in-btn" style="'+getbackground(SUBMITBTN)+'"></div>'+
	'</button>';
	$('#submit-btnarea').html(insert);
	$('#name').val(mypersonalinfo.uesrname);
	$('#number').val(mypersonalinfo.phonenumber);
	$('#select-area').val(mypersonalinfo.areaid);
	$('#areadesc').val(mypersonalinfo.areadesc);
	checkselect('#select-area');

}

function footerprepare(){
	$('#mainfooter').show();
	var insert='';
	insert+='<button onclick = payback() id="back-btn" class="btn-icon" >'+
	'<div class="img-in-btn" style="'+getbackground(BACKBTN)+'"></div></button>'+
    '<button onclick = callsort() id="sort-btn" class="btn-icon">'+
    '<div class="img-in-btn" style="'+getbackground(SORTBTN)+'"></div></button>'+
    '<button onclick = topay() id="pay-btn" class="btn-icon-text">'+
    '<p class="text-in-btn"id="totalpay">结算 ￥0</p>'+
    '<div class="img-in-btn" style="'+getbackground(PAYBTN)+'"></div></button>';
    $('#mainfooter').html(insert);
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
    			$('#order-first-item').children('p').html('总计：￥'+mytotalpay+'（含外送费：￥'+shopinfo.deliveryfee+'）');
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

function firstcallcontent(){
	footerprepare();
    if(firstsortid>=0){
    	showproductcontent(firstsortid);
    }else{
    	showsortcontent();
    }
}
function refreshcontent(){
	switch(currentcontent){
		case SORTCONTENT:
		showproductcontent();
		break;
		case PRODUCTCONTENT:
		showproductcontent();
		break;
		case PAYCONTENT:
		showpaycontent();
		break;
	}
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
			
		myuesrname=$('#name').val();
		myphonenumber=$('#number').val();
		myareaid=$('#select-area').val();
		myareadesc=$('#areadesc').val();
		mytips=$('#tips').val();
		writeinfolocal(myuesrname,myphonenumber,myareaid,myareadesc);
				$.ajax({
			        type:'POST',
			        dataType: 'json',
			        url:  AJAXFORSUBMIT,
			        data:{sellerid:sellerid,openid:openid,wapkey:identitykey,name:myuesrname,phone:myphonenumber, areaid:myareaid,areadesc:myareadesc,tips:mytips, products:products, nums:nums},
			        success:function(data,textStatus){
			            if(data.success=='1'){
							Toast('下单成功',2000);
							clearorder();
							getorder();
			            }else{{
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

function getorder(){
	$.ajax({
        type:'POST',
        dataType: 'json',
        url:  AJAXFORRESULT,
        data:{sellerid:sellerid,wapkey:identitykey,openid:openid,endtime:null,num:1},
        success:function(data,textStatus){
            if(data.success=='1'){
            	callsuccesspay(data.result[0]);
            }else{
            	var restartgetorder=function (){ 
					getorder();
				};   
	            callerror(WRONGDATA,restartgetorder);
            } 
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){ 
        	var restartgetorder=function (){ 
				getorder();
			};   
            callerror(WRONGDATA,restartgetorder);
        }  
    });    
}

function callsuccesspay(order){
	$(PAYSUCCESS).show();
	var insert='';
	insert+='订单号：'+order.order_no+
	'<br />订单状态：'+order.status+
	'<br />'+
	'<br />联系人姓名：'+order.name+
	'<br />联系人电话：'+order.phone+
	'<br />收货地点：'+order.address+
	'<br />下单时间：'+order.ctime+
	'<br />'+
	'<br />订单明细：'+order.order_items+
	'<br />订单总价：'+order.total;
	$('#tips-orderdesc-ordersuccess').html(insert);
	insert='';
	insert+='<button class="btn-icon-text" onclick=newstart() id="newstart-btn">'+
	'<p class="text-in-btn">继续下单</p>'+
	'<div class="img-in-btn" style="'+getbackground(NEWSTART)+'"></div>'+
	'</button>';
	$('#newstart-btnarea').html(insert);
}
function toclearorder(){
	if (confirm('您确定清空购物车吗？')) { 
		clearorder();
		switch(currentcontent){
			case PAYCONTENT:
			fillpaycontent();
			break;
		}
	}
}

function toaddorder(productid1){
	if(addorder(productid1)){
		switch(currentcontent){
			case PRODUCTCONTENT:
			setbtnshow(PRODUCTCONTENT);
			break;
			case PAYCONTENT:
			setbtnshow(PAYCONTENT);
			break;
		}
	}
	
}
function todeleteorder(productid1){
	if(deleteorder(productid1)){
		switch(currentcontent){
			case PRODUCTCONTENT:
			setbtnshow(PRODUCTCONTENT);
			break;
			case PAYCONTENT:
			fillpaycontent();
			break;
			}
	}
}
function havelook(){
	var max=sortarray.length-1;
	var luky=parseInt(Math.random()*(max+1));
	callproduct(sortarray[luky].sortid);
}

function newstart(){
	datarefresh();
}

//检查输入
function checkinput(element1) {
    if ($.trim($(element1).val()).length<=0&&$(element1).data('nonull')==true) {//输入框里值为空，或者为一些特定的文字时，都提示输入不能为空
		$(element1).prev('label').html('输入不能为空');
        return false;
    }else if($(element1).attr('type')=='tel'&&!checkphonenumber($(element1).val())){
    	$(element1).prev('label').html('请正确输入手机号或电话号码<br />示例：15353535353 或 025-83622222');
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
		return (/^(1[3|4|5|8][0-9]\d{8})$/.test($.trim(this))); 

	} 

	String.prototype.isTel = function()
	{
	    return (/^(0\d{2,3}-\d{7,8})?$/.test($.trim(this)));
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






function getbackground(btnname){
	var position=0;
	switch(btnname){
		case SORTBTN:
		position=0;
		break;
		case BACKBTN:
		position=1;
		break;
		case PAYBTN:
		position=2;
		break;
		case CLEARBTN:
		position=3;
		break;
		case HAVELOOKBTN:
		position=4;
		break;
		case SUBMITBTN:
		position=5;
		break;
		case MINUSBTN:
		position=6;
		break;
		case PLUSBTN:
		position=7;
		break;
		case SORTITEMNOR:
		position=8;
		break;
	}
	var positionx=0-position*ICONSIZE;
	var bgset='background:url('+BASEURLICON+') no-repeat '+positionx+'px 0;'
	return bgset;
}