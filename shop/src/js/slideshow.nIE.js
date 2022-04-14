$(function(){
		$('#slides').slides({
			play: parseInt('<?=$this->ss_info[play]?>'),
			slideSpeed : parseInt('<?=$this->ss_info[pause]?>'),
			effect: '<?=$this->ss_info[effect]?>',
			hoverPause: true,
			crossfade: true,
			pause: 2000,
			animationStart: function(current){
				$('.caption').animate({
					bottom:-40
				},100);
				$('.description').animate({
					top:-285
				},100);
				if (window.console && console.log) {
					// example return of current slide number
					console.log('animationStart on slide: ', current);
				};
			},
			animationComplete: function(current){
				$('.caption').animate({
					bottom:0
				},200);
				$('.description').animate({
					top:0
				},200);
				if (window.console && console.log) {
					// example return of current slide number
					console.log('animationComplete on slide: ', current);
				};
			},
			slidesLoaded: function() {
				$('.caption').animate({
					bottom:0
				},200);
				$('.description').animate({
					top:0
				},200);
			}
		});
	});