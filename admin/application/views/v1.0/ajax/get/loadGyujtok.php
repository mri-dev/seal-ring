<br />
<select name="gyujtokat[]" class="form-control" id="gyujtokat">
	<option value="">-- gyűjtő kategória kiválasztás --</option>
    <option value="" disabled="disabled">----------------------</option>
    <option value="0">Mindegyikbe megjelenjen</option>
    <option value="" disabled="disabled">----------------------</option>
    <? foreach($this->gyujtok as $d): ?>
    <option value="<?=$d[ID]?>">|-----<?=Product::clear($d[neve])?></option>
    <? endforeach; ?>
</select>