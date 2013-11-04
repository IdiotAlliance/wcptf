<?php
    Yii::app()->clientScript->registerScript(
    'myHideEffect',
    '$(".message").animate({opacity: 1.0}, 1000).fadeOut("slow");',
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

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('class'=>'well row'),
    
)); ?>
<legend>登录</legend>
    <?php echo $form->textFieldRow($model, 'username', 
                                array(
                                    'class'=>'input-large', 
                                    'prepend'=>'<i class="icon-user"></i>',
                                    'placeholder'=>'邮箱',
                                    'tabindex'=>'1',
                                    )); ?>

    <?php echo CHtml::link('忘记密码？', array('/accounts/verifyEmail/findPwd'), array('class'=>'getpassword')); ?>

    <?php echo $form->passwordFieldRow($model, 'password', 
                                array(
                                'class'=>'input-large', 
                                'prepend'=>'<i class="icon-lock"></i>',
                                'placeholder'=>'请输入密码',
                                'tabindex'=>'2',
                                )); ?>
    <div>
    <?php echo $form->checkBoxRow($model, 'rememberMe', 
                                array(
                                    'tabindex'=>3,
                                    )); ?>
    </div>

    <div class='submit'>
        <?php echo CHtml::submitButton('登录', 
                                array(
                                    'class'=>'btn btn-primary btn-block',
                                    'tabindex'=>'4',
                                    )); ?>
    </div>
    <div class='registernow'>
        <span>还没有登录帐号？</span>
        <?php echo CHtml::link('立即注册！', array('/accounts/register/association')); ?>
    </div>

<?php $this->endWidget(); ?>
