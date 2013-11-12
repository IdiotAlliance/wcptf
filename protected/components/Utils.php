<?php
class Utils {
	public static function getDate($format){
		switch ($format){
			case 'Y-m-d w':
			case 'y-m-d w':
				$date = date('Y-m-d')." ";
				switch (date('w')){
					case 0: $date = $date."星期天"; break;
					case 1: $date = $date."星期一"; break;
					case 2: $date = $date."星期二"; break;
					case 3: $date = $date."星期三"; break;
					case 4: $date = $date."星期四"; break;
					case 5: $date = $date."星期五"; break;
					case 6: $date = $date."星期六"; break;
				}
				return $date;
		}	
	}
}