<?
class String{
   static $issuu_ember_width = 725;
   static $issuu_ember_height = 450;
   
   private function getIssuuId($link){
	   	$pos = strpos($link,'e=');
		return substr($link,$pos+2);
   }
   public function ISSUUEmber(&$string){
  		$vw 	= (is_numeric(self::$issuu_ember_width)) ? self::$issuu_ember_width : 725;
		$vh 	= (is_numeric(self::$issuu_ember_height)) ? self::$issuu_ember_height : 450;
		$defStr = $string;
		
	
		preg_match_all("/\[issuu\](.+?)\[\/issuu\]/i",$defStr,$m);
				
		$vURL = $m['1'];
		
		$vid = array();
		
		foreach($vURL as $link){
			$string = str_replace(
			"['issuu']".$link."[/issuu]",
			'<div style="padding:10px; text-align:center;"><div data-configid="'.self::getIssuuId($link).'" style="width: '.$vw.'px; height: '.$vh.'px; text-align:center;" class="issuuembed"></div>
			</div>',
			$string);
		}
   }
   
   public function strCmd(&$s){
	   $from = array('//fel');
	   $to = array('<a href="#top" class="up">lap tetejére</a>');
		$s = str_replace($from,$to,$s);   
   }
}
?>