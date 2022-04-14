<div class="account page-width">
    <div class="grid-layout">
        <div class="grid-row grid-row-20"><? $this->render('user/inc/account-offline', true); ?></div>
        <div class="grid-row grid-row-80">
          <?php if (isset($_GET['group'])): ?>
            <div class="">
              <h1><?=($_GET['group'] == 'company')?__('Partner (cég) regisztráció'):__('Regisztráció')?></h1>
                  <div class="center">
                    <?php if ($_GET['group'] == 'company'): ?>
                      <?php if ($this->settings['account_reseller_description'] != ''): ?>
                        <div class="reseller-description">
                          <?php echo $this->settings['account_reseller_description']; ?>
                        </div>
                      <?php endif; ?>
                      <a href="/user/regisztracio?group=user"><?=__('Magánszemélyként regisztrálok inkább')?> >></a>
                    <?php else: ?>
                    <?php endif; ?>
                  </div>
                  <?=$this->msg?>
                  <br><br>
                  <form autocomplete="off" action="/user/regisztracio/<?=($_GET['group'] == 'company')?'?group=company':''?>" method="post" id="register" onsubmit="$('#registerBtn').click() return false;">
                  <input type="hidden" name="group" value="<?=$_GET['group']?>">
                  <div class="" style="padding:0;">
                      <div class="stack">
                          <h3><?=__('Alapadatok')?></h3>
                          <div>
                              <div class="row">
                                  <div class="col-md-6 col-pright"><label for="nev"><?=__('Teljes név')?>:</label><input required="required" type="text" id="nev" name="nev" value="<?=($this->msg)?$_POST['nev']:''?>" class="form-control"/></div>
                                  <div class="col-md-6 col-pleft"><label for="email"><?=__('E-mail cím')?>:</label><input required="required" type="text" id="email" name="email" value="<?=($this->msg)?$_POST['email']:''?>" class="form-control <?=($this->err == 1002)?'input-text-error':''?>" excCode="1002" /></div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 col-pright"><label for="pw1"><?=__('Jelszó')?></label><input required="required" type="password" id="pw1" name="pw1" class="form-control"/></div>
                                  <div class="col-md-6 col-pleft"><label for="pw2"><?=__('Jelszó újra')?></label><input required type="password" id="pw2" name="pw2" class="form-control"/></div>
                              </div>
                          </div>
                      </div>
                      <? if($_GET['group'] == 'company'): ?>
                      <div class="stack">
                          <h3><?=__('Cégadatok megadása')?></h3>
                          <div>
                              <div class="row">
                                  <div class="col-md-6 col-pright"><label for="company_name"><?=__('Cégnév')?>:</label><input required="required" type="text" id="company_name" name="company['company_name']" value="<?=($this->msg)?$_POST['company']['company_name']:''?>" class="form-control <?=($this->err == 2001)?'input-text-error':''?>" excCode="2001"/></div>
                                  <div class="col-md-6 col-pleft"><label for="company_hq"><?=__('Cég székhelye')?>:</label><input required="required" type="text" id="company_hq" name="company['company_hq']" value="<?=($this->msg)?$_POST['company']['company_hq']:''?>" class="form-control <?=($this->err == 2002)?'input-text-error':''?>" excCode="2002" /></div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 col-pright"><label for="company_adoszam"><?=__('Adószám')?>:</label><input required="required" type="text" id="company_adoszam" name="company['company_adoszam']" value="<?=($this->msg)?$_POST['company']['company_adoszam']:''?>" class="form-control <?=($this->err == 2003)?'input-text-error':''?>" excCode="2003"/></div>
                                  <div class="col-md-6 col-pleft"><label for="company_address"><?=__('Cég postacím')?>:</label><input required="required" type="text" id="company_address" name="company['company_address']" value="<?=($this->msg)?$_POST['company']['company_address']:''?>" class="form-control <?=($this->err == 2004)?'input-text-error':''?>" excCode="2004" /></div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 col-pright"><label for="company_bankszamlaszam"><?=__('Bankszámlaszám')?>:</label><input required="required" type="text" id="company_bankszamlaszam" name="company['company_bankszamlaszam']" value="<?=($this->msg)?$_POST['company']['company_bankszamlaszam']:''?>" class="form-control <?=($this->err == 2005)?'input-text-error':''?>" excCode="2005"/></div>
                              </div>
                          </div>
                      </div>
                      <? endif; ?>
                      <div class="stack">
                          <h3><?=__('Vásárláshoz szükséges adatok')?></h3>
                          <div>
                              <div class="row">
                                  <div class="col-md-6 col-pright">
                                      <h4><?=__('Számlázási adatok')?></h4>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Név')?></strong> *</div>
                                          <div class="col-md-8"><input required="required" type="text" id="szam_nev" name="szam_nev" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Irányítószám')?></strong> *</div>
                                          <div class="col-md-8"><input autocomplete="off" required="required" type="text" <? if(\Lang::getLang() == DLANG): ?>ng-keyup="findCityByIrsz($event, 'szam_city')"<? endif; ?> id="szam_irsz" name="szam_irsz" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Település')?></strong> *</div>
                                          <div class="col-md-8 hint-holder-col"><input required="required" placeholder="<?=(\Lang::getLang() == DLANG)?__('Irányítószám megadása').'...':''?>" <?=(\Lang::getLang() == DLANG)?'readonly="readonly"':''?> type="text" id="szam_city" name="szam_city" class="form-control"/><div class="hint-holder" ng-show="findedCity['szam_city'] && findedCity['szam_city'].length != 0" id="szam_city">
                                            <div class="hint-list">
                                              <div class="cityhint" ng-click="fillCityHint('szam_city', city)" ng-repeat="city in findedCity['szam_city']">{{city.varos}} <span ng-show="city.megye" class="megye">({{city.megye}} megye)</span></div>
                                            </div>
                                          </div></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Kerület')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szam_kerulet" name="szam_kerulet" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Közterület neve')?></strong> *</div>
                                          <div class="col-md-8"><input required="required" type="text" id="szam_kozterulet_nev" name="szam_kozterulet_nev" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Közterület jellege')?></strong></div>
                                          <div class="col-md-8">
                                              <select name="szam_kozterulet_jelleg" class="form-control" id="szam_kozterulet_jelleg">
                                                  <option value="" selected="selected">-- <?=__('válasszon')?> --</option>
                                                  <? foreach( $this->kozterulet_jellege as $kj ): ?>
                                                  <option value="<?=$kj?>" <?=(isset($_POST['szam_kozterulet_jellege']) && $_POST['szam_kozterulet_jellege'] == $kj) ? 'selected="selected"' : ( ($kj == 'utca') ? 'selected="selected"':'' )?>><?=$kj?></option>
                                                  <? endforeach; ?>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Házszám')?></strong> *</div>
                                          <div class="col-md-8"><input required="required" type="text" id="szam_hazszam" name="szam_hazszam" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Épület')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szam_epulet" name="szam_epulet" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Lépcsőház')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szam_lepcsohaz" name="szam_lepcsohaz" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Szint')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szam_szint" name="szam_szint" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Ajtó')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szam_ajto" name="szam_ajto" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-12 form-text right" style="font-size:0.85em;"><a href="javascript:void(0);" id="copySzamToSzall"><?=__('számlázási adatok másolása szállítási adatokhoz')?> <i class="fa fa-arrow-right"></i> </a></div>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-pleft">
                                      <h4><?=__('Szállítási adatok')?></h4>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Név')?></strong> *</div>
                                          <div class="col-md-8"><input required="required" type="text" id="szall_nev" name="szall_nev" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Irányítószám')?></strong> *</div>
                                          <div class="col-md-8"><input autocomplete="off" required="required" type="text" id="szall_irsz" <? if(\Lang::getLang() == DLANG): ?>ng-keyup="findCityByIrsz($event, 'szall_city')"<? endif; ?> name="szall_irsz" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Település')?></strong> *</div>
                                          <div class="col-md-8 hint-holder-col"><input required="required" placeholder="<?=(\Lang::getLang() == DLANG)?__('Irányítószám megadása').'...':''?>" type="text" id="szall_city" <?=(\Lang::getLang() == DLANG)?'readonly="readonly"':''?> name="szall_city" class="form-control"/><div class="hint-holder" ng-show="findedCity['szall_city'] && findedCity['szall_city'].length != 0" id="szall_city">
                                            <div class="hint-list">
                                              <div class="cityhint" ng-click="fillCityHint('szall_city', city)" ng-repeat="city in findedCity['szall_city']">{{city.varos}} <span ng-show="city.megye" class="megye">({{city.megye}} megye)</span></div>
                                            </div>
                                          </div></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Kerület')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szall_kerulet" name="szall_kerulet" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Közterület neve')?></strong> *</div>
                                          <div class="col-md-8"><input required="required" type="text" id="szall_kozterulet_nev" name="szall_kozterulet_nev" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Közterület jellege')?></strong></div>
                                          <div class="col-md-8">
                                              <select name="szall_kozterulet_jelleg" class="form-control" id="szall_kozterulet_jelleg">
                                                  <option value="" selected="selected">-- <?=__('válasszon')?> --</option>
                                                  <? foreach( $this->kozterulet_jellege as $kj ): ?>
                                                  <option value="<?=$kj?>" <?=(isset($_POST['szall_kozterulet_jelleg']) && $_POST['szall_kozterulet_jelleg'] == $kj) ? 'selected="selected"' : ( ($kj == 'utca') ? 'selected="selected"':'' )?>><?=$kj?></option>
                                                  <? endforeach; ?>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Házszám')?></strong> *</div>
                                          <div class="col-md-8"><input required="required" type="text" id="szall_hazszam" name="szall_hazszam" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Épület')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szall_epulet" name="szall_epulet" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Lépcsőház')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szall_lepcsohaz" name="szall_lepcsohaz" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Szint')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szall_szint" name="szall_szint" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Ajtó')?></strong></div>
                                          <div class="col-md-8"><input type="text" id="szall_ajto" name="szall_ajto" class="form-control"/></div>
                                      </div>
                                      <div class="divider-sm"></div>
                                      <div class="row">
                                          <div class="col-md-4 form-text"><strong><?=__('Telefonszám')?></strong></div>
                                          <div class="col-md-8"><input required="required" type="text" id="szall_phone" name="szall_phone" class="form-control"/></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="stack">
                          <div class="row">
                              <div class="col-md-8 form-btn" style="line-height:42px;font-size: 0.8em;"><input required="required" type="checkbox" id="aszfOk" name="aszfOk" /> <label for="aszfOk">
                                <?php echo sprintf(__('Elolvastam és tudomásul vettem az %s és az %s-ban foglaltakat!'), '<a href="'.$this->settings['ASZF_URL'].'" target="_blank">'.__('ÁSZF').'</a>', '<a href="/p/adatvedelmi-tajekoztato">'.__('Adatvédelmi tájékoztató').'</a>'); ?></label></div>
                              <div class="col-md-4" align="right">
                                  <button name="registerUser" value="1" class="btn btn-pr"><?=__('Regisztráció')?> <i class="fa fa-arrow-circle-right"></i></button>
                              </div>
                          </div>
                      </div>
                  </div>
                  </form>
              </div>
          <?php elseif($_GET['successreg'] == 1): ?>
            <div class="success-reg-msg">
              <h1><i class="fa fa-check-circle-o"></i><br><?=__('Sikeresen rögzítette regisztrációját!')?></h1>
              <p><?php echo $_GET['msg']; ?></p> 
              <br>
              <div class="todo-after-reg">
                <h2><?=__('További teendők')?>:</h2>
                <ul>
                    <li><i class="fa fa-circle-o"></i> <strong><?=__('Kérjük, hogy aktiválja regisztrációját!')?></strong></li>
                    <li><i class="fa fa-circle-o"></i> <strong><?=__('Magánszemély esetén: kérjük várja meg a hozzáférés engedélyezését!')?></strong></li>
                    <li><i class="fa fa-circle-o"></i> <strong><?=__('Céges regisztráció esetén: kérjük várja meg kollégánk jelentkezését!')?></strong></li>
                </ul>
              </div>
            </div>
          <?php else: ?>
            <div class="group-selector">
              <h1><?=__('Ön hogy szeretne regisztrálni?')?></h1>
              <div class="groups">
                <div class="">
                  <a href="/user/regisztracio?group=user"><?=__('Magánszemélyként')?></a>
                </div>
                <div class="">
                  <a href="/user/regisztracio?group=company"><?=__('Cégként')?></a>
                </div>
                <div style="flex-basis: 100%; font-size: 1.25rem; line-height: 1.5; color: #000;">
                    <h2 style="font-weight: bold; margin: 0 0 10px 0; color: #15a98c;"><?=__('Tisztelt Leendő Ügyfelünk!')?></h2>
                    <p><?=__('Regisztrációja aktiválása után kérjük várjon kollégánk jelentkezéséig, vagy a felhasználói fiókja engedélyezéséig!')?></p>   
                    <p><?=__('Köszönjük türelmüket és megértésüket!')?></p>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#copySzamToSzall').click(function(){
            $('#register input[name^=szam_]').each(function(){
                var e = $(this).attr('name');
                 $('#register input[name=szall_'+e.replace('szam_','')+']').val($(this).val());
            });

            $('#register select#szall_kozterulet_jelleg option[value="'+$('#register select#szam_kozterulet_jelleg').val()+'"]').prop('selected', true);
        });
    })
</script>
