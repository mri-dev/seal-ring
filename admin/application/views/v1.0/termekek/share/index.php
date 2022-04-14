<h1>Megosztás facebook oldalon</h1>
<div class="con">
	<div class="row">
		<div class="col-md-12">
			<?=$this->fb_login_status?>
		</div>
	</div>
</div>
<?=$this->bmsg?>
<div class="row">
	<? if( $this->fb_status ): ?>
	<div class="col-md-6">
		<div class="con">
			<h3>Bejegyzés adatok</h3>
			<br>
			<form method="post" action="">
				<div class="row">
					<div class="col-md-3 input-txt">Bejegyzés szövege:</div>
					<div class="col-md-9"><textarea class="form-control" ng-model="fb_message" <? if( $this->got_product ): ?>ng-init="fb_message='<?=$this->termek['full_name']?> termék elérhető a webáruházunkban! Megvásárolható a követlező linre kattintva:'" <? endif; ?> name="message"><? if( $this->got_product ): ?><?=$this->termek['full_name']?> termék elérhető a webáruházunkban! Megvásárolható a követlező linre kattintva:<? endif; ?></textarea></div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-3 input-txt">URL:</div>
					<div class="col-md-9"><input type="text" class="form-control" ng-model="fb_url" <? if( $this->got_product ): ?>ng-init="fb_url='<?=DOMAIN?>t/<?=Helper::makeSafeUrl($this->termek['full_name'], '_-'.$this->termek['termek_ID'])?>'" value="<?=DOMAIN?>t/<?=Helper::makeSafeUrl($this->termek['full_name'], '_-'.$this->termek['ID'])?>" <? endif; ?> name="url" ></div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-3 input-txt">Kép:</div>
					<div class="col-md-9"><input type="text" class="form-control" ng-model="fb_image" <? if( $this->got_product ): ?>ng-init="fb_image='<?=$this->termek['profil_kep']?>'" value="<?=$this->termek['profil_kep']?>" <? endif; ?> name="image" ></div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-3 input-txt">Megosztási felület:</div>
					<div class="col-md-9">
						<select class="form-control" name="post_to">
							<option value="316381051873841">goldfishing.hu facebook oldal</option>
						</select>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12 right">
						<button class="btn btn-primary" name="shareProduct" value="1">Megosztás <i class="fa fa-share"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="con">
			<h3>Előnézet</h3>
			<br>
			<div class="fb-preview">
				<div class="msg">{{ fb_message }}</div>
				<div class="url"><a href="{{ fb_url }}">{{ fb_url }}</a></div>
				<div class="img"><img src="{{ fb_image }}"></div>				
			</div>	
		</div>
	</div>
	<? else: ?>
	<div class="center col-md-12" style="padding:25px;">
		<h4>Csatlakozás szükséges facebook applikáción keresztül!</h4>
	</div>
	<? endif; ?>
</div>