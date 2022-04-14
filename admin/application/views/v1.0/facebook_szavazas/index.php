<h1>Facebook szavazás</h1>
<?=$this->rmsg?>
<div class="row np votes">
	<div class="col-md-4">
		<div style="float:right;">
			<button class="btn btn-sm btn-primary" onclick="$('#add_vote').slideToggle(200);"> <i class="fa fa-plus"></i> új szavazás</button>
		</div>
		<h3>Szavazások</h3>
		<div style="display:none;" class="con" id="add_vote">
			<form action="" method="post">
				<h4>Új szavazás létrehozása</h4>
				<div class="row">
					<div class="col-md-3 input-head">
						<strong>Megnevezés</strong>
					</div>
					<div class="col-md-9">
						<input type="text" name="name" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 input-head">
						<strong>Induljon</strong>
					</div>
					<div class="col-md-5">
						<input type="date" name="time['start']" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 input-head">
						<strong>Befejeződjön</strong>
					</div>
					<div class="col-md-5">
						<input type="date" name="time['end']" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 right">
						<button name="createVote" value="1" class="btn btn-sm btn-success">Létrehozás <i class="fa fa-arrow-right"></i></button>
					</div>
				</div>
			</form>
		</div>
		<div class="con">
			<table class="table termeklista vote-list table-bordered" style="margin:0;">
				<thead>
					<tr>
						<th>Megnevezés</th>
						<th>Statisztika</th>
						<th>Aktív időintervallum</th>
						<th>I/O</th>
					</tr>
				</thead>
				<tbody>
					<? if( count($this->votes) > 0 ): foreach( $this->votes as $v ): ?>
					<tr>
						<td><a href="/facebook_szavazas/edit/<?=$v['ID']?>"><?=$v['name']?></a><?=($this->gets['2'] == $v['ID'] && $this->gets['1'] == 'edit')?'<div style="color:red; font-size:10px;">(szerkesztés alatt)</div>':''?> </td>
						<td class="center">
							<a href="/facebook_szavazas/stat/<?=$v['ID']?>"><i class="fa fa-pie-chart"></i></a>							
						</td>
						<td class="center"><?=$v['interval_str']?></td>
						<td class="center"><?=($v['active'] == '0')?'<i class="fa fa-times" title="Inaktív">':'<i class="fa fa-check" title="Aktív">'?></td>
					</tr>
					<? endforeach; else: ?>
					<tr>
						<td colspan="5" style="text-align:center;">
							<div class="no-items">Nincsennek szavazások!</div>
						</td>
					</tr>
					<? endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-8">
		<? 
		// Statisztika
		if($this->gets['1'] == 'stat'): ?>
			<div style="float:left; margin-left:25px;">
				<a title='vissza' href="/facebook_szavazas/" class="btn btn-default btn-sm"><i class="fa fa-level-down fa-rotate-90"></i></a>
				<a title='szerkesztő nézet' href="/facebook_szavazas/edit/<?=$this->gets['2']?>" class="btn btn-default btn-sm">szerkesztés <i class="fa fa-gear"></i></a>
			</div>
			<h2 style="text-align:center;"><?=$this->vote['data']['name']?></h2>
			<h4 style="text-align:center;">szavazás statisztika</h4>
			<div class="con vote-edit" style="margin-left:25px;">
				<div class="questions stat">
					<div class="info">
						<div class="row">
							<div class="col-md-3">
								<div class="in">
									<div class="num"><?=$this->vote['stat']['total_voter']?></div>
									<div class="legend">szavazó összesen</div>	
								</div>								
							</div>
						</div>						
					</div>
				<? foreach ( $this->vote['questions'] as $question ) { ?>
					<div class="question">
						<div class="row">
							<div class="col-md-12 center">
								<?
								$total_vote = 0;

								if( is_array($question['stat']['items']) )
								foreach($question['stat']['items'] as $qi){
									if(is_array($qi))
									if( $qi['vote_num'] > 0){
										$total_vote += $qi['vote_num'];
									}
								}
								?>
								<h4><?=$question['question']?></h4>
								<div class="item-type-hint">
									<?
									switch($question['item_type']) {
										case 'radio':
											echo 'Egy érték kiválasztós kérdés. Típus: radio';
										break;
										case 'text':
											echo 'Érték megadós kérdés. Típus: input - textarea';
										break;
										case 'checkbox':
											echo 'Több érték kiválasztós kérdés. Típus: checkbox';
										break;
									}
									?>									
								</div>
								<? if($question['item_type'] == 'text'): ?>
								<div class="vote-num"><?=count($question['stat']['items'])?> megadott érték</div>
								<? else: ?>
								<div class="vote-num"><?=$total_vote?> érték alapján</div>
								<? endif; ?>

								<? if($question['item_type'] != 'text'): ?>
								<script>									
									 google.setOnLoadCallback(showChart<?=$question['hashkey']?>);
     								 function showChart<?=$question['hashkey']?>() {

     								 	var data = google.visualization.arrayToDataTable([
     								 		["",""],
     								 		<? foreach($question['stat']['items'] as $qi): ?>
 								 			["<?=$qi['item_value']?>", <?=($qi['vote_num'])?$qi['vote_num']:0?>],
								       		<? endforeach; ?>
     								 		]);
     								 		
								       	var options = {
								            legend: { position: 'right' },
								            height: 300
								        };

								        var chart = new google.visualization.PieChart(document.getElementById("visual_graph_<?=$question['hashkey']?>"));
								        chart.draw(data, options);
     								 }
								</script>								
								<? endif; ?>
							</div>
						</div>
						<div class="stat row">
							<div class="col-md-12">
								<? if($question['item_type'] != 'text'): ?>
								<div id="visual_graph_<?=$question['hashkey']?>"></div>	
								<? else: ?>
								<div class="text-values" id="textvaluelist">
									
									<div class="value">
										<table style="width:100%;" class="table-bordered">
											<thead>
												<tr>
													<th class="center">Megadott érték</th>
													<th width="15%" class="center">IP</th>
													<th width="15%" class="center">Időpont</th>
												</tr>
											</thead>
											<tbody>
												<? foreach($question['stat']['items'] as $v): ?>
												<tr>
													<td><?=$v['text']?></td>
													<td class="center"><?=$v['ip']?></td>
													<td class="center"><?=$v['datetime']?></td>
												</tr>
												<? endforeach; ?>											
											</tbody>													
										</table>										
									</div>								
								</div>
								<? endif; ?>							
							</div>
						</div>
					</div>
				<? } ?>
				</div>
				
			</div>
		<? else: 
			// Szerkesztés
		?>
		<? if($this->gets['1'] != ''): ?>
		<div style="float:left; margin-left:25px;">
			<a title='vissza' href="/facebook_szavazas/" class="btn btn-default btn-sm"><i class="fa fa-level-down fa-rotate-90"></i></a>
			<a title='statisztika nézet' href="/facebook_szavazas/stat/<?=$this->gets['2']?>" class="btn btn-default btn-sm">statisztika <i class="fa fa-pie-chart"></i></a>
		</div>
		<? endif; ?>
		<h3 style="text-align:center;">Szavazás szerkesztése</h3>
		<div class="con vote-edit" style="margin-left:25px;">
		<? if( $this->vote ): ?>
			<h4>Szavazás alapadatok</h4>
			<div>
				<form method="post" action="">
				<input type="hidden" name="id" value="<?=$this->vote['data']['ID']?>">
				<div class="row">
					<div class="col-md-2 input-head">
						<strong>Megnevezés</strong>
					</div>
					<div class="col-md-4">
						<input type="text" name="name" value="<?=$this->vote['data']['name']?>" class="form-control">
					</div>
					<div class="col-md-2 input-head inline">
						<strong>Aktív?</strong>
					</div>
					<div class="col-md-4">
						<input type="checkbox" <?=($this->vote['data']['active'] == '1')?'checked="checked"':''?> name="active">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 input-head">
						<strong>Induljon</strong>
					</div>
					<div class="col-md-4">
						<input type="date" name="time_start" value="<?=substr($this->vote['data']['time_start'],0,10)?>" class="form-control">
					</div>
					<div class="col-md-2 input-head inline">
						<strong>Befejeződjön</strong>
					</div>
					<div class="col-md-4">
						<input type="date" name="time_end" value="<?=substr($this->vote['data']['time_end'],0,10)?>" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 right">
						<button name="editVotePoll" value="1" class="btn btn-sm btn-success">Alapadatok mentése <i class="fa fa-save"></i></button>
					</div>
				</div>
				</form>
			</div>
			<h4>Szavazás kérdések</h4>
			<form action="" method="post">
				<div class="questions"></div>				
				<div class="new">
					<button id="addQuestion" type="button" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> kérdés hozzáadása</button>					
				</div>
				<div class="row">
					<div class="col-md-12 right">
						<button name="createVoteQuestion" value="<?=$this->vote['data']['ID']?>" class="btn btn-success btn-sm">Szavazás kérdések mentés <i class="fa fa-save"></i></button>							
					</div>
				</div>
			</form>
		<? else: ?>
			<div class="no-items">Válassza ki a bal oldali listából a szavazást a szerkesztéshez!</div>
		<? endif; ?>			
		</div>
		<? endif;?>
	</div>
</div>
<script>
	// Load Google Visualization API
	google.load("visualization", "1.1", {packages:["corechart"]});

	function getElem(e) {
		var hashkey = e.attr('hashkey');

		var selected_type = $('.ask #type_'+hashkey).val();

		if( !selected_type ) {
			alert('Kérjük válassza ki, hogy milyen típusú elemből álljon a kérdés!');
			return false;
		}

		// Elem betöltése
		$.post('<?=AJAX_GET?>', {
			type : 'loadVotePollItem',
			item_type : selected_type,
			hash: hashkey,
			new : 1
		}, function(d){
			$('#elemlist_'+hashkey).append( d );
		},"html");
	}

	function loadQuestions( callback ) {
		$.post('<?=AJAX_GET?>', {
			type : 'loadVotePollQuestions',
			poll_id : <?=$this->vote['data']['ID']?>
		}, function(d){
			$('.questions').append( d );			
			callback();
		},"html");
	}

	function getAllQuestions() {
		$('.questions').html( '' );
		$('<div id="loader" class="center loader"> <i class="fa fa-spinner fa-spin"></i> Betöltés folyamatban...</div>').insertBefore('.questions');
		
		loadQuestions( function(){
			// Kérdés törlése
			$('.ask .del > i').click( function() {
				var c = confirm( 'Biztos, hogy törli ezt a kérdést? A művelet visszavonhatatlan!' );

				if( !c ) return false;

				var item_hash = $(this).attr('question-hash');

				$.post('<?=AJAX_POST?>', {
					type : 'votePollActions',
					mode : 'delete',
					what : 'question',
					hash : item_hash
				}, function(d){
					alert('Sikeresen töröltük a kérdést és a hozzá tartozozó elemeket.');
					getAllQuestions();
				},"html");

			});	
			$('#loader').remove();	
		} );
	}

	$(function(){

		if( '<?=$this->gets['1']?>' == 'edit'  ){
			getAllQuestions();
		}

		$('#addQuestion').click( function(){
			$.post('<?=AJAX_GET?>', {
				type : 'loadVotePollNewQuestion',
				item : ($('.questions').find('.q').size() + 1),
				new : 1 
			}, function(d){
				$('.questions').append( d );
			},"html");			
		} );

		
	})	
</script>