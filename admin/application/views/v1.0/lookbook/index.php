<div style="float:right;">
	<a class="btn btn-default" href="/lookbook/uj"> új létrehozása <i class="fa fa-plus"></i></a>
</div>
<div class="lookbook">
	<h1>LookBook</h1>
	<div class="divider"></div>	
	<br>
	<?=$this->msg?>
	<? if( $this->gets['1'] == 'uj' || $this->gets['1'] == 'edit'): ?>
	<br>
	<div class="con <?=($this->gets['1'] == 'edit')?'con-edit':''?>">
		<h3><?=($this->gets['1'] == 'edit')?'Lookbook szerkesztése':'Új lookbook létrehozása'?></h3>
		<?
			if( $this->edit ){
				$data = $this->edit['data']['0'];
			}
		?>
		<form action="" method="post">
			<div style="margin: 0 -15px;">
				<div class="row" style="margin: 0 -15px;">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">
								<label for="nev">Elnevezés*</label>
								<input type="text" class="form-control" name="nev" id="nev" value="<?=($data) ? $data['nev'] : ''?>" placeholder="pl.: Friss nyári kollekció">
							</div>
							<div class="col-md-4">
								<label for="kulcs">Elérési kulcs*</label>
								<input type="text" class="form-control" name="kulcs" id="kulcs" value="<?=($data) ? $data['kulcs'] : ''?>" placeholder="p.: friss_nyari_kollekcio">
							</div>
							<div class="col-md-2">
								<label for="lathato">Láthato</label>
								<input type="checkbox" class="form-control" name="lathato" <?=($data && $data['lathato'] == 1) ? 'checked="checked"' : ''?> id="lathato">
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">				
					<div class="col-md-12">
						<label for="">Elrendezés</label>
						<div class="template-block">
							<label><input type="radio" name="template" value="1_1" <?=($data && $data['template'] == '1_1' || !$data) ? 'checked="checked"' : ''?>> <img src="<?=IMG?>lookbook_template_block_1_1.png" alt=""></label>
							<label><input type="radio" name="template" value="1_2" <?=($data && $data['template'] == '1_2') ? 'checked="checked"' : ''?>> <img src="<?=IMG?>lookbook_template_block_1_2.png" alt=""></label>
							<label><input type="radio" name="template" value="2_1" <?=($data && $data['template'] == '2_1') ? 'checked="checked"' : ''?>> <img src="<?=IMG?>lookbook_template_block_2_1.png" alt=""></label>
						</div>
					</div>
				</div>
				<div class="row" style="margin:8px 0;">
					<div class="col-md-12">
						<div class="divider"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 input-txt">
						<? if($this->gets['1'] == 'uj'): ?>
						<i class="fa fa-info-circle"></i> További beállítások elérhetőek létrehozás után.
						<? endif; ?>
					</div>
					<div class="col-md-4 right">
						<? if($this->gets['1'] == 'uj'): ?>
						<button class="btn btn-primary" name="add" value="1">Létrehozás</button>
						<? else: ?>
						<button class="btn btn-success" name="edit" value="1">Változások mentése <i class="fa fa-save"></i></button>
						<? endif; ?>
					</div>
				</div>
			</div>
		</form>
	</div>
	<? endif; ?>
	<br>
	<div class="tbl-container overflowed">
		<form action="" method="post">
		<table class="table termeklista table-bordered">
			<thead>
		    	<tr>
					<th title="ID" width="50">#</th>
					<th>Elnevezés</th>
					<th>Elérési kulcs</th>
					<th width="80">Gyüjtők</th>
					<th width="120">Elrendezés</th>
					<th width="80">Látható</th>
		            <th width="20"></th>
		        </tr>
			</thead>
		    <tbody>
		    	<? if( count( $this->lookbooks['data']) > 0 ): foreach( $this->lookbooks['data'] as $d ): ?>
		    	<tr class="<?=($this->gets['2'] == $d['ID'] && $this->gets['1'] == 'del')?'dellitem':''?>">
			    	<td class="center"><?=$d['ID']?></td>
			    	<td><strong><a title="Lookbook kezelése, részletek" href="/lookbook/v/<?=$d['ID']?>"><?=$d['nev']?></a></strong></td>
			    	<td><a href="<?=HOMEDOMAIN?>lookbook/<?=$d['kulcs']?>" target="_blank"><em><?=HOMEDOMAIN?>lookbook/</em><strong><?=$d['kulcs']?></strong></a></td>
					<td class="center"><?=$d['container_num']?> db</td>
					<td class="center"><?=str_replace('_',' / ', $d['template'])?> oszlop</td>
					<td class="center"><?=($d['lathato'] == 1) ? '<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>'?></td>
					<td align="center">
			            <div class="dropdown">
			            	<i class="fa fa-gears dropdown-toggle" title="Műveletek" id="dm<?=$d['ID']?>" data-toggle="dropdown"></i>
			                  <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$d['ID']?>">
			                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/lookbook/edit/<?=$d['ID']?>">szerkesztés <i class="fa fa-pencil"></i></a></li>
			                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/lookbook/del/<?=$d['ID']?>">végleges törlés <i class="fa fa-times"></i></a></li>
							  </ul>
			            </div>
		            </td>
		        </tr>
		        <? if( $this->gets['1'] == 'v' && $this->gets['2'] == $d['ID'] ): ?>
		        <tr>
		        	<td colspan="99">
		        		<div class="container-viewer">
		        		<form action="" method="post">
		        			<input type="hidden" name="book_id" value="<?=$d['ID']?>">
		        			<input type="hidden" id="b<?=$d['ID']?>_left_cnum" value="<?=(count( $d['containers']['left'] ) > 0) ? count( $d['containers']['left'] ) : 0?>">
		        			<input type="hidden" id="b<?=$d['ID']?>_right_cnum" value="<?=(count( $d['containers']['right'] ) > 0) ? count( $d['containers']['left'] ) : 0?>">
			        		
			        		<div class="row np" style="padding:0 15px;">
			        			<div class="col-md-12 right">
			        				<a href="/lookbook/" style="color:#222;">bezárás</a> &nbsp;
			        				<button name="saveContainer" value="1" class="btn btn-success">Adatok mentése <i class="fa fa-save"></i></button>
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-md-6">
			        				<div class="container-side">
			        					<div class="side-name">Bal oszlop <span style="color:red;" id="loading_side_left"></span></div>
			        					<div id="container_<?=$d['ID']?>_left">
			        						<? $i = 0; if(count( $d['containers']['left'] ) > 0): foreach( $d['containers']['left'] as $left_c ): $i++; ?>
												<? echo $this->template->get( 'lookbook_edit_container', array( 
												'data' 		=> $left_c, 
												'book' 		=> $d['ID'],
												'position' 	=> 'left',
												'index' 	=> $i,
												) ); ?>
			        						<? endforeach; endif; ?>
			        					</div>
			        					<div class="add-container">
			        						<a href="javascript:void(0);" onclick="add_container( <?=$d['ID']?>, 'left' );"><i class="fa fa-plus"></i> gyűjtő hozzáadása</a>
			        					</div>
			        				</div>
			        			</div>
			        			<div class="col-md-6">
			        				<div class="container-side">
			        					<div class="side-name">Jobb oszlop <span style="color:red;" id="loading_side_right"></span></div>		        					
			        					<div id="container_<?=$d['ID']?>_right">
			        						<? $i = 0; if(count( $d['containers']['right'] ) > 0): foreach( $d['containers']['right'] as $right_c ): $i++; ?>
												<? echo $this->template->get( 'lookbook_edit_container', array( 
												'data' 		=> $right_c, 
												'book' 		=> $d['ID'],
												'position' 	=> 'right',
												'index' 	=> $i,
												) ); ?>
			        						<? endforeach; endif; ?>
			        					</div>
			        					<div class="add-container">
			        						<a href="javascript:void(0);" onclick="add_container( <?=$d['ID']?>, 'right' );"><i class="fa fa-plus"></i> gyűjtő hozzáadása</a>
			        					</div>
			        				</div>
			        			</div>
			        		</div>
		        		</form>
		        		</div>
		        	</td>
		        </tr>
		    	<? endif; ?>
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
</div>

<script>
	$(function(){
		$('#nev').bind( 'keyup', function() {
			$('#kulcs').val( $(this).val() );
		});
	})

	function search_product ( book_id, position, container, search, elem_hint_to ) {
		elem_hint_to.html( '<div><i class="fa fa-spinner fa-spin"></i> keresés folyamatban...</div>' ).show(0);
		$.post('<?=AJAX_POST?>', {
			type: 'search_product_for_lookbook',
			search: search,
			book : book_id,
			position : position,
			container: container
		}, function(d){
			console.log(d);
			elem_hint_to.html( d );
		}, "html");
		
	}

	function add_product_to_container ( book_id, position, container, e, data ) {
		console.log(data);

		$('.products-set.book-'+book_id+'-'+position+'-'+container).append('<input type="hidden" name="new_container['+position+']['+container+']['products'][]" value="'+data.id+'" /><div><i class="fa fa-times delp" onclick="$(this).parent().remove();"></i><div class="push-item">'+data.name+'</div></div>')

		$(e).remove();
	}

	function add_container ( book_id, position ) {
		var container_index = parseInt($('#b'+book_id+'_'+position+'_cnum').val());
		$('#loading_side_'+position).html( '<i class="fa fa-spinner fa-spin"></i> betöltés folyamatban...' );
		loadTemplate( 'lookbook_new_container', {
			book : book_id,
			position : position,
			index : container_index + 1
		}, function ( e ) {
			$('#container_'+book_id+'_'+position).append( e );
			$('#loading_side_'+position).html( '' );
			$('#b'+book_id+'_'+position+'_cnum').val( container_index + 1 );
		} );
	}

	function del_container ( cont_id ) {
		var conf = confirm('Biztos, hogy törli a kiválasztott gyüjtőt?');

		if ( conf ) {
			$.post( '<?=AJAX_POST?>', {
				type 	: 'lookbook_remove_container',
				id 		: cont_id
			}, function(d){
				document.location.href = '/lookbook/v/<?=$this->gets['2']?>/?msgkey=msg&msg=Gyüjtő sikeresen törölve!';
			}, "html" );			
		} else {
			return false;
		}
	}

	function add_more_image ( book_id, position, index ) {
		var preve = $('.image-set.book-'+book_id+'-'+position+'-'+index+'').find('input[type=text]').size();
		var ins =  '<div class="input-group" style="margin-top:4px;"><input type="text" name="new_container['+position+']['+index+']['kepek'][]" id="img_'+book_id+'_'+position+'_'+index+'-'+(preve+1)+'" class="form-control"><span class="input-group-addon"><a title="Kép kiválasztása" href="<?=FILE_BROWSER_IMAGE?>&field_id=img_'+book_id+'_'+position+'_'+index+'-'+(preve+1)+'" data-fancybox-type="iframe" class="iframe-btn" type="button"><i class="fa fa-folder-open"></i></a></span></div>';
		$('.image-set.book-'+book_id+'-'+position+'-'+index).append( ins );				
	}

</script>