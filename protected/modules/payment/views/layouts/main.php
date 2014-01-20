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
        <style type="text/css">
            body{
                background: #f6f7f1 url("<?php echo Yii::app()->baseUrl?>/img/account_foreground.png") repeat 0 0;
                font-size: 16px;
            }
            #main_container{
                position: absolute;
                left: 0px;
                top: 0px;
                right: 0px;
                bottom: 0px;
            }
            #nav_bar_container{
                position: absolute;
                width: 900px;
                left: 50%;
                margin-left: -450px;
                top: 40px;
            }
            #nav_bar_container .nav_item{
                color: #999999;
                font-size: 16px;
                line-height: 30px;
                display: block;
                text-shadow: 1px 1px rgba(255,255,255,0.75);
                cursor: pointer;
                display: inline-block;
                min-width: 120px;
                text-decoration: none;
            }
            #nav_bar_container .nav_item:hover{
                color: #666666;
            }
            #nav_bar_container .nav_item.active{
                color: #444444;
            }
            #nav_bar_container .nav_title{
                color: #6a8b82;
                font-size: 23px;
                line-height: 25px;
            }
            #tab_container{
                position: absolute;
                width: 900px;
                min-height: 500px;
                left: 50%;
                margin-left: -450px;
                top: 100px;
            }
            #tab_container .tab{
                position: relative;
                left: 0px;
                top: 0px;
                width: 100%;
                min-height: 500px;
                display: none;
            }
            #tab_container .stab{
                background-color: #ffffff;
                border-radius: 1px;
                box-shadow: 0px 0px 5px #808080;
            }
            #tab_container .tab.active{
                display: block;
            }
            #tab_container .tab .tab_title{
                font-size: 24px;
                font-family: "Helvetica Neue", Helvetica, Arial,"Microsoft Yahei","SimHei",Sans-serif;
                line-height: 24px;
                margin: 20px 0 50px 0;
                color: #84a099;
                text-align: center;
            }
            .main-panel {
                width: 700px;
                margin-top: 10%;
                margin-left: 20%;
                background-color: #ffffff;
                border-radius: 1px;
                box-shadow: 0px 0px 5px #808080;
            }
            .main-content{
                padding: 20px;
            }
            .content {
                display: inline-block;
                text-align: center;
            }
            .card-area{
                margin-top: 10px;
            }
            .content.cardNo{
                width: 300px;
                height: 30px;
                background: #eb6467;
            }
            .content.password{
                width: 200px;
                height: 30px;
                background: #34bb87;
            }
            .content.value{
                width: 100px;
                height: 30px;
                background: #3487bb;
            }
        </style>
</head>

<body>
    <div id="main_container">
        <div id="nav_bar_container" class="row">
            <a href="<?php echo Yii::app()->baseUrl?>" class="nav_title nav_item">微积分</a>
            <a href="<?php echo Yii::app()->createUrl('accounts/replyRules/allRules');?>" class="nav_item msgs" data-toggle="tab_sdmessages">消息设置</a>
            <a href="#" class="nav_item members" data-toggle="tab_members">会员管理</a>
            <a href="#" class="nav_item help" data-toggle="tab_help">帮助</a>
        </div>
        <!-- 页面主体内容-->
        <?php echo $content; ?>     
        <script type="text/javascript">
            $(document).ready(function(){
                
            });
        </script>
    </div>
</body>
</html>