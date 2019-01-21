<h2>Kreatívok</h2>
<?=$this->msg?>
<br>
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th title="" width="40">#</th>	 
			<th>Elnevezés</th>	 
			<th>URL</th>
			<th width="150">Esemény típusa</th>
			<th>Állapot</th>
			<th>Megjelent</th>
			<th width="160">Konverzió <br> (sikertelen / sikeres)</th>
			<th width="200">Időtartam</th>			
			<th width="50" class="center"><i class="fa fa-gear"></i></th>   
        </tr>
	</thead>
    <tbody>
	<? 	
		foreach( $this->creatives->getList() as $creative ): 
	?>
    	<tr>
	    	<td class="center"><?=$creative->getID()?></td>
	    	<td><strong><a href="/popup/?v=creative&c=<?=$creative->getID()?>"><?=$creative->getName()?></a></strong></td>
	    	<td><em><?=$creative->getActivityURI()?></em></td>
	    	<td class="center"><?=$creative->getType(true)?></td>
	    	<td width="80" class="center" style="color:white; background: <?=($creative->isActive())?'green':'red'?>">
	    		<?=($creative->isActive())?'Aktív':'Inaktív'?>
	    	</td>
	    	<td class="center" width="50"><?=$creative->getViewNum()?>x</td>
	    	<td class="center">
	    		<span><?=$creative->getFailConversionNum()?></span> /
	    		<span><?=$creative->getSuccessConversionNum()?></span>
	    		<div style="font-weight: bold; color: green;"><?=number_format( ( $creative->getSuccessConversionNum() / ($creative->getViewNum() / 100)), 2, ".", " " )?>%</div>
	    	</td>
	    	<td class="center"><?=$creative->getDate('from')?> &mdash; <?=$creative->getDate('to')?></td>
	    	<td class="center">
	            <div class="dropdown">
	            	<i class="fa fa-gears dropdown-toggle" title="Beállítások" id="dm<?=$creative->getID()?>" data-toggle="dropdown"></i>
	                  <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$creative->getID()?>">
	                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/popup/?v=creative&c=<?=$creative->getID()?>&a=copy">másolat készítése <i class="fa fa-copy"></i></a></li>
	                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/popup/?v=creative&c=<?=$creative->getID()?>&a=delete">végleges törlés <i class="fa fa-times"></i></a></li>
					  </ul>
	            </div>
            </td>
        </tr> 
    <? 	endforeach; ?>           	
    </tbody>
</table>
