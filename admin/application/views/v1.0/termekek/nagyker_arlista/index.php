<script>
	
	$( function(){
		
		$('.actions *[action]').click( function(){
			var id 			= $(this).attr('action-id');
			var action 		= $(this).attr('action');
			var pre_class 	= $(this).find('i').attr('class');
			var result_view = $('#result');
			var v 			= $(this).find('i');
			var is_done 	= $(this).hasClass('done');
			var dn 			= true;
			var alw 		= $(this).hasClass('needAllow');
			var alw_c 		= true;

			v.attr('class','fa fa-refresh fa-spin in-progress');
			result_view.html( "" );

			if( is_done )
			dn = confirm('Már végre lett hajtva ez a művelet! Ismételjük újra?');

			if( !dn ){
				v.attr( 'class', pre_class );
				return false;
			}

			if( alw )
			alw_c = confirm('Biztos benne, hogy végrehajtja a műveletet?');

			if( !alw_c ){
				v.attr( 'class', pre_class );
				return false;
			}

			$.post("<?=AJAX_GET?>",{
				type 	: 'nagykerListaActions',
				fnc 	: action,
				id 		: id
			}, function(d){
				result_view.html( d );
				v.attr( 'class', pre_class );
			},"html");
		});

			})
</script>
<div style="float:right;">
	<a href="/<?=$this->gets[0]?>/" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1>Termékek / Nagyker árlista</h1>
<?=$this->bmsg?>
<div class="row">
	<div class="col-md-7" style="padding-right:0;">
		<div class="con">
			<h2>Nagyker árlisták</h2>
			<div class="nagyker-arlista">
			<? if( count( $this->arlista ) == 0 ): ?>
				Nincs létrehozva nagyker!
			<? else: ?>
				<? foreach( $this->arlista as $lista ): ?>
					<div class="nagyker"><strong><?=$lista[nev]?></strong> (<?=count($lista[lista])?>)</div>
						<div class="nagyker-list">
							<div class="vr-line" style="height: <?=(count($lista[lista])*30-15)?>px;"></div>
							<? foreach( $lista[lista] as $ls ): ?>
							<div class="lista">
								<div class="actions">
									<ul>
										<li action="showListItems" action-id="<?=$ls[ID]?>"><i title="Lista tartalmának megtekintése" class="fa fa-eye" ></i></li>
										<li action="importToDatabase" class="<?=(is_null($ls[imported_at]))?'req':'done'?>" action-id="<?=$ls[ID]?>"><i title="<?=(is_null($ls[imported_at]))?'Betöltés ideiglenes adatbázisba':'Adatbázisba betöltve ekkor: '.$ls[imported_at]?>" class="fa fa-database" ></i></li>
										<li action="checkItems" class="<?=(is_null($ls[refreshed_at]))?'req':'done'?>" action-id="<?=$ls[ID]?>"><i title="<?=(is_null($ls[refreshed_at]))?'Termékek ellenőrzés/vizsgálata és frissítés':'Termékek ára frissítve ekkor: '.$ls[refreshed_at]?>" class="fa fa-refresh" ></i></li>
										<li action="deleteList" class="needAllow" action-id="<?=$ls[ID]?>"><i title="Lista törlése" class="fa fa-times"></i></li>
									</ul>
								</div>
								<div class="hr-line" style=""></div>
								<?=$ls[file_name]?> <em>(<?=Helper::softDate($ls[uploaded_at])?>)</em>
							</div>
							<? endforeach; ?>
						</div>
				<? endforeach; ?>
			<? endif; ?>
			</div>
		</div>
		<div id="result">

		</div>
	</div>
	<div class="col-md-5" style="padding-left:5px;">
		<div class="con">
			<form action="" method="post" enctype="multipart/form-data">
	        	<h3>Nagyker hozzáadása</h3>
	            
	            <div class="row">
	                <div class="col-md-9">
	                    Megnevezés: <input type="text" class="form-control" name="nev" placeholder="nagyker egyedi elnevezése" value="<?=$this->sm[nev]?>">
	                </div>
	                <div class="col-md-3" align="right">
	                <br>
	                	<? if($this->gets[2] == 'szerkeszt'): ?>
	                    <input type="hidden" name="id" value="<?=$this->gets[2]?>" />
	                    <a href="/<?=$this->gets[0]?>/<?=$this->gets[1]?>/"><button type="button" class="btn btn-danger btn-3x"><i class="fa fa-arrow-circle-left"></i> bezár</button></a>
	                    <button name="save" class="btn btn-success">Változások mentése <i class="fa fa-check-square"></i></button>
	                    <? else: ?>
	                    <button name="addNagyker" class="btn btn-primary">Hozzáadás <i class="fa fa-check-square"></i></button>
	                    <? endif; ?>
	                </div>
	            </div>
            </form>
		</div>
		<div class="con">
			<form action="" method="post" enctype="multipart/form-data">
	        	<h3>Lista feltöltés</h3>
	            
	            <div class="row">
	                <div class="col-md-4">
	                    Nagyker: 
	                    <select class="form-control" name="nagyker_id">
	                    	<option value="">-- válassz --</option>
	                    	<option value="" disabled="disabled"></option>
	                    	<? foreach( $this->arlista as $lista ): ?>
								<option value="<?=$lista[ID]?>"><?=$lista[nev]?></option>
							<? endforeach; ?>
	                    </select>
	                </div>
	                <div class="col-md-5">
	                	Lista (.csv): 
	                	<input type="file" name="csv[]" multiple="multiple" class="form-control">
	                </div>
	                <div class="col-md-3" align="right">
	                <br>
	                	<button name="uploadList" class="btn btn-primary">Feltöltés <i class="fa fa-upload"></i></button>
	                </div>
	            </div>
            </form>
		</div>
	</div>
</div>
