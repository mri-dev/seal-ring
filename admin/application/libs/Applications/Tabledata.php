<?
namespace Applications;

use DatabaseManager\Database;

class Tabledata extends Database 
{	
	private $key = false;
	private $description = null;
	private $image = null;
	private $footer_text = null;
	private $datas = array();

	private $dataset_num = 0;
	private $walk_step = 0;

	function __construct() {
		parent::__construct();
	}

	public function add( $post )
	{
		unset($post['add']);


		if ( $post['elnevezes'] == '' ) {
			throw new \Exception("Elnevezés megadása kötelező! Kérjük pótolja!");
		}

		if ( $post['kulcs'] == '' ) {
			throw new \Exception("Azonosító kulcs megadása kötelező! Kérjük pótolja!");
		}

		$post['dataset'] = addslashes( json_encode( $post['dataset'], JSON_UNESCAPED_UNICODE ) );

		$this->insert( 
			'tablazatok',
			$post
		);
	}

	public function edit( $id, $post )
	{
		unset($post['edit']);

		if ( $post['elnevezes'] == '' ) {
			throw new \Exception("Elnevezés megadása kötelező! Kérjük pótolja!");
		}

		if ( $post['kulcs'] == '' ) {
			throw new \Exception("Azonosító kulcs megadása kötelező! Kérjük pótolja!");
		}

		$post['dataset'] = addslashes( json_encode( $post['dataset'], JSON_UNESCAPED_UNICODE ) );

		$this->update( 
			'tablazatok',
			$post,
			"ID = $id" 
		);
	}

	public function delete( $id )
	{
		$this->query("DELETE FROM tablazatok WHERE ID = $id;");
	}

	public function getAll()
	{
		$q = "SELECT * FROM tablazatok;";

		$arg['multi'] = 1;
		extract($this->q($q, $arg));

		return $ret;
	}

	public function get( $val, $by = 'kulcs' )
	{
		$qry = $this->query( sprintf("SELECT * FROM tablazatok WHERE $by = '%s';", $val ) );

		$data = $qry->fetch(\PDO::FETCH_ASSOC);

		$data['dataset'] = json_decode($data['dataset'], JSON_UNESCAPED_UNICODE);

		return $data;
	}

	public function getTable( $key )
	{
		/**
		 * RESET
		 */
		$this->walk_step = 0;
		$this->dataset_num = 0;
		$this->datas = array();
		////////////////////////////
		///
		$this->key = $key;

		$qry = $this->query( sprintf("SELECT * FROM tablazatok WHERE kulcs = '%s';", $key ) );

		$data = $qry->fetch(\PDO::FETCH_ASSOC);

		if ( $data['kep'] ) {
			$this->image =  $data['kep'];
		}

		if ( $data['labresz_megjegyzes'] ) {
			$this->footer_text =  $data['labresz_megjegyzes'];
		}

		if ( $data['leiras'] ) {
			$this->description =  $data['leiras'];
		}

		$dataset = json_decode($data['dataset'], JSON_UNESCAPED_UNICODE);

		$this->datas = $dataset;

		$this->dataset_num = count($this->datas);

		return $this;
	}

	public function checkSet( $value )
	{
		if ( strpos( $value , '|') !== false ) {
			$set = array();
			$value = trim($value, "|");
			$set = explode("|",$value);
			return $set;
		} else {
			return $value;
		}
	}

	public function walkDataset()
	{
		$this->walk_step++;

		$status = true;
		
		$this->current_walk_item = $this->datas[$this->walk_step];
		
		if ( $this->walk_step > $this->dataset_num ) {
			$status = false;
		}

		return $status;
	}

	public function the_table()
	{
		return $this->datas[$this->walk_step];
	}

	public function getImage()
	{
		return ( $this->image ) ? $this->image : false;
	}

	public function getDescription()
	{
		return ( is_null( $this->description) ) ? false : $this->description;
	}

	public function getFooterText()
	{
		return  ( is_null( $this->footer_text) ) ? false : $this->footer_text;
	}

}
?>