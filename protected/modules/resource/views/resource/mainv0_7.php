(function(loader){
	loader.loadMessage = function(){
		$.ajax({
				url: "<?php echo Yii::app()->createUrl('messages/message/load')?>",
				dataType: 'json',
				success: function(data){
					var total = 0;
					total += self.handleSystemMessages(data['system']);
					total += self.handleOrderMessages(data['orders']);
					// total += self.handleWechatMessages(data['wcmsgs']);
					total += self.handleCommentMessages(data['comments']);
					self.setTotal(total);
					setTimeout(self.loadMessage, self.getTimeoutTime(data));
				},
				fail: function(data){
					setTimeout(self.loadMessage, self.getTimeoutTime(data));
				}
		});
	};
	loader.handleSystemMessages = function(count){
		var total = parseInt(count);
		if(total > 0)
			$('#system_msg_badge').html(total);
		else
			$('#system_msg_badge').html('');
		return total;
	};
	loader.handleOrderMessages = function(msgs){
		var total = 0;
		if(msgs){
			for(var key in msgs){
				if(parseInt(key) != self.currentId){
					$('#order_badge_' + key).html(msgs[key]);
					total += parseInt(msgs[key]);
				}else{
					if(parseInt(msgs[key]) > 0){
						$('#order_manage_badge').html(msgs[key]);
					}else{
						$('#order_manage_badge').html("");
					}
				}
				if(total > 0)
					$('#order_msg_badge').html(total);
				else
					$('#order_msg_badge').html('');
			}
		}else{
			$('.order-badge').html('');
		}
		return total;
	};
	loader.handleWechatMessages = function(count){
		var total = parseInt(count);
		if(total > 0)
			$('#wechat_msg_badge').html(total);
		else
			$('#wechat_msg_badge').html('');
		return total;
	};
	loader.handleCommentMessages = function(msgs){
		var total = 0;
		if(msgs){
			for(var key in msgs){
				if(parseInt(key) != self.currentId){
					$('#comment_badge_' + key).html(msgs[key]);
					total += parseInt(msgs[key]);
				}else{
					if(self.currentAction != "members" && parseInt(msgs[key]) > 0){
						$('#comment_manage_badge').html(msgs[key]);
					}
				}
				if(total > 0)
					$('#comment_msg_badge').html(total);
				else
					$('#comment_msg_badge').html('');
			}
		}else{
			$('.comment-badge').html('');
		}
		return total;
	};
	loader.setTotal = function(total){
		if(total > 0)
			$('#msg_total_badge').html(total);
		else
			$('#msg_total_badge').html('');
	};

	loader.getTimeoutTime = function(){
		return 10000;
	}
})(window.MESSAGE_LOADER);

(function(win){
	var self = this;
	win.TOAST = self;
	self.info = function(msg){
		$('#toast-container').removeClass();
		$('#toast-container').addClass('info');
		$('#toast-container').html(msg);
		self.expand();
	};
	self.success = function(msg){
		$('#toast-container').removeClass();
		$('#toast-container').addClass('success');
		$('#toast-container').html(msg);
		self.expand();
	};
	self.warn = function(msg){
		$('#toast-container').removeClass();
		$('#toast-container').addClass('warn');
		$('#toast-container').html(msg);
		self.expand();
	};
	self.err  = function(msg){
		$('#toast-container').removeClass();
		$('#toast-container').addClass('err');
		$('#toast-container').html(msg);
		self.expand();
	};
	self.expand = function(){
		$('#toast-container').animate({
			top: '0'
		}, 500, function(){
			setTimeout(self.contract, 2000);
		});
	}
	self.contract = function(){
		$('#toast-container').animate({
			top: '-30px'
		}, 500);
	}
})(window);

$(document).ready(function(){
	//显示添加分组输入框
	$('#newCategory').click(function(event){		
		event.stopPropagation();
		$("#categoryInput").css('display','block');
	});
	//回车添加分组
	$("#categoryInput").keyup(function(event){
		var key = event.which;
		if(key == 13){
			var inputText = $("#categoryInput input").val();
			if(inputText != ""){
				$.ajax({
	                type: 'POST',
	                url: "<?php echo CHtml::normalizeUrl(array('/takeAway/productManager/addCategory'));?>",
	                data: {'typeName':inputText,'sid':window.GLOBALS.sid},
	                dataType: 'json',
	                
	                success:function(json){
	                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+"/typeId/"+json.success+"/prodId/0/sid/"+window.GLOBALS.sid;
	                },
	                error:function(json){
	                	$("#categoryInput").css('display','none');
	                },
	            });
			}
			else{
				$("#categoryInput").css('display','none');
			}
		}				
	});
	
	//实现菜单的折叠效果
	$(".menu ul").hide();
	$(".menu h4").click(function(){
		if($(this).next("ul").css("display") == "block"){
			$(this).next("ul").addClass('active');
			$(".menu ul").not('.active').hide("slow");
		}else{
			$(".menu ul").hide('slow');
		}
		$(this).next("ul").slideToggle("slow");
	})
	
	$(".menu ul").hide();
	switch($("#action-name").attr('class')){
		case 'orderFlowController':
			$('.menu ul').eq(0).show();
			break;
		case 'productManager':
			$('.menu ul').eq(1).show();
			break;
		default:
			break;
	}

	MESSAGE_LOADER.loadMessage();
});
// this is a foo line
function expandStoreSwitch(){
	if(window.GLOBALS.storeCount > 1)
		$('.store_switch').slideToggle('fast');
}