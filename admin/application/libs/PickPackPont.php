<?
class PickPackPont{
	const ONLINE_LISTA_URL 	= 'http://partner.pickpackpont.hu/stores/pppboltlista.xml';
	const SQL_TABLE 		= 'pickpackpont_boltlista';
	const SQL_SHEME			= 'goldonli_fishing';
	private $rebuild_interval_day = 1;
	private $db		 		= false;
	
	public function __construct( $arg ){
		$this->db = $arg['database'];
		
		$update = ($arg['update']) ? true : false;
		
		if(!$this->db){
			echo __CLASS__.' LIBRARY: adatbázis kapcsolatot csatlakoztassa => arg['database']';
			return false;
		}

		// Refresh list
		if ( $update ) {
			$this->refreshList();
			return true;
		}
		
		$database_build_check = $this->checkDatabaseUsage();
		// Build the Database
		if(!$database_build_check){
			$this->reBuild();	
		}
	}
	
	public function getPointData($uzlet_id){
		if($uzlet_id == '') return false;
		$q = "SELECT * FROM ".self::SQL_TABLE." WHERE ppp_uzlet_kod = ".$uzlet_id;
		
		extract($this->db->q($q));
		
		return $data;	
	}
	public function getList(){
		$q = "SELECT *,IF(varos = 'Budapest',CONCAT(varos,' ',megye),megye) as megye FROM ".self::SQL_TABLE;
		$arg['multi'] = '1';
		extract($this->db->q($q,$arg));
		
		return $data;
	}
	public function getAreas($ppp_data = false){
		if(!$ppp_data) return false;	
		$megyek = array();
		
		foreach($ppp_data as $d){
			if(!in_array($d['megye'],$megyek)){
				$megyek[] = $d['megye'];
			}
		}
		
		asort($megyek);
		
		return $megyek;
	}
	public function getCities($ppp_data = false){
		if(!$ppp_data) return false;	
		$cities = array();
		
		foreach($ppp_data as $d){
			if(!in_array($d['varos'],$cities[$d['megye']])){
				$cities[$d['megye']][] = $d['varos'];
			}
		}
		
		asort($cities);
		
		return $cities;
	}
	public function getPoints($ppp_data = false){
		if(!$ppp_data) return false;	
		$cities = array();
		
		foreach($ppp_data as $d){
			$cities[$d['megye']][$d['varos']][] = $d;
		}
		
		asort($cities);
		
		return $cities;
	}
	private function reBuild(){
		$this->prepareDatabase();
		$this->downloadList();
	}
	private function checkDatabaseUsage(){
		$check_sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".self::SQL_SHEME."' and TABLE_NAME = '".self::SQL_TABLE."'";
		$q = $this->db->query($check_sql);
		
		if($q->rowCount() == 0){
			return false;	
		}else{
			$q = "SELECT datediff(now(),idopont) FROM ".self::SQL_TABLE." LIMIT 0,1;";
			$q = $this->db->query($q);
			
			if($q->rowCount() == 0 || $q->fetchColumn() > $this->rebuild_interval_day){
			 	return false;	
			}else{
				return true;		
			}			
		}
	}
	private function prepareDatabase(){
		$drop_sql = "DROP TABLE IF EXISTS ".self::SQL_TABLE;
		$create_sql = "CREATE TABLE IF NOT EXISTS `".self::SQL_TABLE."` (
			  `ID` int(4) NOT NULL AUTO_INCREMENT,
			  `megye` varchar(100) NOT NULL,
			  `varos` varchar(50) NOT NULL,
			  `cim` text NOT NULL,
			  `uzlet_nev` varchar(200) NOT NULL,
			  `tipus` varchar(50) NOT NULL,
			  `nyitvatartas` text NOT NULL,
			  `leiras` text NOT NULL,
			  `fizetes_bankkartya` tinyint(1) NOT NULL DEFAULT '0',
			  `gps_lat` REAL NOT NULL DEFAULT '0.0',
			  `gps_lng` REAL NOT NULL DEFAULT '0.0',
			  `ppp_uzlet_kod` int(7) NOT NULL,
			  `idopont` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `iranyitoszam` int(5) NOT NULL,
			  PRIMARY KEY (`ID`),
			  KEY `megye` (`megye`),
			  KEY `varos` (`varos`),
			  KEY `tipus` (`tipus`),
			  KEY `iranyitoszam` (`iranyitoszam`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			";
		$this->db->query($drop_sql);
		$this->db->query($create_sql);
	}
	private function downloadList(){
		$file = Helper::XMLParse(self::ONLINE_LISTA_URL);
		
		if($file){
			$shops = $file->Shop;
			if(count($shops) > 0){
				foreach($shops as $s){
					$bankkartya = ($s->IsBankCard == 'X') ? 1 : 0; 
					$nyitvatartas = json_encode(array(
						'Hétfő' => $s->Monday,
						'Kedd' => $s->Tuesday,
						'Szerda' => $s->Wednesday,
						'Csütörtök' => $s->Thursday,
						'Péntek' => $s->Friday,
						'Szombat' => $s->Saturday,
						'Vasárnap' => $s->Sunday
					),JSON_UNESCAPED_UNICODE);
					$gps_lat = str_replace(',','.',trim($s->Lat));
					$gps_lng = str_replace(',','.',trim($s->Lng));
					$this->db->insert(self::SQL_TABLE,
						array('megye', 'varos', 'cim', 'uzlet_nev', 'tipus', 'leiras', 'fizetes_bankkartya', 'gps_lat', 'gps_lng', 'ppp_uzlet_kod', 'iranyitoszam', 'nyitvatartas'),
						array(trim($s->Area), trim($s->City), trim($s->Address), trim($s->PPPShopname), trim($s->ShopType), trim($s->Description), $bankkartya, $gps_lat,$gps_lng, trim($s->ShopCode), trim($s->ZipCode),trim($nyitvatartas))
					);	
				}
			}
		}else{
			error_log('Nem sikerült betölteni a Pick Pack Pontokat. Jelezze az oldal tulajdonosának a hibát!');
		}
		
	}
	private function refreshList(){
		$this->reBuild();
	}
	public function teszt(){
		echo __CLASS__.' meg van nyitva!';	
	}
}
?>