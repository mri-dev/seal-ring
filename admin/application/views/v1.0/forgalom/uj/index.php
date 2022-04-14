<script type="text/javascript">
	$(function(){
		var view = $('.loadData');
		$('#tipus_kulcs').change(function(){
			view.html('<i class="fa fa-spinner fa-spin"></i> Kis türelmet kérünk...');
			$.post("<?=AJAX_GET?>",{
				type: 'loadTrafficAdder',
				key : $(this).val()
			},function(d){
				view.html(d);
			},"html");
		});
		
	})
</script>
<div style="float:right;">
	<a href="/<?=$this->gets['0']?>/" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> vissza</a>
	<a href="/<?=$this->gets['0']?>/tipus_kulcsok" class="btn btn-default"><i class="fa fa-bars"></i> Forgalom típus kulcsok</a>
</div>
<h1>Új forgalom bejegyzése</h1>

<div class="con">
	<div class="row np" style="padding:15px;">
		<div class="col-md-2 input-txt"><strong>Típus kulcs kiválasztása:</strong></div>
		<div class="col-md-5">
			<select name="tipus_kulcs" class="form-control" id="tipus_kulcs">
				<option value="" selected>-- válasszon --</option>
				<option value="" disabled></option>
				<? $data = $this->kulcsok;
				foreach($data as $d): ?>
				<option value="<?=$d['key']?>"><?=(strpos($d['key'],'income') === 0)?'BEVÉTEL:':'KIADÁS:'?> <?=$d['comment']?> - <?=$d['key']?></option>
				<? endforeach; ?>
			</select>
		</div>
	</div>
	<div class="row np">
		<div class="loadData col-md-12">
			
		</div>
	</div>
</div>