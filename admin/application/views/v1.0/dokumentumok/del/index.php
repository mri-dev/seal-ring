<div class="con con-del">
	<h2>Fájl törlése a szerverről</h2>
	<div>
		<strong style="color:black;"><?=$this->file['cim']?></strong> <em>(<?=$this->file['filepath']?>)</em> fájlt véglegesen törölni kívánja a szerverről?
		<form method="post" action="">
			<input type="hidden" name="id" value="<?=$this->file['ID']?>">
			<input type="hidden" name="file" value="<?=$this->file['filepath']?>">
			<div class="divider" style="margin:8px 0;"></div>
			<div class="right">
				<a href="/dokumentumok" class="btn btn-danger"><i class="fa fa-times"></i> mégse</a>
				<button class="btn btn-success" name="deleteFile" value="1">Végleges törlés <i class="fa fa-trash"></i></button>
			</div>
		</form>
	</div>
</div>