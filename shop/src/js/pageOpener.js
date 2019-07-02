(function($){
	$.fn.openPage = function(arg){
		var settings = $.extend({
			overlayed 	: false,
			path 		: '/ajax/box/',
			fill 		: false
		},arg);

		init = function($box){
			var $container 	= false;

			$box.click(function(e){
				createContainer($box);
			});


			$(document).keyup(function(e){
				if(e.keyCode === 27){
					if(containerCreated()){
						removeContainer();
					}
				}
			});

			createContainer = function($box){
				var classString = 'dialogBox';
				if(!containerCreated()){
					if(settings.overlayed){
						classString += ' overlayed';
					}

					//Specify box content WIDTH with parameter: jwidth
					var fix_width 	= $($box[0]).attr('jwidth');
					fix_width 		= (typeof fix_width !== 'undefined') ? fix_width : false;

					//Specify box content HEIGHT with parameter: jheight
					var fix_height 	= $($box[0]).attr('jheight');
					fix_height 		= (typeof fix_height !== 'undefined') ? fix_height : false;

					$('<div class="'+classString+'"><div class="content" style="'+( (fix_width) ? 'width:'+fix_width+'px;'  : '' )+''+( (fix_height) ? 'height:'+fix_height+'px; margin-top:-'+(fix_height/2)+'px;'  : '' )+'"><span class="exit"><i class="fa fa-times"></i></span><i class="fa fa-spinner fa-spin"></i><div class="c"></div></div></div>').prependTo('body');
					$container = $('div.dialogBox');

					loadContent($box,settings,function(d){
						setContainer(d);
						recalcSizes($box);
					});

					$container.find('span.exit').click(function(){
						removeContainer();
					});


				}
			}
			setContainer = function(data){
				$container.find('.content .c').html(data);

				$container.find('*[fill]').click(function(){
					setUnloaded();
					loadContent($box,{
						type : $(this).attr('fill')
					},function(d){
						setContainer(d);
						recalcSizes($box);
						setLoaded();
					});
				});

				setLoaded();
			}
			setLoaded = function(){
				$container.find('i[class*=fa-spin]').addClass('loaded');
			}
			setUnloaded = function(){
				$container.find('i[class*=fa-spin]').removeClass('loaded');
			}
			recalcSizes = function($box){
				var e 		= $container.find('.content');
				var height 	= e.height();

				/*e.css({
					marginTop: '-'+(height/2)+'px'
				});*/

			}
			containerCreated = function(){
				if($container){
					return true;
				}else{
					return false;
				}
			}
			removeContainer = function(){
				$container.remove();
				$container = false;
			}
			loadContent = function($box,arg,callback){
				var page = settings.path;
				var attr = {
					type : $box.attr('jOpen')
				};

				$.each($box[0].attributes,function(){
					if(this.specified){
						if(this.name != 'type'){
							attr[this.name] = this.value;
						}
					}
				});

				var iarg = $.extend(attr,arg);

				if($box.attr('jOpen') == ''){
					removeContainer();
					return false;
				}
				$.post(
					page,
					iarg,
					function(d){
						callback(d);
					},
					"html"
				);
			}
		}

		return this.each(function(){
			var $box = $(this);
			init($box);
		});
	}
}(jQuery));
