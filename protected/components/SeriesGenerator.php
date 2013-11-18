<?php
class SeriesGenerator extends Controller{
	
	public static $ALPHABET = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
					  'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
					  'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 
					  'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 
					  'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 
					  'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 
					  'Y', 'Z'
					 );
	
	public static $WAP_TOKEN_LEN  = 16;
	public static $MEMBER_KEY_LEN = 32;
	
	/**
	 * 创建wap token
	 */
	public static function generateMemeberToken(){
		$token = '';
		$time = time();
		while($time > 0){
			$token = $token.(SeriesGenerator::$ALPHABET[$time%62]);
			$time  = (int)($time / 10);
		}
		while(strlen($token) < SeriesGenerator::$WAP_TOKEN_LEN){
			$index = (int)rand(0, 61);
			$token = $token.(SeriesGenerator::$ALPHABET[$index]);
		}
		return $token;
	}
	
	/**
	 * 为会员创建key
	 */
	public static function generateMemberKey(){
		$key = '';
		while(strlen($key) < SeriesGenerator::$MEMBER_KEY_LEN){
			$index = (int)rand(0, 61);
			$key = $key.(SeriesGenerator::$ALPHABET[$index]);
		}
		return $key;
	}
	
}