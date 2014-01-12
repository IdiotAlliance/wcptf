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
        'brandUrl'=>array('/site/index'),
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
                                array('label'=>'退出','url'=>array("/site/logout")),
                            )),
                    ),
            ),
        ),
    )); ?>

	<div class='main'>
		<div class='sidebar'>
			
			<div class='menu'>
				<h4><a href="#">&nbsp&nbsp回复设置</a></h4>
			</div>
			<div class='menu'>
				<h4><a href="<?php echo Yii::app()->createUrl('weiXinReply/replyRules/allRules');?>">&nbsp&nbsp回复规则</a></h4>
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
</body>
</html>
