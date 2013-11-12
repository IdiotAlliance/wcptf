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
					array('label'=>'进入管理器', 'url'=>array('takeAway/orderFlow/orderFlow'), 'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'退出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				),
            ),
        ),
    )); ?>
    
    <div id="myCarousel" class="carousel slide">
        <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>
        <!-- Carousel items -->
        <div class="carousel-inner">
            <div class="active item">
                <img src='data:image/png;base64,'data-src="holder.js/1400x500/auto/#666:#6a6a6a/text:Welcome" alt="Welcome">
                <div class="carousel-caption">
                  <h3>面向商家的第三方服务工具</h3>
                  <p>在这里你可以第一时间获取订单，与用户沟通</p>
                </div>
            </div>
            <div class="item">
                <img src="data:image/png;base64," data-src="holder.js/1400x500/auto/#666:#6a6a6a/text:Welcome" alt="Welcome">  
                    <div class='container'>
                    <div class="carousel-caption">
                        <h3>简单，好用的客户营销工具</h3>
                        <p>在这里你可以第一时间获取订单，与用户沟通</p>
                    </div>
                    </div>
            </div>
        </div>
        <!-- Carousel nav -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>
        
    <div id='features'>
        <div class='container'>
            <a class='feature'><i class="icon-shopping-cart icon-white"></i> 商品管理</a>
            <a class='feature'><i class="icon-user icon-white"></i> 会员管理</a>
            <a class='feature'><i class="icon-list-alt icon-white"></i> 订单管理</a>
            <a class='feature'><i class="icon-star icon-white"></i> 活动管理</a>
            <a class='feature'><i class="icon-align-left icon-white"></i> 统计分析</a>
            <a class='feature'><i class="icon-bullhorn icon-white"></i> 及时通知</a>
            <a class="tour-link">
                了解详细 <span class="icon-play icon-white"></span>     
            </a>
        </div>
    </div>
    
    <div id='customer'>
        <h1 class='text-center'>超过 <strong>1000</strong> 个商家的选择</h1>
        <ul class='logos'>
            <li class='l1'><a class='img-circle'>回品茶叶</a></li>
            <li class='l2'><a class='img-circle'>都市118连锁酒店</a></li>
            <li class='l3'><a class='img-circle'>风流屋</a></li>
            <li class='l4'><a class='img-circle'>上海古玩古董鉴定交流中心</a></li>
            <li class='l5'><a class='img-circle'>爱的平方婚典策划</a></li>
            <li class='l6'><a class='img-circle'>壹号线</a></li>
            <li class='l7'><a class='img-circle'>美丽妆品</a></li>
            <li class='l8'><a class='img-circle'>天鼎茶叶</a></li>
        </ul>
        <div style='height:300px;'></div>
        
    </div>
    
    <div class='unique'>
        <div class='container'>
        <div class='row'>
            <div class='span4'>
                <img src='' class='img-circle' data-src="holder.js/140x140" src="data:image/png;base64,">
                <h2>特点1</h2>
                <p>甚至我在windows下找搜狗甚至百度自家的输入法，都没有完全相同的功能。
                似乎都要先切到自身输入法的英文输入模式才能实现自动空格，但这样来回切换显
                然太繁琐，而且我的习惯是如果要切换就直接切换到英文键盘，免得一不小心和其
                他操作的快捷键冲突</p>
                <p>
                    <a class="btn btn-default" role="button" href="#">
                      查看详情 »
                    </a>
                </p>
            </div>
        
            <div class='span4'>
                <img src='' class='img-circle' data-src="holder.js/140x140" src="data:image/png;base64,">
                <h2>特点1</h2>
                <p>甚至我在windows下找搜狗甚至百度自家的输入法，都没有完全相同的功能。
                似乎都要先切到自身输入法的英文输入模式才能实现自动空格，但这样来回切换显
                然太繁琐，而且我的习惯是如果要切换就直接切换到英文键盘，免得一不小心和其
                他操作的快捷键冲突</p>
                <p>
                    <a class="btn btn-default" role="button" href="#">
                      查看详情 »
                    </a>
                </p>
            </div>
        
            <div class='span4'>
                <img src='' class='img-circle' data-src="holder.js/140x140" src="data:image/png;base64,">
                <h2>特点1</h2>
                <p>甚至我在windows下找搜狗甚至百度自家的输入法，都没有完全相同的功能。
                似乎都要先切到自身输入法的英文输入模式才能实现自动空格，但这样来回切换显
                然太繁琐，而且我的习惯是如果要切换就直接切换到英文键盘，免得一不小心和其
                他操作的快捷键冲突</p>
                <p>
                    <a class="btn btn-default" role="button" href="#">
                      查看详情 »
                    </a>
                </p>
            </div>
        </div>
        </div>
    </div>
    
    <div class='footer'>
        <div class='container'>
            <div class='links'>
                <a>关于我们</a>
                <a>联系我们</a>
                <a>服务条款</a>
                <a>常见问题</a>
            </div>
            <div class='copyright'>
                <small>川B2-20130052，苏ICP备12019256号-5</small>
            </div>
        </div>
    </div>
    

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/holder.js"></script>
</body>
</html>