<?php

/**
 * This is the model class for table "product_type".
 *
 * The followings are the available columns in table 'product_type':
 * @property string $id
 * @property string $seller_id
 * @property string $type_name
 * @property string $type_description
 *
 * The followings are the available model relations:
 * @property Users $seller
 * @property Products[] $products
 */
class ProductTypeAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductTypeAR the static model class
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
		return 'product_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_name, type_description', 'required'),
			array('seller_id', 'length', 'max'=>11),
			array('type_name', 'length', 'max'=>128),
			array('type_description', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, seller_id, type_name, type_description', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'UsersAR', 'seller_id'),
			'products' => array(self::HAS_MANY, 'ProductsAR', 'type_id'),
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
			'type_name' => 'Type Name',
			'type_description' => 'Type Description',
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
		$criteria->compare('type_name',$this->type_name,true);
		$criteria->compare('type_description',$this->type_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function updateProductType($typeName, $changeName, $changeDesc)
	{
		try{
			$pdType = ProductTypeAR::model()->find(
					'seller_id=:seller_id AND type_name=:type_name',
					array(
						':seller_id'=>Yii::app()->user->sellerId,
						':type_name'=>$typeName,
					)
				);
			$pdType->type_name = $changeName;
			$pdType->type_description = $changeDesc;
			return $pdType->update();
		}catch(Exception $e){
			throw new CHttpException(500,'更新失败，请稍后再试！');
			return false;
		}
	}

	/**
	 * 获取商家的所有产品品类，包括已删除的
	 * @param unknown $sellerId
	 * @return unknown
	 */
	public function getSellerProductType($sellerId)
	{
		$pdTypeList = ProductTypeAR::model()->findAll('seller_id=:sellerId',array(':sellerId'=>$sellerId));
		return $pdTypeList;
	}

	/**
	 * 获取商家未删除的商品品类
	 * @param unknown $sellerId
	 */
	public function getUndeletedProductTypeBySellerId($sellerId){
		$pdTypeList = ProductTypeAR::model()->findAll('seller_id=:sellerId and deleted<>1',
													  array(':sellerId'=>$sellerId));
		return $pdTypeList;
	}
	
	//获取类别的描述
	public function getProductDesc($typeName){
		if($typeName=='未分类' || $typeName=='星标类')
			return '默认分类';
		else{
			$pdType = ProductTypeAR::model()->find(
					'seller_id=:seller_id AND type_name=:type_name',
					array(
						':seller_id'=>Yii::app()->user->sellerId,
						':type_name'=>$typeName,
					)
				);
			return $pdType->type_description;
		}
	}
	//获取特定类别
	public function getProductType($typeName){
		$pdType = ProductTypeAR::model()->find(
					'seller_id=:seller_id AND type_name=:type_name',
					array(
						':seller_id'=>Yii::app()->user->sellerId,
						':type_name'=>$typeName,
					)
				);
		return $pdType;
	}
	
	public function getProductTypeById($id){
		$pdType = ProductTypeAR::model()->find('id=:id', array(':id'=>$id));
		return $pdType;
	}
}