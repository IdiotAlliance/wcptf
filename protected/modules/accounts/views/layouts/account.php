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

</head>

<body>
    <!-- 页面主体内容-->
    <?php echo $content; ?>     
</body>
</html>