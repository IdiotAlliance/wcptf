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
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main_v0_7.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
		(function(win){
			var self = this;
			win.MESSAGE_LOADER = self;
			self.currentId = <?php echo $this->currentStore->id?>;
			self.currentAction = "<?php echo $this->action?>";

			win.GLOBALS = {};
			win.GLOBALS.storeCount = <?php echo count($this->stores); ?>;
			win.GLOBALS.sid = <?php echo $this->currentStore->id;?>;
		})(window);
	</script>
</head>

<body>
	<?php
	$orderItems = array();
	$memberItems = array();
	foreach ($this->stores as $store) {
		if($store->id != $this->currentStore->id){
			array_push(
				$orderItems,
				array(
					  'sid'=>$store->id,
					  'label'=>$store->name, 
					  'url'=>Yii::app()->createUrl('messages/message/redirect', array('type'=>1, 'sid'=>$store->id)))
			);
			array_push(
				$memberItems,
				array(
					  'sid'=>$store->id,
					  'label'=>$store->name, 
					  'url'=>Yii::app()->createUrl('messages/message/redirect', array('type'=>3, 'sid'=>$store->id)))
			);	
		}
	}?>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a href="/weChat/index.php/" class="brand">微积分</a>
				<ul class="pull-right nav" id="yw0">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">消息
							<div class="badge badge-important" id="msg_total_badge"></div>
							<span class="caret"></span>
						</a>
						<ul id="yw1" class="dropdown-menu">
							<li>
								<a tabindex="-1" 
								   href="<?php echo Yii::app()->createUrl('messages/message/redirect', array('type'=>0))?>">系统消息
									<div id="system_msg_badge" class="badge"></div>
								</a>
							</li>
							<!--
							<li>
								<a tabindex="-1" 
									href="<?php echo Yii::app()->createUrl('messages/message/redirect', array('type'=>2))?>">微信消息
									<div id="wechat_msg_badge" class="badge member-badge"></div>
								</a>
							</li>
							-->
							<li class="<?php if($orderItems) echo 'dropdown-submenu'; else echo '';?>">
								<a tabindex="-1" href="#">订单消息
									<div id="order_msg_badge" class="badge order-badge"></div>
								</a>
								<ul id="yw2" class="dropdown-menu">
									<?php
										foreach ($orderItems as $orderItem) {
											echo '<li><a tabindex="-1" href="'.
												 $orderItem['url'].
												 '">'.$orderItem['label'].
												 	'<div class="badge order-badge" id="order_badge_'.$orderItem['sid'].'"></div>'.
												 '</a></li>';
										}
									?>
								</ul>
							</li>
							<li class="<?php if($orderItems) echo 'dropdown-submenu'; else echo '';?>">
								<a tabindex="-1" href="#">最新评论
									<div id="comment_msg_badge" class="badge comment-badge"></div>
								</a>
								<ul id="yw3" class="dropdown-menu">
									<?php
										foreach ($memberItems as $memberItem) {
											echo '<li><a tabindex="-1" href="'.
												 $memberItem['url'].
												 '">'.$memberItem['label'].
												 	'<div class="badge comment-badge" id="comment_badge_'.$memberItem['sid'].'"></div>'.
												 '</a></li>';
										}
									?>
								</ul>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">设置 <span class="caret"></span>
						</a>
						<ul id="yw5" class="dropdown-menu">
							<li>
								<a tabindex="-1" href="<?php echo Yii::app()->createUrl('accounts/account/stores')?>">店铺管理</a>
							</li>
							<li>
								<a tabindex="-1" href="<?php echo Yii::app()->createUrl('accounts/replyRules/allRules')?>">消息设置</a>
							</li>
							<li>
								<a tabindex="-1" href="<?php echo Yii::app()->createUrl('accounts/account/profile')?>">账户信息</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="<?php echo Yii::app()->createUrl('accounts/help/help'); ?>">帮助</a>
					</li>
					<li>
						<a tabindex="-1" href="<?php echo Yii::app()->createUrl('site/logout'); ?>">退出</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class='main'>
		<div class='sidebar'>
			<div class='menuHeader' onclick="expandStoreSwitch()">
				当前店铺：<b><?php echo $this->currentStore->name?></b>
				<div class="store_switch">
					<?php 
						foreach ($this->stores as $store) {
							if($store->id != $this->currentStore->id){
								$url = Yii::app()->request->url;
								$url = preg_replace('/(\d+)$/', $store->id, $url);
								echo '<div class="store_item" onclick="window.location='."'".$url."'".'">'.$store->name.'</div>';
							}
						}
					?>
				</div>
			</div>
			<div class='menu'>
				<h4>
					<a href="#"><i class='icon-list-alt'></i> &nbsp&nbsp订单管理
					<div class="badge badge-important" id="order_manage_badge"></div></a>
				</h4>
				<ul>
					<li><a href="<?php echo Yii::app()->createUrl('takeAway/orderFlow/orderFlow').'?sid='.$this->currentStore->id?>">订单流</a></li>
					<li><a href="#">订单2</a></li>					
				</ul>
			</div>
			<div class='menu'>
				<h4>
					<a href="#"><i class='icon-shopping-cart'></i> &nbsp&nbsp商品管理</a>
				</h4>
				<ul id="category">
					<?php foreach ($this->typeCount as $tc):?>
						<li>
							<a href="<?php echo Yii::app()->createUrl('takeAway/productManager/allProducts',array('typeId'=>$tc['typeId'],'prodId'=>0)).'?sid='.$this->currentStore->id;?>">
								<?php echo $tc['type_name'];?>
								<i>(<?php echo $tc['product_count'];?>)</i>
							</a>
						</li>
					<?php endforeach;?>					
					<li id='categoryInput' style="display:none"><input type="text" placeholder='输入分组名'></input></li>
					<li><a id='newCategory'><i class='icon-plus'></i> 添加类别</a></li>
				</ul>
			</div>
			<div class='menu'>
				<h4><a href="<?php echo Yii::app()->createUrl('takeAway/members').'?sid='.$this->currentStore->id;?>">
					<i class='icon-user'></i> &nbsp&nbsp会员管理
						<div class="badge badge-important" id="comment_manage_badge"></div>
					</a>
				</h4>
			</div>
			<!--
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
			-->
			<div class='menu'>
				<h4><a href="<?php echo Yii::app()->createUrl('takeAway/sellerProfile').'?sid='.$this->currentStore->id;?>">
					<i class='icon-edit'></i> &nbsp&nbsp店铺信息</a></h4>
			</div>
			<div class='menu'>
				<h4><a href="<?php echo Yii::app()->createUrl('takeAway/sellerSettings').'?sid='.$this->currentStore->id;?>">
					<i class='icon-wrench'></i> &nbsp&nbsp店铺设置</a></h4>
			</div><!-- 
			<div class='menuAction'>
				<ul>
					<li><a href="#"><i class='icon-plus'></i></a></li>
					<li><a href="#"><i class='icon-cog'></i></a></li>
				</ul>
			</div> -->
		</div>
		<div id="toast-container">
			<div id="toast"></div>
		</div>
        <!-- 页面主体内容-->
        <?php echo $content; ?>		
	</div>
<script type="text/javascript" src="<?php echo Yii::app()->createUrl('/resource/resource/js/name/mainv0_7')?>"></script>
</body>
</html>
