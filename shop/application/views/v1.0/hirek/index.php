<div class="news-page">
		<? if( $this->news ):
			$arg = $this->news->getFullData();
			$arg['date_format'] = $this->settings['date_format'];
		?>
		<div class="pw">
			<? echo $this->template->get( 'hir-olvas',  $arg ); ?>
		</div>

		<?php if ( $this->related->getNums() != 0): ?>
			<div class="news related-news">
				<div class="pw">
					<h2 class="title">Ezeket olasta már?</h2>
					<div class="articles">
						<?
						$step = 0;
						while ( $this->related->walk() ) {
							$step++;
							$arg = $this->related->the_news();
							$arg['date_format'] = $this->settings['date_format'];
							echo $this->template->get( 'slide', $arg );
						}?>
					</div>
				</div>
			</div>

			<script type="text/javascript">
				$(function(){
					$('.news.related-news .articles').slick({
						infinite: true,
					  slidesToShow: 3,
					  slidesToScroll: 1,
						dots: true
					});
				})
			</script>
		<?php endif; ?>


		<? else: ?>
		<div class="news-list">
			<div class="pw">
				<h1>Híreink</h1>
				<div class="articles">
					<?
					$step = 0;
					while ( $this->list->walk() ) {
						$step++;
						$arg = $this->list->the_news();
						$arg['date_format'] = $this->settings['date_format'];

						echo $this->template->get( 'hir', $arg );
					}?>
				</div>
				<?=$this->navigator?>
			</div>
		</div>
		<? endif; ?>
</div>
