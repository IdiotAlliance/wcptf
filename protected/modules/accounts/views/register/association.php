<div class="alert alert-info">
<h5>提示：</h5>
<p>请您仔细阅读<a href="#">微积分服务条款</a>，点击注册表示您同意我们的服务条款</p>
</div>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'association_register_form',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        ),
    'htmlOptions'=>array('class'=>'span10'),
    ));
?>

<fieldset>
        <?php echo $form->dropDownListRow($model, 'sellerType', array('选择商家类型','外卖','桌游',)); ?> 
        <?php echo $form->textFieldRow($model, 'email', array('class'=>'input-large')); ?>
        <?php echo $form->passwordFieldRow($model, 'password', array(
                                                                'class'=>'input-large',
                                                                'enableAjaxValidation'=>false,
                                                             )); ?>                                                  
        <?php echo $form->captchaRow($model, 'verifyCode', array(
                                                            'class'=>'input-large',
                                                            'captchaOptions'=>array(
                                                                'clickableImage'=>true,
                                                                'showRefreshButton'=>true,
                                                                'buttonLabel'=>'换一张',
                                                                ),
                                                            'enableAjaxValidation'=>false,
                                                            )); ?>
</fieldset>

    <div class='form-actions'>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'立即注册', 'type'=>'primary')); ?>
    </div>
<?php $this->endWidget(); ?>
