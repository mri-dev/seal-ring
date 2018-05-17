function PickPack(){
			this.showPointData = function(data_obj){
				var mapkey = '';
				$('#ppp_point_data_nev').text(data_obj.uzlet_nev);
				$('#ppp_point_data_address').html('<div style="line-height:17px;">'+data_obj.megye+' / '+data_obj.iranyitoszam+' '+data_obj.varos+', '+data_obj.cim+'</div><br>');
				$('#ppp_point_data_desc').html('<div style="color:#fefa1e; line-height:17px;">'+data_obj.leiras+'</div>');
				$('#ppp_point_data_type').html('<br><div style="line-height:17px;"><strong>Bankkártyás fizetés: </strong><span style="color:#fefa1e;">'+((data_obj.fizetes_bankkartya == '1')?'Van':'Nincs')+'</span><br>'+'<strong>Típus: </strong><span style="color:#fefa1e;">'+data_obj.tipus+'</span></div>');
				var openStr = '<strong>Nyitvatartás:</strong><div class="nyitvatartas">';
				var opens = $.parseJSON(data_obj.nyitvatartas);
				
				$.each(opens,function(i,v){
					openStr += '<div class="row np" style="color:#fefa1e;"><div class="col-md-6">'+i+':</div><div class="col-md-6"> '+v[0]+"</div></div>";	
				});
				openStr += '</div>';
				$('#ppp_point_data_open').html(openStr);
				$('#ppp_point_mapimg').attr('src','http://maps.google.com/maps/api/staticmap?center='+data_obj.gps_lat+','+data_obj.gps_lng+'&zoom=16&size=235x235&maptype=roadmap&sensor=false&language=hu_HU&markers=color:red|label:none|'+data_obj.gps_lat+','+data_obj.gps_lng);
				$('.pickpackpont .atvetelAdat').css({display:'block'});
			}
			this.trigger = function(megye, varos, uzlet){
				var $parent 		= this;
				var megyeTrigged 	= false;
				var varosTrigged 	= false;
				var uzletTrigged 	= false;
				console.log(megye+"  "+varos+"  "+uzlet);
				// Megye trigger
				if(typeof megye !== 'undefined' && megye != ''){
					$('select[name=ppp_megye] option').each(function(i,e){
						
						if($(this).val() == megye){
							$(this).prop('selected',true);
							megyeTrigged = true;
							$parent.getCities(megye, function(data){
								$('select[name=ppp_varos]').attr('disabled',false).focus();
								$('select[name=ppp_uzlet]').attr('disabled',true);
								$('.pickpackpont .atvetelAdat').css({display:'none'});
								var data = $.parseJSON(data);
								
								$('select[name=ppp_uzlet] option').remove();
								$('<option value="">-- válasszon várost --</option>').appendTo('select[name=ppp_uzlet]');
								
								$('select[name=ppp_varos] option').remove();
								$('<option value="">-- válasszon várost --</option>').appendTo('select[name=ppp_varos]');
								$('<option value="" disabled>').appendTo('select[name=ppp_varos]');
								$.each(data,function(index, value){
									$('<option value="'+value+'">'+value+'</option>').appendTo('select[name=ppp_varos]');
								});
								triggerCity();	
							});
						}
					});
				}
				
				// Város trigger
				function triggerCity(){
					if(typeof varos !== 'undefined' && varos != '' && megyeTrigged){
						$('select[name=ppp_varos] option').each(function(i,e){
							if($(this).val() == varos){
								$(this).prop('selected',true);
								varosTrigged = true;
								
								$parent.getPoints(megye, varos, function(data){
									var data = $.parseJSON(data);
									$('select[name=ppp_uzlet]').attr('disabled',false).focus();
									$('.pickpackpont .atvetelAdat').css({display:'none'});
									$('select[name=ppp_uzlet] option').remove();
									$('<option value="">-- válasszon átvételi pontot --</option>').appendTo('select[name=ppp_uzlet]');
									$('<option value="" disabled>').appendTo('select[name=ppp_uzlet]');
									$.each(data,function(index, value){
										
										$('<option value="'+value.ppp_uzlet_kod+'">'+value.tipus+" - "+value.cim+'</option>').appendTo('select[name=ppp_uzlet]');	
									});
									triggerPoint();
								});
							}
						});					
					}
				}
				
				// Hely trigger
				function triggerPoint(){
					if(typeof uzlet !== 'undefined' && uzlet != '' && megyeTrigged && varosTrigged){
						$('select[name=ppp_uzlet] option').each(function(i,e){
							if($(this).val() == uzlet){
								$(this).prop('selected',true);
								uzletTrigged = true;
								
								$parent.getPointData(uzlet, function(data){
									var data = $.parseJSON(data);
									$parent.showPointData(data);
								});
							}
						});					
					}
				}
				
				
			}
			this.getCities = function(megye, callback){
				$.post('/ajax/get',{
					type : 'pickpackpont',
					mode : 'getCities',
					arg  : {
						megye : megye	
					}
				},function(d){
					callback(d);
				},"html");
			}
			this.getPoints = function(megye, varos, callback){
				$.post('/ajax/get',{
					type : 'pickpackpont',
					mode : 'getPoints',
					arg  : {
						megye : megye,
						varos : varos	
					}
				},function(d){
					callback(d);
				},"html");
			}
			this.getPointData = function(uzlet_id, callback){
				$.post('/ajax/get',{
					type : 'pickpackpont',
					mode : 'getPointData',
					arg  : {
						id : uzlet_id	
					}
				},function(d){
					callback(d);
				},"html");
			}
			
		}
		var PickPack = new PickPack();