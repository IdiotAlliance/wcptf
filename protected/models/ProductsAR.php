<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property string $id
 * @property string $seller_id
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
			array('seller_id, type_id, pname, stime, instore, daily_instore', 'required'),
			array('credit, status, instore, daily_instore, insufficient', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('seller_id, type_id, cover', 'length', 'max'=>11),
			array('pname', 'length', 'max'=>256),
			array('pname, description, etime, richtext', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, seller_id, type_id, pname, price, credit, description, stime, etime, status, instore, daily_instore, insufficient, richtext, cover', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'UsersAR', 'seller_id'),
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
			'seller_id' => 'Seller',
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
		$criteria->compare('seller_id',$this->seller_id,true);
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
	public function getProductByIdSeller($product_id, $sellerId){
		$product = ProductsAR::model()->find('id=:product_id and seller_id=:sellerId', 
			array(':product_id'=>$product_id, ':sellerId'=>$sellerId));
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
	public function buyProduct($product_id, $sellerId, $num){
		$product = ProductsAR::model()->find('id=:product_id and seller_id=:sellerId', 
			array(':product_id'=>$product_id, ':sellerId'=>$sellerId));
		$product->instore = $product->instore - $num;
		$product->save();
		return $product;
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
			'condition' => 'seller_id=:seller_id and type_id=:type_id',
			'params' => array(':seller_id'=>Yii::app()->user->sellerId,':type_id'=>$typeId),
		));
		return count($pdList);
	}
	
	/**
	 * 取出一个商家的所有商品，包括已经被删除的商品
	 * @param unknown $sellerId
	 * @return unknown
	 */
	//获取某商家的所有商品
	public function getProductsBySellerId($sellerId){
		$products = ProductsAR::model()->findAll('seller_id=:sellerId and deleted=:deleted', array(':sellerId'=>$sellerId,':deleted'=>0));
		return $products;
	}

	/**
	 * 
	 * @param unknown $sellerId
	 */
	public function getUndeletedProductsBySellerId($sellerId){
		$products = ProductsAR::model()->findAll('seller_id=:sellerId and deleted<>1', 
												 array(':sellerId'=>$sellerId));
		return $products;
	}
	
	/**
	 * 根据sellerid获取产品，以及它们的图片url
	 * @param unknown $sellerId
	 */
	public function getUndeletedProductsWithPicUrl($sellerId){
		$connection = ProductsAR::model()->getDbConnection();
		$query = "SELECT products.id as id, products.status as status, products.type_id as type_id, products.stime as stime,".
				 " products.etime as etime, products.description as description, products.pname as pname,".
				 " products.price as price, products.daily_instore as daily_instore, pictures.pic_url as picurl".
				 " FROM products LEFT JOIN pictures ON products.cover=pictures.id".
				 " WHERE products.seller_id=:sellerId and products.deleted<>1";
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':sellerId', $sellerId);
			$result = $stmt->queryAll();
			return $result;
		}
	}
	
	public function getProduct($pname){
		$product = ProductsAR::model()->find(
			'seller_id=:seller_id AND pname=:pname',
			array(
				':seller_id'=>Yii::app()->user->sellerId,
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
	public function getProductsByType($sellerId){
		$connection = ProductsAR::model()->getDbConnection();
        $query = "select count(*) as product_count,product_type.id as typeId,product_type.type_name from products left join product_type on products.type_id = product_type.id where products.seller_id=:seller_id group by products.type_id";
        if ($stmt = $connection->createCommand($query)) {
            $stmt->bindParam(':seller_id',$sellerId);
            $result = $stmt->queryAll();
            return $result;
        }
	}

}