<?
/*========================================
=            Teszt Controller            =
========================================*/

use PortalManager\Portal;
use PortalManager\Request;
use MailManager\Mailer;
use PortalManager\Template;

class test extends Controller{
	function __construct(){
		parent::__construct();
		parent::$pageTitle = 'Teszt';

	}

	function request () {
		$this->hidePatern = true;
		try {

			$url = 'http://casada.chr.hu/subscriber.php?g=77&f=a627f4887k';
			//$url = 'http://casada-shop-cp.mri-dev.com/test/post';
			$request = (new Request)->post( $url, array(
				// E-mail cím
				'subscr' 	=> 'pocokxtrame@gmail.com',
				// Név
				'f_943' 	=> 'MRIDEV',
				// Telefonszám
				'f_944' 	=> '706666666',
				// Cím
				'f_945' 	=> '666 Pokol, Pokol tornáca 666., 6-os barlang',
				'sub' 		=> 'Feliratkozás'
			) )
			->setDebug( true )
			->send();


			$result = $request->decodeJSON( $request->getResult() );

			echo $request->getResult();

			echo '<pre>';
				print_r($result);
			echo '</pre>';
		} catch( \Exception $e ) {
			echo $e->getMessage();
		}
	}

	public function mail()
	{
		$mail = new Mailer( $this->db->settings['page_title'], 'no-reply@sealring.hu', $this->db->settings['mail_sender_mode'] );
		$mail->add( 'mistvan2014@gmail.com' );

		$arg = array(
			'settings' => $this->db->settings
		);

		$mail->setSubject( 'Teszt' );
		$mail->setMsg( (new Template( VIEW . 'templates/mail/' ))->get( 'clearmail', $arg ) );
		$re = $mail->sendMail(array('debug' => 3));
		print_r($re);
	}

	function post() {
		$this->hidePatern = true;

		print_r($_POST);
	}

	function __destruct(){
		// RENDER OUTPUT
			parent::bodyHead();					# HEADER
			$this->view->render(__CLASS__);		# CONTENT
			parent::__destruct();				# FOOTER
	}
}

?>
