<?php

/**
 * This is the model class for table "sdmsgs".
 *
 * The followings are the available columns in table 'sdmsgs':
 * @property string $id
 * @property string $keyword_id
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property SdmsgItems[] $sdmsgItems
 * @property Keywords $keyword
 */
class SdmsgsAR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sdmsgs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('seller_id, type', 'required'),
            array('seller_id, type, match_rule', 'numerical', 'integerOnly'=>true),
            array('menu_name', 'length', 'max'=>128),
            array('keyword', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, seller_id, type, menu_name, keyword, match_rule', 'safe', 'on'=>'search'),
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
            'sdmsgItems' => array(self::HAS_MANY, 'SdmsgItems', 'sdmsg_id'),
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
            'type' => 'Type',
            'menu_name' => 'Menu Name',
            'keyword' => 'Keyword',
            'match_rule' => 'Match Rule',
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
		$criteria->compare('keyword_id',$this->keyword_id,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SdmsgsAR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getMsgByType($userId, $type){
		return SdmsgsAR::model()->find('seller_id=:userId and type=:type',
									    array(':userId' => $userId, ':type'=>$type));
	}

	public static function findMatch($userId, $content){
		if($userId >= 0 && $content){
			$connection = SdmsgsAR::model()->getDbConnection();
			$query = "SELECT * FROM sdmsgs WHERE seller_id=".$userId." AND keyword LIKE '%".$content."%'";
			if($stmt = $connection->createCommand($query)){
				$results = $stmt->queryAll();
				$matches = array();
				$stop = false;
				for($i=0; $i<count($results); $i++){
					$keywords = split(';', $results[$i]['keyword']);
					switch ($results[$i]['match_rule']) {
						case 0:
							# complete match
							if(in_array($content, $keywords)){
								// if a complete match is found, clear the array and insert the result
								unset($matches);
								array_push($matches, $results[$i]);
								// stop iteration
								$stop = true;
							}
							break;
						
						case 1:
							# partial match
							foreach ($keywords as $word) {
								if(strpos($word, $content) >= 0){
									array_push($matches, $results[$i]);
								}
							}
							break;
					}
					if ($stop) {
						break;
					}
				}
				if(empty($matches))
					return null;
				return $matches[0]['id'];
			}
		}
		return null;
	}

	public function getAutoReply($sellerId){
		return SdmsgsAR::model()->find(
			'seller_id=:seller_id and type = 0',
			array(
				':seller_id'=>$sellerId,
			)
		);
	}

	public function getDefaultReply($sellerId){
		return SdmsgsAR::model()->find(
			'seller_id=:seller_id and type = 1',
			array(
				':seller_id'=>$sellerId,
			)
		);
	}

}
