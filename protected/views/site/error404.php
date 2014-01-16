<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle='404 - 您访问的页面不存在';
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
<h2>错误404，您访问的页面不存在</h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>
<script type="text/javascript" src="http://www.qq.com/404/search_children.js" charset="utf-8"></script>
</div>