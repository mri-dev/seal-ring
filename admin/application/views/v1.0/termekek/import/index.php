<div style="float:right;">
	<a href="/<?=$this->gets[0]?>/" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1>Termékek importálása</h1>
<?=$this->msg?>

<div class="row np">
	<div class="col-md-6">
		<div class="con">
			<h3>Online terméklista elérhetősége <span class="info">Online lista esetén nem szükséges a manuális feltöltés. A lista betöltésekor a friss adatokat tartalmazza. A listát harmadik fél szolgáltatja, rendszerint a nagykereskedelmek, raktárkezelők.</span></h3>
			<form method="post" action="/termekek/import/">
				<div class="input-group">
					<input class="form-control" name="import_online_xml" id="import_online_xml" placeholder="termék lista url elérhetősége...(.xml)" type="text" value="<?=$this->settings['products_list_xml_url']?>"/>
					<span class="input-group-btn">
						<button type="button" id="check_link" class="btn btn-default" title="Link vizsgálata"><i class="fa fa-eye"></i></button>
						<button name="save_online_xml_url" value="1" class="btn btn-success">Link mentése</button>
					</span>
				</div>
				<div class="clr"></div>
				<? if( $this->url_result ): ?>
				<div class="url-result-view <?=($this->url_result['header_code'] != 200)?'not-ok':''?>">
					<div class="title">Link vizsgálatának eredménye:</div>
					<div class="result">
						<div>Válaszkód: <strong><?=$this->url_result['header_code']?></strong> (<?=$this->url_result[0]?>)</div>
						<div>Típus: <strong><?=$this->url_result['Content-Type']?></strong></div>
						<div>Méret: <strong><?=number_format( $this->url_result['Content-Length'] / 1024 / 1024, 3, "."," ")?> MB</strong></div>
					</div>
					<div class="exit">
						<a href="/termekek/import/">[bezárás]</a>
					</div>
				</div>
				<? endif; ?>
			</form>
		</div> 
	</div>
	<div class="col-md-6">
		<div class="con">
			<h3>Lista feltöltése <span class="path"><i class="fa fa-folder"></i> <?=SOURCE?>uploaded_files/...</span></h3>
			<div>
				<form enctype="multipart/form-data" action="" method="post">
					<div class="upload-file">
						<div class="input-group">
							<input type="file" name="xml" class="form-control">
							<span class="input-group-btn">
								<button name="upload_xml" value="1" class="btn btn-default">Feltöltés</button>
							</span>
						</div>						
					</div>
					<br>
					<?
						$xml_files = $this->uploaded_files->getFolderItems( array(
							'allowedExtension' => 'xml|json'
						) );
					?>
					<h3>Feltöltött listák</h3>
					<div class="uploaded-files">
						<? if (!$xml_files) { ?>
						<div class="no-result">Nincs lista feltöltve!</div>
						<? } ?>						
						<? foreach( $xml_files as $files ): ?>
						<div class="file">
							<div class="delete"><a title="Fájl törlése" href="?delete_file=<?=$files['src_path']?>"><i class="fa fa-times"></i></a></div>
							<i class="fa fa-file-o"></i> 
							<span class="name"><?=$files['name']?></span> &bull; 
							<span class="time"><?=date('Y/m/d H:i',$files['time'])?></span> &bull; 
							<span class="size"><?=number_format($files['sizes']['mb'], 3, ".", " " )?> MB</span> 
						</div>
						<? endforeach; ?>					
					</div>
				</form>
			</div>	
		</div>
	</div>
</div>

<div class="row np">
	<div class="col-md-12">
		<div class="con">
			<h3>Termékek importálása <span class="info">FIGYELEM! Nagy fájlok esetén a betöltés több időt vehet igénybe!</span></h3>
			<fieldset class="block">
				<legend>Lista előnézet, betöltés</legend>
				<div>

					<div class="row np">
						<div class="form-group">
							<label for="" class="col-sm-1 control-label">Forrás fájl</label>
							<div class="col-sm-5">
						    	<select class="form-control" id="selectfromfile">
						    		<option value="">-- válasszon --</option>
						    		<option value="" disabled="disabled"></option>
						    		<option value="online" <?=($_GET['srcby'] == 'online')?'selected="selected"':''?>>Online lista</option>
						    		<option value="offline" <?=($_GET['srcby'] == 'offline')?'selected="selected"':''?>>Feltöltött lista</option>
						    	</select>
						   	</div>
						</div>
					</div>

					<div id="selectfilemore" style="<?=( !$this->xml_import_check ) ? 'display:none;':''?>">
						<div class="row">	
							<div id="selectfile_offline" style="<?=( !$this->xml_import_check ) ? 'display:none;':''?>">
								<div class="form-group">
									<label for="" class="col-sm-1 control-label">Fájl kiválasztása</label>
									<div class="col-sm-5">
								    	<select class="form-control" id="selectfile_offline_src">
								    		<option value="">-- válasszon --</option>
								    		<option value="" disabled="disabled"></option>
								    		<? foreach( $xml_files as $files ): ?>
								    		<option value="<?=SOURCE.str_replace('src/','',$files['src_path'])?>" <?=($_GET['srcby'] == 'offline' && $_GET['file'] == SOURCE.str_replace('src/','',$files['src_path']))?'selected="selected"':''?>><?=$files['name']?> (<?=date('Y/m/d H:i',$files['time'])?>)</option>											
											<? endforeach; ?>
								    	</select>
								   	</div>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="form-group">
								<label for="" class="col-sm-1 control-label">Művelet</label>
								<div class="col-sm-5">
							    	<select class="form-control" id="selectfile_action">
							    		<option value="1">Kiértékelés és feldolgozás műveletek</option>
							    		<option value="2">*Kiértékelés, elemek listázása és feldolgozás műveletek</option>
							    	</select>
							    	<em>* Elemek listázásánál az elemek mennyiségétől függően, több időbe telhet a kilistázás.</em>
							   	</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 right">
								<button onclick="load_list_preview();" class="btn btn-success">Lista előnézet <i class="fa fa-eye"></i></button>
							</div>
						</div>
					</div>

				</div>
			</fieldset>
			<div class="xml-list-result">
			<? if( $this->gets[2] == 'preview' ): ?>

				<? if( $_GET['file'] != '' && !$this->xml_import_check ):  ?>
				<div class="no-result">
					A kiválaszott lista nem elérhető, hibás vagy nem tartalmaz adatokat! <br>
					<small>(<?=$_GET['file']?>)</small>
				</div>
				<? else: ?>
					<h1>Lista összefoglaló</h1>
					<ul class="statuses">
						<li class="total">
							<div class="num"><?=$this->xml_import_check['total_items']?> db</div>
							<div class="text">termék a listában</div>
						</li><li class="total_exists">
							<div class="num"><?=$this->xml_import_check['total_exists']?> db</div>
							<div class="text">termék már feltöltve</div>
						</li><li class="total_need_update">
							<div class="num"><?=$this->xml_import_check['total_need_update']?> db</div>
							<div class="text">termék frissítésre szorul</div>
						</li><li class="total_not_exists">
							<div class="num"><?=$this->xml_import_check['total_not_exists']?> db</div>
							<div class="text">új termék</div>
						</li>
					</ul>
					<div class="actions">
						<h4>Műveletek</h4>
						<div>
							<form action="" method="post">
								<input type="hidden" name="action_do" value="1">
								<input type="submit" value="Új termékek betöltése az adatbázisba" <?=($this->xml_import_check['total_not_exists'] == 0)?'disabled="disabled"':''?> name="create_new_products">
								<input type="submit" value="Frissítendő termékek frissítése" <?=($this->xml_import_check['total_need_update'] == 0)?'disabled="disabled"':''?> name="only_update_products">
							</form>
						</div>
					</div>
					<? if( $this->xml_import_check && $_GET['showlist'] == 2): ?>
					<div class="items">
						<h4>Interakcióra váró lista elemek</h4>
						<table class="table termeklista  table-bordered">
							<thead>
								<tr>
									<th width="150">Cikkszám <?=\PortalManager\Formater::tooltip('A forrás articleid és variantid együttese! <br><br> articleid-variantid')?></th>
									<th>Termék</th>
									<th width="100">Méret</th>
									<th width="150">Szín</th>
									<th width="120">Nettó ár</th>
									<th width="120">Bruttó ár</th>
									<th width="80">articleid</th>
									<th width="80">variantid</th>
									<th width="80">number</th>
								</tr>
							</thead>
							<tbody>
								<? foreach( $this->xml_import_check['list'] as $item ): if( $item['status']['need_update'] == 0 && ($item['status']['need_update'] == 0 && $item['status']['exists'] == 1) ) continue; ?>
								<tr class="<?=($item['status']['exists'] == 1) ? (($item['status']['need_update'] == 1) ? 'want-update' : 'exists') : 'not-exists' ?>">
									<td class="center"><?=$item['data']['cikkszam']?></td>
									<td class="<?=(in_array('rovid_leiras', $item['status']['update_rows']) || in_array('nev', $item['status']['update_rows']))?'wupdate':''?>">
										<strong><?=(in_array('nev', $item['status']['update_rows']))?'(<strike>'.$item['status']['exists_db_data']['nev'].'</strike>)':''?><?=$item['data']['nev']?></strong>
										<div class="desc"><em><?=(in_array('rovid_leiras', $item['status']['update_rows']))?'(<strike>'.$item['status']['exists_db_data']['rovid_leiras'].'</strike>)':''?><?=$item['data']['rovid_leiras']?></em></div>
										<div class="desc"><?=$item['data']['kategoria_hashkeys']?></div>
									</td>
									<td class="center <?=(in_array('meret', $item['status']['update_rows']))?'wupdate':''?>">
									<?=(in_array('meret', $item['status']['update_rows']))?'(<strike>'.$item['status']['exists_db_data']['meret'].'</strike>)':''?>
									<?=$item['data']['meret']?></td>
									<td class="center <?=(in_array('szin', $item['status']['update_rows']))?'wupdate':''?>">
									<?=(in_array('szin', $item['status']['update_rows']))?'(<strike>'.$item['status']['exists_db_data']['szin'].'</strike>)':''?>
									<?=$item['data']['szin']?></td>
									<td class="center <?=(in_array('netto_ar', $item['status']['update_rows']))?'wupdate':''?>">
									<?=(in_array('netto_ar', $item['status']['update_rows']))?'(<strike>'.$item['status']['exists_db_data']['netto_ar'].'</strike>)':''?>
									<?=$item['data']['netto_ar']?>
									</td>
									<td class="center <?=(in_array('brutto_ar', $item['status']['update_rows']))?'wupdate':''?>"><?=$item['data']['brutto_ar']?></td>
									<td class="center "><?=$item['data']['raktar_articleid']?></td>
									<td class="center "><?=$item['data']['raktar_variantid']?></td>
									<td class="center "><?=$item['data']['raktar_number']?></td>
								</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					</div>
					<? endif; ?>
				<? endif; ?>

			<? endif; ?>
			</div>
		</div>		
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('#check_link').click(function(){
			var url = $('#import_online_xml').val();
			
			if ( url ) {
				document.location.href = '/termekek/import/?checkurl='+url;
			}
		});

		$('#selectfromfile').change( function(){
			var val = $(this).val();

			if( val == 'offline'){
				$('#selectfilemore').show();
				$('#selectfile_offline').show();
			} else if( val == 'online') {
				$('#selectfilemore').show();
				$('#selectfile_offline').hide();
			} else {
				$('#selectfilemore').hide();
				$('#selectfile_offline').hide();
			}
		} );


	})

	function load_list_preview () {
		var val = $('#selectfromfile').val();

		if( val == 'offline'){
			document.location.href = '/termekek/import/preview/?file='+$('#selectfile_offline_src').val()+'&srcby=offline&showlist='+$('#selectfile_action').val();
		} else if( val == 'online') {
			document.location.href = '/termekek/import/preview/?file='+$('#import_online_xml').val()+'&srcby=online&showlist='+$('#selectfile_action').val();
		} else {
			return false;
		}
	}
</script>