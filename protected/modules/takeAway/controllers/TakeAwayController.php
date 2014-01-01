<?php

class TakeAwayController extends Controller{

	
	public $currentStore = null;
	public $stores = null;

	public function __construct($id,$module=null){

		// call parent's constructor
		parent::__construct($id, $module);
		
		// get stores information from db
		$this->stores = StoreAR::model()->getUndeletedStoreByUserId(Yii::app()->user->sellerId);
	}

	/**
	 * Set the current store
	 */
	public function setCurrentStore($storeId=-1){
		$set = false;
		if($storeId >= 0){
			foreach ($this->stores as $store) {
				# code...
				if($store->id == $storeId){
					$this->currentStore = $store;
					$set = true;
					break;
				}
			}
		}
		return $set;
	}

}