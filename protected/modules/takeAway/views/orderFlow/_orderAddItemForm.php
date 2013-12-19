<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

	<?php echo $form->textFieldRow($model, 'productId', array('class'=>'span2')); ?>
	<?php echo $form->textFieldRow($model, 'num', array('class'=>'span2')); ?>
 
<?php $this->endWidget(); ?>