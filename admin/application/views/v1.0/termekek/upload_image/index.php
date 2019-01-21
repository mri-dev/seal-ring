<h1>Termékképek feltöltés</h1>
<?=$this->msg?>
<div class="con" style="color:green;">
	<strong><?=count($this->ids)?> db</strong> kiválasztott termék, ahol le lesznek cserélve a termékképek az újonnan feltöltött képekre!
</div>
<div class="con" style="color:red;">
	Figyelem! Feltöltés után a kiválasztott termékekről a korábbi képeket lecsatolja a rendszer és az új képek lesznek helyettük!
</div>
<? if ( count($this->ids) > 0 ): ?>
	<div class="con">
		<h3>Képek kiválasztása a feltöltéshez</h3>
		<form action="" method="post" enctype="multipart/form-data">
			<input type="file" name="img[]" multiple="multiple">	
			<br>	
			<button class="btn btn-success" name="upload" value="1">Feltöltés és frissítés</button>	
		</form>
	</div>
<? endif; ?>