<?php

/**
 * This is the model class for table "prepaid_card".
 *
 * The followings are the available columns in table 'prepaid_card':
 * @property string $id
 * @property string $card_no
 * @property string $password
 * @property string $value
 * @property string $is_use
 * @property string $duetime
 */
class PrepaidCardAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrepaidCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prepaid_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('card_no, password, value, duetime', 'required'),
			array('card_no, password', 'length', 'max'=>128),
			array('value', 'length', 'max'=>8),
			array('is_use', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, card_no, password, value, is_use, duetime', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'card_no' => 'Card No',
			'password' => 'Password',
			'value' => 'Value',
			'is_use' => 'Is Use',
			'duetime' => 'Duetime',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('card_no',$this->card_no,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('is_use',$this->is_use,true);
		$criteria->compare('duetime',$this->duetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	//生成点卡
	public function generateCard($value){
		$card = new PrepaidCardAR;
		$card->card_no = "temp";
		$card->password = "temp";
		$card->value = $value;
		$card->is_use = 1;
		$date= date('Y-m-d H:i:s');
		$card->duetime = date('Y-m-d H:i:s',strtotime("$date +1 year")); 
		$card->save();
		$cardNo = PrepaidCardAR::model()->generateCardNo($card->id);
		$card->card_no = $cardNo;
		$card->password = PrepaidCardAR::model()->generatePassword($cardNo);
		$card->is_use = 0;
		$card->save();
		return $card;
	}
	//生成卡号
	public function generateCardNo($cardId){
		//每天的卡号对10000000取余减伤0位,掩饰数字3245167
		$num = date("Ymd");
		$num = (int)$num + 3245167;
		$cardId = (int)$cardId + $num;
		$cardId = $cardId % 10000000;
		$cardId = str_pad($cardId, 7, "0", STR_PAD_LEFT);
		return date("Ymd").$cardId;
	}
	// 生成密钥
	public function generatePassword($cardNo){
		//生成校验码
		$checkStr = substr($cardNo, 10, 5);
		$checkStr = md5($checkStr);
		$checkStr = substr($checkStr, 0, 5);
		srand(microtime(true) * 1000);
		$password = "";
		for($i=0; $i<5; $i++){
			$ranNum = rand(1, 1000);
			$ranNum = $ranNum + hexdec(substr($checkStr, $i, 1));
			$password = $password.PrepaidCardAR::model()->getPasswordChar($ranNum);
		}
		$password = $password.$checkStr;
		return $password;
	}
	// 获取加密字符
	public function getPasswordChar($num){
		//密码字符集
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$len = 62;
		$num = $num % $len;
		return substr($chars, $num, 1);  
	}
	//验证点卡是否是本系统生成
	public function validationCard($cardNo, $password){
		$checkStr = substr($cardNo, 10, 5);
		$checkStr = md5($checkStr);
		$checkStr = substr($checkStr, 0, 5);
		if($checkStr == substr($password, 5, 5)){
			return true;
		}else{
			false;
		}
	}
}