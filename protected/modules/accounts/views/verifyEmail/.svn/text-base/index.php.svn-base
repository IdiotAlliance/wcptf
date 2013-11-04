<?php
    Yii::app()->clientScript->registerScript(
    'myHideEffect',
    '$(".message").animate({opacity: 1.0}, 2000).fadeOut("slow");',
    CClientScript::POS_READY
    );
?>
<?php $this->widget('bootstrap.widgets.TbAlert',array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'&times;',
        'alerts'=>array(
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
            'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),          
            ),
        'htmlOptions'=>array('class'=>'message'),
        )); ?>

<p>
    我们已向您的注册邮箱发送了激活邮件，请点击邮件中的链接激活帐号。
</p>
<span>没有收到？请检查邮箱的垃圾邮件<br/>
    或者点击下面的链接，重新发送激活邮件</span>
<br/>

<?php 
    echo $this->renderPartial('_resendlink'); 
?>
