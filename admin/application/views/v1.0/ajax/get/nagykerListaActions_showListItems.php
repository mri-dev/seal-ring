<div class="con">
	<h2><?=$this->data['nagyker_nev']?> / <?=$this->data['file_name']?></h2>
	<a href="<?=str_replace(array('http://','..src/'),array('http://src.',''),DOMAIN).$this->data['file_path']?>">Letöltés</a>
	<br><br><br>
	<? $titles = array(); ?>
	<? foreach( $this->csv->titles as $d ): $titles[] = trim($d); endforeach; ?>	
	<div class="row" style="margin:0 -15px;">
		<div class="col-md-6">
			<h4>Kötelező mezők:</h4>
			<table class="table table-bordered" cellspacing="10">
				<thead>
					<tr>
						<th>Mező</th>
						<th>Állapot</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="150"><strong><u>nt</u></strong> - nettó ár</td>
						<td><? if( in_array('nt', $titles) ): ?> <strong style="color:green;">MEGVAN</strong> <? else: ?> <strong style="color:red;">HIÁNYZIK</strong>  <? endif; ?></td>
					</tr>
					<tr>
						<td><strong><u>br</u></strong> - bruttó ár</td>
						<td><? if( in_array('br', $titles) ): ?> <strong style="color:green;">MEGVAN</strong> <? else: ?> <strong style="color:red;">HIÁNYZIK</strong>  <? endif; ?></td>
					</tr>
					<tr>
						<td><strong><u>kod</u></strong> - nagyker azonosító</td>
						<td><? if( in_array('kod', $titles) ): ?> <strong style="color:green;">MEGVAN</strong> <? else: ?> <strong style="color:red;">HIÁNYZIK</strong>  <? endif; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<h4>Opcionális mezők:</h4>
			<table class="table table-bordered" cellspacing="10">
				<thead>
					<tr>
						<th>Mező</th>
						<th>Állapot</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="150"><strong>nt_a</strong> - akciós nettó ár</td>
						<td><? if( in_array('nt_a', $titles) ): ?> <strong style="color:green;">MEGVAN</strong> <? else: ?> <strong style="color:orange;">NINCS</strong>  <? endif; ?></td>
					</tr>
					<tr>
						<td><strong>br_a</strong> - akciós bruttó ár</td>
						<td><? if( in_array('br_a', $titles) ): ?> <strong style="color:green;">MEGVAN</strong> <? else: ?> <strong style="color:orange;">NINCS</strong>  <? endif; ?></td>
					</tr>
					<tr>
						<td><strong>ea</strong> - egyedi bruttó ár</td>
						<td><? if( in_array('ea', $titles) ): ?> <strong style="color:green;">MEGVAN</strong> <? else: ?> <strong style="color:orange;">NINCS</strong>  <? endif; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<h4>Nyers lista tartalom:</h4>
	<table class="table termeklista table-bordered" width="100%" cellspacing="10">
		<thead>
			<tr>
			
			<th>#</th>
			<? foreach( $titles as $t ): ?>			
				<th><?=$t?></th>
			<? endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<? $p = 0; foreach( $this->csv->data as $d ): $p++; ?>
			<tr>
				<td>#<?=$p?></td>
				<? foreach( $titles as $t ): ?>
				<td><?=$d[$t]?></td>
				<? endforeach; ?>
			</tr>
			<? endforeach; ?>
		</tbody>
	</table>
</div>