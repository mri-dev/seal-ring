<h1>Nyelvi beállítások</h1>

<div class="tbl-container overflowed">
  <table class="table termeklista table-bordered">
    <thead>
      <tr>
        <th>Nyelv</th>
        <th>Nyelvi kulcs</th>
        <th>Valuta / Pénznem</th>
        <th>Egység valuta ára (ft)</th>
        <th>Állapot</th>
        <th>Sorrend</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach((array)$this->languages as $lang ): ?>
      <tr>
        <td>
          <img width="20" src="<?=IMG?>flags/<?=$lang['langkey']?>.gif" alt="<?=strtoupper($lang['langkey'])?>"> <strong><a href="/beallitasok/nyelvek/?editor=<?=$lang['langkey']?>"><?=$lang['title']?></a></strong>
        </td>
        <td>
         <?=strtoupper($lang['langkey'])?>
        </td>
        <td class="center"><?=strtoupper($lang['valuta'])?></td>
        <td class="center">1 <?=strtoupper($lang['valuta'])?> = <?=$lang['changes']?> Ft</td>
        <td class="center"><?=($lang['active'] == '1')?'AKTÍV':'INAKTÍV'?></td>
        <td class="center"><?=$lang['sorrend']?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php if( isset($this->editor) && $this->editor ): ?>
  <br>
  <h2><u><strong><?=$this->editor['lang']['title']?></strong></u> nyelvi beállítások:</h2>
  <br>
  <form action="" method="post">
  <div class="con">
    <div class="row">
      <div class="col-md-5">
        <label for="">Nyelv</label>
        <input type="text" name="lang['title']" class="form-control" value="<?=$this->editor['lang']['title']?>">
      </div>
      <div class="col-md-2">
        <label for="">Nyelvi kulcs (<a href="https://www.science.co.il/language/Codes.php" target="_blank">Code 2 kulcsok</a>)</label>
        <input type="text" readonly name="lang['langkey']" class="form-control" value="<?=$this->editor['lang']['langkey']?>">
      </div>
      <div class="col-md-2">
        <label for="">Pénznem / Valuta</label>
        <input type="text" name="lang['valuta']" class="form-control" value="<?=$this->editor['lang']['valuta']?>">
      </div>      
      <div class="col-md-2">
        <label for="">Egység valuta ára (Ft)</label>
        <input type="text" name="lang['changes']" class="form-control" value="<?=$this->editor['lang']['changes']?>">
      </div>     
      <div class="col-md-1">
        <label for="">Aktív</label>
        <input type="checkbox" name="lang['active']" class="form-control" <?=($this->editor['lang']['active'] != '1')?'':'checked="checked"'?> value="1">
      </div>   
    </div>
  </div>
  <br>
  <h3>Szöveges fordítások</h3>
  <div class="con" style="margin-bottom: 100px;">
    <a href="javascript:void(0);" onclick="addnewline()">+ nyelvi érték</a>
    <div class="language-text-editor">
      <?php $list = array_reverse($this->editor['translates']); ?>
      <?php foreach( $list as $key => $value): if( $key == '' )continue; ?>
      <div class="line">
        <div class="head"><strong><?=$key?></strong></div>
        <div class="value">
          <textarea class="no-editor form-control" name="translate[<?=$key?>]"><?=$value?></textarea>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="translate-saver">
    <button type="submit" name="saveTranslates" value="<?=$this->editor['lang']['langkey']?>">Nyelvi fájlok mentése</button>
  </div>
  </form>

  <script>
    function addnewline(){
      $('<div class="line newline"><div class="head"><strong><input type="text" class="form-control" name="new_translate_head[]" value="" placeholder="Azonosító kulcs"/></strong></div><div class="value"><textarea class="no-editor form-control" name="new_translate_value[]"></textarea></div></div>').insertBefore('.language-text-editor > .line:first-child');
    }
  </script>
<?php else: ?>
  <br>
  <div class="alert alert-info">A nyelvi szövegek szerkesztéséhez kattintson a nyelv nevére a fenti listában.</div>
<?php endif; ?>
