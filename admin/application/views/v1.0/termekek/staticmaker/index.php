<h1>Dinamikusan betöltődő adat létrehozó</h1>
<p>Ezzel a funkcióval létrehozhat olyan termékcsoport jellemzőt (pl.: leírás), amit a rendszer dinaimusan be tud tölteni.</p>
<br>
<h2><strong>Termékcsoport leírások</strong></h2>
<div class="row dinamicmaker">
  <div class="col-md-8">
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
  <div class="col-md-4">
   <h3>Állományok</h3>
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
