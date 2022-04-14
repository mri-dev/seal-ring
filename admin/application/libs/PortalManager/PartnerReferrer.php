<?php
	namespace PortalManager;

	class PartnerReferrer 
	{
		public $code 				= null;
		private $arg 				= array();
		private $item 				= false;
		private $db 				= null;
		private $exluded_user 		= false;
		private $must_loggedin 		= false;
		private $userloggedin 		= false; 
		public $error_msg 			= 'A megadott partnerkód nem jogosítja fel kedvezményes vásárlásra.';
		public $error_type			= 'invalid';

		public function __construct( $code, $arg = array() )
		{
			$this->arg 	= $arg;
			$this->db 	= $arg['db'];
			$this->code = $code;

			if( !isset($this->arg['settings']) ) {
				throw new \Exception('Hiányzik a settings lista.');
			}

			return $this;
		}

		public function setExcludedUser( $user_id )
		{ 
			$this->exluded_user = $user_id;
			return $this;
		}

		public function load()
		{
			if( !$this->code ) return $this;

			// Validate user
			$qry = "SELECT ID, email, nev, user_group FROM ".\PortalManager\Users::TABLE_NAME." WHERE 1 = 1 ";

			if( $this->exluded_user ) {
				$qry .= " and ID != ".$this->exluded_user;
			}

			$qry .= " and ID = resolveRefererID('".$this->code."') and engedelyezve = 1 ";

			$query = $this->db->query( $qry );

			if( $query->rowCount() == 0 ) return $this;

			$this->item = $query->fetch(\PDO::FETCH_ASSOC);


			return $this;
		}

		public function setMustloggedin()
		{
			$this->must_loggedin = true;

			return $this;
		}

		public function setMe( $me )
		{
			$this->userloggedin = $me;

			return $this;
		}

		public function isValid()
		{
			$v = false;

			if( !$this->item ){
				return $v;
			} 

			if ( $this->must_loggedin && !$this->userloggedin ) {
				$this->error_msg = 'Csak bejelentkezezz felhasználó veheti igénybe a kedvezményt!';
				$this->error_type= 'info';
				return false;			
			}

			if( $this->item['user_group'] == \PortalManager\Users::USERGROUP_RESELLER) 	return true;
			if( $this->item['user_group'] == \PortalManager\Users::USERGROUP_SALES) 	return true;

			/**
			 * Jogosúltság ellenőrzése
			 */
			// Minimális összeg limit 
			$min_price = $this->arg['settings']['referer_min_price'];

			// Korábban megrendelt, lezárt megrendelések össz. értéke
			$q = "
			SELECT 				sum((o.me * o.egysegAr)) - (SELECT kedvezmeny FROM orders WHERE ID = o.orderKey) as ar 
			FROM 				`order_termekek` as o 
			WHERE 				o.userID = ".$this->item['ID']." and (SELECT allapot FROM orders WHERE ID = o.orderKey) = ".$this->arg['settings']['flagkey_orderstatus_done'];
			$totalOrderPrice = (float) $this->db->query($q)->fetch(\PDO::FETCH_COLUMN);

			// Vizsgálat: ha kevesebb a megrendelt össz.érték
			if ( $totalOrderPrice < $min_price ) {
				return $v;
			}

			$v = true;

			return $v;
		}

		public function getPartnerName( $hashed = true )
		{
			$name = trim($this->item['nev']);

			if( $hashed ) {
				$xnev = explode(" ", $name);

				$name = substr($xnev['0'],0,1).str_repeat("*",strlen($xnev['0'])-1) ." ".end($xnev);
			}

			return $name;
		}

		public function getPartnerID()
		{
			return $this->item['ID'];
		}

		public function getPartnerGroup()
		{
			return $this->item['user_group'];
		}

		public function getPartnerEmail()
		{
			return $this->item['email'];
		}

		public function getPartnerCode()
		{
			return $this->code;
		}

		public function __destruct()
		{
			$this->db 	= null;
			$this->arg 	= null;
			$this->item = null;
		}	
	}