<?php
/**
 * @author  zhoushuai
 */
class EmailHelper {

    //发送激活邮件
    public static function sendVerifyEmail($userAr, $name){
        $to = $userAr->email;
        $subject = '请激活您的微积分账户！';
        $message = '亲爱的'.$name."：\r\n"
                    .'欢迎您加入微积分！'."\r\n"
                    .'请点击下面的链接完成注册：'."\r\n"
                    .Yii::app()->request->hostInfo.Yii::app()->createUrl(
                        '/accounts/verifyEmail/check',
                        array(
                            'login'=>$userAr->email,
                            'code'=>$userAr->verify_code,
                            )
                        )."\r\n";
        $headers = 'From:玉米地<yumifield@yumifield.com>'."\r\n".
                   'Reply-To:yumifield@yumifield.com'."\r\n".
                   'MIME-Version:1.0'."\r\n".
                   'Content-type:text/html; charset=utf-8'."\r\n";

        return mail($to, $subject, $message, $headers);
    }

    //发送找回密码邮件
    public static function sendFindPwdEmail($email, $token){
        $to = $email;
        $subject = '玉米地 - 找回密码';
        $message = '亲爱的'.$email."：\r\n"
                    .'您申请了重置您的玉米地帐号密码，请点击下面的链接继续操作：'."\r\n"
                    .Yii::app()->request->hostInfo.Yii::app()->createUrl(
                        '/accounts/verifyEmail/findPwd',
                        array(
                            'token'=>$token,
                            )
                        );
        $headers = 'From:玉米地<yumifield@yumifield.com>'."\r\n".
                   'Reply-To:yumifield@yumifield.com'."\r\n".
                   'MIME-Version:1.0'."\r\n".
                   'Content-type:text/html; charset=utf-8'."\r\n";

        Yii::trace('message'.$message);
        return mail($to, $subject, $message, $headers);
    }

    public static function sendFeedbackEmail($id){
        $feedbackAr = FeedbackAR::model()->findByPk($id);
        $userAr = UsersAR::model()->findByPk($feedbackAr->user_id);
        $to = 'yumifield@163.com';
        $subject = '玉米地 - 用户意见反馈-'.$feedbackAr->submit_time;
        $message =  'user:'.$feedbackAr->specific_name."\r\n"
                    .'email:'.$userAr->email. "\r\n"
                    .'url:'.$feedbackAr->url."\r\n"
                    .'content:'.$feedbackAr->content."\r\n";
        $headers = 'From:玉米地<yumifield@yumifield.com>'."\r\n".
                   'Reply-To:yumifield@yumifield.com'."\r\n".
                   'MIME-Version:1.0'."\r\n".
                   'Content-type:text/html; charset:utf-8'."\r\n";

        Yii::trace('message'.$message);
        return mail($to, $subject, $message, $headers);        
    }
    public static function sendMail($to,$subject,$message,$headers){
        $tmp = explode('@',$to);
        $toDomain = $tmp[1];
        $commonDomains = array("qq.com","163.com","sina.cn","sina.com");   
        if (in_array($toDomain,$commonDomains)){
            return mail($to, $subject, $message, $headers);
        }else{

        }
    }

    public static function smtpMail($to,$subject,$message,$headers){

	}
}
