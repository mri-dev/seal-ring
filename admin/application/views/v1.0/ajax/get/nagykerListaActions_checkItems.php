<div class="con">
	<? if( count( $this->data ) > 0): ?>
	<script type="text/javascript">
		function refreshProductPrice(f){
			var d = $(f).serialize();

			var c = confirm('Biztos, hogy frissíti az árakat?');

			if( c ){
				$('#result').html('<div class="center" style="padding:25px;"><h3 style="color:#c4392e;">Folyamatban...</h3></div>');
				$.post("<?=AJAX_GET?>",{
					type 	: 'nagykerListaActions',
					fnc 	: 'updateProductPrice',
					data	: d,
					list_id : <?=$this->id?>
				}, function(r){
					$('#result').html(r);
				},"html");

			}else return false;
		}
	</script>
	<form method="post" action="" onsubmit="refreshProductPrice(this); return false;">
	<div style="float:right;">
		<input type="submit" class="btn btn-primary" value="Árváltozások frissítése">
	</div>
	<h4>Lista:</h4>
	<br><br>
	<pre><? //print_r($this->data);?></pre>
	<table class="table termeklista termekfrissites table-bordered" width="100%" cellspacing="10">
		<thead>
			<tr>
				<th>Termék / Nagyker kód</th>
				<th width="80">Aktuális ár <br>(nettó)</th>
				<th width="80">Új ár <br> (nettó)</th>
				<th width="80" style="border-left:2px dotted #999;">Aktuális ár <br>(bruttó)</th>
				<th width="80">Új ár <br> (bruttó)</th>
				<th width="80" style="border-left:2px solid #555;">Akciós aktuális <br>(nettó)</th>
				<th width="80">Akciós új <br>(nettó)</th>
				<th width="80" style="border-left:2px dotted #999;">Akciós aktuális <br>(bruttó)</th>
				<th width="80">Akciós új <br>(bruttó)</th>
				<th width="80" style="border-left:2px solid #555;">Egyedi ár</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $this->data as $d ): ?>
			<tr class="<? if(!$d[old_netto_ar]): ?>not-in-product<? endif; ?>">
				<td>
					<?=$d[termek_nev]?>
					<div><strong><? if($d[old_netto_ar]): ?><?=$d[nagyker_kod]?><? else: ?><strike><?=$d[nagyker_kod]?></strike><? endif; ?></strong></div>
				</td>
				<td class="center"><?=$d[old_netto_ar]?></td>
				<td class="center">
					<? if($d[old_netto_ar] && $d[old_netto_ar] != $d[netto_ar]): ?>
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][netto_old]" value="<?=$d[old_netto_ar]?>">
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][netto]" value="<?=$d[netto_ar]?>">
					<? endif; ?>
					<strong style="color:green;"><?=$d[netto_ar]?></strong>
				</td>
				<td class="center" style="border-left:2px dotted #999;"><?=$d[old_brutto_ar]?></td>
				<td class="center">
					<? if($d[old_netto_ar] && $d[old_brutto_ar] != $d[brutto_ar]): ?>
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][brutto_old]" value="<?=$d[old_brutto_ar]?>">
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][brutto]" value="<?=$d[brutto_ar]?>">
					<? endif; ?>
					<strong style="color:green;"><?=$d[brutto_ar]?></strong>
				</td>


				<td class="center" style="border-left:2px solid #555;"><?=$d[old_akcios_netto_ar]?></td>
				<td class="center">
					<? if($d[termek_id] != ''): ?>
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][akcios_netto_old]" value="<?=$d[old_akcios_netto_ar]?>">
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][akcios_netto]" value="<?=($d[akcios_netto_ar] == '') ? 0 : $d[akcios_netto_ar]?>">
					<? endif; ?>
					<strong style="color:#b84545;"><?=$d[akcios_netto_ar]?></strong>
				</td>
				<td class="center" style="border-left:2px dotted #999;"><?=$d[old_akcios_brutto_ar]?></td>
				<td class="center">
					<? if($d[termek_id] != ''): ?>
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][akcios_brutto_old]" value="<?=$d[old_akcios_brutto_ar]?>">
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][akcios_brutto]" value="<?=($d[akcios_brutto_ar] == '') ? 0 : $d[akcios_brutto_ar]?>">
					<? endif; ?>
					<strong style="color:#b84545;"><?=$d[akcios_brutto_ar]?></strong>
					
				</td>
				<td class="center" style="border-left:2px solid #555;">
					<?=$d[egyedi_ar]?>
					<? if($d[termek_id] != ''): ?>
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][egyedi_ar_old]" value="<?=(is_null($d[egyedi_ar_old]))?0:$d[egyedi_ar_old]?>">
					<input type="hidden" name="priceUpdate[<?=$d[termek_id]?>][egyedi_ar]" value="<?=($d[egyedi_ar] == '')?0:$d[egyedi_ar]?>">
					<? endif; ?>
				</td>
			</tr>
			<? endforeach; ?>
		</tbody>
	</table>

	<? else: ?>
	<div class="center" style="padding:25px;">
		<h3 style="color:#c4392e;">Nem található használható elem!</h3>
	</div>
	<? endif; ?>
	</form>
</div>