<h4>在进行下一步之前，您需要将账户与微信绑定</h4><br><br>
<?php $form = $this->beginWidget(
	'bootstrap.widgets.TbActiveForm', array(
    'id'=>'wechat_bind_form',
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
        <?php echo $form->textFieldRow($model, 'wechat_id', array(
                                                                'class'=>'input-xlarge'
                                                             )); ?>                                                  
        <?php echo $form->textFieldRow($model, 'wechat_name', array('class'=>'input-xlarge')); ?>
        <?php echo $form->textFieldRow($model, 'token', array('id'=>'wechat_bind_token',
                                                              'class'=>'input-xlarge',
        													  'onchange'=>'setUrl()',
        													  'onkeyup'=>'setUrl()',
                                                             )); ?>
		<?php echo $form->textFieldRow($model, 'wechat_url', array('id'=>'wechat_bind_url',
															'class'=>'input-xxlarge',
															'readonly'=>'true'))?>
</fieldset>

    <div class='form-actions'>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'完成', 'type'=>'primary')); ?>
    </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	var userId  = <?php echo $user->id?>;
	var baseurl = "<?php echo Yii::app()->createAbsoluteUrl('wechat/weChatAccess')?>/";
	
	function setUrl(){
		var value = $('#wechat_bind_token').val();
		var base  = baseurl + userId + '/';
		$('#wechat_bind_url').val(base + value);
	}
</script>