<? 
class partnerSale extends Controller 
{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'Eladások partnerkód által / Adminisztráció';
			
			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();

			$this->view->fizetes 			= $this->AdminUser->getFizetesiModok();
			$this->view->szallitas 			= $this->AdminUser->getSzallitasiModok();
			$this->view->allapotok[order]	= $this->AdminUser->getMegrendelesAllapotok();
			$this->view->allapotok[termek]	= $this->AdminUser->getMegrendeltTermekAllapotok();

			$arg 			= array();
			$arg[limit] 	= 50;
			$filters 		= Helper::getCookieFilter('filter',array('filtered'));
			$arg[filters] 	= $filters;
			$arg['onlyreferer'] = true;
			$arg['order'] 		= "o.idopont DESC";

			if(isset($_GET[partner])) {
				$arg['referercode'] = $_GET[partner];	
			}

			if($_GET[ID]) {
				$arg[filters][ID] = $_GET[ID];	
			}

			$this->view->megrendelesek = $this->AdminUser->getMegrendelesek($arg);	
		}
	
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>