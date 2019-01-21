<div style="float:right;">
    <a href="/felhasznalok/containers" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1>Új felhasználói kör létrehozás</h1>
<div class="con">
	<form action="" method="post">
		<div class="row">
			<div class="col-sm-2">
				<label for="nev">Konténer elnevezés</label>
				<input type="text" name="nev" value="<?=$this->container['nev']?>" class="form-control">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">				
				<button class="btn btn-success" name="addContainer" value="1">Létrehozás <i class="fa fa-save"></i></button>
			</div>
		</div>
	</form>
</div>