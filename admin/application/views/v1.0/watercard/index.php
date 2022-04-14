<div style="float:right;">
    <a href="/watercard/uj" class="btn btn-info"><i class="fa fa-plus-circle"></i> új kártya</a>
</div>
<h1>
    A jövő bajnokai kártyák
    <span><strong><?=$this->cards['info']['total_num']?> db</strong> kártya
    <span>
        <? if($_COOKIE['filtered'] == '1'): ?><span class="filtered">Szűrt listázás <a href="/watercard/clearfilters/" title="szűrés eltávolítása" class="actions"><i class="fa fa-times-circle"></i></a></span><? endif; ?>
    </span>
</h1>
<?=$this->msg?>
<? if( $this->gets['1'] == 'check'):  ?>
    <div style="color:#B95050; font-size:1.2em;">A lista jelenleg csak a <strong>"<?=$this->gets['2']?>"</strong> kártya számú rekordot mutatja! <a href="/watercard">[összes listázása]</a></div>
    <br>
<? endif; ?>

<? if($this->gets['1'] == 'del'): ?>
<form action="" method="post">
<input type="hidden" name="delId" value="<?=$this->gets['2']?>" />
<div class="row np">
    <div class="col-md-12">
        <div class="con con-del">
            <h2>Kártya igény törlése</h2>
            Biztos, hogy törli a kiválasztott kártya igényt?
            <div class="row np">
                <div class="col-md-12 right">
                    <a href="/<?=$this->gets['0']?>/" class="btn btn-danger"><i class="fa fa-times"></i> NEM</a>
                    <button class="btn btn-success">IGEN <i class="fa fa-check"></i> </button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<? else: ?>

<form action="" method="post">
    <div class="tbl-container overflowed">
        <table class="table termeklista table-bordered">
        <thead>
        	<tr>
        		<th width="40">#</th>
        		<th width="80">Felh. ID</th>
                <th width="180">Igénylő név</th>
                <th width="180">Igénylő e-mail</th>
        		<th>Kártya száma</th>
        		<th>Egyesület</th>
        		<th width="140">Időpont</th>
        		<th width="140">Aktiválva</th>
                <th width="20"></th>
            </tr>
        </thead>
        <tbody>
        	<tr class="search <? if($_COOKIE['filtered'] == '1'): ?>filtered<? endif;?>">
        		<td><input type="text" name="ID" class="form-control" value="<?=$_COOKIE['filter_ID']?>" /></td>
        		<td><input type="text" name="uid" class="form-control" value="<?=$_COOKIE['filter_uid']?>" /></td>
                <td><input type="text" name="nev" placeholder="" class="form-control" value="<?=$_COOKIE['filter_nev']?>" /></td>
        		<td><input type="text" name="email" placeholder="" class="form-control" value="<?=$_COOKIE['filter_email']?>" /></td>
        		
        		<td><input type="text" name="kartya_szam" placeholder="" class="form-control" value="<?=$_COOKIE['filter_kartya_szam']?>" /></td>
        		<td><input type="text" name="egyesulet" placeholder="" class="form-control" value="<?=$_COOKIE['filter_egyesulet']?>" /></td>
        		<td></td>
        		<td>
        			<select class="form-control"  name="aktivalva" style="max-width:200px;">
        				<option value="" selected="selected"># Mind</option>
                        <option value="1" <?=($_COOKIE['filter_aktivalva'] == '1')?'selected':''?>>Igen</option>
        				<option value="0" <?=($_COOKIE['filter_aktivalva'] == '0')?'selected':''?>>Nem</option>
                    </select>
        		</td>
        		<td align="center">
                	<button name="filterList" class="btn btn-default"><i class="fa fa-search"></i></button>
                </td>
        	</tr>
        	<? if(count($this->cards['data']) > 0): foreach($this->cards['data'] as $d):  ?>
        	<tr class="<? if($d['aktivalva'] == 0): ?>want-activate<? endif; ?>">
            	<td class="center"><?=$d['ID']?></td>
            	<td class="center"><?=$d['uid']?></td>
            	<td><?=$d['neve']?></td>
            	<td class="center"><?=$d['email']?></td>
            	<td><strong><?=$d['kartya_szam']?></strong> 
                    <? if( is_null($d['aktivalva']) ): ?>
                       <span style="color:red;">[aktiválás szükséges]</span>
                    <? endif; ?>
                </td>
            	<td><strong><?=$d['egyesulet']?></strong></td>
            	<td class="center"><?=\PortalManager\Formater::dateFormat( $d['hozzaadva'], $this->settings['date_format'] )?></td>
            	<td class="center">
            		<? if( is_null($d['aktivalva']) ): ?>
            			<div><i class="fa fa-times"></i></div>
            		<? else: ?>
            			<div><i class="fa fa-check"></i></div>
            			<?=\PortalManager\Formater::dateFormat( $d['aktivalva'], $this->settings['date_format'] )?>
            		<? endif; ?>
            	</td>
            	<td class="center">
            		<div class="dropdown">
                    	<i class="fa fa-gears dropdown-toggle" title="Beállítások" id="dm<?=$d['product_id']?>" data-toggle="dropdown"></i>
                          <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$d['product_id']?>">
                          	<? if( is_null($d['aktivalva']) ): ?>
                          		<li role="presentation"><a role="menuitem" tabindex="-1" href="/watercard/activate/<?=$d['ID']?>">Kártya aktiválás <i class="fa fa-check"></i></a></li>
        		    		<? else: ?>
        		    			<li role="presentation"><a role="menuitem" tabindex="-1" href="/watercard/deactivate/<?=$d['ID']?>">Kártya inaktiválás <i class="fa fa-times"></i></a></li>
        		    		<? endif; ?>
                          	
        				    <li role="presentation"><a role="menuitem" tabindex="-1" href="/watercard/del/<?=$d['ID']?>">törlés <i class="fa fa-trash"></i></a></li>
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
    </div>
</form>
<br>
<?=$this->navigator?>
<? endif; ?>