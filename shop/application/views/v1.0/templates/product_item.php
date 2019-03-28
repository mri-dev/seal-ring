<div class="item">
  <?php
    $wo_price = (empty($ar) || $ar == '0') ? true : false;
    if( $akcios == '1' ) $ar = $akcios_fogy_ar;
  ?>
  <div class="wrapper">
    <div class="image">
      <div class="data-board">
        <div class="wrapper">
          <div class="ujdonsag">
            <?php if ( $ujdonsag == '1' ): ?>
            <div class="ujdonsag-label">ÚJ</div>
            <?php endif; ?>
          </div>
          <?php
          ?>
          <div class="factory"><div class="marka" style="background-color: <?=$marka_szin?>; color: <?=$marka_tszin?>;"><?php if($marka_img == ''){ echo $marka_nev; }else{ echo '<img src="'.IMGDOMAIN.$marka_img.'" alt="'.$marka_nev.'"/>'; } ?></div></div>
          <div class="discount">
            <?php if ( $akcios == '1' ): ?>
            <div class="discount-label">
              <div class="p">-<? echo 100-round($akcios_fogy_ar / ($brutto_ar / 100)); ?>%</div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
			<a href="<?=$link?>"><img title="<?=$product_nev?>" src="<?=$profil_kep?>" alt="<?=$product_nev?>"></a>
      <?php if ($rovid_leiras): ?>
      <div class="short-desc">
        <?php echo $rovid_leiras; ?>
      </div>
      <?php endif; ?>
		</div>
    <div class="title">
      <h3><a title="<?=$product_nev?>" href="<?=$link?>"><?=$product_nev?></a></h3>
      <div class="subtitle"><?=__($csoport_kategoria)?></div>
    </div>
    <?php if ($show_variation): ?>
    <div class="variation">
      <?php if (isset($meret)): ?>
        <span class="kiszereles" title="Kiszerelés"><?=$meret?>:</span>
      <?php endif; ?>
      <strong title="Termék variáció"><?=$szin?></strong>
    </div>
    <?php endif; ?>

    <div class="prices">
      <div class="wrapper <?=($wo_price)?'wo-price':''?>">
        <?php if ( $wo_price ): ?>
          <div class="ar">
            <strong>ÉRDEKLŐDJÖN!</strong>
          </div>
        <?php else: ?>
          <?php if ( $akcios == '1' ): ?>
            <div class="ar akcios">
              <div class="old"><?=Helper::cashFormat($brutto_ar)?> <?=$valuta?></div>
              <div class="current"><?=Helper::cashFormat($ar)?> <?=$valuta?></div>
            </div>
          <?php else: ?>
            <div class="ar">
              <div class="current"><?=Helper::cashFormat($ar)?> <?=$valuta?> <? if($user['data']['price_group_data']['groupkey'] == 'beszerzes_netto') { echo '<span class="text">+ ÁFA</span>'; } ?></div>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        <div class="fav" ng-class="(fav_ids.indexOf(<?=$product_id?>) !== -1)?'selected':''" title="Kedvencekhez adom" ng-click="productAddToFav(<?=$product_id?>, $event)">
          <i class="fa fa-star" ng-show="fav_ids.indexOf(<?=$product_id?>) !== -1"></i>
          <i class="fa fa-star-o" ng-show="fav_ids.indexOf(<?=$product_id?>) === -1"></i>
        </div>
      </div>
    </div>

    <div class="buttons<?=($wo_price)?' wo-price':''?>">
      <?php if (!$wo_price): ?>
      <div class="add">
        <button type="button" id="btn-add-p<?=$product_id?>" cart-data="<?=$product_id?>" cart-progress="btn-add-p<?=$product_id?>" cart-me="1" cart-remsg="cart-msg" class="cart tocart"><img src="<?=IMG?>shopcart-ico.svg" alt="Kosárba"> Kosárba</button>
      </div>
      <?php endif; ?>
      <div class="link">
        <a href="<?=$link?>"><img src="<?=IMG?>eye-ico.svg" alt="Kosárba"> Megnézem</a>
      </div>
    </div>
  </div>
</div>
