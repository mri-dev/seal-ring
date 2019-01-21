<? require "head.php"; ?>
<h1>Tisztelt <?=$settings['page_title']?> adminisztrátor!</h1>
<br>
A webáruházba <strong><?=$new_items?> db</strong> új elem / termék lett automatikusan létrehozva a(z) <strong>/gateway/api</strong> <em>articleUpdate</em> parancs által.
<br><br>
<strong style="color:red;">Az új elemek / termékek nyilvánosság tételéhez egészítse ki a hiányzó adatokat. <u>Az új elemek jelenleg INAKTÍV állapotbvan várakoznak!</u></strong>
<br><br>
<strong>Elküldött forrás JSON:</strong>
<pre>
	<?=$source_str_json?>
</pre>
<? require "footer.php"; ?>