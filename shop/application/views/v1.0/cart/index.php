<? $k = $this->kosar; ?>
<div class="cart">
	<div class="page-width">
		<div class="responsive-view full-width">
			<form class="" action="" method="post">
			<div class="box">
				<div class="cart-head">
					<? if( count($k['items']) > 0 ): ?>
					<div style="float:right;">
						<? if($this->gets[1] == '' || $this->gets[1] == '0'): ?>
							<a href="/kosar/?clear=1" class="clear-cart" title="Kosár ürítése">kosár üritése <i class="fa fa-trash-o"></i></a>
						<? endif; ?>
					</div>
					<? endif; ?>
					<h1>Kosár tartalma</h1>
					<div class="right">
						<button class="btn btn-danger btn-sm mustReload" onclick="document.location.reload(true);">A kosár tartalma megváltozott. <strong>Kattintson</strong> a frissítéshez!</button>
					</div>
				</div>
				<a name="step"></a>
				<?=$this->msg?>

				<?php if ( $this->gets[1] == '1' ): ?>
					<div class="order-stepper overview">
						<div class="head"><h2><i class="fa fa-user"></i> Vásárlói fiók</h2></div>
						<div class="pre-before-order user-logged">
							<div class="user">
								<div class="face">
									<div class="face-wrapper">
										<div class="it"><?=$this->user['data']['piktoname']?></div>
									</div>
								</div>
								<div class="useroverview">
									<div class="name">
										<strong><?=$this->user['data']['nev']?></strong> <?php if ($this->user['data']['user_group'] == 'company' && $this->user['data']['company_name'] != ''): ?>
										(<?=$this->user['data']['company_name']?>)
										<?php endif; ?>
									</div>
									<div class="email">
										<?=$this->user['data']['email']?>
									</div>
									<div class="action">
										<a href="/user/logout?safe=1&return=/<?=$this->gets[0]?>" class="logout">Kijelentkezés <i class="fa fa-sign-out"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="head"><h2><i class="fa fa-truck"></i> Átvétel módja</h2></div>
						<div class="head"><h2><i class="fa fa-money"></i> Fizetés módja</h2></div>
						<div class="head"><h2><i class="fa fa-comment-o"></i> Megjegyzés a megrendeléshez</h2></div>
						<div class="pre-before-order user-logged order-comment">
							<div class="full-line">
								<textarea name="comment" placeholder="A rendeléssel kapcsolatban ide írja kéréseit..." class="form-control"></textarea>
							</div>
						</div>
						<div class="head"><h2><i class="fa fa-inbox"></i> Megrendelendő termékek áttekintése</h2></div>
					</div>
				<?php endif; ?>

				<div class="mobile-table-container overflowed cart-items">
					<table class="table table-bordered">
						<thead>
							<tr class="item-header">
								<th class="center">Termék</th>
								<th  width="120" class="center">Me.</th>
								<th class="center" width="15%">Egységár</th>
								<th class="center" width="15%"><?=($this->user['data']['price_group_data']['groupkey'] == 'beszerzes_netto')?'Nettó ár':(($this->settings['price_show_brutto'] == 0)?'Nettó ár':'Bruttó ár')?></th>
								<th class="center" width="10"></th>
							</tr>
						</thead>
						<?php if (count($k['items']) > 0): ?>
						<tbody>
							<? foreach($k['items'] as $d):
								if($d['szuper_akcios'] == 1){
									$szuperakcios_termekek_ara += $d['sum_ar'];
								}
								if($d['pickpackszallitas'] == 0) $no_ppp_itemNum++;
								if($d['elorendelheto'] == 1) $preOrder_item++;
							?>
							<tr class="item">
								<td>
									<div class="main">
										<div class="img">
											<a href="<?=$d['url']?>"><img src="<?=$d['profil_kep']?>" alt="<?=$d['termekNev']?>" /></a>
										</div>
										<div class="tinfo">
											<div class="nev"><a href="<?=$d['url']?>"><?=$d['termekNev']?></a></div>
											<div class="sel-types">
												<? if($d['szin']): ?><em>Variáció:</em> <strong><?=$d['szin']?></strong><? endif;?>
												<? if($d['meret']): ?><em>Kiszerelés:</em> <strong><?=$d['meret']?></strong><? endif;?>
											</div>
											<div class="subLine">
												<span title="Termék elérhetősége"><i class="fa fa-truck"></i> <?=$d['allapot']?></span> &nbsp;&nbsp;
												<span title="Kiszállítási idő"><i class="fa fa-clock-o"></i> <?=$d['szallitasIdo']?></span>
											</div>
										</div>
									</div>
								</td>
								<td class="center">
									<strong><?=$d['me']?> db</strong>
									<?php if ($d['me'] > $d['raktar_keszlet']): ?>
										<div class="raktar_keszlet" style="<?=($d['raktar_keszlet']<=0)?'color:#ff9167;':'color:#15a98c;'?>"><?=($d['raktar_keszlet']<=0)?'Nincs raktáron: Rendelhető.':$d['raktar_keszlet'].' db raktáron.<br><span style="color:#ff9167;">'.($d['me']-$d['raktar_keszlet']).' rendelhető.</span>'?></div>
									<?php endif; ?>
								</td>
								<td class="center">
									<? if( $d['discounted'] ): ?>
										<div><strike><?=Helper::cashFormat($d['prices']['old_each'])?> Ft</strike></div>
										<div><strong><?=Helper::cashFormat($d['prices']['current_each'])?> Ft</strong></div>
									<? else: ?>
									<span><?=Helper::cashFormat($d['prices']['current_each'])?> Ft</span>
									<? endif; ?>
								</td>
								<td class="center">
									<? if( $d['discounted'] ): ?>
										<div><strike><?=Helper::cashFormat($d['prices']['old_sum'])?> Ft</strike></div>
										<div><strong><?=Helper::cashFormat($d['prices']['current_sum'])?> Ft</strong></div>
									<? else: ?>
									<strong><?=Helper::cashFormat($d['prices']['current_sum'])?> Ft</strong>
									<? endif; ?>
								</td>
								<td class="center action">
									<? if($this->gets[1] == '' || $this->gets[1] == '0'): ?>
									<span>
										<i class="fa fa-angle-up cart-adder asc" title="Több" onclick="Cart.addItem(<?=$d[termekID]?>)"></i>
										<i class="fa fa-angle-down cart-adder desc" title="Kevesebb" onclick="Cart.removeItem(<?=$d[termekID]?>)"></i>
									</span>
									<? endif; ?>
								</td>
							</tr>
							<? endforeach;
							// Végső ár kiszámolása
							$calc_final_total = $k[totalPrice] - $szuperakcios_termekek_ara;
							//$calc_final_total = ($calc_final_total -(($this->user[kedvezmeny]/100)*$calc_final_total)) + $szuperakcios_termekek_ara;
							?>
							</div>
						</tbody>
						<?php else: ?>
						<tbody>
							<tr>
								<td colspan="5" class="center">
									<div class="empty-cart">
										<i class="fa fa-shopping-cart ico"></i>
										<br>
										<strong>Az Ön kosarában nincsenek temékek!</strong>
										<div>Böngésszen termékeink közül.</div>
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
								</td>
							</tr>
						</tbody>
						<?php endif; ?>
					</table>

	        <?php
					// Ha nincs elegendő termék készleten - értesítő
					if(count($k['items']) > 0): ?>
						<?php if ($k['unstocked_items'] && $k['unstocked_items']['total'] != 0): ?>
						<div class="alert alert-warning">
							<i class="fa fa-exclamation-triangle"></i> A kosárban lévő termékeknél <strong><?=$k['unstocked_items']['total']?> db tétel nincs raktáron!</strong> Kérjük, vegye  figyelembe, hogy ezen tételeket hosszabb határidővel, gyártás / beszerzés után tudjuk teljesíteni.
						</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $this->gets[1] == '1' ): ?>
						<div class="order-stepper overview">
							<div class="head"><h2><i class="fa fa-shield"></i> Adatvédelmi Tájékoztató és Szállítási feltételek elfogadása</h2></div>
							<div class="pre-before-order user-logged">
								<div class="">
									bla bla
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( empty($this->gets[1]) ): ?>
						<div class="order-stepper">
								<?php if(!$this->user): ?>
								<div class="head">
									<h2>Bejelentkezés szükséges a vásárláshoz</h2>
								</div>
								<div class="pre-before-order user-not-logged">
									<div class="user">
										<div class="face">
											<div class="face-wrapper">
												<div class="it">?</div>
											</div>
										</div>
										<div class="login"><a href="/user/belepes?return=/<?=$this->gets[0]?>">Bejelentkezés</a></div>
										<div class="sep">vagy</div>
										<div class="register"><a href="/user/regisztracio?return=/<?=$this->gets[0]?>">Fiók regisztráció</a></div>
									</div>
									<div class="nextbutton">
										<button type="submit" name="orderState" disabled="disabled" value="start">Tovább a megrendeléshez</button>
									</div>
								</div>
								<?php else: ?>
									<div class="head">
										<h2>Bejelentkezve a következő fiókkal</h2>
									</div>
									<div class="pre-before-order user-logged">
										<div class="user">
											<div class="face">
												<div class="face-wrapper">
													<div class="it"><?=$this->user['data']['piktoname']?></div>
												</div>
											</div>
											<div class="useroverview">
												<div class="name">
													<strong><?=$this->user['data']['nev']?></strong> <?php if ($this->user['data']['user_group'] == 'company' && $this->user['data']['company_name'] != ''): ?>
													(<?=$this->user['data']['company_name']?>)
													<?php endif; ?>
												</div>
												<div class="email">
													<?=$this->user['data']['email']?>
												</div>
												<div class="action">
													<a href="/user/logout?safe=1&return=/<?=$this->gets[0]?>" class="logout">Kijelentkezés <i class="fa fa-sign-out"></i></a>
												</div>
											</div>
										</div>
										<div class="nextbutton">
											<button type="submit" name="orderState" value="start">Tovább a megrendeléshez</button>
										</div>
									</div>
								<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.cart-adder').click(function(){
			$('button.mustReload').css({visibility:'visible'});
		});
	});
</script>
