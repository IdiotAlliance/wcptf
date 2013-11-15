<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=100%, initial-scale=1.0, user-scalable=no">
    
    <link rel="stylesheet"  href="<?php echo Yii::app()->request->baseUrl; ?>/css/wap/wechat.css">
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/wap/wechat.js"></script>
	<style>a{TEXT-DECORATION:none}</style>
</head>
<body>
	<!-- 页面主体内容-->
    <?php echo $content; ?>     
</body>
</html>