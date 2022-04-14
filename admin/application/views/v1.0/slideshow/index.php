<h1>Slideshow</h1>
<?=$this->msg?>
<div class="row">
	<div class="col-md-12">
        <? 
            $groups = array();
            if(count($this->ss)> 0): foreach($this->ss as $d){
                if( !in_array($d['groups'], $groups) ) {
                    $groups[] = $d['groups'];
                }
            } endif; 
        ?>
        <div class="con">
            Elemek mutatása: &nbsp;&nbsp; <a style="<?=( !isset($_GET['g']) )?'font-weight: bold; color:red;':''?>" href="/slideshow">Összes</a> | <? foreach( $groups as $g ): ?> &nbsp; <a style="<?=( isset($_GET['g']) && $_GET['g'] == $g )?'font-weight: bold; color:red;':''?>" href="/slideshow/?g=<?=$g?>"><?=$g?></a> &nbsp; <? endforeach; ?>
        </div>

    	<div class="con">
        	<form action="" method="post" enctype="multipart/form-data">
        	<h2>Új elem hozzáadása</h2>
            <br>
            <div class="row">                
                <div class="col-md-1">
                    <label for="sorrend">Sorrend:</label>
                    <input type="number" id="sorrend" class="form-control" name="sorrend" value="0" min="-100" max="100" step="1">
                </div>
                <div class="col-md-2">
                    <label for="groups">Gyűjtő csoport:</label>
                    <input type="text" id="groups" class="form-control" name="groups" value="<?=(isset($_GET['g'])) ? $_GET['g'] : 'Home'?>" >
                </div>  
                <div class="col-md-3">
                    <label for="img">Kép kiválasztása (javasolt méret: 838 x ??): </label>
                    <div class="input-group"> 
                        <input type="text" id="img" class="form-control" name="img">
                        <span class="input-group-addon">
                            <a title="Kép kiválasztása galériából" href="<?=FILE_BROWSER_IMAGE?>&field_id=img" data-fancybox-type="iframe" class="iframe-btn"><i class="fa fa-th"></i></a>
                        </span>
                    </div>
                </div>                
                <div class="col-md-4">
                    <label for="url">URL a képhez:</label>
                    <input type="text" id="url" class="form-control" name="url">
                </div>
                <div class="col-md-1" align="center">
                    <label for="lathato">Aktív: </label>
                    <input type="checkbox" class="form-control" id="lathato" name="lathato">
                </div>
            </div>
            <div class="divider" style="margin:8px 0;"></div>
            <h4>FELIRAT</h4>
            <div class="row">
                
                <div class="col-md-6">
                    <label for="focim_<?=$d['ID']?>">Főcím</label>
                    <input type="text" name="focim" id="focim_<?=$d['ID']?>" class="form-control" value="" />
                </div>
                <div class="col-md-6" style="padding-left:4px;">
                    <label for="alcim_<?=$d['ID']?>">Alcím</label>
                    <input type="text" name="alcim" id="alcim_<?=$d['ID']?>" class="form-control" value="" />
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="focim_link_text_<?=$d['ID']?>">Főcím hivatkozás felirat</label>
                    <input type="text" name="focim_link_text" placeholder="pl.: részletek" id="focim_link_text_<?=$d['ID']?>" class="form-control" value="" />
                </div>
                <div class="col-md-6" style="padding-left:4px;">
                    <label for="focim_link_<?=$d['ID']?>">Főcím hivatkozás</label>
                    <input type="text" name="focim_link" placeholder="pl.: http://www.example.com" id="focim_link_<?=$d['ID']?>" class="form-control" value="" />
                </div>
            </div>
            <br>
            <div class="row">    
                <div class="col-md-12 right">
                    <button name="add" class="btn btn-primary">Hozzáadás <i class="fa fa-check-square"></i></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
    	<div class="con">
        	<? if(count($this->ss)> 0): foreach($this->ss as $d): ?>
            <br />
            <div class="row">
            	<form action="" method="post">
                <input type="hidden" name="id" value="<?=$d['ID']?>" />
            	<div class="col-md-7">
                	<img src="/<?=substr($d['kep'],1)?>" alt="" style="width:100%;" class="<?=($d['lathato'] == '1')?'showed':''?>" />
                </div>
                <div class="col-md-5">
                    <div class="row np">
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="group">Gyűjtő csoport</label>
                                <input type="text" name="groups" id="group" class="form-control" value="<?=$d['groups']?>" />
                            </div>
                        </div>
                        <div class="col-md-7" style="padding-left:5px;">
                            <div class="form-group">
                                <label for="url">Kép URL link</label>
                                <input type="text" name="url" id="url" class="form-control" value="<?=$d['url']?>" />
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-left:5px;">
                            <div class="form-group">
                                <label for="sorrend">Sorrend</label>
                                <input type="number" name="sorrend" id="sorrend" class="form-control" value="<?=$d['sorrend']?>" min="-100" max="100"  />
                            </div>
                        </div>
                    </div>

                    <label for="img_<?=$d['ID']?>">Kép</label>
                    <div class="input-group"> 
                        <input type="text" id="img_<?=$d['ID']?>" class="form-control" name="img" value="<?=$d['kep']?>">
                        <span class="input-group-addon">
                            <a title="Kép kiválasztása galériából" href="<?=FILE_BROWSER_IMAGE?>&field_id=img_<?=$d['ID']?>" data-fancybox-type="iframe" class="iframe-btn"><i class="fa fa-th"></i></a>
                        </span>
                    </div>                    
                    <div>
                        <? $imgs = getimagesize(substr($d['kep'],1)); ?>
                        Kép méretei: <strong><?=$imgs['0'].' x '.$imgs['1']?></strong>
                    </div>
                    <div class="divider" style="margin:8px 0;"></div>
                    <h3>FELIRAT</h3>
                    <div class="row np">
                        <div class="col-md-6">
                            <label for="focim_<?=$d['ID']?>">Főcím</label>
                            <input type="text" name="focim" id="focim_<?=$d['ID']?>" class="form-control" value="<?=$d['focim']?>" />
                        </div>
                        <div class="col-md-6" style="padding-left:4px;">
                            <label for="alcim_<?=$d['ID']?>">Alcím</label>
                            <input type="text" name="alcim" id="alcim_<?=$d['ID']?>" class="form-control" value="<?=$d['alcim']?>" />
                        </div>
                    </div>
                    <br>
                    <div class="row np">
                        <div class="col-md-6">
                            <label for="focim_link_text_<?=$d['ID']?>">Főcím hivatkozás felirat</label>
                            <input type="text" name="focim_link_text" placeholder="pl.: részletek" id="focim_link_text_<?=$d['ID']?>" class="form-control" value="<?=$d['focim_link_text']?>" />
                        </div>
                        <div class="col-md-6" style="padding-left:4px;">
                            <label for="focim_link_<?=$d['ID']?>">Főcím hivatkozás</label>
                            <input type="text" name="focim_link" placeholder="pl.: http://www.example.com" id="focim_link_<?=$d['ID']?>" class="form-control" value="<?=$d['focim_link']?>" />
                        </div>
                    </div>
                    <div class="divider" style="margin:8px 0;"></div>
                    <div class="form-group">
                        <label for="sorrend">Látható</label>
                        <input type="checkbox" name="lathato" id="lathato" style="width:25px;" class="form-control" <?=($d['lathato'] == '1')?'checked':''?> />
                    </div>
                    <div align="right">
                    	
                    	<button name="save" type="submit" value="1" class="btn btn-success">Mentés <i class="fa fa-check"></i></button>
                    </div>
                </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?=$d['ID']?>" />
                    <input type="hidden" name="img" value="<?=$d['kep']?>" />
                    <button name="delete" value="1"  class="btn btn-danger btn-sm">Törlés <i class="fa fa-times"></i></button>
                </form>
                </div>
            </div>
            <? endforeach; else:?>
            	<div class="noItem">
                	Nincs feltöltött reklámanyag!
                </div>
            <? endif; ?>
            
        </div>
    </div>
</div>