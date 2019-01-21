<h2> <a href="/popup/?v=creative&c=<?=$this->creative->getID()?>" class="btn btn-sm btn-default"><i class="fa fa-long-arrow-left"></i></a> Új megjelenés létrehozása  <span>/ <?=$this->creative->getName()?> / Kreatívok</span></h2>
<?=$this->msg?>
<br>
<form method="post" action="">
	<div class="con">
		<div class="row">
			<div class="col-sm-6">
				<label>Elnevezés</label>
				<input type="text" class="form-control" name="name" value="<?=$_POST[name]?>">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-6">
				<label>Megjelenési arány</label>
				<input type="number" step="1" class="form-control" name="use_weight" value="<?=(isset($_POST[name]))? $_POST[name] : 1?>">
				<em>Egymáshoz viszonyított arányok.</em>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<label>Állapot</label>	
				<select class="form-control" name="active">
					<option value="0" <?=(isset($_POST[active]) && $_POST[active] == 0)?'selected="selected"':'selected="selected"'?>>Inaktív</option>
					<option value="1" <?=(isset($_POST[active]) && $_POST[active] == 1)?'selected="selected"':''?>>Aktív</option>
				</select>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<button class="btn btn-success" name="createScreen" value="1">Létrehozás</button>
			</div>
		</div>
	</div>
</form>