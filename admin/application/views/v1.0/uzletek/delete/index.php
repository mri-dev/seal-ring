<h1><?=$this->shop->getName()?> <small>Üzlet törlése</small></h1>
<div class="panel panel-danger">
	<div class="panel-heading">Biztos benne, hogy törli a(z) <strong><?=$this->shop->getName()?></strong> üzletet és a hozzá kapcsolódó elemeket?</div>
	<div class="panel-body right">		
		<form action="" method="post">
			<a href="/uzletek/" class="btn btn-danger"><i class="fa fa-times"></i> mégse</a>
			<button class="btn btn-success" name="deleteShop">IGEN <i class="fa fa-check"></i></button>
		</form>
	</div>
</div>