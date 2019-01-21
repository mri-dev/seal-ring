<?php
namespace Wordpress;

class WPMigrator 
{
	const PREFIX = 'wp_';

	private $posts	 		= false;

	function __construct( $arg = array() )
	{
		$this->db = $arg[db];

		return $this;
	}

	
	public function get_option( $key )
	{
		$value = false;

		$get = $this->db->squery( "SELECT option_value FROM ".self::PREFIX."options WHERE option_name = :key", array(
			'key' => $key
		) );

		if ($get->rowCount() == 0) {
			return $value;
		}

		$value = $get->fetchColumn();


		return $value;
	}

	public function get_post_permalink( $post_id = false )
	{
		if ( !$post_id || empty($post_id) ) {
			return false;
		}

		return $this->db->query("SELECT guid FROM ".self::PREFIX."posts WHERE ID = ".$post_id.";")->fetchColumn();
	}

	public function wp_get_attachment_url( $thumb_id = false )
	{
		if ( !$thumb_id || empty($thumb_id) ) {
			return false;
		}

		return $this->db->query("SELECT guid FROM ".self::PREFIX."posts WHERE ID = ".$thumb_id." and post_type = 'attachment';")->fetchColumn();
	}

	public function get_post_thumbnail_id( $post_id = false )
	{
		if ( !$post_id || empty($post_id) ) {
			return false;
		}

		return $this->db->query("SELECT meta_value FROM ".self::PREFIX."postmeta WHERE post_id = ".$post_id." and meta_key = '_thumbnail_id';")->fetchColumn();
	}


	public function get_posts( $arg = array() )
	{
	 	$qry = "SELECT 
	 		p.ID, 
	 		p.post_title,
	 		p.post_content,
	 		p.post_date
	 	FROM ".self::PREFIX."posts as p ";

	 	$qry .= " WHERE 1=1 ";
	 	$qry .= " and p.post_status = 'publish' and p.post_type = 'post' ";

	 	if ( isset($arg['category_name']) ) 
	 	{
	 		$qry .= " and (SELECT 1 FROM `".self::PREFIX."term_relationships` as tr LEFT OUTER JOIN ".self::PREFIX."terms as t ON t.term_id = tr.term_taxonomy_id WHERE tr.object_id = p.ID and t.slug = '".$arg['category_name']."') IS NOT NULL ";
	 	}
	 	

	 	$q = $this->db->query($qry);

	 	if ( $q->rowCount() == 0 ) {
	 		return false;
	 	}

	 	return $q->fetchAll(\PDO::FETCH_ASSOC);
	}

	function __destruct()
	{
		$this->db = null;
	}
}