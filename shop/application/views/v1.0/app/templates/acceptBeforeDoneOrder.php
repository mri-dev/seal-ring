<md-dialog aria-label="{{accept_order_title}}" class="ajaxdialog accept-order">
  <form ng-cloak>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>{{accept_order_title}}</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="closeDialog()">
          <md-icon md-svg-src="/src/images/ic_close_white_24px.svg" aria-label="Close dialog"></md-icon>
        </md-button>
      </div>
    </md-toolbar>

    <md-dialog-content>
      <div class="md-dialog-content">
        <div ng-bind-html="accept_order_text|unsafe"></div>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <md-button ng-click="closeDialog()">
       Mégse
      </md-button>
      <span flex></span>
      <md-button class="md-warn md-raised" ng-click="acceptOrder()">
        Elfogadom a feltételeket
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>
