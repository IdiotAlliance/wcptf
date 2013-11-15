<?php

/**
 * This is the model class for table "members".
 *
 * The followings are the available columns in table 'members':
 * @property string $id
 * @property string $seller_id
 * @property string $openid
 * @property string $fakeid
 * @property string $memberid
 * @property integer $credits
 * @property string $ctime
 * @property string $wxid
 * @property string $wxnickname
 * @property integer $unsubscribed
 *
 * The followings are the available model relations:
 * @property Users $seller
 */
class MembersAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MembersAR the static model class
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
		return 'members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seller_id, openid', 'required'),
			array('credits', 'numerical', 'integerOnly'=>true),
			array('seller_id', 'length', 'max'=>11),
			array('openid, fakeid, memberid', 'length', 'max'=>64),
			array('wxid, wxnickname', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, seller_id, openid, fakeid, memberid, credits, ctime, wxid, wxnickname', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'UsersAR', 'seller_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'seller_id' => 'Seller',
			'openid' => 'Openid',
			'fakeid' => 'Fakeid',
			'memberid' => 'Memberid',
			'credits' => 'Credits',
			'ctime' => 'Ctime',
			'wxid' => 'Wxid',
			'wxnickname' => 'Wxnickname',
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
		$criteria->compare('seller_id',$this->seller_id,true);
		$criteria->compare('openid',$this->openid,true);
		$criteria->compare('fakeid',$this->fakeid,true);
		$criteria->compare('memberid',$this->memberid,true);
		$criteria->compare('credits',$this->credits);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('wxid',$this->wxid,true);
		$criteria->compare('wxnickname',$this->wxnickname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 检测具有某个openId的用户是否已经是某个商家的会员
	 * @param unknown $sellerId 商家id
	 * @param unknown $openId 微信用户的openid
	 */
	public function memberExists($sellerId, $openId){
		$member = MembersAR::model()->find('seller_id=:sellerId and openid=:openId', 
										   array(':sellerId'=>$sellerId, ':openId'=>$openId));
		if($member)
			return true;
		return false;
	}
	
	public function getMemberBySellerIdAndOpenId($sellerId, $openId){
		$member = MembersAR::model()->find('seller_id=:sellerId and openid=:openId',
				array(':sellerId'=>$sellerId, ':openId'=>$openId));
		return $member;
	}
	
	/*
		获取微信昵称
	*/
	public function getMemberName($memberid){
		$member= MembersAR::model()->find('openid=:openid', array(':openid'=>$memberid));
		$memberName = $member->wxnickname;
		return $memberName;
	}

	/*
		通过openid查找用户
	*/
	public function getMemberByOpenId($openid){
		$member= MembersAR::model()->find('openid=:openid', array(':openid'=>$openid));
		return $member;
	}
	/*
		新建用户
	*/
	public function createMember($sellerid, $openid, $name){
		$member = new MembersAR;
		$member->seller_id = $sellerid;
		$member->openid = $openid;
		$member->wxnickname = $name;
		$member->ctime = date("Y-m-d H:i:s");
		$member->credits = 0;
		$member->save();
		return $member;
	}

}