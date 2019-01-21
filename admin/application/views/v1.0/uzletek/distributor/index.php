<div style="float:right;">
	<a href="/uzletek/" class="btn btn-default"><i class="fa fa-arrow-left"></i> vissza</a>
	<a href="/uzletek/distributor/<?=$this->shop->getID()?>/?add=1" class="btn btn-primary">új tanácsadó bekapcsolása <i class="fa fa-plus"></i></a>
</div>
<h1><?=$this->shop->getName()?> <small>Tanácsadók kezelése</small></h1>
<? $distributors = $this->shop->getDistributors(); ?>
<?=$this->msg?>
<? if($_GET['add'] == '1'): ?>
<div class="con">
	<form action="" method="post">
		<h3>Tanácsadó adatokkal rendelkező hozzáadása</h3>
		<small>Válassza ki a felhasználót az alábbi listából.</small>
		<hr>
		<select class="form-control" name="distributor">
			<option value>-- válassza ki a felhasználót (<?=count($this->dist_users)?>) --</option>
			<option value disabled="disabled"></option>
			<? if( count($this->dist_users) > 0): ?>
			<? foreach( $this->dist_users as $du ): ?>
			<option value="<?=$du['ID']?>"><?=$du['nev']?> (<?=$du['email']?>)</option>
			<? endforeach; ?>
			<? endif; ?>
		</select>
		<hr>
		<div class="right">
			<a href="/uzletek/distributor/<?=$this->shop->getID()?>" class="btn btn-sm btn-default"><i class="fa fa-times"></i> mégse</a>
			<button class="btn btn-success" name="addDistributor" value="1">Hozzáadás <i class="fa fa-arrow-right"></i></button>
		</div>
	</form>
</div>
<br>
<? endif; ?>
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
    		<th width="80">Felh. ID</th>
    		<th>Felhasználó</th>
    		<th width="180" title="Alapértelmezett tanácsadó adati fognak megjelenni kapcsolattartónak az üzlet / casadapont kapcsán.">Alapértelmezett</th>
    		<th width="180">Jelentkezés ideje</th>
    		<th width="180">Engedélyezve</th>
			<th width="100"><i class="fa fa-gear"></i></th>   
        </tr>
	</thead>
    <tbody>
	<? 	foreach( $distributors as $distributor ): ?>
    	<tr>
    		<td class="center">
    			<?=$distributor['user_id']?>
    		</td>
    		<td><strong><?=$distributor['nev']?></strong> (<em><?=$distributor['email']?></em>)</td>
    		<td class="center"><? if($distributor['alapertelmezett'] == '1'): ?> <i class="fa fa-check"></i> <? else: ?><i class="fa fa-times"></i> <? endif; ?></td>
    		<td class="center"><?=$distributor['request_date']?></td>
    		<td class="center"><?=$distributor['allowed_date']?></td>
	    	<td align="center">
	            <div class="dropdown">           	
	            	<i class="fa fa-gears dropdown-toggle" title="Beállítások" id="dm" data-toggle="dropdown"></i>
	                  <ul class="dropdown-menu" role="menu" aria-labelledby="dm">

	                  	<? if($distributor['alapertelmezett'] == '0'): ?> 
						<li role="presentation"><a role="menuitem" tabindex="-1" href="/uzletek/distributor/<?=$this->shop->getID()?>/?detuserdefault=1&uid=<?=$distributor['user_id']?>">Legyen alapértelmezett <i class="fa fa-asterisk"></i></a></li>
	              		<? endif; ?>  
	              		<li role="presentation"><a role="menuitem" tabindex="-1" href="/account/?t=edit&ID=<?=$distributor['user_id']?>&ret=<?=$_SERVER[REQUEST_URI]?>">Felhasználó szerkesztése <i class="fa fa-pencil"></i></a></li>	                		                  	
	                  	<li role="separator" class="divider"></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" href="/uzletek/distributor/<?=$this->shop->getID()?>/?remove=1&uid=<?=$distributor['user_id']?>">Törlés <i class="fa fa-trash"></i></a></li>
					  </ul>
	            </div>
            </td>
        </tr> 
    <? 	endforeach; ?>           	
    </tbody>
</table>