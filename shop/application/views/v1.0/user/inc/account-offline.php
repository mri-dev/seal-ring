<div class="side-menu side-left">
	<ul>
	    <li class="head <?=($this->gets['1'] == 'belepes')?'active':''?>"><a href="/belepes"><?=__('Bejelentkezés')?></a></li>
	    <li class=" <?=($this->gets['1'] == 'jelszoemlekezteto')?'active':''?>"><a href="/jelszoemlekezteto"><?=__('Elfelejtett jelszó')?></a></li>
	    <li class="head <?=($this->gets['1'] == 'regisztracio' && !$_GET['group'])?'active':''?>"><a href="/regisztracio"><?=__('Regisztráció')?></a></li>
	</ul>
</div>
