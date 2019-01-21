<?php
namespace ShopManager;

use Interfaces\CategoryInterface;

class FelhasznalasiTerulet extends Category implements CategoryInterface
{
  function __construct( $category_id, $arg = array() )
  {
    $this->table = 'shop_felhasznalasi_teruletek';
    parent::__construct( $category_id, $arg );
    return $this;
  }

  public function __destruct()
  {
    parent::__destruct();
  }
}
?>
