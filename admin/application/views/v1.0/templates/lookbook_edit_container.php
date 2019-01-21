<div class="new-container editor">
	<input type="hidden" name="container[<?=$position?>][<?=$index?>][cont_id]" value="<?=$data['ID']?>">
	<div class="del-cont"><i title="Gyüjtő törlése" class="fa fa-times" onclick="del_container(<?=$data['ID']?>);"></i></div>
	<div class="row np">
		<div class="col-md-2">			
			<label for="">Gyüjtő sorrend</label>
			<div>
				<input type="number" name="container[<?=$position?>][<?=$index?>][sorrend]" value="<?=$data['sorrend']?>" min="-100" max="100" class="form-control">		
			</div>
		</div>
		<div class="col-md-3" style="padding-left:5px;">			
			<label for="">Kép léptetés gyorsaság <?=\PortalManager\Formater::tooltip('0 másodperc = manuális léptetés')?></label>
			<div class="input-group">
				<input type="number" name="container[<?=$position?>][<?=$index?>][kep_leptetes_ido]" value="<?=$data['kep_leptetes_ido']/1000?>" min="0" max="20" class="form-control">	
				<span class="input-group-addon">másodperc</span>		
			</div>
		</div>
	</div>
	<br>
	<div class="image-set book-<?=$book?>-<?=$position?>-<?=$index?>">
		<label for="">Képek</label>
		<? $i = 0; foreach( $data['kepek'] as $kep ): $i++; ?>
		<div class="input-group" style="margin-bottom:4px;">			
			<input type="text" name="container[<?=$position?>][<?=$index?>][kepek][]" value="<?=$kep?>" id="img_<?=$book?>_<?=$position?>_<?=$index?>_<?=$i?>" class="form-control">
			<span class="input-group-addon"><a title="Kép kiválasztása" href="<?=FILE_BROWSER_IMAGE?>&field_id=img_<?=$book?>_<?=$position?>_<?=$index?>_<?=$i?>" data-fancybox-type="iframe" class="iframe-btn" type="button"><i class="fa fa-folder-open"></i></a></span>
		</div>
		<? endforeach; ?>
	</div>
	<br>
	<div class="right"><a href="javascript:void(0);" onclick="add_more_image( <?=$book?>, '<?=$position?>', <?=$index?> );">új kép <i class="fa fa-plus"></i></a></div>
	<br>
	<div class="">
		<label for="">Promóciós szöveg (nem kötelező)</label>
		<div>
			<textarea name="container[<?=$position?>][<?=$index?>][szoveg]" class="form-control no-editor" placeholder="Képen megjelenő szöveg..."><?=$data['szoveg']?></textarea>
		</div>
	</div>
	<br>
	<div class="products">
		<label for="">Csatolt termékek</label>
		<div class="products-set book-<?=$book?>-<?=$position?>-<?=$index?>">
			<? foreach( $data['products'] as $p ): ?>
			<input type="hidden" name="container[<?=$position?>][<?=$index?>][prev_products][]" value="<?=$p['termek_id']?>">
			<div>
				<i class="fa fa-times delp" onclick="$(this).parent().remove();"></i>
				<input type="hidden" name="container[<?=$position?>][<?=$index?>][products][]" value="<?=$p['termek_id']?>">
				<div class="push-item"><?=$p['termek_nev']?> (<?=$p['cikkszam']?>)</div>
			</div>
			<? endforeach;?>
		</div>
		<div class="add-product">
			<div class="input-group">				
				<input type="text" class="form-control" placeholder="termék keresés..." class="search-item" id="src-item-<?=$book?>-<?=$position?>-<?=$index?>">
				<span class="input-group-addon"><a href="javascript:void(0);" onclick="search_product(<?=$book?>, '<?=$position?>', <?=$index?>, $('#src-item-<?=$book?>-<?=$position?>-<?=$index?>').val(), $('.search-hint.book-<?=$book?>-<?=$position?>-<?=$index?>'));"><i class="fa fa-search"></i></a></span>
			</div>
			<div class="search-hint overflowed book-<?=$book?>-<?=$position?>-<?=$index?>">
			</div>
		</div>
	</div>
</div>