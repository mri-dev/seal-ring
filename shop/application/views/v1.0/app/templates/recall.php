<md-dialog aria-label="Ingyenes visszahívás kérése" class="ajaxdialog recall">
  <form ng-cloak>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Ingyenes visszahívás kérése</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="closeDialog()">
          <md-icon md-svg-src="/src/images/ic_close_white_24px.svg" aria-label="Close dialog"></md-icon>
        </md-button>
      </div>
    </md-toolbar>

    <md-dialog-content>
      <div class="md-dialog-content" ng-show="!sending">
        <md-input-container class="md-icon-float md-block">
          <label>Az Ön teljes neve</label>
          <md-icon md-svg-src="/src/images/ic_person_orange_24px.svg"></md-icon>
          <input required ng-model="recall.name">
        </md-input-container>
        <md-input-container class="md-icon-float md-block">
          <label>Az Ön telefonszáma</label>
          <md-icon md-svg-src="/src/images/ic_phone_orange_24px.svg"></md-icon>
          <input required ng-model="recall.phone" ng-pattern="/^\d+$/">
          <div class="hint" ng-show="showHints">Minta: 061123456</div>
          <div ng-messages="recall.phone.$error" multiple md-auto-hide="false">
            <div ng-message="required">
              Telefonszám kitöltése kötelező!
            </div>
            <div ng-message="pattern">
              Nem megfelelő a telefonszám formátuma.
            </div>
          </div>
        </md-input-container>
        <br>
        <md-input-container class="md-block">
          <label>Milyen ügyben keres minket?</label>
          <textarea required ng-model="recall.subject" md-maxlength="200" rows="3" md-select-on-focus></textarea>
        </md-input-container>

        <div class="validate-text" ng-show="!validateForm()">
          Kérjük, hogy töltse ki helyesen a fenti űrlapot.<br>A csillaggal megjelölt mezők kitöltése kötelező!<br>A telefonszámot a mintán szereplő formátumban adja meg.
        </div>
      </div>
      <div class="md-dialog-content sending-progress" ng-show="sending">
        <div class="message">
          A kérés küldése folyamatban... <i class="fa fa-spin fa-spinner"></i>
        </div>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row" ng-show="!sending" ng-hide="!validateForm()">
      <md-button ng-click="closeDialog()">
       Mégse
      </md-button>
      <span flex></span>
      <md-button class="md-primary md-raised" ng-click="sendModalMessage('recall')">
        Visszahívás kérése
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>
