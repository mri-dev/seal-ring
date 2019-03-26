<?php
use Applications\CSVParser;
class felhasznalok extends Controller{
		function __construct(){
			parent::__construct( array( 'admin' => true ));
			parent::$pageTitle = 'Felhasználók';

			if(Post::on('filterList')){
				$filtered = false;

				if($_POST[ID] != ''){
					setcookie('filter_ID',$_POST[ID],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_ID','',time()-100,'/'.$this->view->gets[0]);
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
				if($_POST[engedelyezve] != ''){
					setcookie('filter_engedelyezve',$_POST[engedelyezve],time()+60*24,'/'.$this->view->gets[0]);
					$filtered = true;
				}else{
					setcookie('filter_engedelyezve','',time()-100,'/'.$this->view->gets[0]);
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
				Helper::reload();
			}

			$arg = array();
			$arg[limit] = 50;
			$filters = Helper::getCookieFilter('filter',array('filtered'));

			if( isset($_GET['ID']) ) {
				$filters['ID'] = $_GET['ID'];
			}

			//$filters['user_group'] = 'user';

			$arg[filters] = $filters;

			$this->view->users = $this->User->getUserList($arg);

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

		function containers()
		{
			// Felhasználó törlése a konténerből
			if( isset($_GET[t])  )
			{
				try
				{
					$this->User->deleteUserFromContainer( $_GET['uid'], $_GET['cid'] );
					Helper::reload( '/felhasznalok/containers/?s='.$_GET['cid']  );
				}
				catch( \Exception $e )
				{
					$this->view->msg = Helper::makeAlertMsg( 'pError', $e->getMessage() );
				}
			}

			// Új felhasználó hozzáadása egy konténerhez
			if( Post::on('container') )
			{
				try
				{
					$this->User->addUserToContainer( $_POST['user_id'], $_POST['container'] );
					Helper::reload( '/felhasznalok/containers/?s='.$_POST['container']  );
				}
				catch( \Exception $e )
				{
					$this->view->msg = Helper::makeAlertMsg( 'pError', $e->getMessage() );
				}
			}

			$this->out('containers', $this->User->getContainers());
		}

		function container_edit()
		{

			if( Post::on('saveContainer') )
			{
				try
				{
					$id = $_POST['saveContainer'];
					unset($_POST['saveContainer']);

					$this->User->saveContainer( $id, $_POST);
					Helper::reload();
				}
				catch( \Exception $e )
				{
					$this->view->msg = Helper::makeAlertMsg( 'pError', $e->getMessage() );
				}
			}
			$this->out('container', $this->User->getContainer($this->gets[2]));
		}

		function container_del()
		{

			if( Post::on('delContainer') )
			{
				try
				{
					$id = $_POST['delContainer'];

					$this->User->delContainer( $id );
					Helper::reload('/felhasznalok/containers/');
				}
				catch( \Exception $e )
				{
					$this->view->msg = Helper::makeAlertMsg( 'pError', $e->getMessage() );
				}
			}
			$this->out('container', $this->User->getContainer($this->gets[2]));
		}

		function container_new()
		{

			if( Post::on('addContainer') )
			{
				try
				{
					unset($_POST['addContainer']);

					$this->User->addContainer( $_POST );
					Helper::reload('/felhasznalok/containers/');
				}
				catch( \Exception $e )
				{
					$this->view->msg = Helper::makeAlertMsg( 'pError', $e->getMessage() );
				}
			}
			$this->out('container', $this->User->getContainer($this->gets[2]));
		}

		public function import()
		{
			$csv = new CSVParser('/home/webprohu/seal-ring.web-pro.hu/admin/src/json/users.csv');
			$csv = $csv->getResult();

			// Pricegroup
			$pg = array();
			try {
				$pgg = $this->db->query("SELECT * FROM shop_price_groups")->fetchAll(\PDO::FETCH_ASSOC);
			} catch (\Exception $e) {

			}

			foreach ((array)$pgg as $p) {
				$pg[$p['groupkey']] = $p['ID'];
			}

			$insert_row = array();
			foreach ((array)$csv as $k => $v) {
				$price_group = 'ar1';
				$user_group = 'user';

				if ($v['Kategoria'] != 'kisker') {
					$user_group = 'company';
				}

				if (
					$v['Kategoria'] == 'kisker'
				) {
					$price_group = $pg['ar1'];
				} else {
					$price_group = $pg[trim($v['Kategoria'])];
				}

				// Telephelyek
				if (
					$v['Kategoria'] == 'ar0'
				) {
					$price_group = $pg['beszerzes_netto'];
				}



				$insert_row[] = array(
					'ID' => (int)$v['Ugyfelkod'],
					'email' => trim($v['e-mail']),
					'username' => trim($v['User name']),
					'nev' => trim($v['Partner neve']),
					'jelszo' => \Hash::jelszo(trim($v['Password'])),
					'engedelyezve' => 1,
					'aktivalva' => NOW,
					'regisztralt' => NOW,
					'old_user' => 1,
					'user_group' => $user_group,
					'price_group' => $price_group
				);
			}

			/*
			echo '<pre>';
			print_r($insert_row);*/

			if (!empty($insert_row) && false) {
				$debug = false;
				$dbx = $this->db->multi_insert_v2(
					'felhasznalok',
					array(
						'ID', 'email', 'username', 'nev', 'jelszo', 'engedelyezve', 'aktivalva', 'regisztralt', 'old_user', 'user_group', 'price_group'
					),
					$insert_row,
					array(
						'debug' => $debug,
						'duplicate_keys' => array('ID', 'email', 'nev')
					)
				);
				if ($debug) {
					echo $dbx;
				}
			}
			//echo '--->'; $this->memo();
			unset($insert_row);

		}

		function clearfilters(){
			setcookie('filter_ID','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_nev','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_email','',time()-100,'/'.$this->view->gets[0]);
			setcookie('filter_engedelyezve','',time()-100,'/'.$this->view->gets[0]);
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
