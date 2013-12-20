<?php

/**
 * This is the model class for table "keywords".
 *
 * The followings are the available columns in table 'keywords':
 * @property string $id
 * @property string $wx_id
 * @property string $keyword
 *
 * The followings are the available model relations:
 * @property Wxid $wx
 * @property Sdmsgs[] $sdmsgs
 */
class KeywordsAR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'keywords';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wx_id, keyword', 'required'),
			array('wx_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wx_id, keyword', 'safe', 'on'=>'search'),
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
			'wx' => array(self::BELONGS_TO, 'Wxid', 'wx_id'),
			'sdmsgs' => array(self::HAS_MANY, 'Sdmsgs', 'keyword_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'wx_id' => 'Wx',
			'keyword' => 'Keyword',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('wx_id',$this->wx_id,true);
		$criteria->compare('keyword',$this->keyword,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KeywordsAR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
