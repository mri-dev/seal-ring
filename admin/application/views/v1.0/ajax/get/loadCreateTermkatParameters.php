<? if(count($this->parameterek) > 0): ?>
	<h3>Paraméterek:</h3><br>
<? endif; ?>
<? foreach($this->parameterek as $d): ?>
<div class="row">
	<div class="col-md-12">
     <strong><?=Product::clear($d['parameter'])?></strong>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
    	<div class="input-group">
    	<input type="text" name="param[<?=$d['ID']?>]" class="form-control">
        <span class="input-group-addon"><?=$d['mertekegyseg']?></span>
        </div>
    </div>
</div>
<br>
<? endforeach; ?>