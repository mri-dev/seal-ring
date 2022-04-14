<? require "head.php"; ?>
<h2>Dear <?=$nev?>!</h2>
<h3>Thank's for your order in our webshop: <?=$settings['page_title']?>!</h3>
<div>Order number: <strong><?=$orderData['azonosito']?></strong></div>
<br>
<div><h3>Ordered products</h3></div>
<table class="if" width="100%" border="1" style="border-collapse:collapse;" cellpadding="10" cellspacing="0">
<thead>
	<tr>
		<th align="center">Qry.</th>
		<th align="center">Product</th>
		<th align="center"><?=($nettoar == '1')?'Net.':'Gross'?> unit price</th>
		<th align="center"><?=($nettoar == '1')?'Net.':'Gross'?> price</th>
		<th align="center">Status</th>
	</tr>
</thead>
<tbody style="color:#888;">
<? foreach($cart as $d){
	$total += ($d['ar']*$d['me']);
?>
	<tr>
		<td align="center"><?=$d['me']?>x</td>
		<td>
			<a href="<?=$d['url']?>"><?=$d['nev']?></a>
			<?php if ($d['configs']): ?>
				<div class="config">
					-> <?php foreach ((array)$d['configs'] as $cid => $c): ?>
						<em><?php echo $c['parameter']; ?>:</em> <strong><?php echo $c['value']; ?></strong>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</td>
		<td align="center"><?=number_format($d['ar'], 2, ".", " ")?> <?=$valuta?> <?=($nettoar == '1')?'+ VAT':''?></td>
		<td align="center"><?=number_format(($d['ar']*$d['me']), 2, ".", " ")?> <?=$valuta?> <?=($nettoar == '1')?'+ VAT':''?></td>
		<td align="center">
			<?php if ((float)$d['keszleten'] == 0): ?>
				<strong style="color:red;">Ordered for production!</strong>
			<?php else: ?>
				<?php if ($d['keszleten'] < $d['me']): ?>
					<strong style="color:<?=$d['termek_allapot_color']?>;"><?=$d['termek_allapot']?>: <?=$d['keszleten']?> pcs. <span style="color:#ff9167;"><?=($d['me']-$d['keszleten'])?> pcs in order!</span></strong>
				<?php else: ?>
					<strong style="color:<?=$d['termek_allapot_color']?>;"><?=$d['termek_allapot']?>: <?=$d['keszleten']?> pcs.</strong>
				<?php endif; ?>
			<?php endif; ?>
		</td>
	</tr>
<? }
	// Összesítő ár
?>
<tr>
	<td colspan="4" align="right">Total:</td>
	<td align="center"><?=number_format($total, 2, ".", " ")?> Ft <?=($nettoar == '1')?'+ ÁFA':''?></td>
</tr>

	<tr>
		<td colspan="4" align="right">Shipping costs:</td>
		<td align="center"><?=$szallitasi_koltseg?> Ft</td>
	</tr>
	<tr>
		<td colspan="4" align="right">Discount:</td>
			<td align="center"><?=( ( !$kedvezmeny && $kedvezmeny == '') ? '0' : round($kedvezmeny) )?> <?=$valuta?></td>
	</tr>
	<?
	if($szallitasi_koltseg > 0) $total += $szallitasi_koltseg;
	?>
	<tr>
		<td colspan="4" align="right"><strong>Total price:</strong></td>
		<td align="center"><strong><?=number_format($total-$kedvezmeny, 2, ".", " ")?> <?=$valuta?></strong> <?=($nettoar == '1')?'+ ÁFA':''?></td>
	</tr>
</tbody>
</table>
<p style="margin: 10px 0; font-weight: bold; color: red;">We will make contact you if price or availability changes on products whick is out of stock</p>
<div class="" style="font-size: 10px;">
	<p><u><span style="font-family: Arial, Helvetica, sans-serif; font-size: 18px;">SHIPPING INFORMATIONS:</span></u></p>
	<p><strong>Your transport partner: GLS!</strong></p>
	- Gross transport price under 30 EUR:
	<div style="margin-left: 20px;">
    + 5.9 EUR + VAT cash on delivery.<br>
		For contract partners: 3.58 EUR + VAT.
	</div>
	- Above 30 EUR total: Free shipping.
</div>
<div><h3>Billing details</h3></div>
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
			<td align="left">City </td>
			<td align="left"><strong><?=$szamlazasi_keys['city']?></strong></td>
		</tr>
		<tr>
			<td align="left">Address name</td>
			<td align="left"><strong><?=$szamlazasi_keys['kozterulet_nev']?></strong></td>
		</tr>
		<tr>
			<td align="left">Address type</td>
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
<div><h3>Shipping details</h3></div>
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
			<td align="left">Building </td>
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
			<td align="left">Phone</td>
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
		<td width="150" align="left">Used coupon</td>
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
		<td width="150" align="left">Comment</td>
		<td align="left"><strong><?=$megjegyzes?></strong></td>
	</tr>
	<tr>
		<td align="left">Shipping method</td>
		<td align="left"><strong><?=__($atvetel)?></strong></td>
	</tr>
	<tr>
		<td align="left">Paying method</td>
		<td align="left"><strong><?=__($fizetes)?></strong>
		<? if( $is_pickpackpont ){ ?>
			(<?=$ppp_uzlet_str?>)
		<? } ?>
		</td>
	</tr>
	<tr>
		<td align="left">Ordered at</td>
		<td align="left"><strong><?=date('Y-m-d H:i:s')?></strong></td>
	</tr>
</tbody>
</table>
<? if( $is_eloreutalas ){ ?>
	<div><h3>Payment informations for your paying (bank transfer)</h3></div>
	<table class="if" width="100%" border="1" style="border-collapse:collapse;" cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td width="150" align="left">Name</td>
			<td align="left"><strong><?=$settings['banktransfer_author']?></strong></td>
		</tr>
		<tr>
			<td align="left">Bank account number:</td>
			<td align="left"><strong><?=$settings['banktransfer_number']?></strong></td>
		</tr>
		<tr>
			<td align="left">Bank:</td>
			<td align="left"><strong><?=$settings['banktransfer_bank']?></strong></td>
		</tr>
		<tr>
			<td align="left">Transfer notice:<br><em style="font-size:12px;">(your order number)</em></td>
			<td align="left"><strong><strong><?=$orderData['azonosito']?></strong></td>
		</tr>
	</tbody>
	</table>
<? } ?>
<br>
<div>You can track your order in our wehshop or get in contacts us!<br /><br />
<strong>Your order describe page:</strong><br />
<a href="<?=$settings['domain']?>/order/<?=$accessKey?>"><?=$settings['domain']?>/order/<?=$accessKey?></a>
</div>
<? require "footer.php"; ?>
