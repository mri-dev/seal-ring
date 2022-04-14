<script type="text/javascript">
	$(function(){
		$('.ctLoadAjxModszer input[type=checkbox]').click(function(){
			doModszerKat($(this));
		});	
	})
	function doModszerKat(e){
		var tid 	= '<?=$this->tid?>';
		var mod 	= e.attr('mod');
		var mid 	= e.attr('mid');
		var gyid 	= e.attr('gyid');
		var onoff 	= e.is(':checked');
		
		gyid = (typeof gyid === 'undefined') ? null : gyid;
		
		$.post('<?=AJAX_POST?>',{
			type : 'termekChangeActions',
			mode : 'putInKategoria',
			mod  : mod,
			mid  : mid,
			gyid : gyid,
			tid  : tid,
			add  : onoff
		},function(d){
			console.log('mod: '+mod+', mid: '+mid+', gyid: '+gyid+', tid: '+tid+' = '+onoff);
		},"html");
	}
</script>
<div class="ctLoadAjxModszer">
	<? foreach($this->modszerek as $d): ?>
    <div class="m">
    	<label><input type="checkbox" mod="modszer" mid="<?=$d['ID']?>" <?=(in_array($d['ID'],$this->modsz))?'checked':''?>> <?=Product::clear($d['neve'])?></label>
        <? if(count($this->gyujtok[$d['neve']]) > 0): foreach($this->gyujtok[$d['neve']] as $gy): ?>
        <div class="gy">
        	<label><input type="checkbox" mod="gyujto" mid="<?=$d['ID']?>" gyid="<?=$gy['ID']?>" <?=(in_array($d['ID'].'_'.$gy['ID'],$this->mod_gyujt))?'checked':''?>> <?=Product::clear($gy['neve'])?></label>
        </div>
        <? endforeach; endif;?>
    </div>
    <? endforeach; ?>
</div>