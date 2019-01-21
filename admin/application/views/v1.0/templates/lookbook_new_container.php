<div class="new-container">
	<input type="hidden" name="new_container[<?=$position?>][<?=$index?>][create]" value="1" >
	<div class="head">Új gyűjtő</div>
	<div class="row np">
		<div class="col-md-2">			
			<label for="">Gyüjtő sorrend</label>
			<div>
				<input type="number" name="new_container[<?=$position?>][<?=$index?>][sorrend]" value="<?=$index?>" min="-100" max="100" class="form-control">		
			</div>
		</div>
		<div class="col-md-3" style="padding-left:5px;">			
			<label for="">Kép léptetés gyorsaság <?=\PortalManager\Formater::tooltip('0 másodperc = manuális léptetés')?></label>
			<div class="input-group">
				<input type="number" name="new_container[<?=$position?>][<?=$index?>][kep_leptetes_ido]" value="4" min="0" max="20" class="form-control">	
				<span class="input-group-addon">másodperc</span>		
			</div>
		</div>
	</div>
	<br>
	<div class="image-set book-<?=$book?>-<?=$position?>-<?=$index?>">
		<label for="">Képek</label>
		<div class="input-group">
			<input type="text" name="new_container[<?=$position?>][<?=$index?>][kepek][]" id="img_<?=$book?>_<?=$position?>_<?=$index?>_1" class="form-control">
			<span class="input-group-addon"><a title="Kép kiválasztása" href="<?=FILE_BROWSER_IMAGE?>&field_id=img_<?=$book?>_<?=$position?>_<?=$index?>_1" data-fancybox-type="iframe" class="iframe-btn" type="button"><i class="fa fa-folder-open"></i></a></span>
		</div>
	</div>
	<br>
	<div class="right"><a href="javascript:void(0);" onclick="add_more_image( <?=$book?>, '<?=$position?>', <?=$index?> );">új kép <i class="fa fa-plus"></i></a></div>
	<br>
	<div class="">
		<label for="">Promóciós szöveg (nem kötelező)</label>
		<div>
			<textarea name="new_container[<?=$position?>][<?=$index?>][szoveg]" class="form-control no-editor" placeholder="Képen megjelenő szöveg..."></textarea>
		</div>
	</div>
	<br>
	<div class="products">
		<label for="">Csatolt termékek</label>
		<div class="products-set book-<?=$book?>-<?=$position?>-<?=$index?>">
			
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