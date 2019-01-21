<div style="float:right;">
    <a href="/kedvezmenyek" class="btn btn-default">Törzsvásárlói kedvezmények</a>
</div>
<h1>Előrendelési kedvezmény</h1>
<script type="text/javascript">
	$(function(){
	
	})
</script>
<?=$this->bmsg?>
<? if($this->gets[1] == 'torles'): ?>
<form action="" method="post">
<input type="hidden" name="delId" value="<?=$this->gets[2]?>" />
<div class="row">
	<div class="col-md-12">
    	<div class="panel panel-danger">
        	<div class="panel-heading">
            <h2><i class="fa fa-times"></i> Kedvezmény törlése</h2>
            </div>
        	<div class="panel-body">
            	<div style="float:right;">
                	<a href="/<?=$this->gets[0]?>/" class="btn btn-danger"><i class="fa fa-times"></i> NEM</a>
                    <button class="btn btn-success">IGEN <i class="fa fa-check"></i> </button>
                </div>
            	<strong>Biztos, hogy törli a kedvezményt?</strong>
            </div>
        </div>
    </div>
</div>
</form>
<? else: ?>

<div class="row">
	<div class="col-md-12">
    	<div class="con <?=($this->gets[1] == 'szerkeszt')?'edit':''?>">
        	<form action="" method="post" enctype="multipart/form-data">
        	<h2><? if($this->gets[1] == 'szerkeszt'): ?>Kedvezmény szerkesztése<? else: ?>Új kedvezmény hozzáadása<? endif; ?></h2>
            <br>
            <div class="row">
                <div class="col-md-3 <?=($this->err && $_POST[ar_from] == '')?'has-error':''?>">
                	<div class="input-group">
                        <input type="number" value="<?=($this->err)?$_POST[ar_from]:$this->sm[ar_from]?>" id="ar_from" name="ar_from" class="form-control" />
                        <span class="input-group-addon">Ft-tól</span>
                    </div>
                </div>
                <div class="col-md-3 <?=($this->err && $_POST[ar_to] == '')?'has-error':''?>">
                	<div class="input-group">
                        <input type="number" value="<?=($this->err)?$_POST[ar_to]:$this->sm[ar_to]?>" name="ar_to" class="form-control" />
                        <span class="input-group-addon">Ft-ig</span>
                    </div>
                </div>
                <div class="col-md-2 <?=($this->err && $_POST[kedvezmeny] == '')?'has-error':''?>">
                	<div class="input-group">
                        <input type="text" value="<?=($this->err)?$_POST[kedvezmeny]:$this->sm[kedvezmeny]?>" name="kedvezmeny" class="form-control" />
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
                <div class="col-md-4" align="right">
                	<? if($this->gets[1] == 'szerkeszt'): ?>
                    <input type="hidden" name="id" value="<?=$this->gets[2]?>" />
                    <a href="/<?=$this->gets[0]?>"><button type="button" class="btn btn-danger btn-3x"><i class="fa fa-arrow-circle-left"></i> bezár</button></a>
                    <button name="saveKedvezmeny" class="btn btn-success">Változások mentése <i class="fa fa-check-square"></i></button>
                    <? else: ?>
                    <button name="addUjKedvezmeny" class="btn btn-primary">Hozzáadás <i class="fa fa-check-square"></i></button>
                    <? endif; ?>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="con">
	    	<div><h2>Kedvezmények</h2></div>
            <div style="padding:10px;">
            	<div class="row" style="color:#cccccc; margin-bottom:15px;">
                	<div class="col-md-3">Érték-től</div>
                    <div class="col-md-3">Érték-ig</div>
                    <div class="col-md-3">Kedvezmény (%)</div>
                    <div class="col-md-3"></div>
                </div>
            	<? foreach($this->kedvezmenyek as $d): ?>
            	<div class="row markarow">
                	<div class="col-md-3"><?='<strong>'.Helper::cashFormat($d[ar_from]).'</strong> Ft-tól'?></div>
                    <div class="col-md-3"><?=($d[ar_to] == 0)?'végtelenig':'<strong>'.Helper::cashFormat($d[ar_to]).'</strong> Ft-ig'?></div>
                    <div class="col-md-3"><?=$d[kedvezmeny]?>%</div>
                    <div class="col-md-3" align="right">
                    	<a href="/<?=$this->gets[0]?>/szerkeszt/<?=$d[ID]?>" title="Szerkesztés"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                        <a href="/<?=$this->gets[0]?>/torles/<?=$d[ID]?>" title="Törlés"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <? endforeach; ?>
            </div>
	    </div>
    </div>
</div>
<? endif; ?>