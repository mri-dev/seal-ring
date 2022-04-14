<?
use PortalManager\News;
use PortalManager\Template;

class home extends Controller{
		function __construct(){
			parent::__construct();
			parent::$pageTitle = '';

			$this->out('homepage', true);
			$this->out('showslideshow', true);
			$this->out('bodyclass', 'homepage');

			if( isset($_GET['lang']) && !empty($_GET['lang']) )
			{
				setcookie( 'lang', $_GET['lang'], time() + 3600 * 24 * 30, '/' );
				Helper::reload( ($_SERVER['HTTP_REFERER'])?:'/' ); exit;
			}

			$news = new News( false, array( 'db' => $this->db ) );
			$temp = new Template( VIEW .'hirek/template/' );
			$ptemp = new Template( VIEW .'templates/' );

			$arg = array(
				'limit' => 30,
				'page' 	=> 1,
				'lathato' => 1,
				
			);
			$this->out( 'news', $news->getTree( $arg ) );
			$this->out( 'template', $temp );
			$this->out( 'ptemplate', $ptemp );

			// SEO Inform��ci��k
			$SEO = null;
			// Site info
			$SEO .= $this->view->addMeta('description', $this->view->settings['about_us']);
			$SEO .= $this->view->addMeta('keywords',$this->view->settings['page_keywords']);
			$SEO .= $this->view->addMeta('revisit-after','3 days');

			// FB info
			$SEO .= $this->view->addOG('title', $this->view->settings['page_title'] . ' - '.$this->view->settings['page_description']);
			$SEO .= $this->view->addOG('description', $this->view->settings['about_us']);
			$SEO .= $this->view->addOG('type','website');
			$SEO .= $this->view->addOG('url', CURRENT_URI );
			$SEO .= $this->view->addOG('image', $this->view->settings['domain'].'/admin'.$this->view->settings['logo']);
			$SEO .= $this->view->addOG('site_name', $this->view->settings['page_title']);
			$this->view->SEOSERVICE = $SEO;
		}

		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>
