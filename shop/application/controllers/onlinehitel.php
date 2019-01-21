<? 
class onlinehitel extends Controller
{
		function __construct(){	
			parent::__construct();
			parent::$pageTitle = 'Online hitel';
			
		}

		
		function __destruct(){
			// RENDER OUTPUT
				parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				parent::__destruct();				# FOOTER
		}
	}

?>