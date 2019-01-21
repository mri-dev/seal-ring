<?php
namespace Wordpress;

class GalleryHelper 
{
	const PREFIX = 'wp_bwg_';
	const GALLERY_PATH = 'photo-gallery';
	private $search_var;
	private $search_by;
	private $allowed = false;
	private $imgpath = '';
	private $db;
	private $settings;

	function __construct( $var = false, $by = 'slug', $arg = array() )
	{
		$this->search_var 	= $var;
		$this->search_by 	= $by;

		$this->db 		= $arg['db'];
		$this->settings = $arg['settings'];

		if (!isset($arg['settings'])) 
		{
			throw new \Exception("-settings- argument hiányzik!");			
		}

		$this->allowed = true;

		return $this;
	}

	public function getImages()
	{
		global $wpdb;
		$image_set = false;

		if(!$this->allowed) return false;

		$gallery_id 	= $this->db->query("SELECT id FROM ".self::PREFIX."gallery WHERE ".$this->search_by." = '".$this->search_var."'")->fetchColumn();
		

		if ( $gallery_id ) 
		{
			$image_set 		= array();
			$images 		= $this->db->query($iw = "SELECT id, image_url, thumb_url, description, alt FROM ".self::PREFIX."image WHERE gallery_id = ".$gallery_id." and published = 1 ORDER BY `order` ASC")->fetchAll(\PDO::FETCH_ASSOC);
			$this->imgpath 	= $this->db->query("SELECT images_directory FROM ".self::PREFIX."option WHERE id = 1")->fetchColumn();

			if($images)
			foreach ($images as $image) 
			{
				$image['image_url'] = $this->settings['blog_url'].'/'.$this->imgpath.'/'.self::GALLERY_PATH.$image['image_url'];
				$image['thumb_url'] = $this->settings['blog_url'].'/'.$this->imgpath.'/'.self::GALLERY_PATH.$image['thumb_url'];
				$image_set[] = $image;
			}
		}

		return $image_set;
	}

	function __destruct()
	{
		$this->db = null;
		$this->settings = false;
	}
}