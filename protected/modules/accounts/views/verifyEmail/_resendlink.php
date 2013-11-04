<?php echo CHtml::ajaxLink(
    '重新发送',
    array('/accounts/verifyEmail/reSendVerifyEmail'),
    array(
        'type'=>'post',
        'update'=>'#hint',
        )     
    ); ?>

<p id='hint'></p>
