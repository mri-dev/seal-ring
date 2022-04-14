<h1>Ajánló felirat <span><strong><?=$this->ajanlok['info']['total_num']?> db</strong> ajánló felirat</span></h1>
<?=$this->msg?>
<? if($this->gets['1'] == 'torles'): ?>
<form action="" method="post">
<input type="hidden" name="delId" value="<?=$this->gets['2']?>" />
<div class="row np">
    <div class="col-md-12">
        <div class="con con-del">
            <h2>Ajánló szöveg törlése</h2>
            Biztos, hogy törli a kiválasztott ajánló szöveget?
            <div class="row np">
                <div class="col-md-12 right">
                    <a href="/<?=$this->gets['0']?>/" class="btn btn-danger"><i class="fa fa-times"></i> NEM</a>
                    <button name="delHighlight" value="1" class="btn btn-success">IGEN <i class="fa fa-check"></i> </button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<? endif; ?>

<? if($this->gets['1'] != 'torles'): ?>
<div class="con <?=($this->gets['1'] == 'szerkeszt')?'con-edit':''?>">
    <form action="" method="post">
    <h2><? if($this->gets['1'] == 'szerkeszt'): ?>Ajánló szerkesztése<? else: ?>Új ajánló hozzáadása<? endif; ?></h2>
    <br>
    <div class="row">
        <div class="col-md-2">
            <label for="sorrend">Sorrend:</label>
            <input type="number" class="form-control" value="<?=($this->ajanlo ? $this->ajanlo['sorrend'] : '')?>" id="sorrend" name="sorrend" />
        </div>
        <div class="col-md-1">
            <label for="lathato">Látható:</label>
            <input type="checkbox" class="form-control" <?=($this->ajanlo && $this->ajanlo['lathato'] == '1' ? 'checked="checked"' : '')?> id="lathato" name="lathato" />
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <label for="tartalom">Ajánló felirat</label>
            <div style="background:#fff;"><textarea name="tartalom" id="tartalom" class="form-control"><?=($this->ajanlo ? $this->ajanlo['tartalom'] : '')?></textarea></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 right">
            <? if($this->gets['1'] == 'szerkeszt'): ?>
            <a href="/<?=$this->gets['0']?>"><button type="button" class="btn btn-danger btn-3x"><i class="fa fa-arrow-circle-left"></i> bezár</button></a>
            <button name="saveHighlight" class="btn btn-success">Változások mentése <i class="fa fa-check-square"></i></button>
            <? else: ?>
            <button name="addHighlight" value="1" class="btn btn-primary">Hozzáadás <i class="fa fa-check-square"></i></button>
            <? endif; ?>
        </div>
    </div>
    </form>
</div>
<? endif; ?>

<table class="table termeklista table-bordered">
	<thead>
    	<tr>
	        <th>Felirat</th>
	        <th>Sorrend</th>
	        <th>Aktív</th>
	        <th width="80"></th>
        </tr>
	</thead>
    <tbody>
    	<? if(count($this->ajanlok['data']) > 0): foreach($this->ajanlok['data'] as $d):  ?>
    	<tr class="<?=($this->gets['1'] == 'torles' && $this->gets['2'] == $d['ID'] ? 'dellitem' : '')?>">
	        <td>
          		<?=$d['tartalom']?>
            </td>
            <td width="100" class="center">
          		<?=$d['sorrend']?>
            </td>
            <td width="100" class="center">
          		<?=($d['lathato']) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'?>
            </td>
            <td class="center actions">
                <a href="/<?=$this->gets['0']?>/szerkeszt/<?=$d['ID']?>" title="Szerkesztés"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                <a href="/<?=$this->gets['0']?>/torles/<?=$d['ID']?>" title="Törlés"><i class="fa fa-times"></i></a>
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
