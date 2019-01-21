<div style="float:right;">
	<a href="/kuponok/" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1><strong style="color:black;"><u><?=$this->coupon->getCode()?></u></strong> kupon törlése</h1>

<div class="con">
	<form action="" method="post">
		<div class="row">
			<div class="col-sm-10">
				Biztos, hogy törli a(z) <strong>"<?=$this->coupon->getTitle()?>" (<?=$this->coupon->getCode()?>)</strong> kupont?
			</div>
			<div class="col-sm-2 right">
				<div class="">
					<a href="/kuponok" class="btn btn-danger"><i class="fa fa-times"></i> mégse</a>
					<button class="btn btn-success" name="delCoupon" value="1">Végleges törlés <i class="fa fa-trash"></i></button>
				</div>
			</div>
		</div>
	</form>
</div>