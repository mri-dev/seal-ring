<script type="text/javascript">
	$(function(){
		$('#fgt').change(function(){
			var v = $(this).val();
			if(v == '<?=Traffic_Model::TYPE_TRAFFIC_INCOME?>'){
				$('#key_str').text('income_');
				$('#traffic_prefix').val('income_');
			}else{
				$('#key_str').text('outgo_');
				$('#traffic_prefix').val('outgo_');
			}
		});
	})
</script>

<?=$this->bmsg?>
<? if($this->gets[2] == 'torles'): ?>
<form action="" method="post">
<input type="hidden" name="delId" value="<?=$this->gets[3]?>" />
<div class="row">
	<div class="col-md-12">
    	<div class="panel panel-danger">
        	<div class="panel-heading">
            <h2><i class="fa fa-times"></i> Forgalom típus kulcs törlése</h2>
            </div>
        	<div class="panel-body">
            	<div style="float:right;">
                	<a href="/<?=$this->gets[0]?>/<?=$this->gets[1]?>" class="btn btn-danger"><i class="fa fa-times"></i> NEM</a>
                    <button class="btn btn-success">IGEN <i class="fa fa-check"></i> </button>
                </div>
            	<strong>Biztos, hogy törli a kiválasztott forgalom típus kulcsot? Nem ajánlott (!), ha már korábban használatban volt ez a kulcs!</strong>
            </div>
        </div>
    </div>
</div>
</form>
<? else: ?>
<div style="float:right;">
	<a href="/<?=$this->gets[0]?>/uj" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> vissza</a>
</div>
<h1>Forgalom típus kulcsok</h1>
<div class="con <?=($this->gets[2] == 'szerkeszt')?'edit':''?>">
	<form action="" method="post" enctype="multipart/form-data">
	<h2><? if($this->gets[2] == 'szerkeszt'): ?>Típus kulcs szerkesztése<? else: ?>Típus kulcs hozzáadása<? endif; ?></h2>
	<br>
	<div class="row">
		<div class="col-md-4">
			Alapé. megnevezés: <input type="text" class="form-control" name="megnevezes" value="<?=($this->err)?$_POST[megnevezes]:$this->sm[nev]?>">
		</div>
		<div class="col-md-2">
			Forgalom típus:
			<select name="forgalom_tipus" id="fgt" class="form-control">
				<option value="" selected>-- válasszon --</option>
				<option value="<?=Traffic_Model::TYPE_TRAFFIC_INCOME?>" <?=(($this->err && $_POST[forgalom_tipus] == Traffic_Model::TYPE_TRAFFIC_INCOME) || (strpos($this->sm[kulcs],'income_') === 0))?'selected':''?>>Bevétel</option>
				<option value="<?=Traffic_Model::TYPE_TRAFFIC_OUTGO?>" <?=(($this->err && $_POST[forgalom_tipus] == Traffic_Model::TYPE_TRAFFIC_OUTGO) || (strpos($this->sm[kulcs],'outgo_') === 0))?'selected':''?>>Kiadás</option>
			</select>
		</div>
		<div class="col-md-3">
			Típus kulcs:
			<input type="hidden" id="traffic_prefix" name="traffic_prefix" value="<?=($this->err)?$_POST[traffic_prefix]:((strpos($this->sm[kulcs],'income_') === 0)?'income_':'outgo_')?>" />
			<div class="input-group">
				<span id="key_str" class="input-group-addon"><?=($this->err)?$_POST[traffic_prefix]:(($this->sm[kulcs] != '')?((strpos($this->sm[kulcs],'income_') === 0)?'income_':'outgo_'):'??')?></span>
				<input type="text" class="form-control" name="key" placeholder="telefon_szamla" value="<?=($this->err)?$_POST[key]:str_replace(array('income_','outgo_'),'',$this->sm[kulcs])?>">
			</div>
		</div>
		<div class="col-md-3" align="right">
		<br>
			<? if($this->gets[2] == 'szerkeszt'): ?>
			<input type="hidden" name="id" value="<?=$this->gets[3]?>" />
			<a href="/<?=$this->gets[0]?>/<?=$this->gets[1]?>"><button type="button" class="btn btn-danger btn-3x"><i class="fa fa-arrow-circle-left"></i> bezár</button></a>
			<button name="save" class="btn btn-success">Változások mentése <i class="fa fa-check-square"></i></button>
			<? else: ?>
			<button name="add" class="btn btn-primary">Hozzáadás <i class="fa fa-check-square"></i></button>
			<? endif; ?>
		</div>
	</div>
	</form>
</div>
<div class="con">
	<h2>Típus kulcsok</h2>
	<br />
	<div class="row" style="color:#aaa;">
		<div class="col-md-4">
			<em>Alapé. megnevezes</em>
		</div>
		<div class="col-md-2">
			<em>Forgalom típus</em>
		</div>
		<div class="col-md-3">
			<em>Típus kulcs</em>
		</div>
		<div class="col-md-2">
			<em>Alapé. érték</em>
		</div>
		<div class="col-md-1" align="right">
			
		</div>
	</div>
	<? $data = $this->kulcsok;
	foreach($data as $d): ?>
		<div class="row markarow" <? if(!$d[isDefault]): ?>style="font-size:1.1em; color:#222;"<? endif; ?>>
			<div class="col-md-4">
				<strong><?=$d[comment]?></strong>
			</div>
			<div class="col-md-2">
				<? if($d[trafficType] == Traffic_Model::TYPE_TRAFFIC_OUTGO): ?>
					<span style="color:red;">Kiadás</span>
				<? elseif($d[trafficType] == Traffic_Model::TYPE_TRAFFIC_INCOME):?>
					<span style="color:green;">Bevétel</span>
				<? endif; ?>
			</div>
			<div class="col-md-3">
				<em><?=$d[key]?></en>
			</div>
			<div class="col-md-2" style="color:#aaa;">
				<? if($d[isDefault]): ?>
					<i class="fa fa-check"></i>
				<? else: ?>
					<i class="fa fa-times"></i>
				<? endif; ?>
			</div>
			<div class="col-md-1" align="right">
				<? if(!$d[isDefault]): ?>
				<a href="/<?=$this->gets[0]?>/<?=$this->gets[1]?>/szerkeszt/<?=$d[key]?>"><i class="fa fa-pencil"></i></a>
				<a href="/<?=$this->gets[0]?>/<?=$this->gets[1]?>/torles/<?=$d[key]?>"><i class="fa fa-times"></i></a>
				<? else: ?>
				<em>Alapé. érték</em>
				<? endif; ?>
			</div>
		</div>
	<? endforeach; ?>
</div>
<? endif; ?>