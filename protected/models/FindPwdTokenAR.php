<?php

/**
 * @author  zhoushuai
 */
class FindPwdTokenAR extends CActiveRecord
{
    const STATUS_NOT_SUCCEED = 0;
    const STATUS_HAS_SUCCEED = 1;
 
    const TOKEN_LENGTH = 64;    //token长度

    private $_randCharacters = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        );

   
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'find_pwd_token';
    }

    public function rules()
    {
        return array(
            array('user_id', 'required', 'message'=>''),
            array('token', 'required', 'message'=>''),  
            array('token', 'length', 'max'=>'64', 'tooLong'=>''),    
            array('gen_time', 'required', 'message'=>''),    
            array('succeed', 'in', 'range'=>array(
                FindPwdTokenAR::STATUS_NOT_SUCCEED,
                FindPwdTokenAR::STATUS_HAS_SUCCEED,
                )),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'UserAR', 'user_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'user_id' => '用户id',
            'token'=>'token',
            'gen_time'=>'生成时间',
            'succeed'=>'成功修改',
        );
    }

    public function generateToken(){
        $token = '';
        $randCharactersLength = count($this->_randCharacters);
        for ($i = 0; $i < FindPwdTokenAR::TOKEN_LENGTH; $i++){
            $token = $token.$this->_randCharacters[rand(0, $randCharactersLength - 1 )];
        }
        return $token;
    }

    public function getFindPwdTokenByToken($token){
        return FindPwdTokenAR::model()->find('token=:token', array(':token'=>$token));
    }

    public function isTokenValid($token){
        $findPwdTokenAr = FindPwdTokenAR::model()->find('token=:token', array(':token'=>$token));
        if(($findPwdTokenAr == null) ||
                ($findPwdTokenAr->succeed == FindPwdTokenAR::STATUS_HAS_SUCCEED) ||
                (strtotime($findPwdTokenAr->gen_time) < strtotime('-30 minutes'))){
            return false;
        }
        return true;
    }

    /**
     * 将该用户之前的token状态设为已经使用过
     */
    public function setOldTokenInvalid($user_id){
        $findPwdTokenAr = FindPwdTokenAR::model()->find(array(
            'condition'=>'user_id=:user_id',
            'params'=>array(':user_id'=>$user_id),
            'order'=>'gen_time DESC',
            ));
        if($findPwdTokenAr != null){
            $findPwdTokenAr->succeed = FindPwdTokenAR::STATUS_HAS_SUCCEED;
            $findPwdTokenAr->save();
        }
    }
}
