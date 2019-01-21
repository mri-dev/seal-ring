<? require "head.php"; ?>
<h2>Tisztelt <?=$nev?>!</h2>
Köszönjük, hogy regisztrált rendszerünkbe! <br>
Amennyiben nem Ön regisztrált a(z) <strong><?=$settings['page_title']?></strong> weboldalon, hagyja figyelmen kívül ezt a levelet. 3 nap múlva törlődnek a nem aktivált regisztrációs kérelmek!<br>
<br>
<strong>Amennyiben Ön regisztrált, kérjük, hogy az alábbi hivatkozást megnyitva <u>aktiválja fiókját</u>:</strong><br>
<a href='http://www.<?=rtrim(str_replace(array('http://','www.'),array('',''),$settings['page_url']),'/')?>/user/activate/<?=$activateKey?>'>http://www.<?=rtrim(str_replace(array('http://','www.'),array('',''),$settings['page_url']),'/')?>/user/activate/<?=$activateKey?></a><br>
<br>
Jó vásárlást kívánunk!
<? require "footer.php"; ?>