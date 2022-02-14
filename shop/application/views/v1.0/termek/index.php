<?php
  $ar = $this->product['ar'];
?>
<div class="product-view">
  <div class="sidebar">
    <? $this->render('templates/sidebar_menu'); ?>
  </div>
  <div class="product-data">
    <div class="">
      <div class="top-datas"> 
        <div class="images">
          <?php if (true): ?>
          <div class="main-img img-auto-cuberatio">
            <?php if (false): ?>
              <? if( $ar >= $this->settings['cetelem_min_product_price'] && $ar <= $this->settings['cetelem_max_product_price'] && $this->product['no_cetelem'] != 1 ): ?>
                  <img class="cetelem" src="<?=IMG?>cetelem_badge.png" alt="Cetelem Online Hitel">
              <? endif; ?>
            <?php endif; ?>
            <div class="img-thb">
                <a href="<?=$this->product['profil_kep']?>" class="zoom"><img di="<?=$this->product['profil_kep']?>" src="<?=$this->product['profil_kep']?>" alt="<?=$this->product['nev']?>"></a>
            </div>
          </div>
          <div class="all">
            <?  foreach ( $this->product['images'] as $img ) { ?>
            <div class="imgslide img-auto-cuberatio__">
              <div class="wrp">
                <img class="aw" i="<?=\PortalManager\Formater::productImage($img)?>" src="<?=\PortalManager\Formater::productImage($img)?>" alt="<?=$this->product['nev']?>">
              </div>
            </div>
            <? } ?>
          </div>
          <?php endif; ?>
        </div>
        <div class="main-data">
        <h1><?=$this->product['nev']?></h1>
        <div class="csoport">
          <?=$this->product['csoport_kategoria']?>
        </div>
        <div class="cimkek">
        <? if($this->product['akcios'] == '1'): ?>
            <img src="<?=IMG?>discount_small_icon.png" title="Akciós!" alt="Akciós">
        <? endif; ?>
        <? if($this->product['ujdonsag'] == '1'): ?>
            <img src="<?=IMG?>new_icon_sq.svg" title="Újdonság!" alt="Újdonság">
        <? endif; ?>
        </div>
        <div class="prices">
          <?php if( $this->user ): ?>
          <div class="lab">
            <?php if (!$this->user || $this->user['data']['price_group_data']['groupkey'] == 'ar1'): ?>
             <? if(false): ?><strong><?=($this->user['data']['price_group_data']['title'] != '')?$this->user['data']['price_group_data']['title']:'Kiskereskedelmi'?></strong><? endif; ?><?=($this->settings['price_show_brutto'] == 0)?'Nettó':'Bruttó'?> ár:
            <?php elseif($this->user['data']['price_group_data']['groupkey'] == 'beszerzes_netto'): ?>
              Nettó <strong>beszerzési</strong> ár:
            <?php else: ?>
              <? if(false): ?><strong><?=($this->user['data']['price_group_data']['title'] != '')?$this->user['data']['price_group_data']['title']:'Kiskereskedelmi'?></strong><? endif; ?><?=($this->settings['price_show_brutto'] == 0)?'Nettó':'Bruttó'?> ár:
            <?php endif; ?>
          </div>
          <?php $kisker_brutto = (int)$this->product['price_default_kisker_brutto']; ?>
          <div class="base">
            <?php if ($kisker_brutto == 0): ?>
              <div class="current">
                ÉRDEKLŐDJÖN!
              </div>
            <?php else: ?>
              <?  if( $this->product['akcios'] == '1' && $this->product['akcio']['mertek'] > 0):
                  $ar = $this->product['eredeti_ar'];
              ?>
              <div class="old">
                  <div class="price"><strike><?=\PortalManager\Formater::cashFormat($ar)?> <?=$this->valuta?></strike> <span class="disc-percent">-<?=$this->product['akcio']['szazalek']?>%</span> </div>
              </div>
              <? endif; ?>
              <div class="current">
                  <?=\PortalManager\Formater::cashFormat($this->product['ar'])?> <?=$this->valuta?> <?=($this->settings['price_show_brutto'] == 0)?'<span class="text">+ ÁFA</span>':''?>
                  <?php if ($this->user['data']['price_group_data']['groupkey'] == 'beszerzes_netto' && $this->settings['price_show_brutto'] == 1): ?>
                    <span class="text">+ ÁFA</span>
                  <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
          <?php else: ?>
            <div class="login-for-price">Az Ár bejelentkezés után látható!</div><br>
          <?php endif; ?>
        </div>
        <div class="divider"></div>
        <div class="status-params">
          <div class="avaibility">
            <div class="v"><?=$this->product['keszlet_info']?></div>
          </div>
          <div class="transport">
            <div class="h">Várható szállítás:</div>
            <div class="v"><span><?=$this->product['szallitas_info']?></span></div>
          </div>
          <?php if ( $ar > $this->settings['FREE_TRANSPORT_ABOVEPRICE']): ?>
          <div class="free-transport">
            <div class="free-transport-ele">
              <i class="fa fa-car"></i> Ingyen szállítjuk
            </div>
          </div>
          <?php endif; ?>
        </div>
        <?php if ($this->product['rovid_leiras'] != ''): ?>
        <div class="divider"></div>
        <div class="short-desc">
          <?=$this->product['rovid_leiras']?>
        </div>
        <?php endif; ?>
        <?php
        if( count($this->product['hasonlo_termek_ids']['colors']) > 1 ):
            $colorset = $this->product['hasonlo_termek_ids']['colors'];
        ?>
        <div class="divider"></div>
        <div class="variation-header">
          Elérhető variációk:
        </div>
        <div class="variation-list">
        <? foreach ($colorset as $szin => $adat ) : ?>
          <div class="variation<?=($szin == $this->product['szin'] )?' actual':''?>"><a href="<?=$adat['link']?>"><?=$szin?></a></div>
        <? endforeach; ?>
        </div>
        <? endif; ?>
        <div class="divider"></div>
        <div class="cart-info">
          <div id="cart-msg"></div>
          <?php if ($this->product['show_stock'] == 1): ?>
            <div class="stock-info <?=($this->product['raktar_keszlet'] <=0)?'no-stock':''?>">
              <?php if ($this->product['raktar_keszlet'] > 0): ?>
                Készleten: <strong><?php echo $this->product['raktar_keszlet']; ?> db</strong>
              <?php else: ?>
                Készleten: <strong>Nincs készleten jelenleg.</strong>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          <?php if (true): ?>
          <div class="group" >
            <?
            if( count($this->product['hasonlo_termek_ids']['colors'][$this->product['szin']]['size_set']) > 1 ):
                $colorset = $this->product['hasonlo_termek_ids']['colors'][$this->product['szin']]['size_set'];
                //unset($colorset[$this->product['szin']]);
            ?>
            <div class="size-selector cart-btn dropdown-list-container">
                <div class="dropdown-list-title"><span id=""><?=__('Kiszerelés')?>: <strong><?=$this->product['meret']?></strong></span> <? if( count( $this->product['hasonlo_termek_ids']['colors'][$this->product['szin']]['size_set'] ) > 0): ?> <i class="fa fa-angle-down"></i><? endif; ?></div>

                <div class="number-select dropdown-list-selecting overflowed">
                <? foreach ($colorset as $szin => $adat ) : ?>
                    <div link="<?=$adat['link']?>"><?=$adat['size']?></div>
                <? endforeach; ?>
                </div>
            </div>
            <? endif; ?>
            <div class="order <?=($this->product['without_price'])?'requestprice':''?>">
              <?php if ( !$this->product['without_price'] && $kisker_brutto != 0  ): ?>
              <div class="men">
                <div class="wrapper">
                  <label for="add_cart_num">Darab:</label>
                  <input type="number" name="" id="add_cart_num" cart-count="<?=$this->product['ID']?>" value="1" min="1">
                </div>
              </div>
              <?php endif; ?>
              <?php if ( !$this->product['without_price'] && $kisker_brutto != 0 ): ?>
                <div class="buttonorder">
                  <button id="addtocart" cart-data="<?=$this->product['ID']?>" cart-remsg="cart-msg" title="Kosárba rakom" class="tocart cart-btn"> <img src="<?=IMG?>icons/cart-button.svg" alt="kosárba rakom"> <?=__('kosárba rakom')?></i></button>
                </div>
              <?php else: ?>
                <div class="requestbutton">
                  <md-tooltip md-direction="top">
                    Erre a gombra kattintva árajánlatot kérhet erre a termékre.
                  </md-tooltip>
                  <button aria-label="Erre a gombra kattintva árajánlatot kérhet erre a termékre." class="tocart cart-btn" ng-click="requestPrice(<?=$this->product['ID']?>)"><?=__('Ajánlatot kérek')?></i></button>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="divider"></div>
          <?php endif; ?>
          <div class="group-infos">
            <?php if (!empty($this->product['in_cats']['name'])): ?>
            <div class="cats">
              <div class="flex">
                <div class="title">
                  Kategóriák:
                </div>
                <div class="val">
                  <div class="wrapper">
                    <div class="labels">
                      <?php
                      $ci = -1;
                      foreach ((array)$this->product['in_cats']['name'] as $cat ): $ci++; ?>
                      <div class="">
                        <a href="<?=$this->product['in_cats']['url'][$ci]?>"><?=$cat?></a>
                      </div>
                      <?php endforeach; unset($ci); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($this->product['kulcsszavak'])): ?>
            <div class="keywords">
              <div class="flex">
                <div class="title">
                  Címkék:
                </div>
                <div class="val">
                  <div class="wrapper">
                    <div class="labels">
                      <?php foreach ( (array)$this->product['kulcsszavak'] as $kulcsszavak ): ?>
                      <div>
                        <a href="/tag/<?=$kulcsszavak?>"><?=$kulcsszavak?></a>
                      </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
            <div class="shares">
              <div class="flex">
                <div class="title">
                  Megosztás:
                </div>
                <div class="val">
                  <div class="wrapper">
                    <div class="social">
                      <div class="flex flexmob-exc-resp">
                        <div class="facebook">
                          <a  href="#"><i class="fa fa-facebook"></i></a>
                        </div>
                        <div class="googleplus">
                          <a href="#"><i class="fa fa-google-plus"></i></a>
                        </div>
                        <div class="email">
                          <a href="#"><i class="fa fa-envelope"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="more-datas">
      <div class="">
        <nav class="tab-header">
          <ul>
            <li class="description active"><a href="#description" onclick="switchTab('description')">Leírás</a></li>
            <?php if ($this->product['parameters'] && !empty($this->product['parameters'])): ?>
            <li class="parameters"><a href="#parameters" onclick="switchTab('parameters')">Műszaki adatok</a></li>
            <?php endif; ?>
            <?php if ($this->product['documents']): ?>
            <li class="documents"><a href="#documents" onclick="switchTab('documents')">Dokumentumok</a></li>
            <?php endif; ?>
          </ul>
        </nav>
        <div class="holder">
          <div class="info-texts">
            <?php if ($this->product['parameters'] && !empty($this->product['parameters'])): ?>
              <a name="parameters"></a>
              <div class="parameters tab-holder" id="tab-content-parameters">
                <div class="c">
                  <div class="params">
                    <?php foreach ( $this->product['parameters'] as $p ): ?>
                    <div class="param">
                      <div class="key">
                        <?php echo $p['neve']; ?>
                      </div>
                      <div class="val">
                        <strong><?php echo $p['ertek']; ?></strong> <span class="me"><?php echo $p['me']; ?></span>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <?php 
              if($this->product['static']['desc']){
                $this->product['leiras'] = $this->product['static']['desc'];
              }
            ?>

            <a name="description"></a>
            <div class="description tab-holder showed" id="tab-content-description">
              <div class="c">
                <?php if ( !empty($this->product['leiras']) ): ?>
                <?=$this->product['leiras']?>
                <?php else: ?>
                  <div class="no-data">
                    <i class="fa fa-info-circle"></i> A terméknek nincs leírása.
                  </div>
                <?php endif; ?>
              </div>
            </div>


            <?php if ($this->product['documents']): ?>
            <a name="documents"></a>
            <div class="documents tab-holder" id="tab-content-documents">
              <div class="c">
                <div class="docs">
                  <?php foreach ( (array)$this->product['documents'] as $doc ): ?>
                  <div class="doc">
                    <a target="_blank" title="Kiterjesztés: <?=strtoupper($doc['ext'])?>" href="/app/dcl/<?=$doc['hashname']?>"><img src="<?=IMG?>icons/<?=$doc['icon']?>.svg" alt=""><?=$doc['cim']?><?=($doc[filesize])?' <span class="size">&bull; '.strtoupper($doc['ext']).' &bull; '.$doc[filesize].'</span>':''?></a>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>
          <?php if ( $this->related_list ): ?>
          <div class="related-products">
            <div class="c">
              <div class="items">
              <?php if ( $this->related_list ): ?>
                <? foreach ( $this->related_list as $p ) {
                    $p['itemhash'] = hash( 'crc32', microtime() );
                    $p = array_merge( $p, (array)$this );
                    echo $this->template->get( 'product_item', $p );
                } ?>
              <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(function() {
        fixCatHeight();
        fixCatPosition();

        $(window).scroll(function(){
          fixCatHeight();
          fixCatPosition();
        });

        <? if( $_GET['buy'] == 'now'): ?>
        $('#add_cart_num').val(1);
        $('#addtocart').trigger('click');
        setTimeout( function(){ document.location.href='/kosar' }, 1000);
        <? endif; ?>
        $('.number-select > div[num]').click( function (){
            $('#add_cart_num').val($(this).attr('num'));
            $('#item-count-num').text($(this).attr('num')+' db');
        });
        $('.size-selector > .number-select > div[link]').click( function (){
            document.location.href = $(this).attr('link');
        });

        $('.product-view .images .all img').hover(function(){
            changeProfilImg( $(this).attr('i') );
        });

        $('.product-view .images .all img').bind("mouseleave",function(){
            //changeProfilImg($('.product-view .main-view a.zoom img').attr('di'));
        });

        $('.products > .grid-container > .item .colors-va li')
        .bind( 'mouseover', function(){
            var hash    = $(this).attr('hashkey');
            var mlink   = $('.products > .grid-container > .item').find('.item_'+hash+'_link');
            var mimg    = $('.products > .grid-container > .item').find('.item_'+hash+'_img');

            var url = $(this).find('a').attr('href');
            var img = $(this).find('img').attr('data-img');

            mimg.attr( 'src', img );
            mlink.attr( 'href', url );
        });

        $('.viewSwitcher > div').click(function(){
            var view = $(this).attr('view');

            $('.viewSwitcher > div').removeClass('active');
            $('.switcherView').removeClass('switch-view-active');

            $(this).addClass('active');
            $('.switcherView.view-'+view).addClass('switch-view-active');

        });

        $('.images .all').slick({
          infinite: true,
          slidesToShow: 5,
          slidesToScroll: 1,
          speed: 400,
          autoplay: true
        });
    })

    function switchTab( tab ) {
      $('.tab-holder.showed').removeClass('showed');
      $('.tab-holder.'+tab).addClass('showed');

      $('nav.tab-header li.active').removeClass('active');
      $('nav.tab-header li.'+tab).addClass('active');
      console.log(tab);
    }

    function changeProfilImg(i){
        $('.product-view .main-img a.zoom img').attr('src',i);
        $('.product-view .main-img a.zoom').attr('href',i);
    }
    function fixCatPosition() {
      var etop = $('.cat-menu').offset().top;
      var wtop = $(window).scrollTop();

      if ( wtop > 20 ) {
        $('.cat-menu').css({
          top: wtop + 0
        });
      } else {
        $('.cat-menu').css({
          top: 0
        });
      }
    }

    function fixCatHeight() {
      var wh = $(window).height();
      var header_h = $('body > header').height()+8;
      var footer_h = $('body > footer').height()+3;
      var visible_footer = ((wh-($('body > footer').offset().top-$(window).scrollTop())) > 0) ? true : false;

      if (!visible_footer) {
        footer_h = 0;
      }

      $('.cat-menu').css({
        maxHeight: wh - (header_h+footer_h)-25
      });
    }
</script>
