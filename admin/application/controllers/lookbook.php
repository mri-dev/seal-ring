<? 
use Applications\Lookbooks;
use PortalManager\Template;

class lookbook extends Controller{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'LookBook / Adminisztráció';
						
				
			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();

			$this->lookbook = new Lookbooks( array( 'db' => $this->db ) );


			$this->out( 'lookbooks', $this->lookbook->getAll() );
	
			
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
		}

		public function uj()
		{
			if(Post::on('add')){
				try{
					$this->lookbook->add($_POST);	
					Helper::reload('/lookbook/');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}			
		}

		public function v()
		{
			$temp = new Template( VIEW . 'templates/');

			if(Post::on('saveContainer')){
				try{
					unset($_POST['saveContainer']);
					$this->lookbook->addContainers( $_POST);	
					Helper::reload('/lookbook/v/'.$this->view->gets['2'].'/?msgkey=msg&msg=Változások sikeresen mentve lettek!');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			$this->out( 'template', $temp );
		}

		public function edit()
		{

			if(Post::on('edit')){
				try{
					$this->lookbook->edit( $this->view->gets['2'], $_POST);	
					Helper::reload('/lookbook/?msgkey=msg&msg=Változások sikeresen mentve lettek!');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			$this->out( 'edit', $this->lookbook->getAll( array( 'get' => $this->view->gets['2'] ) ) );			
		}
		
		
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>