<?php
/**
 * @author  zhoushuai
 */
class SettingsController extends Controller
{

	public $layout = 'column1';

	public function actionPassword()
	{
		$model = new SetPasswordForm();
		$model->unsetAttributes();

		if (isset($_POST['ajax']) && $_POST['ajax']==='set_password_form'){
			$model->attributes = $_POST['SetPasswordForm'];
			echo CActiveForm::validate($model, array('reNewPassword'));
			Yii::app()->end();
		}
	
		if (isset($_POST['SetPasswordForm'])){
			$model->attributes = $_POST['SetPasswordForm'];
			if ($model->validate() && $model->resetSucceed()){
				Yii::app()->user->setFlash('success', '<strong>修改密码成功！</strong>');
			}
			else {
				Yii::app()->user->setFlash('error', '<strong>修改密码失败！</strong>');
			}
			$this->refresh();
		}
		$this->render('password',array('model'=>$model));
	}


	public function filters()
	{		
		return array('accessControl');
	}

	public function accessRules(){
		return array(
			array('allow',
				'actions'=>array('password'),
				'roles'=>array('Association', 'Company', 'Individual', 'Operator'),
				),
			array('deny',
				'actions'=>array('password'),
				'users'=>array('*'),
				),
			);
	}


	protected function beforeAction($action){
		if (isset(Yii::app()->user->userType)){
			switch (Yii::app()->user->userType) {
				case UserAR::TYPE_ASSOCIATION:
                    Yii::app()->bootstrap->register(); 
                    Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/association/main.css");
					$this->layout = 'application.modules.association.views.layouts.column1';
					
					break;
				case UserAR::TYPE_COMPANY:
					$this->layout = 'application.modules.company.views.layouts.column1';
					break;
				case UserAR::TYPE_INDIVIDUAL:
					break;
				case UserAR::TYPE_OPERATOR:
					$this->layout = 'application.modules.operator.views.layouts.column1';					
					break;
				case UserAR::TYPE_OPRADMIN:
					$this->layout = 'application.modules.opradmin.views.layouts.column1';
					break;
				default:
					$this->layout = '//layouts/column1';
					break;
			}
		}
		return true;
	}

	/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	
}
