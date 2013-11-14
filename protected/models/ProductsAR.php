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
			array('description, etime, richtext', 'safe'),
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
		获取特定类别的商品
	*/
	public function getCategoryProducts($productType, $sellerId){
		if($productType == '未分类')
			$productList = ProductsAR::model()->with('cover0')->findAll(array(
				'condition' => 't.seller_id =:seller_id and type_id=:type_id',
				'params' => array(':type_id'=>1,':seller_id'=>$sellerId),
				'order'=>'pname DESC',
			));
		else if($productType == "星标类")
			$productList = ProductsAR::model()->with('cover0')->findAll(array(
				'condition' => 'type_id=:type_id and t.seller_id =:seller_id',
				'params' => array(':type_id'=>2,':seller_id'=>$sellerId),
				'order'=>'pname DESC',
			));
		else
			$productList = ProductsAR::model()->with('type','cover0')->findAll(array(
				'condition' => 'type_name=:type_name and t.seller_id =:seller_id',
				'params' => array(':type_name'=>$productType,':seller_id'=>$sellerId),
				'order'=>'pname DESC',
			));
		foreach ($productList as $product) {
			$stime = new DateTime($product->stime);
			$product->stime = $stime->format('Y-m-d');
			$etime = new DateTime($product->etime);
			$product->etime = $etime->format('Y-m-d');
			switch ($product->status) {
				case 0:
					$product->status = '上架中';
					break;
				case 1:
					$product->status = '已上架';
					break;
				case 0:
					$product->status = '已下架';
					break;

				default:
					$product->status = '上架中';
					break;
			}
		}
		return $productList;
	}
	//将对象数组转成数组
	public function getAllProducts($productList){
		$prodList = array();
		foreach ($productList as $product) {
			$prod = array();
			$prod['pname'] = $product->pname;
			$prod['stime'] = $product->stime;
			$prod['etime'] = $product->etime;
			switch ($product->status) {
				case 0:
					$prod['status'] = '上架中';
					break;
				case 1:
					$prod['status'] = '已上架';
					break;
				case 0:
					$prod['status'] = '已下架';
					break;

				default:
					$prod['status'] = '上架中';
					break;
			}
			$prod['price'] = $product->price;
			$prod['cover'] = $product->cover0->pic_url;

			$prodList[] = $prod;
		}
		return $prodList;
	}

	//获取该商户未分类或者星标类的商品数
	public function getSpCategoryNum($typeId){
		$pdList = ProductsAR::model()->findAll(array(
			'condition' => 'seller_id=:seller_id and type_id=:type_id',
			'params' => array(':seller_id'=>Yii::app()->user->sellerId,':type_id'=>$typeId),
		));
		return count($pdList);
	}
	
	public function getProductsBySellerId($sellerId){
		$products = ProductsAR::model()->findAll('seller_id=:sellerId', array(':sellerId'=>$sellerId));
		return $products;
	}

	public function getProduct($pname){
		$product = ProductsAR::model()->find(
			'seller_id=:seller_id AND pname=:pname',
			array(
				':seller_id'=>Yii::app()->user->sellerId,
				':pname'=>$pname,
				)
			);
		$stime = new DateTime($product->stime);
		$product->stime = $stime->format('Y-m-d');
		$etime = new DateTime($product->etime);
		$product->etime = $etime->format('Y-m-d');
		if($product->richtext==null)
			$product->richtext = "请输入商品详细图文信息";
		return $product;
	}
	
	public function getProductById($id){
		$product = ProductsAR::model()->find('id=:id', array(':id'=>$id));
		return $product;
	}
}