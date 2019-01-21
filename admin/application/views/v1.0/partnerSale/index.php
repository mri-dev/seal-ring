<?
$nevek = array(
	'nev' => 'Név',
	'uhsz' => 'Utca, házszám',
	'city' => 'Város',
	'irsz' => 'Irányítószám',
	'phone' => 'Telefonszám',
    'state' => 'Megye'
);
?>

<h1>Partnerkódos Megrendelések (<?=$this->megrendelesek[info][total_num]?>)
	<span>
       	<? if($_COOKIE[filtered] == '1'): ?><span class="filtered">Szűrt listázás <a href="/megrendelesek/clearfilters/" title="szűrés eltávolítása" class="actions"><i class="fa fa-times-circle"></i></a></span><? endif; ?>
    </span>
</h1>
<?=$this->msg?>
<div class="tbl-container overflowed">
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th width="40">#</th>
            <th width="100">Azonosító</th>
            <th width="100">Ajánló partner</th>
            <th>Név/E-mail</th>
            <th width="150">Állapot</th>
            <th width="150">Átvételi mód</th>
            <th width="130">Fizetési mód</th>
            <th width="50">Tétel</th>
            <th width="100">Végösszeg</th>
            <th width="50">Kedvezmény</th>
            <th width="140">Megrendelve</th>
            <th width="35"></th>
        </tr>
	</thead>
    <tbody>    	
    	<? if(count($this->megrendelesek[data]) > 0): foreach($this->megrendelesek[data] as $d):  ?>
		<? 
		$preorders 	= 0;
		$itemNum 	= 0;
		foreach($d[items][data] as $item){
			if($item[elorendelt] == '1') $preorders += $item[me];
			$itemNum 	+= $item[me];
		}?>
    	<tr id="o_<?=$d[ID]?>" class="o">
	    	<td align="center" valign="middle" style="border-left:5px solid <?=$this->allapotok[order][$d[allapot]][szin]?>;"><?=$d[ID]?></td>
            <td align="center" valign="middle">
            	<?=$d[azonosito]?>
            </td>
            <td align="center" valign="middle">
                <a href="/<?=($d['referer']->getPartnerGroup() == 'user') ? 'felhasznalok' : 'partnerek'?>/?ID=<?=$d['referer']->getPartnerID()?>" target="_blank"><?=$d['referer']->getPartnerName(false)?></a></strong> (<?=$d['referer_code']?>)

            </td>
            <td>
                <div class="ind feat">
                <? if( $d['used_cash'] != 0 ): ?><i class="fa fa-money" title="Felhasznált virtuális egyenleg"></i><? endif; ?>
                </div>

				<input type="hidden" name="accessKey[<?=$d[ID]?>]" value="<?=$d[accessKey]?>" />
            	<div class="nev"><?=$d[nev]?> (<em style="font-weight:normal;"><?=$d[email]?></em>)</div>
                <div>
					<a href="<?=HOMEDOMAIN?>order/<?=$d[accessKey]?>" target="_blank">Publikus adatlap</a>
					<? if( $d[comment] != '' ): ?>
						&nbsp;&nbsp;<span style="color:#eb6464;"><i class="fa fa-file-text-o"></i> vásárlói megjegyzés</span>
					<? endif; ?>              
				</div>
            </td>
            <td class="center">
                <strong style="color:<?=$this->allapotok[order][$d[allapot]][szin]?>;"><?=$this->allapotok[order][$d[allapot]][nev]?></strong>                 
                <? 
                // PayU pay info
                if($d[fizetesiModID] == $this->settings['flagkey_pay_payu']): ?>
                <div>
                   <? if( $d['payu_fizetve'] == 1 && $d['payu_teljesitve'] == 0 ): ?>
                    <span class="payu-paidonly">Fizetve. Visszaigazolásra vár.</span>
                    <? elseif($d['payu_fizetve'] == 1 && $d['payu_teljesitve'] == 1): ?>
                    <span class="payu-paid-done">Fizetve. Elfogadva.</span>
                    <? endif; ?>                    
                </div>
                <? endif;?>
            </td>
            <td class="center"><?=$this->szallitas[$d[szallitasiModID]][nev]?></td>
            <td class="center">
                <?=$this->fizetes[$d[fizetesiModID]][nev]?>
            </td>
            <td class="center"><?=$d[items][tetel]?></td>
            <td class="center"><strong><?=Helper::cashFormat($d[items][total]+$d[szallitasi_koltseg]+($d[kedvezmeny]*-1))?> Ft</strong></td>
            <td class="center"><?=Helper::cashFormat($d['kedvezmeny'])?> Ft</td>
            <td class="center"><?=\PortalManager\Formater::dateFormat($d[idopont], $this->settings['date_format'])?></td>
            <td class="center"><button name="filterList" title="Részletek" mid="<?=$d[ID]?>" type="button" class="btn btn-default btn-sm watch"><i class="fa fa-eye"></i></button></td>
        </tr>
       	<tr class="oInfo" id="oid_<?=$d[ID]?>" style="display:none;">
       		<td colspan="25" style="padding:0;">
            	<div class="row orderInfo">
                	<div class="col-md-12">
                        <? if($d[kedvezmeny_szazalek] > 0): ?>
                        <div class="discounted-info-price">A termékek árai <?=$d[kedvezmeny_szazalek]?>%-kal csökkentetve jelennek meg! </div>
                        <? endif; ?>
                    	<table class="items" width="100%">
                        	<thead>
                        		<tr>
                        			<th colspan="2">Termék</th>
                                    <th width="50">Méret</th>
                                    <th>Szín</th>
                        			<th width="50">Me.</th>
                        			<th width="80">E. Ár</th>
                        			<th width="120">Össz. Ár</th>
                        			<th>Állapot</th>
                        		</tr>
                        	</thead>
                    		<tbody>
                            	<? 
                                $c_total = 0; 
                                foreach($d[items][data] as $item): $c_total += $item[subAr]; ?>
                    			<tr>
                                	<td width="35"><div class="img"><img src="<?=\PortalManager\Formater::productImage($item[profil_kep], 75, \ProductManager\Products::TAG_IMG_NOPRODUCT)?>" alt="" /></div></td>
                    				<td>
									   <a href="<?=HOMEDOMAIN.'termek/'.\PortalManager\Formater::makeSafeUrl($item[termekNev],'_-'.$item[termekID])?>" target="_blank"><?=($item[termekNev]) ?: '-törölt termék-'?></a>
                                       <div class="item-number">#<span class="number"><?=$item['termekID']?></span> &nbsp; Cikkszám: <span class="number"><?=$item['cikkszam']?></span> &nbsp; articleid: <span class="number"><?=$item['raktar_articleid']?></span> &nbsp; variantid: <span class="number"><?=$item['raktar_variantid']?></span></div>
                                    </td>
                                    <td class="center">
                                        <strong><?=$item['meret']?></strong>
                                    </td>
                                    <td class="center">
                                         <strong><?=$item['szin']?></strong>
                                    </td>
                                    <td class="center">
                                    	<?=$item[me]?>
                                        <input type="hidden" value="<?=$item[me]?>" name="prev_termekMe[<?=$d[ID]?>][<?=$item[ID]?>]" />
                                    </td>
                                    <td class="center">
                                        <?=Helper::cashFormat($item[egysegAr])?> Ft
                                    	<input style="display: none;" type="number" name="termekAr[<?=$d[ID]?>][<?=$item[ID]?>]" value="<?=round($item[egysegAr])?>" min="0" class="form-control" />
                                        <input type="hidden" value="<?=round($item[egysegAr])?>" name="prev_termekAr[<?=$d[ID]?>][<?=$item[ID]?>]" />
									</td>
                                    <td class="center"><?=Helper::cashFormat($item[subAr])?> Ft</td>
                                    <td class="center" width="200">
                                    <select class="form-control" name="termekAllapot[<?=$d[ID]?>][<?=$item[ID]?>]" style="max-width:200px;" readonly="readonly">
										<? foreach($this->allapotok[termek] as $m):  ?>
                                        <option style="color:<?=$m[szin]?>;" value="<?=$m[ID]?>" <?=($m[ID] == $item[allapotID])?'selected':''?>><?=$m[nev]?></option>
                                        <? endforeach; ?>
                                    </select>
                                    <input type="hidden" value="<?=$item[allapotID]?>" name="prev_termekAllapot[<?=$d[ID]?>][<?=$item[ID]?>]" />
                                    </td>
                    			</tr>
                                <? endforeach; ?>
                                <tr style="background:#f3f3f3;">
                                    <td class="right" colspan="6">Termékek összesített ára:</td>
                                    <td class="center"><strong><?=Helper::cashFormat($c_total)?> Ft</strong></td>  
                                    <td class="right" colspan="2">
                                       
                                    </td>                                  
                                </tr>
                    		</tbody>
                    	</table>
                        <? if( !is_null($d['coupon_code']) ): ?>
                        <div class="coupon-used">
                            <div class="row">
                                <div class="col-sm-3 left">Felhasznált kupon:</div>
                                <div class="col-sm-9 right"><strong><?=$d['coupon']->getTitle()?></strong> (<?=$d['coupon_code']?>)</div>
                            </div>
                        </div>
                        <? endif; ?>
                        <? if( $d['used_cash'] != 0 ): ?>
                        <div class="referer-used">
                            <div class="row">
                                <div class="col-sm-3 left">Felhasznált egyenleg:</div>
                                <div class="col-sm-9 right"><strong><?=\Helper::cashFormat($d['used_cash'])?> Ft</strong></div>
                            </div>
                        </div>
                        <? endif; ?>
                        <div id="newitem_c<?=$d[ID]?>"></div>
                    </div>
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
</div>
<ul class="pagination">
  <li><a href="/<?=$this->gets[0]?>/<?=($this->gets[1] != '')?$this->gets[1].'/':'-/'?>1">&laquo;</a></li>
  <? for($p = 1; $p <= $this->megrendelesek[info][pages][max]; $p++): ?>
  <li class="<?=(Helper::currentPageNum() == $p)?'active':''?>"><a href="/<?=$this->gets[0]?>/<?=($this->gets[1] != '')?$this->gets[1].'/':'-/'?><?=$p?>"><?=$p?></a></li>
  <? endfor; ?>
  <li><a href="/<?=$this->gets[0]?>/<?=($this->gets[1] != '')?$this->gets[1].'/':'-/'?><?=$this->megrendelesek[info][pages][max]?>">&raquo;</a></li>
</ul>

<script type="text/javascript">
    $(function(){
        $('button[mid]').click(function(){
            var e = $(this);
            var id = e.attr('mid');
            
            $('.oInfo').hide(0);
            $('.o').removeClass('opened');
            
            $('#o_'+id).addClass('opened');
            $('#oid_'+id).show(0);
        }); 
    })

    function collectSprinterTrans() {
        var items = $('input[type=checkbox][class*=sprinter_exp]:checked');
        var keys = '';

        items.each( function(i,e){
            keys += $(e).val()+",";
        });

        keys = keys.slice(0, -1);

        document.location.href = '/csv/sprinter_transport/'+keys;        
    }

    function addNewItem (contid) {
         var cont = $('#newitem_c'+contid);

         $.post( "<?=AJAX_GET?>", {
            type :'loadAddNewItemsOnOrder'
         }, function(d){
            cont.append(d);
         },"html" );
         
    }
</script>