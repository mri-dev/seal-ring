<?php
  class Lang{
	
		public static function content( $string, $ctx )
		{
			$src = self::formatToArray( $ctx );
			$string = (array_key_exists($string,$src)) ? $src[$string] : $string; 
			return $string;	
		}
		
		private static function formatToArray($str){
			$arr = array();
			$a_str = explode(';;',rtrim($str,';;'));	
			foreach($a_str as $as){
				$b_str = explode('::',$as);
				$arr[trim($b_str['0'])] = trim($b_str['1']);
			}
			
			return $arr;
		}
	
		public static function getLang(){
			$lang = DLANG;
			
			if($_COOKIE['lang'] != ''){
				$lang = $_COOKIE['lang'];	
			}
			
			return $lang;
		}  
}
?>
