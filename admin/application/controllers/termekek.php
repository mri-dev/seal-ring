<?
use ShopManager\Categories;
use ProductManager\Products;
use ProductManager\Product;
use PortalManager\Pagination;
use PortalManager\Template;
use PortalManager\Admin;
use FileManager\FileLister;
use Applications\XMLParser;
use ShopManager\FelhasznalasiTeruletek;
use ResourceImporter\ResourceImport;

class termekek extends Controller
{
		function __construct(){
			parent::__construct();
			parent::$pageTitle = 'Termékek / Adminisztráció';

			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();

			if( $_GET['backmsg'] )
			{
				$this->view->bmsg= Helper::makeAlertMsg('pSuccess', $_GET['msg']);
			}

			if ($this->gets['1'] == '' || is_numeric($this->gets['1']))
			{
				// Kategóriák
				$cats = new Categories(  array( 'db' => $this->db )  );
				$this->out( 'categories', $cats->getTree() );

				if(Post::on('actionSaving')){
					try{
						$arg = array();
						$re = $this->AdminUser->doAction($_POST['selectAction'], 'action_', $arg);
						/*echo '<pre>';
						print_r($_POST);
						echo '</pre>';*/
						$this->view->rmsg	= Helper::makeAlertMsg('pSuccess', $re);
					}catch(Exception $e){
						$this->view->err 	= true;
						$this->view->rmsg= Helper::makeAlertMsg('pError', $e->getMessage());
					}
				}

				if(Post::on('filterList')){
					$filtered = false;

					if($_POST['ID'] != ''){
						setcookie('filter_ID',$_POST['ID'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_ID','',time()-100,'/'.$this->view->gets['0']);
					}

					if($_POST['cikkszam'] != ''){
						setcookie('filter_cikkszam',$_POST['cikkszam'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_cikkszam','',time()-100,'/'.$this->view->gets['0']);
					}


					if($_POST['szin'] != ''){
						setcookie('filter_szin',$_POST['szin'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_szin','',time()-100,'/'.$this->view->gets['0']);
					}


					if($_POST['meret'] != ''){
						setcookie('filter_meret',$_POST['meret'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_meret','',time()-100,'/'.$this->view->gets['0']);
					}

					if($_POST['nev'] != ''){
						setcookie('filter_nev',$_POST['nev'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_nev','',time()-100,'/'.$this->view->gets['0']);
					}

					if($_POST['marka'] != ''){
						setcookie('filter_marka',$_POST['marka'],time()+60*24,'/'.$this->view->gets['0']);
							$filtered = true;
					}else{
						setcookie('filter_marka','',time()-100,'/'.$this->view->gets['0']);
					}
					if($_POST['szallitasID'] != ''){
						setcookie('filter_szallitasID',$_POST['szallitasID'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_szallitasID','',time()-100,'/'.$this->view->gets['0']);
					}

					if($_POST['keszletID'] != ''){
						setcookie('filter_keszletID',$_POST['keszletID'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_keszletID','',time()-100,'/'.$this->view->gets['0']);
					}

					if($_POST['lathato'] != ''){
						setcookie('filter_lathato',$_POST['lathato'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_lathato','',time()-100,'/'.$this->view->gets['0']);
					}

					if($_POST['xml_import_done'] != ''){
						setcookie('filter_xml_import_done',$_POST['xml_import_done'],time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_xml_import_done','',time()-100,'/'.$this->view->gets['0']);
					}



					if($_POST['fotermek'] == 'on'){
						setcookie('filter_fotermek',1,time()+60*24,'/'.$this->view->gets['0']);
						$filtered = true;
					}else{
						setcookie('filter_fotermek','',time()-100,'/'.$this->view->gets['0']);
					}

					if($filtered){
						setcookie('filtered','1',time()+60*24*7,'/'.$this->view->gets['0']);
					}else{
						setcookie('filtered','',time()-100,'/'.$this->view->gets['0']);
					}
					Helper::reload('/termekek/1');
				}

				// Termék lista
				$products = new Products( array( 'db' => $this->db ) );
				$price_groups = $products->priceGroupList();

				$filters = Helper::getCookieFilter('filter',array('filtered'));

				// GETS
				if (isset($_GET['article'])) {
					$filters['raktar_articleid'] = $_GET['article'];
				}
				$arg = array(
					'admin' => true,
					'filters' => $filters,
					'limit' => 50,
					'page' => Helper::currentPageNum(),
					'order' => array(
						'by' => 'p.ID',
						'how' => 'DESC'
					)
				);
				$products_list = $products->prepareList( $arg )->getList();
				$this->out( 'products', $products );
				$this->out( 'termekek', $products_list );
				$this->out( 'navigator', (new Pagination(array(
					'class' => 'pagination pagination-sm center',
					'current' => $products->getCurrentPage(),
					'max' => $products->getMaxPage(),
					'root' => '/'.__CLASS__,
					'item_limit' => 28
				)))->render() );

				// Márkák
				$this->view->markak 	= $this->AdminUser->getMarkak();
				// Kategóriák
				$this->view->kategoria  = $this->AdminUser->getTermekKategoriak();

				// Készlet lista
				$this->view->keszlet 	= $this->AdminUser->getKeszletLista();

				// Ár csoportok
				$this->view->price_groups = $price_groups;
			}

			// Szállításimód lista
			$this->view->szallitasMod 	= $this->AdminUser->getSzallitasModLista();
			// Szállításimód lista
			$fizmod = $this->AdminUser->getFizetesiModok();

			$nfizmod = array();
			foreach ( $fizmod as $fm ) {
				$nfizmod[$fm['ID']] = $fm;
			}
			$this->view->fizetesiMod = $nfizmod;
			// Szállítási idő lista
			$this->view->szallitas 	= $this->AdminUser->getSzallitasIdoLista();



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

		function clearfilters(){
			setcookie('filter_ID','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_cikkszam','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_nev','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_szin','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_meret','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_lathato','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_fotermek','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_marka','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_szallitasID','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filter_keszletID','',time()-100,'/'.$this->view->gets['0']);
			setcookie('filtered','',time()-100,'/'.$this->view->gets['0']);
			Helper::reload('/termekek/');
		}

		public function staticmaker()
		{	
			global $root;
			$lang = DLANG;

			if( isset($_COOKIE['langedit']) )
			{
				$lang = $_COOKIE['langedit'];
			}
			
			$this->view->lang = $lang;

			$root = $_SERVER['DOCUMENT_ROOT'].'src/static/';

			/* Automatikus nyelvi mappák létrehozása */
			function checkLangRoot ()
			{
				global $root;
				$folders = ['desc', 'images', 'keywords'];
				
				if( !file_exists($root) )
				{
					mkdir( $root, 0755, true );
				}

				foreach( $folders as $f )
				{
					if( !file_exists($root.$f) )
					{
						mkdir( $root.$f, 0755, true );
					}					
				}
			}

			if( $lang && $lang != DLANG )
			{
				$root = $root.$lang.'/';
			}

			if( isset($_GET['changelang']) && !empty($_GET['changelang']) )
			{
				if( $_GET['changelang'] == DLANG )
				{
					setcookie('langedit', false, time() - 3600, '/' );
				} else {
					setcookie('langedit', $_GET['changelang'], time() + (3600 * 24 * 90), '/' );
				}

				\Helper::reload('/termekek/staticmaker');
			}

			if(Post::on('updateKeywords'))
			{
				checkLangRoot();

				// Files 
				$folder = 'src/static/desc/';

				if( $lang && $lang != DLANG )
				{
					$folder = 'src/static/'.$lang.'/keywords/';
				}
					
				$files = \File::showFolderFiles( $folder );

				if( $files )
				{
					$total = 0;
					$groups = '';
					foreach($files as $f)
					{
						$str = trim(file_get_contents( substr($f['src'], 1) ));
						$sg = str_replace( '.txt', '', $f['name'] );
						if( $str ) $total++;
						$this->db->update(
							'shop_termekek',
							[
								'kulcsszavak' => $str
							],
							sprintf("shopgroup = '%s'", $sg)
						);
						$groups .= $sg.', ';
					}
					$groups = rtrim($groups, ', ');

					$this->view->keywordmsg = '<strong>'.$total. ' db termék csoport</strong> azonosító termék kulcsszava cserélve lett:<br>'.$groups;
				}
				unset($files);
			}

			if(Post::on('createDesc'))
			{
				checkLangRoot();

			 	$html =	fopen( $root.'desc/'.$_POST['group'].'.html' , "w");
				$content = $_POST['content'];
				fwrite($html, $content);
				fclose($html);
			}

			// Files 
			$folder = 'src/static/desc/';

			if( $lang && $lang != DLANG )
			{
				$folder = 'src/static/'.$lang.'/desc/';
			}

			$files = \File::showFolderFiles( $folder );
			$this->view->files = $files;

			// Szerkeszt
			$editor = [];
			if( isset($_GET['edit']) )
			{
				$editor['group'] = str_replace('.html', '', $_GET['edit'] );
				foreach($files as $f)
				{
					if( $f['name'] == $_GET['edit'] )
					{
						$editor['content'] = file_get_contents( $root.'desc/'.$_GET['edit']);
					}
				}
			}

			$this->view->editor = $editor;
		}

		function t(){
			// CRM
			$crm = new ResourceImport( array( 'db' => $this->db ) );
			$products = new Products( array( 'db' => $this->db ) );
			$products->setCRMHandler( $crm );

			switch($this->view->gets['2']){
				case 'del':
					if(Post::on('delTermId')){
						$this->AdminUser->delTermek($this->view->gets['3']);
						Helper::reload('/termekek/-/1');
					}
				break;
				case 'edit': case 'newedit':

					// Termék másolása

					if(Post::on('copyTermek')){
						try{
							$re = $this->AdminUser->copyTermek($_POST['tid'],$_POST['copyNum']);
							$this->view->copyMsg	= Helper::makeAlertMsg('pSuccess', $re);
						}catch(Exception $e){
							$this->view->err 	= true;
							$this->view->copyMsg= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}

					// Termék alapadatok szerkesztése
					if(Post::on('saveTermek')){
						try{
							// Termék adatok mentése
							$save = $products->save( (new Product( array( 'db' => $this->db ) ))
								->setId( $this->view->gets['3'] )
								->setData( array(
								'cikkszam' => $_POST['cikkszam'],
								'nev' => $_POST['nev'],
								'marka' => $_POST['marka'],
								'rovid_leiras' => $_POST['rovid_leiras'],
								'marketing_leiras' => $_POST['marketing_leiras'],
								'leiras' => $_POST['leiras'],
								'bankihitel_leiras' => $_POST['bankihitel_leiras'],
								'letoltesek' => $_POST['letoltesek'],
								'szallitas' => $_POST['szallitasID'],
								'allapot' => $_POST['keszletID'],
								'akcios' => ($_POST['akcios'] ? 1 : 0),
								'ujdonsag' => ($_POST['ujdonsag'] ? 1 : 0),
								'arukereso' => ($_POST['argep'] ? 1 : 0 ),
								'argep' => ($_POST['argep'] ? 1 : 0 ),
								'pickpackpont' => ($_POST['pickpackszallitas'] ? 1 : 0 ),
								'no_cetelem' => ($_POST['no_cetelem'] ? 1 : 0 ),
								'garancia' => ($_POST['garancia'] ?: 0),
								'cat' => $_POST['cat'],
								'szin' => $_POST['szin'],
								'meret' => $_POST['meret'],
								'fotermek' => ($_POST['fotermek'] == 'on' ? 1 : 0),
								'kiemelt' => ($_POST['kiemelt'] == 'on' ? 1 : 0),
								'ajanlorendszer_kiemelt' =>  ($_POST['ajanlorendszer_kiemelt'] == 'on' ? 1 : 0),
								'felhasznalasi_terulet' =>  ((int)$_POST['felhasznalasi_terulet']),
								'lathato' => ($_POST['lathato'] == 'on' ? 1 : 0),
								'ar_netto' => $_POST['netto_ar'],
								'ar_brutto' => $_POST['brutto_ar'],
								'ar_akcios_netto' => $_POST['akcios_netto_ar'],
								'ar_akcios_brutto' => $_POST['akcios_brutto_ar'],
								'raktar_keszlet' => $_POST['raktar_keszlet'],
								'linkek' => array(
									'nev' => $_POST['linkNev'],
									'url' => $_POST['linkUrl'],
								),
								'ar_by' => $_POST['ar_by'],
								'akcios_ar_by' => $_POST['akcios_ar_by'],
								'kulcsszavak' => $_POST['kulcsszavak'],
								'raktar_articleid' => $_POST['raktar_articleid'],
								'raktar_variantid' => $_POST['raktar_variantid'],
								'raktar_supplierid' => $_POST['raktar_supplierid'],
								'raktar_number' => $_POST['raktar_number'],
								'alapertelmezett_kategoria' => $_POST['alapertelmezett_kategoria'],
								'csoport_kategoria' => $_POST['csoport_kategoria'],
								'ajandek' => $_POST['ajandek'],
								'termek_site_url' => $_POST['termek_site_url'],
								'tudastar_url' => $_POST['tudastar_url'],
								'referer_price_discount' => $_POST['referer_price_discount'],
								'show_stock' => $_POST['show_stock'],
								'sorrend' =>  (isset($_POST['sorrend']) ? $_POST['sorrend'] : 100),
								'meta_title' => $_POST['meta_title'],
								'meta_desc' => $_POST['meta_desc'],
								'crm' => $_POST['crm'],
							) ) );
							Helper::reload( '/termekek/t/edit/'.$this->view->gets['3'].'/?backmsg=success&msg='.$save);
						} catch (Exception $e){
							$this->view->err 	= true;
							$this->view->bmsg 	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}

					// Termék adatainak lekérése
					$this->out( 'products', $products );
					$this->out( 'termek', $products->get( $this->view->gets['3'] ) );
					if ( $this->view->termek['related_products_ids'] ) {
						$termek_kapcsolatok = new Products( array( 'db' => $this->db ) );
						$termek_kapcsolatok = $termek_kapcsolatok->prepareList( array(
							'limit' => -1,
							'admin' => true,
							'filters' => array(
								'ID' => $this->view->termek['related_products_ids']
							)
						) )->getList();
						$kapcsolat_template = new Template( VIEW  . 'templates/' );
						$this->out(
							'kapcsolatok',
							$kapcsolat_template->get(
								'products_relatives',
								array(
									'list' 	=> $termek_kapcsolatok,
									'mode' 	=> 'remove',
									'id' 	=> $this->view->termek['ID']
								)
							)
						);
					}

					// Termék képek feltöltése
					if(Post::on('uploadImg')){
						$folder 	= '';
						$firstImg 	= false;
						$tid 		= $_POST['tid'];

						$folder 	= ( $_POST['dir'] ) ?: 'src/products/p'.$this->view->gets['3'];
						$firstImg 	= true;

						if(!file_exists($folder)){
							mkdir($folder,0777,true);
						}

						$tdata = $this->view->termek;

						try{
							$mt = explode(" ",str_replace(".","",microtime()));
							$imgName = Helper::makeSafeUrl($products->getManufacturName($tdata['marka']).'-'.$tdata['nev'], '__'.date('YmdHis').$mt['0']);

							$rei = Images::upload(array(
								'src' 		=> 'img',
								'noRoot' 	=> true,
								'upDir' 	=> $folder,
								'fileName' 	=> $imgName,
								'makeThumbImg' => true,
								'makeWaterMark' => false,
								'maxFileSize' => 5150
							));
						}catch(Exception $e){
							echo $e->getMessage();
						}

						$upDir 		= $rei['dir'];
						$upProfil 	= $rei['file'];

						if ( count($rei['allUploadedFiles']) > 0 ) {
							$img = $this->db->query("SELECT profil_kep FROM shop_termekek WHERE ID = $tid;")->fetch(PDO::FETCH_ASSOC);

							if( $img['profil_kep'] == '' || !$img['profil_kep'] )
								if( $firstImg ) {
									$this->db->query("UPDATE shop_termekek SET kep_mappa = '{$upDir}', profil_kep = '$upProfil' WHERE ID = $tid;");
								}
						}

						if ( count($rei['allUploadedFiles']) > 0 ) {
							foreach($rei['allUploadedFiles'] as $kep){
								$products->addImageToProduct( $tid, $kep );
							}
						}

						Helper::reload();
					}

					// Termék paraméterek mentése
					if( Post::on('saveTermekParams') )
					{
						foreach($_POST['param'] as $pid => $pd){
							$v = $pd;

							if(is_null($v) || $v == ''){
								$this->db->query("DELETE FROM shop_termek_parameter WHERE termekID = {$_POST['tid']} and parameterID = $pid");
							}else{
								if($this->db->query("SELECT id FROM shop_termek_parameter WHERE termekID = {$_POST['tid']} and parameterID = $pid")->rowCount() > 0){
									$this->db->update('shop_termek_parameter',
									array(
										'ertek' => $v
									),
									"termekID = {$_POST['tid']} and parameterID = $pid and katID = {$_POST['kid']}");
								}else{
									$this->db->insert('shop_termek_parameter',
									array(
										'termekID' 		=> $_POST['tid'],
										'katID' 		=> $_POST['kid'],
										'parameterID' 	=> $pid,
										'ertek' 		=> addslashes($v)
									));
								}
							}

						}

						Helper::reload();
					}

					// Felhasználási területek
					$felhasznalasi_teruletek = new FelhasznalasiTeruletek( array( 'db' => $this->db ) );
					$felhasznalasi_teruletek_tree = $felhasznalasi_teruletek->getTree();
					$this->out( 'felhasznalasi_teruletek', $felhasznalasi_teruletek_tree );

					// Kategóriák
					$cats = new Categories( array( 'db' => $this->db ) );
					$this->out( 'categories', $cats->getTree() );
					// Márka lista
					$this->view->markak 	= $this->AdminUser->getMarkak();
					// Készlet lista
					$this->view->keszlet 	= $this->AdminUser->getKeszletLista();
					// Szállítási idő lista
					$this->view->szallitas 	= $this->AdminUser->getSzallitasIdoLista();

					$this->view->parameterek = $this->AdminUser->getParameterOnTermekKategoria($this->view->termek['alapertelmezett_kategoria']);

				break;
				case 'delListingFromKat':
					if(Post::on('delKatItemID')){
						$this->db->query("DELETE FROM shop_termek_in_kategoria WHERE ID = {$_POST['delKatItemID']}");
						Helper::reload('/termekek/t/edit/'.$this->view->gets['4']);
					}
				break;
			}
		}

		function upload_image()
		{

			$products = new Products( array( 'db' => $this->db ) );

			$ids = explode("|", $this->view->gets['2']);
			$this->out( 'ids', $ids );


			// Termék képek feltöltése
			if(Post::on('upload')){
				$folder 	= '';


				$folder 	= ( $_POST['dir'] ) ?: 'src/products/upload_'.date('Ymd');
				$firstImg 	= true;

				if(!file_exists($folder)){
					mkdir($folder,0777,true);
				}

				$tdata = $this->view->termek;

				try{
					$mt = explode(" ",str_replace(".","",microtime()));
					$imgName = 'productimg__'.date('YmdHis').$mt['0'];

					$rei = Images::upload(array(
						'src' 		=> 'img',
						'noRoot' 	=> true,
						'upDir' 	=> $folder,
						'fileName' 	=> $imgName,
						'maxFileSize' => 5150
					));
				}catch(Exception $e){
					echo $e->getMessage();
				}

				$upDir 		= $rei['dir'];
				$upProfil 	= $rei['file'];


				if ( count($rei['allUploadedFiles']) > 0 ) {
					foreach ( $ids as $sid ) {
						$firstImg 	= true;

				  		$products->removeImageFromProduct( $sid );
				  		foreach( $rei['allUploadedFiles'] as $kep ){
				  			if ( $firstImg ) {
				  				$products->setProfilImageToProduct( $sid, $kep );
				  				$firstImg = false;
				  			}
							$products->addImageToProduct( $sid, $kep );
						}
				  	}
				}

				Helper::reload('/termekek/upload_image/?msgkey=msg&msg=Képfeltöltés sikeres. A kiválasztott termékek képei frissítve lettek!');
			}

		}

		function szallitasi_mod(){

			if(Post::on('add')){
				try{
					$this->AdminUser->addSzallitasMod($_POST);
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->bmsg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			if(Post::on('save')){
				try{
					$this->AdminUser->saveSzallitasMod($_POST);
					Helper::reload('/termekek/szallitasi_mod/?msgkey=msg&msg=Változások sikeresen mentve lettek!');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->emsg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			if(Post::on('delId')){
				try{
					$this->AdminUser->delSzallitasMod($this->view->gets['3']);
					Helper::reload('/termekek/szallitasi_mod');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->emsg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			if($this->view->gets['2'] == 'szerkeszt'){
				$this->view->sm = $this->AdminUser->getSzallitasModData($this->view->gets['3']);
			}


			$this->view->n = $this->AdminUser->getSzallitasiModok();
		}

		function fizetesi_mod(){

			if(Post::on('add')){
				try{
					$this->AdminUser->addFizetesiMod($_POST);
					Helper::reload();
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			if(Post::on('save')){
				try{
					$this->AdminUser->saveFizetesiMod($_POST);
					Helper::reload('/termekek/fizetesi_mod');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			if(Post::on('delId')){
				try{
					$this->AdminUser->delFizetesiMod($this->view->gets['3']);
					Helper::reload('/termekek/fizetesi_mod');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			if($this->view->gets['2'] == 'szerkeszt'){
				$this->view->sm = $this->AdminUser->getFizetesiModData($this->view->gets['3']);
			}


			$this->view->n = $this->AdminUser->getFizetesiModok();
		}

		function termek_allapotok(){

			if(Post::on('add')){
				try{
					$this->AdminUser->addTermekAllapot($_POST);
					Helper::reload();
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			if(Post::on('save')){
				try{
					$this->AdminUser->saveTermekAllapot($_POST);
					Helper::reload('/termekek/termek_allapotok');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			if(Post::on('delId')){
				try{
					$this->AdminUser->delTermekAllapot($this->view->gets['3']);
					Helper::reload('/termekek/termek_allapotok');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->msg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			if($this->view->gets['2'] == 'szerkeszt'){
				$this->view->sm = $this->AdminUser->getTermekAllapotData($this->view->gets['3']);
			}


			$this->view->n = $this->AdminUser->getFizetesiModok();
		}

		function szallitasi_ido(){
			if(Post::on('add')){
				try{
					$this->AdminUser->addSzallitasIdo($_POST);
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->bmsg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			if(Post::on('save')){
				try{
					$this->AdminUser->saveSzallitasIdo($_POST);
					Helper::reload('/termekek/szallitasi_ido');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->emsg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
			if(Post::on('delId')){
				try{
					$this->AdminUser->delSzallitasIdo($this->view->gets['3']);
					Helper::reload('/termekek/szallitasi_ido');
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->emsg 	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			if($this->view->gets['2'] == 'szerkeszt'){
				$this->view->sm = $this->AdminUser->getSzallitasIdoData($this->view->gets['3']);
			}

			$this->view->n = $this->AdminUser->getSzallitasIdoList();
		}

		function uj(){
			// Termék márkák
			$this->view->markak = $this->AdminUser->getMarkak();
			// Termékek
			$products = new Products( array( 'db' => $this->db ) );

			// Kategória lista
			/*$categories = new Categories( false, array( 'db' => $this->db ) );
			$cat_tree 	= $categories->getTree();
			$this->out( 'categories', $cat_tree );*/

			// ÚJ termék
			if(Post::on('ujTermek')){
				try{
					//$re = $this->AdminUser->addTermek($_POST);
					$re = $products->create( (new Product( array( 'db' => $this->db ) ))->setData( array(
						'cikkszam' => $_POST['nagyker_kod'],
						'nev' => $_POST['nev'],
						'marka' => $_POST['marka'],
						'rovid_leiras' => $_POST['rovid_leiras'],
						'leiras' => $_POST['leiras'],
						'bankihitel_leiras' => $_POST['bankihitel_leiras'],
						'marketing_leiras' => $_POST['marketing_leiras'],
						'letoltesek' => $_POST['letoltesek'],
						'szallitas' => $_POST['szallitasID'],
						'allapot' => $_POST['keszletID'],
						'akcios' => ($_POST['akcios'] ? 1 : 0),
						'kiemelt' => ($_POST['kiemelt'] == 'on' ? 1 : 0),
						'ujdonsag' => ($_POST['ujdonsag'] ? 1 : 0),
						'arukereso' => ($_POST['argep'] ? 1 : 0 ),
						'argep' => ($_POST['argep'] ? 1 : 0 ),
						'pickpackpont' => ($_POST['pickpackszallitas'] ? 1 : 0 ),
						'no_cetelem' => ($_POST['no_cetelem'] ? 1 : 0 ),
						'garancia' => ($_POST['garancia_honap'] ? $_POST['garancia_honap'] : 0),
						'cat' => $_POST['cat'],
						'ar' => $_POST['ar'],
						'ar_netto' => $_POST['netto_ar'],
						'ar_brutto' => $_POST['brutto_ar'],
						'raktar_keszlet' => $_POST['raktar_keszlet'],
						'ar_akcios' => $_POST['akcios_ar'],
						'ar_akcios_netto' => $_POST['akcios_netto_ar'],
						'ar_akcios_brutto' => $_POST['akcios_brutto_ar'],
						'szin' => $_POST['szin'],
						'meret' => $_POST['meret'],
						'fotermek' => ($_POST['fotermek'] == 1 ? 1 : 0),
						'kulcsszavak' => $_POST['kulcsszavak'],
						'raktar_articleid' => $_POST['raktar_articleid'],
						'raktar_variantid' => $_POST['raktar_variantid'],
						'linkek' => array(
							'nev' => $_POST['linkNev'],
							'url' => $_POST['linkUrl'],
						),
						'connects' 			=> $_POST['productConnects'],
						'csoport_kategoria' => $_POST['csoport_kategoria'],
						'ajandek' 			=> $_POST['ajandek'],
						'termek_site_url' 	=> $_POST['termek_site_url'],
						'show_stock' 		=> $_POST['show_stock'],
						'referer_price_discount' => $_POST['referer_price_discount'],
						'sorrend' 			=>  (isset($_POST['sorrend']) ? $_POST['sorrend'] : 100)
					) ) );

					Helper::reload( '/termekek/uj/?backmsg=success&msg='.$re);
				}catch(Exception $e){
					$this->view->err 	= true;
					$this->view->bmsg	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

		}

		function kepek()
		{
			$this->Admin = new Admin( false, array( 'db' => $this->db )  );

			if( Post::on('connectImagase') ){
				try {
					$this->Admin->autoProductImageConnecter();
					Helper::reload( '/termekek/kepek/?backmsg=success&msg=Képek frissítése megtörtént' );
				} catch (Exception $e) {
					$this->view->err 	= true;
					$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}
		}

		function import()
		{
			$this->Admin 			= new Admin( false, array( 'db' => $this->db )  );
			$this->uploaded_files 	= new FileLister( 'src/uploaded_files/' );

			// Online terméklista xml linkjének mentése
			if( Post::on('save_online_xml_url') ){
				try {
					$re = $this->Admin->save_product_xml_url( $_POST['import_online_xml'] );
					Helper::reload();
				} catch (Exception $e) {
					$this->view->err 	= true;
					$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			if( Post::on('upload_xml') ) {
				if ( $_FILES['xml']['error'] == UPLOAD_ERR_OK ) {
					move_uploaded_file( $_FILES['xml']['tmp_name'], 'src/uploaded_files/'.$_FILES['xml']['name']);
					Helper::reload();
				}
			}

			if ( $_GET['checkurl']) {
				$header = @get_headers( $_GET['checkurl'], 1 );
				$header['header_code'] = substr( $header['0'], 9, 3 );

				$this->out( 'url_result',  $header );
			}

			if ( $this->view->gets['2'] == 'preview' ) {
				// Lista Típusa
				$ext = pathinfo( $_GET['file'], PATHINFO_EXTENSION );

				switch( $ext ) {
					case 'json':
						$json_result = json_decode( file_get_contents( $_GET['file'] ) );

						$articles = $json_result->parameters;

						/**
						 * JSON ELŐKÉSZÍTÉS
						 **/
						$repaired_articles = array();
						foreach ( $articles as $article ) {
							foreach ( $article->variants as $variant ) {
								$in = array();

								$in['articleid'] = $article->article->articleid;
								$in['name'] = $article->article->name;
								$in['number'] = $article->article->number;
								$in['supplier_articlenumber'] = $article->article->supplier_articlenumber;
								$in['description'] = $article->article->description;
								$in['variantid'] = $variant->variantid;
								$in['color_number'] = $variant->color_number;
								$in['color_name'] = $variant->color_name;
								$in['size_name'] = $variant->size;
								$in['netprice'] = $variant->netprice;
								$in['grossprice'] = $variant->grossprice;

								$cats = array();
								if( count( $article->categories ) > 0){
									foreach ( $article->categories as $cat ) {
										$cats[] = $cat->category;
									}
								}
								$in['categories'] = $cats;

								$repaired_articles[] = $in;
							}
						}

						$this->out( 'xml_result',  $repaired_articles );
						$this->out( 'xml_import_check', $this->Admin->checkImportProducts( $this->view->xml_result ) );

					break;
					case 'xml':
						$this->XMList = new XMLParser( $_GET['file'] );
						$this->out( 'xml_result',  $this->XMList->getResult() );
						$this->out( 'xml_import_check', $this->Admin->checkImportProducts( $this->view->xml_result ) );
					break;

				}
			}

			$this->out( 'uploaded_files', $this->uploaded_files );

			// Import művelet
			if ( Post::on('action_do') ) {
				try {
					// Új termékek importálása
					if ( Post::on('create_new_products') ) {
						$this->Admin->importProducts( $this->view->xml_import_check, array( 'mode' => 'create' ) );
					}
					// Frissítendő termékek frissítése
					if ( Post::on('only_update_products') ) {
						$this->Admin->importProducts( $this->view->xml_import_check, array( 'mode' => 'update' ) );
					}

					//Helper::reload('/termekek/import/?msgkey=msg&msg=Importálás műveletek sikeresen befejeződtek!');

				} catch ( Exception $e ) {
					$this->view->err 	= true;
					$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
				}

			}
		}

		function nagyker_arlista(){

			if( Post::on('uploadList') ){
				try {
					$re = $this->AdminUser->uploadNagykerLista();
					Helper::reload();
				} catch (Exception $e) {
					$this->view->err 	= true;
					$this->view->bmsg	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			if( Post::on('addNagyker') ){
				try {
					$re = $this->AdminUser->addNagyker($_POST);
					Helper::reload();
				} catch (Exception $e) {
					$this->view->err 	= true;
					$this->view->bmsg	= Helper::makeAlertMsg('pError', $e->getMessage());
				}
			}

			// Nagyker árlista
			$this->view->arlista = $this->AdminUser->getNagykerArlista();

			if( $_GET['path'] != '' )
			$this->view->csv = CSVParser::GET( $_GET['path'] );
		}

		public function csoportmodosito()
		{
			// Termék lista
			$terms = new Products( array( 'db' => $this->db ) );

			$arg = array(
				'collectIDS' => true,
				'admin' => true,
				'filters' => array(),
				'limit' => -1,
				'page' => 1,
				'shortlist' => true,
				'order' => array(
					'by' => 'p.ID',
					'how' => 'DESC'
				)
			);

			if (isset($_GET['by']) && isset($_GET['src']))
			{
				$_GET['by'] = ($_GET['by']=='') ? 'search' : $_GET['by'];
				if ($_GET['by'] == 'ids') {
					$arg['in_ID'] = explode(",",trim($_GET['src']));
				}
				if ($_GET['by'] == 'shopgroup') {
					$arg['shopgroup'] = trim($_GET['src']);
				}
				if ($_GET['by'] == 'cikkszam') {
					$cikkszamok = trim($_GET['src']);
					$arg['filters']['cikkszam'] = explode(",", $cikkszamok);
				}
				if ($_GET['by'] == 'search') {
					$arg['search_str'] = trim($_GET['src']);
					$search = explode(" ", trim($_GET['src']));
					if (!empty($search)) {
						$this->shop->logSearching($_GET['src']);
						$arg['search'] = $search;
						$this->out( 'searched_by', $search );
					}
				}
			}
			if ($_GET['src'] != '') {
				$termlist = $terms->prepareList( $arg )->getList(); 
				if (isset($_POST['modifyAllTerm']))
				{
					try {
						$back = $terms->groupProductChanger( $_POST, $terms->getLoadedIDS() );
						if ($back) {
							\Helper::reload();
						}
					} catch (\Exception $e) {
						$this->view->err 	= true;
						$this->view->bmsg	= Helper::makeAlertMsg('pError', $e->getMessage());
					}
				}

				$this->out( 'terms', $terms );
				$this->out( 'term_list', $termlist );
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
