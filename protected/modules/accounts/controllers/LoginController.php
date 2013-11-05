<?php
/**
 * @author  luwenbin
 */
class LoginController extends Controller
{
    public $layout = 'column1';
    public $defaultAction = 'login';
    
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest){
            $model = new LoginForm;

            if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if(isset($_POST['LoginForm']))
            {
                $model->attributes=$_POST['LoginForm'];
                //validate()为CFromModel内置方法，验证rules
                if($model->validate() && $model->login()){
                    if ($model->isVerified()){
                        $user = UsersAR::model()->getUserByEmail($model->username);

                        switch ($user->seller_type) {
                            case "1":                            
                                $this->redirect(array('/takeAway/productManager/allProducts'));
                                break;  
                            default:
                                $this->redirect(Yii::app()->user->returnUrl);
                                break;
                        }
                        
                    }
                    else{
                        $this->redirect(array('/accounts/verifyEmail/actEmail'));
                    }
                }
            }
            $this->render('login', array('model'=>$model));              
        }
        else {
            $this->redirect(Yii::app()->user->returnUrl);
        }
    }

 /*
    public function filters()
    {
        return array(
            'accessControl',
            );
    }

    public function accessRules(){
        return array(
            array(
                'allow',
                'actions'=>array('login'),
                'users'=>array('?'),
                ),
            array(
                'deny',
                'actions'=>array('login'),
                'users'=>array('@'),
                ),
            );
    }
 */

}