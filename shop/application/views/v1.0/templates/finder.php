<?php
  $getqry = $_GET;
  unset($getqry['tag']);
  $getqrystr = http_build_query($getqry);
?>
<div class="search-finder" ng-init="loadFinder('<?=$getqrystr?>')">
  <div class="tabs">
    <ul>
      <li ng-class="(findernavpos=='simple')?'active':''" ng-click="switchFinderNav('simple')">Termék kereső</li>
      <?php if (false): ?>
        <li ng-class="(findernavpos=='advenced')?'active':''" ng-click="switchFinderNav('advenced')">Részletes kereső</li>
        <li ng-class="(findernavpos=='keywords')?'active':''" ng-click="switchFinderNav('keywords')">Keresés kifejezésre</li>
        <li ng-class="(findernavpos=='numbers')?'active':''" ng-click="switchFinderNav('numbers')">Keresés cikkszám alapján</li>
      <?php endif; ?>
    </ul>
  </div>
  <div class="contents">
    <div class="cont-simple" ng-show="(findernavpos=='simple')">
      <div class="wrapper">

        <div class="left-side">
          <div class="src">
            <div class="search-wrapper">
              <input type="text" ng-change="bindFinder()" ng-model="finder_config_select.search_keywords" placeholder="Keresési kifejezés...">
            </div>
          </div>
        </div>
        <div class="right-side">
          <div class="search-button" ng-class="(finder_result_num == 0)?'disabled':''">
            <button ng-click="goFinder()"><strong>Keresés</strong><br><span ng-show="finder_result_num!==-1">{{finder_result_num}} db. találat</span><span ng-hide="finder_result_num!==-1">Betöltés...<i class="fa fa-refresh fa-spin"></i></span></button>
          </div>
        </div>
      </div>
    </div>
    <div class="cont-advenced" ng-show="(findernavpos=='advenced')">
      <div class="wrapper">
        <div class="src">
          <div class="search-wrapper">
            <input type="text" ng-change="bindFinder()" ng-model="finder_config_select.search_keywords" placeholder="Keresési kifejezés...">
          </div>
        </div>
        <div class="left-side">
          <div class="group">
            <div class="selections">
              <label for="">Válassza ki a terméktípust</label>
              <div class="select-wrapper">
                <select ng-change="bindFinder()" ng-options="item as item.label for item in finder_config.selects.cats track by item.id" ng-model="finder_config_select.selects.cat"></select>
              </div>
            </div>
            <div class="selections" ng-class="(!finder_config_select.selects.cat.id)?'disabled':''">
              <label for="">Válassza ki a mellékterméket</label>
              <div class="select-wrapper">
                <select ng-change="bindFinder()" ng-disabled="(!finder_config_select.selects.cat.id)?true:false" ng-options="item as item.label for item in finder_config.selects.subcats[finder_config_select.selects.cat.id] track by item.id" ng-model="finder_config_select.selects.subcat"></select>
              </div>
            </div>
          </div>
        </div>
        <div class="div">&nbsp;</div>
        <div class="right-side">
          <div class="group">
            <h3>Felhasználási terület</h3>
            <div class="holder">
              <div class="radioboxes">
                <div class="" ng-repeat="cb in finder_config.felhasznalasi_teruletek">
                  <input type="radio" ng-click="bindFinder()" ng-value="cb.id" ng-model="$parent.finder_config_select.felhasznalasi_terulet" id="felhasznalasi_teruletek_v{{cb.id}}"> <label for="felhasznalasi_teruletek_v{{cb.id}}">{{cb.label}}</label>
                </div>
              </div>
            </div>
          </div>
          <?php if (false): ?>
            <div class="group">
              <h3>Méretek</h3>
              <div class="size-configs">
                <div class="size-group" ng-repeat="size in finder_config.meretek">
                  <div class="flex">
                    <div class="ranges">
                      <label for="">{{size.name}}</label>
                      <div class="flex">
                        <div class="r-min">
                          <input type="text" ng-value="size.range.min">
                        </div>
                        <div class="t-label">
                          ≤ {{size.label}} ≤
                        </div>
                        <div class="r-max">
                          <input type="text" ng-value="size.range.max">
                        </div>
                      </div>
                    </div>
                    <div class="fvalue">
                      <label for="">Pontos méret</label>
                      <div class="flex">
                        <div class="t-label">
                          {{size.label}}=
                        </div>
                        <div class="v">
                          <input type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <div class="search-button" ng-class="(finder_result_num == 0)?'disabled':''">
            <button ng-click="goFinder()"><strong>Keresés</strong><br><span ng-show="finder_result_num!==-1">{{finder_result_num}} db. találat</span><span ng-hide="finder_result_num!==-1">Betöltés...<i class="fa fa-refresh fa-spin"></i></span></button>
          </div>
        </div>
      </div>
    </div>
    <?php if (false): ?>
    <div class="cont-keywords" ng-show="(findernavpos=='keywords')">
      <div class="wrapper">
        <div class="left-side">
          <div class="search-wrapper">
            <input type="text" ng-model="finder_config_select.search_keywords" placeholder="Keresési kifejezés...">
          </div>
        </div>
        <div class="div">&nbsp;</div>
        <div class="right-side">
          <div class="search-button">
            <button ng-click="goFinder()"><strong>Keresés</strong><br>{{finder_result_num}} db. találat</button>
          </div>
        </div>
      </div>
    </div>
    <div class="cont-numbers" ng-show="(findernavpos=='numbers')">
      <div class="wrapper">
        <div class="left-side">
          <div class="search-wrapper">
            <input type="text" ng-model="finder_config_select.search_number" placeholder="Cikkszám...">
          </div>
        </div>
        <div class="div">&nbsp;</div>
        <div class="right-side">
          <div class="search-button">
            <button ng-click="goFinder()"><strong>Keresés</strong><br>{{finder_result_num}} db. találat</button>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>
