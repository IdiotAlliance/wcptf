<div class="alert alert-info">
<h5>提示：</h5>
<?php echo  CHtml::image(Yii::app()->baseUrl.'/images/tips.png'); ?>
</div>
<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs',
    'stacked'=>false,
    'items'=>array(
        array('label'=>'社团注册', 'url'=>array('/accounts/register/association')),
        array('label'=>'企业注册', 'url'=>array('/accounts/register/company'), 'active'=>true),
        ),
    'htmlOptions'=>array('class'=>'span10', 'style'=>'margin-left:0px'),
)); ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'company_register_form',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        //'validateOnChange'=>false,
        ),
    'htmlOptions'=>array('class'=>'span10'),
    ));
?>

<fieldset>
        <?php echo $form->dropDownListRow($model, 'province', $provinceList, 
            array(
                'class'=>'input-large',
                'empty'=>Yii::t('viewMember', '选择省份'),
                'ajax'=>array(
                    'type'=>'POST',
                    'url'=>Yii::app()->createUrl('/accounts/register/dynamicCity'),
                    'data'=>array(
                        'pid'=>'js:this.value', 
                        'oldpid'=>$model->province,
                        'YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken,
                        ),
                    'update'=>'#CompanyRegisterForm_city',
                    ),
                'validateOptions'=>array(
                    'enableAjaxValidation'=>false,
                    ),
                ));
                ?>
        <?php echo $form->dropDownListRow($model, 'city', $cityList,
                array(
                    'class'=>'input-large',
                    'empty'=>Yii::t('viewMember', '选择城市'),
                    'validateOptions'=>array(
                        'enableAjaxValidation'=>false,
                        ),
                )); 
                ?>

        <?php echo $form->textFieldRow($model, 'companyName', array(
                                                                'class'=>'input-large',
                                                                'validateOptions'=>array(
                                                                    'enableAjaxValidation'=>false,
                                                                    ),
                                                                )); ?>
        <?php echo $form->textFieldRow($model, 'loginEmail', array('class'=>'input-large')); ?>
        <?php echo $form->passwordFieldRow($model, 'password', array(
                                                                'class'=>'input-large',
                                                                'validateOptions'=>array(
                                                                    'enableAjaxValidation'=>false,
                                                                    ),
                                                                )); ?>
        <?php echo $form->textFieldRow($model, 'contactEmail', array(
                                                                'class'=>'input-large',
                                                                'validateOptions'=>array(
                                                                    'enableAjaxValidation'=>false,
                                                                    ),
                                                                )); ?>
        <?php echo $form->textFieldRow($model, 'contactPhone', array(
                                                                'class'=>'input-large',
                                                                'validateOptions'=>array(
                                                                    'enableAjaxValidation'=>false,
                                                                    ),
                                                                )); ?>  
        <?php echo $form->textFieldRow($model, 'invitationCode', array(
                                                                'class'=>'input-large',
                                                                'validateOptions'=>array(
                                                                    'enableAjaxValidation'=>false,
                                                                    ),
                                                                )); ?>  
        <?php echo $form->captchaRow($model, 'verifyCode', array(
                                                            'class'=>'input-large',
                                                            'captchaOptions'=>array(
                                                                'clickableImage'=>true,
                                                                'showRefreshButton'=>true,
                                                                'buttonLabel'=>'换一张',
                                                                ),
                                                            'validateOptions'=>array(
                                                                'enableAjaxValidation'=>true,
                                                                ),
                                                            )); ?>
</fieldset>

    <div class='form-actions'>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'立即注册', 'type'=>'primary')); ?>
    </div>

<?php $this->endWidget(); ?>
