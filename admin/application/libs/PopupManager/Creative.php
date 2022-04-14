<?php
namespace PopupManager;

class Creative
{
	const DB_TABLE 				= 'popup_creatives';
	const DB_TABLE_SETTINGS  	= 'popup_creative_settings';
	const DB_TABLE_LOG_VIEW 	= 'popup_creatives_viewed';
	const DB_TABLE_LOG_CLICKS 	= 'popup_clicks';

	private $db;
	private $data;
	private $settings;

	function __construct( $arg = array() )
	{
		$this->db = $arg['db'];


		return $this;
	}

	public function load( $creative_id )
	{
		$q = "SELECT
			c.ID,
			c.name,
			c.`type`,
			c.check_url,
			c.active_from,
			c.active_to,
			c.active,
			(SELECT count(ID) FROM ".self::DB_TABLE_LOG_VIEW." WHERE creative_id = c.ID) as view,
			(SELECT count(ID) FROM ".self::DB_TABLE_LOG_CLICKS." WHERE creative_id = c.ID and closed = 1) as click_close,
			(SELECT count(ID) FROM ".self::DB_TABLE_LOG_CLICKS." WHERE creative_id = c.ID and closed = 0) as click_success
		";
		$q .= " FROM ".self::DB_TABLE." as c ";
		$q .= " WHERE ID = ".$creative_id;

		$this->data = $this->db->query($q)->fetch(\PDO::FETCH_ASSOC);
		$this->settings = $this->loadSettings($this->data['ID']);

		return $this;
	}

	// Kreativ másolása
	public function copy()
	{
		if ( !$this->getID()) {
			return false;
		}

		/**
		 * KREATIVE
		 * */
		// popup_creatives copy

		$this->db->query( "CREATE TEMPORARY TABLE tmp SELECT * FROM ".self::DB_TABLE." WHERE ID = ".$this->getID() );
		$this->db->query( "UPDATE tmp SET ID = NULL, name = CONCAT('Másolat: ', name)" );
		$this->db->query( "INSERT INTO ".self::DB_TABLE." SELECT * FROM tmp" );

		$new_creative_id = $this->db->lastInsertId();

		$this->db->query( "DROP TABLE tmp" );

		// popup_creative_settings copy
		$this->db->query( "CREATE TEMPORARY TABLE tmp SELECT * FROM ".self::DB_TABLE_SETTINGS." WHERE creative_id = ".$this->getID() );
		$this->db->query( "UPDATE tmp SET ID = NULL, creative_id = ".$new_creative_id );
		$this->db->query( "INSERT INTO ".self::DB_TABLE_SETTINGS." SELECT * FROM tmp" );
		$this->db->query( "DROP TABLE tmp" );


		/**
		 * CAMPAIGN
		 * */
		$list = $this->db->query("SELECT ID FROM ".\PopupManager\CreativeScreen::DB_TABLE." WHERE creative_id = ".$this->getID());

		if ($list->rowCount() != 0)
		{
			$lista = $list->fetchAll(\PDO::FETCH_ASSOC);

			foreach ($lista as $d )
			{
				$this->db->query( "CREATE TEMPORARY TABLE tmp SELECT * FROM ".\PopupManager\CreativeScreen::DB_TABLE." WHERE ID = ".$d['ID'] );
				$this->db->query( "UPDATE tmp SET ID = NULL, creative_id = ". $new_creative_id );
				$this->db->query( "INSERT INTO ".\PopupManager\CreativeScreen::DB_TABLE." SELECT * FROM tmp" );
				$new_screen_id = $this->db->lastInsertId();
				$this->db->query( "DROP TABLE tmp" );


				$this->db->query( "CREATE TEMPORARY TABLE tmp SELECT * FROM ".\PopupManager\CreativeScreen::DB_SETTINGS_TABLE." WHERE campaign_id = ".$d['ID'] );
				$this->db->query( "UPDATE tmp SET ID = NULL, creative_id = ". $new_creative_id. ", campaign_id = ".$new_screen_id );
				$this->db->query( "INSERT INTO ".\PopupManager\CreativeScreen::DB_SETTINGS_TABLE." SELECT * FROM tmp" );
				$this->db->query( "DROP TABLE tmp" );
			}
		}
	}

	public function delete()
	{
		if ( !$this->getID()) {
			return false;
		}

		// kreativ
		$this->db->query("DELETE FROM ".self::DB_TABLE." WHERE ID = ".$this->getID());
		// Kreativ beállítások
		$this->db->query("DELETE FROM ".self::DB_TABLE_SETTINGS." WHERE creative_id = ".$this->getID());
		// Kreativ view
		$this->db->query("DELETE FROM ".self::DB_TABLE_LOG_VIEW." WHERE creative_id = ".$this->getID());
		// Kreativ click
		$this->db->query("DELETE FROM ".self::DB_TABLE_LOG_CLICKS." WHERE creative_id = ".$this->getID());

		// Screens
		$this->db->query("DELETE FROM ".\PopupManager\CreativeScreen::DB_TABLE." WHERE creative_id = ".$this->getID());
		// Screen settings
		$this->db->query("DELETE FROM ".\PopupManager\CreativeScreen::DB_SETTINGS_TABLE." WHERE creative_id = ".$this->getID());
	}

	public function loadByURI( $uri )
	{
		$uri = rtrim($uri,"/");

		$q = "SELECT
			c.ID,
			c.name,
			c.`type`,
			c.check_url,
			c.active_from,
			c.active_to,
			c.active,
			(SELECT count(ID) FROM ".self::DB_TABLE_LOG_VIEW." WHERE creative_id = c.ID) as view,
			(SELECT count(ID) FROM ".self::DB_TABLE_LOG_CLICKS." WHERE creative_id = c.ID and closed = 1) as click_close,
			(SELECT count(ID) FROM ".self::DB_TABLE_LOG_CLICKS." WHERE creative_id = c.ID and closed = 0) as click_success
		";
		$q .= " FROM ".self::DB_TABLE." as c ";
		$q .= " WHERE 1=1 and c.active = 1 and now() >= c.active_from and now() < c.active_to ";

		$q .= " and c.check_url = '".$uri."'";

		$this->data = $this->db->query($q)->fetch(\PDO::FETCH_ASSOC);
		$this->settings = $this->loadSettings($this->data['ID']);

		return $this;
	}

	private function loadSettings()
	{
		if( !$this->getID() ) return array();

		$q = "SELECT metakey, metavalue FROM ".self::DB_TABLE_SETTINGS." WHERE creative_id = ".$this->getID()." and groupkey = 'settings';";

		$settings = $this->db->query($q)->fetchAll(\PDO::FETCH_ASSOC);

		$list = array();

		foreach ($settings as $d)
		{
			$v = $d['metavalue'];

			if(is_numeric($v)) {
				$v = (float)$v;
			}

			$list[$d['metakey']] = $v;
		}

		return $list;
	}

	public function logShow( $session_id, $screen_id )
	{
		$this->db->insert(
			self::DB_TABLE_LOG_VIEW,
			array(
				'creative_id' 	=> $this->getID(),
				'screen_id' 	=> $screen_id,
				'session_id' 	=> $session_id
			)
		);
	}

	public function getSessionLastViewAsSec( $session_id )
	{
		$last = $this->db->squery("SELECT idopont FROM ".self::DB_TABLE_LOG_VIEW. " WHERE creative_id = :c and session_id = :s ORDER BY idopont DESC LIMIT 0,1;", array('c' => $this->getID(), 's' => $session_id))->fetchColumn();

		return strtotime( NOW ) - strtotime($last);
	}

	public function getSessionViewedNumbers($session_id)
	{
		return $this->db->squery("SELECT count(ID) FROM ".self::DB_TABLE_LOG_VIEW. " WHERE creative_id = :c and session_id = :s;", array('c' => $this->getID(), 's' => $session_id))->fetchColumn();
	}

	public function getType( $textformat = false )
	{
		if (!$textformat) {
			return $this->data['type'];
		}

		switch ($this->data['type']) {
			case 'timed':
				return 'Időzített';
			break;
			case 'scroll':
				return 'Ablak görgetés';
			break;
			case 'exit':
				return 'Kilépési szándék';
			break;
		}
	}

	public function getViewNum()
	{
		return (int)$this->data['view'];
	}

	public function getFailConversionNum()
	{
		$num = $this->data['click_close'] + ($this->getViewNum() - ($this->data['click_close'] + $this->data['click_success']));

		return $num;
	}

	public function getSuccessConversionNum()
	{
		return (int)$this->data['click_success'];
	}

	public function getDate( $what = 'from' )
	{
		return substr($this->data['active_'.$what], 0, 10);
	}

	public function getSettings()
	{
		return $this->settings;
	}

	public function hasData()
	{
		return ($this->data) ? true : false;
	}

	public function getID()
	{
		return $this->data['ID'];
	}

	public function getName()
	{
		return $this->data['name'];
	}

	public function getActivityURI()
	{
		return $this->data['check_url'];
	}

	public function isActive()
	{
		return ($this->data['active'] == '0') ? false : true;
	}

	public function getURL()
	{
		return $this->data['check_url'];
	}

	function __destruct()
	{
		$this->db 	= null;
		$this->data = null;
	}
}
