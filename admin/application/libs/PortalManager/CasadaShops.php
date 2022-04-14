<?php
	namespace PortalManager;

	use PortalManager\CasadaShop;

	class CasadaShops 
	{
		private $has_geolocation 	= false;
		private $arg 				= array();
		private $items 				= array();
		private $db 				= null;
		private $myPosition 		= false;

		public function __construct( $arg = array() )
		{
			$this->arg 	= $arg;
			$this->db 	= $arg['db'];

			return $this;
		}

		public function __destruct()
		{
			$this->db 	= null;
			$this->arg 	= null;
			$this->myPosition = null;
		}

		/**
		 * Saját GPS pozíció meghatározása
		 * 
		 * @param array $gps_array 0=> lat, 1 = lng
		 * */
		public function setMyPosition($gps_array)
		{
			$this->myPosition = array(
				'lat' => $gps_array['0'],
				'lng' => $gps_array['1']
			); 

			if( empty($gps_array['0']) ||  empty($gps_array['1']) ) return $this;

			$this->has_geolocation = true;

			return $this;
		}

		public function getList( $arg = array() )
		{
			$binds 	= array();
			$data 	= array();

			// (((acos(sin((".$this->myPosition['lat']."*pi()/180)) * sin(( SUBSTRING_INDEX( s.gps,  ',', -1 ) *pi()/180))+cos((".$this->myPosition['lat']."*pi()/180)) * cos((SUBSTRING_INDEX( s.gps,  ',', 1 )*pi()/180)) * cos(((".$this->myPosition['lng']."- SUBSTRING_INDEX( s.gps,  ',', -1 ))*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance
			$qry 	= "
			SELECT 			s.ID
			FROM 			".\PortalManager\CasadaShop::DB_TABLE." as s
			WHERE 		 	1=1";

			if( !$arg['admin'] )
			{
				$qry .= " and s.aktiv = 1 and s.geo_show = 1 ";
			}

			if( isset($arg['exc_id']) )
			{
				$binds['exc_id'] = $arg['exc_id'];
				$qry .= " and s.ID NOT IN(:exc_id) ";
			}

			if( $this->has_geolocation ) {
				$lat1 = $this->myPosition['lat']; 
				$lng1 = $this->myPosition['lng']; 

				$qry .= " ORDER BY 
				6371 * 2 * ASIN(SQRT(
		            POWER(SIN((".$lat1." - abs(SUBSTRING_INDEX( s.gps,  ',', 1 ))) * pi()/180 / 2),
		            2) + COS(".$lat1." * pi()/180 ) * COS(abs(SUBSTRING_INDEX( s.gps,  ',', 1 )) *
		            pi()/180) * POWER(SIN((".$lng1." - SUBSTRING_INDEX( s.gps,  ',', -1 )) *
		            pi()/180 / 2), 2) )) ASC";
			} else {
				$qry .= " ORDER BY 		s.aktiv DESC, s.sorrend ASC ";				
			}

			$result = $this->db->squery( $qry, $binds );

			foreach ( $result->fetchAll(\PDO::FETCH_ASSOC) as $d ) 
			{
				$sh = new CasadaShop( $d['ID'], $this->arg );

				if(	$this->has_geolocation )
				{
					$sh->setMyPosition(array($this->myPosition['lat'], $this->myPosition['lng']));
				}	

				$data[] = $sh;
			}

			return $data;
		}

		public function getNearofMe()
		{
			$shop = false;

			$binds 	= array();
			$data 	= array();

			$qry 	= "
			SELECT 			s.ID
			FROM 			".\PortalManager\CasadaShop::DB_TABLE." as s
			WHERE 		 	1=1 and s.aktiv = 1
			";

			if( $this->has_geolocation ) {
				$lat1 = $this->myPosition['lat'];
				$lng1 = $this->myPosition['lng'];

				$qry .= " ORDER BY
				6371 * 2 * ASIN(SQRT(
	            POWER(SIN((".$lat1." - abs(SUBSTRING_INDEX( s.gps,  ',', 1 ))) * pi()/180 / 2),
	            2) + COS(".$lat1." * pi()/180 ) * COS(abs(SUBSTRING_INDEX( s.gps,  ',', 1 )) *
	            pi()/180) * POWER(SIN((".$lng1." - SUBSTRING_INDEX( s.gps,  ',', -1 )) *
	            pi()/180 / 2), 2) )) ASC ";				
			} else {
				$qry .= " ORDER BY s.alapertelmezett DESC";
				//$p['post__in'] = array( get_option( 'shops_default_shop', false ) );
			}

			$qry .= " LIMIT 0,1";

			$shop = $this->db->squery( $qry, $binds )->fetchAll();

			$shopobj = new CasadaShop( $shop['0']['ID'], $this->arg );

			if(	$this->has_geolocation )
			{
				$shopobj->setMyPosition(array($this->myPosition['lat'], $this->myPosition['lng']));
			}		
		
			return $shopobj;
		}
	}

	