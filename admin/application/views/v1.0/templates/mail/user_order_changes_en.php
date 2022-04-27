<? require "head.php";
$szamlazasi_keys 	= json_decode($szamlazasi_keys, true);
$szallitasi_keys 	= json_decode($szallitasi_keys, true);
$total = 0;
$translate = (new \Lang)->builder($langkey);
?>

<h2>Dear <?=$nev?>!</h2>
<div><strong><u>Your #<?=$orderData['azonosito']?></u></strong> order changed at <strong><u><?=date('Y-m-d H:i:s')?></u></strong>.</div>
<div><h3>Changed:</h3></div>
<? foreach($changedData as $chkey => $chv){

	$keyname = $strKey[$chkey];

	if($chkey == 'termekAllapot') {
		$after = ' ('.$chv.' products)';
	}
	if($chkey == 'uj_termek') {
		$after = ' ('.$chv.' pcs products added)';
	}
	echo '<div>- ' . $translate->get($keyname) . $after . '</div>';
}
?>
<div></div>
<div><h3>Order status:</h3></div>
<div><strong style="color:<?=$orderAllapotok[$allapot]['szin']?>;"><?=$translate->get($orderAllapotok[$allapot]['nev'])?></strong></div>

<div><h3>Termékek</h3></div>
<table class="if" width="100%" style="border-collapse:collapse;" cellpadding="10" cellspacing="0">
<thead>
	<tr>
		<th align="center">Qty.</th>
		<th align="center">Product</th>
		<th align="center">Gross Unit price</th>
		<th align="center">Gross price</th>
		<th align="center">Stock</th>
		<th align="center">Status</th>
	</tr>
</thead>
<tbody style="color:#888;">
<? foreach($cart as $d){
	$total += ($d['ar']*$d['me']);
?>
	<tr>
		<td align="center"><?=$d['me']?>x</td>
		<td><a href="<?=$d['url']?>"><?=$translate->get($d['nev'])?></a></td>
		<td align="center"><?=number_format($d['ar'], 2, '.', ' ')?> EUR + VAT</td>
		<td align="center"><?=number_format($d['ar']*$d['me'], 2, '.', ' ')?> EUR + VAT</td>
		<td align="center"><strong style="color:<?=$d['termek_allapot_color']?>;"><?=$translate->get($d['termek_allapot'])?></strong></td>
		<td align="center"><strong style="color:<?=$termekAllapotok[$d['allapotID']]['szin']?>;"><?=$translate->get($termekAllapotok[$d['allapotID']]['nev'])?></strong></td>
	</tr>
<? } ?>
	<tr>
		<td colspan="5" align="right">Product total:</td>
		<td align="center"><?=number_format($total, 2, '.', ' ')?> EUR + VAT</td>
	</tr>
	<tr>
		<td colspan="5" align="right">Shipping cost:</td>
		<td align="center"><?=number_format($szallitasi_koltseg, 2, '.', ' ')?> EUR</td>
	</tr>
	<tr>
		<td colspan="5" align="right">Discount:</td>
		<td align="center"><?=(($kedvezmeny > 0) ? Helper::cashFormat($kedvezmeny) : 0 )?> EUR</td>
	</tr>
	<?
		if($kedvezmeny > 0) 		$total -= $kedvezmeny;
		if($szallitasi_koltseg > 0) $total += $szallitasi_koltseg;
	?>
	<tr>
		<td colspan="5" align="right"><strong>Total:</strong></td>
		<td align="center"><strong><?=number_format($total, 2, '.', ' ')?> EUR + VAT</strong></td>
	</tr>
</tbody>
</table>
<div><h3>Billing informations</h3></div>
<table class="if" width="100%" border="1" style="border-collapse:collapse;" cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td width="150" align="left">Name</td>
			<td align="left"><strong><?=$szamlazasi_keys['nev']?></strong></td>
		</tr>
		<?php if ( $szamlazasi_keys['adoszam'] != '' ): ?>
		<tr>
			<td width="150" align="left">Tax number</td>
			<td align="left"><strong><?=$szamlazasi_keys['adoszam']?></strong></td>
		</tr>
		<?php endif; ?>
		<tr>
			<td align="left">Zip code</td>
			<td align="left"><strong><?=$szamlazasi_keys['irsz']?></strong></td>
		</tr>
		<?php if ( $szamlazasi_keys['kerulet'] != '' ): ?>
		<tr>
			<td align="left">District</td>
			<td align="left"><strong><?=$szamlazasi_keys['kerulet']?></strong></td>
		</tr>
		<?php endif; ?>
		<tr>
			<td align="left">City</td>
			<td align="left"><strong><?=$szamlazasi_keys['city']?></strong></td>
		</tr>
		<tr>
			<td align="left">Address name</td>
			<td align="left"><strong><?=$szamlazasi_keys['kozterulet_nev']?></strong></td>
		</tr>
		<tr>
			<td align="left">Adress type</td>
			<td align="left"><strong><?=$szamlazasi_keys['kozterulet_jelleg']?></strong></td>
		</tr>
		<tr>
			<td align="left">House number</td>
			<td align="left"><strong><?=$szamlazasi_keys['hazszam']?></strong></td>
		</tr>
		<?php if ( $szamlazasi_keys['epulet'] != '' ): ?>
		<tr>
			<td align="left">Building</td>
			<td align="left"><strong><?=$szamlazasi_keys['epulet']?></strong></td>
		</tr>
		<?php endif; ?>
		<?php if ( $szamlazasi_keys['lepcsohaz'] != '' ): ?>
		<tr>
			<td align="left">Staircase</td>
			<td align="left"><strong><?=$szamlazasi_keys['lepcsohaz']?></strong></td>
		</tr>
		<?php endif; ?>
		<?php if ( $szamlazasi_keys['szint'] != '' ): ?>
		<tr>
			<td align="left">Floor</td>
			<td align="left"><strong><?=$szamlazasi_keys['szint']?></strong></td>
		</tr>
		<?php endif; ?>
		<?php if ( $szamlazasi_keys['ajto'] != '' ): ?>
		<tr>
			<td align="left">Door</td>
			<td align="left"><strong><?=$szamlazasi_keys['ajto']?></strong></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
<div><h3>Shipping informations</h3></div>
<table class="if" width="100%" border="1" style="border-collapse:collapse;" cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td width="150" align="left">Name</td>
			<td align="left"><strong><?=$szallitasi_keys['nev']?></strong></td>
		</tr>
		<tr>
			<td align="left">Zip code</td>
			<td align="left"><strong><?=$szallitasi_keys['irsz']?></strong></td>
		</tr>
		<?php if ( $szallitasi_keys['kerulet'] != '' ): ?>
		<tr>
			<td align="left">District</td>
			<td align="left"><strong><?=$szallitasi_keys['kerulet']?></strong></td>
		</tr>
		<?php endif; ?>
		<tr>
			<td align="left">City</td>
			<td align="left"><strong><?=$szallitasi_keys['city']?></strong></td>
		</tr>
		<tr>
			<td align="left">Address name</td>
			<td align="left"><strong><?=$szallitasi_keys['kozterulet_nev']?></strong></td>
		</tr>
		<tr>
			<td align="left">Address type</td>
			<td align="left"><strong><?=$szallitasi_keys['kozterulet_jelleg']?></strong></td>
		</tr>
		<tr>
			<td align="left">House number</td>
			<td align="left"><strong><?=$szallitasi_keys['hazszam']?></strong></td>
		</tr>
		<?php if ( $szallitasi_keys['epulet'] != '' ): ?>
		<tr>
			<td align="left">Building</td>
			<td align="left"><strong><?=$szallitasi_keys['epulet']?></strong></td>
		</tr>
		<?php endif; ?>
		<?php if ( $szallitasi_keys['lepcsohaz'] != '' ): ?>
		<tr>
			<td align="left">Staircase</td>
			<td align="left"><strong><?=$szallitasi_keys['lepcsohaz']?></strong></td>
		</tr>
		<?php endif; ?>
		<?php if ( $szallitasi_keys['szint'] != '' ): ?>
		<tr>
			<td align="left">Floor</td>
			<td align="left"><strong><?=$szallitasi_keys['szint']?></strong></td>
		</tr>
		<?php endif; ?>
		<?php if ( $szallitasi_keys['ajto'] != '' ): ?>
		<tr>
			<td align="left">Door</td>
			<td align="left"><strong><?=$szallitasi_keys['ajto']?></strong></td>
		</tr>
		<?php endif; ?>
		<tr>
			<td align="left">Phone number</td>
			<td align="left"><strong><?=$szallitasi_keys['phone']?></strong></td>
		</tr>
	</tbody>
</table>

<div><h3>Additional informations</h3></div>
<table class="if" width="100%" border="1" style="border-collapse:collapse;" cellpadding="10" cellspacing="0">
	<tbody>
		<? if($orderData['used_cash'] != 0): ?>
		<tr>
			<td width="150" align="left">Felhasznált egyenleg</td>
			<td align="left"><strong><?=$orderData['used_cash']?> Ft</strong></td>
		</tr>
		<? endif; ?>
		<? if( $orderData['coupon_code'] ): ?>
		<tr>
			<td width="150" align="left">Used coupon code</td>
			<td align="left"><strong><?=$orderData['coupon_code']?></strong></td>
		</tr>
		<? endif; ?>
		<? if( $orderData['referer_code'] ): ?>
		<tr>
			<td width="150" align="left">Felhasznált ajánló partnerkód</td>
			<td align="left"><strong><?=$orderData['referer_code']?></strong></td>
		</tr>
		<? endif; ?>
		<tr>
			<td width="150" align="left">User comment</td>
			<td align="left"><strong><?=$megjegyzes?></strong></td>
		</tr>
		<tr>
			<td align="left">Shipping method</td>
			<td align="left">
			<strong><?=$translate->get($atvetel)?></strong>
			<? if( $is_pickpackpont ){ ?>
				(<?=$ppp_uzlet_str?>)
			<? } ?></td>
		</tr>
		<tr>
			<td align="left">Payment method</td>
			<td align="left"><strong><?=$translate->get($fizetes)?></strong></td>
		</tr>
		<tr>
			<td align="left">Order placed</td>
			<td align="left"><strong><?=$orderData['idopont']?></strong></td>
		</tr>
	</tbody>
</table>

<? if( $is_eloreutalas ){ ?>
	<div><h3>Bank transfer informations</h3></div>
	<table class="if" width="100%" border="1" style="border-collapse:collapse;" cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td width="150" align="left">Name</td>
			<td align="left"><strong><?=$settings['banktransfer_author']?></strong></td>
		</tr>
		<tr>
			<td align="left">Bank address number:</td>
			<td align="left"><strong><?=$settings['banktransfer_number']?></strong></td>
		</tr>
		<tr>
			<td align="left">Bank:</td>
			<td align="left"><strong><?=$settings['banktransfer_bank']?></strong></td>
		</tr>
		<tr>
			<td align="left">In receipt comment:<br><em style="font-size:12px;">(your order number)</em></td>
			<td align="left"><strong><?=$orderData['azonosito']?></strong></td>
		</tr>
	</tbody>
	</table>
<? } ?>

<br>
<div>You can tract your order in your account.<br /><br />
<strong>Your order page, check it out what's going on:</strong><br />
<a href="<?=$settings['domain']?>/order/<?=$accessKey?>"><?=$settings['domain']?>/order/<?=$accessKey?></a>
</div>
<? require "footer.php"; ?>
