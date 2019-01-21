<li class="head"><?=$this->creative->getName()?></li>
<li class="<?=($_GET[v] == 'creative' && !$_GET[p])?'on':''?>"><a href="/popup/?v=creative&c=<?=$this->creative->getID()?>">Beállítások</a></li>
<li class="<?=($_GET[v] == 'creative' && $_GET[p] == 'screen_new')?'on':''?>"><a href="/popup/?v=creative&p=screen_new&c=<?=$this->creative->getID()?>">Új megjelenés</a></li>