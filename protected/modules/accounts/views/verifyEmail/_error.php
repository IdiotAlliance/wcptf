<div class='headtips'>
    <strong>您的找回密码链接无效，请尝试下面的操作提示：</strong>
</div>
<div class='headtips'>
    <ul>
        <li>请到您的邮箱中完整复制找回密码邮件中的重置密码链接后，拷贝至浏览器的地址栏中重试一次。</li>
        <li>找回密码邮件的有效期为30分钟，如果您没能在有效期内完成密码重置，请    
            <?php echo CHtml::link('重新找回密码', 
            array('/accounts/verifyEmail/findPwd'),
            array()
            ); ?>
            。</li>
    </ul>
</div>