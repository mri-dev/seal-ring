<?php 
	function getHost()
	{
		$HTTP_SERVER_VARS = $_SERVER;
		if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"] != ""){ 
			$IP = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]; 
			$proxy = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
			$host = @gethostbyaddr($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]); 
		}else{ 
			$IP = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
			$host = @gethostbyaddr($HTTP_SERVER_VARS["REMOTE_ADDR"]); 
		} 
		
		$host = gethostbyaddr('80.249.162.130');
				
		return $host;
	}
	
	$host = getHost();
	
	preg_match('/.es|.me|.rs|.hr$/',$host, $esgot);
	preg_match('/.arukeresso.com$/',$host, $arukereso_exc);
		
	if( is_array($esgot) && !empty($esgot) && empty( $arukereso_exc ) ){
		header('Location: http://www.casada.com/?from=shop.casada.hu', true, 302);
		exit;
	}
	
	
	
	
	
?>