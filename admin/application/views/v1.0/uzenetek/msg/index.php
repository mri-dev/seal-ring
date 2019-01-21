<div style="float:right;">
	<a href="/<?=$this->gets[0]?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> vissza</a>
</div>
<h1 style="font-size:28px; font-weight:bold; color:black;"><?=$this->msg[uzenet_targy]?></h1>
<div class="clr"></div>
<div class="divider"></div>
<br />
<?=$this->rmsg?>
<div class="con msgContainer">
	<div class="tbl">
		<div class="tbl-col tbl-w-10 left"><em>Feladó neve</em></div>
		<div class="tbl-col"><strong><?=$this->msg[felado_nev]?></strong></div>
	</div>
	<div class="tbl">
		<div class="tbl-col tbl-w-10 left"><em>Válaszcím</em></div>
		<div class="tbl-col"><strong><?=$this->msg[felado_email]?></strong></div>
	</div>
	<div class="tbl">
		<div class="tbl-col tbl-w-10 left"><em>Tárgy</em></div>
		<div class="tbl-col"><strong><?=$this->msg[uzenet_targy]?></strong></div>
	</div>
	<div class="tbl">
		<div class="tbl-col tbl-w-10 left"><em>Küldés ideje</em></div>
		<div class="tbl-col"><strong><?=$this->msg[elkuldve]?></strong></div>
	</div>
	<?php if ( $this->msg['item'] ): ?>
	<div class="divider"></div>
	<div class="tbl">
		<div class="tbl-col tbl-w-10 left va-top">Kapcsolódó tárgy</div>
		<div class="tbl-col">
			<div class="item-holder tbl">
				<div class="tbl-col tbl-w-10">
					<div class="image">
						<img src="<?=DOMAIN . $this->msg['item']['profil_kep']?>" alt="">
					</div>
				</div>
				<div class="tbl-col ">
					<div class="title">
						<h3><a target="_blank" href="<?=$this->settings['page_url'].'/termek/'.\Helper::makeSafeUrl($this->msg['item']['nev'],'_-'.$this->msg['item']['termek_ID'])?>"><?=$this->msg['item']['nev']?></a></h3>
					</div>
					<?php $csop = $this->msg['item']['csoport_kategoria'];  ?>
					<?php if ($csop): ?>
					<div class="csoport">
						<?php echo $csop; ?>
					</div>
					<?php endif; ?>
					<div class="desc">
						<?=$this->msg['item']['rovid_leiras']?>
					</div>
					<div class="action">
						<a href="/termekek/t/edit/<?=$this->msg['item']['termek_ID']?>" target="_blank">Termék szerkesztése</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<div class="divider"></div>
	<div class="tbl">
		<div class="tbl-col tbl-w-10 left va-top"><em>Feladó üzenet</em></div>
		<div class="tbl-col"><?=$this->msg[uzenet]?></div>
	</div>
	<? if($this->msg[felado_email]): ?>
	<div class="divider"></div>
	<div class="tbl">
		<div class="tbl-col tbl-w-10 left va-top"><em>Válaszüzenet</em></div>
		<div class="tbl-col">

				<div class="row">
					<div class="col-md-12" style="padding-left:0;">
						<? if(!$this->msg[valasz_uzenet]): ?>
						<form action="" method="post">
							<em style="font-size:0.8em; color:#222;">-- üzenet kezdete --</em>
							<div style="color:black;">
								<div>
									Tisztelt <input type="text" style="padding:2px 5px; color:#222;" name="replyToName" value="<?=$this->msg[felado_nev]?>" />!
								</div>
								<br />
								<textarea placeholder="válaszüzenet tartalma a feladónak..." name="replyMsg" class="form-control" style="min-height:100px;"></textarea>
								<div><br />Üdvözlettel,<br /><?=$this->settings['page_title']?></div>
								<em style="font-size:0.8em; color:#222;">-- üzenet vége --</em>
								<br />
							</div>
							<em style="color:#888;"><i class="fa fa-info-circle"></i> A válaszüzenethez csatolva lesz a feladó üzenete is!</em><br />
							<div align="right">
								<button type="submit" name="sendReplyMsg" class="btn btn-success">Válasz küldése <i class="fa fa-check"></i></button>
							</div>
						</form>
						<? else: ?>
							<?=$this->msg[valasz_uzenet]?>
							<div style="font-size:0.8em;">
								<br />
								<em><i class="fa fa-info-circle"></i> Megválaszolás ideje: </em> <?=Helper::softDate($this->msg[valaszolva])?> - <strong><?=Helper::distanceDate($this->msg[elkuldve], $this->msg[valaszolva])?></strong> várakozott a kérdező a válaszra
							</div>
						<? endif; ?>
					</div>
				</div>
		</div>
	</div>
	<? endif; ?>
</div>
