<div style="float:right;">
	<a href="/account/?t=create&reseller=1&ret=/viszonteladok" class="btn btn-primary"><i class="fa fa-plus"></i> új partner</a>
</div>
<h1>Partnerek</h1>
<?=$this->msg?>
<form action="" method="post">
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th title="Felhasználó ID" width="40">#</th>
	        <th>Név/Email</th>
	        <th>Vállalkozás adatok</th>
            <th width="250">Számlázási adat</th>
            <th width="250">Szállítási adat</th>
            <th width="150">Hozott forgalom (ajánló kóddal)</th>
            <th width="100">Engedélyezve</th>
            <th width="100">Aktiválva</th>
            <th width="120">Utoljára belépett</th>
            <th width="120">Regisztrált</th>
            <th width="20"><i class="fa fa-gears"></i></th>
        </tr>
	</thead>
    <tbody>
        <tr class="search <? if($_COOKIE[filtered] == '1'): ?>filtered<? endif;?>">
            <td><input type="text" name="ID" class="form-control" value="<?=$_COOKIE[filter_ID]?>" /></td>
            <td><input type="text" name="nev" class="form-control" placeholder="felhasználó neve..." value="<?=$_COOKIE[filter_nev]?>" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="center">
                <button name="filterList" class="btn btn-default"><i class="fa fa-search"></i></button>
            </td>
        </tr>
    	<? if(count($this->users[data]) > 0): foreach($this->users[data] as $d):  ?>
    	<tr>
	    	<td align="center"><?=$d[ID]?></td>
	        <td>
          		<strong><?=$d['nev']?></strong> <br>
                <?=$d['email']?>
                <div style="color: #aaa;">(<?=$this->user_groupes[$d['user_group']]?>)</div>
            </td>
            <td>
            	<div><strong><?=$d['total_data']['data']['company_name']?></strong></div>
                <div style="font-size: 0.9em;">
                    <div><u>Üzlet címe:</u> <?=$d['total_data']['data']['company_address']?></div>
                    <div><u>Telephely:</u> <?=$d['total_data']['data']['company_hq']?></div>
                    <div><u>Adószám:</u> <?=$d['total_data']['data']['company_adoszam']?></div>
                    <div><u>Bankszámlaszám:</u> <?=$d['total_data']['data']['company_bankszamlaszam']?></div>
                </div>
            </td>
            <td>
                <? if( $d['total_data']['szamlazasi_adat'] ): ?>
                    <strong><?=$d['total_data']['szamlazasi_adat']['nev']?></strong>
                    <div style="font-size: 0.9em;">
                    <?=$d['total_data']['szamlazasi_adat']['irsz']?> <?=$d['total_data']['szamlazasi_adat']['city']?>, <?=$d['total_data']['szamlazasi_adat']['uhsz']?>
                    </div>
                <? else: ?>
                    &mdash; hiányzó adat &mdash;
                <? endif; ?>
            </td>
            <td>
                <? if( $d['total_data']['szallitasi_adat'] ): ?>
                    <strong><?=$d['total_data']['szallitasi_adat']['nev']?></strong>
                    <div style="font-size: 0.9em;">
                    <?=$d['total_data']['szallitasi_adat']['irsz']?> <?=$d['total_data']['szallitasi_adat']['city']?>, <?=$d['total_data']['szallitasi_adat']['uhsz']?> <br>
                    Telefon: <?=$d['total_data']['szallitasi_adat']['phone']?>
                    </div>
                <? else: ?>
                    &mdash; hiányzó adat &mdash;
                <? endif; ?>
            </td>
            <td class="center">
                <?php if ($d['totalReferredOrderPrices']): ?>
                    <a target="_blank" href="/partnerSale?partner=<?=$d[total_data][data][refererID]?>"><?=Helper::cashFormat($d['totalReferredOrderPrices'])?> Ft</a>
                <? else: ?>
                n.a.
                <?php endif; ?>
              </td>
            <td align="center"><?=($d[engedelyezve] == 1)?'<i title="Engedélyezve" mode="engedelyezve" class="fa fa-check vtgl" fid="'.$d[ID].'"></i>':'<i mode="engedelyezve" class="fa fa-times vtgl" fid="'.$d[ID].'" title="Tiltva"></i>'?></td>
            <td align="center"><?=(!is_null($d[aktivalva]))?'<i title="Aktiválva" class="fa fa-check"></i>':'<i class="fa fa-times" title="Nincs aktiválva"></i>'?></td>
            <td align="center"><?=Helper::softDate($d[utoljara_belepett])?>	<br><em>(<?=Helper::distanceDate($d[utoljara_belepett])?>)</em></td>
            <td align="center"><?=Helper::softDate($d[regisztralt])?> <br><em>(<?=Helper::distanceDate($d[regisztralt])?>)</em></td>
            <td>
                <div class="dropdown">
                    <i class="fa fa-gear dropdown-toggle" title="Beállítások" id="dm<?=$d['ID']?>" data-toggle="dropdown"></i>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$d['ID']?>">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="/account/?t=edit&ID=<?=$d['ID']?>&ret=<?=$_SERVER[REQUEST_URI]?>">Szerkesztés <i class="fa fa-pencil"></i></a></li>
                      </ul>
                </div>
            </td>
        </tr>
        <? endforeach; else: ?>
        <tr>
	    	<td colspan="15" align="center">
            	<div style="padding:25px;">Nincs találat!</div>
            </td>
        </tr>
        <? endif; ?>
    </tbody>
</table>
</form>
<script type="text/javascript">
	$(function(){
		$('.termeklista i.vtgl').click(function(){
			visibleToggler($(this));
		});
	})
	function visibleToggler(e){
		var id 		= e.attr('fid');
		var src 	= e.attr('class').indexOf('check');
		var mode 	= e.attr('mode');

	 	if(src >= 0){
			e.removeClass('fa-check').addClass('fa-spinner fa-spin');
			doChange(e, mode, id, false);
		}else{
			e.removeClass('fa-times').addClass('fa-spinner fa-spin');
			doChange(e, mode, id, true);
		}
	}
	function doChange(e, mode, id, show){
		var v = (show) ? '1' : '0';
		$.post("<?=AJAX_POST?>",{
			type : 'userChangeActions',
			mode : mode,
			id 	: id,
			val : v
		},function(d){
			if(!show){
				e.removeClass('fa-spinner fa-spin').addClass('fa-times');
			}else{
				e.removeClass('fa-spinner fa-spin').addClass('fa-check');
			}
		},"html");
	}
</script>
