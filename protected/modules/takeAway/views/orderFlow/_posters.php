<?php /** @var BootActiveForm $form */
	
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'horizontalForm',
        'type'=>'inline',
    )); ?>

    <?php echo $form->radioButtonListRow($model, 'poster', $posterViews); ?>
 
<?php $this->endWidget(); ?>