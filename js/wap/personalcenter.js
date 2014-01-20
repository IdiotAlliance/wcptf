//icon size
var SMALLICONSIZE=20;
var BIGICONSIZE=32;

//button
var LOADMOREBTN='#loadmore-btn';
var MAKECALLBTN='#makecall-btn';
var BACKBTN='#back-btn';
var RIGHTARROR='rightarror';
var SUBMITBTN='submitbtn';

//bigicon
var PHONEBIND='phonebind';
var CARDBIND='cardbind';
var HISTORYORDER='historyorder';

var MAINCONTENT='#maincontent';
var ORDERCONTENT='#ordercontent';

var mytoasttimeout=null;  

var personalinfo=null; 

function firstinit(){
  viewprepare();
  baseeventbind();
  baseinfoload();
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
  //显示并绑定
  if(isfromfather){
    $('#backkit').show();
    $('#backkit').click(function(){showbacktolist();});
    $('#tiny').css('background',getbackground(TINYSHOWBTN));
    $('#backtolist').click(function(){history.back();});
  }else{
    $('#backkit').hide();
  }
}

function viewprepare(){
  $('#historyorder').find('.list-item-img').css('background',getbackground(HISTORYORDER));
  $('#phonebind').find('.list-item-img').css('background',getbackground(PHONEBIND));
  $('#cardbind').find('.list-item-img').css('background',getbackground(CARDBIND));
  $('.list-item-icon').css('background',getbackground(RIGHTARROR));
  $('#back-btn').find('.img-in-btn').css('background',getbackground(BACKBTN));
}

function baseinfoload(){
  $.ajax({
        type:'POST',
        dataType: 'json',
        url:  AJAXFORRESULT,
        data:{storeid:storeid,wapKey:identitykey,openid:openid},
        success:function(data,textStatus){
            if(data.success=='1'){
              personalinfo=data.success;
              callmaincontent();
            }else{  
              $(MAINCONTENT).hide();
              callerror(WRONGKEY);
            } 
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){ 
          var restartpersonalinfoload=function (){ 
            baseinfoload();
          };   
          $(MAINCONTENT).hide();
          callerror(WRONGDATA,restartpersonalinfoload);
        }  
    });    
}

function callmaincontent(){
  $('#history-desc').html('最新订单：'+personalinfo.lastorder);
  showmaincontent();
}

/*界面调取方法*/
function showmaincontent(){
  $('#maincontent').show();
  $('#ordercontent').hide();
  $('#personalcenterfooter').hide();
}

function showordercontent(){
  $('#maincontent').hide();
  $('#ordercontent').show();
  orderload(null,LIMITNUM);
  $('#personalcenterfooter').show();
  $('#personaltitle').html(历史订单);
}

       //获得图片资源
function getbackground(btnname){
  var position=0;
  var bgset=null;
  var size=0;//0=small,1=big
  switch(btnname){
    //small
    case BACKBTN:
    position=0;
    size=0;
    break;
    case RIGHTARROR:
    position=1;
    size=0;
    break;
    case MAKECALLBTN:
    position=2;
    size=0;
    break;
    case LOADMOREBTN:
    position=3;
    size=0;
    break;
    case SUBMITBTN:
    position=4;
    size=0;
    break;
    //big
    case PHONEBIND:
    position=0;
    size=1;
    break;
    case CARDBIND:
    position=1;
    size=1;
    break;
    case HISTORYORDER:
    position=2;
    size=1;
    break;
  }
  if(size==0){
    var positionx=0-position*SMALLICONSIZE;
    var bgset='url('+BASEURLSMALLICON+') no-repeat '+positionx+'px 0'
  }else{
    var positionx=0-position*BIGICONSIZE;
    var bgset='url('+BASEURLBIGICON+') no-repeat '+positionx+'px 0'
  }
  return bgset;
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

function showbacktolist(){
  $('#backkit').removeClass('backkit-hide');
  $('#backkit').addClass('backkit-show');
  $('#tiny').css('background',getbackground(TINYHIDEBTN));
  $('#backkit').click(function(){hidebacktolist();});
    clearTimeout(mytoasttimeout);
  mytoasttimeout=setTimeout(function() {
    hidebacktolist();
  }, 3000);
  function hidebacktolist(){
    $('#backkit').removeClass('backkit-show');
    $('#backkit').addClass('backkit-hide');
    $('#backkit').click(function(){showbacktolist();});
    $('#tiny').css('background',getbackground(TINYSHOWBTN));
  }
}


/*
js for
history order
*/
//单次载入订单数
var LIMITNUM=10;

var nexttime=null;
var mytoasttimeout=null;
var isorderlistprepared=false;


function orderload(endtime,num){
  $.ajax({
        type:'POST',
        dataType: 'json',
        url:  AJAXFORRESULT,
        data:{storeid:storeid,wapKey:identitykey,openid:openid,endtime:endtime,num:num},
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
      insert+='<li class="orderhistory-item">'+
      '<div class="mainarea-in-list">'+
      '<h4>订单号：'+order.order_no+'</h4>'+
      '<h5>姓名：'+order.name+
      '<br />联系电话：'+order.phone+
      '<br />收货地点：'+order.address+
      '<br />订单备注：'+(order.tips!=''?order.tips:'无')+
      '<br />使用会员卡：'+order.use_card+
      '<br />下单时间：'+order.ctime+
      '<br />------------------------------------'+
      '<br />订单明细：'+order.order_items+
      '<br />订单总价：￥'+order.total+
      '<br />------------------------------------'+
      '<br />订单状态：'+order.status;
      if(order.status=='派送中'){
        insert+='<br />送餐员：'+order.poster_name+
        '<br />送餐员电话：<a href="tel:'+order.poster_phone+'">'+order.poster_phone+'</a>';
      }
      insert+='</h5></div></li>';
    }else{
      insert+='订单获取失败';
    }
    $('#orderhistory-list').append(insert);
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
    '<span class="text-in-btn" id="makecall">拨号</span>'+
    '<span class="img-in-btn" style="background:'+getbackground(MAKECALLBTN)+';"></span>'+
    '</a>';
  $('#orderhistory-first-item .btnarea-in-list').append(insert);
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
