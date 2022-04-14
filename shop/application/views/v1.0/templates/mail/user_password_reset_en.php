<? require "head.php"; ?>
['EN'] Weboldalunkon új jelszót igényelt. Lépjen be az automatikusan generált új jelszavával, majd sikeres bejelentkezés után változtassa meg a kívánt jelszóra.<br />
<br />
<strong>Jelszavát könnyedén megváltoztathatja a <a href='http://www.<?=rtrim(str_replace(array('http://','www.'),array('',''),$settings['page_url']),'/')?>/user/jelszocsere'>Fiókom / Jelszócsere</a> menüpont alatt.</strong><br />
<br />
Automatikusan generált jelszó:<br />
<strong><?=$jelszo?></strong>
<? require "footer.php"; ?>