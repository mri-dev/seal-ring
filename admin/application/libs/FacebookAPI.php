<?
	class FacebookAPI extends Facebook{
		function __construct($arg){
			parent::__construct($arg);
		}	
		
		function fbUserStat(){
			return $this->getUser();
		}
		function FBLoginUrl(){
			if(!$this->fbUserStat()){
				# Bejelentkező URL
				$url = $this->getLoginUrl(array(
					"scope" 		=> "publish_stream",
					"redirect_uri" 	=> "http://ksz.ppn.hu/fb/saveData"
				));
			}
			
			# Adatbázis műveletek, logolás
			
			return $url;
		}
		
		function MyData($extra = ''){
			$ext = ($extra != '') ? '/'.$extra : '';
			if($this->getUser()){
				return $this->api('/me' . $ext);
	  		}else{
				return false;	
			}
		}
		
		function profilImg($who = null,$style = null){
			$wh = ($who == null) ? $this->fbUserStat() : $who ;
			$style = ($style == null) ? '' : $style ;
			$url = "http://graph.facebook.com/".$wh."/picture";
			return '<img class="'.$style.'" alt="" src="'.$url.'">';
		 }	
		 
	}
?>