<div class="ele-item <? if(!$new): ?>item_<?=$item_name?><? endif; ?>">
	<? if(!$new): ?>
		<div class="del" title="Eltávolítás"><i question-item-action="delete" question-item-hash="<?=$hash?>_<?=$item_name?>" class="fa fa-times"></i></div>
	<? endif; ?>
	<div class="head">Érték #<?=$order_sort?></div>
	<div class="row">
		<? 
		// Type of RADIO
		if( $type == 'radio' ): ?>
		<div class="col-md-12">
			<input type="hidden" name="values_new[<?=$hash?>][]" value="<?=($new)?1:0?>">
			<input type="hidden" name="values_name[<?=$hash?>][]" value="<?=$item_name?>">
			<input type="text" class="form-control" name="values[<?=$hash?>][]" value="<?=$item_value?>">			
		</div>
		<? 
		// Type of CHECKBOX
		elseif( $type == 'checkbox' ): ?>
		<div class="col-md-12">
			<input type="hidden" name="values_new[<?=$hash?>][]" value="<?=($new)?1:0?>">
			<input type="hidden" name="values_name[<?=$hash?>][]" value="<?=$item_name?>">
			<input type="text" class="form-control" name="values[<?=$hash?>][]" value="<?=$item_value?>">
		</div>
		<? endif; ?>
	</div>
</div>
<style>
	.ele-item {
		border: 1px dashed #b7b7b7;
		padding: 5px;
		background: #f2f2f2;
		margin: 0 0 8px 0;
	}
	.ele-item .head {
		padding: 5px 0 5px 0;
		border-bottom:1px solid #d4d4d4;
		color: #898989 !important;
		font-size:12px !important;
	} 
	.ele-item:last {
		margin: 0;
	}
</style>