<?php
    Yii::app()->clientScript->registerScript(
    'myHideEffect',
    '$(".message").animate({opacity: 1.0}, 4000).fadeOut("slow");',
    CClientScript::POS_READY
    );
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'set_password_form',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        //'validateOnChange'=>false,
        ),
    'type'=>'horizontal',
    ));
?>
    <fieldset>
        <legend>修改密码</legend>
        <?php echo $form->passwordFieldRow($model, 'oldPassword', array('class'=>'input-large')); ?>
        <?php echo $form->passwordFieldRow($model, 'newPassword', array('class'=>'input-large')); ?>
        <?php echo $form->passwordFieldRow($model, 'reNewPassword', array('class'=>'input-large')); ?>
    </fieldset>

    <div class='form-actions'>
         <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'保存', 'type'=>'primary')); ?>
    </div>
<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.TbAlert',array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'&times;',
        'alerts'=>array(
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
            ),
        'htmlOptions'=>array(
            'class'=>'message',
            ),
        )); ?>


