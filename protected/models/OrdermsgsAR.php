<?php

/**
 * This is the model class for table "ordermsgs".
 *
 * The followings are the available columns in table 'ordermsgs':
 * @property string $id
 * @property string $store_id
 * @property string $ctime
 * @property integer $read
 */
class OrdermsgsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdermsgsAR the static model class
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
		return 'ordermsgs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, store_id, ctime', 'required'),
			array('read', 'numerical', 'integerOnly'=>true),
			array('store_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, store_id, ctime, read', 'safe', 'on'=>'search'),
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
			'order_id' => 'Order',
			'store_id' => 'Store',
			'ctime' => 'Ctime',
			'read' => 'Read',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('read',$this->read);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	//插入订单消息
	public function insertMsg($sellerId, $orderId, $storeId, $ctime, $read){
		$ordermsgs = new OrdermsgsAR;
		$ordermsgs->order_id = $orderId;
		$ordermsgs->store_id = $storeId;
		$ordermsgs->ctime = $ctime;
		$ordermsgs->read = $read;
		$ordermsgs->save();
		//插入消息队列
		MsgQueueAR::model()->insertMsg($sellerId, $ordermsgs->id, 1);
	}

	//清空该店的订单消息
	public function deleteMsg($storeId){
		$ordermsgs = OrdermsgsAR::Model()->findAll('store_id=:storeId', array(':storeId'=>$storeId));
		foreach ($ordermsgs as $msg) {
			$msgInQueue = MsgQueueAR::model()->find('msg_id=:msgId', array(':msgId'=>$msg->id));
			$msgInQueue->delete();
			$msg->delete();
		}
	}
}