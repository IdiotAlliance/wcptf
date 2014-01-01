<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <!-- Bootstrap core CSS -->
    <?php Yii::app()->clientScript->registerCoreScript('jquery');?>
    <?php Yii::app()->bootstrap->register(); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>
    <!-- 页面主体内容-->
    <?php echo $content; ?>     
</body>
</html>