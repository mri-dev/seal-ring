<form action="/user/belepes?return=<?=($_GET['return'] == '') ? ( ('/user/belepes'  == $_SERVER['REQUEST_URI']) ? '' : $_SERVER['REQUEST_URI'] ) : $_GET['return']?>" method="post">
	<div class="row np">
		<div class="col-md-12">
			<label for="login_email"><?=__('E-mail cím')?></label>
			<input type="email" id="login_email" name="email" class="form-control">
		</div>
	</div>
	<div class="row np">
		<div class="col-md-12">
			<label for="login_pw"><?=__('Jelszó')?></label>
			<input type="password" id="login_pw" name="pw" class="form-control">
		</div>
	</div>
	<div class="row np">
		<div class="col-md-6 left links">
			<? if(!$clear): ?>
			<a href="/user/regisztracio"><strong><?=__('Regisztráció')?></strong></a> &nbsp;
			<a href="/user/jelszoemlekezteto"><?=__('Elfelejtett jelszó')?></a>
			<? endif; ?>
		</div>
		<div class="col-md-6 right loginbtn">
			<button name="loginUser" value="1" class="btn btn-pr"><?=__('Bejelentkezés')?></button>
		</div>
	</div>
</form>
