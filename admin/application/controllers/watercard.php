<? 
use Applications\Watercards;
use PortalManager\Pagination;

class watercard extends Controller
{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'Arena Water Card / Adminisztráció';
						
			 
			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();

			if( Post::on('filterList') ){
				$filtered = false;
				
				if($_POST[ID] != ''){
					setcookie('filter_ID',$_POST[ID],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_ID','',time()-100,'/'.$this->view->gets[0]);
				}

				if($_POST[uid] != ''){
					setcookie('filter_uid',$_POST[uid],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_uid','',time()-100,'/'.$this->view->gets[0]);
				}

				if($_POST[nev] != ''){
					setcookie('filter_nev',$_POST[nev],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_nev','',time()-100,'/'.$this->view->gets[0]);
				}

				if($_POST[email] != ''){
					setcookie('filter_email',$_POST[email],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_email','',time()-100,'/'.$this->view->gets[0]);
				}

				if($_POST[kartya_szam] != ''){
					setcookie('filter_kartya_szam',$_POST[kartya_szam],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_kartya_szam','',time()-100,'/'.$this->view->gets[0]);
				}

				if($_POST[egyesulet] != ''){
					setcookie('filter_egyesulet',$_POST[egyesulet],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_egyesulet','',time()-100,'/'.$this->view->gets[0]);
				}

				if($_POST[aktivalva] != ''){
					setcookie('filter_aktivalva',$_POST[aktivalva],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_aktivalva','',time()-100,'/'.$this->view->gets[0]);
				}

				
				if($filtered){
					setcookie('filtered','1',time()+60*24*7,'/'.$this->view->gets[0]);
				}else{
					setcookie('filtered','',time()-100,'/'.$this->view->gets[0]);
				}				
				Helper::reload( '/watercard/-/1' );
			}

			$arg 			= array();
			$arg[limit] 	= 50;
			$filters 		= Helper::getCookieFilter('filter',array('filtered'));

			if ( $this->view->gets[1] == 'check' ) {
				$filters['kartya_szam'] = $this->view->gets[2];
			}
			
			$arg[filters] 	= $filters;

			$this->wc = new Watercards( array( 'db' => $this->db, 'view' => $this->view ) ) ;

			$this->out( 'cards', $this->wc->getAll( $arg ) );
			$this->out( 'navigator', (new Pagination(array(
				'class' => 'pagination pagination-sm center',
				'current' => $this->view->cards['info']['pages']['current'],
				'max' => $this->view->cards['info']['pages']['max'],
				'root' => '/'.__CLASS__.'/-',
				'item_limit' => 18
			)))->render() );



			if(Post::on('delId')){
				try{
					$this->wc->delete($this->view->gets[2]);	
					Helper::reload('/watercard/?msgkey=msg&msg=A kártya igényt sikeresen töröltük!');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			// SEO Információk
			$SEO = null;
			// Site info
			$SEO .= $this->view->addMeta('description','');
			$SEO .= $this->view->addMeta('keywords','');
			$SEO .= $this->view->addMeta('revisit-after','3 days');
			
			// FB info
			$SEO .= $this->view->addOG('type','website');
			$SEO .= $this->view->addOG('url','');
			$SEO .= $this->view->addOG('image','');
			$SEO .= $this->view->addOG('site_name','');
			
			$this->view->SEOSERVICE = $SEO;
		}
		
		function activate()
		{
			$this->wc->activate( $this->view->gets[2] );
			Helper::reload('/watercard');
		}

		function deactivate()
		{
			$this->wc->deactivate( $this->view->gets[2] );
			Helper::reload('/watercard');
		}
		
		function clearfilters(){
			setcookie('filter_ID','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_uid','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_nev','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_email','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_kartya_szam','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_egyesulet','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_aktivalva','',time()-100,'/'.$this->view->gets[0]);

			setcookie('filtered','',time()-100,'/'.$this->view->gets[0]);
			Helper::reload('/'.$this->view->gets[0]);
		}
		
		
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>