<?php
use ShopManager\OrderException;
use Applications\PayU;
use Applications\Simple;
use PortalManager\PartnerReferrer;
use PortalManager\Coupon;

class kosar extends Controller{

		private $preorder_index	= 'cart_preorder';
		private $preorder_flag 	= false;

		function __construct(){
			parent::__construct();
			$title = 'Kosár';

			$ckosar	= $this->shop->cartInfo(Helper::getMachineID(), $arg);

			/* * s/
			echo '<pre>';
			print_r($ckosar);
			echo '</pre>';
			/* */

			// Kosar üritése
			if( $_GET['clear'] == '1' )
			{
				$this->shop->clearCart(Helper::getMachineID());
				Helper::reload('/'.__CLASS__);
			}

			// Partner kód mentése
			if( Post::on('save_partner_code') ) {
				setcookie( 'partner_code', $_POST['partner_code'], time() + 3600 * 48, '/'.__CLASS__ );
				setcookie( 'coupon_code', null, time() - 3600, '/'.__CLASS__ );
				setcookie( '__order_step_1poststr', null, time() - 3600, '/' );
				Helper::reload('/'.__CLASS__);
			}

			// Partner kód mentése
			if( Post::on('save_coupon_code') ) {
				setcookie( 'coupon_code', $_POST['coupon_code'], time() + 3600 * 48, '/'.__CLASS__ );
				setcookie( 'partner_code', null, time() - 3600, '/'.__CLASS__ );
				setcookie( '__order_step_1poststr', null, time() - 3600, '/' );
				Helper::reload('/'.__CLASS__);
			}

			if( Post::on('save_vr_cash') ) {
				if ( $_POST['virtual_cash'] > $ckosar['totalPrice'] ) {
					$_POST['virtual_cash'] = $ckosar['totalPrice'];
				}
				setcookie( 'coupon_code', null, time() - 3600, '/'.__CLASS__ );
				setcookie( 'partner_code', null, time() - 3600, '/'.__CLASS__ );
				setcookie( '__order_step_1poststr', json_encode($_POST, JSON_UNESCAPED_UNICODE), time() + 3600 * 48, '/' );
				Helper::reload('/'.__CLASS__);
			}

			/* * /
			$this->ppp = $this->model->openLib('PickPackPont',array(
				'database' => $this->model->db
			));

			$this->view->ppp->data 		= $this->ppp->getList();
			$this->view->ppp->megyek 	= $this->ppp->getAreas($this->view->ppp->data);
			/* */

			$this->view->canOrder = true;
			$arg = array();

			if (!$this->view->user) {
				$this->view->canOrder = false;
			}

			if (!$this->view->user && $this->gets['1'] == 1 ) {
				Helper::reload('/'.__CLASS__);
			}
			/**
			* Partner kód ellenőrzés
			* */
			/* * /
			$partner_ref = (new PartnerReferrer ( $_COOKIE['partner_code'], array(
				'db' 		=> $this->db,
				'settings' 	=> $this->view->settings
			)))
			->setExcludedUser( $this->view->user['data']['ID'] )
			->setMustloggedin()
			->setMe($this->view->user)
			->load();


			if( $partner_ref->isValid() ) {
				$arg['referer_discount'] = true;
			}

			$this->out( 'partner_referer', $partner_ref );
			/* */

			/**
			 * Kupon kód ellenőrzése
			 * */
			$coupon = (new Coupon(array( 'db' => $this->db )))
				->setOrderTotal($ckosar['totalPrice'])
				->setExcludedUser($this->view->user['data']['ID'])
				->get($_COOKIE['coupon_code']);

			$this->out( 'coupon', $coupon );

			if( $coupon->isRunning() )
			{
				$arg['coupon'] = $coupon;
			}

			$this->view->kosar = $this->shop->cartInfo(Helper::getMachineID(), $arg);

			//$this->view->ppp->data 		= $this->ppp->getPointData($this->view->storedString['2']['ppp_uzlet']);

			$min_price_order = $this->view->settings['order_min_price'];
			if( $this->view->kosar['totalPrice'] < $min_price_order ) {
				$this->view->canOrder = false;
				$this->view->not_reached_min_price_text = 'Minimális vásárlási érték <strong>'.Helper::cashFormat($min_price_order).' Ft</strong>! A kosarában található termékek összesített értéke nem haladja meg ezt az értéket!';
			}

			// PostaPont szállítás esetén, ha nincs kiválasztva a PP, akkor nem lehet megrendelni
			/*if($this->view->storedString['2']['atvetel'] == '5' && $this->view->storedString['2']['pp_selected'] == ''){
				$this->view->canOrder = false;
			}*/

			if(Post::on('orderState'))
			{
				/**
				* Virtuálos egyenleg felhasználás
				* */
				// Ha a beírt cash nagyobb mint a rendelkezésre álló
				if ( $_POST['virtual_cash'] > $this->view->user['data']['cash']  )
				{
					$_POST['virtual_cash'] = $this->view->user['data']['cash'];
				}

				// Ha a beírt cash nagyobb, mint a kosár összértéke
				if ( $_POST['virtual_cash'] > $this->view->kosar['totalPrice'] )
				{
					$_POST['virtual_cash'] = $this->view->kosar['totalPrice'];
				}

				// Kupon és partnerkód eltávolítása
				if ( isset($_POST['virtual_cash']) && $_POST['virtual_cash'] > 0 )
				{
					setcookie("coupon_code", 	null, time()-3600, "/".__CLASS__);
					setcookie("partner_code", 	null, time()-3600, "/".__CLASS__);
				}

				try{
					$step = $this->shop->doOrderV2($_POST, array( 'user' => $this->view->user ));
					if ($step == 2) {
						Helper::reload('/'.__CLASS__.'/done/'.$_COOKIE['lastOrderedKey']);
					} else {
						Helper::reload('/'.__CLASS__.'/'.$step.'#step');
					}
				}catch(OrderException $e){
					$this->view->orderExc = $e->getErrorData();
					$this->out( 'msg', \Helper::makeAlertMsg('pError', $this->view->orderExc['msg']) );
				}
			}

			// SEO Információk
			$SEO = null;
			// Site info
			$SEO .= $this->view->addMeta('description', $this->view->settings['page_description']);
			$SEO .= $this->view->addMeta('keywords','ajánló rendszer kód kedvezmény vásárlás ingyen');
			$SEO .= $this->view->addMeta('revisit-after','3 days');

			// FB info
			$SEO .= $this->view->addOG('type','website');
			$SEO .= $this->view->addOG('url', CURRENT_URI );
			$SEO .= $this->view->addOG('image', $this->view->settings['domain'].'/admin'.$this->view->settings['logo']);
			$SEO .= $this->view->addOG('site_name', $this->view->settings['page_title']);
			$SEO .= '<link rel="canonical" href="'.$this->view->settings['domain'].'" />'."\n\r";
			$this->view->SEOSERVICE = $SEO;


			parent::$pageTitle = $title;
		}

		function done(){
			$this->view->accessKey 		= $this->view->gets['2'];
			$this->view->orderAllapot 	= $this->shop->getMegrendelesAllapotok();
			$this->view->szallitas 		= $this->shop->getSzallitasiModok();
			$this->view->fizetes 		= $this->shop->getFizetesiModok();

			$this->view->orderInfo 		= $this->shop->getOrderData($this->view->accessKey);
			$this->view->order_user 	= $this->User->get( array( 'user' => $this->view->orderInfo['email'] ) );


			/** PAYU FIZETÉS */
			$order_id = $this->view->orderInfo['azonosito'];

			if( $order_id == '' ){
				Helper::reload( '/user' );
			}

			$this->view->orderInfo['szallitas_adat'] 		= json_decode($this->view->orderInfo['szallitasi_keys'], true);
			$this->view->orderInfo['szamlazas_adat'] 		= json_decode($this->view->orderInfo['szamlazasi_keys'], true);

			$this->payu = (new Simple())
				->setMerchant( 	'HUF', 	$this->view->settings['payu_merchant'])
				->setSecretKey( 'HUF',	$this->view->settings['payu_secret'] )
				->setCurrency( 	'HUF' )
				->setOrderId( $order_id )
				->setData( $this->view->orderInfo );

			if ( $this->view->orderInfo['szallitasi_koltseg'] > 0 ) {
				$this->payu->setTransportPrice( $this->view->orderInfo['szallitasi_koltseg'] );
			}

			$discount = $this->view->orderInfo['kedvezmeny'];
			if ( !empty($this->view->orderInfo['items']) ) {
				$total_ar = 0;
				foreach ($this->view->orderInfo['items'] as $ai ) {
					$total_Ar += $ai['subAr'];
				}
			}

			if($discount > 0) {
				$this->payu->setDiscount($discount);
			}

			$this->payu->prepare();

			$this->out( 'payu_btn', $this->payu->getPayButton() );
		}

		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>
