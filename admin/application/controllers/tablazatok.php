<? 
use Applications\Tabledata;
use PortalManager\Template;

class tablazatok extends Controller 
{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'Táblázatok';
			
			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();
			
	        $this->tables = new Tabledata;
	        $temp = new Template( VIEW . 'templates/' );

			$this->out( 'templates', $temp );			
			$this->out( 'datatable', $this->tables );
			$this->out( 'sizetable', $this->tables->getAll() );

			
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
					$this->tables->add($_POST);	
					Helper::reload( '/tablazatok/' );
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

		}

		public function edit()
		{

			if(Post::on('edit')){
				try{
					$this->tables->edit( $this->view->gets[2], $_POST);	
					Helper::reload();
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			$temp = new Template( VIEW . 'templates/' );

			$this->out( 'templates', $temp );
			$this->out( 'selected_data', $this->tables->get( $this->view->gets[2], 'ID' ) );
		}

		public function del()
		{
			if(Post::on('delId')){
				try{
					$this->tables->delete( $_POST['delId']);	
					Helper::reload('/tablazatok/');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

		}
		
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>