<? 
use PortalManager\News;
use PortalManager\Pagination;

class hirek extends Controller{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'Hírek / Adminisztráció';
			
			
			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();

			$news = new News( $this->view->gets[2],  array( 'db' => $this->db )  );
			
			if(Post::on('add')){
				try{
					$news->add($_POST);	
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			
			switch($this->view->gets[1]){
				case 'szerkeszt':
					if(Post::on('save')){
						try{
							$news->save($_POST);	
							Helper::reload();
						}catch(Exception $e){
							$this->view->err 	= true;
							$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}
					$this->out( 'news', $news->get( $this->view->gets[2]) );
				break;
				case 'torles':
					if(Post::on('delId')){
						try{
							$news->delete($this->view->gets[2]);	
							Helper::reload('/hirek');
						}catch(Exception $e){
							$this->view->err 	= true;
							$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}
					$this->out( 'news', $news->get( $this->view->gets[2]) );
				break;
			}

			// Hír fa betöltés
			$arg = array(				
				'limit' => 25,
				'page' 	=> Helper::currentPageNum() 
			);
			$page_tree 	= $news->getTree( $arg );
			// Hírek
			$this->out( 'news_list', $page_tree );
			$this->out( 'navigator', (new Pagination(array(
				'class' 	=> 'pagination pagination-sm center',
				'current' 	=> $news->getCurrentPage(),
				'max' 		=> $news->getMaxPage(),
				'root' 		=> '/'.__CLASS__,
				'item_limit'=> 28
			)))->render() );

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