var SMALLICONSIZE=20;
var BIGICONSIZE=64;

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

var code=null; //在全局 定义验证码   

function data(){

}

function firstinit(){
  createcode();
  viewprepare();
  baseeventbind();
}

function viewprepare(){
  $('#historyorder').find('.list-item-img').css('background',getbackground(HISTORYORDER));
  $('#phonebind').find('.list-item-img').css('background',getbackground(PHONEBIND));
  $('#cardbind').find('.list-item-img').css('background',getbackground(CARDBIND));
  $('.list-item-icon').css('background',getbackground(RIGHTARROR));
}
function baseeventbind(){
}
function createcode(){    
  code = '';   
  var codelength = 4;//验证码的长度   
  var selectchar = new Array(0,1,2,3,4,5,6,7,8,9);//所有候选组成验证码的字符，当然也可以用中文的   
  for(var i=0;i<codelength;i++){  
  	var charindex = Math.floor(Math.random()*10);   
  	code +=selectchar[charindex];  
  }     
  $('#checkcode').val(code);  
}   
        
function validate ()   {   
  var inputCode = $("#verifycodeinput").value();   
  if(inputCode.length <=0){   
    alert("请输入验证码！");   
    return false;
  }else if(inputCode != code ){   
    alert("验证码输入错误！");   
    checkcode();//刷新验证码   
    return false;
  }else{    
    return true; 
  }   
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