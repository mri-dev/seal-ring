<?
namespace Applications;

use PortalManager\Formater;

class Lookbooks 
{	
	private $db = null;
	function __construct( $arg = array() ) {
		$this->db = $arg[db];
	}

	public function add( $post )
	{
		unset($post['add']);

		if ( $post['nev'] == '' ) {
			throw new \Exception("Elnevezés megadása kötelező! Kérjük pótolja!");			
		}

		if ( $post['kulcs'] == '' ) {
			throw new \Exception("Elérési kulcs megadása kötelező! Kérjük pótolja!");			
		}

		$post['lathato'] = ($post['lathato'] == 'on') ? 1 : 0;

		$post['kulcs']  = Formater::makeSafeUrl($post['kulcs'] ,'');
		$post['kulcs']  = $this->checkEleres( $post['kulcs'] );


		$this->db->insert( 
			'lookbook',
			$post
		);
	}

	public function addContainers( $post )
	{
		$bookid = $post['book_id'];

		// Új gyűjtők beszúrása
		if( count( $post['new_container']) > 0 ) {
			foreach ( $post['new_container'] as $position => $cont ) {
				
				foreach ($cont as $c ) {
					$kepek = '';
					if( count($c['kepek']) > 0 )
					foreach ($c['kepek'] as $kep ) {
						if( $kep != '') {
							$kepek .= $kep.'||';
						}
					}
					$kepek = rtrim($kepek,'||');

					if ( $c['create'] ) {
					
						$this->db->insert( 'lookbook_gyujtok',
						array(
							'book_id' => $bookid,
							'pozicio' => $position,
							'sorrend' => $c['sorrend'],
							'kepek' => $kepek,
							'kep_leptetes_ido' => ($c['kep_leptetes_ido'] * 1000),
							'szoveg' => $c['szoveg']
						) ); 

						$cid = $this->lastInsertId();

						if ( count( $c['products']) > 0 ) {
							foreach ( $c['products'] as $pid ) {
								if( $pid != '' ) {
									$this->db->insert( 'lookbook_termekek', 
										array(
											'termek_id' => $pid,
											'gyujto_id' => $cid,
											'book_id' => $bookid
										));
								}
							}
						}

					}
				}

			}
		}

		// Meglévők szerkesztése
		if ( count( $post['container']) > 0 ) {
			foreach ( $post['container'] as $position => $cont ) {
				
				$i = 0; 
				foreach ($cont as $c ) {
					$i++;
					$kepek = '';


					// Termékek ellenőrzése
					$want_delete_product = array();

					if ( count($c['prev_products'] ) > 0 ) 
					foreach ( $c['prev_products'] as $pid ) {
						if( (is_array($c['products']) && !in_array( $pid , $c['products']) || empty($c['products'])) ){
							$want_delete_product[] = $pid;
						}
					}

					foreach ( $want_delete_product as $id ) {
						$this->db->query( $q = "DELETE FROM lookbook_termekek WHERE book_id = $bookid and gyujto_id = {$c['cont_id']} and termek_id = $id;" );
					}

					// Hozzáadottak bekapcsolása
					$editor = $post['new_container'][$position][$i];

					if ( $editor ) {
						if ( !$editor['create'] ) {
							// Képek
							if( count( $editor['kepek'] ) > 0)
								foreach ( $editor['kepek'] as $ekep ) {
									if( $ekep != '')
									$c['kepek'][] = $ekep;
								}

							// Termékek
							if( count( $editor['products'] ) > 0)
								foreach ( $editor['products'] as $ep ) {
									if( $ep != ''){
										$this->db->insert( 'lookbook_termekek', 
											array(
												'termek_id' => $ep,
												'gyujto_id' => $c['cont_id'],
												'book_id' 	=> $bookid
											));
									}
								}
						}
					}


					foreach ($c['kepek'] as $kep ) {
						if( $kep != '') {
							$kepek .= $kep.'||';
						}
					}
					$kepek = rtrim($kepek,'||');

					$this->db->update( 'lookbook_gyujtok',
					array(
						'sorrend' => $c['sorrend'],
						'kepek' => $kepek,
						'kep_leptetes_ido' => ($c['kep_leptetes_ido'] * 1000),
						'szoveg' => $c['szoveg']
					),
					sprintf("ID = %d", $c['cont_id'])); 


				}

			}
		}
	}

	public function removeContainer( $cont_id )
	{
		if ( !$cont_id ) {
			return false;
		}

		// Termék eltávolítás
		$this->db->query( "DELETE FROM lookbook_termekek WHERE gyujto_id = $cont_id;" );
		// Gyüjtő eltávolítás
		$this->db->query( "DELETE FROM lookbook_gyujtok WHERE ID = $cont_id;" );		
	}

	public function edit( $id, $post )
	{
		unset($post['edit']);

		if ( $post['nev'] == '' ) {
			throw new \Exception("Elnevezés megadása kötelező! Kérjük pótolja!");			
		}

		if ( $post['kulcs'] == '' ) {
			throw new \Exception("Elérési kulcs megadása kötelező! Kérjük pótolja!");			
		}

		$post['lathato'] = ($post['lathato'] == 'on') ? 1 : 0;

		/*$post['kulcs']  = Formater::makeSafeUrl($post['kulcs'] ,'');
		$post['kulcs']  = $this->checkEleres( $post['kulcs'] );
		*/

		$this->db->update( 
			'lookbook',
			$post,
			"ID = $id" 
		);
	}

	public function getAll( $arg = array() )
	{
		$q = "
		SELECT 			lb.*,
						( SELECT count(ID) FROM lookbook_gyujtok WHERE book_id = lb.ID ) as container_num
		FROM 			lookbook as lb
		WHERE 			lb.ID IS NOT NULL";

		if ( $arg['get' ]) {
			$q .= " and lb.ID = ". $arg['get'];
		}

		if ( $arg['get_by_key' ]) {
			$q .= " and lb.kulcs = '". $arg['get_by_key']."' ";
		}

		$q .= " ORDER BY lb.nev ASC ";
		$q .= ";";
		
		$arg['multi'] = 1;

		extract($this->db->q( $q, $arg ));

		$bdata = array();

		foreach ( $data as $d ) {
			$d['containers'] = $this->getContainers( $d['ID'] );
			$bdata[] = $d;
		}

		$ret['data'] = $bdata;

		return $ret;
	}

	public function getContainers( $book_id, $arg = array() )
	{
		$data = array();
		$return = array();

		if ( !$book_id ) {
			return $data;
		}

		$q = "
		SELECT 			c.*
		FROM 			lookbook_gyujtok as c
		WHERE 			c.ID IS NOT NULL and 
						c.book_id = ". $book_id;

		$q .= " ORDER BY c.sorrend ASC ";
		$q .= ";";
		$arg['multi'] = 1;
		extract($this->db->q( $q, $arg ));

		foreach ($data as $cont) {
			$kepek = array();
			$kepek = explode("||", rtrim($cont['kepek'],"||"));

			$cont['kepek'] = $kepek;
			$cont['products'] = $this->getContainerProducts( $cont['ID'] );

			$return[$cont['pozicio']][] = $cont;
		}

		return $return;
	}

	public function getContainerProducts( $container_id )
	{
		$q = "
		SELECT 			ct.ID, ct.termek_id,
						t.nev as termek_nev,
						t.cikkszam
		FROM 			lookbook_termekek as ct
		LEFT OUTER JOIN shop_termekek as t ON t.ID = ct.termek_id
		WHERE 			ct.ID IS NOT NULL and 
						ct.gyujto_id = ". $container_id;

		$q .= " ORDER BY ct.sorrend ASC, ct.ID ASC ";
		$q .= ";";
		$arg['multi'] = 1;
		extract($this->db->q( $q, $arg ));

		return $data;
	}

	public function delete( $id )
	{
		$this->db->query("DELETE FROM lookbook WHERE ID = $id;");
	}

	private function checkEleres( $text )
	{
		$text = Formater::makeSafeUrl($text,'');

		$qry = $this->db->query(sprintf("
			SELECT 		kulcs 
			FROM 		lookbook 
			WHERE 		kulcs = '%s' or 
						kulcs like '%s-_' or 
						kulcs like '%s-__' 
			ORDER BY 	kulcs DESC 
			LIMIT 		0,1", trim($text), trim($text), trim($text) ));
		$last_text = $qry->fetch(\PDO::FETCH_COLUMN);
		
		if( $qry->rowCount() > 0 ) {

			$last_int = (int)end(explode("-",$last_text));

			if( $last_int != 0 ){
				$last_text = str_replace('-'.$last_int, '-'.($last_int+1) , $last_text);
			} else {
				$last_text .= '-1';
			}			
		} else {
			$last_text = $text;
		}

		return $last_text;
	}


}
?>