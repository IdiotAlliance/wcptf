<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- Bootstrap core CSS -->
	<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
    <?php Yii::app()->bootstrap->register(); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/wechat.css" rel="stylesheet" type="text/css">

</head>

<body>
	<?php $this->widget('bootstrap.widgets.TbNavbar',array(
        'type'=>'inverse',
        'brand'=>'微积分',
        'brandUrl'=>Yii::app()->createUrl('index'),
        'fixed'=>'top', 
        'items'=>array(
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                'htmlOptions'=>array('class'=>'pull-right'),
                'items'=>array(
                		array('label'=>'消息','url'=>'#','items'=>array(
                                array('label'=>'消息1','url'=>'#'),
                                array('label'=>'消息2','url'=>'#'),
                                array('label'=>'消息3','url'=>'#'),
                            )),
                        array('label'=>'帮助','url'=>'#','items'=>array(
                                array('label'=>'功能向导','url'=>'#'),
                                array('label'=>'视频教程','url'=>'#'),
                                array('label'=>'联系我们','url'=>'#'),
                            )),
                        array('label'=>'设置','url'=>'#','items'=>array(
                                array('label'=>'个人设置','url'=>'#'),
                                array('label'=>'退出','url'=>Yii::app()->createUrl("site/logout")),
                            )),
                    ),
            ),
        ),
    )); ?>

	<div class='main'>
		<div class='sidebar'>
			<div class='menu'>
				<h4><i class='icon-list-alt'></i> &nbsp&nbsp订单管理</a></h4>
				<ul>
					<li><a href="<?php echo Yii::app()->createUrl('takeAway/orderFlow/orderFlow')?>">订单流</a></li>
					<li><a href="#">订单2</a></li>					
				</ul>
			</div>
			<div class='menu'>
				<h4>
					<a href="<?php 
					if(Yii::app()->session['typeCount']!=null){
						echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>Yii::app()->session['typeCount'][0]['typeId']));
					}else{
						echo Yii::app()->createUrl('takeAway/productManager/noProducts');
					}

					?>"><i class='icon-shopping-cart'></i> &nbsp&nbsp商品管理<a>
				</h4>
				<ul id="category">
					<?php foreach (Yii::app()->session['typeCount'] as $tc):?>
					<li><a href="<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$tc['typeId']));?>"><?php echo $tc['type_name'];?><i>(<?php echo $tc['product_count'];?>)</i></a></li>
					<?php endforeach;?>					
					<li id='categoryInput' style="display:none"><input type="text" placeholder='输入分组名'></input></li>
					<li><a id='newCategory'><i class='icon-plus'></i> 添加类别</a></li>
				</ul>
			</div>
			<div class='menu'>
				<h4><a href="<?php echo Yii::app()->createUrl('takeAway/members');?>"><i class='icon-user'></i> &nbsp&nbsp会员管理</a></h4>
			</div>
			<div class='menu'>
				<h4><i class='icon-star'></i> &nbsp&nbsp活动管理</h4>
			</div>
			<div class='menu'>
				<h4><i class='icon-align-left'></i> &nbsp&nbsp统计分析</h4>
				<ul>
					<li><a href="#">人员访问量</a></li>
					<li><a href="#">用户丢失率</a></li>		
					<li><a href="#">用户丢失率</a></li>				
				</ul>
			</div>
			<div class='menu'>
				<h4><a href="<?php echo Yii::app()->createUrl('takeAway/sellerProfile');?>"><i class='icon-edit'></i> &nbsp&nbsp店铺信息</a></h4>
			</div>
			<div class='menu'>
				<h4><a href="<?php echo Yii::app()->createUrl('takeAway/sellerSettings');?>"><i class='icon-wrench'></i> &nbsp&nbsp店铺设置</a></h4>
			</div>
			<div class='menuAction'>
				<ul>
					<li><a href="#"><i class='icon-plus'></i></a></li>
					<li><a href="#"><i class='icon-cog'></i></a></li>
				</ul>
			</div>
		</div>

        <!-- 页面主体内容-->
        <?php echo $content; ?>		
	</div>
<script type="text/javascript">
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
		                url: "<?php echo CHtml::normalizeUrl(array('productManager/addCategory'));?>",
		                data: {'typeName':inputText},
		                dataType: 'json',
		                
		                success:function(json){
		                	window.location.href = "<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts');?>"+"/typeId/"+json.success;
		                },
		                error:function(json){
		                	alert("商品类别名重复！");
		                	$("#categoryInput").css('display','none');
		                },
		            }) 	
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


	});
</script>
</body>
</html>
