<? require "head.php"; ?>
<h2>Új kapcsolat üzenet érkezett a(z) <?=$settings['page_title']?> oldalon!</h2>
<br>
Az üzenetet a következő oldalról küldték: <strong><?=$settings['domain']?><?=substr($_SERVER['REQUEST_URI'], 1)?></strong>
<br><br>
<strong>Üzenet feladója:</strong> <?=$form['contact_name']?> (<?=$form['contact_email']?>) <br>
<strong>Üzenet tárgya:</strong> <?=$form['contact_subject']?><br>
<br>
<strong>Üzenet tartalma:</strong><br>
<?=$form['contact_msg']?>
<br><br>
<strong>A feladónak az adminisztrációs felületen keresztül válaszolhat:  <a href="<?=$adminroot?>uzenetek/msg/<?=$msgid?>"><?=$adminroot?>uzenetek/msg/<?=$msgid?></a></strong>
<? require "footer.php"; ?>