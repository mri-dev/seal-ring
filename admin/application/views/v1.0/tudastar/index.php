<h1>Tudástár</h1>
<?php echo $this->rmsg; ?>
<?php
  $cat_type = 'add';
  if ($_GET['edit'] == 'category') {
    $cat_type = 'edit';
  }
  if ($_GET['del'] == 'category') {
    $cat_type = 'del';
  }
?>
<div class="row">
  <div class="col-md-4">
    <?php if ($_GET['add'] == 'category' || $_GET['edit'] == 'category' || $_GET['del'] == 'category'): ?>
    <div class="con <?=($cat_type=='edit')?'edit':(($cat_type=='del')?'con-del':'')?>">
      <h2><?php switch ($cat_type) {
        case 'add': echo 'Új témakör hozzáadása'; break;
        case 'edit': echo 'Témakör szerkesztése'; break;
        case 'del': echo 'Témakör törlése'; break;
      } ?></h2>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?=$this->c['ID']?>">
        <?php if ($_GET['del'] == 'category'): ?>
        <div class="row">
          <div class="col-md-12">
            Biztos, hogy véglegesen törli a(z) <strong><?=$this->c['cim']?></strong> témakört? A művelet nem visszavonható.
          </div>
        </div>
        <br>
        <?php else: ?>
        <div class="row">
          <div class="col-md-8">
            <label for="cat_cim">Témakör címe *</label>
            <input type="text" class="form-control" name="cim" value="<?=($this->err)?$_POST['cim']:$this->c[cim]?>" id="cat_cim">
          </div>
          <div class="col-md-4">
            <label for="cat_sorrend">Sorrend</label>
            <input type="text" class="form-control" name="sorrend" value="<?=($this->err)?$_POST['sorrend']:(($this->c)?$this->c[sorrend]:100)?>" id="cat_sorrend">
          </div>
        </div>
        <br>
        <?php endif; ?>
        <div class="row">
          <div class="col-md-12 right">
            <a href="/tudastar" class="pull-left btn btn-default"> <i class="fa fa-angle-left"></i> mégse</a>
            <button type="submit" class="btn <?php switch ($cat_type) {
              case 'add': echo 'btn-primary'; break;
              case 'edit': echo 'btn-success'; break;
              case 'del': echo 'btn-danger'; break;
            } ?>" name="categoryModifier" value="<?=$cat_type?>"><?php switch ($cat_type) {
              case 'add': echo 'Hozzáadás <i class="fa fa-plus"></i>'; break;
              case 'edit': echo 'Változások mentése <i class="fa fa-save"></i>'; break;
              case 'del': echo 'Végleges törlés <i class="fa fa-trash"></i>'; break;
            } ?></button>
          </div>
        </div>
      </form>
    </div>
    <?php endif; ?>
    <div class="con">
      <div class="pull-right"><a href="/tudastar/?add=category"><i class="fa fa-plus"></i> új hozzáadása</a></div>
      <h2>Témakörök (<?=count($this->cats[data])?>)</h2>
      <br>
      <div class="row np row-head">
				<div class="col-md-9"><em>Témakör</em></div>
				<div class="col-md-2 center"><em>Sorrend</em></div>
				<div class="col-md-1"></div>
			</div>
      <div class="categories">
        <?php if (count($this->cats[data]) == 0): ?>
          Nincsenek témakörök létrehozva.
        <?php else: ?>
        <?php foreach ( $this->cats['data'] as $c ): ?>
          <div class="row np<?=($_GET['edit'] == 'category' && $_GET['id'] == $c['ID'])?' on-edit':''?>">
            <div class="col-md-9">
              <a href="/tudastar/?edit=category&id=<?=$c['ID']?>"><?php echo $c['cim']; ?></a>
            </div>
            <div class="col-md-2 center">
              <?php echo $c['sorrend']; ?>
            </div>
            <div class="col-md-1 actions" align="right">
              <a href="/tudastar/?del=category&id=<?=$c['ID']?>" title="Törlés"><i class="fa fa-times"></i></a>
            </div>
          </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <?php
      $art_type = 'add';
      if ($_GET['edit'] == 'article') {
        $art_type = 'edit';
      }
      if ($_GET['del'] == 'article') {
        $art_type = 'del';
      }
    ?>
    <?php if ($_GET['add'] == 'article' || $_GET['edit'] == 'article' || $_GET['del'] == 'article'): ?>
    <div class="con <?=($art_type=='edit')?'edit':(($art_type=='del')?'con-del':'')?>">
      <h2><?php switch ($art_type) {
        case 'add': echo 'Új cikk hozzáadása'; break;
        case 'edit': echo 'Cikk szerkesztése'; break;
        case 'del': echo 'Cikk törlése'; break;
      } ?></h2>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?=$this->c['ID']?>">
        <?php if ($_GET['del'] == 'article'): ?>
        <div class="row">
          <div class="col-md-12">
            Biztos, hogy véglegesen törli a(z) <strong><?=$this->c['cim']?></strong> cikket? A művelet nem visszavonható.
          </div>
        </div>
        <br>
        <?php else: ?>
        <div class="row">
          <div class="col-md-8">
            <label for="art_cim">Cikk címe *</label>
            <input type="text" class="form-control" name="cim" value="<?=($this->err)?$_POST['cim']:$this->c[cim]?>" id="art_cim">
          </div>
          <div class="col-md-2">
            <label for="art_sorrend">Sorrend</label>
            <input type="text" class="form-control" name="sorrend" value="<?=($this->err)?$_POST['sorrend']:(($this->c)?$this->c[sorrend]:100)?>" id="art_sorrend">
          </div>
          <div class="col-md-2">
            <label for="art_kiemelt">Kiemelt <?=\PortalManager\Formater::tooltip('A kiemeltnek jelölt cikkek megjelennek a láblécben.')?></label>
            <input type="checkbox" class="form-control" <?=($this->err && isset($_POST['kiemelt']))?'checked="checked"':( ($this->c && $this->c['kiemelt'] == '1') ? 'checked="checked"':'' )?> name="kiemelt" id="art_kiemelt">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <label for="art_temakor">Témakör *</label>
            <select class="form-control" name="katID" id="art_temakor">
              <option value="">-- válasszon --</option>
              <option value="" disabled="disabled"></option>
              <?php foreach ($this->catgroup as $cg): ?>
              <option value="<?=$cg['ID']?>" <?=($this->err && $_POST['katID'] == $cg['ID'])?'selected="selected"':( ($this->c && $this->c['katID'] == $cg['ID']) ? 'selected="selected"':'' )?>><?=$cg['cim']?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <label for="art_kulcsszavak">Kulcsszavak, vesszővel elválasztva</label>
            <input type="text" name="kulcsszavak" class="form-control" value="<?=($this->err)?$_POST['kulcsszavak']:$this->c[kulcsszavak]?>" id="art_kulcsszavak">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <label for="art_kulcsszavak">Tartalom</label>
            <textarea name="szoveg"><?=($this->err)?$_POST['szoveg']:$this->c[szoveg]?></textarea>
          </div>
        </div>
        <br>
        <?php endif; ?>
        <div class="row">
          <div class="col-md-12 right">
            <a href="/tudastar" class="pull-left btn btn-default"> <i class="fa fa-angle-left"></i> mégse</a>
            <button type="submit" class="btn <?php switch ($art_type) {
              case 'add': echo 'btn-primary'; break;
              case 'edit': echo 'btn-success'; break;
              case 'del': echo 'btn-danger'; break;
            } ?>" name="articleModifier" value="<?=$art_type?>"><?php switch ($art_type) {
              case 'add': echo 'Hozzáadás <i class="fa fa-plus"></i>'; break;
              case 'edit': echo 'Változások mentése <i class="fa fa-save"></i>'; break;
              case 'del': echo 'Végleges törlés <i class="fa fa-trash"></i>'; break;
            } ?></button>
          </div>
        </div>
      </form>
    </div>
    <?php endif; ?>
    <div class="con">
      <div class="pull-right"><a href="/tudastar/?add=article"><i class="fa fa-plus"></i> új cikk</a></div>
      <h2>Tudástár cikkek (<?=count($this->articles)?>) <? if($_COOKIE['filtered'] == '1'): ?><span class="filteralert"> &mdash; szűrt lista</span><? endif;?></h2>
      <form class="" action="" method="post">
        <div class="filter-box <? if($_COOKIE['filtered'] == '1'): ?>filtered<? endif;?>">
          <div class="row">
            <div class="col-md-5">
              <input type="text" name="filter_search" class="form-control" placeholder="Keresés..." value="<?=$_COOKIE['filter_search']?>">
            </div>
            <div class="col-md-5">
              <select class="form-control" name="filter_temakor">
                <option value="">-- témakör --</option>
                <option value="" disabled="disabled"></option>
                <?php foreach ($this->catgroup as $cg): ?>
                <option value="<?=$cg['ID']?>" <?=($_COOKIE['filter_temakor'] == $cg['ID'])?'selected="selected"':''?>><?=$cg['cim']?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2 right">
              <? if($_COOKIE[filtered] == '1'): ?><a class="btn btn-danger" href="/tudastar/clearfilters/" title="szűrés eltávolítása" class="actions"><i class="fa fa-times-circle"></i></a><? endif; ?>
              <button name="filterList" class="btn btn-default">szűrés <i class="fa fa-filter"></i></button>
            </div>
          </div>
        </div>
      </form>
      <br>
      <div class="row np row-head">
				<div class="col-md-9"><em>Cikk címe</em></div>
				<div class="col-md-1 center"><em>Kiemelt</em></div>
				<div class="col-md-1 center"><em>Sorrend</em></div>
				<div class="col-md-1"></div>
			</div>
      <div class="categories tudastar-list">
        <?php if (count($this->articles) == 0): ?>
          Nincsenek cikkek létrehozva.
        <?php else: ?>
        <?php foreach ( $this->articles as $c ): ?>
          <div class="row np<?=($_GET['edit'] == 'article' && $_GET['id'] == $c['ID'])?' on-edit':''?>">
            <div class="col-md-9">
              <a class="title" href="/tudastar/?edit=article&id=<?=$c['ID']?>"><?php echo $c['cim']; ?></a>
              <div class="cat">
                <i class="fa fa-cube"></i> <?=$this->catgroup[$c['katID']]['cim']?>
              </div>
              <div class="keywords">
                <i class="fa fa-tags"></i> <?php echo implode(', ',$c['kulcsszavak']); ?>
              </div>
            </div>
            <div class="col-md-1 center">
              <?=($c['kiemelt']=='1')?'<i style="color: #67c225;" class="fa fa-check-circle"></i>':'<i style="color: #bababa;" class="fa fa-circle-o"></i>'?>
            </div>
            <div class="col-md-1 center">
              <?php echo $c['sorrend']; ?>
            </div>
            <div class="col-md-1 actions" align="right">
              <a href="/tudastar/?del=article&id=<?=$c['ID']?>" title="Törlés"><i class="fa fa-times"></i></a>
            </div>
          </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
