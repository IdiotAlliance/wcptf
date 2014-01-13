<?php

/**
 * This is the model class for table "systemmsgs".
 *
 * The followings are the available columns in table 'systemmsgs':
 * @property string $id
 * @property integer $type
 * @property string $ctime
 * @property integer $read
 * @property string $seller_id
 *
 * The followings are the available model relations:
 * @property Users $seller
 */
class SystemmsgsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SystemmsgsAR the static model class
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
		return 'systemmsgs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, ctime, seller_id', 'required'),
			array('type, read', 'numerical', 'integerOnly'=>true),
			array('seller_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, ctime, read, seller_id', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'Users', 'seller_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'ctime' => 'Ctime',
			'read' => 'Read',
			'seller_id' => 'Seller',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('read',$this->read);
		$criteria->compare('seller_id',$this->seller_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getMsgsAfter($uid, $after, $limit){
		return SystemmsgsAR::model()->findAll(array('condition' => 'seller_id=:uid AND id>:after',
													'params' => array(':uid'=>$uid, ':after'=>$after),
													'limit' => $limit, 
													'order' => 'ctime desc'
													)
											 );
	}

	public static function getMsgsBefore($uid, $before, $limit){
		return SystemmsgsAR::model()->findAll(array('condition' => 'seller_id=:uid AND id<:before',
													'params' => array(':uid'=>$uid, ':before'=>$before),
													'limit' => $limit, 
													'order' => 'ctime desc'
													)
											 );
	}
}