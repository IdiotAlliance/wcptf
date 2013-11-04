<div class='headtips'>
    <small>1.填写登录邮箱 >></small>
    <small>2.接收找回密码邮件 >> </small>
    <strong>3.重设密码</strong>
    <small> >> 4.完成</small>
</div>

<?php echo $form->hiddenField($model, 'token'); ?>
<?php echo $form->passwordFieldRow($model, 'password', array(
    'class'=>'input-large',
    'tabindex'=>'1',
)); ?>
<?php echo $form->passwordFieldRow($model, 'repassword', array(
    'class'=>'input-large',
    'tabindex'=>'2',
)); ?>
<div class='form-actions'>
<?php echo CHtml::submitButton('提交',
    array(
        'class'=>'btn btn-primary',
        'tabindex'=>'3',
    )); ?>
</div>
