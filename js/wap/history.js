//单次载入订单数
var LIMITNUM=10;

var mytoasttimeout=null;

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
            	callmyorderlist(data.result,data.nexttime);
            }else{  
	            callerror(WRONGKEY);
            } 
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){ 
        	var restartorderload=function (){ 
				orderload(endtime,num);
			};   
            callerror(WRONGDATA,restartorderload);
        }  
    });    
}
function callmyorderlist(orders,time){
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
			'<br />'+
			'<br />订单明细：'+order.order_items+
			'<br />订单总价：'+order.total+
			'<br />'+
			'<br />订单状态：'+order.status;
			if(order.poster_name!='无'){
				insert+='<br />送餐员：'+order.poster_name;
			}
			if(order.poster_phone!=''&&order.poster_phone!=null){
				insert+='<br />送餐员电话：<a href="tel:'+order.poster_phone+'">'+order.poster_phone+'</a>';
			}
			insert+='</p>'+
			'</div>';
		}else{
			insert+='订单获取失败';
		}
		$('#tips-orders').append(insert);
	}
	if(time==null||time==''){
		$('#newstart-btnarea').hide();
		Toast('已全部载入',2000);
	}else{
		insert=''
		insert+='<button class="btn-icon-text" id="loadmore-btn">'+
		'<p class="text-in-btn">加载更多</p>'+
		'</button>';
		$('#newstart-btnarea').html(insert);
		$('#loadmore-btn').click(function(){
			orderload(time,LIMITNUM);
		});
		$('#newstart-btnarea').show();
	}
	$('#order').show();
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