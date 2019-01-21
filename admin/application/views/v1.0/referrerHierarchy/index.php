<h1>AJánló felhasználó rangsor</h1>

<div class="con">
	<form method="get" action="">
		<input type="hidden" name="f" value="1">
		<? if(isset($_GET['g'])): ?>
		<input type="hidden" name="g" value="<?=$_GET[g]?>">
		<? endif; ?>
		<div class="row">
			<div class="col-sm-7">
				<label for="time_from">Felhasználói csoport</label>
				<div style="line-height: 35px;">
					<a href="/referrerHierarchy/?f=1<?=(isset($_GET['time_from']))?'&time_from='.$_GET['time_from']:''?><?=(isset($_GET['time_to']))?'&time_to='.$_GET['time_to']:''?>" style="<?=(empty($this->ug)) ? 'font-weight: bold;' :'' ?>">Összes</a> | 
					<a href="/referrerHierarchy/?f=1&g=sales,reseller<?=(isset($_GET['time_from']))?'&time_from='.$_GET['time_from']:''?><?=(isset($_GET['time_to']))?'&time_to='.$_GET['time_to']:''?>" style="<?=(in_array('sales', $this->ug) && in_array('reseller', $this->ug)) ? 'font-weight: bold;' :''?>">Üzletkötők / Viszonteladók</a> | 
					<a href="/referrerHierarchy/?f=1&g=user<?=(isset($_GET['time_from']))?'&time_from='.$_GET['time_from']:''?><?=(isset($_GET['time_to']))?'&time_to='.$_GET['time_to']:''?>" style="<?=(in_array('user', $this->ug)) ? 'font-weight: bold;' :''?>">Felhasználók</a>
				</div>
			</div>
			<div class="col-sm-2">
				<label for="time_from">Dátum -tól</label>
				<input type="date" name="time_from" class="form-control" value="<?=(isset($_GET['time_from']))?$_GET['time_from']:''?>">
			</div>
			<div class="col-sm-2">
				<label for="time_from">Dátum -ig</label>
				<input type="date" name="time_to" class="form-control" value="<?=(isset($_GET['time_to']))?$_GET['time_to']:''?>">
			</div>
			<div class="col-sm-1">
				<label for="">&nbsp;</label>
				<input type="submit" class="form-control btn btn-sec" value="Mehet">
			</div>
		</div>
	</form>
</div>
<br>
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
    		<th width="40">#</th>
			<th title="Felhasználó ID" width="60">Felh.ID</th>
	        <th>Név</th>
            <th width="200">E-mail</th>
            <th width="100" title="Megrendeléseinek összesített értéke">Fizetett össz.</th>  
            <th width="200" style="border-bottom: 2px solid #d41c4f;">Kódjával leadott megrendelések</th>         
            <th width="200" style="border-bottom: 2px solid #d41c4f;">Hozott forgalom (ajánló kóddal)</th>
            <th width="200" style="border-bottom: 2px solid #d41c4f;">Érték arány</th>
            <th width="180">Utoljára belépett</th>
            <th width="180">Regisztrált</th>
            <th width="20"></th>
        </tr>
	</thead>
    <tbody>
    	<? 
    	$i = 0;
    	if(count($this->users[data]) > 0): foreach($this->users[data] as $d):  
    		$i++;
    	?>
    	<tr>
    		<td align="center"><?=$i?></td>
	    	<td align="center"><?=$d[ID]?></td>
	        <td>
          		<strong><?=$d[nev]?></strong>
          		<div style="color: #aaa;">(<?=$this->user_groupes[$d['user_group']]?>)</div>
            </td>
            <td align="center"><?=$d[email]?></td>
           
            <td align="center">
            	<?=Helper::cashFormat($d[totalOrderPrices])?> Ft
            </td>
            <td align="center">
                <?=Helper::cashFormat($d['totalRefererOrderNum'])?> db
            </td>
            <td align="center">
                <?php if ($d['totalReferredOrderPrices']): ?>
                    <a target="_blank" title="Megrendelések listája" href="/partnerSale?partner=<?=$d[total_data][data][refererID]?>"><?=Helper::cashFormat($d['totalReferredOrderPrices'])?> Ft</a>           
                <? else: ?>
                n.a.
                <?php endif; ?>
            </td>
            <td align="center">
            	<strong><?=Helper::cashFormat($d['totalReferredOrderPrices'] / $d['totalRefererOrderNum'])?></strong> 
            	Ft / megrendelés 	
            </td>
            <td align="center"><?=Helper::softDate($d[utoljara_belepett])?>	<br><em>(<?=Helper::distanceDate($d[utoljara_belepett])?>)</em></td>
            <td align="center"><?=Helper::softDate($d[regisztralt])?> <br><em>(<?=Helper::distanceDate($d[regisztralt])?>)</em></td>
            <td class="center">
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