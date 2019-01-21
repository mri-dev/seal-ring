<div style="float:right;">
	<a href="/kuponok/create" class="btn btn-primary"><i class="fa fa-plus-circle"></i> új kupon</a>
</div>
<h1>KUPONOK</h1>
<?=$this->msg?>
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th title="" width="40">Kupon kód</th>	   
			<th>Kupon elnevezése</th>    
			<th>Felhasználás limit (maradt)</th> 
			<th>Megrendelés összeg limit</th> 
			<th>Időtartam</th> 
			<th>I/O</th> 
			<th><i class="fa fa-gear"></i></th>   
        </tr>
	</thead>
    <tbody>
	<? 	
		while( $this->coupons->walk() ): 
		$item = $this->coupons->get();
	?>
    	<tr>
	    	<td class="center"><strong><?=$item->getCode()?></strong></td>
	    	<td>
	    		<?=$item->getTitle()?>
	    		<? if($item->hasAuthor()): ?>
	    		<div style="color:red;">Jegyzett kupon tulajdonos: <strong><? $author = $item->getAuthor(); echo $author[nev]; ?></strong> (<em><?=$author[email]?></em>)</div>
	    		<? endif; ?>
	    	</td>
	    	<td class="center"><?=$item->limitLeft()?> db</td>
	    	<td class="center">
	    		<? if(!$item->getMinOrderValue()): ?>
	    			Nincs limit
	    		<? else: ?>
	    			<?=Helper::cashFormat($item->getMinOrderValue())?> Ft
	    		<? endif; ?>

	    	</td>
	    	<td class="center"><?=$item->validFromDate()?> &nbsp; &mdash; &nbsp; <?=$item->validToDate()?></td>
	    	<td class="center"><? if($item->isActive()): ?><i class="fa fa-check vtgl" title="Aktív / Kattintson az inaktiváláshoz" tid="<?=$item->getCode()?>"></i><? else: ?><i class="fa fa-times vtgl" title="Inaktív / Kattintson az aktiváláshoz" tid="<?=$item->getCode()?>"></i><? endif; ?></td>
	    	<td align="center">
	            <div class="dropdown">
	            	<i class="fa fa-gears dropdown-toggle" title="Beállítások" id="dm<?=$item->getCode()?>" data-toggle="dropdown"></i>
	                  <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$item->getCode()?>">
	                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="/kuponok/edit/<?=$item->getCode()?>">szerkesztés <i class="fa fa-pencil"></i></a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" href="/kuponok/del/<?=$item->getCode()?>">törlés <i class="fa fa-times"></i></a></li>
					  </ul>
	            </div>
            </td>
        </tr> 
    <? 	endwhile; ?>           	
    </tbody>
</table>

<script type="text/javascript">
	$(function(){
		$('.termeklista i.vtgl').click(function(){
			visibleToggler($(this));
		});
	})

	function visibleToggler(e){
        var tid = e.attr('tid'); 
        var src =  e.attr('class').indexOf('check');
        
        if(src >= 0){
            e.removeClass('fa-check').addClass('fa-spinner fa-spin');
            doVisibleChange(e, tid, false);
        }else{
            e.removeClass('fa-times').addClass('fa-spinner fa-spin');
            doVisibleChange(e, tid, true);
        }   
    }

	function doVisibleChange(e, tid, show){
		var v = (show) ? '1' : '0';
		$.post("<?=AJAX_POST?>",{
			type : 'couponsChangeActions',
			mode : 'io',
			code : tid,
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


