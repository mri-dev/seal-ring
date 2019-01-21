<div class="item">
	<? 
		$ar = $brutto_ar;
		if( $akcios == '1' ): 
			$ar = $akcios_fogy_ar; 
		endif; 

		// Cashoff ár
		$dar = $ar-$user['data']['cash']; 
		if( $dar < 0) $dar = 0;
	?>
	<div class="image">
		<a href="<?=$link?>"><img class="aw" title="<?=$product_nev?>" src="<?=$profil_kep?>" alt="<?=$product_nev?>"></a>
	</div>
	<div class="title"><?=$product_nev?></div>
	<div class="subtitle"><?=__($csoport_kategoria)?></div>
	<div class="info-row-bottom">
		<div class="price">
			<? $ar = $brutto_ar; ?>
			<? 
			if( $akcios == '1' ): 
			$ar = $akcios_fogy_ar;
			?>
			<div class="old"><div class="percents">-<? echo 100-round($akcios_fogy_ar / ($brutto_ar / 100)); ?>%</div> <?=Helper::cashFormat($brutto_ar)?> <?=$valuta?> </div>
			<? endif; ?>
			<div class="current"><?=Helper::cashFormat($ar)?> <?=$valuta?></div>
		</div>
		<? if( !empty($ajandek) ): ?>
		<div class="gift">
			<img src="<?=IMG?>gift_20pxh.png" alt="<?=__('Ajándék')?>">								
			<?=$ajandek?>
		</div>
		<? endif; ?>		
		<div class="clr"></div>
	</div>
	<div class="buttons">
		<div class="holder">
			<div class="watch autoheight"><a href="<?=$link?>"><?=__('megnézem')?></a></div>
			<div class="order autoheight"><a href="<?=$link?>?buy=now"><?=__('megrendelem')?></a></div>
		</div>					
	</div>	
</div>