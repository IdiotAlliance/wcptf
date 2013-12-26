<?php

class TakeAwayController extends Controller{

	
	public $currentStore = null;
	public $stores = null;

	public function __construct($id,$module=null){

		// call parent's constructor
		parent::__construct($id, $module);
		
		// get stores information from db
		$this->stores = StoreAR::model()->getStoreByUserId(Yii::app()->user->sellerId);
	}

	/**
	 * Set the current store
	 */
	public function setCurrentStore($storeId=-1){
		if($storeId >= 0){
			foreach ($this->stores as $store) {
				# code...
				if($store->id == $storeId){
					$this->currentStore = $store;
					break;
				}	
			}
		}
	}

}