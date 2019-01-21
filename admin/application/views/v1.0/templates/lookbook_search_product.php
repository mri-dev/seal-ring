<? foreach ( $view->product_list as $d ) :?>
<div class="src-item">
	<div class="adder">
		<a href="javascript:void(0);" onclick="add_product_to_container(<?=$view->book?>, '<?=$view->position?>', <?=$view->container?>, $(this), { id: <?=$d['product_id']?>, name: '<?=$d['product_nev'].' ('.$d['cikkszam'].')'?>' });" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
	</div>
	<div class="img"><img src="<?=$d['profil_kep']?>" style="max-height:50px;" alt=""></div>
	<div>
		<strong><a href="<?=HOMEDOMAIN?>termek/<?=\PortalManager\Formater::makeSafeUrl($d['product_nev'],'_-'.$d['product_id'])?>" target="_blank"><?=$d['product_nev']?></a></strong>
		<div> 
			<em>
				#<?=$d['product_id']?>,
				cikkszám: <strong><?=$d['cikkszam']?></strong>,
				színvariációk: <strong> <?=count($d['hasonlo_termek_ids']['colors'])?> db</strong>
			</em>
		</div>
	</div>
	<div class="clr"></div>
</div>
<div class="divider"></div>
<? endforeach; ?>