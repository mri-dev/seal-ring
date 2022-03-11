<div class="cat-menu">
  <ul>
    <?php foreach ( $this->categories->tree  as $cat ) { ?>
    <li class="menu-item item<?=$cat['ID']?> deep<?=$cat['deep']?><?=($this->catid && $this->catid == $cat['ID'])?' active':''?>"><a href="<?=$cat['link']?>"><?=__(trim($cat['neve']))?></a><? if($cat['child']): ?><div class="toggler" toggle-menu="<?=$cat['ID']?>"></div><? endif; ?></li>
      <?php
      foreach ( (array)$cat['child'] as $cat2): $rowclass = 'row-'.$cat['ID'].'-'.$cat2['ID']; ?>
        <li class="menu-item item<?=$cat2['ID']?> <?=$rowclass?> deep<?=$cat2['deep']?> childof<?=$cat2['szulo_id']?>"><a href="<?=$cat2['link']?>"><?=__(trim($cat2['neve']))?></a><? if($cat2['child']): ?><div class="toggler" toggle-menu="<?=$cat2['ID']?>"></div><? endif; ?></li>
        <?php
        foreach ( (array)$cat2['child'] as $cat3): $rowclass = 'row-'.$cat['ID'].'-'.$cat2['ID'].'-'.$cat3['ID']; ?>
          <li class="menu-item item<?=$cat3['ID']?> <?=$rowclass?> deep<?=$cat3['deep']?> childof<?=$cat3['szulo_id']?>"><a href="<?=$cat3['link']?>"><?=__(trim($cat3['neve']))?></a><? if($cat3['child']): ?><div class="toggler" toggle-menu="<?=$cat3['ID']?>"></div><? endif; ?></li>
        <?php endforeach;  ?>
      <?php endforeach;  ?>
    <?php } ?>
  </ul>
</div>
