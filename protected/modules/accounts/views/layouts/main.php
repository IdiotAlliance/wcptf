<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <!-- Bootstrap core CSS -->
    <?php Yii::app()->clientScript->registerCoreScript('jquery');?>
    <?php Yii::app()->bootstrap->register(); ?>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/index.css" rel="stylesheet" type="text/css">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>
    <?php $this->widget('bootstrap.widgets.TbNavbar',array(
        'type'=>'inverse',
        'brand'=>'微积分',
        'brandUrl'=>'./',
        'fixed'=>'top', 
        'items'=>array(
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                'items'=>array(
                    array('label'=>'首页', 'url'=>'#', 'active'=>true),
                    array('label'=>'了解详细', 'url'=>'#'),
                    array('label'=>'价格方案', 'url'=>'#'),
                ),
            ),
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                'htmlOptions'=>array('class'=>'pull-right'),
                'items'=>array(
                    array('label'=>'注册', 'url'=>array('/accounts/register/association'), 'visible'=>Yii::app()->user->isGuest),
                    array('label'=>'登录', 'url'=>array('/accounts/login/login'), 'visible'=>Yii::app()->user->isGuest),
                    array('label'=>'退出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
            ),
        ),
    )); ?>
    
    <header class='jumbotron'></header>


    <!-- 页面主体内容-->
    <?php echo $content; ?>     


</body>
</html>
