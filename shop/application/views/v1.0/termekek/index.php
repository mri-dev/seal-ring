<? if( true ): ?>
    <div class="category-listing page-width">
        <? $this->render('templates/slideshow'); ?>
        <div class="list-view webshop-product-top">
          <div class="grid-layout">
            <div class="grid-row filter-sidebar">
              <? $this->render('templates/sidebar_menu'); ?>
            </div>
            <div class="grid-row products">
              <?php $this->render('templates/finder'); ?>
              <br>
              <div>
                  <? if($this->parent_menu&& count($this->parent_menu) > 0): ?>
                  <div class="sub-categories">
                      <div class="title">
                          <h3><? $subk = ''; foreach($this->parent_row as $sc) { $subk .= $sc.' / '; } echo rtrim($subk,' / '); ?> alkategóriái</h3>
                          <? if($this->parent_category): ?>
                          <a class="back" href="<?=$this->parent_category->getURL()?>"><i class="fa fa-arrow-left"></i> vissza: <?=$this->parent_category->getName()?></a>
                           <? endif; ?>
                      </div>
                      <div class="holder">
                        <? foreach( $this->parent_menu as $cat ): ?>
                        <div class="item">
                          <div class="wrapper">
                            <?php if (false): ?>
                              <div class="img"><a href="<?=$cat['link']?>"><img src="<?=rtrim(IMGDOMAIN,"/").$cat['kep']?>" alt="<?=$cat['neve']?>"></a></div>
                            <?php endif; ?>
                            <div class="title"><a href="<?=$cat['link']?>"><?=$cat['neve']?></a></div>
                          </div>
                        </div>
                        <? endforeach; ?>
                      </div>
                  </div>
                  <? endif; ?>

                  <div class="category-title head">
                    <?php if ($this->myfavorite): ?>
                      <h1>Kedvencnek jelölt termékek</h1>
                      <div class="push-cart-favorite">
                        <a href="/kedvencek/?order=1&after=/kosar">Kedvenceket a kosárba teszem <i class="fa fa-cart-plus"></i></a>
                      </div>
                    <?php elseif($this->category->getName() != ''): ?>
                      <h1><?=$this->category->getName()?></h1>
                    <?php else: ?>
                      <?php if ($this->gets[1] == 'akciok'): ?>
                      <h1>Akciós termékek</h1>
                    <?php elseif($this->gets[1] == 'kiemelt'): ?>
                      <h1>Kiemelt termékek</h1>
                      <?php else: ?>
                      <h1>Termékek</h1>
                      <?php endif; ?>
                      <?php if (isset($this->searched_by)): ?>
                        <div class="search-for">
                         <i class="fa fa-search"></i> Keresés, mint: <?php foreach ($this->searched_by as $s): ?>
                            <span><?=$s?></span>
                          <?php endforeach; ?>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>
                      <?php $navh = '/termekek/'; ?>
                      <ul class="cat-nav">
                        <li><a href="/"><i class="fa fa-home"></i></a></li>
                        <li><a href="<?=$navh?>">Webshop</a></li>
                        <?php if ($this->myfavorite): ?>
                        <li>Kedvencek</li>
                        <?php endif; ?>
                        <?php
                        if($this->cat_nav):
                        foreach ( (array)$this->cat_nav as $nav ): $navh = \Helper::makeSafeUrl($nav['neve'],'_-'.$nav['ID']); ?>
                        <li><a href="/termekek/<?=$navh?>"><?php echo $nav['neve']; ?></a></li>
                      <?php endforeach; endif; ?>
                      </ul>

                      <div class="orders">
                        <form class="" id="formfilter" action="/termekek/<?=$this->gets[1]?>" method="get">
                          <input type="hidden" name="src" value="<?=$_GET['src']?>">
                          <div class="row">
                            <div class="col-md-9">
                              <div class="page-product-info">
                                <div class="prod-items"><strong><?php echo $this->products->getItemNumbers(); ?> találat</strong></div>
                                <div class="pages"><?php echo $this->products->getMaxPage(); ?> / <strong><?php echo $this->products->getCurrentPage(); ?>. oldal</strong></div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="input-group">
                                <span class="input-group-addon">Rendezés</span>
                                <select class="form-control" name="order" onchange="$('#formfilter').submit()">
                                  <option value="" selected="selected">Méret szerint</option>
                                  <option value="nev_ASC" <?=($_GET['order'] == 'nev_ASC'?'selected="selected"':'')?>>Név: A-Z</option>
                                  <option value="nev_DESC" <?=($_GET['order'] == 'nev_DESC'?'selected="selected"':'')?>>Név: Z-A</option>
                                  <option value="ar_ASC" <?=($_GET['order'] == 'ar_ASC'?'selected="selected"':'')?>>Ár: növekvő</option>
                                  <option value="ar_DESC" <?=($_GET['order'] == 'ar_DESC'?'selected="selected"':'')?>>Ár: csökkenő</option>
                                </select>
                              </div>
                            </div>
                        </div>
                        </form>
                      </div>
                      <div id="cart-msg"></div>
                  </div>

                  <? if( !$this->products->hasItems()): ?>
                  <div class="no-product-items">
                      <?php if ($this->myfavorite): ?>
                        <div class="icon"><i class="fa fa-circle-o-notch "></i></div>
                        <strong>Nincsenek kedvencnek jelölt termékei!</strong><br>
                        Kedvencnek jelölhet bármilyen terméket, hogy később gyorsan és könnyedén megtalálja.
                      <?php else: ?>
                        <div class="icon"><i class="fa fa-circle-o-notch"></i></div>
                        <strong>Nincsenek termékek ebben a kategóriában!</strong><br>
                        A szűrőfeltételek alapján nincs megfelelő termék, amit ajánlani tudunk. Böngésszen további termékeink között.
                      <?php endif; ?>
                  </div>
                  <? else: ?>
                      <div class="grid-container">

                      <? /* foreach ( $this->product_list as $p ) {
                          $p['itemhash'] = hash( 'crc32', microtime() );
                          $p['sizefilter'] = ( count($this->products->getSelectedSizes()) > 0 ) ? true : false;
                          echo $this->template->get( 'product_list_item', $p );
                      }*/ ?>
                          <div class="items">
                              <? foreach ( $this->product_list as $p ) {
                                  $p['itemhash'] = hash( 'crc32', microtime() );
                                  $p['sizefilter'] = ( count($this->products->getSelectedSizes()) > 0 ) ? true : false;
                                  $p['show_variation'] = ($this->myfavorite) ? true : false;
                                  $p = array_merge( $p, (array)$this );
                                  echo $this->template->get( 'product_item', $p );
                              } ?>
                          </div>
                      </div>
                      <script type="text/javascript">
                        $(function(){
                          fixTitleWidth();

                          $(window).resize(function(){
                            fixTitleWidth();
                          });
                        });

                        function fixTitleWidth() {
                          var pw = $(window).width();
                          if ( pw >= 1550 ) {
                            var w = $('.category-listing .items').width() / 4 - 55;
                          } else{
                            var w = $('.category-listing .items').width() / 3 - 55;
                          }

                          $('.category-listing .items .item .title a').css({
                            width: w
                          });

                        }
                      </script>
                      <div class="clr"></div>
                      <? echo $this->navigator; ?>
                  <br>
                  <? endif; ?>
              </div>
            </div>
            <div class="grid-row filter-sidebar">
              <? $this->render('templates/sidebar'); ?>
            </div>
          </div>
        </div>
    </div>
    <script type="text/javascript">
      $(function(){
        fixCatHeight();
        fixCatPosition();

        $(window).scroll(function(){
          fixCatHeight();
          fixCatPosition();
        });
      })

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
<? else: ?>
    <?=$this->render('home')?>
<? endif; ?>
