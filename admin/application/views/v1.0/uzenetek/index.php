<h1>Üzenetek <span><strong><?=Helper::cashFormat($this->uzenetek['info']['total_num'])?> db</strong> üzenet <? if($_COOKIE['filtered'] == '1'): ?><span class="filtered">Szűrt üzenetek listázása <a href="/uzenetek/clearfilters/" class="btn btn-danger">eltávolítás</a></span><? endif; ?></span></h1>
<?=$this->rmsg?>
<div class="clr"></div>
<? if($this->gets['1'] != 'dell'): ?>
<form action="" method="post">
<div class="tbl-container overflowed">
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th title="Üzenet ID" width="40">#</th>
	    <th width="220">Küldő</th>
			<th>Téma</th>
			<th width="180">Időpont</th>
			<th width="180">Válaszolva</th>
			<th width="120" title="Archiválva"><i class="fa fa-eye"></i></th>
            <th width="20"></th>
        </tr>
	</thead>
    <tbody>
    	<tr class="search <? if($_COOKIE['filtered'] == '1'): ?>filtered<? endif;?>">
    		<td><input type="text" name="ID" class="form-control" value="<?=$_COOKIE['filter_ID']?>" /></td>
            <td><input type="text" name="contact" placeholder="név vagy email..." class="form-control" value="<?=$_COOKIE['filter_contact']?>" /></td>

			<td><input type="text" name="uzenet_targy" placeholder="tárgy megnevezése..." class="form-control" value="<?=$_COOKIE['filter_uzenet_targy']?>" /></td>
			<td></td>
			<td>
				<select class="form-control"  name="fvalaszolva" style="max-width:200px;">
					<option value="" selected="selected"># Mind</option>
                    <option value="1" <?=($_COOKIE['filter_fvalaszolva'] == '1')?'selected':''?>>Igen</option>
					<option value="0" <?=($_COOKIE['filter_fvalaszolva'] == '0')?'selected':''?>>Nem</option>
                </select>
			</td>
			<td>
				<select class="form-control"  name="farchivalt" style="max-width:200px;">
					<option value="" selected="selected"># Mind</option>
                    <option value="1" <?=($_COOKIE['filter_farchivalt'] == '1')?'selected':''?>>Igen</option>
					<option value="0" <?=($_COOKIE['filter_farchivalt'] == '0')?'selected':''?>>Nem</option>
                </select>
			</td>
    		<td align="center">
            	<button name="filterList" class="btn btn-default"><i class="fa fa-search"></i></button>
            </td>
    	</tr>
    	<? if(count($this->uzenetek['data']) > 0): foreach($this->uzenetek['data'] as $d):  ?>
    	<tr class="<? if($d['archivalva'] == 1): ?>archived<? endif; ?>">
	    	<td align="center">
				<?=$d['ID']?><br />
				<input type="checkbox" name="selectedItem[]" value="<?=$d['ID']?>" />
			</td>
			<td>
				<div style="font-size:1.2em;"><strong><?=$d['felado_nev']?></strong></div>
				<div style="color:#888;">
					<em>
					<?php
					switch ($d['tipus']) {
						case 'recall':
							echo $d['felado_telefon'];
						break;
						case 'ajanlat': case 'requesttermprice':
							echo '<a href="mailto:'.$d['felado_email'] . '?subject=Válasz: '.( ($d['tipus']=='ajanlat')?'Ingyenes ajánlatkérésre':'Termékár kérésre').'.">'.$d['felado_email'] . '</a> &nbsp;&bull;&nbsp; '.$d['felado_telefon'];
						break;
					}
					?>
					</em>
				</div>
			</td>
			<td><strong>
			<?
				switch($d['tipus']){
					case 'recall':
						echo '<i style="width:15px;" class="fa fa-phone"></i>';
					break;
					case 'ajanlat':
						echo '<i style="width:15px;" class="fa fa-file"></i>';
					break;
					case 'requesttermprice':
						echo '<i style="width:15px;" class="fa fa-archive"></i>';
					break;
				}
			?>
			<?=$d['uzenet_targy']?>
			<? if($d['felado_email'] != '' && !$d['valaszolva']){ echo ' - <span style="color:#FF0000;">E-mail válaszra vár!</span>'; } ?>
			</strong></td>
			<td align="center"><?=\PortalManager\Formater::dateFormat($d['elkuldve'], $this->settings['date_format'])?></td>
			<td align="center">
				<? if($d['valaszolva']): ?>
					<i class="fa fa-check" style="font-size:20px; color:green;"></i>
					<div><?=\PortalManager\Formater::dateFormat($d['valaszolva'], $this->settings['date_format'])?></div>
				<? else: ?>
					<?=\PortalManager\Formater::dateFormat($d['valaszolva'], $this->settings['date_format'])?>
				<? endif; ?>
			</td>
			<td align="center">
				<? if($d['archivalva'] == '1'): ?>
					<i class="fa fa-check vtgl" title="Archiválás megszüntetése" tid="<?=$d['ID']?>"></i>
				<? else: ?>
					<i class="fa fa-times vtgl" title="Archiválás" tid="<?=$d['ID']?>"></i>
				<? endif; ?>
			</td>
			<td class="center">
				<a class="btn btn-default btn-sm" href="/<?=$this->gets['0']?>/msg/<?=$d['ID']?>"><i class="fa fa-eye"></i></a>
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
<? if(true): ?>
	<div class="con padding-vertical-5">
		<div class="tbl">
			<div class="tbl-col" style="border-right:1px solid #ddd; width:40px;" align="center">
				<input type="checkbox" id="selectAll" />
			</div>
			<div class="tbl-col">
				<div class="padding-horizontal-5">
				<!-- Actions -->
					<select name="selectAction" id="selectAction" class="form-control">
						<option value=""># Kiválasztott üzenetek módosítása! Művelet kiválasztása...</option>
						<option value="" disabled></option>
						<option value="action_archivalva">Archiválás</option>
						<option value="action_torles">Végleges törlés (nem visszavonható)</option>
					</select>
				<!--//Actions -->
				</div>
			</div>
			<div class="tbl-col">
				<!-- Action - Achiválva -->
				<div id="action_archivalva" class="hided actionContainer">
					<select name="action_archivalva" id="action_archivalva" class="form-control">
						<option value="">-- állapot kiválasztása --</option>
						<option value="" disabled></option>
						<option value="0">Nem</option>
						<option value="1">Igen</option>
					</select>
				</div>
				<!--//Action - Achiválva -->
				<!-- Action - Achiválva -->
				<div id="action_torles" class="hided actionContainer">
					<select name="action_torles" id="action_torles" class="form-control">
						<option value="">-- Biztos, hogy törli? --</option>
						<option value="" disabled></option>
						<option value="0">Nem</option>
						<option value="1">Igen</option>
					</select>
				</div>
				<!--//Action - Achiválva -->
			</div>
			<div id="action_value" class="tbl-col actionContainer hided">
				<input type="text" name="action_value" class="form-control" placeholder="érték megadása..." />
			</div>
			<div class="tbl-col" style="width:105px;" align="center">
				<button class="btn btn-success" name="actionSaving" value="true" type="submit">Végrehajtás</button>
			</div>
		</div>
	</div>
<? endif; ?>
</form>
<ul class="pagination">
  <li><a href="/<?=$this->gets['0']?>/<?=($this->gets['1'] != '')?$this->gets['1'].'/':'-/'?>1">&laquo;</a></li>
  <? for($p = 1; $p <= $this->uzenetek['info']['pages']['max']; $p++): ?>
  <li class="<?=(Helper::currentPageNum() == $p)?'active':''?>"><a href="/<?=$this->gets['0']?>/<?=($this->gets['1'] != '')?$this->gets['1'].'/':'-/'?><?=$p?>"><?=$p?></a></li>
  <? endfor; ?>
  <li><a href="/<?=$this->gets['0']?>/<?=($this->gets['1'] != '')?$this->gets['1'].'/':'-/'?><?=$this->uzenetek['info']['pages']['max']?>">&raquo;</a></li>
</ul>
<? endif; ?>

<script type="text/javascript">
	$(function(){
		$('.termeklista i.vtgl').click(function(){
			visibleToggler($(this));
		});

		$('#selectAll').change(function(){
			var sa 	= $(this).is(':checked');
			var chs = $('.termeklista').find('input[type=checkbox]');
			if(sa){
				chs.prop("checked", !chs.prop("checked"));
			}else{
				chs.prop("checked", !chs.prop("checked"));
			}
		});

		$('#selectAction').change(function(){
			var v 		= $(this).val();
			var isval 	= v.indexOf('action_value');

			$('.actionContainer').hide();

			if(isval === -1){
				$('#'+v).show();
			}else if(isval === 0){
				$('#action_value').show();
			}
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
			type : 'uzenetek',
			mode : 'toggleArchive',
			id 	: tid,
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
