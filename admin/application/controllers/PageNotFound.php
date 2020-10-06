<?	class PageNotFound extends Controller{
		function __construct(){
			parent::__construct();
			parent::$pageTitle = 'Az oldal nem található!';
			 
		}
		
		
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}
?>