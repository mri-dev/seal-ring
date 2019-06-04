<h1>Termék csoportok tömeges módosítása</h1>

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
        <input type="radio" name="by" <?=(isset($_GET['by']) && $_GET['by'] == 'shopgroup')?'checked="checked"':''?>  value="shopgroup" id="by_shopgroup"> <label for="by_shopgroup">termék csoport azonosító</label>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-1">
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
<br>
<div class="divider"></div>
<div class="result-list">
  <div class="header">
    <h3><strong><?php echo $this->terms->getItemNumbers(); ?> db eredmény</strong> / Tömeges módosítása</h3>
  </div>

  <div class="modifier-block">
    <div class="con">
asd
    </div>
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
</div>
</form>
