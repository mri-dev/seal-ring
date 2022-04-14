<?
use PopupManager\Creatives;
use PopupManager\Creative;
use PopupManager\CreativeScreens;
use PopupManager\CreativeScreen;

class popup extends Controller
{
		function __construct(){
			parent::__construct();
			parent::$pageTitle = 'Felugróablak kezelő / Adminisztráció';

			$this->view->adm = $this->AdminUser;
			$this->view->adm->logged = $this->AdminUser->isLogged();

			define('PILOT_ANGULAR_CALL', true);


			switch ($_GET['v'])
			{
				case 'creative_create':

					// Kreatív adatok
					$creative = new Creatives(array('db' => $this->db));

					// Creative létrehozás
					if (Post::on('createCreative'))
					{
						try
						{
							unset($_POST['createCreative']);
							$id = $creative->create($_POST);
							Helper::reload('/popup/');
						}
						catch ( Exception $e )
						{
							$this->view->err	= true;
							$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}


				break;

				case 'creative':
					// Kreatív adatok
					$creative = (new Creative(array('db' => $this->db)))->load($_GET['c']);
					$this->out('creative',$creative);

					// Kreatív screen-ek
					$screens = new CreativeScreens($creative->getID(), array('db' => $this->db));
					$this->out('screens',$screens);

					// Kreatív másolása
					if ($_GET['a'] == 'copy') {
						$creative->copy();
						Helper::reload('/popup');
					}

					// Creative törlése
					if (Post::on('deleteCreative'))
					{
						try
						{
							$creative->delete();
							Helper::reload('/popup/');
						}
						catch ( Exception $e )
						{
							$this->view->err	= true;
							$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}

					// Screen létrehozás
					if (Post::on('createScreen'))
					{
						try
						{
							unset($_POST['createScreen']);
							$id = $screens->create($_POST);
							Helper::reload('/popup/?v=screen&s='.$id);
						}
						catch ( Exception $e )
						{
							$this->view->err	= true;
							$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}


					// Creative változások mentése
					if (Post::on('saveCreative'))
					{
						// Kreatív adatok
						$creative = new Creatives(array('db' => $this->db));

						try
						{
							unset($_POST['saveCreative']);
							$id = $creative->save($_GET['c'], $_POST);
							Helper::reload();
						}
						catch ( Exception $e )
						{
							$this->view->err	= true;
							$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}
				break;

				case 'screen':
					// Screen adatok
					$screen = (new CreativeScreen(array('db' => $this->db)))->load($_GET['s']);
					$this->out('screen',$screen);

					// Kreatív adatok
					$creative = (new Creative(array('db' => $this->db)))->load($screen->getCreativeID());
					$this->out('creative',$creative);


					// Screen törlése
					if (Post::on('deleteScreen'))
					{
						try
						{
							$screen->delete();
							Helper::reload('/popup/?v=creative&c='.$screen->getCreativeID());
						}
						catch ( Exception $e )
						{
							$this->view->err	= true;
							$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}

					// Screen másolása
					if ($_GET['a'] == 'copy')
					{
						try
						{
							$screen->copy();
							Helper::reload('/popup/?v=creative&c='.$screen->getCreativeID());
						}
						catch ( Exception $e )
						{
							$this->view->err	= true;
							$this->view->msg	= Helper::makeAlertMsg('pError', $e->getMessage());
						}
					}

					// Screen alapadatok módosítása
					if (Post::on('saveScreenSettings'))
					{
						unset($_POST['saveScreenSettings']);
						$screen->saveSettings($_POST);
						Helper::reload();
					}
				break;

				default:
					$creatives = new Creatives(array('db' => $this->db));
					$this->out('creatives',$creatives);
				break;
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
