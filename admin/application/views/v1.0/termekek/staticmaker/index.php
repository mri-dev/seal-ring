<h1>Dinamikusan betöltődő adatkezelő</h1>
<p>Ezzel a funkcióval létrehozhat olyan termékcsoport jellemzőt (pl.: leírás), amit a rendszer dinaimusan be tud tölteni.</p>

<?php if(count($this->languages) > 1): ?>
<h4>Nyelv kiválasztása</h4>
<?php foreach((array)$this->languages as $langkey => $lang): 
  $selected = ( (!isset($_COOKIE['langedit']) && $langkey == DLANG ) || $_COOKIE['langedit'] == $langkey) ? true : false;
  ?>
  <a href="/termekek/staticmaker?changelang=<?=$langkey?>" class="btn <?=(!$selected)?'btn-default':'btn-warning'?>"><?=$lang['title']?></a>
<?php endforeach; ?>
<br><br>
<?php endif; ?>

<h2><strong>Kulcsszavak frissítése</strong></h2>
<p>
  Az FTP-n feltöltött kulcsszó állományokból frissíti a rendszer a termék csoport azonosító alapján a kulcsszavakat. Az állomány neve <strong>termék csoport azonosító.txt</strong>. Pl.: <strong>ONBR70.txt</strong>. A kulcsszavakat simán, egymás után, vesszővel elválasztva írja az állományba.
</p>
<form action="" method="post">
  <button class="btn btn-primary btn-md" name="updateKeywords" value="1" type="submit"><i class="fa fa-refresh"></i> Kulcsszavak frissítése</button>
  <?php if( $this->keywordmsg ): ?>
    <br><br>
  <div class="alert alert-success"><?=$this->keywordmsg?></div>
  <?php endif; ?>
</form>
<br>
<h2><strong>Termékcsoport leírások</strong></h2>
<div class="row dinamicmaker np">
  <div class="col-md-8">
    <div class="con">
      <?php if(!empty($this->editor['group'])): ?>
      <h3>Állomány módosítása</h3>
      <?php else: ?>
      <h3>Leírás készítés</h3>
      <?php endif; ?>
      <form action="" method="post">
        <label for="">Termék csoport azonosító</label>
        <input type="text" name="group" class="form-control" value="<?=$this->editor['group']?>" placeholder="Pl.: ONBR70">
        <br>
        <label for="">Állomány tartalma</label>
        <textarea name="content"><?=$this->editor['content']?></textarea>
        <br>
        <?php if(empty($this->editor['group'])): ?>
          <button class="btn btn-success btn-md" name="createDesc" value="1" type="submit"><i class="fa fa-plus-circle"></i> Állomány létrehozása</button>
        <?php else: ?>
          <a href="/termekek/staticmaker" class="btn btn-default">Mégse</a>
          <button class="btn btn-warning btn-md" name="createDesc" value="1" type="submit"><i class="fa fa-save"></i> Állomány módosítása</button>
        <?php endif; ?>
      </form>
    </div>
  </div>
  <div class="col-md-4">
    <div class="con" style="margin: 0 10px;">
      <h3>Állományok [<?=$this->lang?>]</h3>
      <div class="files">
        <?php if($this->files): ?>
          <?php foreach((array)$this->files as $f): ?>
          <div class="file"><a title="Állomány szerkesztése" href="<?=DOMAIN?>termekek/staticmaker/?edit=<?=$f['name']?>"><strong><?=$f['name']?></strong> (<?=$f['ido']?>)</a> <a class="view" href="<?=DOMAIN.$f['src']?>" target="_blank" title="Állomány megtekintése új ablakban"><i class="fa fa-external-link"></i></a></div>
          <?php endforeach; ?>
        <?php else: ?>
          Nincsenek létrehozva állományok.
        <?php endif; ?>
      </div>
    </div>   
  </div>
</div>
