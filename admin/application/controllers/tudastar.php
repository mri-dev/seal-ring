<?php

use PortalManager\Helpdesk;

class tudastar extends Controller{
	function __construct(){
		parent::__construct();
		parent::$pageTitle = 'Tudástár';

		$this->view->adm = $this->AdminUser;
		$this->view->adm->logged = $this->AdminUser->isLogged();

		$helpdesk = new Helpdesk(array('db' => $this->db));

		if (isset($_GET['msg'])) {
			$this->out('rmsg', Helper::makeAlertMsg('p'.$_GET['type'], $_GET['msg']));
		}

		if(Post::on('filterList')){
			$filtered = false;

			if($_POST['filter_search'] != ''){
				setcookie('filter_search',$_POST['filter_search'],time()+60*24,'/'.$this->view->gets[0]);
				$filtered = true;
			}else{
				setcookie('filter_search','',time()-100,'/'.$this->view->gets[0]);
			}

			if($_POST['filter_temakor'] != ''){
				setcookie('filter_temakor',$_POST['filter_temakor'], time()+60*24,'/'.$this->view->gets[0]);
				$filtered = true;
			}else{
				setcookie('filter_temakor','',time()-100,'/'.$this->view->gets[0]);
			}

			if($filtered){
				setcookie('filtered','1',time()+60*24*7,'/'.$this->view->gets[0]);
			}else{
				setcookie('filtered','',time()-100,'/'.$this->view->gets[0]);
			}
			Helper::reload('/tudastar/');
		}

		$filters = Helper::getCookieFilter('filter',array('filtered'));

		// Témakör Modifier
		if ( \Post::on('categoryModifier') )
		{
			try {
				$re = $helpdesk->categoryModifier( $_POST['categoryModifier'], $_POST );
				\Helper::reload('/tudastar/?type=Success&msg='.$re);
			} catch (\Exception $e) {
				$this->out('err', true);
				$this->out('rmsg', Helper::makeAlertMsg('pError', $e->getMessage()));
			}
		}

		// Cikk Modifier
		if ( \Post::on('articleModifier') )
		{
			try {
				$re = $helpdesk->articleModifier( $_POST['articleModifier'], $_POST );
				\Helper::reload('/tudastar/?type=Success&msg='.$re);
			} catch (\Exception $e) {
				$this->out('err', true);
				$this->out('rmsg', Helper::makeAlertMsg('pError', $e->getMessage()));
			}
		}

		// Kategória lista
		$categories = $helpdesk->getCategories();
		// Kategória csoportosítás ID alapján
		$catgroup = array();
		foreach ($categories['data'] as $cat) {
			$catgroup[$cat['ID']] = $cat;
		}
		$this->out( 'catgroup', $catgroup );

		// Cikkek Lista
		$cat_id = (isset($filters['temakor'])) ? (int)$filters['temakor'] : false;
		$artarg = array();
		if ( isset($filters['search']) && !empty($filters['search']) ) {
			$artarg['search'] = $filters['search'];
		}

		$articles = $helpdesk->getArticles( $cat_id, $artarg );

		// Kateógira adat betöltése, ha szükség van rá
		if ( $_GET['del'] == 'category' || $_GET['edit'] == 'category' ) {
			$edit_cat_data = $helpdesk->getCategoryData( $_GET['id'] );
			$this->out( 'c', $edit_cat_data );
		}

		// Cikk adat betöltése, ha szükség van rá
		if ( $_GET['del'] == 'article' || $_GET['edit'] == 'article' ) {
			$edit_article_data = $helpdesk->getArticleData( $_GET['id'] );
			$this->out( 'c', $edit_article_data );
		}

		// Kategória lista view
		$this->out( 'cats', $categories );

		// Cikekk lista view
		$this->out( 'articles', $articles );

	}

	function clearfilters()
	{
		setcookie('filter_search','',time()-100,'/'.$this->view->gets[0]);
		setcookie('filter_temakor','',time()-100,'/'.$this->view->gets[0]);
		setcookie('filtered','',time()-100,'/'.$this->view->gets[0]);
		Helper::reload('/tudastar/');
	}

  function __destruct(){
    // RENDER OUTPUT
      parent::bodyHead();					# HEADER
      $this->view->render(__CLASS__);		# CONTENT
      parent::__destruct();				# FOOTER
  }
}

?>
