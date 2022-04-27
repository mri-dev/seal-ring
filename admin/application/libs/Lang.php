<?php
  class Lang
	{
		private $builder; 
		private $builder_filters;

		public function builder( $targetlang = 'hu' )
		{
			$this->builder = @file_get_contents( constant('LANG_FOLDER') . $targetlang.'/lang.txt' );
			$this->builder_filters = self::getFilters( $this->builder );

			return $this;
		}

		public function get( $text = '' )
		{
			if( $this->builder )
			{
				return self::content( $text, $this->builder, $this->builder_filters );
			} else {
				return $text;
			}
		}
	
		public static function content( $string, $ctx, $filters = [] )
		{
			$src = self::formatToArray( $ctx );
			$string = (array_key_exists($string,$src)) ? $src[$string] : $string;

			if( $filters )
			{
				$string = self::acceptFilters( $string, $filters );
			}
			
			return $string;	
		}
		
		public static function formatToArray($str){
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

		public static function getFilters( $ctx )
		{
			$filters = [];
			$src = self::formatToArray( $ctx );
			foreach( $src as $key => $value )
			{
				if( strpos($key, 'filter:') === 0 )
				{
					$filters[str_replace('filter:', '', $key)] = $value;
				}
			}
			return $filters;
		}

		public static function acceptFilters( $value, $filters )
		{
			foreach($filters as $search => $replace )
			{
				$src = str_replace("%%", '(.*)', $search);
				preg_match('/'.$src.'/i', $value, $match);
				if( $match && $match[1] )
				{
					$value = preg_replace('/'.$src.'/i', $match[1].str_replace('%%', '', $replace), $value );
				}
			}
			return $value;
		}
}
?>
