<?
namespace PortalManager;

use PortalManager\Coupon;

class Coupons
{
	const DB_TABLE = 'coupons';

	private $db; 
	private $arg;

	public 	$tree 				= false;
	private $current 			= false;
	private $tree_steped_item 	= false;
	private $tree_items 		= 0;
	private $walk_step 			= 0;
	public $qry_str;

	public function __construct( $arg = array() )
	{
		$this->db 	= $arg['db'];
		$this->arg 	= $arg;

		// Auto-setup coupon database
		$this->setup();

		return $this;
	}

	protected function setup()
	{
		$create = "
		CREATE TABLE IF NOT EXISTS `".self::DB_TABLE."` (
		`coupon_code` varchar(25) NOT NULL,
		  `name` varchar(250) DEFAULT NULL,
		  `usage_left` int(6) NOT NULL DEFAULT '999999',
		  `active_from` datetime NOT NULL,
		  `active_to` datetime NOT NULL,
		  `for_users` text,
		  `for_products` text,
		  `for_categories` text,
		  `discount_type` enum('cash','percentage') NOT NULL DEFAULT 'cash' COMMENT 'Kedvezmény típusa',
		  `discount_value` int(11) NOT NULL DEFAULT '0',
		  `active` tinyint(1) NOT NULL DEFAULT '1',
		  `author` int(11) DEFAULT NULL COMMENT 'null = admin, int = reseller',
		  `admin_checked` tinyint(1) NOT NULL DEFAULT '1',
		  PRIMARY KEY (`coupon_code`),
		  KEY `active` (`active`),
		  KEY `discount_type` (`discount_type`),
		  KEY `author` (`author`),
		  KEY `admin_checked` (`admin_checked`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		if( $this->db ) {
			$this->db->query( $create );
		}
	}

	public function getTree( $arg = array() )
	{
		$tree 		= array();

		// Legfelső színtű kategóriák
		$qry = "
		SELECT 			coupon_code 
		FROM 			".self::DB_TABLE." 
		WHERE 			1=1 ";

		if( !$arg['admin'] ) {
			$qry .= " and active = 1 and now() > active_from and now() < active_to ";
		}
	
		$qry .= " ORDER BY 		active DESC, active_to ASC;";

		$this->qry_str = $qry;
		
		$top_cat_qry 	= $this->db->query($qry);
		$top_cat_data 	= $top_cat_qry->fetchAll(\PDO::FETCH_ASSOC); 

		if( $top_cat_qry->rowCount() == 0 ) return $this; 
		
		foreach ( $top_cat_data as $item ) 
		{
			$coupon = (new Coupon( $this->arg ))->get( $item['coupon_code'] );	
			$this->tree_items++;
			$this->tree_steped_item[] = $coupon;	
			$tree[] = $item;
		}

		$this->tree = $tree;

		return $this;
	}

	public function walk()
	{	
		if( !$this->tree_steped_item ) return false;
		
		$this->current = $this->tree_steped_item[$this->walk_step];		

		$this->walk_step++;

		if ( $this->walk_step > $this->tree_items ) {
			// Reset Walk
			$this->walk_step = 0;
			$this->current = false;

			return false;
		}

		return true;	
	}

	public function get()
	{
		return $this->current;
	}

	public function __destruct()
	{
		$this->db 				= null;
		$this->arg 				= null;
		$this->tree 			= false;
		$this->current 			= false;
		$this->tree_steped_item = false;
		$this->tree_items 		= 0;
		$this->walk_step 		= 0;
		$this->qry_str 			= null;
	}
}

?>