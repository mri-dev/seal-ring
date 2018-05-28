<?php

class tudastar extends Controller{
		function __construct(){
			parent::__construct();
			parent::$pageTitle = 'Tudástár';

			$this->out('bodyclass', 'fixwidth');

			// SEO Információk
			$SEO = null;
			// Site info
			$SEO .= $this->view->addMeta('description', 'Tudástárunkban megtalálhat minden olyan információt, amire szüksége lehet termékeinkkel kapcsolatban. Fontos tippekkel és tanácsokkal látjuk el.');
			$SEO .= $this->view->addMeta('keywords','tudastar, információk, leírások, dokumentumok, oktatás, tűzvédelem');
			$SEO .= $this->view->addMeta('revisit-after','3 days');

			// FB info
			$SEO .= $this->view->addOG('title', parent::$pageTitle);
			$SEO .= $this->view->addOG('description', 'Tudástárunkban megtalálhat minden olyan információt, amire szüksége lehet termékeinkkel kapcsolatban. Fontos tippekkel és tanácsokkal látjuk el.');
			$SEO .= $this->view->addOG('type','article');
			$SEO .= $this->view->addOG('url', CURRENT_URI );
			$SEO .= $this->view->addOG('image', $this->view->settings['domain'].'/admin'.$this->view->settings['logo']);
			$SEO .= $this->view->addOG('site_name', $this->view->settings['page_title']);
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
