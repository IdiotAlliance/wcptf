<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle='500 - 请求发生错误';
$this->breadcrumbs=array(
	'Error',
);
?>
<style type="text/css">
	#error{
		padding: 40px 20% 0 20%;
	}
</style>
<div id='error'>
<h2>错误500，请求发生错误</h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>
</div>