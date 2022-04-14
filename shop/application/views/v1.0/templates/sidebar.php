<div class="sidebar-holder">
    <?php if ( $this->product_listing ): ?>
    <form class="" action="" method="get">
      <div class="filters side-group">
        <div class="head">
          <?=__('Keresés tulajdonságok szerint')?>
        </div>
        <?php if ( !empty($this->productFilters) ): ?>
          <?php foreach ( $this->productFilters as $pf ):

            if(count($pf['hints']) == 0): continue; endif;
            if( ($pf['type'] != 'tartomany' && $pf['type'] != 'szam') &&  count($pf['hints']) <= 1) continue;
            if( ($pf['type'] == 'tartomany' || $pf['type'] == 'szam') &&  count($pf['hints']) <= 1) continue;
          ?>
          <div class="section-group filter-row">
            <strong><?php echo $pf['parameter']; ?></strong> <?=($pf['me'] != '')?'('.$pf['me'].')':''?>
          </div>
          <div class="section-wrapper type-<?=$pf['type']?>">
              <input type="hidden" name="fil_p_<?=$pf['ID']?>" id="p_<?=$pf['ID']?>_v" />
              <div id="pmf_<?=$pf['ID']?>">
                 <? if($pf['type'] == 'tartomany'): ?>
                 <div class="pos_rel">
                    <input mode="minmax" id="r<?=$pf['ID']?>_range_min" type="hidden" name="fil_p_<?=$pf['ID']?>_min" value="<?=$_GET['fil_p_'.$pf['ID'].'_min']?>" class="form-control <?=($_GET['fil_p_'.$pf['ID'].'_min'])?'filtered':''?>" />
                    <input mode="minmax" id="r<?=$pf['ID']?>_range_max" type="hidden" name="fil_p_<?=$pf['ID']?>_max" value="<?=$_GET['fil_p_'.$pf['ID'].'_max']?>" class="form-control <?=($_GET['fil_p_'.$pf['ID'].'_max'])?'filtered':''?>" />
                    <div class="range" key="r<?=$pf['ID']?>" smin="<?=$_GET['fil_p_'.$pf['ID'].'_min']?>" smax="<?=$_GET['fil_p_'.$pf['ID'].'_max']?>" amin="<?=$pf['minmax']['min']?>" amax="<?=$pf['minmax']['max']?>"></div>
                    <div class="rangeInfo">
                       <div class="col-md-6 def"><em>(<?=$pf['minmax']['min']?> - <?=$pf['minmax']['max']?>)</em></div>
                       <div class="col-md-6 sel" align="right"><span id="r<?=$pf['ID']?>_range_info_min"><?=$_GET['fil_p_'.$pf['ID'].'_min']?></span> - <span id="r<?=$pf['ID']?>_range_info_max"><?=$_GET['fil_p_'.$pf['ID'].'_max']?></span></div>
                    </div>
                 </div>
                 <? elseif($pf['type'] == 'szam'): ?>
                 <div class="pos_rel">
                    <input mode="minmax" id="r<?=$pf['ID']?>_range_min" type="hidden" name="fil_p_<?=$pf['ID']?>_min" value="<?=$_GET['fil_p_'.$pf['ID'].'_min']?>" class="form-control <?=($_GET['fil_p_'.$pf['ID'].'_min'])?'filtered':''?>" />
                    <input mode="minmax" id="r<?=$pf['ID']?>_range_max" type="hidden" name="fil_p_<?=$pf['ID']?>_max" value="<?=$_GET['fil_p_'.$pf['ID'].'_max']?>" class="form-control <?=($_GET['fil_p_'.$pf['ID'].'_max'])?'filtered':''?>" />
                    <div class="range" key="r<?=$pf['ID']?>" smin="<?=$_GET['fil_p_'.$pf['ID'].'_min']?>" smax="<?=$_GET['fil_p_'.$pf['ID'].'_max']?>" amin="<?=$pf['minmax']['min']?>" amax="<?=$pf['minmax']['max']?>"></div>
                    <div class="rangeInfo">
                       <div class="col-md-6 def"><em>(<?=$pf['minmax']['min']?> - <?=$pf['minmax']['max']?>)</em></div>
                       <div class="col-md-6 sel" align="right"><span id="r<?=$pf['ID']?>_range_info_min"><?=$_GET['fil_p_'.$pf['ID'].'_min']?></span> - <span id="r<?=$pf['ID']?>_range_info_max"><?=$_GET['fil_p_'.$pf['ID'].'_max']?></span></div>
                    </div>
                 </div>
                 <? else: ?>
                 <div class="selectors">
                    <?php if (count($pf['hints']) > 0): ?>
                    <div class="sel-item-n">
                      <?=count($pf['hints'])?>
                    </div>
                    <?php endif; ?>
                    <div class="selector" key="p_<?=$pf['ID']?>" id="p_<?=$pf['ID']?>"><?=__('összes')?></div>
                    <div class="selectorHint p_<?=$pf['ID']?>" style="display:none;">
                       <ul>
                          <? foreach($pf['hints'] as $h): ?>
                          <li><label><input type="checkbox" <?=(in_array($h,$this->filters['fil_p_'.$pf['ID']]))?'checked':''?> for="p_<?=$pf['ID']?>" text="<?=$h?>" value="<?=$h?>" /> <?=$h?> <?=$pf['mertekegyseg']?></label></li>
                          <? endforeach;?>
                       </ul>
                    </div>
                 </div>
                 <? endif; ?>
              </div>
           </div>
          <?php endforeach; ?>
        <?php endif; ?>
        <div class="section-group">
          <?=__('Rendezés')?>
        </div>
        <div class="section-wrapper">
          <select name="order" class="form-control">
            <option value="ar_asc" selected="selected"><?=__('Ár: növekvő')?></option>
            <option value="ar_desc"><?=__('Ár: csökkenő')?></option>
            <option value="nev_asc"><?=__('Név: A-Z')?></option>
            <option value="nev_desc"><?=__('Név: Z-A')?></option>
          </select>
        </div>
        <div class="action-group">
          <button type="submit"><?=__('Szűrés')?> <i class="fa fa-refresh"></i></button>
        </div>
      </div>
    </form>
  <?php endif; // End of product_listing ?>

  <?php if ($this->top_documents): ?>
  <div class="documents side-group">
    <div class="head">
      <?=__('Dokumentumok')?>
    </div>
    <div class="wrapper">
      <div class="document-top-list">
        <div class="wrapper">
          <ul>
            <?php foreach ($this->top_documents as $docs ): if(empty($docs['cim'])) continue; ?>
            <li><a title="<?=strtoupper($docs['extension'])?><?=($docs['size']) ? ' - '.round($docs['sizes']['kb']).' KB':''?>" href="/app/dcl/<?=$docs['hashname']?>" target="_blank"><img src="<?=IMG?>icons/docst-<?=($docs['extension'] == '' || $docs['extension'] == 'link')?'url':$docs['extension']?>.svg" alt="<?=$docs['extension']?>"> <?=$docs['cim']?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <? if( $this->live_products_list && false ): ?>
  <div class="liveproducts side-group">
    <div class="head">
      Mások most ezt nézik
    </div>
    <div class="wrapper">
      <div class="product-side-items imaged-style">
        <? foreach ( $this->live_products_list as $livep ) { ?>
        <div class="item">
          <div class="img">
            <a href="<?php echo $livep['link']; ?>"><img src="<?php echo $livep['profil_kep_small']; ?>" alt="<?php echo $livep['product_nev']; ?>"></a>
          </div>
          <div class="data">
            <a href="<?php echo $livep['link']; ?>">
              <div class="name">
                <?php echo $livep['product_nev']; ?>
              </div>
            </a>
            <div class="price">
              <strong><?php echo Helper::cashFormat($livep['ar']); ?> Ft</strong> <?php if ($livep['akcios'] == 1): ?>
                <span class="old"><?php echo Helper::cashFormat($livep['brutto_ar']); ?> Ft</span>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <? } ?>
      </div>
    </div>
  </div>
  <? endif; ?>

  <? if( $this->top_products && $this->top_products->hasItems()  && false ): ?>
  <div class="topproducts side-group">
    <div class="head">
      A legtöbbet vásárolt
    </div>
    <div class="wrapper">
      <div class="product-side-items imaged-style">
        <? foreach ( $this->top_products_list as $topp ) { ?>
          <div class="item">
            <div class="img">
              <a href="<?php echo $topp['link']; ?>"><img src="<?php echo $topp['profil_kep_small']; ?>" alt="<?php echo $topp['product_nev']; ?>"></a>
            </div>
            <div class="data">
              <a href="<?php echo $topp['link']; ?>">
                <div class="name">
                  <?php echo $topp['product_nev']; ?>
                </div>
              </a>
              <div class="price">
                <strong><?php echo Helper::cashFormat($topp['ar']); ?> Ft</strong> <?php if ($topp['akcios'] == 1): ?>
                  <span class="old"><?php echo Helper::cashFormat($topp['brutto_ar']); ?> Ft</span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <? } ?>
      </div>
      <div class="stock-info">
        <?php if ($this->top_products_list['0']['raktar_keszlet'] > 0): ?>
          Ebből a termékünkből már csak <?=$this->top_products_list['0']['raktar_keszlet']?> db van!
        <?php else: ?>
          Ez a termékünk elfogyott!
        <?php endif; ?>
      </div>
    </div>
  </div>
  <? endif; ?>

  <? if( $this->viewed_products_list ): ?>
  <div class="lastviewed side-group">
    <div class="head"><?=__('Utoljára megtekintettek')?></div>
    <div class="wrapper">
      <div class="product-side-items imaged-style">
        <? foreach ( $this->viewed_products_list as $viewed ) { ?>
          <div class="item">
            <div class="img">
              <a href="<?php echo $viewed['link']; ?>"><img src="<?php echo $viewed['profil_kep']; ?>" alt="<?php echo $viewed['product_nev']; ?>"></a>
            </div>
            <div class="data">
              <a href="<?php echo $viewed['link']; ?>">
                <div class="name">
                  <?php echo $viewed['product_nev']; ?>
                </div>
              </a>
              <div class="price">
                <?php if($this->user): ?>
                <strong><?php echo Helper::cashFormat($viewed['ar']); ?> Ft</strong> <?php if ($viewed['akcios'] == 1): ?>
                  <span class="old"><?php echo Helper::cashFormat($viewed['brutto_ar']); ?> Ft</span>
                <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <? } ?>
      </div>
    </div>
  </div>
  <? endif; ?>
	<?php
		$top_tudastar = $this->top_helpdesk_articles;
    if( $top_tudastar ):
	?>
  <div class="helpdesk side-group">
    <div class="head"><?=__('Tudástár')?></div>
    <div class="wrapper">
      <div class="helpdesk-top-searcher">
        <div class="helpdesk-search">
          <form class="" action="/tudastar" method="get" onsubmit="prepareHelpdeskHeaderSearch(this); return false;">
            <input type="text" name="tags" value="" placeholder="<?=__('Keresőszó megadása')?>" autocomplete="off">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>
        <div class="picked-articles">
          <div class="wrapper">
            <ul>
              <?php foreach ($top_tudastar as $tud): ?>
  						<li><a href="/tudastar/#?pick=<?=$tud['ID']?>"><?php echo __(trim($tud['cim'])); ?></a></li>
  						<?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  endif; // $top_tudastar ?>

</div>
