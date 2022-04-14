<?php
namespace ResourceImporter;

use ResourceImporter\ResourceImportInterface;

/** 
 *
 */
class ResourceImport extends ResourceImportBase implements ResourceImportInterface
{

  function __construct( $arg = array() )
  {
    return parent::__construct( $arg );
  }

  public function groupCat( $content = false )
  {
    $group = array();

   if ( count($content) == 0 ) {
     return false;
   }

   foreach ( (array)$content as $data ) {
     if (!in_array($data['CSOPORT'], $group[$data['FAJTA']])) {
       $group[$data['FAJTA']][] = $data['CSOPORT'];
     }
   }
   unset($content);
   return $group;
  }

  public function getFullItemData( $originid, $id )
  {
    $data = array();

    $q = "SELECT
      x.*,
      x.prod_id as sync_id
    FROM xml_temp_products as x WHERE 1=1 ";

    $q .= " and x.origin_id = ".$originid;
    $q .= " and x.ID = :prod_id ";

    $qry = $this->db->squery( $q, array(
      'prod_id' => $id
    ));

    $dat = $qry->fetch(\PDO::FETCH_ASSOC);

    $data = $dat;

    return $data;
  }

  public function prepareContext( $context = false )
  {
    $prepared = array();

    $prepared = $context;

    return $prepared;
  }

  public function __destruct()
  {
    parent::__destruct();
  }
}
