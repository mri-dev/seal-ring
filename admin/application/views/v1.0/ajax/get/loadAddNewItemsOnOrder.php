<div class="row" style="padding:4px 0;">
	<div class="col-md-1" style="line-height:35px;">
		#ID
	</div>
	<div class="col-md-3">
		<input type="text" name="new_product[]" value="" class="form-control" placeholder="A termék belső ID-ja">
	</div>
	<div class="col-md-1" style="line-height:35px;">
		Mennyiség:
	</div>
	<div class="col-md-3">
		<input type="number" value="1" min="1" name="new_product_number[]" class="form-control">
	</div>
	<div class="col-md-1" style="line-height:35px;">
		Állapot:
	</div>
	<div class="col-md-3">
		<select class="form-control" name="new_product_allapot[]">
			<? foreach($this->allapotok as $m):  ?>
            <option style="color:<?=$m[szin]?>;" value="<?=$m[ID]?>"><?=$m[nev]?></option>
            <? endforeach; ?>
        </select>
	</div>
</div>
<div class="divider"></div>
