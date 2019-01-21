<div class="divider"></div>
<script type="text/javascript">
	$(function(){
		$( "#date" ).datepicker({
		  dateFormat: "yy-mm-dd",
		  defaultDate: "+1w",
		  changeMonth: true,
		  numberOfMonths: 1,
		  onClose: function( selectedDate ) {
			$( "#dateTo" ).datepicker( "option", "minDate", selectedDate );
		  }
		});
		var regTrafficProgress = false;
		$('#regTraffic').click(function(){
			var text 	= $('#megjegyzes').val();
			var date 	= $('#date').val();
			var ertek 	= $('#ertek').val();
			var hour 	= $('#hour').val();
			var key 	= $('#kulcs').val();
			var mode 	= $('#mode').val();
			
			if(key == ''){ 
				alert('Forgalom típus kulcs hiányzik!');
				return false;
			}
			if(text == ''){ 
				alert('Forgalom bejegyzéséhez szükséges a bejegyzés megjegyzése!');
				return false;
			}
			if(ertek == ''){ 
				alert('Forgalom bejegyzéséhez szükséges a forgalom értékének megadása!');
				return false;
			}
			if(date == ''){ 
				alert('Forgalom bejegyzéséhez szükséges az időpont kiválasztása (tárgyi nap)!');
				return false;
			}
			
			if(!regTrafficProgress){
				var bevetel = 0;
				var kiadas 	= 0;
				
				if(mode == 'bevetel'){
					bevetel = ertek;
				}else if(mode == 'kiadas'){
					kiadas = ertek;
				}
				
				regTrafficProgress = true;
				console.log('Started');
				var parent = $(this)
					.html('<i class="fa fa-spinner fa-spin"></i> folyamatban')
					.css('disabled',true)
					.removeClass('btn-primary')
					.addClass('btn-default');
					
				$.post("/ajax/traffic",{
					action 	: 'add',
					type 	: key,
					bevetel : bevetel,
					kiadas 	: kiadas,
					text 	: text,
					date 	: date + " " + hour
				},function(d){
					console.log(d);
					$('#msg').html(d);
					parent
						.html('Forgalom bejegyzése <i class="fa fa-check-square"></i>')
						.css('disabled',false)
						.removeClass('btn-default')
						.addClass('btn-primary');
						
					regTrafficProgress = false;
				},"html");
			}
		});
	})
</script>
<br />
<h3><?=(strpos($this->key,'income') === 0)?'<span style="color:green;">Új bevétel bejegyzés</span>':'<span style="color:red;">Új kiadás bejegyzés</span>'?></h3>
<div class="row np">
	<input type="hidden" id="mode" value="<?=(strpos($this->key,'income') === 0)?'bevetel':'kiadas'?>" />
	<input type="hidden" id="kulcs" value="<?=$this->key?>" />
	<div class="col-md-12">
		<? $data = $this->kulcsok[Helper::getFromArrByAssocVal($this->kulcsok,'key',$this->key)]?>
		<br />
		<div class="row">
			<div class="col-md-2 input-txt"><strong>Megjegyzés:</strong></div>
			<div class="col-md-5"><input type="text" id="megjegyzes" class="form-control" value="<?=$data[comment]?>" /></div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-2 input-txt"><strong>Érték:</strong></div>
			<div class="col-md-2">
				<div class="input-group">
					<input type="number" id="ertek" class="form-control" value="0" />
					<span class="input-group-addon">Ft</span>
				</div>
			</div>
		</div>
		<br />
		<div class="row np">
			<div class="col-md-2 input-txt"><strong>Időpont:</strong></div>
			<div class="col-md-2">
				<input type="text" id="date" class="form-control" value="<?=date('Y-m-d')?>" />
			</div>
			<div class="col-md-1" style="padding-left:15px;">
				<input type="text" id="hour" class="form-control" value="<?=date('H:i')?>" />
			</div>
			<div class="col-md-7" align="right">
				<button class="btn btn-primary" id="regTraffic">Forgalom bejegyzése <i class="fa fa-check-square"></i></button>
				<div id="msg"></div>
			</div>
		</div>
	</div>
</div>