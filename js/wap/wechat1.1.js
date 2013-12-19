/*全局常量*/
//店铺状态hhh
var INNORMAL = 'innormal';
var NODELIVERY = 'nodelivery';
var ENCLOSED = 'enclosed';
//推荐类型
var RECSORT='recsort';
var RECPRODUCT='recproduct';

//单次订单最大数量
var LIMITORDERNUM=30;

/*全局变量*/
//运行特征值
var isfirstinit=true;
var ispayable=true;//店铺是否服务中
var needdeliveryfee=false;//当前订单是否需要外送费
var issubmittable=false;//当前订单是否满足提交条件
var totalpay=0;
var totalordernum=0;
var overleft=false;
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
function order(productid1) {
    this.productid = productid1;
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
	baseeventbind();
	dataload(true,true,true,true,true); 
}

//初始事件绑定
function baseeventbind(){
	$(document).ajaxStart(function () { 
		startloading('正在进行数据交换'); 
	});
	$(document).ajaxStop(function () { 
		stoploading(); 
	});
	$(document).ajaxError(function () { 
		stoploading(); 
	}); 
	
}

//ajax获取源数据
function dataload(needsort,needproduct,needdeliveryarea,needrecommend,needshopinfo){
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
            	if(mydatasource.sortdata==null||mydatasource.productdata==null||mydatasource.deliveryareadata==null||mydatasource.shopinfodata==null){
            		var restartdataload=function (){ 
						dataload(mydatasource.sortdata==null,mydatasource.productdata==null,mydatasource.deliveryareadata==null,needrecommend,mydatasource.shopinfodata==null);
					};
					$(currentcontent).hide();
		           	callerror(WRONGDATA,restartdataload); 
            	}else{
            		datarefresh(); 
            	}
            }else{
            	var restartdataload=function (){ 
					dataload(needsort,needproduct,needdeliveryarea,needrecommend,needshopinfo);
				};
				$(currentcontent).hide();
	           	callerror(WRONGDATA,restartdataload); 
            }
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){  
        	var restartdataload=function (){ 
				dataload(needsort,needproduct,needdeliveryarea,needrecommend,needshopinfo);
			};
			$(currentcontent).hide();
           	callerror(WRONGDATA,restartdataload); 
        }  
    });   
}

function orderload(){
	$.ajax({
        type:'POST',
        dataType: 'json',
        url:  AJAXFORRESULT,
        data:{sellerid:sellerid,wapKey:identitykey,openid:openid,endtime:null,num:1},
        success:function(data,textStatus){
            if(data.success=='1'){
            	callsuccesspay(data.result[0]);
            }else{
            	var restartorderload=function (){ 
            		$(currentcontent).show();
					orderload();
				};   
				$(currentcontent).hide();
	            callerror(WRONGDATA,restartorderload);
            } 
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){ 
        	var restartorderload=function (){ 
        		$(currentcontent).show();
				orderload();
			};   
			$(currentcontent).hide();
            callerror(WRONGDATA,restartorderload);
        }  
    });    
}


//源数据、数据关系重置
function datarefresh(){
	//重置数据引用
	sortarray=mydatasource.sortdata;
	productarray=mydatasource.productdata;
	deliveryareaarray=mydatasource.deliveryareadata;
	shopinfo=mydatasource.shopinfodata;
	recommendarray=mydatasource.recommenddata;
	
	//重置关系map
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


/*本地读写*/
//从本地读订单缓存
function readorderlocal(){
	orderarray=new Array();
	if (localStorage) {
		if(localStorage.getItem(sellerid+'-'+openid+'-'+'order')){
			var orderarraytemp=localStorage.getItem(sellerid+'-'+openid+'-'+'order').split('&');
			var orderindex=0;
			for(var i=0;i<orderarraytemp.length;i++){
				var ordertemp=orderarraytemp[i].split('*');
				if(findproductbyid(ordertemp[0])>=0){
					orderarray[orderindex]=new order(ordertemp[0]);
					orderarray[orderindex].count=parseInt(ordertemp[1]);
					orderindex++;
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
	var mytotalpay=0;
	var mytotalordernum=0;
	var myoverleft=false;
	var myneeddeliveryfee=false;
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				mytotalordernum+=parseInt(orderarray[i].count);
				mytotalpay+=((productarray[productindex].price*100)*orderarray[i].count)/100;//防止js浮点计算bug
				if(orderarray[i].count>productarray[productindex].productleft){
					myoverleft=true;
				}
			}
		}
	}
	if(mytotalpay<shopinfo.sendingfee&&mytotalordernum>0&&shopinfo.deliveryfee>0){
		mytotalpay+=parseInt(shopinfo.deliveryfee);
		myneeddeliveryfee=true;
	}else if(mytotalpay>=shopinfo.sendingfee&&mytotalordernum>0&&!shopinfo.isdeliveryfree&&shopinfo.deliveryfee>0){
		mytotalpay+=parseInt(shopinfo.deliveryfee);
		myneeddeliveryfee=true;
	}else{
		myneeddeliveryfee=false;
	}
	if(mytotalpay<shopinfo.sendingfee&&mytotalordernum>0&&shopinfo.isdeliveryfree){
		issubmittable=true;
	}else if(mytotalpay>=shopinfo.sendingfee&&mytotalordernum>0){
		issubmittable=true;
	}else{
		issubmittable=false;
	}
	totalpay=mytotalpay;
	totalordernum=mytotalordernum;
	overleft=myoverleft;
	needdeliveryfee=myneeddeliveryfee;
	return mytotalpay;
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

//button
var SUBMITBTN='#submit-btn';
var SORTBTN='#sort-btn';
var BACKBTN='#back-btn';
var PAYBTN='#pay-btn';
var CLEARBTN='#clear-btn';
var HAVELOOKBTN='#havelook-btn';
var MINUSBTN='.button-minus';
var PLUSBTN='.button-plus';
var RIGHTARROR='rightarror';
var NEWSTARTBTN='#newstart-btn';
var INSLEEPBTN='insleepbtn';

//icon大小
var ICONSIZE=20;

//itemdesc状态
var DESCSHOW='descshow';
var DESCHIDE='deschide';
var DESCNOEXIST='descnoexist';

/*全局变量*/
//运行特征值
var currentsort = -1;//当前选中的sort类型
var lastcontent = '';
var currentcontent = '';
var mytoasttimeout=null;

var contentin=true;
var productcontentscroll=0;
var sortcontentscroll=0;
var productcontentscrolltemp=0;
var sortcontentscrolltemp=0;
var lastchange=null;


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

//确定需要显示的content及in or out
function basecontentprepare(content){
	contentin=true;
	//根据前后页面主从关系确定in or out
	switch(content){
		case SORTCONTENT:
		switch(currentcontent){
			case PAYCONTENT:
			contentin=false;
			break;
			case PRODUCTCONTENT:
			contentin=false;
			break;
		}
		break;
		case PRODUCTCONTENT:
		switch(currentcontent){
			case PAYCONTENT:
			contentin=false;
			break;
		}
		break;
	}
	content!=SORTCONTENT?$(SORTCONTENT).hide():$(SORTCONTENT).show();
	content!=PRODUCTCONTENT?$(PRODUCTCONTENT).hide():$(PRODUCTCONTENT).show();
	content!=PAYCONTENT?$(PAYCONTENT).hide():$(PAYCONTENT).show();

	
	lastcontent=currentcontent;
	currentcontent=content;
}


function personalinfoprepare(){
	var insert='';
	insert+='<label class="label-main">姓名:*</label><label class="label-tips" style="display:none"></label>'+
    '<input type="text" placeholder="请输入姓名" data-maxinput="10" data-nonull="true" onblur=checkinput(this) id="name" value="">'+
    '<label class="label-main">联系电话:*</label><label class="label-tips" style="display:none"></label>'+
    '<input id="number" placeholder="请输入联系电话" data-maxinput="20" data-nonull="true" onblur=checkinput(this) type="tel" value="">'+
    '<label class="label-main">请选择收货片区:*</label><label class="label-tips" style="display:none"></label>'+
    '<select id="select-area" onchange=checkselect(this)>';
    for(var i=0;i<deliveryareaarray.length;i++){
		if(deliveryareaarray[i].areastatus==false){
			insert+='<option value="'+deliveryareaarray[i].areaid+'" disabled="disabled">'+deliveryareaarray[i].areaname+'</option>';
		}else{
			insert+='<option value="'+deliveryareaarray[i].areaid+'">'+deliveryareaarray[i].areaname+'</option>';
		}
	}
    insert+='</select>'+
    '<label class="label-desc"></label>'+
    '<label class="label-main">详细收货地点:*</label><label class="label-tips" style="display:none"></label>'+
    '<textarea type="text" placeholder="请输入详细收货地址，如：仙1-202" data-maxinput="40" data-nonull="true" onblur=checkinput(this) id="areadesc" value=""></textarea>'+
    '<label class="label-main">备注:</label><label class="label-tips" style="display:none"></label>'+
    '<textarea type="text"  placeholder="请输入备注（如需使用会员卡，请留下卡号与登记时预留手机号，我们将与您电话核实）" data-maxinput="40" data-nonull="false" onblur=checkinput(this) id="tips" value=""></textarea>';
	$('#personalinfo-content').html(insert);
	insert='';
	insert+='<button class="btn-icon-text" onclick=submit() id="submit-btn">'+
    '<span class="text-in-btn"id="submit">提交订单</span>'+
    '<span class="img-in-btn" style="background:'+getbackground(SUBMITBTN)+';"></span>'+
	'</button>';
	$('#submit-btnarea').html(insert);
	$('#name').val(mypersonalinfo.uesrname);
	$('#number').val(mypersonalinfo.phonenumber);
	$('#select-area').val(mypersonalinfo.areaid);
	$('#areadesc').val(mypersonalinfo.areadesc);
	if(!(mypersonalinfo.areaid==null||mypersonalinfo.areaid=='')){
		checkselect('#select-area');
	}
}

function footerprepare(){
	$('#mainfooter').show();
	var insert='';
	insert='<button onclick = payback() id="back-btn" class="btn-icon" >'+
	'<span class="img-in-btn" style="background:'+getbackground(BACKBTN)+';"></span></button>'+
    '<button onclick = callsort() id="sort-btn" class="btn-icon">'+
    '<span class="img-in-btn" style="background:'+getbackground(SORTBTN)+';"></span></button>';
    $('#mainfooter .left-footer').html(insert);
    insert='<h4 id="paytitle">订单中心</h4>';
    $('#mainfooter .center-footer').html(insert);
    insert='<button onclick = topay() id="pay-btn" class="btn-icon-text">'+
    '<span class="text-in-btn">结算 ￥0</span>'+
    '<span class="img-in-btn" style="background:'+getbackground(PAYBTN)+';"></span></button>';
    $('#mainfooter .right-footer').html(insert);
}

function contenteventbind(){
	$('#product-list,#order-list').on(
		'click',MINUSBTN,function(event){
		myproductid=$(this).data('value');
		todeleteorder(myproductid);
		event.stopPropagation();
	});
	$('#product-list,#order-list').on(
		'click',PLUSBTN,function(event){
		myproductid=$(this).data('value');
		toaddorder(myproductid);
        event.stopPropagation();
    });
    $('#product-list').on('click','.product-item',function(event){
    	var mytarget=event.target;
    	var isfrombtn=false;
    	while(!$(mytarget).is('.product-item')){
    		if($(mytarget).is('.btnarea-in-list')){
    			isfrombtn=true;
    			break;
    		}
    		mytarget=$(mytarget).parent();
    	}
    	if(!isfrombtn){
    	showitemdesc(this);
    }
    });

	//监听系统滚动事件
	$(window).scroll(function() {
		if(lastchange!=currentcontent){
			switch(lastchange){
			   case PRODUCTCONTENT:
			   productcontentscroll=productcontentscrolltemp;
			   break;
			   case SORTCONTENT:
			   sortcontentscroll=sortcontentscrolltemp;
			   break;
			}
			lastchange=currentcontent;
			switch(lastchange){
			   case PRODUCTCONTENT:
			   productcontentscrolltemp=$(this).scrollTop();
			   break;
			   case SORTCONTENT:
			   sortcontentscrolltemp=$(this).scrollTop();
			   break;
			}
		}else{
			switch(lastchange){
			   case PRODUCTCONTENT:
			   productcontentscrolltemp=$(this).scrollTop();
			   break;
			   case SORTCONTENT:
			   sortcontentscrolltemp=$(this).scrollTop();
			   break;
			}
		}
    });
}



function contentshow(content,sortid){
	var precurrentsort=currentsort;
	$(content).removeAttr('style');
	$(content).css('position','absolute');
	if(contentin){
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
	if(contentin){
		$(content).css('right','0');
	}else{
		$(content).css('left','0');
	}
    $(content).css('transition', 'all 200ms ease');
    $(content).css('position','relative');

    //页面载入后定位至指定位置
	switch(content){
		case SORTCONTENT:
		window.scrollTo(0,1);
		window.scrollTo(0,sortcontentscroll);
		break;
		case PRODUCTCONTENT:
		if(sortid==precurrentsort){
			window.scrollTo(0,1);
		    window.scrollTo(0,productcontentscroll);
		}else{
		    window.scrollTo(0,1);
		}
		break;
		case PAYCONTENT:
		window.scrollTo(0,1);
		break;
	}
	    
}


/*页面初始化类，初始化固定内容*/
function fillsortcontent(){
	switch(shopinfo.shopstatus){
		case INNORMAL:
		if(!(shopinfo.servertime<shopinfo.endtime&&shopinfo.servertime>shopinfo.begintime)){
			$('#tips-sortcontent').show();
			$('#tips-title-sort').html('休息中(￣o￣). z Z');
			if(shopinfo.announcement!=''){
				var myannouncement='营业时间：'+shopinfo.begintime+'-'+shopinfo.endtime;
				myannouncement+='<br />今日公告：'+shopinfo.announcement;
				$('#tips-announcement-sort').html(myannouncement);
			}else{
				var myannouncement='营业时间：'+shopinfo.begintime+'-'+shopinfo.endtime;
				$('#tips-announcement-sort').html(myannouncement);
			}
		}else if(shopinfo.announcement!=''){
			$('#tips-sortcontent').show();
			$('#tips-title-sort').html('今日公告');
			$('#tips-announcement-sort').html(shopinfo.announcement);
		}else{
			$('#tips-sortcontent').hide();
		}
		break;
		case NODELIVERY:
		$('#tips-sortcontent').show();
		$('#tips-title-sort').html('今天不能送外卖啦>_<');
		if(shopinfo.announcement!=''){
			$('#tips-announcement-sort').html(shopinfo.announcement);
		}else{
			$('#tips-announcement-sort').html('偷偷告诉你哦，实体店还是营业的，欢迎前来光临！');
		}
		break;
		case ENCLOSED:
		$('#tips-sortcontent').show();
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
					insert+='<li class="sort-item-rec" onclick = showproductcontent(\''+sortarray[t].sortid+'\') >'+
					'<img src="'+BASEURL+recommendarray[i].recommendimg+'" alt="无真相>_<~">'+
					'<div class="mainarea-in-list">'+
					'<h4>'+sortarray[t].sortname+'</h4>'+
					'<h5>'+sortarray[t].sortdesc+'</h5>'+
					'</div>'+
					'<p class="p-aside">'+recommendarray[i].recommendtag+'</p>'+
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
			insert+='<li class="sort-item-nor" onclick = showproductcontent(\''+sortarray[i].sortid+'\')>'+
			'<img src="'+BASEURL+sortarray[i].sortimg+'" alt="无真相>_<~">'+
			'<div class="list-item-icon" style="background:'+getbackground(RIGHTARROR)+';"></div>'+
			'<div class="mainarea-in-list">'+
			'<h4>'+sortarray[i].sortname+'</h4>'+
			'<h5>'+sortarray[i].sortdesc+'</h5>'+
			'</div>'+
			'</li>';
		}
	}
	$('#sort-normallist').html(insert);
	setcontentshow(SORTCONTENT);
	
}

function fillproductcontent(sortid1){
	var sortindex=findsortbyid(sortid1);
	var insert='';
	currentsort=sortid1;
	if(sortindex>=0){
		insert+='<li class="product-item" id="product-first-item"><div class="mainarea-in-list"><h4>'+sortarray[sortindex].sortname+'</h4><h5>'+sortarray[sortindex].sortdesc+'</h5></div></li>'
	}
	for(var i=0;i<productarray.length;i++){
		if(productarray[i].sortid==sortid1){
			insert+='<li class="product-item" id="product-'+productarray[i].productid+'" data-value="'+productarray[i].productid+'" data-descexist="'+DESCNOEXIST+'">'+
				'<div class="btnarea-in-list" >'+
		        '<button class="btn-icon button-minus" data-value="'+productarray[i].productid+'" style="display:inline"><span class="img-in-btn" style="background:'+getbackground(MINUSBTN)+';"></span></button>'+
		        '<button class="btn-icon button-plus" data-value="'+productarray[i].productid+'" style="display:inline"><span class="img-in-btn" style="background:'+getbackground(PLUSBTN)+';"></span></button>'+
	        	'</div>'+
	        	'<div class="tipsarea-in-list" disabled="disabled">'+
		    	'<h4></h4>'+
		    	'</div>'+
				'<div class="mainarea-in-list" >'+
		        '<h4>'+productarray[i].productname+'</h4>'+
		        '<h5>￥'+productarray[i].price+'</h5>'+
	    		'</div>'+
	    		'<p class="p-aside"></p>'+
	    		'<p class="showmore">···</p>'+
        		'</li>';
            }
		}
	
	$('#product-list').html(insert);
	setcontentshow(PRODUCTCONTENT);

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
	insert+='<li class="product-item" id="order-first-item">'+
		'<div class="btnarea-in-list">'+
		'<button class="btn-icon-text" onclick=havelook() id="havelook-btn">'+
		'<span class="text-in-btn" id="havelook">去逛逛</span>'+
		'<span class="img-in-btn" style="background:'+getbackground(HAVELOOKBTN)+';"></span>'+
		'</button>'+
		'<button class="btn-icon-text" onclick=toclearorder() id="clear-btn">'+
		'<span class="text-in-btn" id="clear">清空</span>'+
		'<span class="img-in-btn" style="background:'+getbackground(CLEARBTN)+';"></span>'+
		'</button>'+
		'</div>'+
		'<div class="mainarea-in-list"><h4></h4><h5></h5></div>'+
		'</li>';
	for(var i=0;i<orderarray.length;i++){
		if(orderarray[i].count>0){
			var productindex=findproductbyid(orderarray[i].productid);
			if(productindex>=0){
				insert+='<li class="product-item" id="order-'+orderarray[i].productid+'">'+
					'<div class="btnarea-in-list" >'+
			        '<button class="btn-icon button-minus" data-value="'+orderarray[i].productid+'" style="display:inline"><span class="img-in-btn" style="background:'+getbackground(MINUSBTN)+';"></span></button>'+
			        '<button class="btn-icon button-plus " data-value="'+orderarray[i].productid+'" style="display:inline"><span class="img-in-btn" style="background:'+getbackground(PLUSBTN)+';"></span></button>'+
		        	'</div>'+
		        	'<div class="tipsarea-in-list" disabled="disabled">'+
		    		'<h4></h4>'+
		    		'</div>'+
					'<div class="mainarea-in-list" >'+
			        '<h4>'+productarray[productindex].productname+'</h4>'+
			        '<h5>￥'+productarray[productindex].price+'</h5>'+
		    		'</div>'+
		    		'<p class="p-aside"></p>'+
	        		'</li>';
        	}else{
        		orderarray[i].count=0;
        	}
            }
		}
	
	$('#order-list').html(insert);
	setcontentshow(PAYCONTENT);
}


/*设定当前页面动态属性*/
function setcontentshow(contenttype){
	setcontentframeshow(contenttype);
	switch(contenttype){
		case PRODUCTCONTENT:
		for(var i=0;i<productarray.length;i++){
			if(productarray[i].sortid==currentsort){
				setproductitemshow(productarray[i].productid);
			}
		}
		break;
		case PAYCONTENT:
		for(var i=0;i<orderarray.length;i++){
			if(orderarray[i].count>0){
				setorderitemshow(orderarray[i].productid);
			}
		}
		break;
	}
}

//刷新页面动态部分
function setcontentframeshow(contenttype){
	switch(contenttype){
		case SORTCONTENT:
		setfootershow(contenttype);
		break;
		case PRODUCTCONTENT:
		setfootershow(contenttype);
		break;
		case PAYCONTENT:
		setfootershow(contenttype);
		if(ispayable==false){
    		$('#order-first-item').children('.mainarea-in-list').children('h4').html('休息中');
    		$('#order-first-item').children('.mainarea-in-list').children('h5').html('当前无法交易');
    		$(SUBMITBTN).children('.text-in-btn').html('休息中');
			$(SUBMITBTN).attr('disabled',true);
		}else if(!(totalordernum>0)){
    		$('#order-first-item').children('.mainarea-in-list').children('h4').html('当前订单');
    		$('#order-first-item').children('.mainarea-in-list').children('h5').html('您还没有选中任何订单');
    		$(SUBMITBTN).children('.text-in-btn').html('提交订单');
			$(SUBMITBTN).attr('disabled',false);
		}else{
    		$('#order-first-item').children('.mainarea-in-list').children('h4').html('当前订单');
    		if(needdeliveryfee){
    			$('#order-first-item').children('.mainarea-in-list').children('h5').html('总计：￥'+totalpay+'（含外送费：￥'+shopinfo.deliveryfee+'）');
    		}else{
    			$('#order-first-item').children('.mainarea-in-list').children('h5').html('总计：￥'+totalpay);
    		}
    		$(SUBMITBTN).children('.text-in-btn').html('提交订单');
			$(SUBMITBTN).attr('disabled',false);
		}
		if((totalordernum>0)){
    		$(CLEARBTN).show();
    		$(HAVELOOKBTN).hide();
		}else{
			$(CLEARBTN).hide();
    		$(HAVELOOKBTN).show();
		}
		break;
	}
}

function setfootershow(contenttype){
	switch(contenttype){
		case SORTCONTENT:
		$(BACKBTN).hide();
		$(SORTBTN).hide();
		$(PAYBTN).show();
		$('body').removeClass();
		$('body').addClass('body-with-footer');
		$('#paytitle').hide();
		$('#mainfooter').removeClass();
		$('#mainfooter').addClass('footer-to-bottom');
		break;
		case PRODUCTCONTENT:
		$(BACKBTN).hide();
		$(SORTBTN).show();
		$(PAYBTN).show();
		$('body').removeClass();
		$('body').addClass('body-with-footer');
		$('#paytitle').hide();
		$('#mainfooter').removeClass();
		$('#mainfooter').addClass('footer-to-bottom');
		break;
		case PAYCONTENT:	 
		$(BACKBTN).show();
	 	$(SORTBTN).hide();
	 	$(PAYBTN).hide();
	 	$('body').removeClass();
		$('body').addClass('body-with-header');
	 	$('#paytitle').show();
	 	$('#mainfooter').removeClass();
		$('#mainfooter').addClass('footer-to-top');
		break;
	}

	if(ispayable==false){
		$(PAYBTN).attr('disabled',true);
		$(PAYBTN).children('.text-in-btn').html('休息中');
		$(PAYBTN).children('.img-in-btn').css('background',getbackground(INSLEEPBTN));
	}else{
		$(PAYBTN).attr('disabled',false);
		$(PAYBTN).children('img-in-btn').css('background',getbackground(PAYBTN));
		if(totalpay>0&&totalordernum>0){
			$(PAYBTN).addClass('btn-highlight');
		}else{
			$(PAYBTN).removeClass('btn-highlight');
		}
		$(PAYBTN).children('.text-in-btn').html('结算 ￥'+totalpay);
	}

}

//刷新product页面中每项的显示
function setproductitemshow(productid){
	var orderindex=findorderbyid(productid);
	var productindex=findproductbyid(productid);
	if(ispayable==false){
		$('#product-'+productid).children('.p-aside').hide();
		$('#product-'+productid).children('.tipsarea-in-list').show();
		$('#product-'+productid).children('.btnarea-in-list').hide();
		$('#product-'+productid).children('.tipsarea-in-list').children('h4').html('休息中');
	}else if(orderindex<0||productindex<0||orderarray[orderindex].count<=0){
		$('#product-'+productid).children('.p-aside').hide();
		if(productarray[productindex].productleft<=0){
			$('#product-'+productid).children('.tipsarea-in-list').show();
			$('#product-'+productid).children('.btnarea-in-list').hide();
			$('#product-'+productid).children('.tipsarea-in-list').children('h4').html('已售罄');
		}else{
			$('#product-'+productid).children('.tipsarea-in-list').hide();
			$('#product-'+productid).children('.btnarea-in-list').show();
			$('#product-'+productid).children('.btnarea-in-list').children(MINUSBTN).attr('disabled',true);
			$('#product-'+productid).children('.btnarea-in-list').children(PLUSBTN).attr('disabled',false);
		}
	}else{
		$('#product-'+productid).children('.p-aside').show();
		$('#product-'+productid).children('.tipsarea-in-list').hide();
		$('#product-'+productid).children('.btnarea-in-list').show();
		if(orderarray[orderindex].count<productarray[productindex].productleft){
			$('#product-'+productid).children('.btnarea-in-list').children(MINUSBTN).attr('disabled',false);
			$('#product-'+productid).children('.btnarea-in-list').children(PLUSBTN).attr('disabled',false);
			var insert='已点数量:'+orderarray[orderindex].count;
			$('#product-'+productid).children('.p-aside').html(insert);
		}else if(orderarray[orderindex].count==productarray[productindex].productleft){
			$('#product-'+productid).children('.btnarea-in-list').children(MINUSBTN).attr('disabled',false);
			$('#product-'+productid).children('.btnarea-in-list').children(PLUSBTN).attr('disabled',true);
			var insert='已点数量:'+orderarray[orderindex].count;
			$('#product-'+productid).children('.p-aside').html(insert);
		}else{
			$('#product-'+productid).children('.btnarea-in-list').children(MINUSBTN).attr('disabled',false);
			$('#product-'+productid).children('.btnarea-in-list').children(PLUSBTN).attr('disabled',true);
			var insert='库存不足！';
			$('#product-'+productid).children('.p-aside').html(insert);
		}
	}
}

//刷新order页面中每项的显示
function setorderitemshow(productid){
	var productindex=findproductbyid(productid);
	var orderindex=findorderbyid(productid);
	if(productindex<0||orderindex<0||orderarray[orderindex].count<=0){
		$('#order-'+productid).remove();
	}else{
		if(ispayable==false){
			$('#order-'+productid).children('.p-aside').hide();
			$('#order-'+productid).children('.tipsarea-in-list').show();
			$('#order-'+productid).children('.btnarea-in-list').hide();
			$('#order-'+productid).children('.tipsarea-in-list').children('h4').html('休息中');
		}else{
			$('#order-'+productid).children('.p-aside').show();
			$('#order-'+productid).children('.tipsarea-in-list').hide();
			$('#order-'+productid).children('.btnarea-in-list').show();
			if(orderarray[orderindex].count<productarray[productindex].productleft){
				$('#order-'+productid).children('.btnarea-in-list').children(MINUSBTN).attr('disabled',false);
				$('#order-'+productid).children('.btnarea-in-list').children(PLUSBTN).attr('disabled',false);
				var insert='已点数量:'+orderarray[orderindex].count;
				$('#order-'+productid).children('.p-aside').html(insert);
			}else if(orderarray[orderindex].count==productarray[productindex].productleft){
				$('#order-'+productid).children('.btnarea-in-list').children(MINUSBTN).attr('disabled',false);
				$('#order-'+productid).children('.btnarea-in-list').children(PLUSBTN).attr('disabled',true);
				var insert='已点数量:'+orderarray[orderindex].count;
				$('#order-'+productid).children('.p-aside').html(insert);
			}else{
				$('#order-'+productid).children('.btnarea-in-list').children(MINUSBTN).attr('disabled',false);
				$('#order-'+productid).children('.btnarea-in-list').children(PLUSBTN).attr('disabled',true);
				var insert='库存不足！';
				$('#order-'+productid).children('.p-aside').html(insert);
			}
		}	
	}
}




//toast提示
function Toast(msg,duration){
	$('#mytoast').html(msg);
	$('#mytoast').removeClass('toast-hide');
	$('#mytoast').addClass('toast-show');
	duration=isNaN(duration)?3000:duration;
    clearTimeout(mytoasttimeout);
	mytoasttimeout=setTimeout(function() {
		$('#mytoast').removeClass('toast-show');
		$('#mytoast').addClass('toast-hide');
	}, duration);
}



function firstcallcontent(){
	footerprepare();
	personalinfoprepare();
    if(firstsortid>=0){
    	showproductcontent(firstsortid);
    }else{
    	showsortcontent();
    }
    contenteventbind();
}

function refreshcontent(){
	switch(currentcontent){
		case SORTCONTENT:
		showsortcontent();
		break;
		case PRODUCTCONTENT:
		showproductcontent();
		break;
		case PAYCONTENT:
		showpaycontent();
		break;
	}
	sortcontentscroll=0;
	productcontentscroll=0;
}


/*controller*/
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
		if(!isverified){
			Toast('非验证状态无法下单',2000);
			$('html, body').animate({scrollTop: 0}, 500);
		}else if(!checkinput('#name')){
			Toast('请正确输入您的姓名',2000);
            $('#name').focus();
		}else if(!checkinput('#number')){
			Toast('请正确输入您的手机号或电话号码',2000);
            $('#number').focus();
		}else if(!checkselect('#select-area')){
			Toast('请选择合适的外送片区',2000);
			$('#select-area').focus();
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
		}else if(overleft){
			Toast('您的订单中存在超额',2000);
        	$('html, body').animate({scrollTop: 0}, 500);
		}else{
			
		myuesrname=$('#name').val();
		myphonenumber=$('#number').val();
		myareaid=$('#select-area').val();
		myareadesc=$('#areadesc').val();
		mytips=$('#tips').val();
		writeinfolocal(myuesrname,myphonenumber,myareaid,myareadesc);

		if(confirm('确认提交订单？')){
			$.ajax({
		        type:'POST',
		        dataType: 'json',
		        url:  AJAXFORSUBMIT,
		        data:{sellerid:sellerid,openid:openid,wapKey:identitykey,name:myuesrname,phone:myphonenumber, areaid:myareaid,areadesc:myareadesc,tips:mytips, products:products, nums:nums},
		        success:function(data,textStatus){
		            if(data.success=='1'){
						Toast('下单成功',2000);
						clearorder();
						orderload();
		            }else if(data.success=='2'){
		            	if(data.result=='user not exsit'||data.result=='wapKey is out'){
		            		callwrongkey();
		            		Toast('非验证状态无法下单',2000);
		            		showpaycontent();
		            	}else if(data.result=='order total is low'||data.result=='areaid is out'||data.result=='service is out'){
		            		if(confirm('数据冲突，是否立即更新？')){
			            		dataload(false,false,true,false,true);
			            	}
		            	}else if(data.result=='number is not enough'||data.result=='product id is out'){
		            		if(confirm('数据冲突，是否立即更新？')){
			            		dataload(true,true,false,false,false);
			            	}
		            	}else if(confirm('数据冲突，是否立即更新？')){
		            		dataload(true,true,true,true,true);
		            	}
		            }else if(data.success=='3'){
		            	Toast('存在异常输入',2000);
		            }else{
						callwrongkey();
						Toast('非验证状态无法下单',2000);
		            	showpaycontent();
		            }
		        
		        },
		        error:function(XMLHttpRequest,textStatus,errorThrown){ 
		         	Toast('下单失败，请检查网络并重试',4000);
		        },
		    });  
	    }  
	  }

}

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
		break;
	}
}

function topay(){
	showpaycontent();
}

function callsuccesspay(order){
	var insert='';
	insert+='<button class="btn-icon-text" onclick=newstart() id="newstart-btn">'+
	'<span class="text-in-btn">继续下单</span>'+
	'<span class="img-in-btn" style="background:'+getbackground(NEWSTARTBTN)+';"></span>'+
	'</button>';
	$('#newstart-btnarea').html(insert);
	insert='';
	if(order!=null){
		insert+='<p style="font-size:16px;font-weight:700;">订单号：'+order.order_no+'</p>'+
		'<br />订餐者姓名：'+order.name+
		'<br />联系电话：'+order.phone+
		'<br />收货地点：'+order.address+
		'<br />下单时间：'+order.ctime+
		'<br />订单备注：'+(order.tips!=''?order.tips:'无')+
		'<br />'+
		'<br />订单明细：'+order.order_items+
		'<br />订单总价：￥'+order.total+
		'</div>';
		$('#tips-orderdesc-ordersuccess').html(insert);
	}else{
		insert+='订单获取失败';
		$('#tips-orderdesc-ordersuccess').html(insert);
	}
	$(currentcontent).hide();
	$(PAYSUCCESS).show();
}
function toclearorder(){
	if (confirm('您确定清空购物车吗？')) { 
		clearorder();
		switch(currentcontent){
			case PAYCONTENT:
			fillpaycontent();
			break;
			case PRODUCTCONTENT:
			setcontentshow(currentcontent);
			break;
			default:
			setcontentframeshow(currentcontent);
			break;
		}
	}
}

function toaddorder(productid1){
	if(addorder(productid1)){
		switch(currentcontent){
			case PRODUCTCONTENT:
			setproductitemshow(productid1);
			setcontentframeshow(currentcontent);
			break;
			case PAYCONTENT:
			setorderitemshow(productid1);
			setcontentframeshow(currentcontent);
			break;
			default:
			setcontentframeshow(currentcontent);
			break;
		}
	}
	
}
function todeleteorder(productid1){
	if(deleteorder(productid1)){
		switch(currentcontent){
			case PRODUCTCONTENT:
			setproductitemshow(productid1);
			setcontentframeshow(currentcontent);
			break;
			case PAYCONTENT:
			setorderitemshow(productid1);
			setcontentframeshow(currentcontent);
			break;
			default:
			setcontentframeshow(currentcontent);
			break;
		}
	}
}
function havelook(){
	var max=sortarray.length-1;
	var luky=parseInt(Math.random()*(max+1));
	showproductcontent(sortarray[luky].sortid);
}

function newstart(){
	$(PAYSUCCESS).hide();
	showsortcontent();
	dataload(true,true,true,true,true);
}

//检查输入
function checkinput(element1) {
    if ($.trim($(element1).val()).length<=0&&$(element1).data('nonull')==true) {//输入框里值为空，或者为一些特定的文字时，都提示输入不能为空
		$(element1).prev('label').html('输入不能为空');
		$(element1).prev('label').show();
        return false;
    }else if($(element1).attr('type')=='tel'&&!checkphonenumber($(element1).val())){
    	$(element1).prev('label').html('请正确输入手机号或电话号码<br />示例：15353535353 或 02583622222');
    	$(element1).prev('label').show();
    	return false
    }else if($.trim($(element1).val()).length>$(element1).data('maxinput')){
    	$(element1).prev('label').html('输入过长（'+$(element1).data('maxinput')+'字以内）');
    	$(element1).prev('label').show();
        return false;
    }else{
    	$(element1).prev('label').html('');
    	$(element1).prev('label').hide();
        return true;
    }
}

//检查电话输入
function checkphonenumber(number){
	String.prototype.isMobile = function() {  
		return (/^(1[3|4|5|8][0-9]\d{8})$/.test($.trim(this))); 
	} 
	String.prototype.isTel = function(){
	    return (/^(0\d{2,3}\d{7,8})?$/.test($.trim(this)));
	}
	if (number.isMobile()||number.isTel())  {  
        return true;  
    }else {  
        return false;        
    } 
}

//修改选择框描述
function checkselect(element1){
	var areaindex=findarerbyid($(element1).val());
	if(areaindex>=0&&deliveryareaarray[areaindex].areastatus){
		$(element1).next('label').html(deliveryareaarray[areaindex].areadesc);
		$(element1).prev('label').html('');
		$(element1).prev('label').hide();
		return true;
	}else {
		$(element1).next('label').html('');
		$(element1).prev('label').show();
		if($(element1).val()==null){
			$(element1).prev('label').html('尚未选中任何片区');
		}else{
			$(element1).prev('label').html('该片区今日不外送，请重新选择');
		}
		return false;
	}
}

function showitemdesc(element1){
	var lis=$(element1).siblings();
	for(var i=0;i<lis.length;i++){
		if($(lis[i]).data('descexist')==DESCSHOW){
			hidedesc(lis[i]);
		}
	}
	var mydescexist=$(element1).data('descexist')
	if(mydescexist==DESCNOEXIST){
		initdesc(element1);
	}else if(mydescexist==DESCHIDE){
		showdesc(element1);
	}else if(mydescexist==DESCSHOW){
		hidedesc(element1);
	}
}
function initdesc(element1){
	var myproductid=$(element1).data('value');
	var myproductindex=findproductbyid(myproductid);
	if(myproductindex>=0){
		var myproductdesc=(productarray[myproductindex].productdesc!=null&&productarray[myproductindex].productdesc!='')?productarray[myproductindex].productdesc:'该商品无详细描述';
		var insert='';
		insert+='<div class="descarea-in-list">'+
			'<img class="myimg" onerror=errorajust(this) src="'+BASEURL+productarray[myproductindex].productimg+'" alt="无真相>_<~">'+
			'<p>'+(myproductdesc!=''?myproductdesc:'无描述信息')+'</p>'+
			'</div>';
		$(element1).append(insert);
	}else{
		var insert='';
		insert+='<div class="descarea-in-list">'+
			'<p>无数据</p>'+
			'</div>';
		$(element1).append(insert);
	}
	$(element1).addClass('product-item-showdesc');
	$(element1).data('descexist',DESCSHOW);
	$(element1).children('.showmore').hide();
}
function hidedesc(element1){
	$(element1).children('.descarea-in-list').hide();
	$(element1).removeClass('product-item-showdesc');
	$(element1).data('descexist',DESCHIDE);
	$(element1).children('.showmore').show();
}
function showdesc(element1){
	$(element1).children('.descarea-in-list').show();
	$(element1).addClass('product-item-showdesc');
	$(element1).data('descexist',DESCSHOW);
	$(element1).children('.showmore').hide();
}

function errorajust(element1){
	$(element1).css('height','100px');
	$(element1).css('background','#fff');
}

//获得图片资源
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
		case RIGHTARROR:
		position=8;
		break;
		case NEWSTARTBTN:
		position=10;
		break;
		case INSLEEPBTN:
		position=11;
		break;
	}
	var positionx=0-position*ICONSIZE;
	var bgset='url('+BASEURLICON+') no-repeat '+positionx+'px 0'
	return bgset;
}


