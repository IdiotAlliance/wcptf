<?php

/**
 * This is the model class for table "timely_discounts".
 *
 * The followings are the available columns in table 'timely_discounts':
 * @property string $id
 * @property string $pid
 * @property string $cdate
 * @property string $edate
 * @property string $ctime
 * @property string $etime
 */
class TimelyDiscountsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TimelyDiscountsAR the static model class
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
		return 'timely_discounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, cdate, edate, ctime, etime', 'required'),
			array('pid', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pid, cdate, edate, ctime, etime', 'safe', 'on'=>'search'),
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
			'pid' => 'Pid',
			'cdate' => 'Cdate',
			'edate' => 'Edate',
			'ctime' => 'Ctime',
			'etime' => 'Etime',
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
		$criteria->compare('pid',$this->pid,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('edate',$this->edate,true);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('etime',$this->etime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}