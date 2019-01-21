<div style="float:right;">
    <a href="/felhasznalok/containers" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1><?=$this->container['nev']?> <span>felhasználói kör törlése</span></h1>
<div class="con">
	<form action="" method="post">
		<strong>Biztos benne, hogy törli a konténert? A művelet nem visszavonható!</strong>
		<br><br>
		<div class="row">
			<div class="col-sm-12">	
				<a href="/" class="btn btn-danger">mégse</a> <button class="btn btn-success" name="delContainer" value="<?=$this->container['ID']?>">IGEN <i class="fa fa-check"></i></button>
			</div>
		</div>
	</form>
</div>