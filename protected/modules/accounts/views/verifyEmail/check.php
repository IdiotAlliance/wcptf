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
<?php 
    if ($showLogin){
        echo $this->renderPartial('_loginlink');
    }
?>
</p>
