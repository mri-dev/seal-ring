<? $k = $this->kosar; ?>
<div class="cart page-width">
	<div class="row np" id="cart">
    <div class="col-sm-12">
    	<div class="responsive-view full-width">
    		<? if($this->gets['1'] != 'done'): ?>
	    	<form method="post" action="">
	            <div class="cartItems">
	            	<?
					$no_ppp_itemNum = 0;
						$szuperakcios_termekek_ara = 0;
					?>
					<div class="box">
						<div class="p10 cart-head">
							<? if( count($k['items']) > 0 ): ?>
							<div style="float:right;">
								<? if($this->gets['1'] == '' || $this->gets['1'] == '0'): ?>
									<a href="/kosar/?clear=1" class="clear-cart" title="Kosár ürítése">kosár üritése <i class="fa fa-trash-o"></i></a>
								<? endif; ?>
							</div>
							<? endif; ?>
							<h1>KOSÁR</h1>
						</div>
						<?=$this->msg?>
						<div class="divider"></div>
						<div class="right">
							<button class="btn btn-danger btn-sm mustReload" onclick="document.location.reload(true);">A kosár tartalma megváltozott. <strong>Kattintson</strong> a frissítéshez!</button>
						</div>
						<? if( count($k['items']) > 0 ): ?>
						<div class="mobile-table-container overflowed">
						<table class="table table-bordered">
							<thead>
								<tr class="item-header">
									<th class="center">Termék</th>
									<th  width="120" class="center">Me.</th>
									<th class="center" width="15%">Egységár</th>
									<th class="center" width="15%"><?=($this->user['data']['price_group_data']['groupkey'] == 'beszerzes_netto')?'Nettó ár':(($this->settings['price_show_brutto'] == 0)?'Nettó ár':'Bruttó ár')?></th>
									<th class="center"></th>
								</tr>
							</thead>
							<tbody>
								<? foreach($k['items'] as $d):
									if($d['szuper_akcios'] == 1){
										$szuperakcios_termekek_ara += $d['sum_ar'];
									}
									if($d['pickpackszallitas'] == 0) $no_ppp_itemNum++;
									if($d['elorendelheto'] == 1) $preOrder_item++;
								?>
								<tr class="item">
									<td class="main">
										<div class="img img-thb" onclick="document.location.href='<?=$d['url']?>'">
											<span class="helper"></span>
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
										<? if($this->gets['1'] == '' || $this->gets['1'] == '0'): ?>
										<span>
											<i class="fa fa-minus-square cart-adder desc" title="Kevesebb" onclick="Cart.removeItem(<?=$d['termekID']?>)"></i>
											<i class="fa fa-plus-square cart-adder asc" title="Több" onclick="Cart.addItem(<?=$d['termekID']?>)"></i>
										</span>
										<? endif; ?>
									</td>
								</tr>
								<? endforeach;
								// Végső ár kiszámolása
								$calc_final_total = $k['totalPrice'] - $szuperakcios_termekek_ara;
								//$calc_final_total = ($calc_final_total -(($this->user['kedvezmeny']/100)*$calc_final_total)) + $szuperakcios_termekek_ara;
								?>
								</div>
							</tbody>
						</table>
						<? if( $this->not_reached_min_price_text ): ?>
						<div class="not-enought-price-for-order"><?=$this->not_reached_min_price_text?></div>
						<? endif; ?>
						</div>
						<? else: ?>
							<div class="empty-cart">
								<i class="fa fa-shopping-cart ico"></i>
								<br>
								<strong>Az Ön kosarában nincsenek temékek!</strong>
								<div>Böngésszen termékeink közül.</div>
							</div>
						<? endif; ?>
	            </div>
	       	<? else: ?>
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
	            	<h1><i class="fa fa-check-circle"></i><br />Megrendelés elküldve</h1>
	                <h2>Köszönjük megrendelését!</h2>
	                <p>E-mail címére folyamatos tájékoztatást küldünk megrendelésének állapotáról.</p>

					<? if( $this->orderInfo['fizetesiModID'] == $this->settings['flagkey_pay_payu'] && $this->orderInfo['payu_fizetve'] == 0 ): ?>
						<br>
						<strong>Online bankkártyás fizetésindítása: </strong><br><br>
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
						<a href="<?=DOMAIN?>order/<?=$this->orderInfo['accessKey']?>" class="btn btn-pr">Megrendelés adatlapja <i class="fa fa-arrow-circle-right"></i></a>
					</div>
	            </div>
	        </div>
	       	<? endif; ?>
					<a name="step"></a>
	        <? if(count($k['items']) > 0): ?>
					<?php if ($k['unstocked_items'] && $k['unstocked_items']['total'] != 0): ?>
					<div class="alert alert-warning">
						<i class="fa fa-exclamation-triangle"></i> A kosárban lévő termékeknél <strong><?=$k['unstocked_items']['total']?> db tétel nincs raktáron!</strong> Kérjük, vegye  figyelembe, hogy ezen tételeket hosszabb határidővel, gyártás / beszerzés után tudjuk teljesíteni.
					</div>
					<?php endif; ?>
					<div class="nextOrded">
	            <div class="box">
	                <h2 class="title">Termékek megrendelése</h2>
	                <input type="hidden" name="no_ppp_itemNum" value="<?=$no_ppp_itemNum?>" />
	                <? if($this->gets['1'] != '' && $this->gets['1'] != '0'): ?>
	                	<div class="allStepView">
	                    	<ul>
	                   		  <li class="<?=((int)$this->gets['1'] == 1)?'active':(((int)$this->gets['1'] > 1)?'done':'')?> <?=(in_array(1,$this->orderMustFillStep) && $this->orderStep)?'want':''?>"><a href="/kosar/1"><span class="p1">Számlázási/Szállítási adatok</span></a></li>
	                          <li class="<?=((int)$this->gets['1'] == 2)?'active':(((int)$this->gets['1'] > 2)?'done':'')?> <?=(in_array(2,$this->orderMustFillStep) && $this->orderStep)?'want':''?>"><a href="/kosar/2"><span class="p2">Átvételi mód</span></a></li>
	                          <li class="<?=((int)$this->gets['1'] == 3)?'active':(((int)$this->gets['1'] > 3)?'done':'')?> <?=(in_array(3,$this->orderMustFillStep) && $this->orderStep)?'want':''?>"><a href="/kosar/3"><span class="p3">Fizetési mód</span></a></li>
	                          <li class="<?=((int)$this->gets['1'] == 4)?'active':(((int)$this->gets['1'] > 4)?'done':'')?> <?=(in_array(4,$this->orderMustFillStep) && $this->orderStep)?'want':''?>"><a href="/kosar/4"><span class="p4">Megrendelés leadása</span></a></li>
	                    	</ul>
	                    	<div class="clr"></div>
	                    </div>
	                <? endif; ?>
	                <!--ORDER STEP 0.-->
	                <div class="steps step0 <?=($this->gets['1'] == '0' || $this->gets['1'] == '')?'on':''?>">
									<?php if (false): ?>
	                <div class="row">
	                	<div class="col-sm-6">
	                		<div class="referer-code">
                      	 <label for="partnercode">Ajánló partnerkód</label>
                      	 <div>
                      	 	<div class="input-group">
                      	 		<input type="text" name="partner_code" id="partnercode" class="form-control" placeholder="partnerkód megadása" value="<?=$_COOKIE['partner_code']?>">
                      	 		<span class="input-group-btn">
                      	 			<button class="btn btn-sec" name="save_partner_code" value="1">frissít <i class="fa fa-refresh"></i></button>
                      	 		</span>
                      	 	</div>
                      	 	<div class="info-msg left"><em ><a href="<?=$this->settings['page_url']?>/casada_termek_0ft" target="_blank">Mi az a "partnerkód"?</a></em></div>
                      	 	<? if( $this->partner_referer ): ?>
                          	 	<? if( $this->partner_referer->isValid() ): ?>
                          	 	<div class="partner-box partner-valid">
                          	 		<div class="grid-layout">
                          	 			<div class="grid-row grid-row-80 vra-middle">
                          	 				<div class="ico"><i class="fa fa-check-circle"></i></div>
                          	 				<div class="title">Az Ön ajánló partnere:</div>
                          	 				<div class="partner"><strong><?=$this->partner_referer->getPartnerName()?></strong></div>
                          	 			</div>
                          	 			<div class="grid-row grid-row-20 vra-middle">
                            	 			<div class="msg">
                              	 			<div class="text">Ön kedvezményesen vásárolhat!</div>
                              	 		</div>
                            	 		</div>
                          	 		</div>
                          	 	</div>
                          	 	<? elseif( !is_null($this->partner_referer->code) ): ?>
                          	 	<div class="partner-box partner-<?=$this->partner_referer->error_type?>">
                          	 		<div class="ico"><i class="fa fa-times-circle"></i></div>
                          	 		<?=$this->partner_referer->error_msg?>
                          	 	</div>
                          		<? endif; ?>
                          	<? else: ?>
                      		<? endif; ?>
                      	 </div>
                      </div>
	                	</div>
	                </div>
									<?php endif; ?>

									<?php if(!$this->user): ?>
										<h3 class="offline-pretitle">A termékek megrendeléséhez bejelentkezés szükséges!</h3>
										<div class="logIn" style="min-width: 200px; max-width: 40%; margin: 15px auto;">
											<fieldset>
												<div>
														<a href="/user/regisztracio?return=<?=$_SERVER['REQUEST_URI']?>" class="reg">Nincs fiókom, regisztrálok</a>
														<a href="/user/belepes?return=<?=$_SERVER['REQUEST_URI']?>" class="login">Bejelentkezés</a>
												</div>
											</fieldset>
										</div>
									<?php endif; ?>

									<?php if($this->user): ?>
	                <br>
	                <div class="divider"></div>
	                <br>
	                <div class="row np">
	                    <div class="col-sm-6 col col1">
	                    	<? if(!$this->user): ?>
	                        <div class="offline">
	                        	<div class="p10">
	                            	<div class="head"><strong>Alapadatok megadása</strong></div>
	                            	<input type="text" class="form-control" name="nev" value="<?=($this->orderExc)?$_POST['nev']:$this->storedString['0']['nev']?>"  placeholder="Az Ön neve" />
	                                <? if($this->orderExc && in_array('nev',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
	                                <br />
	                                <input type="text" class="form-control" name="email" value="<?=($this->orderExc)?$_POST['email']:$this->storedString['0']['email']?>" placeholder="Az Ön e-mail címe" />
	                                <? if($this->orderExc && in_array('email',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
	                                <div class="regInfo">vagy jelentkezzen be <br> <i class="fa fa-angle-down"></i></div>
	                            </div>
	                        </div>
	                        <div class="logIn">
	                        		<fieldset>
                                <div>
                                    <a href="/user/regisztracio?return=<?=$_SERVER['REQUEST_URI']?>" class="reg">Nincs fiókom, regisztrálok</a>
                                    <a href="/user/belepes?return=<?=$_SERVER['REQUEST_URI']?>" class="login">Bejelentkezés</a>
                                </div>
	                            </fieldset>
															<?php if (false): ?>
																<div class="info-for-register">
		                            	<div><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
		                            	<strong>Regisztráljon és lépjen be vásárláshoz!</strong><br><br>
										Ajánlórendszerünknek köszönhetően akár ingyen is hozzájuthat termékeinkhez. <br>
										Regisztráljon, mielőtt vásárolna, és már első vásárlása után igénybe veheti ajánlórendszerünket. <br>
										<a href="<?=$this->settings['blog_url']?>/ajanlorendszer">részletek ></a>
		                            </div>
															<?php endif; ?>
	                        </div>
	                        <? else: ?>
	                       		<div class="online" align="center">
	                            	<div class="head orange">Bejelentkezve mint, <strong><?=$this->user['data']['nev']?></strong>!</div>
	                                <div class="p10">
	                                    <div class="head"><strong>Alapadatok</strong></div>
	                                    <input type="text" class="form-control" name="nev" value="<?=($this->orderExc)?$_POST['nev']:$this->user['data']['nev']?>" readonly="readonly"  placeholder="Az Ön neve" />
	                                    <? if($this->orderExc && in_array('nev',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
	                                    <br />
	                                    <input type="text" class="form-control" name="email" value="<?=($this->orderExc)?$_POST['email']:$this->user['data']['email']?>" readonly="readonly" placeholder="Az Ön e-mail címe" />
	                                    <? if($this->orderExc && in_array('email',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
	                                    <? if($this->user['data']['cash'] != 0): ?>
	                                    <div class="cash">
	                                   		<div class="head"><strong>Virtuális egyenleg felhasználás</strong></div>
	                                   		<div class="input-group">
	                                   			<span class="input-group-addon"><strong><?=Helper::cashFormat($this->user['data']['cash'])?></strong> &nbsp; /</span>
	                                   			<input type="number" name="virtual_cash"  class="form-control" min="0" value="<?=($this->orderExc) ? 0 : ( ($this->storedString['0']['virtual_cash']) ? $this->storedString['0']['virtual_cash'] : 0 )?>" max="<?=$this->user['data']['cash']?>">
	                                   			<span class="input-group-addon"> Ft</span>
	                                   			<span class="input-group-btn">
		                            	 			<button class="btn btn-sec" name="save_vr_cash" value="1">frissít <i class="fa fa-refresh"></i></button>
		                            	 		</span>
	                                   		</div>
	                                    </div>
	                                    <? endif; ?>
	                                </div>
	                                <? if( !empty($this->user['kedvezmenyek']) && false ): ?>
	                                <br>
	                                <div class="row np">
	                                    <div class="col-sm-12">
	                                        <div class="discount-info">
	                                            <div class="head">Kedvezmények vásárlásai után</div>
	                                            <div class="row np">
	                                            	<div class="col-sm-6 left">
	                                            		<div class="list">
			                                        		<? foreach( $this->user['kedvezmenyek'] as $kedv ): ?>
																										<div><?=$kedv['nev']?>: <span class="num"><?=$kedv['kedvezmeny']?>%</span> </div>
			                                        		<? endforeach; ?>
			                                        	</div>
	                                            	</div>
	                                            	<div class="col-sm-6 center">
	                                            		<strong>Az Ön kedvezménye:</strong>
			                                            <div class="dc-num"><?=$this->user['kedvezmeny']?>%</div>
	                                            	</div>
	                                            </div>

	                                        </div>
	                                    </div>
	                                </div>
	                                <? endif; ?>
	                            </div>
	                        <? endif; ?>
	                    </div>
	                    <div class="col-sm-6 col col2">
												<div class="coupon-code">
													<div class="head">Kuponkód használata</div>
													<div>
														<div class="input-group">
															<input type="text" id="cuponcode" name="coupon_code" class="form-control" placeholder="kuponkód" value="<?=$_COOKIE['coupon_code']?>">
															<span class="input-group-btn">
																<button class="btn btn-sec" name="save_coupon_code" value="1">frissít <i class="fa fa-refresh"></i></button>
															</span>
														</div>
														<? if( $this->coupon && $this->coupon->coupon_id ): ?>
																<? if( $this->coupon->isRunning() ): ?>
																<div class="partner-box partner-valid">
																	<div class="grid-layout">
																		<div class="grid-row grid-row-100 vra-middle">
																			<div class="ico"><i class="fa fa-check-circle"></i></div>
																			<div><strong>Kupon sikeresen aktiválva:</strong></div>
																			<div><?=$this->coupon->getTitle()?></div>
																		</div>
																	</div>
																</div>
																<? else: ?>

																<? if( !$this->coupon->isReachedPriceLimit() ): ?>
																<div class="partner-box partner-info">
																	<div class="ico"><i class="fa fa-info-circle"></i></div>
																	<div><strong><?=$this->coupon->coupon_id?> &mdash; minimális vásárlási limit:</strong></div>
																	<div><?=Helper::cashFormat($this->coupon->getMinOrderValue())?> <?=$this->valuta?></div>
																</div>
																<? endif; ?>

																<div class="partner-box partner-invalid">
																	<div class="ico"><i class="fa fa-times-circle"></i></div>
																	<div><strong><?=$this->coupon->coupon_id?> &mdash; állapot:</strong></div>
																	A megadott kuponkód jelenleg nem felhasználható.
																</div>
																<? endif; ?>

															<? else: ?>
														<? endif; ?>
													</div>
												</div>
	                    </div>
	                </div>
									<? endif; ?>

									<?php if($this->user): ?>
									<div class="stepzerostarter">
											<div class="cartInfo">
												<? $vcash = $this->storedString['0']['virtual_cash']; ?>

													<span class="tetel"><?=$k['itemNum']?> db tétel</span>
													<span class="totalPrice">
														<? if($this->kosar['kedvezmeny'] > 0 || (is_numeric($vcash) && $vcash != "0" && isset($vcash))): ?>
															<?
																if((is_numeric($vcash) && $vcash != "0" && isset($vcash))) {
																	$this->kosar['totalPrice_before_discount']= $this->kosar['totalPrice'];
																	$calc_final_total = $this->kosar['totalPrice'] - (int)$vcash;
																	$this->kosar['kedvezmeny'] = $vcash;
																}

															?>
															<span class="standardPrice">Eredeti ár: <strong><?=Helper::cashFormat($this->kosar['totalPrice_before_discount'])?> Ft</strong></span>
																<span class="kedvPrice">kedvezményesen <strong><?=Helper::cashFormat($calc_final_total)?> Ft</strong></span>
																<span class="discountPrice"><span>(-<?=Helper::cashFormat($this->kosar['kedvezmeny'])?> Ft)</span></span>
															<? else: ?>
																<?=($this->user['data']['price_group_data']['groupkey'] == 'beszerzes_netto')?'nettó':(($this->settings['price_show_brutto'] == 0)?'nettó':'bruttó')?>
																 <strong><?=Helper::cashFormat($calc_final_total)?></strong> Ft
															<? endif;?>
													</span>
											</div>
											<div class="megrendel">
													<button name="orderState" value="start"  type="submit" class="btn btn-success">Megrendelés folytatása <i class="fa fa-arrow-circle-right"></i></button>
											</div>
									</div>
									<?php endif; ?>

	            	</div>
	                <!--/ORDER STEP 0.-->
	                <!--ORDER STEP 1.-->
	                <div class="steps step1 <?=($this->gets['1'] == '1')?'on':''?>">
	                	<div class="row np">
											<div class="col-sm-6 col1">
														<div class="head">Számlázási adatok</div>
															<div class="p10 input-fields">
																<div class="row">
																	<div class="col-sm-8">
																			 <input type="text" class="form-control" name="szam_nev" value="<?=($this->orderExc)?$_POST['szam_nev']:(($this->storedString['1'])?$this->storedString['1']['szam_nev']:$this->user['szamlazasi_adat']['nev'])?>" placeholder="* Név" />
																			 <? if($this->orderExc && in_array('szam_nev',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																	<div class="col-sm-4">
																			 <input type="text" class="form-control" name="szam_adoszam" value="<?=($this->orderExc)?$_POST['szam_adoszam']:(($this->storedString['1'])?$this->storedString['1']['szam_adoszam']:$this->user['data']['company_adoszam'])?>" placeholder="Adószám" />
																			 <? if($this->orderExc && in_array('szam_adoszam',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-3">
																			 <input type="text" class="form-control" autocomplete="off" name="szam_irsz" value="<?=($this->orderExc)?$_POST['szam_irsz']:(($this->storedString['1'])?$this->storedString['1']['szam_irsz']:$this->user['szamlazasi_adat']['irsz'])?>" placeholder="* Irányítószám" ng-keyup="findCityByIrsz($event, 'szam_city')" />
																			 <? if($this->orderExc && in_array('szam_irsz',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																	<div class="col-sm-3">
																		<input type="text" class="form-control" name="szam_kerulet" autocomplete="new-password" value="<?=($this->orderExc)?$_POST['szam_kerulet']:(($this->storedString['1'])?$this->storedString['1']['szam_kerulet']:$this->user['szamlazasi_adat']['kerulet'])?>" placeholder="Kerület" />
																		<? if($this->orderExc && in_array('szam_kerulet',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																	<div class="col-sm-6 hint-holder-col">
																		<input type="text" readonly="readonly" class="form-control" name="szam_city" value="<?=($this->orderExc)?$_POST['szam_city']:(($this->storedString['1'])?$this->storedString['1']['szam_city']:$this->user['szamlazasi_adat']['city'])?>" placeholder="Város: adja meg az irányítószámot..." id="szam_city" />
																		<div class="hint-holder" ng-show="findedCity['szam_city'] && findedCity['szam_city'].length != 0" id="szam_city">
																			<div class="hint-list">
																				<div class="cityhint" ng-click="fillCityHint('szam_city', city)" ng-repeat="city in findedCity['szam_city']">{{city.varos}} <span ng-show="city.megye" class="megye">({{city.megye}} megye)</span></div>
																			</div>
																		</div>
																		<? if($this->orderExc && in_array('szam_city',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-6">
																		<input type="text" class="form-control" name="szam_kozterulet_nev" value="<?=($this->orderExc)?$_POST['szam_kozterulet_nev']:(($this->storedString['1'])?$this->storedString['1']['szam_kozterulet_nev']:$this->user['szamlazasi_adat']['kozterulet_nev'])?>" placeholder="* Közterület neve" />
																		<? if($this->orderExc && in_array('szam_kozterulet_nev',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																	<div class="col-sm-3">
																		<select name="szam_kozterulet_jelleg" class="form-control" id="szam_kozterulet_jelleg">
																				<option value="">* Közterület jellege</option>
																				<option value="" disabled="disabled"></option>
																				<? foreach( $this->kozterulet_jellege as $s ): ?>
																				<option value="<?=$s?>" <?=( ( $this->storedString['1']['szam_kozterulet_jelleg'] == $s ) || ( $this->orderExc && $_POST['szam_kozterulet_jelleg'] == $s) || ($this->user && $this->user['szamlazasi_adat']['kozterulet_jelleg'] == $s) ) ? 'selected="selected"' : ''?>><?=$s?></option>
																				<? endforeach; ?>
																			</select>
																	</div>
																	<div class="col-sm-3">
																		<input type="text" class="form-control" name="szam_hazszam" value="<?=($this->orderExc)?$_POST['szam_hazszam']:(($this->storedString['1'])?$this->storedString['1']['szam_hazszam']:$this->user['szamlazasi_adat']['hazszam'])?>" placeholder="* Házszám" />
																		<? if($this->orderExc && in_array('szam_hazszam',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-3">
																		<input type="text" class="form-control" name="szam_epulet" autocomplete="new-password" value="<?=($this->orderExc)?$_POST['szam_epulet']:(($this->storedString['1'])?$this->storedString['1']['szam_epulet']:$this->user['szamlazasi_adat']['epulet'])?>" placeholder="Épület" />
																		<? if($this->orderExc && in_array('szam_epulet',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																	<div class="col-sm-3">
																		<input type="text" class="form-control" name="szam_lepcsohaz" autocomplete="new-password" value="<?=($this->orderExc)?$_POST['szam_lepcsohaz']:(($this->storedString['1'])?$this->storedString['1']['szam_lepcsohaz']:$this->user['szamlazasi_adat']['lepcsohaz'])?>" placeholder="Lépcsőház" />
																		<? if($this->orderExc && in_array('szam_lepcsohaz',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																	<div class="col-sm-3">
																		<input type="text" class="form-control" name="szam_szint" value="<?=($this->orderExc)?$_POST['szam_szint']:(($this->storedString['1'])?$this->storedString['1']['szam_szint']:$this->user['szamlazasi_adat']['szint'])?>" placeholder="Szint" />
																		<? if($this->orderExc && in_array('szam_szint',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																	<div class="col-sm-3">
																		<input type="text" class="form-control" name="szam_ajto" value="<?=($this->orderExc)?$_POST['szam_ajto']:(($this->storedString['1'])?$this->storedString['1']['szam_ajto']:$this->user['szamlazasi_adat']['ajto'])?>" placeholder="Ajtó" />
																		<? if($this->orderExc && in_array('szam_ajto',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																	</div>
																</div>
																<div class="row">
																	 <div class="col-sm-12">
																		<input type="checkbox" id="sameOfSzam"/><label for="sameOfSzam">a szállítási adatokkal megegyezik</label>
																	</div>
																</div>
															</div>
													</div>
													<div class="col-sm-6 divCol left col2">
			                        	<div class="head">Szállítási adatok</div>
			                            <div class="p10 input-fields">
																		<div class="row">
			                            		<div class="col-sm-8">
		                                       <input type="text" class="form-control" name="szall_nev" value="<?=($this->orderExc)?$_POST['szall_nev']:(($this->storedString['1'])?$this->storedString['1']['szall_nev']:$this->user['szallitasi_adat']['nev'])?>" placeholder="* Név" />
		                                       <? if($this->orderExc && in_array('szall_nev',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
		                                  </div>
																			<div class="col-sm-4">
		                                       <input type="text" class="form-control" name="szall_adoszam" value="<?=($this->orderExc)?$_POST['szall_adoszam']:(($this->storedString['1'])?$this->storedString['1']['szall_adoszam']:$this->user['data']['company_adoszam'])?>" placeholder="Adószám" />
		                                       <? if($this->orderExc && in_array('szall_adoszam',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
		                                  </div>
			                            	</div>
																		<div class="row">
																			<div class="col-sm-3">
																					 <input type="text" class="form-control" autocomplete="off" name="szall_irsz" value="<?=($this->orderExc)?$_POST['szall_irsz']:(($this->storedString['1'])?$this->storedString['1']['szall_irsz']:$this->user['szallitasi_adat']['irsz'])?>" placeholder="* Irányítószám" ng-keyup="findCityByIrsz($event, 'szall_city')" />
																					 <? if($this->orderExc && in_array('szall_irsz',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																				<div class="col-sm-3">
																					<input type="text" class="form-control" name="szall_kerulet" autocomplete="new-password" value="<?=($this->orderExc)?$_POST['szall_kerulet']:(($this->storedString['1'])?$this->storedString['1']['szall_kerulet']:$this->user['szallitasi_adat']['kerulet'])?>" placeholder="Kerület" />
																					<? if($this->orderExc && in_array('szall_kerulet',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																				</div>
																			<div class="col-sm-6 hint-holder-col">
																				<input type="text" readonly="readonly" class="form-control" name="szall_city" value="<?=($this->orderExc)?$_POST['szall_city']:(($this->storedString['1'])?$this->storedString['1']['szall_city']:$this->user['szallitasi_adat']['city'])?>" placeholder="Város: adja meg az irányítószámot..." id="szall_city" />
																				<div class="hint-holder" ng-show="findedCity['szall_city'] && findedCity['szall_city'].length != 0" id="szall_city">
																					<div class="hint-list">
																						<div class="cityhint" ng-click="fillCityHint('szall_city', city)" ng-repeat="city in findedCity['szall_city']">{{city.varos}} <span ng-show="city.megye" class="megye">({{city.megye}} megye)</span></div>
																					</div>
																				</div>
																				<? if($this->orderExc && in_array('szall_city',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-sm-6">
																				<input type="text" class="form-control" name="szall_kozterulet_nev" value="<?=($this->orderExc)?$_POST['szall_kozterulet_nev']:(($this->storedString['1'])?$this->storedString['1']['szall_kozterulet_nev']:$this->user['szallitasi_adat']['kozterulet_nev'])?>" placeholder="* Közterület neve" />
																				<? if($this->orderExc && in_array('szall_kozterulet_nev',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																			<div class="col-sm-3">
																				<select name="szall_kozterulet_jelleg" class="form-control" id="szall_kozterulet_jelleg">
																						<option value="">* Közterület jellege</option>
																						<option value="" disabled="disabled"></option>
																						<? foreach( $this->kozterulet_jellege as $s ): ?>
																						<option value="<?=$s?>" <?=( ( $this->storedString['1']['szall_kozterulet_jelleg'] == $s ) || ( $this->orderExc && $_POST['szall_kozterulet_jelleg'] == $s) || ($this->user && $this->user['szallitasi_adat']['kozterulet_jelleg'] == $s) ) ? 'selected="selected"' : ''?>><?=$s?></option>
																						<? endforeach; ?>
																					</select>
																			</div>
																			<div class="col-sm-3">
																				<input type="text" class="form-control" name="szall_hazszam" value="<?=($this->orderExc)?$_POST['szall_hazszam']:(($this->storedString['1'])?$this->storedString['1']['szall_hazszam']:$this->user['szallitasi_adat']['hazszam'])?>" placeholder="* Házszám" />
																				<? if($this->orderExc && in_array('szall_hazszam',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-sm-3">
																				<input type="text" class="form-control" name="szall_epulet" autocomplete="new-password" value="<?=($this->orderExc)?$_POST['szall_epulet']:(($this->storedString['1'])?$this->storedString['1']['szall_epulet']:$this->user['szallitasi_adat']['epulet'])?>" placeholder="Épület" />
																				<? if($this->orderExc && in_array('szall_epulet',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																			<div class="col-sm-3">
																				<input type="text" class="form-control" name="szall_lepcsohaz" autocomplete="new-password" value="<?=($this->orderExc)?$_POST['szall_lepcsohaz']:(($this->storedString['1'])?$this->storedString['1']['szall_lepcsohaz']:$this->user['szallitasi_adat']['lepcsohaz'])?>" placeholder="Lépcsőház" />
																				<? if($this->orderExc && in_array('szall_lepcsohaz',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																			<div class="col-sm-3">
																				<input type="text" class="form-control" name="szall_szint" value="<?=($this->orderExc)?$_POST['szall_szint']:(($this->storedString['1'])?$this->storedString['1']['szall_szint']:$this->user['szallitasi_adat']['szint'])?>" placeholder="Szint" />
																				<? if($this->orderExc && in_array('szall_szint',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																			<div class="col-sm-3">
																				<input type="text" class="form-control" name="szall_ajto" value="<?=($this->orderExc)?$_POST['szall_ajto']:(($this->storedString['1'])?$this->storedString['1']['szall_ajto']:$this->user['szallitasi_adat']['ajto'])?>" placeholder="Ajtó" />
																				<? if($this->orderExc && in_array('szam_ajto',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<input type="text" class="form-control" name="szall_phone" value="<?=($this->orderExc)?$_POST['szall_phone']:(($this->storedString['1'])?$this->storedString['1']['szall_phone']:$this->user['szallitasi_adat']['phone'])?>" placeholder="* Telefonszám" />
																				<? if($this->orderExc && in_array('szall_phone',$this->orderExc['input'])): ?><span class="errMsg">Kérjük, töltse ki ezt a mezőt!</span><? endif; ?>
																			</div>
																		</div>
			                            </div>
			                            <div class="clr"></div>
			                        </div>
	                    </div>
	                    <div class="clr"></div>
	                </div>
	                <!--/ORDER STEP 1.-->
	                <!--ORDER STEP 2.-->
	                <div class="steps step2 <?=($this->gets['1'] == '2')?'on':''?>" style="padding:0;">
	                	<div class="row np">
	                    	<div class="col-sm-12">
	                        	<ul class="atvetel">
	                            	<? foreach($this->szallitas as $d): ?>
	                        		<li><input <?=($this->storedString['2']['atvetel'] == $d['ID'])?'checked':''?> id="atvet_<?=$d['ID']?>" type="radio" name="atvetel" value="<?=$d['ID']?>" <?=($d['ID'] == 2 && $no_ppp_itemNum != 0)?'disabled':''?>/><label for="atvet_<?=$d['ID']?>"><?=$d['nev']?> <em><?=Product::transTime($d['ID'])?></em><? if($d['ID'] == 2 && $no_ppp_itemNum != 0): ?><br /><span class="subtitle"><?=$no_ppp_itemNum?> db termék nem szállítható Pick Pack Pontra</span><? endif; ?></label>
	                                <?
	                                // PICK PACK PONT ÁTVÉTEL FORM
	                                if( $d['ID'] == $this->settings['flagkey_pickpacktransfer_id'] ): ?>
	                                <div class="pickpackpont" style="display:none;">
	                                	<input type="hidden" id="ppp_uzlet" name="ppp_uzlet" value="<?=$this->storedString['2']['ppp_uzlet']?>">
	                                	<input type="hidden" id="ppp_uzlet_str" name="ppp_uzlet_n" value="<?=$this->storedString['2']['ppp_uzlet_n']?>">
	                                	<iframe width="100%" height="504px" src="http://online.sprinter.hu/terkep/#/"></iframe>
	                                </div>
	                                <? endif;?>
	                                <?
	                                // PostaPont átvétel FORM
	                                if( $d['ID'] == '5' ):?>
	                                <div class="postapont" style="display:none;">
	                                	<input type="hidden" id="ugyfelform_iranyitoszam" value="<?=($this->orderExc)?$_POST['szall_irsz']:(($this->storedString['1'])?$this->storedString['1']['szall_irsz']:$this->user['szallitasi_adat']['irsz'])?>">
	                                	<input type="hidden" id="valasztott_postapont" name="pp_selected" value="">
	                                	<!-- Postapont választó (Ügyfél oldalra beépítendő rész) -->
										<div id="postapontvalasztoapi"></div>
										<div class="clr"></div>
										<script type="text/javascript">
											ppapi.setMarkers('20_molkut', false);
											ppapi.setMarkers('30_csomagautomata', false);
											ppapi.linkZipField('ugyfelform_iranyitoszam'); //<-- A megrendelő form input elemének a megjelölése (beállítása a kiválasztó számára)
											ppapi.insertMap('postapontvalasztoapi'); //<-- PostaPont választó API beillesztése ( ilyen azonosítóval rendelkező DOM objektumba)
											ppapi.onSelect = function(data){ //<-- Postapont kiválasztásra bekövetkező esemény lekötése
												// Minta! A kiválasztott PostaPont adatainak visszaírása a megrendelő form rejtett mezőjébe.
												$('#valasztott_postapont').val( data['name']+" ("+data['zip'] + " " + data['county']+", "+data['address']+")" );
												$('#selected_pp_data_info').html( data['name']+" ("+data['zip'] + " " + data['county']+", "+data['address']+")" )
												console.log(jQuery.param(data));
											};
										</script>
										<div id="pp-data-info">Kiválasztott PostaPont: <span id="selected_pp_data_info">nincs kiválasztva!</span></div>
										<!-- E:Postapont választó -->
	                                </div>
	                            	<? endif; ?>
	                                </li>
	                                <? endforeach; ?>
	                        	</ul>
	                        </div>
	                    </div>
	                </div>
	                <!--/ORDER STEP 2.-->
	                <!--ORDER STEP 3.-->
	                <div class="steps step3 <?=($this->gets['1'] == '3')?'on':''?>" style="padding:0;">
	                	<div class="row np">
	                    	<div class="col-sm-12">
	                        	<ul class="atvetel">
	                            <? foreach($this->fizetes as $d): ?>
	                            	<? if( $d['ID'] == $this->settings['flagkey_pay_cetelem'] && ($calc_final_total < $this->settings['cetelem_min_product_price'] || $calc_final_total > $this->settings['cetelem_max_product_price']) ) {continue;} ?>
																<?php if ( $d['ID'] == $this->settings['flagkey_pay_cetelem'] && $k['excludes_from_cetelem']['total'] !== 0): continue; endif; ?>
	                            	<? if(in_array($this->storedString['2']['atvetel'],$d['in_szallitas_mod'])): ?>
	                        		<li>
	                        			<input <?=($this->storedString['3']['fizetes'] == $d['ID'])?'checked':''?> id="fizetes_<?=$d['ID']?>" type="radio" name="fizetes" value="<?=$d['ID']?>"/>
	                        			<label for="fizetes_<?=$d['ID']?>"><?=$d['nev']?> <? if($d['ID'] == $this->settings['flagkey_pay_payu']): ?> <a href="http://simplepartner.hu/PaymentService/Fizetesi_tajekoztato.pdf" target="_blank">
										<img style="height: 20px;" src="<?=IMG?>bankcard_logo_with_simple_logo_482x40.png" title="Simple - Online bankkártyás fizetés" alt="Simple vásárlói tájékoztató"></a> <? endif; ?></label>
	                        		</li>
	                                <? endif; ?>

	                           	<? endforeach; ?>
	                            </ul>
	                        </div>
	                    </div>
	                </div>
	                <!--/ORDER STEP 3.-->
	                <!--ORDER STEP 4.-->
	                <div class="steps step4 <?=($this->gets['1'] == '4')?'on':''?>">
	                	<?
	                		$szallias_informacio = $this->szallitas[Helper::getFromArrByAssocVal($this->szallitas,'ID',$this->storedString['2']['atvetel'])];

	                		$szallitasiKoltseg 	= (int)$szallias_informacio['koltseg'];

	                		// Ingyenes szállítás, ha túlhalad az összeghatáron, amikortól már ingyenes a szállítás
	                		if( $szallias_informacio['osszeghatar'] != '0' && ($k['totalPrice']-$szuperakcios_termekek_ara) > (int) $szallias_informacio['osszeghatar'] ){
	                			$szallitasiKoltseg = 0;
	                		}

											$kedvezmeny 		= ($this->user && $this->user['kedvezmeny'] > 0) ? (($k['totalPrice'] - $szuperakcios_termekek_ara) * (($this->user['kedvezmeny']/100))) : 0;
											$vegosszeg 			= $calc_final_total;

										?>
	                	<div class="row np" style="margin-top:5px;">
	                    	<div class="col-sm-6 col1">
													<div class="head"><h4>Számlázási adatok</h4></div>
														<? if($this->orderExc && in_array(1,$this->orderMustFillStep)): ?>
															<div align="center" class="p10"><span class="mustSelect"><i class="fa fa-warning"></i> Figyelem! Hiányoznak a számlázási adatok. Kérjük pótolja!</span></div>
														<? else: ?>
														<div class="order-contact-info">
															<div class="row np">
																	<div class="col-sm-5">
																			<strong>Név</strong>
																		</div>
																		<div class="col-sm-7 right">
																			<?=$this->storedString['1']['szam_nev']?>
																		</div>
																</div>
																<?php if ( $this->storedString['1']['szam_adoszam'] != '' ): ?>
																<div class="row np">
																		<div class="col-sm-5">
																				<strong>Adószám</strong>
																			</div>
																			<div class="col-sm-7 right">
																				<?=$this->storedString['1']['szam_adoszam']?>
																			</div>
																	</div>
																<?php endif; ?>
																<?php if ( $this->storedString['1']['szam_kerulet'] != '' ): ?>
																<div class="row np">
																	<div class="col-sm-5">
																			<strong>Kerület</strong>
																		</div>
																		<div class="col-sm-7 right">
																			<?=$this->storedString['1']['szam_kerulet']?>
																		</div>
																</div>
																<?php endif; ?>
																<div class="row np">
																	<div class="col-sm-5">
																			<strong>Település</strong>
																		</div>
																		<div class="col-sm-7 right">
																			<?=$this->storedString['1']['szam_irsz']?> <?=$this->storedString['1']['szam_city']?>
																		</div>
																</div>
																<div class="row np">
																	<div class="col-sm-7">
																		<strong>Cím</strong> <br>
																		<em>(közterület neve, közterület jellege, házszám)</em>
																	</div>
																	<div class="col-sm-5 right">
																		<?=$this->storedString['1']['szam_kozterulet_nev']?> <?=$this->storedString['1']['szam_kozterulet_jelleg']?> <?=$this->storedString['1']['szam_hazszam']?>
																	</div>
																</div>
																<?php if ( $this->storedString['1']['szam_epulet'] != '' ): ?>
																<div class="row np">
																	<div class="col-sm-5">
																			<strong>Épület</strong>
																		</div>
																		<div class="col-sm-7 right">
																			<?=$this->storedString['1']['szam_epulet']?>
																		</div>
																</div>
																<?php endif; ?>
																<?php if ( $this->storedString['1']['szam_emelet'] != '' ): ?>
																<div class="row np">
																	<div class="col-sm-5">
																			<strong>Emelet</strong>
																		</div>
																		<div class="col-sm-7 right">
																			<?=$this->storedString['1']['szam_emelet']?>
																		</div>
																</div>
																<?php endif; ?>
																<?php if ( $this->storedString['1']['szam_ajto'] != '' ): ?>
																<div class="row np">
																	<div class="col-sm-5">
																			<strong>Ajtó</strong>
																		</div>
																		<div class="col-sm-7 right">
																			<?=$this->storedString['1']['szam_ajto']?>
																		</div>
																</div>
																<?php endif; ?>
	                            </div>
	                            <? endif; ?>
	                        </div>
	                        <div class="col-sm-6 col2" style="border-left:1px solid #ddd;">
														<div class="head"><h4>Szállítási adatok</h4></div>
															 <? if($this->orderExc && in_array(1,$this->orderMustFillStep)): ?>
																<div align="center" class="p10"><span class="mustSelect"><i class="fa fa-warning"></i> Figyelem! Hiányoznak a szállítási adatok. Kérjük pótolja!</span></div>
															<? else: ?>
															<div class="order-contact-info">
																<div class="row np">
																		<div class="col-sm-5">
																				<strong>Név</strong>
																			</div>
																			<div class="col-sm-7 right">
																				<?=$this->storedString['1']['szall_nev']?>
																			</div>
																	</div>
																	<?php if ( $this->storedString['1']['szall_adoszam'] != '' ): ?>
																	<div class="row np">
																			<div class="col-sm-5">
																					<strong>Adószám</strong>
																				</div>
																				<div class="col-sm-7 right">
																					<?=$this->storedString['1']['szall_adoszam']?>
																				</div>
																		</div>
																	<?php endif; ?>
																	<?php if ( $this->storedString['1']['szall_kerulet'] != '' ): ?>
																	<div class="row np">
																		<div class="col-sm-5">
																				<strong>Kerület</strong>
																			</div>
																			<div class="col-sm-7 right">
																				<?=$this->storedString['1']['szall_kerulet']?>
																			</div>
																	</div>
																	<?php endif; ?>
																	<div class="row np">
																		<div class="col-sm-5">
																				<strong>Település</strong>
																			</div>
																			<div class="col-sm-7 right">
																				<?=$this->storedString['1']['szall_irsz']?> <?=$this->storedString['1']['szall_city']?>
																			</div>
																	</div>
																	<div class="row np">
																		<div class="col-sm-7">
																			<strong>Cím</strong> <br>
																			<em>(közterület neve, közterület jellege, házszám)</em>
																		</div>
																		<div class="col-sm-5 right">
																			<?=$this->storedString['1']['szall_kozterulet_nev']?> <?=$this->storedString['1']['szall_kozterulet_jelleg']?> <?=$this->storedString['1']['szall_hazszam']?>
																		</div>
																	</div>
																	<?php if ( $this->storedString['1']['szall_epulet'] != '' ): ?>
																	<div class="row np">
																		<div class="col-sm-5">
																				<strong>Épület</strong>
																			</div>
																			<div class="col-sm-7 right">
																				<?=$this->storedString['1']['szall_epulet']?>
																			</div>
																	</div>
																	<?php endif; ?>
																	<?php if ( $this->storedString['1']['szall_emelet'] != '' ): ?>
																	<div class="row np">
																		<div class="col-sm-5">
																				<strong>Emelet</strong>
																			</div>
																			<div class="col-sm-7 right">
																				<?=$this->storedString['1']['szall_emelet']?>
																			</div>
																	</div>
																	<?php endif; ?>
																	<?php if ( $this->storedString['1']['szall_ajto'] != '' ): ?>
																	<div class="row np">
																		<div class="col-sm-5">
																				<strong>Ajtó</strong>
																			</div>
																			<div class="col-sm-7 right">
																				<?=$this->storedString['1']['szall_ajto']?>
																			</div>
																	</div>
																	<?php endif; ?>
	                            </div>
	                            <? endif; ?>
	                        </div>
	                    </div>
	                    <div class="row np topDiv">
	                    	<div class="col-sm-12">
	                        	<div class="p10">
	                            	<h4>Átvétel módja</h4>
	                                <div>
	                                	<? if($this->orderExc && in_array(2,$this->orderMustFillStep)): ?>
	                                    <span class="mustSelect"><i class="fa fa-warning"></i> Figyelem! Hiányzik az <strong>átvételi mód</strong>. Kérjük, hogy válassza ki az Önnek megfelelőt!</span>
	                                    <? endif; ?>

	                                    <?=$this->szallitas[Helper::getFromArrByAssocVal($this->szallitas,'ID',$this->storedString['2']['atvetel'])]['nev']; ?>  <em><?=Product::transTime($this->storedString['2']['atvetel'])?></em>
	                                    <? // PostaPont info
	                                    if($this->storedString['2']['atvetel'] == '5'): ?>
	                                    <a href="/p/postapont" title="Részletek" target="_blank"><i class="fa fa-info-circle "></i></a>
	                                	<? endif; ?>
	                                	 <? // PickPackPont info
	                                    if($this->storedString['2']['atvetel'] == '2'): ?>
	                                    <a href="/p/pick_pack_pont" title="Részletek" target="_blank"><i class="fa fa-info-circle "></i></a>
	                                	<? endif; ?>
	                                	 <? // Házhoz szállítás info
	                                    if($this->storedString['2']['atvetel'] == '1'): ?>
	                                    <a href="/p/szallitasi_feltetelek"  title="Részletek" target="_blank"><i class="fa fa-info-circle "></i></a>
	                                	<? endif; ?>

	                                    <?
	                                    // PickPackPont átvétel
	                                    if($this->storedString['2']['atvetel'] == $this->settings['flagkey_pickpacktransfer_id']): ?>

	                                        <? if($this->storedString['2']['ppp_uzlet_n'] != ''): ?>
	                                        <input type="hidden" name="ppp_uzlet_done" value="<?=$this->storedString['2']['ppp_uzlet_n']?>" />
	                                        <input type="hidden" name="ppp_uzlet_str" value="<?=$this->storedString['2']['ppp_uzlet_n']?>" />
	                                    	<div class="showSelectedPickPackPont">
	                                        	<div class="head">Kiválasztott <strong>Pick Pack</strong> átvételi pont:</div>
	                                           	<div class="">Kiválasztott átvételi pont: <strong><?=$this->storedString['2']['ppp_uzlet_n']?></strong></div>
	                                        </div>
	                                        <? else: ?>
	                                        	<div class="mustSelect"><i class="fa fa-warning"></i> Figyelem! Nincs kiválasztva a <string>Pick Pack átvételi Pont</string>. <a href="/kosar/2">Kérjük, hogy válassza ki!</a></div>
	                                        <? endif; ?>
	                                    <? endif; ?>

	                                    <?
	                                    // PostaPont átvétel
	                                    if($this->storedString['2']['atvetel'] == '5'): ?>
	                                    	<br>
	                                    	<img src="<?=IMG?>/icons/postapont_logos_big.png" alt="PostaPont" width="150">
	                                    	<br /><br />
	                                        <? if($this->storedString['2']['pp_selected'] != ''): ?>
	                                        <input type="hidden" name="pp_selected_point" value="<?=$this->storedString['2']['pp_selected']?>" />

	                                    	<div class="showSelectedPostaPont">
	                                        	<div class="head">Kiválasztott <strong>PostaPont</strong>:</div>
	                                            <div class="p5">
	                                            	<div class="row np">
	                                                    <div class="col-sm-12 left">
	                                                    	<?=$this->storedString['2']['pp_selected']?>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <? else: ?>
	                                        	<span class="mustSelect"><i class="fa fa-warning"></i> Figyelem! Nincs kiválasztva a <string>PostaPont</string> átvételi pont. Kérjük, hogy válassza ki!</span>
	                                        <? endif; ?>
	                                    <? endif; ?>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row np topDiv">
	                    	<div class="col-sm-12">
	                        	<div class="p10">
	                            	<h4>Fizetés módja</h4>
	                                <div>
	                                	<? if($this->orderExc && in_array(3,$this->orderMustFillStep)): ?>
	                                    <span class="mustSelect"><i class="fa fa-warning"></i> Figyelem! Hiányzik a <strong>fizetési mód</strong>. Kérjük, hogy válassza ki az Önnek megfelelőt!</span>
	                                    <? endif; ?>
	                                	 <?=$this->fizetes[Helper::getFromArrByAssocVal($this->fizetes,'ID',$this->storedString['3']['fizetes'])]['nev']; ?>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <?
                        // Cash - egyenleg
                        if($this->storedString['0']['virtual_cash'] != 0):
                        ?>

						<div class="row np topDiv">
	                    	<div class="col-sm-12">
	                        	<div class="p10">
	                            	<h4>Felhasznált virtuális egyenleg</h4>
	                                <div>
	                                	<strong><?=$this->storedString['0']['virtual_cash']?> Ft</strong>-ot felhasznál virtuális egyenlegéből ennél a vásárlásnál kedvezményként levonva!
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                	<? endif;?>

	                    <? if( $this->partner_referer && $this->partner_referer->isValid() ): ?>
											<div class="row np topDiv">
	                    	<div class="col-sm-12">
	                        	<div class="p10">
	                            	<h4>Ajánló partner</h4>
	                                <div>
	                                	<strong><?=$this->partner_referer->getPartnerName()?></strong> <em>(<?=$this->partner_referer->getPartnerCode()?>)</em>
	                                	<input type="hidden" name="referer_partner_id" value="<?=$this->partner_referer->getPartnerCode()?>">
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <? endif; ?>

	                    <? if( $this->coupon && $this->coupon->isRunning() ): ?>
											<div class="row np topDiv">
	                    	<div class="col-sm-12">
	                        	<div class="p10">
	                            	<h4>Felhasznált kupon</h4>
	                                <div>
	                                	<strong><?=$this->coupon->getTitle()?></strong> <em>(<?=$this->coupon->getCode()?>)</em>
	                                	<input type="hidden" name="coupon_id" value="<?=$this->coupon->getCode()?>">
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <? endif; ?>


											<div class="row np topDiv">
	                    	<div class="col-sm-12">
	                        	<div class="p10">
	                            	<h4>Megjegyzés a megrendeléshez</h4>
	                                <div>
	                                	<textarea name="comment" placeholder="" class="form-control"></textarea>
	                                </div>
	                            </div>
	                        </div>
	                    </div>

	                    <? if( $k['has_request_price'] > 0 ): ?>
	                    <div class="has-requested-price">
				        	<i class="fa fa-exclamation-triangle"></i>
				        	<h4>FIGYELEM!</h4>
				        	<div>A "Termékek ára", "Szállítási költség" és a "Kedvezmény összege" adat nem mérvadó, csak tájékoztató jellegű, mivel megrendelt termékei közt van olyan termék, ahol <a href="/kapcsolat" target="_blank">érdeklődni</a> kell a vételár felől!</div>
				        </div>
				    	<? endif; ?>
	                    <div class="row np">
												<div class="col-sm-4">
													<div class="row np topDiv">
			                    	<div class="col-sm-12">
			                        	<div class="p10 transport-info-div">
			                            	<h4><i class="fa fa-truck"></i> Szállítási információk</h4>
		                                <div class="transport-info">
		                                	<div class="gls"><strong>Rendelését a GLS szállítja ki!</strong></div>
																			<ul>
																				<li>
																					<div class="h">Bruttó 10.000 Ft végösszeg alatt:</div>
																					<strong>+ 2.000 Ft + ÁFA</strong> utánvét költséggel.<br>
																					<em>Szerződött partnerek esetében: <strong>+1.200 Ft + ÁFA.</strong></em>
																				</li>
																				<li><div class="h">Bruttó 10.000 Ft végösszeg felett: <strong>Ingyenes!</strong></div></li>
																			</ul>
																			<div class="check">
																				<input type="checkbox" id="transferinfo_ok" name="transferinfo_ok"><label for="transferinfo_ok">* Elfogadom a szállítási feltételeket!</label>
																			</div>
		                                </div>
			                            </div>
			                        </div>
			                    </div>
												</div>
	                    	<div class="col-sm-8" style="padding-left: 25px;">
	                       		<div class="p10 price">
	                            	<div class="p inf">
	                                	<span class="n">Termékek ára:</span>
	                                    <span class="a"><span class="ar"><?=($this->kosar['kedvezmeny'] > 0 && ($k['discount']['partner'] || $k['discount']['coupon'])) ? Helper::cashFormat($k['totalPrice_before_discount']) : Helper::cashFormat($k['totalPrice'])?></span> Ft</span>
	                                </div>
	                                <? if( true ): ?>
	                                <div class="p inf">
	                                	<span class="n">Kedvezmény:</span>
	                                    <span class="a"><span class="ar"><?=($this->kosar['kedvezmeny']> 0)? '<span class="kedv">'.Helper::cashFormat($this->kosar['kedvezmeny']).' Ft</span>':'</span>&mdash;'?></span>
	                                </div>
	                           		<? endif; ?>
	                           		<? if( $this->user['data']['user_group'] == \PortalManager\Users::USERGROUP_RESELLER && false): ?>
	                                <div class="p inf">
	                                	<span class="n">Kedvezmény:</span>
	                                    <span class="a"><span class="ar"><?=($this->user['kedvezmeny']> 0)? '<span class="kedv">'.$this->user['kedvezmeny'].'%</span>':'</span>&mdash;'?></span>
	                                </div>
	                           		<? endif; ?>
																<?php if (false): ?>
                            		<div class="p">
                                	<span class="n">Szállítási költség:</span>
                                    <span class="a"><span class="ar"><?=($szallitasiKoltseg > 0)?'+'.Helper::cashFormat($szallitasiKoltseg):'0'?></span> Ft</span>
                                </div>
																<?php endif; ?>
	                                <div class="p end">
	                                	<?
	                                    	if($szallitasiKoltseg > 0){	$vegosszeg += $szallitasiKoltseg; }
											//if($kedvezmeny > 0){	$vegosszeg -= $kedvezmeny; }
										?>
	                                	<span class="n">Végösszeg:</span>
	                                    <span class="a"><?=($this->user['data']['price_group_data']['groupkey'] == 'beszerzes_netto')?'nettó':(($this->settings['price_show_brutto'] == 0)?'nettó':'bruttó')?> <span class="ar"><?=Helper::cashFormat($vegosszeg)?></span> Ft</span>
	                                    <input type="hidden" name="kedvezmeny" value="<?=($this->kosar['kedvezmeny'] > 0)?1:0?>" />
	                                    <input type="hidden" name="szallitasi_koltseg" value="<?=$szallitasiKoltseg?>" />
	                               	</div>
	                            </div>
	                        </div>
	                        <div class="col-sm-12">
	                        	<div class="divider"></div>
	                        	<br>
                       			<? if( false ): ?>
                       			<div class="left"><input type="checkbox" checked="checked" id="subscribe" name="subscribe" /><label for="subscribe">Felirakozok hírlevélre!</label></div>
                       			<? endif; ?>
                             	<div class="left"><input type="checkbox" id="aszf_ok" name="aszf_ok"><label for="aszf_ok">* Megrendelésemmel elfogadom a(z) <?=$this->settings['page_title']?> mindenkor hatályos <a href="<?=$this->settings['ASZF_URL']?>" target="_blank">Általános Szerződési Feltételek</a>et!</label></div>
	                        </div>
	                    </div>
	                </div>
	                <!--/ORDER STEP 4.-->
	                <div class="orderFooter">
	                	<? if($this->gets['1'] != '' && $this->gets['1'] != '0'): ?>
	                    <? if($this->gets['1'] < 4): ?>
	                	<a href="/kosar/<?=((int)$this->gets['1'] - 1)?>" class="btn-back"><i class="fa fa-arrow-circle-left"></i> Vissza</a>
	                	<button name="orderState" value="next" class="btn-next">Tovább <i class="fa fa-arrow-circle-right"></i></button>
	                    <? else: ?>
	                    	<a href="/kosar/<?=((int)$this->gets['1'] - 1)?>" class="btn-back"><i class="fa fa-arrow-circle-left"></i> Vissza</a>
	                        <? if($this->canOrder): ?>
	                        <input type="hidden" name="orderUserID" value="<?=$this->user['data']['ID']?>" />
	                    		<button name="orderState" ng-show="order_accepted" value="end" class="btn-order">MEGRENDELÉS LEADÁSA <i class="fa fa-arrow-circle-right"></i></button>
	                        <? endif; ?>
	                    <? endif;?>
	                  <? endif;?>
	                </div>
	            </div>
	            <div class="clr"></div>
	        </div>

	        <?php if ($this->gets['1'] == '3' && false ): ?>
	        <div class="cetelemcalc" style="">
            	<div class="head">
            		Nincs meg a teljes vételár?<br>
            		<em>Igényeljen áruhitelt! Számolja ki, hogy mennyibe kerülne Önnek.</em>
            	</div>
            	<div class="con">
	            	<div class="row">
	            		<div class="col-sm-12 center">
	            			<h2>Cetelem hitelkalkulátor</h2>
	            			Válassza a fenti fizetési lehetőségek közül a Cetelem Online Áruhitel lehetőséget.
	            		</div>
	            	</div>
	            	<br>
            		<div class="row">
            			<div class="col-sm-6">
										<?php if ($k['excludes_from_cetelem']['total'] !== 0): ?>
											<div class="no-accept-items center">
												<div class="head">
													<?php echo $k['excludes_from_cetelem']['total']; ?> DB TERMÉKRE A KOSÁRBAN <br>
													NEM IGÉNYELHETŐ CETELEM ONLINE ÁRUHITELRE!
												</div>
												<div class="ci">
													Amennyiben szeretne áruhitelt igénybe venni, vegye ki a kosárból azokat a termékeket, amik nem igényelhetőek Cetelem online áruhitelre:<br>
													<?php if($k['excludes_from_cetelem']['items']) foreach ($k['excludes_from_cetelem']['items'] as $cet): ?>
														<div class="ceexc">
															-> <?=$cet['termekNev']?>
														</div>
													<?php endforeach; ?>
													<div class="wo">(Ha a fenti termékekre is igényt tart, kérjük, hogy külön megrendelésként adja le!)</div>
												</div>
											</div>
										<?php elseif( ($calc_final_total < $this->settings['cetelem_min_product_price'] || $calc_final_total > $this->settings['cetelem_max_product_price']) ): ?>
											<div class="no-accept-items center">
												<div class="head">
													CETELEM ÁRUHITELT MINIMUM <BR>
													<?php echo Helper::cashFormat($this->settings['cetelem_min_product_price']); ?> FT ÉRTÉK FELETT IGÉNYELHET!
												</div>
												<div class="ci">
													A megrendelésének értéke <h3 class="minprice"><?php echo  Helper::cashFormat($this->settings['cetelem_min_product_price']); ?> - <?php echo  Helper::cashFormat($this->settings['cetelem_max_product_price']); ?> Forint</h3> értékűnek kell lennie, hogy igénybe tudja venni a Cetelem online áruhitelt.
												</div>
											</div>
										<?php else: ?>
											<script type="text/javascript">
                          var calc = new Cetelem.Ecommerce.Calculator({
                          'shopCode': '<?=$this->settings['cetelem_shopcode']?>',
                          'barem': '<?=$this->settings['cetelem_barem']?>',
                          'purchaseAmount': '<?=$calc_final_total?>',
                          'url': 'https://<?=(CETELEM_SANDBOX_MODE === true)?'ecomdemo':'ecom'?>.cetelem.hu/ecommerce/Calc.action',
                          'duration': '10'
                          });
                          calc.iframe(420, 325);
                      </script>
										<?php endif; ?>
            			</div>
            			<div class="col-sm-6">
            				<div class="center">
            					<img src="<?=IMG?>cetelem_info_img.png" alt="Cetelem hiteligénylés információk">
            				</div>
            			</div>
            		</div>
            		<div class="row">
            			<div class="col-sm-12 center">
            				<div style="color: #F06B0A; font-size: 0.9em; margin: 10px 0; display: block;"><strong>A szállítási és egyéb költség nem része a hitelösszegnek!</strong></div>
            			</div>
            		</div>
            	</div>
            </div>
            <?php endif ?>

			</form>
	    	<? endif; ?>
    	</div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
	var selectedAtvetel = '<?=$this->storedString['2']['atvetel']?>';

	$(function(){
		if(selectedAtvetel == "<?=$this->settings['flagkey_pickpacktransfer_id']?>"){
			$('.pickpackpont').css({
				display : 'block'
			});
			$('select[name=ppp_megye]').focus();
		}else if( selectedAtvetel == '5'){
			$('.postapont').css({
				display : 'block'
			});
		}else{
			$('.pickpackpont').css({
				display : 'none'
			});
			$('.pickpackpont .atvetelAdat').css({display:'none'});
			$('select[name=ppp_varos]').attr('disabled',true);
			$('select[name=ppp_uzlet]').attr('disabled',true);
		}

		$('.cart-adder').click(function(){
			$('button.mustReload').css({visibility:'visible'});
		});

		$('.step0 .col2').css({
			height : $('.step0 .col1').height()+'px'
		});


		$('#sameOfSzam').click(function(){
			var cls = $(this).is(':checked');

			if(cls){
				$('input[name^=szam_]').each(function(){
					var e = $(this).attr('name');
					$('input[name=szall_'+e.replace('szam_','')+']').val($(this).val());
				});

				var kjid = $('#szam_kozterulet_jelleg').val();
				$('#szall_kozterulet_jelleg option[value='+kjid+']').prop('selected', true);
			}else{

			}
		});

		$('input[type=radio][name=atvetel]').change(function(){
			var v = $(this).val();

			$('.pickpackpont').css({
				display : 'none'
			});
			$('.postapont').css({
				display : 'none'
			});

			switch(v){
				case '<?=$this->settings["flagkey_pickpacktransfer_id"]?>':
					$('.pickpackpont').css({
						display : 'block'
					});
					$('select[name=ppp_megye]').focus();
				break;
				case '5':
					$('.postapont').css({
						display : 'block'
					});
					ppapi.mapInitialize();
					ppapi.reloadPP();
				break;
				default:
					$('#valasztott_postapont').val('');
					$('#selected_pp_data_info').text('nincs kiválasztva');
					$('.pickpackpont .atvetelAdat').css({display:'none'});
					$('select[name=ppp_varos]').attr('disabled',true);
					$('select[name=ppp_uzlet]').attr('disabled',true);
				break;
			}
		});

		$('input[type=radio][name=fizetes]').change(function(){
			var v = $(this).val();

			$('.cetelemcalc').css({
				display : 'none'
			});

			switch(v){
				case '<?=$this->settings["flagkey_pay_cetelem"]?>':
					$('.cetelemcalc').css({
						display : 'block'
					});
				break;
			}
		});

		// Pick Pack Pont event
		function pppSelecting ( e ) {
			var data = jQuery.parseJSON( e.data );
			console.log(e.data);
			$('#ppp_uzlet_str').val(data.zipCode+" " +data.city+", "+data.address+" ("+data.shopType+")");
			$('#ppp_uzlet').val(data.pppShopname);
		}
		window.addEventListener( "message", pppSelecting, false );

	})
</script>
