<div class="q ask ask_<?=$timestamp?>">
	<? if(!$new): ?>
		<div title="Eltávolítás" class="del"><i question-action="delete" question-hash="<?=$timestamp?>" class="fa fa-times"></i></div>
	<? endif; ?>
	<input type="hidden" name="question[<?=$timestamp?>][is_new]" value="<?=($new)?1:0?>" >
	<div class="row">
		<div class="col-md-1">
			<label for="sort_<?=$timestamp?>">Sorrend</label>
			<input type="text" value="<?=($order_sort)?$order_sort:$size_num?>" name="question[<?=$timestamp?>][sort]" id="sort_<?=$timestamp?>" class="form-control">			
		</div>
		<div class="col-md-6">
			<label for="question_<?=$timestamp?>">Kérdés</label>
			<input type="text" value="<?=$question?>" name="question[<?=$timestamp?>][question]" id="question_<?=$timestamp?>" class="form-control">			
		</div>	
		<div class="col-md-3">
			<label for="type_<?=$timestamp?>">Típus</label>
			<select name="question[<?=$timestamp?>][type]" class="form-control itemtypeselect_<?=$timestamp?>" id="type_<?=$timestamp?>">
				<option value="" selected>-- válasszon --</option>
				<option value="radio" <?=($item_type == 'radio')?'selected':''?>>Kiválasztós (egy érték)</option>
				<option value="checkbox" <?=($item_type == 'checkbox')?'selected':''?>>Többlehetőségű (pipálós)</option>
				<option value="text" <?=($item_type == 'text')?'selected':''?>>Érték beírós</option>
			</select>		
		</div>	
		<div class="col-md-2">
			<label for="add_<?=$timestamp?>">&nbsp;</label>
			<button id="add_<?=$timestamp?>" hashkey="<?=$timestamp?>" type="button" class="btn btn-warning btn-sm form-control adder" style="<?=($item_type=='text')?'display:none;':''?>">elem hozzáadása <i class="fa fa-plus"></i></button>	
		</div>
	</div>
	<div class="row elems" id="elemlist_cont_<?=$timestamp?>" style="<?=($item_type=='text')?'display:none;':''?>">
		<div class="head">Elemek</div>
		<div class="elem_items" id="elemlist_<?=$timestamp?>"></div>
	</div>
</div>
<script>
	$(function(){
		$('.ask_<?=$timestamp?> .adder').click(function(){
			getElem( $(this) );
		});

		$('.itemtypeselect_<?=$timestamp?>').change( function(){
			var type = $(this).val();
			
			if (type == 'text') {
				$('#add_<?=$timestamp?>').hide();
				$('#elemlist_cont_<?=$timestamp?>').hide();
			}else{
				$('#add_<?=$timestamp?>').show();
				$('#elemlist_cont_<?=$timestamp?>').show();
			}

		} );

		loadElems<?=$timestamp?>();
	});	

	function loadElems<?=$timestamp?>() {
		$('#elemlist_<?=$timestamp?>').html( '' );
		getElems<?=$timestamp?>( function(){
			$('#elemlist_<?=$timestamp?> .ele-item .del > i').click( function() {
				var c = confirm( 'Biztos, hogy törli ezt az értéket? A művelet visszavonhatatlan!' );

				if( !c ) return false;

				var item_hash = $(this).attr('question-item-hash');
				console.log(item_hash);
				
				$.post('<?=AJAX_POST?>', {
					type : 'votePollActions',
					mode : 'delete',
					what : 'question-item',
					hash : item_hash
				}, function(d){
					alert('Sikeresen töröltük az értéket.');
					loadElems<?=$timestamp?>();
				},"html");				
			});	
		});
	}

	function getElems<?=$timestamp?>( callback ){
		$('#elemlist_<?=$timestamp?>').html( '' );
		$.post('<?=AJAX_GET?>', {
			type : 'loadVotePollItems',
			hash : '<?=$timestamp?>',
			item_type: '<?=$item_type?>'
		}, function(d){
			$('#elemlist_<?=$timestamp?>').append( d );
			callback();
		},"html");
	}
</script>
<style>
	.questions .ask {
		border: 1px solid #d3d3d3;
		border-top:3px solid #898989;
		background: #f3f3f3;
		padding: 10px;
		margin-bottom:8px;
	}	
	.questions .ask div[class*=col-md] {
		padding: 5px;
	}
	.elems .head {
		margin: 0 0 8px 0;
		font-size:15px;
		font-weight: bold;
		color: black;
		text-transform: uppercase;
	}
	.elems .elem_items {
		border:1px solid #ddd;
		background: #e8e8e8;
		padding: 8px;
	}
</style>
