<? 
class referrerHierarchy extends Controller 
{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'Ajánló rangsor / Adminisztráció';
			
			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();

			$arg 		= array();
			$arg['limit'] = 99999;
						
			$filters = Helper::getCookieFilter('filter',array('filtered'));
			$ug = array();	
			if(isset($_GET['g'])) {
				$ug = explode(",", $_GET['g']);
			}	

			if ($ug) {				
				$filters['user_group'] 	= $ug;
			}

			$arg['onlyreferersale'] = true;
			$arg['order'] = "totalReferredOrderPrices DESC";

			if( isset($_GET['time_from']) || isset($_GET['time_to'])) 
			{
				$arg['referertime'] = array(
					'from' 	=> $_GET['time_from'],
					'to' 	=> $_GET['time_to']
				);
			}
			

			$arg['filters'] = $filters;

			$this->view->users = $this->User->getUserList($arg);			
			$this->out('user_groupes', $this->User->getUserGroupes());
			$this->out('ug', $ug);
		}
	
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>