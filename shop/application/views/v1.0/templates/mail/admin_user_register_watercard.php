<? require "head.php"; ?>
<h2>Új felhasználó regisztráció során <u>Jövő Bajnokai kártya / Arena Water Card</u> adatokat adtak meg!</h2>
<br>
<strong style="color:red;">A kártya visszaigazolásra vár, amit az adminisztrációs felületen keresztül jóváhagyhat.</strong> <br>
Visszaigazolás: <a href="<?=$adminroot?>watercard/check/<?=$wc['kartyaszam']?>/1"><?=$adminroot?>watercard/check/<?=$wc['kartyaszam']?></a>
<br><br>
ADATOK: <br>
Név: <strong><?=$data['nev']?></strong> <br>
E-mail: <strong><?=$data['email']?></strong><br>
<br>
KÁRTYA ADATOK: <br>
Kártyaszám: <strong><?=$wc['kartyaszam']?></strong> <br>
Egyesület: <strong><?=$wc['egyesulet']?></strong><br>
<br>
<? require "footer.php"; ?>