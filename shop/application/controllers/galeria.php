<?php
use PortalManager\Gallery;

class galeria extends Controller{
		function __construct(){
			parent::__construct();
			parent::$pageTitle = 'Galéria';
			$page_desc = 'Fotó galériánk.';
			$page_img = SOURCE.'images/no-image-gallery.jpg';

			$this->out( 'bodyclass', 'article galleries' );
			$this->out( 'head_img_title', 'Galéria' );
			$cat = (isset($_GET['cat']) && !empty($_GET['cat'])) ? $_GET['cat'] : false;

      $galleries = new Gallery(array('db' => $this->db));

			if (isset($_GET['folder']) && !empty($_GET['folder']))
			{
					$folder = $galleries->getGallery( $_GET['folder'] );
					$this->out( 'gallery', $folder );

					parent::$pageTitle = $folder['title'].' | Galéria';
					$page_desc = $folder['title'].' galéria - '.count($folder['images']). ' db kép.';

					if ($folder['belyeg_kep'] != '') {
						$page_img = UPLOADS.$folder['belyeg_kep'];
					}
			}

			$newgalleries = $galleries->getLastGalleries(array('lathato' => 1));
			$this->out( 'newgalleries', $newgalleries );

			// SEO Információk
			$SEO = null;
			// Site info
			$SEO .= $this->view->addMeta('description', $page_desc );
			$SEO .= $this->view->addMeta('keywords',$this->view->settings['page_keywords']);
			$SEO .= $this->view->addMeta('revisit-after','3 days');

			// FB info
			$SEO .= $this->view->addOG('title', $this->view->settings['page_title'] . ' - '.$this->view->settings['page_description']);
			$SEO .= $this->view->addOG('description', $page_desc );
			$SEO .= $this->view->addOG('type','website');
			$SEO .= $this->view->addOG('url', CURRENT_URI );
			$SEO .= $this->view->addOG('image', $page_img );
			$SEO .= $this->view->addOG('site_name', $this->view->settings['page_title']);
			$this->view->SEOSERVICE = $SEO;
		}

		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				$this->view->news = null;
				parent::__destruct();				# FOOTER
		}
	}

?>
