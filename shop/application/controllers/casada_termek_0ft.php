<?php 
use PortalManager\PartnerReferrer;

class casada_termek_0ft extends Controller 
{
	function __construct(){	
		parent::__construct();
		parent::$pageTitle = 'Casada Ajánló Rendszer &mdash; Casada termékek akár 0 Ft-ért!';

		$desc = "Ismerősei az Ön ajánló partnerkódjával kedvezményesen vásárolhatják meg termékeinket weboldalunkon keresztül.";

		$referer = new PartnerReferrer( $_GET['partner'], array('db' => $this->db, 'settings' => $this->view->settings));
		$referer->load();
		$this->out( 'referer', $referer);

		if (isset($_GET['partner'])) 
		{
			parent::$pageTitle = 'Ezt használd! Az én kupon kódommal most sokkal olcsóbban vásárolhatsz!';
			$desc = "Ráadásul ha Te is megosztod a saját kódodat akár ingyen juthatsz hozzá Casada termékhez és ismerőseid sokkal olcsóbban vásárolhatnak!";
		}
		
		// SEO Információk
		$SEO = null;
		// Site info
		$SEO .= $this->view->addMeta('description', $desc);
		$SEO .= $this->view->addMeta('keywords','ajánló rendszer kód kedvezmény vásárlás ingyen');
		$SEO .= $this->view->addMeta('revisit-after','3 days');
		
		// FB info
		$SEO .= $this->view->addOG('type','website');
		$SEO .= $this->view->addOG('url', CURRENT_URI );
		$SEO .= $this->view->addOG('image',substr(IMG,0).'casada_og_ajanlorendszer.jpg');
		$SEO .= $this->view->addOG('site_name',$this->view->settings['page_title']);
		
		$this->view->SEOSERVICE = $SEO;
	}
	
	function __destruct(){
		// RENDER OUTPUT
			parent::bodyHead();					# HEADER
			$this->view->render(__CLASS__);		# CONTENT
			parent::__destruct();				# FOOTER
	}
}