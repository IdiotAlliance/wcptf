<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property string $id
 * @property string $member_id
 * @property string $comment
 * @property integer $status
 * @property string $ctime
 *
 * The followings are the available model relations:
 * @property Members $member
 */
class CommentsAR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, comment', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('member_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, comment, status, ctime', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Members', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'member_id' => 'Member',
			'comment' => 'Comment',
			'status' => 'Status',
			'ctime' => 'Ctime',
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
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ctime',$this->ctime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 通过联合查询获得一家店铺每个会员的评论数量
	 * @param $sellerId
	 */
	public function getCommentsCountBySellerId($sellerId){
		$connection = CommentsAR::model()->getDbConnection();
		$query = "SELECT comments.member_id AS member_id, COUNT(*) AS comment_count FROM comments ".
				 "LEFT JOIN members ON comments.member_id=members.id ".
				 "WHERE members.seller_id=:sellerId GROUP BY comments.member_id";
		$comments = array();
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':sellerId', $sellerId);
			$result = $stmt->queryAll();
			return $result;
		}
		return $comments;
	}
	
	/**
	 * 根据会员的id获取其评论
	 * @param unknown $memberId
	 */
	public function getCommentsByMemberId($memberId){
		$comments = CommentsAR::model()->findAll(
			array(
				'condition'=>'member_id=:memberId',
				'params'=>array(':memberId'=>$memberId),
				'order'=>'ctime DESC',
			)
		);
		return $comments;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommentsAR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
