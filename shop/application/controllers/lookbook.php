<? 
use Applications\Lookbooks;
use PortalManager\Template;
use ProductManager\Products;

class lookbook extends Controller{
		function __construct(){	
			parent::__construct();
			$title = '';

			$this->lookbooks = new Lookbooks( array( 'db' => $this->db ) );
			$temp = new Template( VIEW . 'templates/');


			$lookbook = $this->lookbooks->getAll( array( 
				'get_by_key' => $this->view->gets['1'] 
			) );

			$lookbook_data = $lookbook['data']['0'];

			// Ha nincs meg a lookbook vagy rejtett, akkor átirányítás a főoldalra
			if ( !$lookbook_data || $lookbook_data['lathato'] == '0' ) {
				Helper::reload('/');
			}

			$this->out( 'temp', $temp );
			$this->out( 'products', new Products( array( 
				'db' => $this->db,
				'user' => $this->User->get() 
			) ));
			$this->out( 'lookbook', $lookbook_data );

			$title .= $lookbook_data['nev'].' | ';
			$title .= 'Lookbook';
						
			// SEO Információk
			$SEO = null;
			// Site info
			$SEO .= $this->view->addMeta('description','');
			$SEO .= $this->view->addMeta('keywords','');
			$SEO .= $this->view->addMeta('revisit-after','3 days');
			
			// FB info
			$SEO .= $this->view->addOG('type','website');
			$SEO .= $this->view->addOG('url',DOMAIN);
			$SEO .= $this->view->addOG('image',DOMAIN.substr(IMG,1).'noimg.jpg');
			$SEO .= $this->view->addOG('site_name',TITLE);
			
			$this->view->SEOSERVICE = $SEO;
		
			
			parent::$pageTitle = $title;
		}
		
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>