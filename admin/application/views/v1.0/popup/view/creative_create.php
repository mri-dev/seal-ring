<h2> <a href="/popup/" class="btn btn-sm btn-default"><i class="fa fa-long-arrow-left"></i></a> Új kreatív létrehozása  <span>/ Kreatívok</span></h2>
<?=$this->msg?>
<br>
<form method="post" action="">
	<div class="con">
		<div class="row">
			<div class="col-sm-6">
				<label>Elnevezés</label>
				<input type="text" class="form-control" name="name" value="<?=$_POST['name']?>">
			</div>
			<div class="col-sm-6">
				<label>Időtartam</label>
				<div class="input-group">
					<input type="date" class="form-control" name="active_from" value="<?=$_POST['active_from']?>">
					<span class="input-group-addon"> &mdash; </span>
					<input type="date" class="form-control" name="active_to" value="<?=$_POST['active_to']?>">
				</div>
				
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-6">
				<label>Aktivitás URL</label>
				<input type="text" class="form-control" name="check_url" value="<?=$_POST['check_url']?>">
			</div>
			<div class="col-sm-6">
				<label>Esemény típusa</label>
				<select class="form-control" name="type" onchange="switchFormView($(this).val());">
					<option value="" selected="selected">-- válasszon --</option>
					<option value="exit" <?=(isset($_POST['type']) && $_POST['type'] == 'exit')?'selected="selected"':''?>>Kilépési szándék</option>
					<option value="scroll" <?=(isset($_POST['type']) && $_POST['type'] == 'scroll')?'selected="selected"':''?>>Ablak görgetés</option>
					<!-- <option value="area" <?=(isset($_POST['type']) && $_POST['type'] == 'area')?'selected="selected"':''?>>Tartomány aktivitás</option>-->
					<option value="timed" <?=(isset($_POST['type']) && $_POST['type'] == 'timed')?'selected="selected"':''?>>Időzített</option>
				</select>
			</div>
		</div>
		<div class="formview" id="fv-timed" style="display: none;">		
			<br>
			<div class="divider"></div>
			<h4>Időzített esemény beállításai</h4>
			<br>
			<div class="row">				
				<div class="col-sm-4">
					<label>Késleltetés oldalbetöltéstől</label>
					<div class="input-group">
						<input type="number" class="form-control" name="settings['type']['timed']['timed_delay_sec']" value="<?=(isset($_POST['settings']['type']['timed']['timed_delay_sec']))? $_POST['settings']['type']['timed']['timed_delay_sec'] : 10 ?>">
						<span class="input-group-addon">másodperc</span>
					</div>		
				</div>
			</div>
			<br>
			<div class="divider"></div>
		</div>
		<div class="formview" id="fv-scroll" style="display: none;">		
			<br>
			<div class="divider"></div>
			<h4>Ablak görgetés esemény beállításai</h4>
			<br>
			<div class="row">				
				<div class="col-sm-4">
					<label>Mikor jelenjen meg a tartalom?</label>
					<div class="input-group">
						<input type="number" class="form-control" name="settings['type']['scroll']['scroll_percent_point']" value="<?=(isset($_POST['settings']['type']['scroll']['scroll_percent_point']))? $_POST['settings']['type']['scroll']['scroll_percent_point'] : 50 ?>">
						<span class="input-group-addon">% legörgetés után</span>
					</div>	
					<em>A weboldal tartalom magassága a 100%.</em>	
				</div>
			</div>
			<br>
			<div class="divider"></div>
		</div>
		<div class="formview" id="fv-exit" style="display: none;">		
			<br>
			<div class="divider"></div>
			<h4>Kilépési szándék esemény beállításai</h4>
			<br>
			<div class="row">				
				<div class="col-sm-6">
					<label>Esemény késleltetés</label>
					<div class="input-group">
						<input type="number" class="form-control" name="settings['type']['exit']['exit_pause_delay_sec']" value="<?=(isset($_POST['settings']['type']['exit']['exit_pause_delay_sec']))? $_POST['settings']['type']['exit']['exit_pause_delay_sec'] : 10 ?>">
						<span class="input-group-addon">másodperc</span>
					</div>	
					<em>Oldalbetöltés után ennyi idő elteltével aktív az esemény.</em>	
				</div>
			</div>
			<br>
			<div class="divider"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3">
				<label>Időtartam 2 megjelenítés között</label>
				<div class="input-group">
					<input type="number" class="form-control" name="settings['view_sec_btw']" value="<?=(isset($_POST['settings']['view_sec_btw']))? $_POST['settings']['view_sec_btw'] : 60 ?>">
					<span class="input-group-addon">másodperc</span>
				</div>
				<em>60 = 1 perc, 3600 = 1 óra, 86400 = 1 nap</em>
			</div>	
			<div class="col-sm-3">
				<label>Maximális megjelenés</label>
				<div class="input-group">
					<input type="number" class="form-control" name="settings['view_max']" value="<?=(isset($_POST['settings']['view_max']))? $_POST['settings']['view_max'] : 10 ?>">
					<span class="input-group-addon"> / felhasználó</span>
				</div>
			</div>		
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<label>Állapot</label>	
				<select class="form-control" name="active">
					<option value="0" <?=(isset($_POST['active']) && $_POST['active'] == 0)?'selected="selected"':'selected="selected"'?>>Inaktív</option>
					<option value="1" <?=(isset($_POST['active']) && $_POST['active'] == 1)?'selected="selected"':''?>>Aktív</option>
				</select>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<button class="btn btn-success" name="createCreative" value="1">Létrehozás</button>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	function switchFormView(v) {
		$('.formview').hide(0);

		$('.formview#fv-'+v).show(0);
	}
</script>