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
</script>
<div style="float:right;">
	<a href="/megrendelesek" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Megrendelések</a>
</div>
<h1>Előrendelések 
	<span>
       	<? if($_COOKIE[filtered] == '1'): ?>
        <span class="filtered">Szűrt lista <a href="/<?=$this->gets[0]?>/clearfilters/" class="btn btn-danger">eltávolítás</a></span>
		<? endif; ?>
    </span>
</h1>
<form action="" method="post">
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th width="40">#</th>
            <th width="100">Azonosító</th>
            <th>Név/E-mail</th>
            <th width="150">Állapot</th>
            <th width="150">Átvételi mód</th>
            <th width="130">Fizetési mód</th>
            <th width="50">Tétel</th>
            <th width="100">Össz. érték</th>
            <th width="90">Megrendelve</th>
            <th width="35"></th>
        </tr>
	</thead>
    <tbody>
    	<tr class="search <? if($_COOKIE[filtered] == '1'): ?>filtered<? endif;?>">
    		<td><input type="text" name="ID" class="form-control" value="<?=$_COOKIE[filter_ID]?>" /></td>
            <td><input type="text" name="azonosito" class="form-control" value="<?=$_COOKIE[filter_azonosito]?>" /></td>
            <td><input type="text" name="access" class="form-control" value="<?=$_COOKIE[filter_access]?>" placeholder="Biztonsági kulcs" /></td>
            <td><select class="form-control"  name="fallapot" style="max-width:200px;">
            	<option value="" selected="selected"># Mind</option>
                	<? foreach($this->allapotok[order] as $m): ?>
                    <option value="<?=$m[ID]?>" <?=($m[ID] == $_COOKIE[filter_fallapot])?'selected':''?>><?=$m[nev]?></option>
                    <? endforeach; ?>
                </select></td>
            <td><select class="form-control"  name="fszallitas" style="max-width:150px;">
            	<option value="" selected="selected"># Mind</option>
                	<? foreach($this->szallitas as $m): ?>
                    <option value="<?=$m[ID]?>" <?=($m[ID] == $_COOKIE[filter_fszallitas])?'selected':''?>><?=$m[nev]?></option>
                    <? endforeach; ?>
                </select></td>
            <td><select class="form-control"  name="ffizetes" style="max-width:150px;">
            	<option value="" selected="selected"># Mind</option>
                	<? foreach($this->fizetes as $m): ?>
                    <option value="<?=$m[ID]?>" <?=($m[ID] == $_COOKIE[filter_ffizetes])?'selected':''?>><?=$m[nev]?></option>
                    <? endforeach; ?>
                </select></td>
            <td></td>
            <td></td>
            <td></td>
    		<td align="center">
            	<button name="filterList" value="1" class="btn btn-default"><i class="fa fa-search"></i></button>
            </td>
    	</tr>
    	<? if(count($this->elorendelesek[data]) > 0): foreach($this->elorendelesek[data] as $d):  ?>
		<? 
		$preorders 	= 0;
		$itemNum 	= 0;
		foreach($d[items][data] as $item){
			if($item[elorendelt] == '1') $preorders += $item[me];
			$itemNum 	+= $item[me];
		}?>
    	<tr id="o_<?=$d[ID]?>" class="o">
	    	<td align="center" valign="middle"><?=$d[ID]?></td>
            <td align="center" valign="middle">
				<? if($d[elorendeles] == 1): ?>
					<div title="Előrendelt termékek: <?=$preorders?> db előrendelt tétel van a megrendelésben!">
						<i class="fa fa-history" style="color:#60b524; font-size:18px;"></i>
					</div>
				<? endif; ?>
            	<?=$d[azonosito]?>
            </td>
            <td>
				<input type="hidden" name="accessKey[<?=$d[ID]?>]" value="<?=$d[accessKey]?>" />
            	<div class="nev"><?=$d[nev]?> (<em style="font-weight:normal;"><?=$d[email]?></em>)</div>
                <div>
					<a title="Trans-o-flex szállítási csv" href="/csv/tof_order_transport/<?=$d[accessKey]?>"><img src="<?=IMG?>icons/tof-trans-csv.png" alt="" /></a>
					&nbsp;&nbsp;
					<a href="<?=DOMAIN?>order/<?=$d[accessKey]?>" target="_blank">Publikus adatlap</a>
				</div>
            </td>
            <td class="center"><strong style="color:<?=$this->allapotok[order][$d[allapot]][szin]?>;"><?=$this->allapotok[order][$d[allapot]][nev]?></strong></td>
            <td class="center"><?=$this->szallitas[$d[szallitasiModID]][nev]?></td>
            <td class="center"><?=$this->fizetes[$d[fizetesiModID]][nev]?></td>
            <td class="center"><?=$d[items][tetel]?></td>
            <td class="center"><strong><?=Helper::cashFormat($d[items][total]+$d[szallitasi_koltseg]+($d[kedvezmeny]*-1))?> Ft</strong></td>
            <td class="center"><?=Helper::softDate($d[idopont])?></td>
            <td class="center"><button name="filterList" title="Részletek" mid="<?=$d[ID]?>" type="button" class="btn btn-default btn-sm watch"><i class="fa fa-eye"></i></button></td>
        </tr>
       	<tr class="oInfo" id="oid_<?=$d[ID]?>" style="display:none;">
       		<td colspan="10" style="padding:0;">
            	<div class="row orderInfo">
                	<div class="col-md-7">
                    	<table class="items" width="100%">
                        	<thead>
                        		<tr>
                        			<th colspan="2">Termék</th>
                        			<th width="50">Me.</th>
                        			<th width="80">E. Ár</th>
                        			<th>Össz. Ár</th>
                        			<th>Állapot</th>
                        		</tr>
                        	</thead>
                    		<tbody>
                            	<? foreach($d[items][data] as $item): ?>
                    			<tr <? if($item[elorendelt] != '1'): ?>style="opacity:0.5;"<?endif;?>>
                                	<td width="35"><div class="img"><img src="<?=Images::getThumbImg('75',$item[profil_kep])?>" alt="" /></div></td>
                    				<td>
									<? if($item[elorendelt] == 1): ?><i title="Előrendelt termék" style="color:#60b524;" class="fa fa-history"></i> <? endif; ?>
									<a href="<?=$item[url]?>" target="_blank"><?=$item[termekNev]?></a></td>
                                    <td class="center">
										<? if($item[elorendelt] != '1'): ?>
											<?=$item[me]?>
										<? else: ?>
                                    	<input type="number" name="termekMe[<?=$d[ID]?>][<?=$item[ID]?>]" value="<?=$item[me]?>" min="0" class="form-control" />
                                        <input type="hidden" value="<?=$item[me]?>" name="prev_termekMe[<?=$d[ID]?>][<?=$item[ID]?>]" />
										<? endif; ?>
                                    </td>
                                    <td class="center">
										<? if($item[elorendelt] != '1'): ?>
											<?=Helper::cashFormat($item[egysegAr])?> Ft
										<? else: ?>
                                    	<input type="number" name="termekAr[<?=$d[ID]?>][<?=$item[ID]?>]" value="<?=$item[egysegAr]?>" min="0" class="form-control" />
                                        <input type="hidden" value="<?=$item[egysegAr]?>" name="prev_termekAr[<?=$d[ID]?>][<?=$item[ID]?>]" />
										<? endif; ?>
									</td>
                                    <td class="center"><?=Helper::cashFormat($item[subAr])?> Ft</td>
                                    <td class="center" width="200">
									<? if($item[elorendelt] != '1'): ?>
										<?=$item[allapotID]?>
									<? else: ?>
										<select class="form-control" name="termekAllapot[<?=$d[ID]?>][<?=$item[ID]?>]" style="max-width:200px;">
											<? foreach($this->allapotok[termek] as $m): ?>
											<option style="color:<?=$m[szin]?>;" value="<?=$m[ID]?>" <?=($m[ID] == $item[allapotID])?'selected':''?>><?=$m[nev]?></option>
											<? endforeach; ?>
										</select>
									<? endif; ?>
                                    <input type="hidden" value="<?=$item[allapotID]?>" name="prev_termekAllapot[<?=$d[ID]?>][<?=$item[ID]?>]" />
                                    </td>
                    			</tr>
                                <? endforeach; ?>
                    		</tbody>
                    	</table>
                    </div>
                    <div class="col-md-5">
                    	<div class="row">
                        	<div class="col-md-6 selectCol"><strong>Megrendelés állapot:</strong></div>
                            <div class="col-md-6 right">
                            <select class="form-control" name="allapotID[<?=$d[ID]?>]">
								<? foreach($this->allapotok[order] as $m): ?>
                                <option style="color:<?=$m[szin]?>;" value="<?=$m[ID]?>" <?=($m[ID] == $d[allapot])?'selected':''?>><?=$m[nev]?></option>
                                <? endforeach; ?>
                            </select>
                            <input type="hidden" value="<?=$d[allapot]?>" name="prev_allapotID[<?=$d[ID]?>]" />
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-md-9 selectCol"><strong>Kedvezmény (Ft):</strong></div>
                            <div class="col-md-3">
                            <input type="number" class="form-control" name="kedvezmeny[<?=$d[ID]?>]" min="0" value="<?=$d[kedvezmeny]?>" />
                            <input type="hidden" value="<?=$d[kedvezmeny]?>" name="prev_kedvezmeny[<?=$d[ID]?>]" />
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-md-9 selectCol"><strong>Szállítási költség (Ft):</strong></div>
                            <div class="col-md-3">
                            <input type="number" class="form-control" name="szallitasi_koltseg[<?=$d[ID]?>]" min="0" value="<?=$d[szallitasi_koltseg]?>" />
                            <input type="hidden" value="<?=$d[szallitasi_koltseg]?>" name="prev_szallitasi_koltseg[<?=$d[ID]?>]" />
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-md-7 selectCol"><strong>Átvételi mód:</strong></div>
                            <div class="col-md-5">
                           	<select class="form-control"  name="szallitas[<?=$d[ID]?>]">
                                <? foreach($this->szallitas as $m): ?>
                                <option value="<?=$m[ID]?>" <?=($m[ID] == $d[szallitasiModID])?'selected':''?>><?=$m[nev]?></option>
                                <? endforeach; ?>
                            </select>
                            
                            <input type="hidden" value="<?=$d[szallitasiModID]?>" name="prev_szallitas[<?=$d[ID]?>]" />
                            </div>
                        </div>
                        <? if($d[szallitasiModID] == 2): ?>
                         <div class="row">
                         	<div class="col-md-12">
                            <div class="selPPP" align="right">
                                <strong><?=$d[ppp_adat][uzlet_nev]?></strong>:  <br />
								<?=$d[ppp_adat][iranyitoszam]?> <?=$d[ppp_adat][varos]?>, <?=$d[ppp_adat][cim]?> <br />
                                #<?=$d[ppp_adat][ppp_uzlet_kod]?>
                                </div>
                            </div>
                       	</div> 	
                        <? endif; ?>
                        
                        <div class="row">
                        	<div class="col-md-7 selectCol"><strong>Fizetési mód:</strong></div>
                            <div class="col-md-5">
                           	<select class="form-control"  name="fizetes[<?=$d[ID]?>]">
                                <? foreach($this->fizetes as $m): ?>
                                <option value="<?=$m[ID]?>" <?=($m[ID] == $d[fizetesiModID])?'selected':''?>><?=$m[nev]?></option>
                                <? endforeach; ?>
                            </select>
                            <input type="hidden" value="<?=$d[fizetesiModID]?>" name="prev_fizetes[<?=$d[ID]?>]" />
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row">
                        	<div class="col-md-6">
                            	<div><strong>Számlázási adatok</strong></div>
                                <? $szam = json_decode($d[szamlazasi_keys]);?>
                                <div>
                                	<? foreach($szam as $szmk => $szmv): ?>
                                   		<div class="row">
                                        	<div class="col-md-6 np selectCol em"><?=$nevek[$szmk]?></div>
                                        	<div class="col-md-6 np right"><input name="szamlazasi_adat[<?=$d[ID]?>][<?=$szmk?>]" type="text" class="form-control" value="<?=$szmv?>" /></div>
                                             <input type="hidden" value="<?=$szmv?>" name="prev_szamlazasi_adat[<?=$d[ID]?>][<?=$szmk?>]" />
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                            	<? $szall = json_decode($d[szallitasi_keys]);?>
                            	<div><strong>Szállítási adatok</strong></div>
                                <div>
                                	<? foreach($szall as $szllk => $szllv): ?>
                                   		<div class="row">
                                        	<div class="col-md-6 selectCol np em"><?=$nevek[$szllk]?></div>
                                        	<div class="col-md-6 np right"><input name="szallitasi_adat[<?=$d[ID]?>][<?=$szllk?>]" type="text" class="form-control" value="<?=$szllv?>" /></div>
                                            <input type="hidden" value="<?=$szllv?>" name="prev_szallitasi_adat[<?=$d[ID]?>][<?=$szllk?>]" />
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 right save">
                       <button name="saveOrder" value="<?=$d[ID]?>" class="btn btn-primary btn-sm">Változások mentése <i class="fa fa-check"></i></button>
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
</form>
<ul class="pagination">
  <li><a href="/<?=$this->gets[0]?>/<?=($this->gets[1] != '')?$this->gets[1].'/':'-/'?>1">&laquo;</a></li>
  <? for($p = 1; $p <= $this->elorendelesek[info][pages][max]; $p++): ?>
  <li class="<?=(Helper::currentPageNum() == $p)?'active':''?>"><a href="/<?=$this->gets[0]?>/<?=($this->gets[1] != '')?$this->gets[1].'/':'-/'?><?=$p?>"><?=$p?></a></li>
  <? endfor; ?>
  <li><a href="/<?=$this->gets[0]?>/<?=($this->gets[1] != '')?$this->gets[1].'/':'-/'?><?=$this->elorendelesek[info][pages][max]?>">&raquo;</a></li>
</ul>