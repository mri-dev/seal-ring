<li class="head"><?=$this->screen->getName()?> <div class="subt"><?=$this->creative->getName()?></div></li>
<li class="form on"><a href="javascript:void(0);" onclick="screenMenuToggler(this, 'settings');">Alap beállítások</a></li>
<form name="screensaver">
<li class="form-view opened" id="view-settings">
	<label>Háttér (overlay)</label>	
	<color-picker ng-model="settings.background_color" color-picker-format="'rgb'"></color-picker>
	<br>
	<label>Ablak szélessége</label>	
	<div class="input-group">		
		<input type="number" class="form-control" ng-model="settings.width">
		<span class="input-group-btn" style="width:0px;"></span>
		<select class="form-control" ng-model="settings.type">
			<option ng-repeat="t in settings.width_types">{{t}}</option>
		</select>
	</div>
</li>
<li class="form <?=($_GET[v] == 'screen' && $_GET[vs] == 'general')?'on':''?>"><a href="javascript:void(0);" onclick="screenMenuToggler(this, 'general');">Ablak stílus</a></li>
<li class="form-view" id="view-general">
	<label>Háttér</label>	
	<color-picker ng-model="screen.background_color" color-picker-format="'rgb'"></color-picker>
	<br>
	<label>Háttérkép (direct) URL</label>	
	<input type="text" class="form-control" ng-model="screen.background_image">
	<br>
	<label>Háttérkép igazítása</label>
	<select class="form-control" ng-model="screen.background_pos_sel">
		<option ng-repeat="(key, t) in screen.background_pos" value="{{key}}">{{t}}</option>
	</select>
	<br>
	<label>Háttérkép ismétlődés</label>
	<select class="form-control" ng-model="screen.background_repeat">
		<option ng-repeat="(key, t) in screen.background_reps" value="{{key}}">{{t}}</option>
	</select>
	<br>
	<label>Háttérkép méret</label>
	<select class="form-control" ng-model="screen.background_size">
		<option ng-repeat="(key, t) in screen.background_sizes" value="{{key}}">{{t}}</option>
	</select>
	<br>
	<label>Behúzás</label>	
	<div class="input-group">		
		<input type="number" class="form-control" min='0' ng-model="screen.padding">
		<span class="input-group-addon">px</span>
	</div>
	<br>
	<h4>Keretezés</h4>
	<label>Keret nagysága</label>	
	<div class="input-group">		
		<input type="number" class="form-control" min="0" ng-model="screen.border_size">
		<span class="input-group-addon">px</span>
	</div>
	<br>
	<label>Keret szín</label>	
	<color-picker ng-model="screen.border_color" color-picker-format="'rgb'"></color-picker>
	<br>
	<label>Keret stílusa</label>	
	<select class="form-control" ng-model="screen.border_type">
		<option ng-repeat="t in screen.border_types">{{t}}</option>
	</select>
	<br>
	<h4>Árnyékhatás</h4>
	<label>Árnyék szín</label>	
	<color-picker ng-model="screen.shadow_color" color-picker-format="'hex'"></color-picker>
	<br>
	<label>Árnyék pozíció</label>
	<div class="input-group">		
		<input type="number" class="form-control" ng-model="screen.shadow.x">
		<span class="input-group-addon">x</span>
		<input type="number" class="form-control" ng-model="screen.shadow.y">
	</div>
	<br>
	<label>Árnyék nagysága</label>	
	<div class="input-group">		
		<input type="number" class="form-control" ng-model="screen.shadow_width">
		<span class="input-group-addon">px</span>
	</div>
	<br>
	<label>Árnyék sugara</label>	
	<div class="input-group">		
		<input type="number" class="form-control" ng-model="screen.shadow_radius">
		<span class="input-group-addon">px</span>
	</div>
	<br>
	<label>Egyedi stílus (CSS)</label>		
	<input type="text" class="form-control" ng-model="screen.cssstyles">
	<em>Pl.: <strong>text-transform: uppercase;</strong> (nagybetű), <strong>font-weight: bold;</strong> (kiemelt)</em>
	<br><br>
</li>
<li class="form <?=($_GET[v] == 'screen' && $_GET[vs] == 'font')?'on':''?>"><a href="javascript:void(0);" onclick="screenMenuToggler(this, 'font');">Szöveg stílus</a></li>
<li class="form-view" id="view-font">
	<label>Szín</label>	
	<color-picker ng-model="screen.text_color" color-picker-format="'rgb'"></color-picker>
	<br>
	
	<label>Szöveg igazítás</label>	
	<select class="form-control" ng-model="screen.text_align">
		<option ng-repeat="a in ['left', 'center', 'right']">{{a}}</option>
	</select>
	<br>
	<label>Kiinduló relative méret</label>	
	<div class="input-group">		
		<input type="number" class="form-control" step="0.1" ng-model="screen.text_size">
		<span class="input-group-addon">em</span>
	</div>
</li>
<li class="form <?=($_GET[v] == 'screen' && $_GET[vs] == 'headers')?'on':''?>"><a href="javascript:void(0);" onclick="screenMenuToggler(this, 'headers');">Fejrész</a></li>
<li class="form-view" id="view-headers">
	<h4>Főcím</h4>
	<label>Felirat</label>	
	<input type="text" class="form-control" ng-model="content.title.text">
	<br>
	<label>Szín</label>	
	<color-picker ng-model="content.title.color" color-picker-format="'rgb'"></color-picker>
	<br>	
	<label>Szöveg igazítás</label>	
	<select class="form-control" ng-model="content.title.align">
		<option ng-repeat="a in ['left', 'center', 'right']">{{a}}</option>
	</select>
	<br>
	<label>Méret</label>	
	<div class="input-group">		
		<input type="number" class="form-control" step="0.1" ng-model="content.title.size">
		<span class="input-group-addon">em</span>
	</div>
	<br>
	<h4>Alcím</h4>
	<label>Felirat</label>	
	<input type="text" class="form-control" ng-model="content.subtitle.text">
	<br>
	<label>Szín</label>	
	<color-picker ng-model="content.subtitle.color" color-picker-format="'rgb'"></color-picker>
	<br>	
	<label>Szöveg igazítás</label>	
	<select class="form-control" ng-model="content.subtitle.align">
		<option ng-repeat="a in ['left', 'center', 'right']">{{a}}</option>
	</select>
	<br>
	<label>Méret</label>	
	<div class="input-group">		
		<input type="number" class="form-control" step="0.1" ng-model="content.subtitle.size">
		<span class="input-group-addon">em</span>
	</div>	
</li>
<li class="form <?=($_GET[v] == 'screen' && $_GET[vs] == 'content')?'on':''?>"><a href="javascript:void(0);" onclick="screenMenuToggler(this, 'content');">Tartalom</a></li>
<li class="form-view" id="view-content">	
	<label>Tartalom szövege</label>	
	<div style="border: 1px dashed #aaa; padding: 5px;" ui-tinymce="tinymcesettings" ng-model="content.fill.text" ></div>
	<br>
	<label>Szín</label>	
	<color-picker ng-model="content.fill.color" color-picker-format="'rgb'"></color-picker>
	<br>	
	<label>Szöveg igazítás</label>	
	<select class="form-control" ng-model="content.fill.align">
		<option ng-repeat="a in ['left', 'center', 'right', 'justify']">{{a}}</option>
	</select>
	<br>
	<label>Méret</label>	
	<div class="input-group">		
		<input type="number" class="form-control" step="0.1" ng-model="content.fill.size">
		<span class="input-group-addon">em</span>
	</div>
</li>
<li class="form <?=($_GET[v] == 'screen' && $_GET[vs] == 'interactions')?'on':''?>"><a href="javascript:void(0);" onclick="screenMenuToggler(this, 'interactions');">Interakció</a></li>
<li class="form-view" id="view-interactions">	
	<h4>Fő gomb</h4>
	<label>Háttér szín</label>	
	<color-picker ng-model="interacion.main.background" color-picker-format="'rgb'"></color-picker>
	<br>
	<label>Gomb szélessége</label>	
	<div class="input-group">		
		<input type="number" class="form-control" ng-model="interacion.main.width">
		<span class="input-group-btn" style="width:0px;"></span>
		<select class="form-control" ng-model="interacion.main.width_type">
			<option ng-repeat="t in interacion.main.width_types">{{t}}</option>
		</select>
	</div>
	<br>
	<label>Behúzás</label>	
	<div class="input-group">		
		<input type="number" class="form-control" min='0' ng-model="interacion.main.padding">
		<span class="input-group-addon">px</span>
	</div>	
	<br>
	<label>Térköz</label>	
	<div class="input-group">		
		<input type="number" class="form-control" min='0' ng-model="interacion.main.margin">
		<span class="input-group-addon">px</span>
	</div>
	<br>
	<h4>Fő gomb Keretezés</h4>
	<label>Keret nagysága</label>	
	<div class="input-group">		
		<input type="number" class="form-control" min="0" ng-model="interacion.main.border_width">
		<span class="input-group-addon">px</span>
	</div>
	<br>
	<label>Keret szín</label>	
	<color-picker ng-model="interacion.main.border_color" color-picker-format="'rgb'"></color-picker>
	<br>
	<label>Keret stílusa</label>	
	<select class="form-control" ng-model="interacion.main.border_style">
		<option ng-repeat="t in screen.border_types ">{{t}}</option>
	</select>
	<br>
	<label>Keret sugara</label>	
	<div class="input-group">		
		<input type="number" class="form-control" min='0' ng-model="interacion.main.border_radius">
		<span class="input-group-addon">px</span>
	</div>
	<br>
	<br>
	<h4>Fő gomb felirat</h4>	
	<input type="text" class="form-control" ng-model="interacion.main.text">
	<br>
	<label>Szöveg szín</label>	
	<color-picker ng-model="interacion.main.text_color" color-picker-format="'rgb'"></color-picker>
	<br>	
	<label>Szöveg igazítás</label>	
	<select class="form-control" ng-model="interacion.main.text_align">
		<option ng-repeat="a in ['left', 'center', 'right']">{{a}}</option>
	</select>
	<br>
	<label>Szöveg méret</label>	
	<div class="input-group">		
		<input type="number" class="form-control" step="0.1" ng-model="interacion.main.text_size">
		<span class="input-group-addon">em</span>
	</div>

	<br>
	<label>Egyedi stílus (CSS)</label>		
	<input type="text" class="form-control" step="0.1" ng-model="interacion.main.text_custom">
	<em>Pl.: <strong>text-transform: uppercase;</strong> (nagybetű), <strong>font-weight: bold;</strong> (kiemelt)</em>
	<br><br>
	<h4>Kilépő gomb</h4>
	<input type="text" class="form-control" ng-model="interacion.exit.text">
	<br>
	<label>Szöveg szín</label>	
	<color-picker ng-model="interacion.exit.text_color" color-picker-format="'rgb'"></color-picker>
	<br>	
	<label>Szöveg igazítás</label>	
	<select class="form-control" ng-model="interacion.exit.text_align">
		<option ng-repeat="a in ['left', 'center', 'right']">{{a}}</option>
	</select>
	<br>
	<label>Szöveg méret</label>	
	<div class="input-group">		
		<input type="number" class="form-control" step="0.1" ng-model="interacion.exit.text_size">
		<span class="input-group-addon">em</span>
	</div>
	
</li>
<li class="form <?=($_GET[v] == 'screen' && $_GET[vs] == 'links')?'on':''?>"><a href="javascript:void(0);" onclick="screenMenuToggler(this, 'links');">Hivatkozások</a></li>
<li class="form-view" id="view-links">	
	<label>Átirányítási URL</label>	
	<input type="text" class="form-control" ng-model="links.to_url">
	<em>Interakció során ide irányítja a felhasználót.</em>
	<br><br>
	<label>Megnyitás</label>	
	<select class="form-control" ng-model="links.open_type">
		<option ng-repeat="(key, v) in links.open_types" value="{{key}}">{{v}}</option>
	</select>
	<br>
	<label>Kilépő URL</label>	
	<input type="text" class="form-control" ng-model="links.exit_url">
	<em>Sima ablak bezáráshoz hagyja üresen ezt a mezőt.</em>
	<br>
</li>
<li class="saving" ng-show="saving">
	Mentés folyamatban <i class="fa fa-refresh fa-spin"></i>
</li>
<li class="form" ng-show="!saving">
	<button class="btn btn-success form-control" ng-click="save(<?=$this->creative->getID()?>, <?=$this->screen->getID()?>)">Jellemzők mentése <i class="fa fa-save"></i></button>
</li>
</form>

<form method="post" action="">
<li class="head">
	Fő beállítások
</li>
<li class="form-view" style="display: block;">
	<label>Megjelenés elnevezése</label>	
	<input type="text" class="form-control" name="name" value="<?=$this->screen->getName()?>">
	<br>
	<label>Megjelenési arány</label>	
	<input type="number" step="1" class="form-control" name="use_weight" value="<?=$this->screen->getShowWeight()?>">
	<em>Egymáshoz viszonyított arányok.</em>
	<br><br>
	<label>Állapot</label>	
	<select class="form-control" name="active">
		<option value="0" <?=(!$this->screen->isActive())?'selected="selected"':''?>>Inaktív</option>
		<option value="1" <?=($this->screen->isActive())?'selected="selected"':''?>>Aktív</option>
	</select>
</li>
<li class="form" ng-show="!saving">
	<button class="btn btn-success form-control" name="saveScreenSettings">Beállítások mentése <i class="fa fa-save"></i></button>
</li>
</form>