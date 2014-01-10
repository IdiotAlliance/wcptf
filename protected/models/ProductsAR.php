<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property string $id
 * @property string $store_id
 * @property string $type_id
 * @property string $pname
 * @property double $price
 * @property integer $credit
 * @property string $description
 * @property string $stime
 * @property string $etime
 * @property integer $status
 * @property integer $instore
 * @property integer $daily_instore
 * @property integer $insufficient
 * @property string $richtext
 * @property string $cover
 *
 * The followings are the available model relations:
 * @property HotProducts[] $hotProducts
 * @property OrderItems[] $orderItems
 * @property ProductType $type
 * @property Users $seller
 * @property Pictures $cover0
 */
class ProductsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductsAR the static model class
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
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('store_id, type_id, pname, stime, instore, daily_instore', 'required'),
			array('credit, status, instore, daily_instore, insufficient', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('store_id, type_id, cover', 'length', 'max'=>11),
			array('pname', 'length', 'max'=>256),
			array('pname, description, etime, richtext', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, store_id, type_id, pname, price, credit, description, stime, etime, status, instore, daily_instore, insufficient, richtext, cover', 'safe', 'on'=>'search'),
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
			'hotProducts' => array(self::HAS_MANY, 'HotProductsAR', 'product_id'),
			'orderItems' => array(self::HAS_MANY, 'OrderItemsAR', 'product_id'),
			'type' => array(self::BELONGS_TO, 'ProductTypeAR', 'type_id'),
			'seller' => array(self::BELONGS_TO, 'UsersAR', 'store_id'),
			'cover0' => array(self::BELONGS_TO, 'PicturesAR', 'cover'),
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
			'type_id' => 'Type',
			'pname' => 'Pname',
			'price' => 'Price',
			'credit' => 'Credit',
			'description' => 'Description',
			'stime' => 'Stime',
			'etime' => 'Etime',
			'status' => 'Status',
			'instore' => 'Instore',
			'daily_instore' => 'Daily Instore',
			'insufficient' => 'Insufficient',
			'richtext' => 'Richtext',
			'cover' => 'Cover',
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
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('stime',$this->stime,true);
		$criteria->compare('etime',$this->etime,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('instore',$this->instore);
		$criteria->compare('daily_instore',$this->daily_instore);
		$criteria->compare('insufficient',$this->insufficient);
		$criteria->compare('richtext',$this->richtext,true);
		$criteria->compare('cover',$this->cover,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	/*
		获取特定商品
	*/
	public function getProductByIdSeller($product_id, $storeId){
		$product = ProductsAR::model()->find('id=:product_id and store_id=:storeId', 
			array(':product_id'=>$product_id, ':storeId'=>$storeId));
		return $product;
	}
	/*
		获取特定商品
	*/
	public function getProductById($product_id){
		$product = ProductsAR::model()->find('id=:product_id', 
			array(':product_id'=>$product_id));
		return $product;
	}
	/*
		购买特定商品
	*/
	public function buyProduct($product_id, $storeId, $num){
		$product = ProductsAR::model()->find('id=:product_id and store_id=:storeId', 
			array(':product_id'=>$product_id, ':storeId'=>$storeId));
		$product->daily_instore = $product->daily_instore - $num;
		$product->save();
		return $product;
	}

	public function getUndeletedProductsByProductType($typeId){
		return ProductsAR::model()->findAll('type_id=:typeId and deleted <> 1', array(':typeId'=>$typeId));
	}

	/*
		获取特定类别的商品
	*/
	public function getCategoryProducts($typeId){

		$productList = ProductsAR::model()->with('cover0')->findAll(array(
			'condition' => 'type_id=:type_id and t.deleted=:deleted',
			'params' => array(':deleted'=>0,':type_id'=>$typeId),
			'order'=>'price DESC',
		));
		foreach ($productList as $product) {
			$stime = new DateTime($product->stime);
			$product->stime = $stime->format('Y-m-d');
			$etime = new DateTime($product->etime);
			$product->etime = $etime->format('Y-m-d');
			$now = date('Y-m-d');
			if($now< $product->stime )
				$product->status = "未到期";
			else if($now > $product->etime)
				$product->status = "已过期";
			else{
				switch ($product->status) {
					case 1:
						$product->status = '已上架';
						break;
					case 2:
						$product->status = '已下架';
						break;
					default:
						$product->status = '已上架';
						break;
				}
			}

		}
		return $productList;
	}
	//将产品list数组转成二维数组，原因在于联表查询没法转成json
	public function getAllProducts($productList){
		$prodList = array();
		foreach ($productList as $product) {
			$prod = array();
			$prod['id'] = $product->id;
			$prod['pname'] = $product->pname;
			$prod['pinyin'] ="xianxian";
			$prod['stime'] = $product->stime;
			$prod['etime'] = $product->etime;
			$prod['status'] = $product->status;
			$prod['price'] = $product->price;
			$prod['cover'] = $product->cover0->pic_url;
			$prod['richtext'] = $product->richtext;

			$prodList[] = $prod;
		}
		return $prodList;
	}
	//将产品转为数组
	public function getProductArray($product){
		$prod = array();
		$prod['id'] = $product->id;
		$prod['pname'] = $product->pname;
		$prod['stime'] = $product->stime;
		$prod['etime'] = $product->etime;
		$prod['credit'] = $product->credit;
		$prod['type_id'] = $product->type_id;
		$now = date('Y-m-d');
		if($now< $product->stime )
			$product->status = "未到期";
		else if($now > $product->etime)
			$product->status = "已过期";
		else{
			switch ($product->status) {
				case 1:
					$product->status = '已上架';
					break;
				case 2:
					$product->status = '已下架';
					break;
				default:
					$product->status = '已上架';
					break;
			}
		}
		$prod['status'] = $product->status;
		$prod['description'] = $product->description;
		$prod['price'] = $product->price;
		$prod['cover'] = $product->cover0->pic_url;
		$prod['instore'] = $product->instore;
		$prod['richtext'] = $product->richtext;
		return $prod;
	}


	//获取该商户未分类或者星标类的商品数
	public function getSpCategoryNum($typeId){
		$pdList = ProductsAR::model()->findAll(array(
			'condition' => 'store_id=:store_id and type_id=:type_id',
			'params' => array(':store_id'=>Yii::app()->user->storeId,':type_id'=>$typeId),
		));
		return count($pdList);
	}
	
	/**
	 * 取出一个商家的所有商品，包括已经被删除的商品
	 * @param unknown $storeId
	 * @deprecated
	 * @return unknown
	 */
	//获取某商家的所有商品
	public function getProductsBySellerId($storeId){
		$products = ProductsAR::model()->findAll('store_id=:storeId and deleted=:deleted', array(':storeId'=>$storeId,':deleted'=>0));
		return $products;
	}

	/**
	 * @param unknown $storeId
	 * @deprecated
	 */
	public function getUndeletedProductsBySellerId($storeId){
		$products = ProductsAR::model()->findAll('store_id=:storeId and deleted<>1', 
												 array(':storeId'=>$storeId));
		return $products;
	}
	
	/**
	 * @param unknown $storeId
	 */
	public function getUndeletedProductsBystoreId($storeId){
		$products = ProductsAR::model()->findAll('store_id=:storeId and deleted<>1', 
												 array(':storeId'=>$storeId));
		return $products;
	}

	/**
	 * 根据storeId获取产品，以及它们的图片url
	 * @param unknown $storeId
	 * @deprecated
	 */
	public function getUndeletedProductsWithPicUrl($storeId){
		$connection = ProductsAR::model()->getDbConnection();
		$query = "SELECT products.id AS id, products.status AS status, products.type_id AS type_id, products.stime AS stime,".
				 " products.etime AS etime, products.description AS description, products.pname AS pname,".
				 " products.price AS price, products.daily_instore AS daily_instore, pictures.pic_url AS picurl".
				 " FROM products LEFT JOIN pictures ON products.cover=pictures.id".
				 " WHERE products.store_id=:storeId and products.deleted<>1";
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':storeId', $storeId);
			$result = $stmt->queryAll();
			return $result;
		}
	}

	/**
	 * 根据store id获取产品，以及它们的图片url
	 * @param integer $sid
	 */
	public function getUndeletedProductsWithPicUrlByStoreId($sid){
		$connection = ProductsAR::model()->getDbConnection();
		$query = "SELECT products.id AS id, products.status AS status, products.type_id AS type_id, products.stime AS stime,".
				 " products.etime AS etime, products.description AS description, products.pname AS pname,".
				 " products.price AS price, products.daily_instore AS daily_instore, pictures.pic_url AS picurl".
				 " FROM products LEFT JOIN pictures ON products.cover=pictures.id".
				 " WHERE products.store_id=:sid and products.deleted<>1";
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':sid', $sid);
			$result = $stmt->queryAll();
			return $result;
		}
	}
	
	public function getProduct($pname){
		$product = ProductsAR::model()->find(
			'store_id=:store_id AND pname=:pname',
			array(
				':store_id'=>Yii::app()->user->storeId,
				':pname'=>$pname,
				)
			);
	}
	
	public function getDetailProductById($id){
		$product = ProductsAR::model()->findByPK($id);
		$stime = new DateTime($product->stime);
		$product->stime = $stime->format('Y-m-d');
		$etime = new DateTime($product->etime);
		$product->etime = $etime->format('Y-m-d');
		if($product->richtext==null)
			$product->richtext = "请输入商品详细图文信息";
		return $product;
	}

	//获取商家各类别的商品数量和类别id和名字，若该类别没有商品将不会显示该类别
	public function getProductsByType($storeId){
		$connection = ProductsAR::model()->getDbConnection();
        $query = "select count(*) AS product_count,product_type.id AS typeId,product_type.type_name from products left join product_type on products.type_id = product_type.id where products.store_id=:store_id group by products.type_id";
        if ($stmt = $connection->createCommand($query)) {
            $stmt->bindParam(':store_id',$storeId);
            $result = $stmt->queryAll();
            return $result;
        }
	}

}