<?php
namespace ShopManager;
/**
 *
 */
class FelhasznalasiTeruletek extends Categories
{

  function __construct( $arg = array() )
  {
    parent::__construct( $arg );
    $this->table = 'shop_felhasznalasi_teruletek';
    return $this;
  }

  public function __destruct()
  {
    parent::__destruct();
  }
}
?>
