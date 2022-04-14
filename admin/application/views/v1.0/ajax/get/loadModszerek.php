<script type="text/javascript">
	$(function(){
		$('.selModszer select').bind('change',function(){
			loadGyujtok($(this));	
		});
	})
	
	function loadGyujtok(e){
		$.post('/ajax/get/',{
			type : 'loadGyujtok',
			modszerId : e.val()
		},function(d){
			$('.selGyujto.i'+e.attr('index')).html(d);
		},"html");
		
	}
</script>
<select name="modszer[]" id="modszer" index="<?=$this->index?>" class="form-control" style="font-weight:bold;">
    <option value="">-- módszer kiválasztása --</option>
    <option value="" disabled></option>
    <? foreach($this->modszerek as $d): ?>
    <option value="<?=$d['ID']?>"><?=Product::clear($d['neve'])?></option>
    <? endforeach; ?>
</select>