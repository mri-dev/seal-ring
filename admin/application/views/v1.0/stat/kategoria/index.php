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
	<a href="/<?=$this->gets['0']?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> vissza</a>
	<a href="/<?=$this->gets['0']?>/termek" class="btn btn-default"><i class="fa fa-th"></i> Termék aktivitás</a>
	<a href="/<?=$this->gets['0']?>/kereses" class="btn btn-default"><i class="fa fa-search"></i> Keresés aktivitás</a>
</div>
<h1>Stat / Kategória aktivitás</h1>
<div class="con">
	<div class="row np">
    	<form action="" method="get">
    	<div class="col-md-1" style="line-height:35px;">
        	<strong>Idő intervallum:</strong>
        </div>
        <div class="col-md-1 col-p-5"><input type="text" value="<?=$_GET['dateFrom']?>" placeholder="tól" class="form-control" id="dateFrom" name="dateFrom"></div>
        <div class="col-md-1 col-p-5"><input type="text" value="<?=$_GET['dateTo']?>" placeholder="ig" class="form-control" id="dateTo" name="dateTo"></div>
        <div class="col-md-1"><button class="btn btn-primary">Frissít</button></div>
        <div class="col-md-8 dateInfo" align="right">
        	<? if($_GET['dateFrom'] != '' && $_GET['dateTo'] != ''): ?>
            	<strong><?=$_GET['dateFrom']?></strong> &minus; <strong><?=$_GET['dateTo']?></strong>
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
            <th width="10%">Nézettsége</th>
            <th width="">Kategória</th>
        </tr>
	</thead>
    <tbody>
    	<? if(count($this->stats['data']) > 0): foreach($this->stats['data'] as $d):  ?>
    	<tr>
          <td align="center"><strong><?=$d['me']?></strong></td>
          <td>
          	<a href="<?=HOMEDOMAIN?>termekek/<?=\PortalManager\Formater::makeSafeUrl($d['kategoriaNev'].'_-'.$d['kat_id'])?>" target="_blank"><?=$d['kategoriaNev']?></a>
          </td>
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