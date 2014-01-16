<?php
/**
 * @author  luwenbin
 */
class RegisterController extends Controller
{
	public $layout = 'column1';
	
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'testLimit'=>1,
				'minLength'=>4,
				'maxLength'=>4,
				'transparent'=>true,
			),
		);
	}

	/**
	 * 商家注册
	 */
	public function actionAssociation()
	{
		if (Yii::app()->user->isGuest){

			$model = new AssoRegisterForm();

			if (isset($_POST['ajax']) && $_POST['ajax']==='association_register_form'){
				$model->attributes = $_POST['AssoRegisterForm'];
				echo CActiveForm::validate($model, array('email'));
				Yii::app()->end();
			}
		
			if (isset($_POST['AssoRegisterForm'])){
				$model->attributes = $_POST['AssoRegisterForm'];
				if ($model->registerSucceed()){
					Yii::app()->user->setFlash('success', '<strong>注册成功！</strong>');
					if ($model->login()){
						$this->redirect(array('/accounts/verifyEmail/actEmail'));			
					}
					else{
						$this->redirect(array('/accounts/login/login'));
												
					}
				}
				else {
					throw new CHttpException(500,'注册账号失败');
				}
			}
			
			$this->render('association', 
				array('model'=>$model, 
					));
		}
		else {
			$this->redirect(Yii::app()->user->returnUrl);
		}
	}
	
}
