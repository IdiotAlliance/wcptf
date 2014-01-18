<?php 
    //字符串中间替换成 ‘*’
    function str_mid_replace($string) {
    if (! $string || !isset($string[1])) return $string;

    $len = strlen($string);
    $starNum = floor($len / 2); 
    $noStarNum = $len - $starNum;
    $leftNum = ceil($noStarNum / 2); 
    $rightNum = $noStarNum - $leftNum;

    $result = substr($string, 0, $leftNum);
    $result .= str_repeat('*', $starNum);
    $result .= substr($string, $len-$rightNum);

    return $result; 
    }
?>
<div class='headtips' >
    <p> 
    <small>1.填写登录邮箱 >></small> 
    <strong>2.接收找回密码邮件 </strong>
    <small> >> 3.重设密码 >> 4.完成</small>
    </p>
</div>
<div class='headtips'>
    <strong>
        邮件已经发送，请查收！
    </strong>
<br/>
    <span>
        我们已将“微积分 - 找回密码”邮件发送到您的邮箱<?php echo str_mid_replace($model->email) ?>中，<br/>
        请在30分钟内点击邮件中的链接，重设您的密码。
    </span>
</div>