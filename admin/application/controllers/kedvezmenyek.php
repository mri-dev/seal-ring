<? class kedvezmenyek extends Controller{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'Törzsvásárlói kedvezmények / Adminisztráció';
			
			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();
			
			
			
			if(Post::on('addUjKedvezmeny')){
				try{
					$this->AdminUser->addKedvezmeny($_POST);
					Helper::reload();
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->bmsg 	= Helper::makeAlertMsg('pError', $e->getMessage()); 
				}
			}
		
			switch($this->view->gets[1]){
				case 'szerkeszt':
					if(Post::on('saveKedvezmeny')){
						try{
							$this->AdminUser->editKedvezmeny($_POST);
							Helper::reload();
						}catch(Exception $e){
							$this->view->err 	= true;
							$this->view->bmsg 	= Helper::makeAlertMsg('pError', $e->getMessage()); 
						}
					}
					
					$this->view->sm = $this->AdminUser->getKedvezmeny($this->view->gets[2]);
				break;
				case 'torles':
					if(Post::on('delId')){
						$this->AdminUser->delKedvezmeny($this->view->gets[2]);
						Helper::reload('/'.__CLASS__);
					}
				break;
			}
			
			$this->view->kedvezmenyek = $this->AdminUser->getKedvezmenyek();
			

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
		
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>