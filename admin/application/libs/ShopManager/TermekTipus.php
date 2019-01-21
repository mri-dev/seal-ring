<?php
namespace ShopManager;

use Interfaces\CategoryInterface;

class TermekTipus extends Category implements CategoryInterface
{
  function __construct( $category_id, $arg = array() )
  {
    $this->table = 'shop_termek_tipusok';
    parent::__construct( $category_id, $arg );    
    return $this;
  }

  public function __destruct()
  {
    parent::__destruct();
  }
}
?>
