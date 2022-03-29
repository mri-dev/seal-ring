<?
use MailManager\Mailer;
use MailManager\MailTemplates;
use PortalManager\Template;

class test extends Controller
{
		function __construct(){
			parent::__construct();


			if ( isset($_GET['mailtest']))
			{
				$this->settings = $this->view->settings;
				$mail = new Mailer(
					$this->settings['page_title'],
					SMTP_USER,
					"smtp"
				);
				$mail->setReplyTo( $this->settings['page_title'], $this->settings['email_noreply_address'] );
				$mail->add( 'molnar.istvan@web-pro.hu' );

				$arg = array(
					'settings' 		=> $this->settings,
					'user_nev' 		=> $_GET['who'],
					'user_email' 	=> $_GET['send'],
					'user_jelszo' 	=> 'XXXXXX'
				);

				$arg['mailtemplate'] = (new MailTemplates(array('db'=>$this->db)))->get($_GET['template'], $arg);

				$mail->setSubject( 'Minta email' );
				$msg = (new Template( VIEW . 'templates/mail/' ))->get( $_GET['mailtest'], $arg );
				$mail->setMsg( $msg );

				if (isset($_GET['send'])) {
					$re = $mail->sendMail();

					print_r($re);
				}
			}
		}

    public function mt()
    {
      $re = $this->User->sendActivationEmail( 'mistvan2014@gmail.com', 'xtrame' );
      print_r($re);
    }

		function rtf()
		{
			require_once LIBS . 'RtfGroup.php';
			$file = $_SERVER['DOCUMENT_ROOT'].'/leiras.rtf';
			echo "READED FILE:<br> ".$file;
			$reader = new \RtfReader();
			$rtf = file_get_contents($file); // or use a string
			$result = $reader->Parse($rtf);
			$formatter = new RtfHtml('UTF-8');
			$converted = $formatter->Format($reader->root);

			echo "<br><br>RESULT:<br>".$converted;
		}

		function mailtemplate()
		{
			
			$arg = array(
				'settings' => $this->view->settings
			);
			//$template = (new Template( VIEW . 'templates/mail/' ))->get( 'user_password_reset', $arg );

			$template  = (new MailTemplates(array('db'=>$this->db)))->get('alert_register_user_adminaccept', $arg);

			echo $template;
		}

		function __destruct(){
			// RENDER OUTPUT
				//parent::bodyHead();					# HEADER
				$this->view->render(__CLASS__);		# CONTENT
				//parent::__destruct();				# FOOTER
		}
	}

?>
