<?
use PortalManager\Admin;
use PortalManager\Gallery;
use ShopManager\Categories;
use ShopManager\Category;
use PortalManager\Pagination;

class galeria extends Controller{
		function __construct(){
			parent::__construct();
			parent::$pageTitle = 'Galéria / Adminisztráció';

      $this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();

      // Szűrő mentése
      if(Post::on('filterList')){
        $filtered = false;

        if($_POST['nev'] != ''){
          setcookie('filter_nev',$_POST['nev'],time()+60*24,'/'.$this->view->gets['0']);
          $filtered = true;
        }else{
          setcookie('filter_nev','',time()-100,'/'.$this->view->gets['0']);
        }

        if($_POST['kategoria'] != ''){
          setcookie('filter_kategoria',$_POST['kategoria'],time()+60*24,'/'.$this->view->gets['0']);
          $filtered = true;
        }else{
          setcookie('filter_kategoria','',time()-100,'/'.$this->view->gets['0']);
        }

        if($filtered){
          setcookie('filtered','1',time()+60*24*7,'/'.$this->view->gets['0']);
        }else{
          setcookie('filtered','',time()-100,'/'.$this->view->gets['0']);
        }
        Helper::reload('/galeria');
      }

      $this->Galleries = new Gallery( array( 'db' => $this->db )  );

      $categories = new Categories( array( 'db' => $this->db ) );
      $categories->setTable( 'Galeria_Group' );


      $arg = array(
				'page' => (isset($this->gets['1'])) ? (int)str_replace('P','', $this->gets['1']) : 1
			);
			$arg['limit'] = 25;
      if (isset($_COOKIE['filter_kategoria'])) {
        $arg['in_cat'] = (int)$_COOKIE['filter_kategoria'];
      }
      if (isset($_COOKIE['filter_nev'])) {
        $arg['search'] = array(
					'text' => $_COOKIE['filter_nev'],
					'src_type' => 'ee'
				);
      }

      $galleries = $this->Galleries->simpleGalleryList( $arg );
			$page_current = $this->Galleries->page_current;
			$page_max = $this->Galleries->page_max;

      $this->out( 'galleries', $galleries);
			$this->out( 'navigator', (new Pagination(array(
				'class' 	=> 'pagination pagination-sm center',
				'current' 	=> $page_current,
				'max' 		=> $page_max,
				'root' => '/galeria',
				'after' => false,
				'item_limit'=> 12
			)))->render() );

      $cat_tree 	= $categories->getTree();
      // Kategoriák
      $this->out( 'categories', $cat_tree );

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

    public function creator()
		{
			$news = new Gallery( array( 'db' => $this->db )  );

			if (isset($_GET['rmsg'])) {
				$xrmsg = explode('::', $_GET['rmsg']);
				$this->out('msg', \Helper::makeAlertMsg('p'.ucfirst($xrmsg['0']), $xrmsg['1']));
			}

			if(Post::on('add')){
				try{
					$id = $news->addSimpleGallery( $this->view->adm->user['ID'], $_POST );
					Helper::reload('/galeria/creator/szerkeszt/'.$id.'?rmsg=success::Új galéria sikeresen létrehozva.');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			switch($this->view->gets['2']){
				case 'szerkeszt':
					if(Post::on('save')){
						/* * /
						echo '<pre>';
						print_r($_POST);
						print_r($_FILES);
						echo '</pre>';
						exit;
						/* */
						try{
							$news->editSimpleGallery($this->view->gets['3'], $_POST);
							Helper::reload();
						}catch(Exception $e){
							$this->view->err 	= true;
							$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}
					$this->out( 'news', $news->getSimpleGaleria( $this->view->gets['3']) );
				break;
				case 'torles':
					if(Post::on('delId')){
						try{
							$news->deleteSimpleGallery( $this->view->gets['3'] );
							Helper::reload('/galeria/');
						}catch(Exception $e){
							$this->view->err 	= true;
							$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}
					$this->out( 'news', $news->getSimpleGaleria( $this->view->gets['3']) );
				break;
			}
		}

    function clearfilters(){
      setcookie('filter_nev','',time()-100,'/'.$this->view->gets['0']);
      setcookie('filter_kategoria','',time()-100,'/'.$this->view->gets['0']);
      setcookie('filtered','',time()-100,'/'.$this->view->gets['0']);
      Helper::reload('/galeria/');
    }

		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>
