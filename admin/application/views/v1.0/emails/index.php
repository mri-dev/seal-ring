<h1>E-mail sablonok</h1>
<?=$this->msg?>
<table class="table termeklista table-bordered">
	<thead>
    	<tr>
			<th width="200">Azonosító</th>	   
			<th>Elnevezés</th>    
			<th><i class="fa fa-gear"></i></th>   
        </tr>
	</thead>
    <tbody>
	<? 	
		foreach( $this->mails as $mail ): 
	?>
    	<tr>
	    	<td class="center"><?=$mail['elnevezes']?></td>
	    	<td><strong><?=$mail['cim']?></strong></td>	    	
	    	<td align="center">
	            <a role="menuitem" tabindex="-1" href="/emails/edit/<?=$mail['elnevezes']?>" title="Szerkesztés"><i class="fa fa-pencil"></i></a>
            </td>
        </tr> 
    <? 	endforeach; ?>           	
    </tbody>
</table>