<?php

class PrepaidCardController extends Controller{

	
	public $layout = '/layouts/main';
    public $defaultAction = 'prepaidCard';
	public function actionPrepaidCard()
	{
		$this->render('prepaidCard');
	}
	public function actionGenerateCard(){
		if(isset($_POST['value']) && isset($_POST['num'])){
			$value = $_POST['value'];
			$num = $_POST['num'];
			if(is_numeric($value)&&is_numeric($num)){
				if($value>0 && $num>0){
					$cards = array();
					for($i=0; $i<$num; $i++){
						$card = PrepaidCardAR::model()->generateCard($value);
						array_push($cards, array("cardNo"=>$card->card_no,
							"password"=>$card->password,
							"value"=>$card->value));
					}
					//参数小于0
					$result = array("success"=>1, "cards"=>$cards);
					echo json_encode($result);
				}else{
					//参数小于0
					$result = array("success"=>2);
					echo json_encode($result);
				}
			}else{
				//参数为字符串
				$result = array("success"=>3);
				echo json_encode($result);
			}		
		}else{
			// 参数为空
			$result = array("success"=>0);
			echo json_encode($result);
		}
	}

}