<? $k = $this->kosar; ?>
<div class="cart">
	<div class="page-width">
		<div class="responsive-view full-width">

			<? if( count($k['items']) > 0 ): ?>
			<form class="" action="" method="post">
			<? else: ?>
			<form class="" action="/termekek" method="get">
			<? endif; ?>
			<div class="box">

				<?php if ($this->gets['1'] != 'done'): ?>
				<div class="cart-head">
					<? if( count($k['items']) > 0 ): ?>
					<div style="float:right;">
						<? if($this->gets['1'] == '' || $this->gets['1'] == '0'): ?>
							<a href="/kosar/?clear=1" class="clear-cart" title="Kosár ürítése"><?=__('kosár üritése')?> <i class="fa fa-trash-o"></i></a>
						<? endif; ?>
					</div>
					<? endif; ?>
					<h1><?=__('Kosár tartalma')?></h1>
					<div class="right">
						<button class="btn btn-danger btn-sm mustReload" onclick="document.location.reload(true);"><?=__('A kosár tartalma megváltozott')?>. <strong><?=__('Kattintson')?></strong> <?=__('a frissítéshez')?>!</button>
					</div>
				</div>
				<?php endif; ?>

				<?php if ($this->gets['1'] == 'done'): ?>
					<div class="box orderDone">
						<a name="step" id="step"></a>
						<div class="p10">
					<?
						$vegosszeg 				= 0;
						$orderedProducts 	= array();

						foreach($this->orderInfo['items'] as $d):
							$vegosszeg 			+= $d['subAr'];
							$orderedProducts[] 	= $d['nev'];
						endforeach;

						if($this->orderInfo['szallitasi_koltseg'] > 0) $vegosszeg += $this->orderInfo['szallitasi_koltseg'];
						if($this->orderInfo['kedvezmeny'] > 0) $vegosszeg -= $this->orderInfo['kedvezmeny'];

					?>
					<h1><i class="fa fa-check-circle"></i><br /><?=__('Megrendelés elküldve')?></h1>
						<h2><?=__('Köszönjük megrendelését!')?></h2>
						<p><?=__('E-mail címére folyamatos tájékoztatást küldünk megrendelésének állapotáról.')?></p>

					<? if( $this->orderInfo['fizetesiModID'] == $this->settings['flagkey_pay_payu'] && $this->orderInfo['payu_fizetve'] == 0 ): ?>
						<br>
						<strong><?=__('Online bankkártyás fizetésindítása')?>: </strong><br><br>
						<?=$this->payu_btn?>
					<? endif; ?>

					<? if( $this->orderInfo['fizetesiModID'] == $this->settings['flagkey_pay_cetelem'] ): ?>
						<br>
						<a class="cetelem-startrans" href="<?=DOMAIN?>order/<?=$this->orderInfo['accessKey']?>/?cetelem=1#start">
							Cetelem online hiteligénylés indítása <i class="fa fa-angle-right"></i>
						</a>
					<? endif; ?>

					<? // PayPal fizetés
					if($this->fizetes[Helper::getFromArrByAssocVal($this->fizetes,'ID',$this->orderInfo['fizetesiModID'])]['nev'] == 'PayPal' && $this->orderInfo['paypal_fizetve'] == 0):


					?>
						<div style="padding:10px 0;">

						</div>
					<? endif; ?>
					<br />
					<div align="center">
						<br>
						<a href="<?=DOMAIN?>order/<?=$this->orderInfo['accessKey']?>" class="btn btn-pr"><?=__('Megrendelés adatlapja')?> <i class="fa fa-arrow-circle-right"></i></a>
					</div>
							</div>
					</div>
				<?php endif; ?>
				<a name="step"></a>
				<?=$this->msg?>
				<?php if ( $this->gets['1'] == '1' ): ?>
					<div class="order-stepper overview">
						<div class="head"><h2><i class="fa fa-user"></i> <?=__('Vásárlói fiók')?></h2></div>
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
										<a href="/user/logout?safe=1&return=/<?=$this->gets['0']?>" class="logout"><?=__('Kijelentkezés')?> <i class="fa fa-sign-out"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="pre-before-order align-top user-logged">
							<div class="szamlazas_info">
								<div class="wrapper">
									<h3><?=__('Számlázási adatok')?></h3>
										<? if($this->orderExc && in_array(1, $this->orderMustFillStep)): ?>
											<div align="center" class="p10"><span class="mustSelect"><i class="fa fa-warning"></i> <?=__('Figyelem! Hiányoznak a számlázási adatok. Kérjük pótolja!')?></span></div>
										<? else: ?>
										<div class="order-contact-info">
											<div class="row np">
													<div class="col-sm-5">
															<strong><?=__('Név')?></strong>
														</div>
														<div class="col-sm-7 right">
															<?=$this->user['data']['szamlazas_nev']?>
														</div>
												</div>
												<?php if ( $this->user['data']['szamlazas_adoszam'] != '' ): ?>
												<div class="row np">
														<div class="col-sm-5">
																<strong><?=__('Adószám')?></strong>
															</div>
															<div class="col-sm-7 right">
																<?=$this->user['data']['szamlazas_adoszam']?>
															</div>
													</div>
												<?php endif; ?>
												<?php if ( $this->user['data']['szamlazas_kerulet'] != '' ): ?>
												<div class="row np">
													<div class="col-sm-5">
															<strong><?=__('Kerület')?></strong>
														</div>
														<div class="col-sm-7 right">
															<?=$this->user['data']['szamlazas_kerulet']?>
														</div>
												</div>
												<?php endif; ?>
												<div class="row np">
													<div class="col-sm-5">
															<strong><?=__('Település')?></strong>
														</div>
														<div class="col-sm-7 right">
															<?=$this->user['data']['szamlazas_irsz']?> <?=$this->user['data']['szamlazas_city']?>
														</div>
												</div>
												<div class="row np">
													<div class="col-sm-7">
														<strong><?=__('Cím')?></strong> <br>
														<em><?=__('(közterület neve, közterület jellege, házszám)')?></em>
													</div>
													<div class="col-sm-5 right">
														<?=$this->user['data']['szamlazas_kozterulet_nev']?> <?=$this->user['data']['szamlazas_kozterulet_jelleg']?> <?=$this->user['data']['szamlazas_hazszam']?>
													</div>
												</div>
												<?php if ( $this->user['data']['szamlazas_epulet'] != '' ): ?>
												<div class="row np">
													<div class="col-sm-5">
															<strong><?=__('Épület')?></strong>
														</div>
														<div class="col-sm-7 right">
															<?=$this->user['data']['szamlazas_epulet']?>
														</div>
												</div>
												<?php endif; ?>
												<?php if ( $this->user['data']['szamlazas_emelet'] != '' ): ?>
												<div class="row np">
													<div class="col-sm-5">
															<strong><?=__('Emelet')?></strong>
														</div>
														<div class="col-sm-7 right">
															<?=$this->user['data']['szamlazas_emelet']?>
														</div>
												</div>
												<?php endif; ?>
												<?php if ( $this->user['data']['szamlazas_ajto'] != '' ): ?>
												<div class="row np">
													<div class="col-sm-5">
															<strong><?=__('Ajtó')?></strong>
														</div>
														<div class="col-sm-7 right">
															<?=$this->user['data']['szamlazas_ajto']?>
														</div>
												</div>
												<?php endif; ?>

												<div class="row np">
													<div class="col-sm-12 right">
															<a href="/user/beallitasok/?return=/kosar/1/#szamlazas"><?=__('Módosítás')?> <i class="fa fa-gear"></i></a>
													</div>
												</div>
											</div>
											<? endif; ?>
								</div>
							</div>
							<div class="szallitas_info">
								<div class="wrapper">
									<h3><?=__('Szállítási adatok')?></h3>
									<? if($this->orderExc && in_array(1, $this->orderMustFillStep)): ?>
										<div align="center" class="p10"><span class="mustSelect"><i class="fa fa-warning"></i> <?=__('Figyelem! Hiányoznak a számlázási adatok. Kérjük pótolja!')?></span></div>
									<? else: ?>
									<div class="order-contact-info">
										<div class="row np">
												<div class="col-sm-5">
														<strong><?=__('Név')?></strong>
													</div>
													<div class="col-sm-7 right">
														<?=$this->user['data']['szallitas_nev']?>
													</div>
											</div>
											<?php if ( $this->user['data']['szallitas_adoszam'] != '' ): ?>
											<div class="row np">
													<div class="col-sm-5">
															<strong><?=__('Adószám')?></strong>
														</div>
														<div class="col-sm-7 right">
															<?=$this->user['data']['szallitas_adoszam']?>
														</div>
												</div>
											<?php endif; ?>
											<?php if ( $this->user['data']['szallitas_kerulet'] != '' ): ?>
											<div class="row np">
												<div class="col-sm-5">
														<strong><?=__('Kerület')?></strong>
													</div>
													<div class="col-sm-7 right">
														<?=$this->user['data']['szallitas_kerulet']?>
													</div>
											</div>
											<?php endif; ?>
											<div class="row np">
												<div class="col-sm-5">
														<strong><?=__('Település')?></strong>
													</div>
													<div class="col-sm-7 right">
														<?=$this->user['data']['szallitas_irsz']?> <?=$this->user['data']['szallitas_city']?>
													</div>
											</div>
											<div class="row np">
												<div class="col-sm-7">
													<strong><?=__('Cím')?></strong> <br>
													<em><?=__('(közterület neve, közterület jellege, házszám)')?></em>
												</div>
												<div class="col-sm-5 right">
													<?=$this->user['data']['szallitas_kozterulet_nev']?> <?=$this->user['data']['szallitas_kozterulet_jelleg']?> <?=$this->user['data']['szallitas_hazszam']?>
												</div>
											</div>
											<?php if ( $this->user['data']['szallitas_epulet'] != '' ): ?>
											<div class="row np">
												<div class="col-sm-5">
														<strong><?=__('Épület')?></strong>
													</div>
													<div class="col-sm-7 right">
														<?=$this->user['data']['szallitas_epulet']?>
													</div>
											</div>
											<?php endif; ?>
											<?php if ( $this->user['data']['szallitas_emelet'] != '' ): ?>
											<div class="row np">
												<div class="col-sm-5">
														<strong><?=__('Emelet')?></strong>
													</div>
													<div class="col-sm-7 right">
														<?=$this->user['data']['szallitas_emelet']?>
													</div>
											</div>
											<?php endif; ?>
											<?php if ( $this->user['data']['szallitas_ajto'] != '' ): ?>
											<div class="row np">
												<div class="col-sm-5">
														<strong><?=__('Ajtó')?></strong>
													</div>
													<div class="col-sm-7 right">
														<?=$this->user['data']['szallitas_ajto']?>
													</div>
											</div>
											<?php endif; ?>
											<div class="row np">
												<div class="col-sm-5">
														<strong><?=__('Telefonszám')?></strong>
												</div>
												<div class="col-sm-7 right">
														<?=$this->user['data']['szallitas_phone']?>
												</div>
											</div>
											<div class="row np">
												<div class="col-sm-12 right">
														<a href="/user/beallitasok/?return=/kosar/1/#szallitas"><?=__('Módosítás')?> <i class="fa fa-gear"></i></a>
												</div>
											</div>
										</div>
										<? endif; ?>
								</div>
							</div>
						</div>
						<div class="head"><h2><i class="fa fa-truck"></i> <?=__('Átvétel módja')?></h2></div>
						<div class="transmod <?=($this->user['data']['szallitas_mod_name'])?'':'not-valid'?>">
							<div class="wrapper">
								<?php if ($this->user['data']['szallitas_mod_name']): ?>
								<div class="st"><div class="wrap"><i class="fa fa-check"></i></div></div>
								<div class="title"><?=__($this->user['data']['szallitas_mod_name']['nev'])?> <? if(!empty($this->user['data']['szallitas_mod_name']['ido'])): ?><span class="transtime">~ <?=$this->user['data']['szallitas_mod_name']['ido']?> <?=__('munkanap')?></span><? endif; ?></div>
								<div class="change"><a href="/user/beallitasok/?return=/kosar/1/#transmods"><?=__('Módosítás')?> <i class="fa fa-gear"></i> </a></div>
								<?php else: ?>
								<div class="st"><div class="wrap"><i class="fa fa-times"></i></div></div>
								<div class="title"><?=__('Hiányos konfiguráció! Kérjük, hogy módosítsa a beállításait')?> -----></div>
								<div class="change"><a href="/user/beallitasok/?return=/kosar/1/#transmods"><?=__('Módosítás')?> <i class="fa fa-gear"></i> </a></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="head"><h2><i class="fa fa-money"></i> <?=__('Fizetés módja')?></h2></div>
						<div class="transmod <?=($this->user['data']['fizetes_mod_name'])?'':'not-valid'?>">
							<div class="wrapper">
								<?php if ($this->user['data']['fizetes_mod_name']): ?>
								<div class="st"><div class="wrap"><i class="fa fa-check"></i></div></div>
								<div class="title"><?=__($this->user['data']['fizetes_mod_name']['nev'])?> <? if(!empty($this->user['data']['fizetes_mod_name']['ido'])): ?><span class="transtime">~ <?=$this->user['data']['fizetes_mod_name']['ido']?> <?=__('munkanap')?></span><? endif; ?></div>
								<div class="change"><a href="/user/beallitasok/#transmods"><?=__('Módosítás')?> <i class="fa fa-gear"></i> </a></div>
								<?php else: ?>
								<div class="st"><div class="wrap"><i class="fa fa-times"></i></div></div>
								<div class="title"><?=__('Hiányos konfiguráció! Kérjük, hogy módosítsa a beállításait')?> -----></div>
								<div class="change"><a href="/user/beallitasok/#transmods"><?=__('Módosítás')?> <i class="fa fa-gear"></i> </a></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="head"><h2><i class="fa fa-comment-o"></i> <?=__('Megjegyzés a megrendeléshez')?></h2></div>
						<div class="pre-before-order user-logged order-comment">
							<div class="full-line">
								<textarea name="comment" placeholder="<?=__('A rendeléssel kapcsolatban ide írja kéréseit...')?>" class="form-control"><?=$_POST['comment']?></textarea>
							</div>
						</div>
						<div class="head"><h2><i class="fa fa-inbox"></i> <?=__('Megrendelendő termékek áttekintése')?></h2></div>
					</div>
				<?php endif; ?>

				<div class="cart-items">
					<div class="mobile-table-container overflowed ">
						<table class="table table-bordered">
						<thead>
							<tr class="item-header">
								<th class="center"><?=__('Termék')?></th>
								<th  width="120" class="center"><?=__('Me')?>.</th>
								<th class="center" width="15%"><?=__('Egységár')?></th>
								<th class="center" width="15%"><?=($this->user['data']['price_group_data']['groupkey'] == 'beszerzes_netto')?'Nettó ár':(($this->settings['price_show_brutto'] == 0)?__('Nettó ár'):__('Bruttó ár'))?></th>
								<th class="center" width="10"></th>
							</tr>
						</thead>
						<?php if (count($k['items']) > 0): ?>
						<tbody>
							<?php $calc_final_total = 0; ?>
							<? foreach($k['items'] as $d):
								if($d['szuper_akcios'] == 1){
									$szuperakcios_termekek_ara += $d['sum_ar'];
								}
								$calc_final_total += $d['sum_ar'];
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
												<? if($d['szin']): ?><em><?=__('Variáció')?>:</em> <strong><?=$d['szin']?></strong><? endif;?>
												<? if($d['meret']): ?><em><?=__('Kiszerelés')?>:</em> <strong><?=$d['meret']?></strong><? endif;?>
											</div>
											<div class="subLine">
												<span title="Termék elérhetősége"><i class="fa fa-truck"></i> <?=__($d['allapot'])?></span> &nbsp;&nbsp;
												<span title="Kiszállítási idő"><i class="fa fa-clock-o"></i> <?=__($d['szallitasIdo'])?></span>
											</div>
										</div>
									</div>
								</td>
								<td class="center">
									<strong><?=$d['me']?> <?=__('db')?></strong>
									<?php if ($d['me'] > $d['raktar_keszlet']): ?>
										<div class="raktar_keszlet" style="<?=($d['raktar_keszlet']<=0)?'color:#ff9167;':'color:#15a98c;'?>"><?=($d['raktar_keszlet']<=0)?__('Nincs raktáron: Rendelhető.'):$d['raktar_keszlet'].' '.__('db raktáron').'.<br><span style="color:#ff9167;">'.($d['me']-$d['raktar_keszlet']).''.__('rendelhető').'.</span>'?></div>
									<?php endif; ?>
								</td>
								<td class="center">
								<?php if( $this->user ): ?>
									<? if( $d['discounted'] ): ?>
										<div><strike><?=Helper::cashFormat($d['prices']['old_each'])?> <?=$this->valuta?></strike></div>
										<div><strong><?=Helper::cashFormat($d['prices']['current_each'])?> <?=$this->valuta?></strong></div>
									<? else: ?>
									<span><?=Helper::cashFormat($d['prices']['current_each'])?> <?=$this->valuta?></span>
									<? endif; ?>
								<?php else: ?> 
									<div class="login-for-price"><?=__('Az Ár bejelentkezés után látható!')?></div>
								<?php endif; ?>
								</td>
								<td class="center">
								<?php if( $this->user ): ?>
									<? if( $d['discounted'] ): ?>
										<div><strike><?=Helper::cashFormat($d['prices']['old_sum'])?> <?=$this->valuta?></strike></div>
										<div><strong><?=Helper::cashFormat($d['prices']['current_sum'])?> <?=$this->valuta?></strong></div>
									<? else: ?>
									<strong><?=Helper::cashFormat($d['prices']['current_sum'])?> <?=$this->valuta?></strong>
									<? endif; ?>									
								<?php else: ?> 
									<div class="login-for-price"><?=__('Az Ár bejelentkezés után látható!')?></div>
								<?php endif; ?>
								</td>
								<td class="center action">
									<? if($this->gets['1'] == '' || $this->gets['1'] == '0'): ?>
									<span>
										<i class="fa fa-angle-up cart-adder asc" title="<?=__("Több")?>" onclick="Cart.addItem(<?=$d['termekID']?>)"></i>
										<i class="fa fa-angle-down cart-adder desc" title="<?=__("Kevesebb")?>" onclick="Cart.removeItem(<?=$d['termekID']?>)"></i>
									</span>
									<? endif; ?>
								</td>
							</tr>
							<? endforeach;
								$szallias_informacio = $this->szallitas[Helper::getFromArrByAssocVal($this->szallitas,'ID',$this->storedString['2']['atvetel'])];
								$szallitasiKoltseg = 0;
								//$szallitasiKoltseg 	= (int)$szallias_informacio['koltseg'];
								// Ingyenes szállítás, ha túlhalad az összeghatáron, amikortól már ingyenes a szállítás
								/*
								if( $szallias_informacio['osszeghatar'] != '0' && ($k['totalPrice']-$szuperakcios_termekek_ara) > (int) $szallias_informacio['osszeghatar'] ){
									$szallitasiKoltseg = 0;
								}
								*/
								//$kedvezmeny 		= ($this->user && $this->user['kedvezmeny'] > 0) ? (($k['totalPrice'] - $szuperakcios_termekek_ara) * (($this->user['kedvezmeny']/100))) : 0;
								$vegosszeg = $calc_final_total;


							// Végső ár kiszámolása
							//$calc_final_total = $k['totalPrice'] - $szuperakcios_termekek_ara;
							//$calc_final_total = ($calc_final_total -(($this->user['kedvezmeny']/100)*$calc_final_total)) + $szuperakcios_termekek_ara;
							?>
							<?php if( $this->user ): ?>
							<tr class="price-overview">
								<td class="nocell"></td>
								<td colspan="2" class="right"><?=__('Termékek ára')?></td>
								<td colspan="2" class="center">
									<strong><span class="ar"><?=($this->kosar['kedvezmeny'] > 0 && ($k['discount']['partner'] || $k['discount']['coupon'])) ? Helper::cashFormat($k['totalPrice_before_discount']) : Helper::cashFormat($k['totalPrice'])?></span> <?=$this->valuta?></strong>
								</td>
							</tr>
							<tr class="price-overview">
								<td class="nocell"></td>
								<td colspan="2" class="right"><?=__('Kedvezmény')?></td>
								<td colspan="2" class="center">
									<span class="a"><span class="ar"><?=($this->kosar['kedvezmeny']> 0)? '<span class="kedv">'.Helper::cashFormat($this->kosar['kedvezmeny']).' Ft</span>':'</span>&mdash;'?></span>
								</td>
							</tr>
							<?
								if($szallitasiKoltseg > 0){	$vegosszeg += $szallitasiKoltseg; }
								//if($kedvezmeny > 0){	$vegosszeg -= $kedvezmeny; }
							?>
							<tr class="price-overview final">
								<td class="nocell"></td>
								<td colspan="2" class="right"><?=__('Végösszeg')?></td>
								<td colspan="2" class="center finalpricetd">
									<strong><span class="a"><span style="font-size: 0.9rem !important;"><?=($this->user['data']['price_group_data']['groupkey'] == 'beszerzes_netto')?__('nettó'):(($this->settings['price_show_brutto'] == 0)?__('nettó'):__('bruttó'))?></span> <span class="ar"><?=Helper::cashFormat($vegosszeg)?></span> <span style="font-size: 0.9rem !important;"><?=$this->valuta?></span></span></strong>
									<input type="hidden" name="kedvezmeny" value="<?=($this->kosar['kedvezmeny'] > 0)?1:0?>" />
									<input type="hidden" name="szallitasi_koltseg" value="<?=$szallitasiKoltseg?>" />
								</td>
							</tr>
							<?php endif; ?>
							</div>
						</tbody>
						<?php else: ?>
						<tbody>
							<tr>
								<td colspan="5" class="center">
									<div class="empty-cart">
										<i class="fa fa-shopping-cart ico"></i>
										<br>
										<strong><?=__('Az Ön kosarában nincsenek temékek!')?></strong>
										<div><?=__('Böngésszen termékeink közül')?>.</div>
										<div class="searchform">
				              <form class="" action="/termekek/<?=($this->gets['0'] == 'termekek' && $this->gets['1'] != '')?$this->gets['1']:''?>" method="get">
				                <div class="wrapper">
				                  <div class="input">
				                    <input type="text" name="src" value="<?=$_GET['src']?>" placeholder="<?=__('TERMÉK NÉV / CIKKSZÁM')?>">
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
					</div>
	        <?php
					// Ha nincs elegendő termék készleten - értesítő
					if(count($k['items']) > 0): ?>
						<?php if ($k['unstocked_items'] && $k['unstocked_items']['total'] != 0): ?>
						<div class="alert alert-warning">
							<i class="fa fa-exclamation-triangle"></i> <?=__('A kosárban lévő termékeknél')?> <strong><?=$k['unstocked_items']['total']?> <?=__('db tétel nincs raktáron!</strong> Kérjük, vegye  figyelembe, hogy ezen tételeket hosszabb határidővel, gyártás / beszerzés után tudjuk teljesíteni.')?>
						</div>
						<?php endif; ?>
						<? if( $this->not_reached_min_price_text ): ?>
						<div class="not-enought-price-for-order"><?=$this->not_reached_min_price_text?></div>
						<? endif; ?>
					<?php endif; ?>

					<?php if ( $this->gets['1'] == '1' ): ?>
						<div class="order-stepper overview">
							<div class="head"><h2><i class="fa fa-shield"></i> <?=__('Adatvédelmi Tájékoztató és Szállítási feltételek elfogadása')?></h2></div>
							<div class="pre-before-order transport-info-div user-logged">
								<div class="wrapper">
									<div class="transport-info">
										<div class="group">
											<div class="g">
												<div class="gline">
													<div class="h"><?=__('Nettó 15.000 Ft végösszeg alatt')?>:</div>
													<div class=""><u><?=__('Vásárlóknak')?>:</u> <strong><?=__('+ nettó 2 000 Ft')?></strong> <?=__('utánvét költséggel')?>.</div>
													<div class=""><u><?=__('Szerződött partnerek esetében')?>:</u> <strong><?=__('+ nettó 1 200 Ft')?></strong>.</div>
												</div>
												<div class="gline">
													<div class="h"><?=__('Nettó 15.000 Ft végösszeg felett')?>:</div>
													<div class=""><?=__('A szállítási díj')?> <strong><?=__('INGYENES')?>!</strong></div>
												</div>
												<div class="gls"><strong><?=__('Rendelését a GLS szállítja ki!')?></strong></div>
											</div>
											<div class="g">
												<div class="aszflinks">
													<div class="h"><?=__('Kérjük, hogy figyelmesen olvassa át az alábbi tájékoztatókat')?>:</div>
													<div class=""><a target="_blank" href="/p/aszf">> <?=__('Általános Szerződési Feltételek')?></a></div>
													<div class=""><a target="_blank" href="/p/szallitas_feltetelek">> <?=__('Szállítási Feltételek')?></a></div>
													<div class=""><a target="_blank" href="/p/vasarlasi-feltetelek">> <?=__('Vásárlási Feltételek')?></a></div>
													<div class=""><a target="_blank" href="/p/adatvedelmi-tajekoztato">> <?=__('Adatvédelmi Tájékoztató')?></a></div>
												</div>
												<div class="check">
													<input type="checkbox" id="transferinfo_ok" name="transferinfo_ok"><label for="transferinfo_ok">* <?=__('Elolvastam az Általános Szerződési Feltételeket, Szállítási és Adatvédelmi Tájékoztatót!')?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
						<?php if ($this->canOrder): ?>
						<div class="order-stepper overview">
							<div class="pre-before-order finish-order user-logged">
								<div class="nextbutton center">
									<button type="submit" name="orderState" value="start"><?=__('Megrendelés leadása')?></button>
								</div>
							</div>
						</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( empty($this->gets['1']) ): ?>
						<div class="order-stepper">
								<?php if(!$this->user): ?>
								<div class="head">
									<h2><?=__('Bejelentkezés szükséges a vásárláshoz')?></h2>
								</div>
								<div class="pre-before-order user-not-logged">
									<div class="user">
										<div class="face">
											<div class="face-wrapper">
												<div class="it">?</div>
											</div>
										</div>
										<div class="login"><a href="/user/belepes?return=/<?=$this->gets['0']?>"><?=__('Bejelentkezés')?></a></div>
										<div class="sep"><?=__('vagy')?></div>
										<div class="register"><a href="/user/regisztracio?return=/<?=$this->gets['0']?>"><?=__('Fiók regisztráció')?></a></div>
									</div>
									<div class="nextbutton">
										<button type="submit" name="orderState" disabled="disabled" value="start"><?=__('Tovább a megrendeléshez')?></button>
									</div>
								</div>
								<?php else: ?>
									<?php if (count($k['items']) > 0): ?>
										<div class="head">
											<h2><?=__('Bejelentkezve a következő fiókkal')?></h2>
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
														<a href="/user/logout?safe=1&return=/<?=$this->gets['0']?>" class="logout"><?=__('Kijelentkezés')?> <i class="fa fa-sign-out"></i></a>
													</div>
												</div>
											</div>
											<div class="nextbutton">
												<button type="submit" name="orderState" value="start"><?=__('Tovább a megrendeléshez')?></button>
											</div>
										</div>
									<?php endif; ?>
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
