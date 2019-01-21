<div style="float:right;">
	<a href="/atiranyitas/" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1>Átirányítás törlése <span>Átirányítás</span></h1>

<div class="con">
	<form action="" method="post">
		<div class="row">
			<div class="col-sm-10">
				Biztos, hogy törli a(z) <strong><?=$this->redirect['watch']?></strong> => <strong><?=$this->redirect['redirect_to']?></strong> átirányítást?
			</div>
			<div class="col-sm-2 right">
				<div class="">
					<a href="/atiranyitas" class="btn btn-danger"><i class="fa fa-times"></i> mégse</a>
					<button class="btn btn-success" name="delRedirect" value="1">Végleges törlés <i class="fa fa-trash"></i></button>
				</div>
			</div>
		</div>
	</form>
</div>