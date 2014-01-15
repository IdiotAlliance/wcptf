
 <script type="text/javascript">
	//初始化
    var initTitle = "<div class='line'>"+
			"<div class='content cardNo'>"+
				"点卡卡号"+
			"</div>"+
			"<div class='content password'>"+
				"点卡密码"+
			"</div>"+
			"<div class='content value'>"+
				"点数"+
			"</div>"+
		"</div>"
    $(document).ready(function(){
        $(".btn.btn-primary.generate").click(function(){
        	 var value = $("input[name='prepaid-value']").val();
        	 var num = $("input[name='prepaid-num']").val();
        	 $(".card-area").html(initTitle);
        	 generateCard(value, num);
        });
    	$(".card-area").append(initTitle);
    });
    function generateCard(value, num){
    	var ctUrl = '/weChat/index.php/payment/prepaidCard/generateCard';
    	$.ajax({
    	    url      : ctUrl,
    	    type     : 'POST',
    	    dataType : 'json',
    	    data 	 : {value:value, num:num},
    	    cache    : false,
    	    success  : function(data)
    	    { 
    	    	if(data.success==0){
    	    		alert("网络错误！");
    	    	}else if(data.success==1){
    	    		alert("成功！");
    	    		var cards = data.cards;
    	    		var len = cards.length;
    	    		for(var i=0; i<len; i++){
    	    			appendCard(cards[i].cardNo, cards[i].password, cards[i].value);
    	    		}
    	    	}else if(data.success==2){
    	    		alert("参数小于0！");
    	    	}else if(data.success==3){
    	    		alert("参数中有字符串！");
    	    	}
    	    },
    	    error:function(){
    	        alert('Request failed');
    	    }
    	});
    }
    function appendCard(cardNo, password, value){
    	var html = "<div class='line'>"+
				"<div class='content cardNo'>"+
					cardNo+
				"</div>"+
				"<div class='content password'>"+
					password+
				"</div>"+
				"<div class='content value'>"+
					value+
				"</div>"+
			"</div>"
    	$(".card-area").append(html);
    }
</script>
<div class="main-panel">
	<div class="main-content">
		<p>充值卡点数</p>
		<input size="16" type="text"  name="prepaid-value">
		<p>数量</p>
		<input size="16" type="text"  name="prepaid-num" >
		<div class="button-area">
			<button class="btn btn-primary generate"> 生成 </button>
		</div>
		<div class="card-area">
		</div>
	</div>
</div>