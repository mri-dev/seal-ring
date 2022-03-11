
	<?php if ( !$this->homepage ): ?>
		</div> <!-- .inside-content -->
		<div class="clr"></div>
		</div><!-- #main -->
		<div class="clr"></div>
	</div><!-- website -->
	<?php endif; ?> 

	<footer>
		<div class="main">
			<div class="pwf">
				<div class="wrapper">
					<div class="flex">
						<div class="links">
							<div class="segitseg">
								<h3><?=__('Tájékoztatók')?></h3>
								<ul>
									<? foreach ( $this->menu_footer->tree as $menu ): ?>
										<li>
											<? if($menu['link']): ?><a href="<?=($menu['link']?:'')?>"><? endif; ?>
												<span class="item <?=$menu['css_class']?>" style="<?=$menu['css_styles']?>">
													<? if($menu['kep']): ?><img src="<?=\PortalManager\Formater::sourceImg($menu['kep'])?>"><? endif; ?>
													<?=__(trim($menu['nev']))?></span>
											<? if($menu['link']): ?></a><? endif; ?>
											<? if($menu['child']): ?>
												<? foreach ( $menu['child'] as $child ) { ?>
													<div class="item <?=$child['css_class']?>">
														<?
														// Inclue
														if(strpos( $child['nev'], '=' ) === 0 ): ?>
															<? echo $this->templates->get( str_replace('=','',$child['nev']), array( 'view' => $this ) ); ?>
														<? else: ?>
														<? if($child['link']): ?><a href="<?=$child['link']?>"><? endif; ?>
														<? if($child['kep']): ?><img src="<?=\PortalManager\Formater::sourceImg($child['kep'])?>"><? endif; ?>
														<span style="<?=$child['css_styles']?>"><?=__(trim($child['nev']))?></span>
														<? if($child['link']): ?></a><? endif; ?>
														<? endif; ?>
													</div>
												<? } ?>
											<? endif; ?>
										</li>
									<? endforeach; ?>
								</ul>
								<br>
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
								<br>
								<div class="page-visit">
									<div class="wrapper">
										<?=__('Weboldal látogatottsága')?>:
										<div class="seps"></div>
										<div class="visit"><?php echo number_format($this->page_visits, 0, ".". "", " "); ?></div>										
										<div class="sep"></div>
										<div class="last-refresh"><?=__('Frissítve')?>: <?php echo date('Y. m. d. H:i'); ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="contacts">

						</div>
						<div class="subs">
							<h3><?=__('Feliratkozás')?></h3>
							<div class="subbox">
								<div class="wrapper">
									<div class="form">
										<form class="" action="/feliratkozas" method="get">
											<div class="name">
												<div class="flex flexmob-exc-resp">
													<div class="ico">
														<i class="fa fa-user"></i>
													</div>
													<div class="input">
														<input type="text" name="name" value="" placeholder="<?=__('Név')?>">
													</div>
												</div>
											</div>
											<div class="email">
												<div class="flex flexmob-exc-resp">
													<div class="ico">
														<i class="fa fa-envelope"></i>
													</div>
													<div class="input">
														<input type="text" name="email" value="" placeholder="<?=__('E-mail')?>">
													</div>
												</div>
											</div>
											<div class="aszf">
												<input type="checkbox" name="aszf" id="subs_aszf" value=""> <label for="subs_aszf"> <?php echo sprintf(__('Adataim magadásával, elfogadom az <a href="%s" target="_blank">%s</a> feltételeit és hozzájárulok ahhoz, hogy a %s ismertető leveleket küldjön nekem a megadott névre és email címre.'), '/p/aszf', __('ÁSZF'), $this->settings['page_author']); ?> </label>
											</div>
											<div class="button">
												<button type="submit" name="subscribe"><?=__('Mehet')?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<?php if (false): ?>
							<div class="contacts">
								<div class="searcher">
									<h3>Keresés</h3>
				          <div class="searchform">
				            <form class="" action="/termekek/" method="get">
				            <div class="flex flexmob-exc-resp">
				              <div class="input">
				                <input type="text" name="src" value="<?=$_GET['src']?>" placeholder="Keresési kifejezés megadása">
				              </div>
				              <div class="button">
				                <button type="submit"><i class="fa fa-search"></i></button>
				              </div>
				            </div>
				            </form>
				          </div>
				        </div>
								<div class="contact">
									<h3>Kapcsolat</h3>
									<div class="">
										<i class="fa fa-phone"></i> Telefon: <a href="tel:<?php echo $this->settings['page_author_phone']; ?>"><?php echo $this->settings['page_author_phone']; ?></a>
									</div>
									<div class="">
										<i class="fa fa-envelope"></i> E-mail: <?php echo $this->settings['office_email']; ?>
									</div>
									<div class="">
										<i class="fa fa-map-marker"></i> Cím: <?php echo $this->settings['page_author_address']; ?>
									</div>
								</div>
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
							</div>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<div class="info">
			<div class="bottom">
				<div class="pwf">
					<span class="author"> <?=$this->settings['page_author']?></span> &copy; 2018. &mdash; <?=__('Minden jog fenntartva!')?>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>
