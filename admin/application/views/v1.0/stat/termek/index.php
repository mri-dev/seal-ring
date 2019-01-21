<script type="text/javascript">
$(function() {
    $( "#dateFrom" ).datepicker({
	  dateFormat: "yy-mm-dd",
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#dateTo" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#dateTo" ).datepicker({
	  dateFormat: "yy-mm-dd",
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#dateFrom" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
</script>
<div style="float:right;">
	<a href="/<?=$this->gets[0]?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> vissza</a>
	<a href="/<?=$this->gets[0]?>/kategoria" class="btn btn-default"><i class="fa fa-bars"></i> Kategória aktivitás</a>
	<a href="/<?=$this->gets[0]?>/kereses" class="btn btn-default"><i class="fa fa-search"></i> Keresés aktivitás</a>
</div>
<h1>Stat / Termék aktivitás</h1>
<div class="con">
	<div class="row np">
    	<form action="" method="get">
    	<div class="col-md-1" style="line-height:35px;">
        	<strong>Idő intervallum:</strong>
        </div>
        <div class="col-md-1 col-p-5"><input type="text" value="<?=$_GET[dateFrom]?>" placeholder="tól" class="form-control" id="dateFrom" name="dateFrom"></div>
        <div class="col-md-1 col-p-5"><input type="text" value="<?=$_GET[dateTo]?>" placeholder="ig" class="form-control" id="dateTo" name="dateTo"></div>
        <div class="col-md-1"><button class="btn btn-primary">Frissít</button></div>
        <div class="col-md-8 dateInfo" align="right">
        	<? if($_GET[dateFrom] != '' && $_GET[dateTo] != ''): ?>
            	<strong><?=$_GET[dateFrom]?></strong> &minus; <strong><?=$_GET[dateTo]?></strong>
            <? else: ?>
            	<strong><?=date('Y m')?>.</strong> hónap
            <? endif; ?>

        </div>
        </form>
    </div>
</div>
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th title="Termék ID" width="40">#TID</th>
            <th title="Cikkszám" width="150">Cikkszám</th>
            <th width="100">Nézettsége</th>
            <th>Termék</th>
            <th width="100">Újdonság</th>
            <th width="100">Akciós</th>
        </tr>
	</thead>
    <tbody>
    	<? if(count($this->stats[data]) > 0): foreach($this->stats[data] as $d):  ?>
    	<tr>
    		<td align="center"><?=$d[termekID]?></td>
            <td class="center"><?=$d['cikkszam']?></td>
            <td align="center"><strong><?=$d[me]?></strong></td>
            <td>
            	<strong><a href="/termekek/t/edit/<?=$d[termekID]?>" title="Admin adatlap"><?=$d[termek]?></a></strong>  &nbsp; <a style="color:black;" href="<?=HOMEDOMAIN.'termek/'.\PortalManager\Formater::makeSafeUrl($d['termek']).'_-'.$d['termekID']?>" target="_blank"><i class="fa fa-external-link" title="Publikus adatlap"></i></a>
                <div class="stat-feat-info">
                    <span class="text">Méret:</span> <?=($d[meret]) ? $d[meret] : '-'?> &nbsp; <span class="text">Szín:</span> <?=($d['szin'])?$d['szin']:'-'?>
                </div>               
            </td>
            <td align="center"><?=($d[ujdonsag] == '1')?'<i class="fa fa-check" title="Igen"></i>':'<i class="fa fa-times" title="Nem"></i>'?></td>
            <td align="center"><?=($d[akcios] == '1')?'<i class="fa fa-check" title="Igen"></i>':'<i class="fa fa-times" title="Nem"></i>'?></td>
            
    	</tr>
        <? endforeach; else: ?>
        <tr>
	    	<td colspan="15" align="center">
            	<div style="padding:25px;">Nincs adat!</div>
            </td>
        </tr>
        <? endif; ?>
    </tbody>
</table>