<? class stat extends Controller{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'Statisztika';
			
			 
 			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();
			
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
		
		function termek(){
			$arg = array();
			if($_GET[dateFrom] != '' && $_GET[dateTo] != ''){
				$arg[inDate] = array($_GET[dateFrom],$_GET[dateTo]);
			}
			$this->view->stats = $this->AdminUser->getTermekStatistic($arg);
		}
		function kategoria(){
			$arg = array();
			if($_GET[dateFrom] != '' && $_GET[dateTo] != ''){
				$arg[inDate] = array($_GET[dateFrom],$_GET[dateTo]);
			}
			$this->view->stats = $this->AdminUser->getKategoriaStatistic($arg);
		}
		function kereses(){
			$arg = array();
			if($_GET[dateFrom] != '' && $_GET[dateTo] != ''){
				$arg[inDate] = array($_GET[dateFrom],$_GET[dateTo]);
			}
			$this->view->stats = $this->AdminUser->getKeresesStatistic($arg);
		}
		
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>