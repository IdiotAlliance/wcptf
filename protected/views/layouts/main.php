<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!-- Bootstrap core CSS -->
    <?php 
    Yii::app()->clientScript->registerCoreScript('jquery');
    ?>
    <?php Yii::app()->bootstrap->register(); ?>

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/index.css" rel="stylesheet">

    <!--[if it IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
   
</head>
<body>
    <?php $this->widget('bootstrap.widgets.TbNavbar',array(
        'type'=>'inverse',
        'brand'=>'微积分',
        'brandUrl'=>Yii::app()->createUrl(''),
        'fixed'=>'top', 
        'items'=>array(
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                'items'=>array(
                    array('label'=>'首页', 'url'=>array('/site/index'), 'active'=>true),
                    //array('label'=>'了解详细', 'url'=>'#'),
                    //array('label'=>'价格方案', 'url'=>'#'),
                ),
            ),
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                'htmlOptions'=>array('class'=>'pull-right'),
                'items'=>array(
                    array('label'=>'注册', 'url'=>array('/accounts/register/association'), 'visible'=>Yii::app()->user->isGuest),
                    array('label'=>'登录', 'url'=>array('/accounts/login/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'进入管理器', 'url'=>array('accounts/account/stores'), 'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'退出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				),
            ),
        ),
    )); ?>
    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    <?php echo $content; ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/holder.js"></script>
</body>
</html>