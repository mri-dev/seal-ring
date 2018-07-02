<?php
namespace ShopManager;
/**
 *
 */
class TermekTipusok extends Categories
{

  function __construct( $arg = array() )
  {
    parent::__construct( $arg );
    $this->table = 'shop_termek_tipusok';
    return $this;
  }

  public function __destruct()
  {
    parent::__destruct();
  }
}
?>
