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
	<a class="btn btn-primary" href="/<?=$this->gets['0']?>/uj"><i class="fa fa-plus-circle"></i> új bejegyzés</a>
</div>
<h1>Forgalmak</h1>
<div class="row">
	<div class="col-md-2" style="padding:0;">
    	<div>
            <div class="box green">
                <div class="head">
                    <div class="txt">
                        <div><strong><i class="fa fa-plus"></i> BEVÉTEL</strong></div>
                    </div>
                </div>
                <div class="c">
					<? if($_COOKIE['filter_dateFrom'] == '' && $_COOKIE['filter_dateTo'] == ''):?>
                	<div class="row">
                    	<div class="col-md-3">Havi</div>
                		<div class="col-md-9"><strong><?=Helper::cashFormat($this->trafficInfo['latest']['in'])?> Ft</strong></div>
                	</div>
                    <div class="row">
                    	<div class="col-md-3">Összes</div>
                		<div class="col-md-9"><strong><?=Helper::cashFormat($this->trafficInfo['all']['in'])?> Ft</strong></div>
                	</div>
					<? else: ?>
					<div class="row">
                    	<div class="col-md-12" align="center">
							<strong style="font-size:23px;"><?=Helper::cashFormat($this->allTraffic['traffic']['income'])?> Ft</strong>
						</div>
					</div>
					<? endif; ?>
                </div>
            </div>
            <br />
            <div class="box red">
                <div class="head">
                    <div class="txt">
                        <div><strong><i class="fa fa-minus"></i> KIADÁS</strong></div>
                    </div>
                </div>
                <div class="c">
					<? if($_COOKIE['filter_dateFrom'] == '' && $_COOKIE['filter_dateTo'] == ''):?>
                	<div class="row">
                    	<div class="col-md-3">Havi</div>
                		<div class="col-md-9"><strong><?=Helper::cashFormat($this->trafficInfo['latest']['out'])?> Ft</strong></div>
                	</div>
                    <div class="row">
                    	<div class="col-md-3">Összes</div>
                		<div class="col-md-9"><strong><?=Helper::cashFormat($this->trafficInfo['all']['out'])?> Ft</strong></div>
                	</div>
					<? else: ?>
					<div class="row">
                    	<div class="col-md-12" align="center">
							<strong style="font-size:23px;"><?=Helper::cashFormat($this->allTraffic['traffic']['outgo'])?> Ft</strong>
						</div>
					</div>
					<? endif; ?>
                </div>
            </div>
			<br />
            <div class="box orange">
                <div class="head">
                    <div class="txt">
                        <div><strong><i class="fa fa-question"></i> HASZON</strong></div>
                    </div>
                </div>
                <div class="c">
					<? if($_COOKIE['filter_dateFrom'] == '' && $_COOKIE['filter_dateTo'] == ''):?>
                	<div class="row">
                    	<div class="col-md-3">Havi</div>
                		<div class="col-md-9"><strong><?=Helper::cashFormat($this->trafficInfo['latest']['in']-$this->trafficInfo['latest']['out'])?> Ft</strong></div>
                	</div>
                    <div class="row">
                    	<div class="col-md-3">Összes</div>
                		<div class="col-md-9"><strong><?=Helper::cashFormat($this->trafficInfo['all']['in']-$this->trafficInfo['all']['out'])?> Ft</strong></div>
                	</div>
					<? else: ?>
					<div class="row">
                    	<div class="col-md-12" align="center">
							<strong style="font-size:23px;"><?=Helper::cashFormat($this->allTraffic['traffic']['income']-$this->allTraffic['traffic']['outgo'])?> Ft</strong>
						</div>
					</div>
					<? endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10" style="padding-left:15px;">
		<form action="" method="post">
    	<table class="table termeklista table-bordered">
        	<thead>
            	<tr>
                	<th width="100">Forgalom</th>
                    <th width="120">Érték</th>
                    <th>Megjegyzés</th>
                    <th width="150">Kapcsolt azonosító</th>
                    <th width="150">Típus</th>
            		<th width="200">Időpont</th>
					<th width="80"></th>
            	</tr>
            </thead>
            <tbody>
                <tr class="search <? if($_COOKIE['filtered'] == '1'): ?>filtered<? endif;?>">
                	<td>
                    <select class="form-control"  name="forgalom" style="max-width:100px;">
                    	<option value="" selected="selected"># Mind</option>
                        <option value="bevetel" <?=($_COOKIE['filter_forgalom'] == 'bevetel')?'selected':''?>>Bevétel</option>
                        <option value="kiadas" <?=($_COOKIE['filter_forgalom'] == 'kiadas')?'selected':''?>>Kiadás</option>
                    </select>
                	</td>
                    <td></td>
                    <td><input type="text" name="megnevezes" class="form-control" value="<?=$_COOKIE['filter_megnevezes']?>" placeholder="Megnevezés..." /></td>
                    <td><input type="text" name="itemid" class="form-control" value="<?=$_COOKIE['filter_itemid']?>" placeholder="Azonosító" /></td>
                    <td>
					<select class="form-control"  name="tipus" style="max-width:150px;">
                    	<option value="" selected="selected"># Mind</option>
						<option value="" disabled></option>
						<? $data = $this->kulcsok;
						foreach($data as $d): ?>
							<option value="<?=$d['key']?>" <?=($_COOKIE['filter_tipus'] == $d['key'])?'selected':''?>><?=$d['key']?></option>
						<? endforeach; ?>
                    </select>
					</td>
					<td>
						<div class="input-group">
							<input id="dateFrom" type="text" name="dateFrom" style="width:45%;" value="<?=$_COOKIE['filter_dateFrom']?>"  />
							<span style="width:10%; text-align:center; display:inline-block;">-</span>
							<input id="dateTo" type="text" name="dateTo" value="<?=$_COOKIE['filter_dateTo']?>" style="width:45%;" />
						</div>
					</td>
            		<td align="center">
						<? if($_COOKIE['filtered'] == '1'): ?>
						<a title="Szűrés eltávolítása" href="/<?=$this->gets['0']?>/clearfilters/" class="btn btn-danger btn-sm"><i style="color:white;" class="fa fa-times"></i></a>
						<? endif;?>
						<button name="filterList" value="1" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
					</td>
                </tr>
                <? foreach($this->allTraffic['data'] as $d): ?>
                <tr class="table-tr td-bg-<?=($d['bevetel'] > 0)?'green':'red'?>">
            		<td align="center"><strong><?=($d['bevetel'] > 0)?'BEVÉTEL':'KIADÁS'?></strong></td>
                    <td align="center"><strong><?=($d['bevetel'] == 0)?'-'.Helper::cashFormat($d['kiadas']):'+'.Helper::cashFormat($d['bevetel'])?> Ft</strong></td>
                    <td><strong><?=$d['megnevezes']?></strong></td>
                    <td align="center"><? if($d['item_id'] != ''): ?><a target="_blank" href="<? switch($d['tipus_kulcs']){
						case 'income_by_buy': case 'outgo_by_buy':
							echo 'megrendelesek?ID='.$d['item_id'];
						break;
					} ?>">#<?=$d['item_id']?></a><? else: ?>-<? endif; ?></td>
                    <td align="center"><?=$d['tipus_kulcs']?></td>
                    <td align="center"><?=Helper::softDate($d['idopont'])?></td>
					<td></td>
            	</tr>
                <? endforeach; ?>
            </tbody>
        </table>
        </form>
        <ul class="pagination">
          <li><a href="/<?=$this->gets['0']?>/-/1">&laquo;</a></li>
          <? for($p = 1; $p <= $this->allTraffic['info']['pages']['max']; $p++): ?>
          <li class="<?=(Helper::currentPageNum() == $p)?'active':''?>"><a href="/<?=$this->gets['0']?>/-/<?=$p?>"><?=$p?></a></li>
          <? endfor; ?>
          <li><a href="/<?=$this->gets['0']?>/-/<?=$this->allTraffic['info']['pages']['max']?>">&raquo;</a></li>
        </ul>
    </div>
</div>