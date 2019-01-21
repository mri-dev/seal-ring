<?
	$shop 	= $casadashops->getNearofMe();
	$dist 	= $shop->getDistributors();

	$nev 	= $dist[0]['nev'];
	$image 	= $dist[0]['profilkep'];
	$titulus= $dist[0]['titulus'];
	$email 	= $dist[0]['email'];
	$hely 	= $shop->getName();
	$cim 	= $shop->getAddress();
	$nyitvatartas= $shop->getOpensASString();
	$telefon= $dist[0][telefon];
?>
<? if(!empty($dist)): ?>
<div class="floating-box contact-msg">
	<div class="labtext toggler">
		<div class="text"><span class="ico"><i class="fa fa-user fa-rotate-90"></i></span> Segíthetek?</div>
	</div>
	<div class="exit" title="Bezárás"><i class="fa fa-times"></i></div>
	<div class="contact">
		<div class="profil">
			<div class="img"><img src="<?=IMGDOMAIN.$image?>" alt="<?=$nev?>"></div>
			<div class="name"><strong><?=$nev?></strong></div>
			<div class="titulus"><?=$titulus?></div>
		</div>		
		<br>
		<div class="hely"><strong><?=$hely?></strong></div>
		<div class="cim"><?=$cim?></div>
		<div class="opens">
		<div><strong>Nyitva tartás:</strong></div>
		<div class="when"><?=$nyitvatartas?></div>
		</div>
	</div>
	<div class="form">
		<div class="welcome">Köszöntöm Önt!</div>
		<div><strong>Segíthetek?</strong></div>
		<div class="clt">Küldjön üzenetet nekem</div>
		<form method="post" action="/">
			<input type="hidden" name="side_contact_msg" value="<?=md5($dist[0][user_id])?>">
			<div><input type="text" class="form-control" name="name" placeholder="Név"></div>
			<div><input type="email" class="form-control" name="email" placeholder="Email"></div>
			<div><textarea name="msg" class="form-control" placeholder="Üzenete"></textarea></div>
			<div>
				<div class="g-recaptcha" data-sitekey="<?=$settings['recaptcha_public_key']?>"></div>
			</div>
			<div><button><i class="fa fa-check"></i> Üzenet elküldése</button></div>
		</form>
		<div class="phone">Telefon: <?=$telefon?></div>
	</div>
	<div class="clr"></div>
</div>
<script type="text/javascript">
	(function($){
		$('.floating-box.contact-msg .toggler').click(function(){
			var c = $(this).parent('.contact-msg');

			if (c.hasClass('opened')) {
				c.removeClass('opened');
			} else {
				c.addClass('opened');
			}
		});
		$('.floating-box.contact-msg .exit').click(function(){
			var c = $(this).parent('.contact-msg');
			$.cookie('closedFloaterMsg', 1);

			c.removeClass('opened');
		});

		$(window).scroll(function(){
			var ck 	= $.cookie('closedFloaterMsg');
			var ft 	= $('body').scrollTop();
			var e 	= $('.floating-box.contact-msg');

			if( !ck ) {
				if ( ft >= 500 && !e.hasClass('opened')) 
				{
					e.addClass('opened');
				} else if( ft < 500 && e.hasClass('opened')) {
					e.removeClass('opened');
				}
			}
		
		});
	})(jQuery);
</script>
<? endif; ?>