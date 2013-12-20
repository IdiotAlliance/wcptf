<?php

/**
 * This is the model class for table "sdmsg_items".
 *
 * The followings are the available columns in table 'sdmsg_items':
 * @property string $id
 * @property string $sdmsg_id
 * @property integer $type
 * @property string $title
 * @property string $content
 * @property string $picurl
 * @property integer $url
 *
 * The followings are the available model relations:
 * @property Sdmsgs $sdmsg
 */
class SdmsgItemsAR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sdmsg_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sdmsg_id, type', 'required'),
			array('type, url', 'numerical', 'integerOnly'=>true),
			array('sdmsg_id', 'length', 'max'=>11),
			array('title', 'length', 'max'=>128),
			array('content, picurl', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sdmsg_id, type, title, content, picurl, url', 'safe', 'on'=>'search'),
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
			'sdmsg' => array(self::BELONGS_TO, 'Sdmsgs', 'sdmsg_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sdmsg_id' => 'Sdmsg',
			'type' => 'Type',
			'title' => 'Title',
			'content' => 'Content',
			'picurl' => 'Picurl',
			'url' => 'Url',
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
		$criteria->compare('sdmsg_id',$this->sdmsg_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('picurl',$this->picurl,true);
		$criteria->compare('url',$this->url);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SdmsgItemsAR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
