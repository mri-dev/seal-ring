<?
namespace PortalManager;
/**
 * @uses WP_Post 
 * */
class CasadaShop {
	const DB_TABLE 		= 'casada_shops';
	const DB_XREF 		= 'casada_shop_user_xref';

	private $data 		= false;
	private $db 		= null;
	private $myPosition = false;

	public function __construct( $data = false, $arg = array() )
	{
		$this->db 	= $arg['db'];

		if(is_numeric($data)) 
		{
			$this->loadShop( $data );
		} else if( is_array($data) )
		{
			$this->data = $data;
		}

		return $this;
		
	}
	/**
	 * Saját GPS pozíció meghatározása
	 * 
	 * @param array $gps_array 0=> lat, 1 = lng
	 * */
	public function setMyPosition($gps_array)
	{
		$this->myPosition = array(
			'lat' => $gps_array[0],
			'lng' => $gps_array[1]
		); 

		return $this;
	}

	public function __destruct()
	{
		$this->db = null;
		$this->myPosition = null;
		$this->data = null;
	}

	public function delete( $shopid )
	{
		$this->db->query("DELETE FROM ".self::DB_XREF." WHERE shop_id = ".$shopid );
		$this->db->query("DELETE FROM ".self::DB_TABLE." WHERE ID = ".$shopid );
	}

	private function loadShop( $id )
	{
		$data 	= array();

		$binds 			= array();
		$binds['id'] 	= (int)$id;

		$qry 	= "
		SELECT 			s.*,
						u.nev as creator_name,
						u.email as creator_email,
						xref.allowed as creator_actived 
		FROM 			".self::DB_TABLE." as s
		LEFT OUTER JOIN ".\PortalManager\Users::TABLE_NAME." as u ON u.ID = s.creator_user
		LEFT OUTER JOIN ".self::DB_XREF." as xref ON xref.user_id = s.creator_user
		WHERE 		 	1=1 and
						s.ID = :id
		";

		$result = $this->db->squery( $qry, $binds );

		$data = $result->fetch(\PDO::FETCH_ASSOC);

		$this->data = $data;
	}

	/**
	 * Shop regisztrálása
	 * 
	 * @param int $uid Partner regisztráció user ID
	 * @param array $data POST data
		 * 
	 * @return array  
	 * */
	public function create( $uid, $data )
	{
		$cim 			= array();
		$cim['irsz'] 	= trim($data['place']['irsz']);
		$cim['address'] = trim($data['place']['city_address']);
		$cim['hsz'] 	= trim($data['place']['address_number']);
		$cimjson 		= json_encode($cim, JSON_UNESCAPED_UNICODE);

		$sorrend 		= (isset($data['place']['sorrend'])) ? $data['place']['sorrend'] : 0;
		$tipus 			= (isset($data['place']['tipus'])) ? $data['place']['tipus'] : 'shop';

		$this->db->insert(
			self::DB_TABLE,
			array(
				'nev' 			=> addslashes($data['place']['name']),
				'telefon' 		=> addslashes($data['place']['phone']),
				'cim' 			=> addslashes($cim['irsz']).' '.addslashes($cim['address']).' '.addslashes($cim['hsz']),
				'cim_json' 		=> $cimjson,
				'nyitvatartas' 	=> json_encode($data['opens'], JSON_UNESCAPED_UNICODE),
				'gps' 			=> trim($data['place']['gps']['lat']).','.trim($data['place']['gps']['lng']),
				'creator_user' 	=> $uid,
				'email' 		=> addslashes($data['place']['email']),
				'sorrend' 		=> $sorrend,
				'tipus' 		=> $tipus
			)
		);

		$id = $this->db->lastInsertId();

		return array(
			'uid' 	=> $uid,
			'data' 	=> $data,
			'id' 	=> $id
		);
	}

	/**
	 * Casada Pont üzletkptő adatok kapcsolat 
	 * 
	 * @param int $uid felhasználó id
	 * @param array $data this.create visszatérése
	 * 
	 * @return int xref kapcsolat ID
	 *  */
	public function registerCreator( $uid, $data)
	{
		if (!$uid || empty($data)) return false;

		$this->db->insert(
			self::DB_XREF,
			array(
				'shop_id' => $data['id'],
				'user_id' => $uid
			)
		);

		$this->db->update(
			\PortalManager\Users::TABLE_NAME,
			array(
				'distributor' => 1
			),
			"ID = ".$uid
		);

		return $this->db->lastInsertId();
	}

	public function getUserShopData( $uid = false )
	{
		$ret = array();

		if (!$uid) return false;


		$check = $this->db->query("SELECT id, shop_id, request_date, allowed, allowed_date FROM ".self::DB_XREF." WHERE user_id = ".$uid);

		if( $check->rowCount() == 0 ) return false;

		$ret['ref'] = $check->fetch(\PDO::FETCH_ASSOC);

		$shop_inf = false;
		$shop = $this->db->query("SELECT nev, telefon, cim, nyitvatartas, gps, email, logo, tipus, aktiv as allowed FROM ".self::DB_TABLE." WHERE ID = ".$ret['ref']['shop_id']." and creator_user = ".$uid.";");

		if( $shop->rowCount() != 0 ) 
		{
			$shop_inf = $shop->fetch(\PDO::FETCH_ASSOC);

			$shop_inf['opens'] 	= json_decode($shop_inf['nyitvatartas'], true);

		}

		$ret['shop'] = $shop_inf;


		return $ret;
	}

	public function getID()
	{
		return $this->data['ID'];
	}

	public function createFrom( $only_name = false )
	{
		if ( $this->data['creator_user'] )
		{
			if( !$only_name )
			{
				return '<a href="/tanacsado/?ID='.$this->data['creator_user'].'">'.$this->data['creator_name'] . '</a> '.( ($this->data['creator_actived'] == '1') ? '<i class="fa fa-check" title="Aktiválva shophoz"></i>' : '<i class="fa fa-exclamation-triangle" style="color:red;" title="Nincs aktiválva shophoz"></i>' ).'<br>('.$this->data['creator_email'] .')';
			} else 
			{
				return $this->data['creator_name'];
			}
			
		} else 
		{
			return 'Admin';
		}
	}

	public function isActive()
	{
		return ($this->data['aktiv'] == 1) ? true : false;
	}

	public function getOpensASString()
	{
		$str 	= '';
		$cont 	= array();
		$opens 	= json_decode($this->data['nyitvatartas'], true);

		if( !is_array($opens) ) return 'n.a.';

		foreach ( $opens as $day => $open ) 
		{
			$op = $open['from'].'-'.$open['to'];

			$cont[$op][] = $day;
		}

		foreach ( $cont as $int => $days) {
			if( $int == 'zárva-zárva') continue; 
			
			$daysstring = '';

			if( count($days) < 2 ) 
			{
				$daysstring = ucfirst(substr($days[0],0,$this->getOpenDayShortprefixindex($days[0])));
			} else {
				$daysstring = ucfirst(substr($days[0],0,$this->getOpenDayShortprefixindex($days[0]))).'-'.ucfirst(substr(end($days),0,$this->getOpenDayShortprefixindex(end($days))));
			}

			$str .= $daysstring.': '.str_replace(':','.',$int).'; ';
		}

		$str = rtrim($str,'; ');

		return $str;
	}

	private function getOpenDayShortprefixindex($clear_dayname)
	{
		switch ($clear_dayname) {
			// szombat = szo
			case 'szerda': case 'csutortok':
				return 2;
			break;
			case 'szombat':
				return 3;
			break;
			default:
				return 1;
			break;
		}
	}

	public function addDistributor($uid)
	{
		$alape = 0;

		// Ha nincs alapértelmezett tanácsadó, akkor legyen az új az alapértelmezett
		$dists = $this->getDistributors();
		if (count($dists) == 0 ) 
		{
			$alape = 1;
		}

		$this->db->insert(
			self::DB_XREF,
			array(
				'user_id' 			=> $uid,
				'shop_id' 			=> $this->getID(),
				'alapertelmezett' 	=> $alape,
				'allowed' 			=> 1,
				'allowed_date' 		=> NOW
			)
		);
	}

	public function setDistributorDefault($uid)
	{
		$this->db->update(
			self::DB_XREF,
			array(
				'alapertelmezett' 	=> 0
			)
		);

		$this->db->update(
			self::DB_XREF,
			array(
				'alapertelmezett' 	=> 1
			),
			"user_id = ".$uid. " and shop_id = ".$this->getID()
		);
	}

	public function removeDistributor($uid)
	{
		$this->db->query("DELETE FROM ".self::DB_XREF." WHERE shop_id = ".$this->getID()." and user_id = ".$uid.";");

		// Ha nincs alapértelmezett tanácsadó, akkor inaktiváljuk a pontot
		$dists = $this->getDistributors();
		if (count($dists) == 0) 
		{
			$this->db->update(
				self::DB_TABLE,
				array(
					'aktiv' => 0
				),
				"ID = ".$this->getID()
			);
		}
	}

	public function getDistributors()
	{
		$data 	= array();
		$binds 	= array();

		$binds['shopid'] = $this->getID();

		$qry 	= "
		SELECT 			xref.user_id,
						xref.request_date,
						xref.allowed_date,
						xref.allowed,
						xref.alapertelmezett,
						u.nev,
						u.email,
						(SELECT ertek FROM ".\PortalManager\Users::TABLE_DETAILS_NAME." WHERE fiok_id = xref.user_id and nev = 'casadapont_tanacsado_titulus' LIMIT 0,1) as titulus,
						(SELECT ertek FROM ".\PortalManager\Users::TABLE_DETAILS_NAME." WHERE fiok_id = xref.user_id and nev = 'casadapont_tanacsado_profil' LIMIT 0,1) as profilkep,						
						(SELECT ertek FROM ".\PortalManager\Users::TABLE_DETAILS_NAME." WHERE fiok_id = xref.user_id and nev = 'szallitas_phone' LIMIT 0,1) as telefon,
						shop.nev as shop_name,
						refererID(u.ID) as referer_code
		FROM 			".self::DB_XREF." as xref	
		LEFT OUTER JOIN ".\PortalManager\Users::TABLE_NAME." as u ON u.ID = xref.user_id	
		LEFT OUTER JOIN ".self::DB_TABLE." as shop ON shop.ID = xref.shop_id
		WHERE 		 	1=1 and xref.shop_id = :shopid
		";

		$result = $this->db->squery( $qry, $binds );

		$data = $result->fetchAll(\PDO::FETCH_ASSOC);

		return $data;
	}

	public function allowAccess()
	{
		$creatorID = $this->data['creator_user'];

		// A creator-nak nincs jelentkezése a shop-hoz
		if( !$this->byAdmin() && !$this->check_xref_user_shop( $creatorID, $this->getID() ) )
		{
			return false;
		}

		$this->db->update(
			self::DB_TABLE,
			array(
				'aktiv' => 1
			),
			"ID = ".$this->getID()
		);

		if ( !$this->byAdmin() ) 
		{
			$this->db->update(
				self::DB_XREF,
				array(
					'allowed' 		=> 1,
					'allowed_date' 	=> NOW
				),
				"shop_id = ".$this->getID()." and user_id = ".$creatorID
			);
		}

		

		return true;
	}

	public function adminEdit($post)
	{
		extract($post);

		$cim 			= array();
		$cim['irsz'] 	= trim($place['irsz']);
		$cim['address'] = trim($place['city_address']);
		$cim['hsz'] 	= trim($place['address_number']);
		$cimjson 		= json_encode($cim, JSON_UNESCAPED_UNICODE);

		$gps = trim($place['gps']['lat']).",".trim($place['gps']['lng']);

		$this->db->update(
			self::DB_TABLE,
			array(
				'nev' 		=> $place['name'],
				'telefon' 	=> $place['phone'],
				'telefon' 	=> $place['phone'],
				'cim' 		=> $cim['irsz']." ".$cim['address']." ".$cim['hsz'],
				'cim_json' 	=> $cimjson,
				'nyitvatartas' => json_encode($opens, JSON_UNESCAPED_UNICODE),
				'sorrend' 	=> $place['sorrend'],
				'tipus' 	=> $place['tipus'],
				'email' 	=> $place['email'],
				'gps' 		=> $gps
			),
			"ID = ".$this->getID()
		);
	}

	public function disallowAccess()
	{
		$this->db->update(
			self::DB_TABLE,
			array(
				'aktiv' => 0
			),
			"ID = ".$this->getID()
		);
	}

	public function isInGEO()
	{
		return ($this->data['geo_show'] == 0) ? false : true;
	}

	public function getTypeData()
	{
		return $this->data['tipus'];
	}

	public function getType()
	{
		return ($this->data['tipus'] == 'shop') ? 'Hivatalos üzlet' : 'Casada Pont';
	}

	public function byAdmin()
	{
		return ($this->data['creator_user']) ? false : true;
	}

	public function hasShop()
	{
		if( !$this->data['ID'] ) return false; else return true;
	}

	public function getName()
	{
		return $this->data['nev'];
	}

	public function isDefault()
	{
		return ($this->data['alapertelmezett'] == '1') ? true : false;
	}

	public function getAddress()
	{
		return $this->data['cim'];
	}

	public function getAddressObj()
	{
		return json_decode($this->data['cim_json']);
	}

	public function getLogo( $prefix = '' )
	{
		$logo = $this->data['logo'];

		if ( !$logo ) {
			$logo = IMG . 'no-image.png';
		} else {
			$logo = $prefix.'/'.$logo;
		}

		return $logo;
	}

	public function getIndex()
	{
		return $this->data['sorrend'];
	}

	public function getOpens()
	{
		$opens = json_decode($this->data['nyitvatartas'], true);

		if (!$opens) {
			return array();
		}

		return $opens;
	}

	public function getPhone()
	{
		return $this->data['telefon'];
	}

	public function getEmail()
	{
		return $this->data['email'];
	}

	public function getGPS()
	{
		$xgps = explode(",",$this->data['gps']);
		return array( 
			'lat' => (float)$xgps[0], 
			'lng' => (float)$xgps[1]
		);
	}

	public function getDirectionURL()
		{
			if ( !$this->myPosition ) {
				return false;
			}

			return "https://www.google.com/maps/dir/".$this->myPosition[lat].",".$this->myPosition[lng]."/".$this->getAddress();
		}

	public function getDistance()
	{
		$gps = $this->getGPS();

		if( !$this->myPosition || empty($this->myPosition['lat']) || empty($this->myPosition['lng']) ) return false;

		$calc = \Helper::distance( $gps['lat'], $gps['lng'], $this->myPosition['lat'], $this->myPosition['lng']);

		return $calc['distance'] . ' ' . $calc['metric'];
	}

	/**
	 * Ellenőrízzük, hogy egy felhasználó jelentkezett-e egy shophoz, mint tanácsadó
	 * */
	private function check_xref_user_shop( $user, $shop )
	{
		return ( $this->db->query("SELECT 1 FROM ".self::DB_XREF." WHERE user_id = $user and shop_id = $shop;")->rowCount() != 0 ) ? true : false;
	}

	private function get_post_meta( $post_id, $key, $off = true )
	{
		$value = $key;

		$q = "SELECT meta_value FROM wp_postmeta WHERE post_id = '$post_id' and meta_key = '$key';";

		$value = $this->db->query( $q )->fetchColumn();

		return $value;
	}

}