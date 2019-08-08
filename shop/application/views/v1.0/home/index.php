<div class="home">
	<div class="pw">
		<div class="grid-layout">
			<div class="grid-row filter-sidebar">
				<? $this->render('templates/sidebar_menu'); ?>
			</div>
			<div class="grid-row inside-content">
				<?php $this->render('templates/finder'); ?>
				<?php if ( false ): ?>
					<div class="title-header">
						<div class="">
							<h2>Újdonságok</h2>
						</div>
					</div>
					<div class="webshop-product-top slide-style">
						<?php if (true): ?>
							<div class="items trackwidth">
								<? foreach ( $this->ujdonsag_products_list as $p ) {
										$p['itemhash'] = hash( 'crc32', microtime() );
										$p['sizefilter'] = ( count($this->ujdonsag_products->getSelectedSizes()) > 0 ) ? true : false;
										$p['show_variation'] = ($this->myfavorite) ? true : false;
										$p = array_merge( $p, (array)$this );
										echo $this->ptemplate->get( 'product_item', $p );
								} ?>
							</div>
						<?php endif; ?>
					</div>

					<div class="title-header">
						<div class="">
							<h2>Kiemelt ajánlataink</h2>
						</div>
					</div>
					<div class="webshop-product-top slide-style">
						<?php if (true): ?>
							<div class="items trackwidth">
								<? foreach ( $this->kiemelt_products_list as $p ) {
										$p['itemhash'] = hash( 'crc32', microtime() );
										$p['sizefilter'] = ( count($this->kiemelt_products->getSelectedSizes()) > 0 ) ? true : false;
										$p['show_variation'] = ($this->myfavorite) ? true : false;
										$p = array_merge( $p, (array)$this );
										echo $this->ptemplate->get( 'product_item', $p );
								} ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( $this->news->has_news()): ?>
				<div class="news trackwidth">
						<div class="title-header">
							<div class="">
								<h2>Híreink</h2>
							</div>
						</div>
						<div class="articles <?=($this->news->getNums() > 3)?'slided':'no-slided'?>">
							<?
							$step = 0;
							while ( $this->news->walk() ) {
								$step++;
								$arg = $this->news->the_news();
								$arg['date_format'] = $this->settings['date_format'];
								echo $this->template->get( 'slide', $arg );
							}?>
						</div>
				</div>
			<?php endif;?>
				<script type="text/javascript">
					$(function(){
						<? if($this->news->getNums() > 3): ?>
						/* */
						$('.news .articles.slided').slick({
							infinite: true,
						  slidesToShow: 2,
						  slidesToScroll: 1,
							dots: true
						});
						/* */
						<? endif; ?>

						$('.webshop-product-top .items').slick({
						  slidesToShow: 3,
						  slidesToScroll: 3,
							dots: true
						});

						trackwidth();
						fixNewsImgHeight();

						$(window).resize(function(){
							trackwidth();
							fixNewsImgHeight();
						});
					})

					function trackwidth(){
						var w = 1200 - $('.filter-sidebar').width() - $('.right-sidebar').width() - 40;
						var pw = $('body').width();

						console.log(pw);
						if (w >= pw) {
							w = pw - 30;
						}
						// 680
						$('.trackwidth').css({
							width: w
						});
					}
					function fixNewsImgHeight(){
						var w = $('.news .articles article .img').width();
						var h = w / 1.75;
						$('.news .articles article .img').css({
							height: h
						});
					}
				</script>
			</div>
			<div class="grid-row right-sidebar">
				<? $this->render('templates/sidebar'); ?>
			</div>
		</div>
	</div>

	<?php if (count($this->factorylist) > 0 && false): ?>
	<div class="factory-preview">
		<div class="pw">
			<div class="factories">
				<?php foreach ( $this->factorylist as $f ): ?>
				<div class="fact">
					<img src="<?=IMGDOMAIN.$f['image']?>" alt="<?=$f['neve']?>">
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$('.factories').slick({
				infinite: true,
			  slidesToShow: 6,
			  slidesToScroll: 1,
				dots: false,
				autoplay: true,
				speed: 1500
			});
		});
	</script>
	<?php endif; ?>
</div>
