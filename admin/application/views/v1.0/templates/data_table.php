<? 
	$t = $prev_table;
?>
<div class="row np tbl-elem">
	<input type="hidden" id="e<?=$t?>_current_col" value="<?=($data && count($data['head']) != 0) ? count($data['head']) : '1'?>">
	<input type="hidden" id="e<?=$t?>_current_row" value="<?=($data && count($data['row']) != 0) ? count($data['row']) : '1'?>">
	<div class="col-md-1"><strong>Tábla elem #<?=$t?></strong></div>
	<div class="col-md-11">
		<div class="row np">
			<div class="col-md-1 input-txt">Tábla főcím</div>
			<div class="col-md-11">
				<input type="text" class="form-control" name="dataset[<?=$t?>][title]" value="<?=$data['title']?>">
			</div>
		</div>
		<div class="row np">
			<div class="col-md-12 tbl-hd">
				<div class="row np">
					<div class="col-md-10">
						Táblázat
					</div>
					<div class="col-md-2 right">
						<button class="btn btn-default btn-sm" type="button" onclick="add_new_col(<?=$t?>);">oszlop beszúrás <i class="fa fa-plus"></i></button>
					</div>
				</div>
			</div>
		</div>
		<div class="row np">
			<div class="col-md-1 input-txt">Oszlop fejcím</div>
			<div class="col-md-11">
				<div id="e<?=$t?>_row_head_items" style="padding-left:3px;"><? if( $data ): ?><? $ci = 0; foreach( $data['head'] as $head ): $ci++; ?><input type="text" class="inp col datatable-col-<?=$ci?>-row" name="dataset[<?=$t?>][head][]" value="<?=$head?>"><? endforeach;?><? else: ?><input type="text" class="inp col" name="dataset[<?=$t?>][head][]"><? endif; ?></div>				
			</div>
		</div>
		<br>
		<div class="row np">
			<div class="col-md-1 input-txt">
				Táblázat elemek
			<div><button class="btn btn-default btn-sm" type="button" onclick="add_new_row(<?=$t?>);"> <i class="fa fa-plus"></i> új sor beszúrás</button></div>
			</div>
			<div class="col-md-11">
				<div id="e<?=$t?>_row_row_items"><? if( $data ): ?>
					<? $ri = 0; foreach ($data['row'] as $row ): $ri++; ?>
						<div id="e<?=$t?>_row_row<?=$ri?>_c" class="item-row item-row-<?=$ri?>" style="margin-bottom:5px;"><? $ci = 0; foreach( $row as $rd ): $ci++; ?><input type="text" class="inp col datatable-col-<?=$ci?>-row" name="dataset[<?=$t?>][row][<?=$ri-1?>][]" value="<?=$rd?>"><? endforeach; ?></div><? if($ri > 1):?><a href="javascript:void(0);" onclick="del_item_row(<?=$ri?>);" class="del-row item-row item-row-<?=$ri?>"><i class="fa fa-times"></i></a><? endif; ?><? endforeach; ?>
				<? else: ?><div id="e<?=$t?>_row_row1_c"><input type="text" class="inp col" name="dataset[<?=$t?>][row][0][]"></div><? endif; ?></div>

			</div>
		</div>
		<br>
		<div class="row np">
			<div class="col-md-1 input-txt">Szélesség (%)</div>
			<div class="col-md-11">
				<div id="e<?=$t?>_row_width_items" style="padding-left:3px;"><? if( $data ): ?>
					<? $ci = 0; foreach( $data['width'] as $width ): $ci++; ?><select name="dataset[<?=$t?>][width][]" class="inp col datatable-col-<?=$ci?>-row">
						<option value="" selected="selected">auto</option>
						<? for( $w = 5; $w <= 95; $w++ ): ?>
						<option value="<?=$w?>" <?=( $width == $w)?'selected="selected"':''?>><?=$w?>%</option>
						<? endfor; ?>
					</select><? endforeach;?>
				<? else: ?><select name="dataset[<?=$t?>][width][]" class="inp col">
					<option value="" selected="selected">auto</option>
					<? for( $w = 5; $w <= 95; $w++ ): ?>
					<option value="<?=$w?>"><?=$w?>%</option>
					<? endfor; ?>
				</select><? endif; ?></div>
			</div>
		</div>
		<div class="row np">
			<div class="col-md-1 input-txt">Stílus (css)</div>
			<div class="col-md-11">
				<div id="e<?=$t?>_row_style_items" style="padding-left:3px;"><? if( $data ): ?><? $ci = 0; foreach( $data['style'] as $style ): $ci++; ?><input type="text" placeholder="font-weight:bold; ..." class="inp col datatable-col-<?=$ci?>-row" name="dataset[<?=$t?>][style][]" value="<?=$style?>"><? endforeach;?>
				<? else: ?><input type="text" placeholder="font-weight:bold; ..." class="inp col" name="dataset[<?=$t?>][style][]"><? endif; ?></div>
			</div>
		</div>	
		<div class="row np">
			<div class="col-md-1 input-txt"></div>
			<div class="col-md-11">
				<div id="e<?=$t?>_row_del_items" style="padding-left:3px;"><? if( $data ): ?><? $di = 0; foreach( $data['head'] as $head ): $di++; ?><div class="del-col datatable-col-<?=$di?>-row" col="<?=$di?>"><? if($di > 1):?><a title="Oszlop törlése" href="javascript:void(0);" onclick="del_col(<?=$di?>);"><i class="fa fa-times"></i></a><? else: ?>&nbsp;<? endif; ?></div><? endforeach;?><? else: ?><div class="del-col" col="1">&nbsp;</div><? endif; ?></div>
			</div>
		</div>
	</div>
</div>