<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>
<?php echo $form->textFieldRow($model, 'username', array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model, 'phone', array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model, 'desc', array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model, 'total', array('class'=>'span2')); ?>
 
<?php $this->endWidget(); ?>