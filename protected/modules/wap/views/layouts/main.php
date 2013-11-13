<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <link rel="stylesheet"  href="<?php echo Yii::app()->request->baseUrl; ?>/css/wap/wechat.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/wap/wechat.js"></script>
</head>
<body>
	<!-- 页面主体内容-->
    <?php echo $content; ?>     
</body>
</html>