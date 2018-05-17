(function($){
	$.fn.sliders = function(arg){
		var settings = $.extend({
			speed : 3500,
			slideSpeed:1000,
			clickSlideSpeed: 200,
			restartSpeed: 5000,
			itemKey : '.item',
			stacked : false,
			stackedBy : false
		},arg); 
		function getContentWidth(){
			return $('#slideShow').width();	
		}
		function getItemWidth(e){
			return e.find(settings.itemKey).width();
		}
		function getItemNum(e){
			return e.find(settings.itemKey).length;
		}
		function sliding(e, ilength, start, step, key, walk, width, slideSpeed){
			var mPad = (walk * (width+4) * step) * -1;
			e.find('.sliderContent').animate({
				left : mPad+"px"	
			},slideSpeed);			
		}
		function navigateTo(goTo){
			clearInterval(timer);
			walk = goTo;
			sliding(e, itemLength, start, step, key, goTo, itemWidth, settings.clickSlideSpeed);
			restarSlider(settings.restartSpeed);			
		}
		function getCurrentPosition(){
			var pos = walk + 1;
			var maxi = itemLength - start;
			return maxi - pos;
		}
			var navKey = 0; 
			var restart = 0;
			var timer = 0;
			var stackSize = 0;
			var dataSet = $(this).attr('dataSet');
			var key 	= $(this).attr('key');
			var start 	= parseInt($(this).attr('start'));
			var step 	= parseInt($(this).attr('step'));
			var walk 	= 0;
			
			var itemLength 	= getItemNum($(this));
			var itemWidth 	= getItemWidth($(this));
			var e 			= $(this);
			var isHovered 	= false;
		
			if(typeof key === 'string'){
				if((itemLength - start) <= 0){
					$('.slider-btn-'+key).css({
						visibility : 'hidden'	
					});
				}
				
				// Navigáció vissza
				$('.slider-btn-'+key).find('div.prev').click(function(){
					if(navKey == 0){
						navKey = 0;	
					}else{
						navKey--;
					}
					navigateTo(navKey);
				});	
				// Navigáció előre
				$('.slider-btn-'+key).find('div.next').click(function(){
					if(navKey == 0){
						navKey = walk+1;	
					}else if(getCurrentPosition() >= 0){
						navKey++;
					}
					navigateTo(navKey);
				});		
			}
			
			if(settings.stacked){
				stackSize = getContentWidth() - $('.slider[key='+settings.stackedBy+']').width() - 8;
				$(this).css({
					maxWidth : stackSize+'px'	
				});
			}
						
			if(itemLength > start){
				if(timer != 0){
					clearInterval(timer);	
				}
				
				startSlide();
			}
		function restarSlider(delay){
			clearInterval(restart);	
			restart = setTimeout(function(){
				startSlide();
			},delay);
		}
		function startSlide(){
			timer = setInterval(function(){
				walk++;
				navKey = walk;
				sliding(e, itemLength, start, step, key, walk, itemWidth, settings.slideSpeed);
				if((itemLength - start) == walk){
					walk = -1;
				}
			},settings.speed);
		}
		return this;
		
	}
}(jQuery));