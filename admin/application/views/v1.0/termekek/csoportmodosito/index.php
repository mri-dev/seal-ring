<h1>Termék csoportok tömeges módosítása</h1>
<?php echo $this->bmsg; ?>
<form class="" action="" method="get">
<fieldset>
  <legend>Keresés</legend>
  <div class="">
    <div class="row">
      <div class="col-md-1">
        Keresés mint:
      </div>
      <div class="col-md-11">
        <input type="radio" name="by" <?=(isset($_GET['by']) && $_GET['by'] == 'search')?'checked="checked"':''?> value="search" id="by_search"> <label for="by_search">keresési kifejezés</label> <br>
        <input type="radio" name="by" <?=(isset($_GET['by']) && $_GET['by'] == 'shopgroup')?'checked="checked"':''?>  value="shopgroup" id="by_shopgroup"> <label for="by_shopgroup">termék csoport azonosító</label><br>
        <input type="radio" name="by" <?=(isset($_GET['by']) && $_GET['by'] == 'ids')?'checked="checked"':''?>  value="ids" id="by_ids"> <label for="by_ids">termék id-k (vesszővel elválasztva)</label>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-1" style="line-height: 35px;">
        Kulcsszó:
      </div>
      <div class="col-md-4">
        <input type="text" class="form-control" name="src" value="<?=$_GET['src']?>" id="src">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Elemek keresése</button>
      </div>
    </div>
  </div>
</fieldset>
</form>
<br>
<div class="divider"></div>
<div class="result-list">
  <div class="header">
    <h3><strong><?php echo $this->terms->getItemNumbers(); ?> db eredmény</strong> / Tömeges módosítása</h3>
  </div>

  <?php if ($this->terms->getItemNumbers() > 0): ?>
    <div class="modifier-block">
      <form class="" action="" method="post">
      <input type="hidden" name="by" value="<?=$_GET['by']?>">
      <input type="hidden" name="src" value="<?=$_GET['src']?>">
      <div class="con con-edit">
        <div class="row">
          <div class="col-md-2">
            <label for="shopgroup" style="line-height: 35px;">Termél csoport azonosító</label>
          </div>
          <div class="col-md-4">
            <input type="text" id="shopgroup" class="form-control" name="shopgroup" value="">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-2">
            <label for="kulcsszavak" style="line-height: 35px;">Kulcsszavak</label>
          </div>
          <div class="col-md-10">
            <input type="text" id="kulcsszavak" class="form-control" name="kulcsszavak" value="">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-2">
            <label for="leiras" style="line-height: 35px;">Leírás</label>
          </div>
          <div class="col-md-10">
            <textarea name="leiras" class="form-control"></textarea>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-2">
            <label for="kepek" style="line-height: 35px;">Képek</label>
          </div>
          <div class="col-md-10">
            <input class="form-control" type="file" name="img[]" id="kepek" multiple>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-2">
            <label for="">Következő értékek törlése</label>
          </div>
          <div class="col-md-10">
            <div class=""><input type="checkbox" name="deleting[]" value="shopgroup" id="del_shopgroup"> <label for="del_shopgroup">termék csoport azonosítók</label></div>
            <div class=""><input type="checkbox" name="deleting[]" value="kulcsszavak" id="del_kulcsszavak"> <label for="del_kulcsszavak">termék kulcsszavak</label></div>
            <div class=""><input type="checkbox" name="deleting[]" value="leiras" id="del_leiras"> <label for="del_leiras">termék leírás</label></div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12 right">
            <button type="submit" class="btn btn-md btn-success" name="modifyAllTerm" value="1">Mind a(z) <?php echo $this->terms->getItemNumbers(); ?> db tétel frissítése</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <div class="result-list">
      <h4><strong>Eredmény lista</strong></h4>
      <?php if ($this->terms->getItemNumbers()): ?>
        <table class="table table-striped">
          <thead>
            <tr>
              <th width="10">#</th>
              <th width="30">ID</th>
              <th width="">Termék név</th>
              <th width="100" title="Termék csoport azonosító">Csop. az.</th>
              <th width="">Kulcsszavak</th>
              <th width="100">Nettó besz. ár</th>
              <th width="30">Aktív</th>
            </tr>
          </thead>
          <tbody>
            <?php $ii =0; foreach ( (array)$this->term_list as $term ): $ii++; ?>
            <tr>
              <td class="center"><?=$ii?></td>
              <td class="center"><?=$term['product_id']?></td>
              <td><strong><a href="<?=$this->settings['page_url']?>/termek/<?=Helper::makeSafeUrl($term['product_nev'],'_-'.$term['product_id'])?>" target="_blank"><?=$term['product_nev']?></a></strong></td>
              <td class="center"><?=($term['shopgroup'])?$term['shopgroup']:'&mdash;'?></td>
              <td><?=$term['kulcsszavak']?></td>
              <td class="center"><?=$term['beszerzes_netto']?></td>
              <td style="color:white;background: <?=($term['lathato'] == 1)?'green':'red'?>;"><?=($term['lathato'] == 1)?'IGEN':'NEM'?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
