<div style="float:right;">
	<a href="/uzletek/add" class="btn btn-primary"><i class="fa fa-plus"></i> új üzlet</a>
</div>
<h1>Üzletek</h1>
<?=$this->msg?>
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
    		<th width="50" title="Állapot">??</th>
			<th>Üzlet neve</th>
			<th width="120">Üzlet telefon</th>
			<th width="120">Üzlet email</th>
			<th width="120">Típus</th>
			<th width="120">Létrehozó</th>
			<th width="50">Tanácsadók</th>
			<th width="30" title="Ez az üzlet jelenjen meg az üzlet listázásában.">GEO</th>
			<th width="30" title="Helymeghatározó (geolocation) hiányában az alapértelmezett üzlet fog megjelenni.">Alapé.</th>
			<th width="100"><i class="fa fa-gear"></i></th>
        </tr>
	</thead>
    <tbody>
	<? 	foreach( $this->shops as $shop ): ?>
	<? 	$dists = $shop->getDistributors(); ?>
    	<tr>
    		<td class="center">
    			<? if($shop->isActive()): ?> <i class="fa fa-check" title="Ez az elem engedélyezve van!"></i> <? else: ?> <i class="fa fa-power-off" style="color:orange;" title="Még nincs engedélyezve ez az elem!"></i> <? if(!$shop->byAdmin()): ?><i class="fa fa-info-circle" style="color:red;" title="Viszonteladó által jelzett igény!"></i><? endif; ?><? endif; ?>
    		</td>
	    	<td><? if(!$shop->isActive() && !$shop->byAdmin()): ?> <em>(Engedélyre vár)</em> <? endif; ?><strong><?=$shop->getName()?></strong>
				<span style="color: #acacac;">&mdash; <?=$shop->getAddress()?></span>
	    	</td>
	    	<td class="center"><?=$dists[0][telefon]?></td>
	    	<td class="center"><?=$dists[0][email]?></td>
	    	<td class="center"><?=$shop->getType()?></td>
	    	<td class="center"><?=$shop->createFrom()?></td>
	    	<td class="center">
	    		<a href="#" onclick="$('#tv<?=$shop->getID()?>').slideToggle()"><?=count($dists)?> db</a>
	    	</td>
	    	<td class="center">
	    		<? if($shop->isInGEO()): ?><i class="fa fa-check vtgl" title="Aktív / Kattintson az inaktiváláshoz" tid="<?=$shop->getID()?>"></i><? else: ?><i class="fa fa-times vtgl" title="Inaktív / Kattintson az aktiváláshoz" tid="<?=$shop->getID()?>"></i><? endif; ?>
	    	</td>
	    	<td class="center">
	    		<? if($shop->isDefault()): ?>
	    		<i class="fa fa-check"></i>
	    		<? else: ?>
	    		<i class="fa fa-times"></i>
	    		<? endif; ?>
	    	</td>
	    	<td align="center">
	            <div class="dropdown">
	            	<i class="fa fa-list" title="Részletek" onclick="$('#tv<?=$shop->getID()?>').slideToggle()" style="margin-right: 5px;"></i>
	            	<i class="fa fa-gears dropdown-toggle" title="Beállítások" id="dm<?=$shop->getID()?>" data-toggle="dropdown"></i>
	                  <ul class="dropdown-menu" role="menu" aria-labelledby="dm">
	                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/uzletek/distributor/<?=$shop->getID()?>">Tanácsadók kezelése <i class="fa fa-user"></i></a></li>
	                  	<? if($shop->isActive()): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="/uzletek/permission/?shopID=<?=$shop->getID()?>&card=disallow">Engedély visszavonás <i class="fa fa-times"></i></a></li>
	                  	<? else: ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="/uzletek/permission/?shopID=<?=$shop->getID()?>&card=allow">Engedélyezés <i class="fa fa-check"></i></a></li>
	                  	<? endif; ?>
	                  	<li role="separator" class="divider"></li>
	                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/uzletek/edit/?shopID=<?=$shop->getID()?>">Szerkesztés <i class="fa fa-pencil"></i></a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" href="/uzletek/delete/?shopID=<?=$shop->getID()?>">Törlés <i class="fa fa-trash"></i></a></li>
					  </ul>
	            </div>
            </td>
        </tr>
        <tr id="tv<?=$shop->getID()?>" style="display:none;">
        	<td colspan="99">
        		<div class="row np">
        			<div class="col-sm-8 casada-pont">
        				<div class="casada-pont-view">
        					<div class="casada-pont-details details">
								<div class="row np">
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-4">
												<div class="key">Arckép</div>
											</div>
											<div class="col-sm-8">
												<? if( false ): ?>
												<div class="value">
													<form id="form_upload_img_f_<?=$shop->getID()?>" method="post" action="<?=AJAX_POST?>" method="post" enctype="multipart/form-data">
													<input type="hidden" name="path" value="src/profil/">
													<input type="hidden" name="type" value="uploadPlaceLogo">
													<input type="hidden" name="name" value="<?=Helper::makeSafeUrl($shop->getName(),'_logo')?>">
													<div class="image">
														<label for="uploader_<?=$shop->getID()?>" title="Kattintson a kép feltöltéséhez!" style="cursor:pointer;"><img id="upload_img_view_f_<?=$shop->getID()?>" src="<?=$shop->getLogo()?>"></label>
													</div>
													<input type="file" style="display:none;" id="uploader_<?=$shop->getID()?>" name="file" uploadID="<?=$shop->getID()?>">
													</form>
												</div>
												<? endif; ?>
												<div class="value">
													<div class="image">
														<label><img src="/<?=$dists[0][profilkep]?>"></label>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="key">Üzlet neve</div>
											</div>
											<div class="col-sm-8">
												<div class="value"><?=$shop->getName()?></div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="key">Telefonszám</div>
											</div>
											<div class="col-sm-8">
												<div class="value"><?=$shop->getPhone()?></div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="key">Email</div>
											</div>
											<div class="col-sm-8">
												<div class="value"><?=$shop->getEmail()?></div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="key">Üzlet címe</div>
											</div>
											<div class="col-sm-8">
												<div class="value"><?=$shop->getAddress()?></div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="key">Üzlet gps</div>
											</div>
											<div class="col-sm-8">
												<? $gps = $shop->getGPS(); ?>
												<div class="value"><?=$gps[lat]?>,<?=$gps[lng]?></div>
											</div>
										</div>

									</div>
									<div class="col-sm-6">
										<div class="head">Nyitvatartás</div>
										<? foreach ($shop->getOpens() as $dayname => $day): ?>
										<div class="row">
											<div class="col-sm-4">
												<div class="key"><?=$this->daynames[$dayname]?></div>
											</div>
											<div class="col-sm-8">
												<div class="value">
												<? if($day['from'] == 'zárva'): ?>
													zárva
												<? else: ?>
													<?=$day['from']?> &mdash; <?=$day['to']?>
												<? endif; ?>
												</div>
											</div>
										</div>
										<? endforeach; ?>
									</div>
								</div>
							</div>
        				</div>
        			</div>
        			<div class="col-sm-4 right">
        				<div><strong>Tanácsadók:</strong></div>
        				<? foreach( $dists as $d ): ?>
        				<div>&mdash; <?=$d['nev']?> <em>(<?=$d['email']?>)</em></div>
        				<? endforeach; ?>
        			</div>
        		</div>
        	</td>
        </tr>
    <? 	endforeach; ?>
    </tbody>
</table>

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

		$('.termeklista i.vtgl').click(function(){
			visibleToggler($(this));
		});
	})

	function visibleToggler(e){
        var tid = e.attr('tid');
        var src =  e.attr('class').indexOf('check');

        if(src >= 0){
            e.removeClass('fa-check').addClass('fa-spinner fa-spin');
            doVisibleChange(e, tid, false);
        }else{
            e.removeClass('fa-times').addClass('fa-spinner fa-spin');
            doVisibleChange(e, tid, true);
        }
    }

	function doVisibleChange(e, tid, show){
		var v = (show) ? '1' : '0';
		$.post("<?=AJAX_POST?>",{
			type : 'casadashopChangeActions',
			mode : 'IO',
			id 	: tid,
			val : v
		},function(d){
			if(!show){
				e.removeClass('fa-spinner fa-spin').addClass('fa-times');
			}else{
				e.removeClass('fa-spinner fa-spin').addClass('fa-check');
			}
		},"html");
	}

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
