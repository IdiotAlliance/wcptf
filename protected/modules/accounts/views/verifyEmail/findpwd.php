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
    'id'=>'findpwd-form',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('class'=>'well row'),
    
)); ?>
<legend>找回密码</legend>

<?php 
switch ($step) {
    case 0:
        $this->renderPartial('_error');
        break;
    case 1:
        $this->renderPartial('_sendEmailForm', 
            array(
            'model'=>$model,
            'form'=>$form,
            ));
        break;
    case 2:
        $this->renderPartial('_sendEmailSuccess',
            array('model'=>$model));
        break;
    case 3:
        $this->renderPartial('_findPwdForm',
            array(
                'model'=>$model,
                'form'=>$form,
                ));
        break;
    case 4:
        $this->renderPartial('_findPwdSuccess');
        break;
}
?>

<?php $this->endWidget(); ?>