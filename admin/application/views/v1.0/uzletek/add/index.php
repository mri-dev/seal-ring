<div style="float:right;">
	<a href="/uzletek/" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1>Új üzlet létrehozása</h1>
<div class="casada-pont con">
<div class="row">
	<form method="post" action="">
	<div class="col-sm-8">
		<div class="row">
			<div class="col-sm-12">
				<h4>Általános adatok</h4>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-dot-circle-o"></i> Casada Pont elnevezés:</span>
					<input type="text" class="form-control" name="place['name']" value="<?=$this->shop->getName()?>" required>
					<span></span>
				</div>
			</div>				
		</div>
		<br>
		<div class="row">
			<? $addr = $this->shop->getAddressObj(); ?>
			<div class="col-sm-2" style="line-height: 26px;"><i class="fa fa-map-marker"></i> Üzlet címe:</div>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="place['irsz']" placeholder="irányítószám" value="<?=$addr->irsz?>" required>
				<span></span>
			</div>	
			<div class="col-sm-6">
				<input type="text" class="form-control" name="place['city_address']" placeholder="város, utca/közterület neve" value="<?=$addr->address?>" required>
				<span></span>
			</div>	
			<div class="col-sm-2">
				<input type="text" class="form-control" name="place['address_number']" placeholder="házszám" value="<?=$addr->hsz?>" required>
				<span></span>
			</div>					
		</div>	
		<br>				
		<div class="row">
			<? $gps = $this->shop->getGPS(); ?>
			<div class="col-sm-4" style="line-height: 26px;"><i class="fa fa-globe"></i> Üzlet GPS koordináták:</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="place['gps']['lat']" value="<?=$gps['lat']?>" placeholder="szélesség" required>
				<span></span>
			</div>	
			<div class="col-sm-4">
				<input type="text" class="form-control" name="place['gps']['lng']" value="<?=$gps['lng']?>" placeholder="hosszúság" required>
				<span></span>
			</div>				
		</div>
	</div>
	<div class="col-sm-4">
		<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<h4>Nyitvatartás</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<? $opens = $this->shop->getOpens(); ?>
				<div class="opens">
					<div class="when"><div class="text">Hétfő</div></div>
					<div class="from">
						<select name="opens['hetfo']['from']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['hetfo']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens['hetfo']['to']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['hetfo']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
				<div class="opens">
					<div class="when"><div class="text">Kedd</div></div>
					<div class="from">
						<select name="opens['kedd']['from']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['kedd']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens['kedd']['to']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['kedd']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
				<div class="opens">
					<div class="when"><div class="text">Szerda</div></div>
					<div class="from">
						<select name="opens['szerda']['from']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['szerda']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens['szerda']['to']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['szerda']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
				<div class="opens">
					<div class="when"><div class="text">Csütörtök</div></div>
					<div class="from">
						<select name="opens['csutortok']['from']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['csutortok']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens['csutortok']['to']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['csutortok']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-6">					
				<div class="opens">
					<div class="when"><div class="text">Péntek</div></div>
					<div class="from">
						<select name="opens['pentek']['from']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['pentek']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens['pentek']['to']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['pentek']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>

				<div class="opens">
					<div class="when"><div class="text">Szombat</div></div>
					<div class="from">
						<select name="opens['szombat']['from']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['szombat']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens['szombat']['to']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['szombat']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>

				<div class="opens">
					<div class="when"><div class="text">Vasárnap</div></div>
					<div class="from">
						<select name="opens['vasarnap']['from']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['vasarnap']['from'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="sep">&mdash;</div>
					<div class="to">
						<select name="opens['vasarnap']['to']">
							<? foreach( $this->times as $time ): ?>
							<option value="<?=$time?>" <?=($time == $opens['vasarnap']['to'])?'selected="selected"':''?>><?=$time?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4>Egyéb</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2" style="line-height: 26px;">
				Sorrend
			</div>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="place['sorrend']" value="<?=($_POST['place']['sorrend'])?$_POST['place']['sorrend']:0?>">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2" style="line-height: 26px;">
				Típus
			</div>
			<div class="col-sm-6">
				<select name="place['tipus']" id="" class="form-control">
					<option value="shop" <?=($this->shop->getTypeData() == 'shop')?'selected="selected"':''?>>Hivatalos üzlet</option>
					<option value="casadapont" <?=($this->shop->getTypeData() == 'casadapont')?'selected="selected"':''?>>Casada Pont</option>
				</select>
			</div>
		</div>
	</div>
	</div>
</div>
<br>
<div class="divider"></div>
<br>
<div class="row np">
	<div class="col-sm-12 right">
		<button class="btn btn-success" name="create" value="1">Létrehozás <i class="fa fa-arrow-circle-right"></i></button>
	</div>
</div>
</form>

</div>