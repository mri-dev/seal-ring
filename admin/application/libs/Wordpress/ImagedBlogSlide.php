<?php
namespace Wordpress;

class ImagedBlogSlide extends WPMigrator
{

	function __construct($arg = array())
	{
		parent::__construct($arg);
	}

	public function get( $category )
	{
		$list = array();

		$arg = array(
			'category_name' => $category
		);

		$data = $this->get_posts( $arg );

		if ($data) 
		foreach ( $data as $d ) 
		{
			$d = (object)$d;

			$list[] = array(
				'title' 	=> $d->post_title,
				'desc' 	=> $d->post_content,
				'date' 		=> $d->post_date,
				'link' 	=>  $this->get_post_permalink( $d->ID ),
				'image' 	=> $this->wp_get_attachment_url( $this->get_post_thumbnail_id($d->ID) )
			);
		}

	 	return $list;
	}

}