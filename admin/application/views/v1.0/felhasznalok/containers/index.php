<div style="float:right;">
    <a href="/felhasznalok/container_new" class="btn btn-primary"><i class="fa fa-plus"></i> új kör</a>
</div>
<h1>Felhasználói körök</h1>
<?=$this->msg?>
<div class="user-containers">
	<table class="table termeklista table-bordered">
		<thead>
	    	<tr>
				<th title="Konténer ID" width="40">#</th>
		        <th>Konténer elnevezés</th>
		        <th width="200">Tagok száma</th>
	            <th width="20"></th>
	        </tr>
		</thead>
	    <tbody>
	    	<? if($this->containers): foreach($this->containers as $d):  ?>
	    	<tr>
		    	<td align="center"><?=$d[ID]?></td>
		        <td>
	          		<strong><?=$d[nev]?></strong>
	            </td>   
	            <td class="center">
	            	<a href="javascript:void(0);" class="userToggler" mid="<?=$d[ID]?>"><?=$d[users_in]?> db</a>
	            </td>         
	            <td class="center">
	                <div class="dropdown">               
	                    <i class="fa fa-gear dropdown-toggle" title="Beállítások" id="dm<?=$d['ID']?>" data-toggle="dropdown"></i>
	                      <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$d['ID']?>">  
	                        <li role="presentation"><a role="menuitem" tabindex="-1" href="/felhasznalok/container_edit/<?=$d['ID']?>">Szerkesztés <i class="fa fa-pencil"></i></a></li>
	                        <li role="presentation"><a role="menuitem" tabindex="-1" href="/felhasznalok/container_del/<?=$d['ID']?>">törlés <i class="fa fa-trash"></i></a></li>
	                      </ul>
	                </div>
	            </td>
	        </tr>
	        <tr class="oInfo<?=($_GET[s] != $d[ID])?'':' opened'?>" id="oid_<?=$d[ID]?>" style="<?=($_GET[s] != $d[ID])?'display:none;':''?>">
	        	<td colspan="4" style="background: #908F8F;">
	        		<div class="user-list">
		        		<div class="con adder">
		        			<h3>Új felhasználó hozzáadása</h3>
		        			<div class="row">
		        				<form method="post" action="/felhasznalok/containers/?s=<?=$d[ID]?>">
		        					<input type="hidden" name="container" value="<?=$d[ID]?>">
			        				<div class="col-sm-10">
			        					<input type="text" class="form-control userReceiver" cid="<?=$d[ID]?>" placeholder="Felhasználó keresése név vagy email szerint...">
			        					<div class="userReceiver-list" id="userReceiver_list<?=$d[ID]?>"></div>
			        				</div>
			        				<div class="col-sm-1">
			        					<input type="text" name="user_id" id="adder_<?=$d[ID]?>_uid" class="form-control" placeholder="ID">
			        				</div>
			        				<div class="col-sm-1 right">
			        					<button class="btn btn-success">Hozzáadás <i class="fa fa-plus"></i></button>
			        				</div>
		        				</form>
		        			</div>
		        		</div>
		        		<? if($d['users_in'] == 0): ?>
		        			<div class="noItem" style="color: #444;">Nincsenek felhasználók sorolva ebbe a konténerbe.</div> 
		        		<? else: ?>
		        			<table class="table table-bordered" style="margin: 0; font-size: 0.9em;">
								<thead>
							    	<tr>
										<th title="Felhasználó ID" width="40">#</th>
								        <th>Felhasználó neve</th>
								        <th>E-mail cím</th>
							            <th width="20"></th>
							        </tr>
								</thead>
							    <tbody>
							    	<? foreach($d[user_list] as $u):  ?>
							    	<tr>
								    	<td align="center"><?=$u[ID]?></td>
								        <td>
							          		<strong><?=$u[nev]?></strong>
							            </td>   
							            <td>
							            	<?=$u[email]?>
							            </td>         
							            <td class="center">
							                <div class="dropdown">               
							                    <i class="fa fa-gear dropdown-toggle" title="Beállítások" id="dm<?=$u['ID']?>" data-toggle="dropdown"></i>
							                      <ul class="dropdown-menu" role="menu" aria-labelledby="dm<?=$u['ID']?>">  
							                        <li role="presentation"><a role="menuitem" tabindex="-1" href="/felhasznalok/containers/?t=delete_user&uid=<?=$u['ID']?>&cid=<?=$d[ID]?>">törlés <i class="fa fa-trash"></i></a></li>
							                      </ul>
							                </div>
							            </td>
							        </tr>
							        <? endforeach; ?>
							    </tbody>
							</table>
		        		<? endif; ?>
	        		</div>
	        	</td>
	        </tr>
	        <? endforeach; else: ?>
	        <tr>
		    	<td colspan="15" align="center">
	            	<div style="padding:25px;">Nincs találat!</div>
	            </td>
	        </tr>
	        <? endif; ?>
	    </tbody>
	</table>
</div>
<script type="text/javascript">
    $(function(){
        $('.userToggler[mid]').click(function(){
            var e = $(this);
            var id = e.attr('mid');
            
            $('.oInfo').hide(0);
            $('.o').removeClass('opened');
            
            $('#o_'+id).addClass('opened');
            $('#oid_'+id).show(0);
        }); 

        $('.userReceiver').bind('keyup', function(){
        	var src = $(this).val();
        	var cid = $(this).attr('cid');
        	var ct  = $('#userReceiver_list'+cid);

        	$.post('<?=AJAX_POST?>', {
        		type : 'searchUsers',
        		search: src
        	}, function(d){
        		if( d.num < 25 ) {
        			var ins = '';
	        		$.each( d.data, function(i, e) {
	        			ins += '<div onclick="saveReceiver('+cid+','+e.ID+')" class="each">';
	        			ins += '<span class="name">'+e.nev+'</span>';
	        			ins += '<span class="email"> ('+e.email+') </span>';
	        			ins += '</div>';
	        		});

	        		ct.html(ins);
        		} else {
        			ct.html("");
        		}
        	}, "json");
			       	
        });

         
    })

	function saveReceiver( cid, id ){
		$('#adder_'+cid+'_uid').val(id);
    }
</script>