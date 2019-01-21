<?php
namespace PopupManager;

use PopupManager\CreativeScreen;

class CreativeScreens
{
	private $db;
	private $arg;
	private $creative_id = false;

	function __construct( $creative_id = false, $arg = array() )
	{
		$this->db 	= $arg[db];
		$this->arg 	= $arg;

		$this->creative_id = $creative_id;

		return $this;
	}

	public function getList()
	{
		$q = "SELECT
			c.ID
		FROM ".\PopupManager\CreativeScreen::DB_TABLE." as c 
		WHERE 1=1
		";

		if ($this->creative_id) {
		 	$q .= " and c.creative_id = ".$this->creative_id;
		}

		$list = $this->db->query($q);

		if ( $list->rowCount() == 0) 
		{
			return array();
		}

		$a = array();

		foreach ($list->fetchAll(\PDO::FETCH_ASSOC) as $d) 
		{
			$a[] = (new CreativeScreen($this->arg))->load($d[ID]);
		}

		return $a;
	}

	public function loadForAction($sessionid = false)
	{
		$ret 		= array();
		$max_weight = 0;
		$weight_row = array();

		$q = "SELECT
			c.ID, 
			c.use_weight
		FROM ".\PopupManager\CreativeScreen::DB_TABLE." as c 
		WHERE 1=1 and c.active = 1
		";

		if ($this->creative_id) {
		 	$q .= " and c.creative_id = ".$this->creative_id;
		}

		$list = $this->db->query($q);

		if($list->rowCount() == 0) return $ret;

		foreach ($list->fetchAll(\PDO::FETCH_ASSOC) as $s ) 
		{
			$max_weight += $s[use_weight];

			for ($i=1; $i <= $s[use_weight] ; $i++) 
			{ 
				$weight_row[] = $s[ID];
			}
		}

		$randid 	= rand(0, $max_weight-1);
		$ret['id'] 	= (int)$weight_row[$randid];

		$screen 	= (new CreativeScreen(array('db' => $this->db)))->load($ret[id]); 
		$ret['variables'] = $screen->getSettings('template');

		return $ret;
	}


	public function create($post)
	{
		$post['creative_id'] = $this->creative_id;	

		if (empty($post['name'])) throw new \Exception("Kérjük, hogy adja meg a megjelenés elnevezését.");	
		if (empty($post['use_weight'])) throw new \Exception("Kérjük, hogy adja meg a megjelenési arányt 1 - 100 tartományban.");	

		$this->db->insert(
			\PopupManager\CreativeScreen::DB_TABLE,
			$post
		);

		return $this->db->lastInsertId();
	}


	function __destruct()
	{
		$this->db 	= null;
		$this->arg 	= null;
	}		
}