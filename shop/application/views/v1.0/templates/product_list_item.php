<div class="item">
	<?php
    $wo_price = (empty($ar) || $ar == '0') ? true : false;
  ?>
	<div class="wrapper">
		<div class="fav" ng-class="(fav_ids.indexOf(<?=$product_id?>) !== -1)?'selected':''" title="Kedvencekhez adom" ng-click="productAddToFav(<?=$product_id?>, $event)">
			<i class="fa fa-star" ng-show="fav_ids.indexOf(<?=$product_id?>) !== -1"></i>
			<i class="fa fa-star-o" ng-show="fav_ids.indexOf(<?=$product_id?>) === -1"></i>
		</div>
		<div class="maindata">
			<div class="title">
				<h3><a title="<?=$product_nev?>" href="<?=$link?>"><?=$product_nev?></a></h3>
				<div class="subtitle"><?=__($csoport_kategoria)?></div>
			</div>
		</div>
		<div class="prices">
      <div class="wrapper <?=($wo_price)?'wo-price':''?>">
        <?php if ( $wo_price ): ?>
          <div class="ar">
            <strong>ÉRDEKLŐDJÖN!</strong>
          </div>
        <?php else: ?>
          <?php if ( $akcios == '1' ): ?>
            <div class="ar akcios">
              <div class="old"><?=Helper::cashFormat($eredeti_ar)?> <?=$valuta?> <?=($this->settings['price_show_brutto'] == 0)?'<span class="text">+ ÁFA</span>':''?></div>
              <div class="current"><?=Helper::cashFormat($ar)?> <?=$valuta?> <?=($this->settings['price_show_brutto'] == 0)?'<span class="text">+ ÁFA</span>':''?></div>
            </div>
          <?php else: ?>
            <div class="ar">
              <div class="current"><?=Helper::cashFormat($ar)?> <?=$valuta?> <?=($this->settings['price_show_brutto'] == 0)?'<span class="text">+ ÁFA</span>':''?> <? if($user['data']['price_group_data']['groupkey'] == 'beszerzes_netto' && $this->settings['price_show_brutto'] == 1) { echo '<span class="text">+ ÁFA</span>'; } ?></div>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
		<div class="stockinfo">
			<div class="rack" style="background: <?=$keszlet_color?>;">
				<?=($show_stock=='1' && $raktar_keszlet > 0)?$raktar_keszlet.' db ':''?><?=$keszlet_nev?>
			</div>
		</div>
		<div class="buttons<?=($wo_price)?' wo-price':''?>">
      <?php if (!$wo_price): ?>
      <div class="addnum">
        <input type="number" onchange="$('#btn-add-p<?=$product_id?>').attr('cart-me', $(this).val())" step="1" max="<?=($raktar_keszlet>0)?$raktar_keszlet:''?>" min="1" value="1">
      </div>
      <div class="add">
        <button type="button" id="btn-add-p<?=$product_id?>" cart-data="<?=$product_id?>" cart-progress="btn-add-p<?=$product_id?>" cart-me="1" cart-remsg="cart-msg" class="cart tocart"> Kosárba <img src="<?=IMG?>shopcart-ico.svg" alt="Kosárba"></button>
      </div>
      <?php endif; ?>
    </div>
	</div>
</div>
