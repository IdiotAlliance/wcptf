<?php

/**
 * This is the model class for table "product_type".
 *
 * The followings are the available columns in table 'product_type':
 * @property string $id
 * @property string $store_id
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
			array('type_name', 'required'),
			array('store_id', 'length', 'max'=>11),
			array('type_name', 'length', 'max'=>128),
			array('type_description', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, store_id, type_name, type_description', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'UsersAR', 'store_id'),
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
			'store_id' => 'Seller',
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
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('type_name',$this->type_name,true);
		$criteria->compare('type_description',$this->type_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function updateProductType($id, $changeName, $changeDesc)
	{
		try{
			$pdType = ProductTypeAR::model()->findByPK($id);
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
		$pdTypeList = ProductTypeAR::model()->findAll('store_id=:sellerId and deleted=:deleted',array(':sellerId'=>$sellerId,':deleted'=>0));
		return $pdTypeList;
	}

	/**
	 * 获取商家未删除的商品品类
	 * @param unknown $sellerId
	 * @deprecated
	 */
	public function getUndeletedProductTypeBySellerId($sellerId){
		$pdTypeList = ProductTypeAR::model()->findAll('store_id=:sellerId and deleted<>1',
													  array(':sellerId'=>$sellerId));
		return $pdTypeList;
	}
	
	public function getUndeletedProductTypeByStoreId($storeId){
		return ProductTypeAR::model()->findAll('store_id=:storeId and deleted<>1',
											   array(':storeId'=>$storeId));
	}

	//获取类别的描述
	public function getProductDesc($typeName){
		if($typeName=='未分类' || $typeName=='星标类')
			return '默认分类';
		else{
			$pdType = ProductTypeAR::model()->find(
					'store_id=:store_id AND type_name=:type_name',
					array(
						':store_id'=>Yii::app()->user->sellerId,
						':type_name'=>$typeName,
					)
				);
			return $pdType->type_description;
		}
		
	}
	
	public function getCategoryByName($name){
		$type = ProductTypeAR::model()->find('type_name=:type_name and store_id=:sellerId and deleted=0',
			array(':type_name'=>$name,':sellerId'=>Yii::app()->user->sellerId));
		return $type;
	}

	//获取商家各类别的商品数量和类别id和名字
	public function getProductsByType($sellerId){
		$connection = ProductsAR::model()->getDbConnection();
        $query = "select count(*) as product_count, product_type.id as typeId,
        product_type.type_name from product_type left join (select * from products where products.deleted<>1) as products_view on products_view.type_id = product_type.id where product_type.store_id=:store_id and product_type.deleted = 0  group by product_type.id";
        if ($stmt = $connection->createCommand($query)) {
            $stmt->bindParam(':store_id',$sellerId);
            $result = $stmt->queryAll();

           	$products = ProductsAR::model()->getProductsBySellerId(Yii::app()->user->sellerId);

           	for($i=0;$i<count($result);$i++){
            	if($result[$i]['product_count']==1)
					$result[$i]['product_count']=0;
           	}
            
        	foreach($products as $product){
        		for($i=0;$i<count($result);$i++){
            		if($product->type_id == $result[$i]['typeId'] && $result[$i]['product_count'] == 0)
            			$result[$i]['product_count']=1;
        		}
        	}

            return $result;
        }

	}

	
	public function getProductTypeById($id){
		$pdType = ProductTypeAR::model()->find('id=:id', array(':id'=>$id));
		return $pdType;
	}
}