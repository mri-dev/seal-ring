<div class="size-data-container">
	<?
		$footer = $data->getFooterText();
		$desc 	= $data->getDescription();
		$image  = $data->getImage();
	?>
	<? if( $image ): ?>
	<div class="size-image">
		<img src="<?=\PortalManager\Formater::sourceImg($image)?>" alt="Mérettáblázat">
	</div>
	<? endif; ?>
	<div class="size-tbl-container">
		<? while( $data->walkDataset() ): $table = $data->the_table(); ?>
		<div class="size-tbl">
			<table>
				<thead>
					<? if($table['title'] && $table['title'] != ''): ?>
					<tr>
						<td class="title" colspan="999">
							<?=$table['title']?>
						</td>
					</tr>
					<? endif;?>
					<? if( $table['head'] && !empty($table['head']) ): ?>
					<tr>
						<? foreach( $table['head'] as $head ): if($head == '') continue; ?>
						<th class="head">
							<?=$head?>
						</th>
						<? endforeach;?>
					</tr>
					<? endif;?>
				</thead>
				<tbody>					
					<? if( $table['row'] && !empty($table['row']) ): ?>
					<? foreach( $table['row'] as $row ): ?>
					<tr>
						<? 
						$rowi = -1;
						foreach( $row as $r ): $rowi++;
						$width = $table['width'][$rowi];
						$style = $table['style'][$rowi];
						?>
						<td <?=($width)?'width="'.$width.'%"':''?> class="<?=(!$r)?'nv':''?>" style="<?=$style?>">
							<? if( is_array($data->checkSet($r)) ):  ?>
								<table class="data-set">
									<tbody>
										<tr>
											<? 
											$each_width = 100 / count($data->checkSet($r));
											foreach( $data->checkSet($r) as $set ): ?>
											<td style="width: <?=$each_width?>%;"><?=$set?></td>
											<? endforeach; ?>
										</tr>
									</tbody>
								</table>
							<? elseif(!$r): ?>
								&nbsp;
							<? else: ?>
								<?=$r?>
							<? endif; ?>
						</td>
						<? endforeach;?>						
					</tr>
					<? endforeach;?>
					<? endif;?>
				</tbody>
			</table>	
		</div>
		<? endwhile;?>
	</div>
	<? if( $desc ): ?>
	<div class="size-desc">
		<?=$desc?>
	</div>
	<? endif; ?>	
	<? if( $footer ): ?>
	<div class="size-footer">
		<?=$footer?>
	</div>
	<? endif; ?>	
	<div class="clr"></div>
</div>
