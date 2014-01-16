<?php

/**
 * This is the model class for table "plugins_store".
 *
 * The followings are the available columns in table 'plugins_store':
 * @property string $plugin_id
 * @property string $store_id
 * @property integer $onoff
 */
class PluginsStoreAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PluginsStoreAR the static model class
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
		return 'plugins_store';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plugin_id, store_id, onoff', 'required'),
			array('onoff', 'numerical', 'integerOnly'=>true),
			array('plugin_id, store_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('plugin_id, store_id, onoff', 'safe', 'on'=>'search'),
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
			'plugin_id' => 'Plugin',
			'store_id' => 'Store',
			'onoff' => 'Onoff',
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

		$criteria->compare('plugin_id',$this->plugin_id,true);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('onoff',$this->onoff);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}