<?php

class TakeAwayController extends Controller{

	
	public $currentStore = null;
	public $stores = null;
	public $action = null;
	public $typeCount = null;

	public function __construct($id,$module=null){

		// call parent's constructor
		parent::__construct($id, $module);
		
		if(Yii::app()->user->isGuest){
			Yii::app()->user->setState('referer', Yii::app()->request->getUrl());
			$this->redirect(Yii::app()->createUrl('accounts/login'));
		}
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

	public function setCurrentAction($aid){
		$this->action = $aid;
	}

	public function setCurrentTypeCount($sid){
		$this->typeCount = ProductTypeAR::model()->getProductsByType($sid);
	}

}