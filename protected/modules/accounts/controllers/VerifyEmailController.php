<?php
/**
 * @author  zhoushuai
 */
class VerifyEmailController extends Controller
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

	public function actionCheck()
	{
		$showLogin = false;

		if (isset($_GET['login']) && isset($_GET['code'])){

			$user = UsersAR::model()->getUserByEmail($_GET['login']);
			if ($user === null || $user->verify_code != $_GET['code']){
				throw new CHttpException(404, '页面不存在');			
			}
			else if ($user->email_verified == UsersAR::STATUS_HAS_VERIFIED){
				    					var_dump($showLogin);
				exit();
				Yii::app()->user->logout();
				Yii::app()->user->setFlash('warning',  '您的邮箱已经激活过了,请直接登录');
				$showLogin = true;
			}
			else if (strtotime($user->register_time) < strtotime('-5 days')){
				    					var_dump($showLogin);
				exit();
				Yii::app()->user->logout();
				Yii::app()->user->setFlash('error',  '该链接已经失效，请登录后，选择重新发送激活邮件');
				$showLogin = true;
			}
			else if (UsersAR::model()->verifyUser($user->email)){

				Yii::app()->user->logout();
				Yii::app()->user->setFlash('success',  '激活成功！');
				$showLogin = true;
			}
			else {
				Yii::app()->user->setFlash('error',  '激活失败，请刷新页面，重新激活。');
			}
		}
		else {
			throw new CHttpException(404, '页面不存在');		
		}
		$this->render('check', array(
			'showLogin'=>$showLogin,
			));
	}

	public function actionActEmail(){
		$this->render('actemail');
	}

	public function actionFindPwd(){
		$model = new SendEmailForm();
		$step = 1;
		
		if (isset($_POST['SendEmailForm'])){
			$model->attributes = $_POST['SendEmailForm'];
			if ($model->validate() && $model->sendEmail()){
				$step = 2;
			}
		}
		if (isset($_GET['token'])){
			if (!FindPwdTokenAR::model()->isTokenValid($_GET['token'])) {
				$step = 0;
			}
			else {
				$step = 3;
				$model = new FindPwdForm();
				$model->token = $_GET['token'];
			}
		}
		if (isset($_POST['FindPwdForm'])){
			$model->attributes = $_POST['FindPwdForm'];
			if($model->validate()){
				if($model->setPassword()){
					$step = 4;
				}
				else {
					$step = 0;
				}
			}
		}
		Yii::trace('step'.$step);
		$this->render('findpwd', array(
			'model'=>$model,
			'step'=>$step,
			));

	}

	public function actionReSendVerifyEmail(){
			try {
				$userAr = UsersAR::model()->getUserByEmail(Yii::app()->user->name);
				$userAr->register_time = new CDbExpression('NOW()');
			    $userAr->verify_code = UsersAR::model()->generateVerifyCode();
			    $userAr->save();
			    
			    if (EmailHelper::sendVerifyEmail($userAr, $userAr->email)){
			    	echo '发送成功！';
			    	Yii::trace('发送成功');
			    }
			    else {
			    	echo '发送失败！请重试';
			    }
			} catch (Exception $e) {
				echo '发送失败！请重试';
			}
			//Yii::app()->user->setFlash('success', '发送成功');
			//$this->refresh();
	}

	public function filters(){
		return array(
			'accessControl',
			'ajaxOnly + reSendVerifyEmail'
			);
	}

	public function accessRules(){
		return array(
			array(
				'allow',
				'actions'=>array('check', 'findPwd'),
				'users'=>array('*'),
				),
			array(
				'allow',
				'actions'=>array('index'),
				'roles'=>array('UnValidater'),
				),
			array(
				'deny',
				'actions'=>array('index'),
				'users'=>array('*'),
				),

			);
	}
}