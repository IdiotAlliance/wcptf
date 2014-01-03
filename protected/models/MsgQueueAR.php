<?php

/**
 * This is the model class for table "msg_queue".
 *
 * The followings are the available columns in table 'msg_queue':
 * @property string $id
 * @property string $seller_id
 * @property string $msg_id
 * @property integer $type
 */
class MsgQueueAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MsgQueueAR the static model class
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
		return 'msg_queue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seller_id, msg_id, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('seller_id, msg_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, seller_id, msg_id, type', 'safe', 'on'=>'search'),
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
			'seller_id' => 'Seller',
			'msg_id' => 'Msg',
			'type' => 'Type',
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
		$criteria->compare('msg_id',$this->msg_id,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function getMsgsBySellerId($sellerId){
		return MsgQueueAR::model()->findAll('seller_id=:sellerId',
											array(':sellerId'=>$sellerId));
	}

	public function insertMsg($sellerId, $msgId, $type){
		$msgQueue = new MsgQueueAR;
		$msgQueue->seller_id = $sellerId;
		$msgQueue->msg_id = $msgId;
		$msgQueue->type = $type;
		$msgQueue->save();
	}

	/**
	 * Get ids of msg_queue items by linking ordermsgs table
	 */
	public static function getOrderItemsByUserAndStoreId($uid, $sid){
		$connection = MsgQueueAR::model()->getDbConnection();
		$query = "SELECT msg_queue.id AS mqid FROM msg_queue JOIN ordermsgs ON ".
				 "msg_queue.msg_id = ordermsgs.id WHERE msg_queue.type=1 and msg_queue.seller_id=:sellerId ".
				 "and ordermsgs.store_id=:sid";
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':sellerId', $uid);
			$stmt->bindParam(':sid', $sid);
			return $stmt->queryAll();
		}
		return null;
	}

	/**
	 * Get ids of msg_queue items by linking comments table
	 */
	public static function getCommentItemsByUserAndStoreId($uid, $sid){
		$connection = MsgQueueAR::model()->getDbConnection();
		$query = "SELECT msg_queue.id AS mqid FROM msg_queue JOIN comments ON ".
				 "msg_queue.msg_id = comments.id WHERE msg_queue.type=3 and msg_queue.seller_id=:sellerId ".
				 "and comments.store_id=:sid";
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':sellerId', $uid);
			$stmt->bindParam(':sid', $sid);
			return $stmt->queryAll();
		}
		return null;
	}

	public static function getCountByType($uid, $type){
		$connection = MsgQueueAR::model()->getDbConnection();
		$query  = null;
		$query1 = "SELECT COUNT(*) as count FROM msg_queue WHERE ".
				  "msg_queue.seller_id=:uid AND msg_queue.type=:type";
		$query2 = "SELECT %s.store_id AS sid, count(*) AS count FROM ".
			     "msg_queue RIGHT JOIN %s ON msg_queue.msg_id=%s.id WHERE ".
			     "msg_queue.seller_id=:uid AND msg_queue.type=:type GROUP BY %s.store_id";
		switch ($type) {
			case Constants::MSG_SYSTEM: 
			case Constants::MSG_WECHAT:
				$query = $query1;
				break;
			case Constants::MSG_ORDERS:
				$query = $query2;
				$query = sprintf($query, 'ordermsgs', 'ordermsgs', 'ordermsgs', 'ordermsgs');
				break;
			case Constants::MSG_COMMENT:
				$query = $query2;
				$query = sprintf($query, 'comments', 'comments', 'comments', 'comments');
				break;
			default:
				return null;
				break;
		}
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':type', $type);
			return $stmt->queryAll();
		}
		return null;
	}

}