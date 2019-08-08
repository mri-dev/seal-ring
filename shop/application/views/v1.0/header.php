<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/html4"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml" lang="hu-HU" ng-app="sealring">
<head>
    <title><?=$this->title?></title>
    <?=$this->addMeta('robots','index,folow')?>
    <?=$this->SEOSERVICE?>
    <?php if ( $this->settings['FB_APP_ID'] != '' ): ?>
    <meta property="fb:app_id" content="<?=$this->settings['FB_APP_ID']?>" />
    <?php endif; ?>
    <? $this->render('meta'); ?>
</head>
<body class="<?=$this->bodyclass?><?=($this->showslideshow)?' slidered':''?>" ng-controller="App" ng-init="init(<?=($this->gets[0] == 'kosar' && $this->gets[1] == 4)?'true':'false'?>)">
<div ng-show="showed" ng-controller="popupReceiver" class="popupview" data-ng-init="init({'contentWidth': 1150, 'domain': '.seal-ring.web-pro.hu', 'receiverdomain' : '<?=POPUP_RECEIVER_URL?>', 'imageRoot' : '<?=POPUP_IMG_ROOT?>/'})"><ng-include src="'/<?=VIEW?>popupview.html'"></ng-include></div>
<? if(!empty($this->settings[google_analitics])): ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', ' <?=$this->settings[google_analitics]?>', 'auto');
  ga('send', 'pageview');
</script>
<? endif; ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="szechenyi-info">
  <a href="/p/szechenyi-2020"><img src="<?=UPLOADS?>szechenyi2020/szechenyi2020-logo.png" alt="Széchenyi 2020"></a>
</div>
<header>
  <div class="pw">
    <div class="flex">
      <div class="logo">
        <a href="<?=$this->settings['page_url']?>"><img src="<?=IMG?>sealringlogo.svg" alt="<?=$this->settings['page_title']?>"></a>
      </div>
      <div class="main hide-on-mobile">
        <div class="top">
          <div class="flex">
            <div class="social">
              <div class="flex flexmob-exc-resp">
                <?php if ( !empty($this->settings['social_facebook_link'])) : ?>
                <div class="facebook">
                  <a target="_blank" title="Facebook oldalunk" href="<?=$this->settings['social_facebook_link']?>"><i class="fa fa-facebook"></i></a>
                </div>
                <?php endif; ?>
                <?php if ( !empty($this->settings['social_youtube_link'])) : ?>
                <div class="youtube">
                  <a target="_blank" title="Youtube csatornánk" href="<?=$this->settings['social_youtube_link']?>"><i class="fa fa-youtube"></i></a>
                </div>
                <?php endif; ?>
                <?php if ( !empty($this->settings['social_googleplus_link'])) : ?>
                <div class="googleplus">
                  <a target="_blank" title="Google+ oldalunk" href="<?=$this->settings['social_googleplus_link']?>"><i class="fa fa-google-plus"></i></a>
                </div>
                <?php endif; ?>
                <?php if ( !empty($this->settings['social_twitter_link'])) : ?>
                <div class="twitter">
                  <a target="_blank" title="Twitter oldalunk" href="<?=$this->settings['social_twitter_link']?>"><i class="fa fa-twitter"></i></a>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <?php if (false): ?>
              <div class="contacts">
                <div class="flex">
                  <div class="phone">
                    <i class="fa fa-phone"></i> <a href="tel:<?=$this->settings['page_author_phone']?>"><?=$this->settings['page_author_phone']?></a>
                  </div>
                  <div class="email">
                    <i class="fa fa-envelope"></i> <a href="mailto:<?=$this->settings['office_email']?>"><?=$this->settings['office_email']?></a>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <div class="navs">
              <div class="flex">
                <?php if (!$this->user): ?>
                <div class="partner">
                  <a href="/user/regisztracio">Regisztráció</a>
                </div>
                <div class="ugyfelkapu">
                  <a href="/user/belepes"><i class="fa fa-user"></i> Belépés</a>
                </div>
                <?php else: ?>
                  <div class="ugyfelkapu">
                    <a href="/user/"><i class="fa fa-user"></i> Belépve, mint <strong><?=$this->user['data']['nev']?></strong>.</a>
                  </div>
                <?php endif; ?>

                <div class="div"></div>
                <div class="kedvencek">
                  <a href="/kedvencek"><i class="fa fa-star"></i> Kedvencek <span class="badge">{{fav_num}}</span></a>
                </div>
                <div class="cart">
                  <div class="holder" id="mb-cart" mb-event="true" data-mb='{ "event": "toggleOnClick", "target" : "#mb-cart" }'>
                    <div class="ico">
                      <img src="<?=IMG?>icons/cart.svg" alt="Kosár" />
                    </div>
                    <div class="cash"><span class="amount" id="cart-item-prices">0</span> Ft <span class="badge" id="cart-item-num-v">0</span></div>
                    <div class="cbtn"><a href="/kosar">kosár</a></div>
                    <div class="floating">
                      <div id="cartContent" class="cartContent overflowed">
                        <div class="noItem"><div class="inf">A kosár üres</div></div>
                      </div>
                      <div class="whattodo">
                        <div class="flex">
                          <div class="doempty">
                            <a href="/kosar/?clear=1">Kosár ürítése <i class="fa fa-trash"></i></a>
                          </div>
                          <div class="doorder">
                            <a href="/kosar">Megrendelése <i class="fa fa-arrow-circle-o-right"></i></a>
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
        <div class="flex">
          <div class="nav">
            <ul>
              <? foreach ( $this->menu_header->tree as $menu ): ?>
              <li class="<?=($menu['child'])?'has-sub':''?>">
                <a href="<?=($menu['link']?:'')?>">
                  <? if($menu['kep']): ?><img src="<?=\PortalManager\Formater::sourceImg($child['kep'])?>"><? endif; ?>
                  <?=$menu['nev']?> <? if($menu['child']): ?><i class="fa fa-angle-down"></i><? endif; ?></a>
                  <? if($menu['child']): ?>
                  <div class="sub nav-sub-view">
                      <div class="inside">
                        <ul>
                        <? foreach($menu['child'] as $child): ?>
                        <li class="<?=$child['css_class']?>">
                          <? if($child['link']): ?><a href="<?=$child['link']?>"><? endif; ?>
                          <span style="<?=$child['css_styles']?>"><?=$child['nev']?></span>
                          <? if($child['link']): ?></a><? endif; ?>
                        </li>
                        <? endforeach; ?>
                        </ul>
                      </div>
                  </div>
                  <? endif; ?>
              </li>
              <? endforeach; ?>
            </ul>
          </div>
          <div class="search">
            <div class="searchform">
              <form class="" action="/termekek/<?=($this->gets[0] == 'termekek' && $this->gets[1] != '')?$this->gets[1]:''?>" method="get">
                <div class="wrapper">
                  <div class="input">
                    <input type="text" name="src" value="<?=$_GET['src']?>" placeholder="TERMÉK NÉV / CIKKSZÁM">
                  </div>
                  <div class="button">
                    <button type="submit"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="mobile-main show-on-mobile">
        <div class="quicknav">
          <div class="partner">
            <a href="/user/regisztracio" title="Regisztráció"><i class="fa fa-sign-in"></i></a>
          </div>
          <div class="ugyfelkapu">
            <a href="/user/belepes" title="Bejelentkezés"><i class="fa fa-user"></i></a>
          </div>
          <div class="kedvencek">
            <a href="/kedvencek"><i class="fa fa-star"></i><span class="badge">{{fav_num}}</span></a>
          </div>
        </div>
        <div class="cart">
          <div class="holder" id="mb-cart" mb-event="true" data-mb='{ "event": "toggleOnClick", "target" : "#mb-cart" }'>
            <div class="ico">
              <img src="<?=IMG?>icons/cart.svg" alt="Kosár" />
            </div>
            <div class="cash"><span class="amount cart-item-prices">0</span> Ft <span class="badge" id="cart-item-num-v">0</span></div>
            <div class="floating">
              <div id="cartContent" class="cartContent overflowed">
                <div class="noItem"><div class="inf">A kosár üres</div></div>
              </div>
              <div class="whattodo">
                <div class="flex">
                  <div class="doempty">
                    <a href="/kosar/?clear=1">Kosár ürítése <i class="fa fa-trash"></i></a>
                  </div>
                  <div class="doorder">
                    <a href="/kosar">Megrendelése <i class="fa fa-arrow-circle-o-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mobilnav">
          <div class="mobilnavtoggler" id="mb-nav" mb-event="true" data-mb='{ "event": "toggleOnClick", "target" : "#mb-nav", "bodynoscroll": true, "calcheight": ".mobilnavtoggler + .mobil-nav-holder", "calcheightminus": 0 }'>
            <i class="fa fa-bars"></i>
          </div>
          <div class="mobil-nav-holder">
            <div class="subnavtitle">Menü</div>
            <div class="nav">
              <ul>
                <? foreach ( $this->menu_header->tree as $menu ): ?>
                <li class="<?=($menu['child'])?'has-sub':''?>">
                  <a href="<?=($menu['link']?:'')?>">
                    <? if($menu['kep']): ?><img src="<?=\PortalManager\Formater::sourceImg($child['kep'])?>"><? endif; ?>
                    <?=$menu['nev']?> <? if($menu['child']): ?><i class="fa fa-angle-down"></i><? endif; ?></a>
                    <? if($menu['child']): ?>
                    <div class="sub nav-sub-view">
                        <div class="inside">
                          <ul>
                          <? foreach($menu['child'] as $child): ?>
                          <li class="<?=$child['css_class']?>">
                            <? if($child['link']): ?><a href="<?=$child['link']?>"><? endif; ?>
                            <span style="<?=$child['css_styles']?>"><?=$child['nev']?></span>
                            <? if($child['link']): ?></a><? endif; ?>
                          </li>
                          <? endforeach; ?>
                          </ul>
                        </div>
                    </div>
                    <? endif; ?>
                </li>
                <? endforeach; ?>
              </ul>
            </div>
            <div class="subnavtitle">Termékek</div>
            <? $this->render('templates/sidebar_menu'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if ( $this->showslideshow && false ): ?>
  <div class="slideshow">
    <?php $this->render('templates/slideshow'); ?>
  </div>
  <?php endif; ?>
  <?php if ( $this->showslideshow && count($this->highlight_text) > 0 && false): ?>
  <div class="bottom">
    <div class="pw">
      <div class="flex">
        <div class="tudta-head">
          <div class="ico"><i class="fa fa-lightbulb-o "></i></div>
          <div class="text">Tudta hogy...</div>
          <div class="clr"></div>
        </div>
        <div class="tudta-cont">
          <? if( count($this->highlight_text) > 0 ): ?>
        <div class="highlight-view">
          <? if( count($this->highlight_text['data']) > 1 && false ): ?>
          <a href="javascript:void(0);" title="Előző" class="prev handler" key="prev"><i class="fa fa-arrow-circle-left"></i></a>
          <a href="javascript:void(0);" title="Következő" class="next handler" key="next"><i class="fa fa-arrow-circle-right"></i></a>
          <? endif; ?>
          <div class="items">
            <div class="hl-cont">
              <ul>
                <? $step = 0; foreach( $this->highlight_text['data'] as $text ): $step++; ?>
                <li class="<?=($step == 1)?'active':''?>" index="<?=$step?>"><?=$text['tartalom']?></li>
                <? endforeach; ?>
              </ul>
              <div class="clr"></div>
            </div>
          </div>
        </div>
        <? endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</header>
<?php if ( !$this->homepage ): ?>
<!-- Content View -->
<div class="website">
		<?=$this->gmsg?>
		<div class="general-sidebar"></div>
		<div class="site-container <?=($this->gets[0]=='termek' || $this->gets[0]=='kosar' )?'productview':''?>">
			<div class="clr"></div>
			<div class="inside-content">
<?php endif; ?>
