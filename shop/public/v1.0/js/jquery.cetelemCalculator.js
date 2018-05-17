(function($){
	$.fn.cetelemCalculator = function(arg){
		var settings = $.extend({
			path 		: '/ajax/post/',
			defaultMonth : 36,
			timeout: 5000
		},arg);
		var finish_calculation = false;
		
		init = function($box)
		{
			var attrs 		= {
				'price' : 0,
				'ownPrice' : 0
			};

			var current_index 	= 1;
			var max_index 		= 0;
			

			$.each($box[0].attributes, function()
			{
				if(this.specified){
					attrs[this.name] = this.value;
				}
			});

			attrs.price = parseInt(attrs.price);

			/*var findOwnPrice = $box.find('#ownPrice').val();

			if (typeof findOwnPrice !== 'undefined') {
				ownPrice = parseInt(findOwnPrice);
			}*/

			startCalc($box, attrs, 0);	
		}

		startCalc = function(c, attrs, ownPrice){
			preload(c);	

			attrs.ownPrice = ownPrice;

			calcPrice(c, attrs);
		}

		calcPrice = function(c, attrs)
		{
			preload(c);	
			

			attrs.type = 'cetelemCalculator';

			$.post(
				settings.path, 
				attrs, 
				function(r) {
					setResult(c, attrs, r);
				}, 
				"json"
			);	

			setInterval(function(){
				if(!finish_calculation){
					c.html('<div class="error">Nem sikerült a Cetelem kalkuláció!</div>');
					finish_calculation = true;
				}
				
			}, settings.timeout);
		}

		preload = function (c) {
			var html = '';

			// Preload
			html += "<div id=\"preload\" style='display: block;'>";
			html += "<i class=\"fa fa-spin fa-spinner\"></i> <br> Cetelem Online Hitelkalkulálás";
			html += "</div>";

			c.html(html);
		}

		setResult = function (c, attrs, results) {
			var html 	= '';
			var res 	= '';
			var fut 	= '';
			var ei 		= 0;
			var max_own_price = -1;

			current_index = ei + 1;

			html += "<span id=\"prev\"><i class=\"fa fa-angle-left\"></i></span><span id=\"next\"><i class=\"fa fa-angle-right\"></i></span>";
			html += "<div id=\"results\">";
			
			if (results.data && typeof results.data === 'object') 
			{
				finish_calculation = true;
				fut += "<ul>";

				var ins = '';

				$.each(results.data, function(i,v)
				{
					ei++;

					if (parseInt(v.maximumOwnShare) > max_own_price) {
						max_own_price = parseInt(v.maximumOwnShare);
					}
					var ownshare = parseInt(v.minimumOwnShare);

					if (parseInt(attrs.ownPrice) > 0 && parseInt(attrs.ownPrice) > ownshare ) {
						ownshare = attrs.ownPrice;
					}

					if (ownshare > max_own_price) {
						ownshare = max_own_price;
					}

					html += "<div class=\"result r"+ei+"\">";
					html += "<strong>Online áruhitel:</strong> " + "<span class=\"constuction c"+ei+" con_"+i+"\"> "+v.instalment+" Ft x "+i+"</span>" + "<div class=\"havi\">(havi törlesztőrészlet)</div>"; 
					html += "<div class=\"ownSharePrice\"><span class=\"text\">Önrész (Ft)</span> <input type=\"number\" min=\"0\" max=\""+v.maximumOwnShare+"\" id=\"ownPrice"+ei+"\" value=\""+( (ownshare) )+"\" /><button mt=\""+ei+"\"><i class=\"fa fa-refresh\"></i></button> (max. "+v.maximumOwnShare+")</div>"; 
					html += "<div class=\"futamidok\">"+ "Futamidő: <strong>"+i+" hónap</strong>" +"</div>";
					html += "</div>";					
				});

				max_index = ei;
				html += "</div>";

				c.html(html);

			} else if (results.data && typeof results.data === 'string') {
				c.html('<div class="error"><i class="fa fa-times"></i> <br>'+results.data+'</div>');
			}  else if( !results.data ){
				c.html('<div class="error">Nem sikerült a Cetelem kalkuláció!</div>');
			}
			

			c.find('#next').click(function(){
				setIndexActive(c, getNextIndex());
			});

			c.find('#prev').click(function(){
				setIndexActive(c, getPrevIndex());
			});

			c.find('.ownSharePrice > input[type=number] + button').click(function(){	
				var ows = $("#ownPrice"+$(this).attr('mt')).val();	
				startCalc(c, attrs, ows);
			}) 
			
			if(typeof max_index !== 'undefined') {			
				c.find('.result.r'+max_index).addClass('active');
			}
		}
		getNextIndex = function(){
			var i = current_index;

			i = i + 1;

			if (i > max_index) {
				i = 1;
			}

			return i;
		}

		getPrevIndex = function(){
			var i = current_index;

			i = i - 1;

			if (i <= 0) {
				i = max_index;
			}

			return i;
		}

		setIndexActive = function(c, i) {
			current_index = i;
			c.find('.result').removeClass('active');
			c.find('.result.r'+i).addClass('active');
		}

		
		return this.each(function(){
			var $box = $(this);
			init($box);
		});
	}
}(jQuery));