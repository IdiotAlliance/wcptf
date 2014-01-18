<?php
/**
 * @author  lwb
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
                        '/accountserifyEmaileck',
                        array(
                            'login'=>$userAr->email,
                            'code'=>$userAr->verify_code,
                            )
                        )."\r\n";
        // $headers = 'From:玉米地<yumifield@.com>'."yumifield\r\n".
        //            'Reply-To:yumifield@yumifield.com'."\r\n".
        //            'MIME-Version:1.0'."\r\n".
        //            'Content-type:textml; charset=utf-8'."\r\n";
        $headers = "From:register@v7fen.com"."\r\n";

        return mail($to, $subject, $message, $headers);
    }

    //发送找回密码邮件
    public static function sendFindPwdEmail($email, $token){
        $to = $email;
        $subject = '微积分- 找回密码';
        $message = '亲爱的'.$email."：\r\n"
                    .'您申请了重置您的微积分帐号密码，请点击下面的链接继续操作：'."\r\n"
                    .Yii::app()->request->hostInfo.Yii::app()->createUrl(
                        '/accountserifyEmail/findPwd',
                        array(
                            'token'=>$token,
                            )
                        );
        $headers = 'From:微积分<findPwd@v7fen.com>'."\r\n".
                   'Reply-To:findPwd@v7fen.com'."\r\n".
                   'MIME-Version:1.0'."\r\n".
                   'Content-type:textml; charset=utf-8'."\r\n";

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
