<?
	class Arukereso{
		private static $client_id = null;
		
		public static function trustedShopReg(
			$client 				= false, 
			$client_email 			= false, 
			$client_product_list 	= array()
		){
			
			self::$client_id = $client;
			
			if(!$client) throw new Exception('Árukereső Kliens azonosító hiányzik.');
			if(!$client_email || $client_email == '') throw new Exception('E-mail cím hiányzik a Megbízható Bolt (Árukereső) programhoz!');
			
			if(count($client_product_list) > 0){
				try{
					$app = new TrustedShop(self::$client_id);
				
					$app->SetEmail($client_email);

					foreach($client_product_list as $item){
						$app->AddProduct($item);
					}
					
					$app->Send();
				}catch(Exception $e){
					throw new Exception($e->getMessage());
				}
			}
		}
	}
?>