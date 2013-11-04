<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $email
 * @property string $password
 * @property integer $type
 * @property string $register_time
 * @property integer $email_verified
 * @property string $seller_type
 * @property string $token
 * @property string $store_name
 * @property string $phone
 * @property string $stime
 * @property string $etime
 * @property string $store_address
 * @property integer $logo
 * @property double $start_price
 * @property double $takeaway_fee
 * @property double $threshold
 *
 * The followings are the available model relations:
 * @property Members[] $members
 * @property Orders[] $orders
 * @property Orders[] $orders1
 * @property Pictures[] $pictures
 * @property Posters[] $posters
 * @property ProductType[] $productTypes
 * @property Products[] $products
 * @property StoreEnv[] $storeEnvs
 */
class UsersAR extends CActiveRecord
{
	const TYPE_SELLER = 0;

    const SELLERTYPE_TAKEAWAY = 1;

    const STATUS_NOT_VERIFIED = 0;
    const STATUS_HAS_VERIFIED = 1;

    const VERIFY_CODE_LENGTH = 32;

	private $_randCharacters = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersAR the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, register_time, token, store_name, phone, stime, etime, store_address, logo, start_price, takeaway_fee, threshold', 'required'),
			array('type, email_verified, logo', 'numerical', 'integerOnly'=>true),
			array('start_price, takeaway_fee, threshold', 'numerical'),
			array('email, password', 'length', 'max'=>128),
			array('seller_type, store_name, phone', 'length', 'max'=>32),
			array('token', 'length', 'max'=>64),
			array('store_address', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, type, register_time, email_verified, seller_type, token, store_name, phone, stime, etime, store_address, logo, start_price, takeaway_fee, threshold', 'safe', 'on'=>'search'),
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
			'members' => array(self::HAS_MANY, 'Members', 'seller_id'),
			'orders' => array(self::HAS_MANY, 'Orders', 'member_id'),
			'orders1' => array(self::HAS_MANY, 'Orders', 'seller_id'),
			'pictures' => array(self::HAS_MANY, 'Pictures', 'seller_id'),
			'posters' => array(self::HAS_MANY, 'Posters', 'seller_id'),
			'productTypes' => array(self::HAS_MANY, 'ProductType', 'seller_id'),
			'products' => array(self::HAS_MANY, 'Products', 'seller_id'),
			'storeEnvs' => array(self::HAS_MANY, 'StoreEnv', 'seller_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Password',
			'type' => 'Type',
			'register_time' => 'Register Time',
			'email_verified' => 'Email Verified',
			'seller_type' => 'Seller Type',
			'token' => 'Token',
			'store_name' => 'Store Name',
			'phone' => 'Phone',
			'stime' => 'Stime',
			'etime' => 'Etime',
			'store_address' => 'Store Address',
			'logo' => 'Logo',
			'start_price' => 'Start Price',
			'takeaway_fee' => 'Takeaway Fee',
			'threshold' => 'Threshold',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('register_time',$this->register_time,true);
		$criteria->compare('email_verified',$this->email_verified);
		$criteria->compare('seller_type',$this->seller_type,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('store_name',$this->store_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('stime',$this->stime,true);
		$criteria->compare('etime',$this->etime,true);
		$criteria->compare('store_address',$this->store_address,true);
		$criteria->compare('logo',$this->logo);
		$criteria->compare('start_price',$this->start_price);
		$criteria->compare('takeaway_fee',$this->takeaway_fee);
		$criteria->compare('threshold',$this->threshold);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

		public function getUserByEmail($email){
        $user = UsersAR::model()->find('email=:email', array(':email'=>$email));
        return $user;
    }

    public function isEmailExisted($email){
        return UsersAR::model()->exists('email=:email', array(':email'=>$email));
    }

    public function generateVerifyCode(){
        $verifyCode = '';
        $randCharactersLength = count($this->_randCharacters);
        for ($i = 0; $i < UsersAR::VERIFY_CODE_LENGTH; $i++){
            $verifyCode = $verifyCode.$this->_randCharacters[rand(0, $randCharactersLength - 1 )];
        }
        return $verifyCode;
    }

    public function verifyUser($email){
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $userAr = UsersAR::model()->find('email=:email', array(':email'=>$email));
            $userAr->email_verified = UsersAR::STATUS_HAS_VERIFIED;
            /*
                待添加：分配角色权限
            */
            $userAr->save();   

            $transaction->commit();        
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
        return true;

    }

    public function isVerified($email){
        $userAr = UsersAR::model()->find('email=:email', array(':email'=>$email));
        return $userAr->email_verified == UsersAR::STATUS_HAS_VERIFIED ? true : false;
    }

}