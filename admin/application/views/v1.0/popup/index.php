<?php 
	$view = (isset($_GET['v']) && !empty($_GET['v'])) ? $_GET['v'] : 'creatives'; 
?>
<div class="popup-view" ng-controller="popup" data-ng-init="init('<?=$_GET['v']?>', <?=($this->creative) ? $this->creative->getID(): 0?>, <?=($this->screen) ? $this->screen->getID(): 0?>)">
	<div class="vhead"><h1>Felugróablak kezelő</h1></div>
	<div class="row np">
		<div class="col-sm-3">
			<div class="menu">
				<ul>
					<li class="<?=(!isset($_GET['v']))?'on':''?>"><a href="/popup/">Összes kreatív</a></li>
					<li class="<?=(isset($_GET['v']) && $_GET['v'] == 'creative_create')?'on':''?>"><a href="/popup/?v=creative_create">Kreatív létrehozás</a></li>
					<? echo $this->render('popup/menu/'.$view); ?>
				</ul>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="inside">
			<?
				if ($_GET['p']) {
					$view = $_GET['p'];
				}
			?>
				<? echo $this->render('popup/view/'.$view); ?>
			</div>
		</div>
	</div>
</div>