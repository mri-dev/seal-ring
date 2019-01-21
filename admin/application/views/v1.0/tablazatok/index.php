<div style="float:right;">
	<a href="/tablazatok/uj/" class="btn btn-default"><i class="fa fa-plus"></i> új táblázat</a>
</div>
<h1>Táblázatok</h1>
<div class="divider"></div>
<?=$this->msg?>
<br>

<? if($this->gets[1] == 'del'): ?>
<form action="" method="post">
<input type="hidden" name="delId" value="<?=$this->gets[2]?>" />
<div class="row np">
	<div class="col-md-12">
    	<div class="con con-del">
            <h2>Táblázat törlése</h2>
            Biztos, hogy törli a kiválasztott táblázatot?
            <div class="row np">
                <div class="col-md-12 right">
                    <a href="/<?=$this->gets[0]?>/" class="btn btn-danger"><i class="fa fa-times"></i> NEM</a>
                    <button class="btn btn-success">IGEN <i class="fa fa-check"></i> </button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<? endif; ?>

<? if( $this->gets[1] == 'uj' || $this->gets[1] == 'edit' ): ?>
<div class="con <?=($this->gets[1] == 'uj')?'':'con-edit'?>">
	<h2><?=($this->gets[1] == 'uj')?'Új táblázat létrehozása':'Táblázat szerkesztése'?></h2>
	<form action="" method="post">
		<div class="row">
			<div class="col-md-4">
                <label for="elnevezes">Elnevezés*</label>
                <input type="text" id="elnevezes" class="form-control" name="elnevezes" value="<?=($this->selected_data)?$this->selected_data['elnevezes']:''?>">                               
            </div>	
            <div class="col-md-2">
                <label for="key">Azonosító kulcs*</label>
                <input type="text" id="key" class="form-control" name="kulcs" value="<?=($this->selected_data)?$this->selected_data['kulcs']:''?>">                               
            </div>
			<div class="col-md-4">
                <label for="image">Kép</label>
                <div class="input-group">
                    <input type="text" id="image" class="form-control" name="kep" value="<?=($this->selected_data)?$this->selected_data['kep']:''?>">
                    <div class="input-group-addon"><a title="Kép kiválasztása" href="<?=FILE_BROWSER_IMAGE?>&field_id=image" data-fancybox-type="iframe" class="iframe-btn" type="button"><i class="fa fa-search"></i></a></div>
                </div>                                
            </div>			
			<div class="col-md-1" style="line-height:24px;">
				<br>
				<button type="button" id="add_table" class="btn btn-default">új táblázat elem <i class="fa fa-plus"></i></button>
			</div>
		</div>
		<br>
		<div class="divider"></div>
		<br>
		<div id="size_items">
			<? if($this->gets[1] == 'uj' || count( $this->selected_data['dataset'] ) == 0): ?>
			<div id="no_size_items">Nincs táblázat elem beszúrva!</div>
			<? else: ?>
				<? 
				$t = 0;
				foreach( $this->selected_data['dataset'] as $dataset ): $t++; ?>
					<? 
						$arg = array();
						$arg['prev_table'] = $t;
						$arg['data'] = $dataset;
						echo $this->templates->get( 'data_table', $arg ); 
					?>
				<? endforeach;?>
			<? endif; ?>
		</div>
		<br>
		<div class="divider"></div>
		<br>
		<div class="row">
			<div class="col-md-12">
				<label for="description">Megjegyzés a táblázathoz</label>
				<textarea name="leiras" id="description"><?=($this->selected_data)?$this->selected_data['leiras']:''?></textarea>
			</div>	
		</div>
		<br>
		<div class="row">		
            <div class="col-md-12">
				<label for="footer">Lábrész megjegyzés</label>
				<input type="text" class="form-control" id="footer" name="labresz_megjegyzes" value="<?=($this->selected_data)?$this->selected_data['labresz_megjegyzes']:''?>">
			</div>	
		</div>
		<br>
		<div class="row">
			<div class="col-md-12 right">
				<? if( $this->gets[1] == 'uj'): ?>
				<button class="btn btn-primary" name="add" value="1">Létrehozás <i class="fa fa-check-square"></i></button>
				<? else: ?>
				<a class="btn btn-danger" href="/tablazatok/">Mégse <i class="fa fa-times"></i></a>
				<button class="btn btn-success" name="edit" value="1">Változások mentése <i class="fa fa-save"></i></button>
				<? endif; ?>
			</div>
		</div>
	</form>
</div>
<br>
<? endif; ?>
<div class="tbl-container overflowed">
	<form action="" method="post">
	<table class="table termeklista table-bordered" style="min-width:970px;">
		<thead>
	    	<tr>
				<th title="ID" width="50">#</th>
				<th>Elnevezés</th>
				<th>Azonosító kulcs</th>
				<th>Beágyazó kulcs</th>
	            <th width="20"></th>
	        </tr>
		</thead>
	    <tbody>
	    	<? if( count( $this->sizetable['data']) > 0 ): foreach( $this->sizetable['data'] as $d ): ?>
	    	<tr class="<?=($this->gets[2] == $d['ID'] && $this->gets[1] == 'del')?'dellitem':''?>">
		    	<td align="center">
					<?=$d['ID']?>
				</td>
				<td align="left">
					<strong><a title="Előnézet megtekintése" href="javascript:void(0);" onclick="$('#table_e_<?=$d['ID']?>').slideToggle(400);"><?=$d['elnevezes']?></a></strong>
				</td>
				<td align="center">
					<?=$d['kulcs']?>
				</td>
				<td align="center">
					##table-data:<?=$d['kulcs']?>##
				</td>
				<td align="center">
		            <div class="dropdown">
		            	<i class="fa fa-gears dropdown-toggle" title="Műveletek" id="dm<?=$d['ID']?>" data-toggle="dropdown"></i>
		                  <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$d['ID']?>">
		                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/tablazatok/edit/<?=$d['ID']?>">szerkesztés <i class="fa fa-pencil"></i></a></li>
		                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/tablazatok/del/<?=$d['ID']?>">végleges törlés <i class="fa fa-times"></i></a></li>
						  </ul>
		            </div>
	            </td>
	        </tr>
	        <tr id="table_e_<?=$d['ID']?>" style="display:none;">
	        	<td colspan="99">
	        		<?
		        		$sizedata = array();
						$sizedata['key'] = $d['kulcs'];
						$table = $this->datatable->getTable( $d['kulcs'] );

						$sizedata['data'] = $table;

						echo $this->templates->get('size_table', $sizedata);
	        		?>
	        	</td>
	        </tr>
	        <? endforeach; else: ?>
	        <tr>
		    	<td colspan="15" align="center">
	            	<div style="padding:25px;">Nincs találat!</div>
	            </td>
	        </tr>
	        <? endif; ?>
	    </tbody>
	</table>
	<?=$this->navigator?>
	</form>
</div>
<script>
	$(function(){
		var inserted_table = <?=($this->selected_data) ? count($this->selected_data['dataset']) : 0?>;

		$('#add_table').click( function(){
			inserted_table++;
			
			if (inserted_table == 1) {
				$('#no_size_items').remove();
			}

			loadTemplate( 'data_table', {
				prev_table : inserted_table
			}, function(template) {
				$('#size_items').append(template);				
			});
		});
		
	})

	function del_col ( col ) {
		$('.datatable-col-'+col+'-row').remove();
	}

	function del_item_row ( row ) {
		$('.item-row.item-row-'+row).remove();
	}

	function add_new_col (elem_index) {
		var current_col_e = $('#e'+elem_index+"_current_col");
		var current_row_e = $('#e'+elem_index+"_current_row");

		addCol( 
			elem_index, 
			current_col_e.val(), 
			current_row_e.val(),
			function( next_index ){
				current_col_e.val(next_index);
			}
		);
	}

	function add_new_row (elem_index) {
		var current_col_e = $('#e'+elem_index+"_current_col");
		var current_row_e = $('#e'+elem_index+"_current_row");

		addElemRow(
			elem_index,
			current_col_e.val(),
			current_row_e.val(),			
			function( next_row_index ){
				current_row_e.val(next_row_index);
			}
		);
	}

	function addCol ( eindex, current, current_row, callback ) {
		console.log(current_row);
		current = parseInt(current);
		// Head
		$('#e'+eindex+"_row_head_items").append('<input type="text" class="inp col datatable-col-'+(current + 1)+'-row" name="dataset['+(eindex)+'][head][]">');
		// Elem
		if( current_row == 1 ){
			$('#e'+eindex+"_row_row_items").find('div#e'+eindex+'_row_row'+current_row+'_c').append('<input type="text" class="inp col datatable-col-'+(current + 1)+'-row" name="dataset['+eindex+'][row][0][]">');
		} else {
			for (var i = current_row; i >= 0; i--) {
				$('#e'+eindex+"_row_row_items").find('div#e'+eindex+'_row_row'+i+'_c').append('<input type="text" class="inp col datatable-col-'+(current + 1)+'-row" name="dataset['+eindex+'][row]['+(i-1)+'][]">');
			};
		}
		
		// Width
		$('#e'+eindex+"_row_width_items").append('<select name="dataset['+eindex+'][width][]" class="inp col datatable-col-'+(current + 1)+'-row">'+$('#e'+eindex+"_row_width_items").find('select').html()+'</select>');
		// Style	
		$('#e'+eindex+"_row_style_items").append('<input type="text" placeholder="font-weight:bold; ..." class="inp col datatable-col-'+(current + 1)+'-row" name="dataset['+eindex+'][style][]">');
		// Delete 
		$('#e'+eindex+"_row_del_items").append('<div class="del-col datatable-col-'+(current + 1)+'-row" col="'+(current + 1)+'"><a title="Oszlop törlése" href="javascript:void(0);" onclick="del_col('+(current + 1)+');"><i class="fa fa-times"></i></a></div>');
		
		callback( current + 1 );	
	}

	function addElemRow ( eindex, col_num, current, callback ) {
		current = parseInt(current);
		var eleminsert = '<div style="margin-top:5px;" id="e'+eindex+'_row_row'+(current + 1)+'_c" class="item-row item-row-'+(current+1)+'">';
		for (var i = 1; i <= col_num; i++) {
			eleminsert += '<input type="text" class="inp col datatable-col-'+i+'-row" name="dataset['+eindex+'][row]['+(current)+'][]">';
		};

		eleminsert += '</div><a href="javascript:void(0);" onclick="del_item_row('+(current+1)+');" class="del-row item-row item-row-'+(current+1)+'"><i class="fa fa-times"></i></a>';

		$('#e'+eindex+"_row_row_items").append(eleminsert);
		callback( current +1 );
	}
</script>