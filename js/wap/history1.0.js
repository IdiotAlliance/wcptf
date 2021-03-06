//单次载入订单数
var LIMITNUM=10;
//button
var LOADMOREBTN='#loadmore-btn';
var MAKECALLBTN='#makecall-btn';
var BACKBTN='#back-btn';
var RIGHTARROR='rightarror';

var ORDERCONTENT='#ordercontent';

//icon大小
var ICONSIZE=20;

var nexttime=null;
var mytoasttimeout=null;
var isorderlistprepared=false;
function firstinit(){
	baseeventbind();
	orderload(null,LIMITNUM);

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
function orderload(endtime,num){
	$.ajax({
        type:'POST',
        dataType: 'json',
        url:  AJAXFORRESULT,
        data:{sellerid:sellerid,wapKey:identitykey,openid:openid,endtime:endtime,num:num},
        success:function(data,textStatus){
            if(data.success=='1'){
				nexttime=data.nexttime;
            	callmyorderlist(data.result,data.sellerphone);
            }else{  
        		$('#ordercontent').hide();
	            callerror(WRONGKEY);
            } 
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){ 
        	var restartorderload=function (){ 
				orderload(endtime,num);
			};   
			$('#ordercontent').hide();
            callerror(WRONGDATA,restartorderload);
        }  
    });    
}
function callmyorderlist(orders,sellerphone){
	if(!isorderlistprepared){
		orderlistprepared(sellerphone);
	}
	var insert='';
	for(var i=0;i<orders.length;i++){
		insert='';
		order=orders[i];
		if(order!=null){
			insert+='<div class="tips-content">'+
			'<p style="font-size:16px;font-weight:700;">订单号：'+order.order_no+'</p>'+
			'<p class="tips-orderdesc-orders">'+
			'<br />订餐者姓名：'+order.name+
			'<br />联系电话：'+order.phone+
			'<br />收货地点：'+order.address+
			'<br />下单时间：'+order.ctime+
			'<br />订单备注：'+(order.tips!=''?order.tips:'无')+
			'<br />'+
			'<br />订单明细：'+order.order_items+
			'<br />订单总价：￥'+order.total+
			'<br />'+
			'<br />订单状态：'+order.status;
			if(order.status=='派送中'){
				insert+='<br />送餐员：'+order.poster_name+
				'<br />送餐员电话：<a href="tel:'+order.poster_phone+'">'+order.poster_phone+'</a>';
			}
			insert+='</p></div>';
		}else{
			insert+='订单获取失败';
		}
		$('#tips-orders').append(insert);
	}
	if(nexttime==null||nexttime==''){
		$('#loadmore-btnarea').hide();
		$(LOADMOREBTN).attr('disabled',true);
		Toast('已全部载入',2000);
	}else{
		$(LOADMOREBTN).attr('disabled',false);
		$('#loadmore-btnarea').show();
	}
	$(ORDERCONTENT).show();
}
function orderlistprepared(sellerphone){
	var insert='<a class="btn-icon-text" href="tel:'+sellerphone+'" id="makecall-btn">'+
		'<p class="text-in-btn" id="havelook">拨号</p>'+
		'<div class="img-in-btn" style="background:'+getbackground(MAKECALLBTN)+';"></div>'+
		'</a>';
	$('#tips-title').append(insert);
	insert='<button class="btn-icon-text" id="loadmore-btn">'+
	'<p class="text-in-btn">加载更多</p>'+
	'<div class="img-in-btn" style="background:'+getbackground(LOADMOREBTN)+';"></div>'+
	'</button>';
	$('#loadmore-btnarea').append(insert);
	$(LOADMOREBTN).click(function(){
		$(LOADMOREBTN).attr('disabled',true);
		orderload(nexttime,LIMITNUM);
	});
	isorderlistprepared=true;
}

//toast提示
function Toast(msg,duration){
	$('#mytoast').html(msg);
	$('#mytoast').css('left','0px');
    $('#mytoast').css('-webkit-transition', 'all 200ms ease');
    $('#mytoast').css('transition', 'all 200ms ease');
    $('#mytoast').css('-webkit-transition-property', 'left');
    $('#mytoast').css('transition-property', 'left');
	duration=isNaN(duration)?3000:duration;
    clearTimeout(mytoasttimeout);
	mytoasttimeout=setTimeout(function() {
		$('#mytoast').removeAttr('style');
	}, duration);
}


//获得图片资源
function getbackground(btnname){
	var position=0;
	switch(btnname){
		case BACKBTN:
		position=0;
		break;
		case RIGHTARROR:
		position=1;
		break;
		case MAKECALLBTN:
		position=2;
		break;
		case LOADMOREBTN:
		position=3;
		break;
	}
	var positionx=0-position*ICONSIZE;
	var bgset='url('+BASEURLICON+') no-repeat '+positionx+'px 0'
	return bgset;
}
