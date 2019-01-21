<div style="float:right;">
	<a href="/uzletek/" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1><?=$this->shop->getName()?> <small>Üzlet / Casada Pont szerkesztése</small></h1>
<div class="casada-pont con">
<div class="row">
	<? if( false ): ?>
	<div class="col-sm-2">
		<div class="img-select">
			<h4>Profil fotó</h4>
			<form id="form_upload_img_f_<?=$this->shop->getID()?>" action="<?=AJAX_POST?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="path" value="src/profil/">
				<input type="hidden" name="type" value="uploadPlaceLogo">
				<input type="hidden" name="name" value="<?=Helper::makeSafeUrl($this->shop->getName(),'_logo')?>">
				<label for="uploader_<?=$this->shop->getID()?>" title="Kattintson a kép feltöltéséhez!" style="cursor:pointer;">
					<img src="<?=$this->shop->getLogo()?>" alt="Profilkép">
				</label>						
				<input type="file" style="display:none;" name="file" id="uploader_<?=$this->shop->getID()?>" uploadID="<?=$this->shop->getID()?>">				
			</form>
		</div>
	</div>
<? endif; ?>

	<form method="post" action="">
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-12">
				<h4>Általános adatok</h4>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-dot-circle-o"></i> Casada Pont elnevezés:</span>
					<input type="text" class="form-control" name="place[name]" value="<?=$this->shop->getName()?>" required>
					<span></span>
				</div>
			</div>				
		</div>
		<br>
		<div class="row">
			<? $addr = $this->shop->getAddressObj(); ?>
			<div class="col-sm-2" style="line-height: 26px;"><i class="fa fa-map-marker"></i> Üzlet címe:</div>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="place[irsz]" placeholder="irányítószám" value="<?=$addr->irsz?>" required>
				<span></span>
			</div>	
			<div class="col-sm-6">
				<input type="text" class="form-control" name="place[city_address]" placeholder="város, utca/közterület neve" value="<?=$addr->address?>" required>
				<span></span>
			</div>	
			<div class="col-sm-2">
				<input type="text" class="form-control" name="place[address_number]" placeholder="házszám" value="<?=$addr->hsz?>" required>
				<span></span>
			</div>					
		</div>	
		<br>				
		<div class="row">
			<? $gps = $this->shop->getGPS(); ?>
			<div class="col-sm-4" style="line-height: 26px;"><i class="fa fa-globe"></i> Üzlet GPS koordináták:</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="place[gps][lat]" value="<?=$gps[lat]?>" placeholder="szélesség" required>
				<span></span>
			</div>	
			<div class="col-sm-4">
				<input type="text" class="form-control" name="place[gps][lng]" value="<?=$gps[lng]?>" placeholder="hosszúság" required>
				<span></span>
			</div>				
		</div>
	</div>
	<div class="col-sm-6">
		<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<h4>Nyitvatartás</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<? $opens = $this->shop->getOpens(); ?>
				<div class="opens">
					<div class="when"><div class="text">Hétfő</div></div>
					<div class="from">
						<select name="opens[hetfo][from]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['hetfo']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens[hetfo][to]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['hetfo']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
				<div class="opens">
					<div class="when"><div class="text">Kedd</div></div>
					<div class="from">
						<select name="opens[kedd][from]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['kedd']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens[kedd][to]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['kedd']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
				<div class="opens">
					<div class="when"><div class="text">Szerda</div></div>
					<div class="from">
						<select name="opens[szerda][from]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['szerda']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens[szerda][to]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['szerda']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
				<div class="opens">
					<div class="when"><div class="text">Csütörtök</div></div>
					<div class="from">
						<select name="opens[csutortok][from]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['csutortok']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens[csutortok][to]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['csutortok']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-6">					
				<div class="opens">
					<div class="when"><div class="text">Péntek</div></div>
					<div class="from">
						<select name="opens[pentek][from]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['pentek']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens[pentek][to]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['pentek']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>

				<div class="opens">
					<div class="when"><div class="text">Szombat</div></div>
					<div class="from">
						<select name="opens[szombat][from]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['szombat']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens[szombat][to]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['szombat']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>

				<div class="opens">
					<div class="when"><div class="text">Vasárnap</div></div>
					<div class="from">
						<select name="opens[vasarnap][from]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['vasarnap']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens[vasarnap][to]">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['vasarnap']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4>Egyéb</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2" style="line-height: 26px;">
				Sorrend
			</div>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="place[sorrend]" value="<?=$this->shop->getIndex()?>">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2" style="line-height: 26px;">
				Típus
			</div>
			<div class="col-sm-6">
				<select name="place[tipus]" id="" class="form-control">
					<option value="shop" <?=($this->shop->getTypeData() == 'shop')?'selected="selected"':''?>>Hivatalos üzlet</option>
					<option value="casadapont" <?=($this->shop->getTypeData() == 'casadapont')?'selected="selected"':''?>>Casada Pont</option>
				</select>
			</div>
		</div>
	</div>
	</div>
</div>
<br>
<div class="divider"></div>
<br>
<div class="row np">
	<div class="col-sm-12 right">
		<button class="btn btn-success" name="editShop" value="1">Változások mentése <i class="fa fa-save"></i></button>
	</div>
</div>
</form>

</div>

<script type="text/javascript">
	$(function(){
		$('*[uploadID]').change(function(){			
			var form = $(this).attr('uploadID');

			var reg=/(.jpg|.gif|.png)$/;
		    if (!reg.test($(this).val())) {
		        alert('A kiválasztott fájl nem képforműtum. Engedélyezve: .jpg, .gif, .png');
		        return false;
		    }

			uploadLogo(form);
		});
	})

	function uploadLogo (form) {
		$('#form_upload_img_f_'+form).ajaxSubmit({
	        dataType: 'json',
	        success: function(data, statusText, xhr, wrapper){

	        	if ( !data.success ) {
	        		alert(data.msg);
	        	} else {
	        		savePlaceLogoURL( form, data.file, function(r){
	        			$('#upload_img_view_f_'+form).attr('src', data.file);
	        			alert('Fájl sikeresen feltöltve!');
	        		});	        		
	        	}

	        }
	    });
	}

	function savePlaceLogoURL ( placeID, logo_src, callback ) {
		$.post('<?=AJAX_POST?>',{
			type : 'savePlaceLogoURL',
			placeID: placeID,
			src: logo_src
		}, function( data ){
			callback( data );
		},"html");
	}
</script>