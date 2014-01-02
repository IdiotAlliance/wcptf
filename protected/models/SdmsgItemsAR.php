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
			array('type', 'numerical', 'integerOnly'=>true),
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

	/**
	 * Find items related to a sdmsg with specified id
	 * @param int $msgId the id of the msg
	 */
	public static function getByMsgId($msgId){
		$items = SdmsgItemsAR::model()->findAll('sdmsg_id=:msgId',
									    		array(':msgId' => $msgId));
		return $items;
	}

	public function getAllCustomizedItem($sellerId){
		$connection = ProductsAR::model()->getDbConnection();
		$query = "select count(*) as item_count,sdmsgs.id as sdmsgs_id,sdmsgs.menu_name,sdmsg_items.type as item_type from keywords left join sdmsgs on sdmsgs.keyword_id = keywords.id 
		left join sdmsg_items on sdmsg_items.sdmsg_id = sdmsgs.id where keywords.seller_id=:seller_id group by keywords.id";
		if ($stmt = $connection->createCommand($query)) {
			$stmt->bindParam(':seller_id',$sellerId);
            $result = $stmt->queryAll();
            for($i=0;$i<count($result);$i++){
            	if($result[$i]['item_count']>1)
            		$result[$i]['type_name'] = '多图文';
            	if($result[$i]['item_type']== 0)
            		$result[$i]['type_name'] = '文本';
            	if($result[$i]['item_count']==1 && $result[$i]['item_type']!= 0)
            		$result[$i]['type_name'] = '单图文';
            }
            return $result;
		}
	}

	public function getItemsBySdmsgsId($sdmsg_id){
		$connection = SdmsgItemsAR::model()->getDbConnection();
		$query = "select * from sdmsg_items where sdmsg_id=:sdmsg_id";
		if ($stmt = $connection->createCommand($query)) {
			$stmt->bindParam(':sdmsg_id',$sdmsg_id);
            $result = $stmt->queryAll();         
            return $result;
		}
	}

	public function getItemById($id){
		$connection = SdmsgItemsAR::model()->getDbConnection();
		$query = "select * from sdmsg_items where id=:id";
		if ($stmt = $connection->createCommand($query)) {
			$stmt->bindParam(':id',$id);
            $result = $stmt->queryAll();         
            return $result;
		}		
	}

	/**
	 * 将多图文的每个图文按顺序在数组中排放
	 * @param int $sdmsg_id the id of the msg
	 */
	public function getImageTexts($sdmsg_id){
		$result = $this->getItemsBySdmsgsId($sdmsg_id);
		$imageTexts = array();
		if(count($result)>1){
			foreach ($result as $re) {
				$type = $re['type'];
				$temp = $type & 3840;
				switch ($temp) {
					case 256:
						$imageTexts[0] = $re;
						break;
					case 512:
						$imageTexts[1] = $re;
						break;
					case 768:
						$imageTexts[2] = $re;
						break;
					case 1024:
						$imageTexts[3] = $re;
						break;
					case 1280:
						$imageTexts[4] = $re;
						break;
					case 1536:
						$imageTexts[5] = $re;
						break;
					case 1792:
						$imageTexts[6] = $re;
						break;	
					case 2048:
						$imageTexts[7] = $re;
						break;	
					case 2304:
						$imageTexts[8] = $re;
						break;	
					case 2560:
						$imageTexts[9] = $re;
						break;		
					default:		
						break;
				}
			}
			for ($i=0; $i<count($imageTexts);$i++) {
				
				$temp = $imageTexts[$i]['type'] & 131;
				switch ($temp) {
					case 1:
						$imageTexts[$i]['resource'] = "外部链接";
						break;
					case 2:
						$imageTexts[$i]['resource'] = "素材";
						break;
					case 128:
						$imageTexts[$i]['resource'] = "在线订单";
						break;
					case 129:
						$imageTexts[$i]['resource'] = "个人中心";
						break;
					case 130:
						$imageTexts[$i]['resource'] = "首页推荐";
						break;
					case 131:
						$imageTexts[$i]['resource'] = "联系我们";
						break;
					default:
						$imageTexts[$i]['resource'] = "外部链接";
						break;
				}
			}
			if($imageTexts[0]['picurl']=="")
				$imageTexts[$i]['picurl'] = '/img/replyCover.png';
			for ($i=1; $i<count($imageTexts); $i++) { 
				if($imageTexts[$i]['picurl'] == "")
					$imageTexts[$i]['picurl'] = '/img/thumbnail.png';
			}
			$sdmsgs = SdmsgsAR::model()->getKeywordsByMsgId($sdmsg_id);
			$imageTexts[0]['keyword'] = $sdmsgs[0]['keyword'];
			return $imageTexts;
		}else if($result[0]['type']!=0 && count($result)==1){
			$temp = $result[0]['type'] & 131;
			switch ($temp) {
				case 1:
					$result[0]['resource'] = "外部链接";
					break;
				case 2:
					$result[0]['resource'] = "素材";
					break;
				case 128:
					$result[0]['resource'] = "在线订单";
					break;
				case 129:
					$result[0]['resource'] = "个人中心";
					break;
				case 130:
					$result[0]['resource'] = "首页推荐";
					break;
				case 131:
					$result[0]['resource'] = "联系我们";
					break;
				default:
					$result[0]['resource'] = "外部链接";
					break;
			}
			return $result;
		}else
			return $result;

	}
	/**
	 * 获取回复类型名称
	 * @param int $sdmsg_id the id of the msg
	 */

	public function getTypeName($sdmsg_id){
		$result = $this->getItemsBySdmsgsId($sdmsg_id);
		$typeName = "";
		if(count($result)>1)
			$typeName = '多图文';
		if($result[0]['type']==0)
			$typeName = '文本';
		if($result[0]['type']!=0 && count($result)==1)
			$typeName = '单图文';

		return $typeName;
	}
}
