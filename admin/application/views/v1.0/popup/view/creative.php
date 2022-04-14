<? if($_GET['a'] == 'delete'): ?>
	<div class="panel panel-danger">
		<div class="panel-heading">Törlés megerősítése</div>
	  	<div class="panel-body">
	  		Biztos benne, hogy törli ezt a kreatívot és az összes hozzá kapcsolódó adatot?
	  		<br><br>
	  		<form method="post" action="">
	  			<a href="/popup" class="btn btn-default"> <i class="fa fa-angle-left"></i> mégse</a>
	  			<button class="btn btn-danger" name="deleteCreative" value="1">Végleges törlés <i class="fa fa-trash"></i></button>
	  		</form>
	  	</div>
	</div>
	<br>
	<br>
	<br>
	<br>
	<br>
<? endif; ?>

<h2> <a href="/popup/" class="btn btn-sm btn-default"><i class="fa fa-long-arrow-left"></i></a> <?=$this->creative->getName()?> <span>Kreatívok</span></h2>
<?=$this->msg?>
<br>
<?
	$screens = $this->screens->getList();
?>
<h3>Megjelenési formák (<?=count($screens)?>)</h3>
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th title="" width="40">#</th>	 
			<th>Elnevezés</th>	 
			<th width="120">Megjelenés arány</th>	
			<th>Állapot</th>
			<th width="80">Megjelent</th>
			<th width="160">Konverzió <br> (sikertelen / sikeres)</th>
			<th width="50" class="center"><i class="fa fa-gear"></i></th>   
        </tr>
	</thead>
    <tbody>
	<? 	
		foreach( $screens as $screen ): 
	?>
    	<tr>
	    	<td class="center"><?=$screen->getID()?></td>
	    	<td><strong><a href="/popup/?v=screen&s=<?=$screen->getID()?>"><?=$screen->getName()?></a></strong></td>
	    	<td class="center"><?=$screen->getShowWeight()?></td>
	    	<td width="80" class="center" style="color:white; background: <?=($screen->isActive())?'green':'red'?>">
	    		<?=($screen->isActive())?'Aktív':'Inaktív'?>
	    	</td>
	    	<td class="center"><?=$screen->getViewNum()?>x</td>	  
	    	<td class="center">
	    		<span><?=$screen->getFailConversionNum()?></span> /
	    		<span><?=$screen->getSuccessConversionNum()?></span>
	    		<div style="font-weight: bold; color: green;"><?=number_format( ( $screen->getSuccessConversionNum() / ($screen->getViewNum() / 100)), 2, ".", " " )?>%</div>
	    	</td>  	
	    	<td class="center">
	            <div class="dropdown">
	            	<i class="fa fa-gears dropdown-toggle" title="Beállítások" id="dm<?=$screen->getID()?>" data-toggle="dropdown"></i>
	                  <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$screen->getID()?>">
	                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/popup/?v=screen&s=<?=$screen->getID()?>">szerkesztés <i class="fa fa-pencil"></i></a></li>
	                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/popup/?v=screen&s=<?=$screen->getID()?>&a=copy">másolat készítés <i class="fa fa-copy"></i></a></li>
	                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/popup/?v=screen&s=<?=$screen->getID()?>&a=delete">végleges törlés <i class="fa fa-times"></i></a></li>
					  </ul>
	            </div>
            </td>
        </tr> 
    <? 	endforeach; ?> 
    <? if(count($screens) == 0): ?>
	    <tr>
		    <td class="center" colspan="20">
		    	<div class="no-item" style="padding: 50px;">Nincs létrehozott megjelenési forma.</div>
		    </td>
		</tr> 
    <? endif; ?>          	
    </tbody>
</table>

<h3>Beállítások</h3>
<?
	$settings = $this->creative->getSettings();
?>
<form method="post" action="">
	<div class="con">
		<div class="row">
			<div class="col-sm-6">
				<label>Elnevezés</label>
				<input type="text" class="form-control" name="name" value="<?=$this->creative->getName()?>">
			</div>
			<div class="col-sm-6">
				<label>Időtartam</label>
				<div class="input-group">
					<input type="date" class="form-control" name="active_from" value="<?=$this->creative->getDate('from')?>">
					<span class="input-group-addon"> &mdash; </span>
					<input type="date" class="form-control" name="active_to" value="<?=$this->creative->getDate('to')?>">
				</div>
				
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-6">
				<label>Aktivitás URL</label>
				<input type="text" class="form-control" name="check_url" value="<?=$this->creative->getActivityURI()?>">
			</div>
			<div class="col-sm-6">
				<label>Esemény típusa</label>
				<select class="form-control" name="type" onchange="switchFormView($(this).val());">
					<option value="" selected="selected">-- válasszon --</option>
					<option value="exit" <?=($this->creative->getType() == 'exit')?'selected="selected"':''?>>Kilépési szándék</option>
					<option value="scroll" <?=($this->creative->getType() == 'scroll')?'selected="selected"':''?>>Ablak görgetés</option>
					<option value="timed" <?=($this->creative->getType() == 'timed')?'selected="selected"':''?>>Időzített</option>
				</select>
			</div>
		</div>
		<div class="formview" id="fv-timed" style="<?=($this->creative->getType() == 'timed') ? 'display: block;' : 'display: none;'?>">		
			<br>
			<div class="divider"></div>
			<h4>Időzített esemény beállításai</h4>
			<br>
			<div class="row">				
				<div class="col-sm-4">
					<label>Késleltetés oldalbetöltéstől</label>
					<div class="input-group">
						<input type="number" class="form-control" name="settings['type']['timed']['timed_delay_sec']" value="<?=$settings['timed_delay_sec']?>">
						<span class="input-group-addon">másodperc</span>
					</div>		
				</div>
			</div>
			<br>
			<div class="divider"></div>
		</div>
		<div class="formview" id="fv-scroll" style="<?=($this->creative->getType() == 'scroll') ? 'display: block;' : 'display: none;'?>">		
			<br>
			<div class="divider"></div>
			<h4>Ablak görgetés esemény beállításai</h4>
			<br>
			<div class="row">				
				<div class="col-sm-4">
					<label>Mikor jelenjen meg a tartalom?</label>
					<div class="input-group">
						<input type="number" class="form-control" name="settings['type']['scroll']['scroll_percent_point']" value="<?=$settings['scroll_percent_point']?>">
						<span class="input-group-addon">% legörgetés után</span>
					</div>		
				</div>
			</div>
			<br>
			<div class="divider"></div>
		</div>
		<div class="formview" id="fv-exit" style="<?=($this->creative->getType() == 'exit') ? 'display: block;' : 'display: none;'?>">		
			<br>
			<div class="divider"></div>
			<h4>Kilépési szándék esemény beállításai</h4>
			<br>
			<div class="row">				
				<div class="col-sm-6">
					<label>Esemény késleltetés</label>
					<div class="input-group">
						<input type="number" class="form-control" name="settings['type']['exit']['exit_pause_delay_sec']" value="<?=$settings['exit_pause_delay_sec']?>">
						<span class="input-group-addon">másodperc</span>
					</div>	
					<em>Oldalbetöltés után ennyi idő elteltével aktív az esemény.</em>	
				</div>
			</div>
			<br>
			<div class="divider"></div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3">
				<label>Időtartam 2 megjelenítés között</label>
				<div class="input-group">
					<input type="number" class="form-control" name="settings['view_sec_btw']" value="<?=$settings['view_sec_btw']?>">
					<span class="input-group-addon">másodperc</span>
				</div>
				<em>60 = 1 perc, 3600 = 1 óra, 86400 = 1 nap</em>
			</div>	
			<div class="col-sm-3">
				<label>Maximális megjelenés</label>
				<div class="input-group">
					<input type="number" class="form-control" name="settings['view_max']" value="<?=$settings['view_max']?>">
					<span class="input-group-addon"> / felhasználó</span>
				</div>
			</div>		
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<label>Állapot</label>	
				<select class="form-control" name="active">
					<option value="0" <?=($this->creative->isActive() == 0)?'selected="selected"':'selected="selected"'?>>Inaktív</option>
					<option value="1" <?=($this->creative->isActive() == 1)?'selected="selected"':''?>>Aktív</option>
				</select>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<button class="btn btn-success" name="saveCreative" value="1">Változások mentése <i class="fa fa-save"></i></button>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	function switchFormView(v) {
		$('.formview').hide(0);

		$('.formview#fv-'+v).show(0);
	}
</script>