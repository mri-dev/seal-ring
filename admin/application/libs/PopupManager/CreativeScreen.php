<?php
namespace PopupManager;

class CreativeScreen 
{
	const DB_TABLE 			= 'popup_campaign';
	const DB_SETTINGS_TABLE = 'popup_campaign_settings';

	private $db;
	private $data;

	function __construct( $arg = array() )
	{
		$this->db = $arg['db'];

		return $this;
	}

	// Screen másolása
	public function copy()
	{
		if ( !$this->getID()) {
			return false;
		}

		$this->db->query( "CREATE TEMPORARY TABLE tmp SELECT * FROM ".self::DB_TABLE." WHERE ID = ".$this->getID() );
		$this->db->query( "UPDATE tmp SET ID = NULL, name = CONCAT('Másolat: ', name)" );
		$this->db->query( "INSERT INTO ".self::DB_TABLE." SELECT * FROM tmp" );
		$new_screen_id = $this->db->lastInsertId();
		$this->db->query( "DROP TABLE tmp" );


		$this->db->query( "CREATE TEMPORARY TABLE tmp SELECT * FROM ".self::DB_SETTINGS_TABLE." WHERE campaign_id = ".$this->getID() );
		$this->db->query( "UPDATE tmp SET ID = NULL, campaign_id = ".$new_screen_id );
		$this->db->query( "INSERT INTO ".self::DB_SETTINGS_TABLE." SELECT * FROM tmp" );
		$this->db->query( "DROP TABLE tmp" );
	}

	public function delete()
	{
		if ( !$this->getID()) {
			return false;
		}

		// view
		$this->db->query("DELETE FROM ".\PopupManager\Creative::DB_TABLE_LOG_VIEW." WHERE creative_id = ".$this->getCreativeID()." and screen_id = ".$this->getID());
		// click
		$this->db->query("DELETE FROM ".\PopupManager\Creative::DB_TABLE_LOG_CLICKS." WHERE creative_id = ".$this->getCreativeID()." and screen_id = ".$this->getID());

		// Screens
		$this->db->query("DELETE FROM ".self::DB_TABLE." WHERE ID = ".$this->getID());
		// Screen settings
		$this->db->query("DELETE FROM ".self::DB_SETTINGS_TABLE." WHERE campaign_id = ".$this->getID());
	}

	public function load( $screen_id )
	{

		$q = "SELECT 
		c.ID, 
		c.creative_id, 
		c.name, 
		c.use_weight, 
		c.active, 
		(SELECT count(ID) FROM ".\PopupManager\Creative::DB_TABLE_LOG_VIEW." WHERE creative_id = c.creative_id and screen_id = c.ID) as view,
		(SELECT count(ID) FROM ".\PopupManager\Creative::DB_TABLE_LOG_CLICKS." WHERE creative_id = c.creative_id and screen_id = c.ID and closed = 1) as click_close,
		(SELECT count(ID) FROM ".\PopupManager\Creative::DB_TABLE_LOG_CLICKS." WHERE creative_id = c.creative_id and screen_id = c.ID and closed = 0) as click_success 
		";

		$q .= " FROM ".self::DB_TABLE." as c ";
		$q .= " WHERE ID = ".$screen_id;

		$this->data = $this->db->query($q)->fetch(\PDO::FETCH_ASSOC);

		return $this;
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

	public function getID()
	{
		return $this->data['ID'];
	}

	public function getName()
	{
		return $this->data['name'];
	}

	public function getViewNum()
	{
		return $this->data['view'];
	}

	public function isActive()
	{
		return ($this->data['active'] == '1') ? true : false;
	}

	public function getShowWeight()
	{
		return (float)$this->data['use_weight'];
	}

	public function getCreativeID()
	{
		return $this->data['creative_id'];
	}

	public function getSettings( $groupkey )
	{
		$varlist = array();

		$q = "SELECT metakey, metavalue FROM ".self::DB_SETTINGS_TABLE." WHERE creative_id = :c and campaign_id = :s and groupkey = :g";

		$vars = $this->db->squery($q, array( 'c' => $this->getCreativeID(), 's' => $this->getID(), 'g' => $groupkey ));

		if ($vars->rowCount() == 0) {
			return $varlist;
		}

		$data = $vars->fetchAll(\PDO::FETCH_ASSOC);

		foreach ( $data as $d ) 
		{
			$value = trim($d['metavalue']);
			$value = rtrim($value ,'"');
			$value = ltrim($value ,'"');

			$varlist[$d['metakey']] = $value;
		}

		return $varlist;
	}

	public function saveSettings($post)
	{
		$this->db->update(
			self::DB_TABLE,
			$post,
			"ID = ".$this->getID()
		);
	}


	function __destruct()
	{
		$this->db 	= null;
		$this->data = null;
	}		
}