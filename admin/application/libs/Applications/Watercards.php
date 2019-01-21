<?
namespace Applications;

use DatabaseManager\Database;
use PortalManager\Formater;
use PortalManager\Template;
use MailManager\Mailer;

class Watercards
{	
	private $db = null;
	function __construct( $arg = array()) {
		$this->db = $arg[db];
		$this->settings = $arg[view]->settings;
	}

	public function getAll( $arg = array() )
	{
		$q = "
		SELECT 			wc.*,
						wc.felh_id as uid,
						u.nev as neve,
						u.email
		FROM 			arena_water_card as wc
		LEFT OUTER JOIN felhasznalok as u ON u.ID = wc.felh_id
		WHERE 			wc.ID IS NOT NULL";

			// FILTERS
		if(count($arg['filters']) > 0){
			foreach($arg['filters'] as $key => $v){
				switch($key)
				{
					case 'ID':
						if( is_array($v) ) {
							$value_set = false;

							if( count($v) > 0 ) {
								$value_set = implode(',', $v);
							}

							if($value_set){
								$q .= " and wc.".$key." IN (".$value_set.") ";
							}
						} else {
							$q .= " and wc.".$key." LIKE '".$v."%' ";

						}

					break;
					case 'uid':
						$q .= " and wc.felh_id = '".$v."' ";
					break;
					case 'nev': case 'email':
						$q .= " and u.".$key." LIKE '%".$v."%' ";
					break;
					case 'egyesulet':
						$q .= " and wc.".$key." LIKE '%".$v."%' ";
					break;
					case 'aktivalva':
						if ( $v == 1 ) {
							$q .= " and wc.".$key." IS NOT NULL ";
						} else if( $v == 0) {
							$q .= " and wc.".$key." IS NULL ";
						}
						
					break;
					default: 
						if( is_array($v) ) {
							$value_set = false;

							if( count($v) > 0 ) {
								$value_set = implode(',', $v);
							}

							if($value_set){
								$q .= " and wc.".$key." IN (".$value_set.") ";
							}
						} else {
							$q .= " and wc.".$key." = '".trim($v)."' ";
						}	
						
					break;	
				}
				
			}	
		}
		

		$q .= " ORDER BY wc.aktivalva ASC ";
		$q .= ";";

		//echo $q;
		
		$arg['multi'] = 1;

		extract($this->db->q( $q, $arg ));

		$bdata = array();

		foreach ( $data as $d ) {
			$bdata[] = $d;
		}

		$ret['data'] = $bdata;

		return $ret;
	}

	public function delete( $ID )
	{
		if ( !$ID ) {
			return false;
		}
		
		$del = "DELETE FROM arena_water_card WHERE ID = $ID;";

		$this->db->query($del);
	}

	public function activate( $ID )
	{
		if ( !$ID ) {
			return false;
		}

		$check = $this->db->query("
			SELECT 			a.*,
							f.nev as neve
			FROM 			arena_water_card as a 
			LEFT OUTER JOIN felhasznalok as f ON f.ID = a.felh_id
			WHERE 			a.ID = ".$ID
		);

		if ( $check->rowCount() == 0 ) {
			return false;
		}

		$data = $check->fetch(\PDO::FETCH_ASSOC);

		if ( !is_null($data['aktivalva']) ) {
			return false;
		}

		// Aktiválás
		$this->db->update(
			'arena_water_card',
			array(
				'aktivalva' => NOW
			),
			"ID =". $ID
		);

		$this->db->update(
			'felhasznalok',
			array(
				'arena_water_card' => 1
			),
			"ID = ".$data['felh_id']
		);

		// E-mail értesítés kiküldése
		$mail = new Mailer( $this->settings['page_title'], $this->settings['email_noreply_address'], $this->settings['mail_sender_mode'] );
		$mail->add( $data['email'] );	
		$arg = array(
			'settings' 		=> $this->settings,
			'infoMsg' 		=> 'Ezt az üzenetet a rendszer küldte. Kérjük, hogy ne válaszoljon rá!',
			'data' 			=> $data
		);
		$mail->setSubject( 'Aktiválva: A jövő bajnokainak / Arena Water Card kártyája' );
		$mail->setMsg( (new Template( VIEW . 'templates/mail/' ))->get( 'user_register_arena_water_card_activate', $arg ) );			
		$re = $mail->sendMail();
		
	}

	public function deactivate( $ID )
	{
		if ( !$ID ) {
			return false;
		}

		$check = $this->db->query("
			SELECT aktivalva, email, felh_id FROM arena_water_card WHERE ID = ".$ID);

		if ( $check->rowCount() == 0 ) {
			return false;
		}

		$data = $check->fetch(\PDO::FETCH_ASSOC);

		if ( is_null($data['aktivalva']) ) {
			return false;
		}

		// Deaktiválás
		$this->db->update(
			'arena_water_card',
			array(
				'aktivalva' => NULL
			),
			"ID =" . $ID
		);
		
		$this->db->update(
			'felhasznalok',
			array(
				'arena_water_card' => NULL
			),
			"ID = ".$data['felh_id']
		);

	}

	public function __destruct()
	{
		$this->db = null;
	}

}
?>