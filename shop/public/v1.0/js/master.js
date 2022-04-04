var language = getCookie('lang', 'hu');
var translates = {
	'hu': {
		'loadings': 'Betöltés...',
		'_x_results': ' db találat',
		'realy_want_to_delete_from_fav': 'Biztos, hogy eltávolítja a kedvencekből?',
		'this_already_in_fav': 'Ez a termék jelenleg a kedvencei közt szerepel.',
		'cancel': 'Mégse',
		'remove': 'Eltávolítás',
		'db': 'db',
		'more': 'Több',
		'less': 'Kevesebb',
		'adding_to_cart_progress': 'kosárba helyezés folyamatban...',
	},
	'en': {
		'loadings': 'Loading...',
		'_x_results': ' items found',
		'realy_want_to_delete_from_fav': 'Are you sure remove from favorites?',
		'this_already_in_fav': 'This products already marked as favorite.',
		'cancel': 'Cancel',
		'remove': 'Remove',
		'db': 'pcs',
		'more': 'More',
		'less': 'Less',
		'adding_to_cart_progress': 'Adding products to your cart...',
	}
};

$(function()
{
	searchFilters();
	getLocation();


	$.cookieAccepter('https://www.sealring.hu/p/aszf/');

	$('*[jOpen]').openPage({
		overlayed 	: true,
		path 		: '<?=AJAX_BOX?>'
	});

	var transports_c 			= $('.transports');

	if(transports_c.length ){
		var transports_c_from_top 	= $('.transports').offset().top;
	}

	var footer_height 			= $('#footer').height();

	$(document).scroll(function(){
		var top = $(this).scrollTop();

		if(top > 200){
			if($('#topper .upTop').css('display') == 'none'){
				$('#topper .upTop').fadeIn(400);
			}
		}else{
			$('#topper .upTop').fadeOut(400);
		}

		// Transports box changes
		if(transports_c.length ){
			var transparent_c_from_bottom = $(document).height() - (transports_c.height() + $('.transports').offset().top);

			if(transparent_c_from_bottom != footer_height)
			if ( ( top + $('#topper').height() ) > transports_c_from_top ) {

				if ( transparent_c_from_bottom <= footer_height ) {
					transports_c.removeClass('toTopFix').addClass('inFooter');
				}else {
					transports_c.removeClass('inFooter').addClass('toTopFix');
				}
			} else {
				transports_c.removeClass('toTopFix').removeClass('inFooter');
			}
		}


		// Cart-Box
		/*if(top > (250 - 30)){
			$('.cart-box').css({
				top: (top-150)+'px'
			});
		}else{
			$('.cart-box').css({
				top: '-2px'
			});
		}	*/
	});

	$('*[toggle-menu]').click(function(){
	var s = $(this).hasClass('toggled');
	var row = $(this).attr('toggle-menu');

	console.log(row);

	if (s) {
		$(this).removeClass('toggled');
		$('.cat-menu li.childof'+row).removeClass('showed');
		$('.cat-menu li[class*=row-'+row+'-]').removeClass('showed');
		$('.cat-menu li[class*=row-'+row+'] .toggler').removeClass('toggled');
	} else {
		$(this).addClass('toggled');
		$('.cat-menu li.childof'+row).addClass('showed');
	}

});

	// Auto Resizer
	autoresizeImages();

	var width = $(window).width();
	$(window).resize(function(){
		 if($(this).width() != width){
				autoresizeImages();
		 }
	});

	// Dropdown select mobil click helper
	$('.dropdown-list-container').click( function(){
		var list = $(this).find('.dropdown-list-selecting');

		if( list.hasClass('showed') ){
			$(this).find('.dropdown-list-selecting').removeClass('showed');
		} else {
			$(this).find('.dropdown-list-selecting').addClass('showed');
		}

	} );
	$('.cart-float').click( function(){
		var view = $(this);

		if( view.hasClass('opened') ){
			$(this).removeClass('opened');
		} else {
			$(this).addClass('opened');
		}

	} );

	$('.social-fb-box').bind({
		mouseenter: function(){
			$(this).animate({
				right: 0
			}, 100);
		},
		mouseleave: function(){
			$(this).animate({
				right: -310
			}, 100);
		}
	});

	$('#topper .upTop > a').click(function(){
		$('body,html').animate({
			scrollTop: 0
		}, 800);
	});

	$('.con i.hbtn').click(function(){
		var key = $(this).attr('key');

		$('.newWire.'+key).slideToggle(200);
	});
	var prevKey = null;
	$('.selector').click(function(){

		var key = $(this).attr('key');
		if(key != prevKey){
			$('.selectors .selectorHint').slideUp(100);
		}
		$('.selectorHint.'+key).slideToggle(200);
		prevKey = key;
	});

	$('.param input[mode!=minmax], .param select').each(function(){
		checkUsedParam($(this));
	});
	$('.param input[mode=minmax]').each(function(){
		checkUsedMinMaxParam($(this));
	});

	$('.selectorHint input[type=checkbox][for]').click(function(){
		var fr 			= $(this).attr('for');
		var selText 	= '';
		var selVal 		= '';

		$('.selectorHint input[type=checkbox][for='+fr+']').each(function(){
			var fr 			= $(this).attr('for');
			var selected 	= $(this).is(':checked');
			var text 		= $(this).attr('text');
			var val 		= $(this).val();

			if(selected){
				selText += text+", ";
				selVal 	+= val+",";
			}

		});

		if(selText == ''){
			selText = ($(this).attr('defText')) ? $(this).attr('defText') : 'összes' ;
		}else{
			selText = selText.slice(0,-2);
		}
		if(selVal == ''){
			selVal = '';
		}else{
			selVal = selVal.slice(0,-1);
		}
		$('#'+fr).text(selText);
		$('#'+fr+'_v').val(selVal);

	});

	$('.szuro .param i.ips').click(function(){
		removeFilterItem($(this));
	});

	$('*[autoOpener]').each(function(){
		var e = $(this);
		var flag = e.attr('autoOpener');
		var state = localStorage.getItem(flag);

		if(!state){
			$(this).css({'display':'block'});
		}else{
			$(this).css({'display':'none'});
		}
	});

	initRanges();

	$('.product-view a.zoom, a.zoom').fancybox({
		padding: 0,

		openEffect : 'elastic',
		openSpeed  : 250,

		closeEffect : 'elastic',
		closeSpeed  : 250,

		closeClick : true,

		helpers : {
			overlay : null,
			buttons	: {
				position : 'bottom'
			},
			title: {
				type: 'over'
			}
		}
	});

	$('.slideShow').slick({
		dots: true,
		infinite: true,
		speed: 600,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 8000,
		adaptiveHeight: true,
		arrows: true,
		responsive : [
			{
				breakpoint: 480,
				settings : {
					mobileFirst : true,
					respondTo : window
				}
			}
		]
	});

	var hlviewer = setInterval( function(){
		var key = $('.highlight-view .items a[key]').attr('key');
		var item_nums = $('.highlight-view .items li').length;
		var current = parseInt($('.highlight-view .items li[class*=active]').attr('index'));
		var next = current + 1;
		var prev = current - 1;

		if ( next > item_nums ) {
			next = 1;
		}

		if ( prev <= 0 ) {
			prev = item_nums;
		};

		$('.highlight-view .items li').removeClass('active');

		if ( key == 'next' ) {
			$('.highlight-view .items li[index='+next+']').addClass('active');
		} else {
			$('.highlight-view .items li[index='+prev+']').addClass('active');
		}

	}, 10000);


	$('.highlight-view .items a[key]').click( function(){
		var key = $(this).attr('key');
		var item_nums = $('.highlight-view .items li').size();
		var current = parseInt($('.highlight-view .items li[class*=active]').attr('index'));
		var next = current + 1;
		var prev = current - 1;

		window.clearInterval(hlviewer);

		if ( next > item_nums ) {
			next = 1;
		}

		if ( prev <= 0 ) {
			prev = item_nums;
		};

		$('.highlight-view .items li').removeClass('active');

		if ( key == 'next' ) {
			$('.highlight-view .items li[index='+next+']').addClass('active');
		} else {
			$('.highlight-view .items li[index='+prev+']').addClass('active');
		}
	});

	$('a[href*=\\#]:not([href=\\#])').click(function(){
		var hash 	= $(this).attr('href').replace('#','');
		var target 	= $('a[name='+hash+']');

		$('html,body').animate({
					scrollTop: target.offset().top - 40
				}, 500);

		return false;
	});
	// Mobile Device events
	$('*[mb-event]').each( function(i){
		var _ =  $(this).data('mb');

		switch (_.event) {
			case 'toggleOnClick':
				if ( _.target ) {
					$(_.target).unbind('mouseenter mouseleave click');
					$(this).click( function(){
						var t = $(_.target);
						var opened = t.hasClass('opened');
						if ( opened ) {
							t.removeClass('opened');
							if (_.bodynoscroll == true) {
								$('body').removeClass('noscroll');
							}
						} else {
							$('.mb-tgl-close').removeClass('opened');
							t.addClass('opened');
							if (_.bodynoscroll == true) {
								$('body').addClass('noscroll');
							}
							if (typeof _.calcheight !== 'undefined') {
								var ph = $('body').height();
								var hm = (typeof _.calcheightminus !== 'undefined') ? _.calcheightminus : 0;
								$(_.calcheight).css({height:ph-hm});
							}
						}
					});
				}
			break;
		}

	} );

	jQuery.each($('.autocorrett-height-by-width'), function(i,e){
		var ew = $(e).width();
		var ap = $(e).data('image-ratio');
		var respunder = $(e).data('image-under');
		var pw = $(window).width();
		ap = (typeof ap !== 'undefined') ? ap : '4:3';
		console.log(ap);
		var aps = ap.split(":");
		var th = ew / parseInt(aps[0])  * parseInt(aps[1]);

		if (respunder) {
			if (pw < respunder) {
				$(e).css({
					height: th
				});
			}
		} else{
			$(e).css({
				height: th
			});
		}

	});

	// Mobile Device max Width
	$('*.mobile-max-width').each( function(){
		if ( width <= 480 ) {
			$(this).css({
				width: width,
				maxWidth : width
			});
		}
	});
})

function getCookie(cname, def = false ) 
{
	if( typeof cname === 'undefined' )
	{
		let cookies = {};
		let decodedCookie = decodeURIComponent(document.cookie).split(';');

		for(let i = 0; i < decodedCookie.length; i++) {
			let c = decodedCookie[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}

			let xc = c.split("=");

			cookies[xc[0]] = xc[1];
		}

		return cookies;
	}

  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return def;
}

function _( keyword ){
	if( typeof translates[language] === 'undefined' )
	{
		return keyword;
	} else {
		return translates[language][keyword];
	}
}

function autoresizeImages(){
	var images = $('.img-auto-cuberatio');

	images.each( function( index, img ){
		var ie = $(img);
		var width = ie.width();

		ie.css({
			height : width
		});
	});
}

function initRanges(){
	$('.range').each(function(){
		var e 		= $(this);
		var key 	= e.attr('key');
		var smin 	= parseInt(e.attr('smin'));
		var smax 	= parseInt(e.attr('smax'));
		var amin 	= parseInt(e.attr('amin'));
		var amax 	= parseInt(e.attr('amax'));

		smin = (isNaN(smin)) ? amin : smin;
		smax = (isNaN(smax)) ? amax : smax;

		e.slider({
			range: true,
			min: amin,
			max: amax,
			step: 1,
			values: [smin,smax],
			slide: function(event, ui){
				$('#'+key+'_range_min').val(ui.values[0]);
				$('#'+key+'_range_max').val(ui.values[1]);
				$('#'+key+'_range_info_min').text(ui.values[0]);
				$('#'+key+'_range_info_max').text(ui.values[1]);
				postFilterForm();
			}
		});
	});
}

function postFilterForm() {

}

function Cart(){
	this.content = ".cartContent";
	this.push = function(i, valuta = 'Ft')
	{
		var gr = $(this.content);

		jQuery.each(gr, function(ix,g)
		{
			var oi = $(g).find(".item");
			var ec = '<div class="item i'+i.termekID+'">'+
			'<div class="img">'+
				'<div class="img-thb">'+
				'<span class="helper"></span>'+
				'<img src="'+i.profil_kep+'" alt="'+i.termekNev+'" name="'+i.termekNev+'"/>'+
				'</div>'+
			'</div>'+
			'<div class="info">'+
				'<div class="adder">'+
					'<i class="fa fa-minus-square" title="'+_('less')+'" onclick="Cart.removeItem('+i.termekID+')"></i>'+
					'<i class="fa fa-plus-square" title="'+_('more')+'" onclick="Cart.addItem('+i.termekID+')"></i>'+
				'</div>'+
				'<div class="remove"><i class="fa fa-times "  onclick="Cart.remove('+i.termekID+');" title="'+_('remove')+'"></i></div>'+
				'<div class="name"><a href="'+i.url+'"><span class="in">'+i.me+'x</span> '+i.termekNev+'</a></div>'+
				'<div class="sub">'+
				/*'<div class="tipus">Variáció: <span class="val">'+((i.szin) ? i.szin+'</span>' : '')+''+( (i.meret)?', Kiszerelés: <span class="val">'+i.meret+'</span>':'')+'</div>'+*/
				'<span class="ar">'+( (i.ar != '-1')? i.ar+' '+valuta+' / '+_('db') : 'Ár: érdeklődjön' )+'</span>'+
				'</div>'+
			'</div>'+
			'<div class="clr"></div></div>';

			if(oi.length == 0){
				$(g).html(ec);
			}else{
				$(ec).insertAfter($(g).find('.item:last'));
			}
		});
	}
	this.addItem = function(id){
		var parent = this;
		$.post('/ajax/post/',{
			type : 'cart',
			mode : 'addItem',
			id 	 : id
		},function(d){
			var p = $.parseJSON(d);
			if(p.success == 1){
				getCartInfo(function(e){
					refreshCart(e);
					parent.reLoad(e);
				});
			}else{
				aler(p.msg);
			}
		},"html");
	}
	this.removeItem = function(id){
		var parent = this;
		$.post('/ajax/post/',{
			type : 'cart',
			mode : 'removeItem',
			id 	 : id
		},function(d){
			var p = $.parseJSON(d);
			if(p.success == 1){
				getCartInfo(function(e){
					refreshCart(e);
					parent.reLoad(e);
				});
			}else{
				aler(p.msg);
			}
		},"html");
	}
	this.reLoad = function(e){
		$(this.content).html('<div class="noItem"><div class="inf">A kosár üres</div></div>');
		buildCartItems(e);
	}
	this.remove = function(id){
		var c = this.content;
		var parent = this;
		$.post('/ajax/post/',{
			type : 'cart',
			mode : 'remove',
			id 	 : id
		},function(d){
			var p = $.parseJSON(d);
			if(p.success == 1){
				$(c+' .item.i'+id).remove();
				var oi = $(c).find(".item");
				if(oi.length == 0){
					$(c).html('<div class="noItem"><div class="inf">A kosár üres</div></div>');
				}
				getCartInfo(function(e){
					refreshCart(e);
					parent.reLoad(e);
				});
			}else{
				aler(p.msg);
			}
		},"html");
	}
}

var Cart = new Cart();

function createFilterArRange(smin, smax, amin, amax){
	amin = parseInt(amin);
	amax = parseInt(amax);
	smin = parseInt(smin);
	smax = parseInt(smax);

	smin = (typeof smin === 'undefined' || isNaN(smin)) ? 0 : smin;
	smax = (typeof smax === 'undefined' || isNaN(smax)) ? 250000 : smax;

	amin = (typeof amin === 'undefined' || isNaN(amin)) ? 0 : amin;
	amax = (typeof amax === 'undefined' || isNaN(amax)) ? 250000 : amax;

	$('#arShow').text("("+amin+" - "+amax+")");

	$('#filter_termekAr_range').slider({
			range: true,
			min: amin,
			max: amax,
		step: 1000,
			values: [ smin, smax ],
			slide: function( event, ui ) {
				$( "#fil_ar_min" ).val(ui.values[ 0 ]);
		$( "#fil_ar_max" ).val(ui.values[ 1 ]);
		$('#arShow').text("("+ui.values[0]+" - "+ui.values[1]+")");
		postFilterForm();
			}
		});
}

function openCloseBox(elem, flag){
	var flagState 	= localStorage.getItem(flag);
	var disp 		= $(elem).css('display');
	if(disp == 'none'){
		localStorage.removeItem(flag);
		$(elem).toggle("slide");
	}else{
		localStorage.setItem(flag,11);
		$(elem).toggle("slide");
	}

	console.log(flagState);
}
function removeFilterItem(e){
	var key = e.attr('key');
	var mode = e.attr('mode');

	if(mode == 'range'){
		$('#'+key+'_min').val('');
		$('#'+key+'_max').val('');
	}else{
		$('#'+key+'_v').val('');
		$('#'+key).text('összes').removeClass('filtered');
	}
	e.remove();
}
function checkUsedMinMaxParam(e){
	var key = e.attr('id');
	var v 	= e.val();
	if(key.search('_min') > -1){
		key = key.replace('_min','');
		if(v != ''){
			$("<i class='fa fa-times ips' mode='range' key='"+key+"'></i>").insertBefore('#'+key+'_min');
		}
	}
}
function checkUsedParam(e){
	if(e.attr('type') == 'hidden'){
		var v 	= e.val();
		var id 	= e.attr("id");
		if(v != ''){
			var key = id.replace('_v','');
			$("<i class='fa fa-times ips' key='"+key+"'></i>").insertBefore('#'+key);
		}
	}
}
function searchFilters(){

	$('.selectorHint input[type=checkbox][for]').each(function(){
		var fr = $(this).attr('for');
		var ch = $(this).is(':checked');
		var selText 	= '';
		var selVal 		= '';

		$('.selectorHint input[type=checkbox][for='+fr+']').each(function(){
			var fr 			= $(this).attr('for');
			var selected 	= $(this).is(':checked');
			var text 		= $(this).attr('text');
			var val 		= $(this).val();

			if(selected){
				$('#'+fr).addClass('filtered');
				selText += text+", ";
				selVal 	+= val+",";
			}

		});

		if(selText == ''){
			selText = $(this).attr('defText');
		}else{
			selText = selText.slice(0,-2);
		}
		if(selVal == ''){
			selVal = '';
		}else{
			selVal = selVal.slice(0,-1);
		}
		$('#'+fr).text(selText);
		$('#'+fr+'_v').val(selVal);

	});

	$('button[cart-data]').click(function(){

		var key = $(this).attr('cart-data');
		var rem = $(this).attr('cart-remsg');
		var me 	= $('input[type=number][cart-count='+key+']').val();
		var progress = $(this).attr('cart-progress');

		if(typeof me === 'undefined'){
			me = parseInt($(this).attr('cart-me'));
		}

		if(typeof progress !== 'undefined'){
			$('#'+progress)
			.stop()
			.addClass('in-progress')
			.html('Folyamatban <i class="fa fa-spin fa-spinner"></i>');
		}

		$('#'+rem).html('<div class="in-progress"><i class="fa fa-spin fa-spinner"></i> '+_('adding_to_cart_progress')+'</div>');

		addToCart(key, me, function(success, msg){
			if (success == 1) {
				$('#'+rem).html('<div class="success">'+msg+'</div>');
			} else {
				$('#'+rem).html('<div class="error">'+msg+'</div>');
			}

			if(typeof progress !== 'undefined'){
				$('#'+progress)
				.stop()
				.removeClass('in-progress')
				.html('<span class="t">Kosárba</span> <img src="https://cp.seal-ring.web-pro.hu/src/images/shopcart-ico.svg" alt="Kosárba">');
			}

		} );
	});

	getCartInfo(function(e){
		refreshCart(e);
		buildCartItems(e);
	});
}
function buildCartItems(c){
	var i = c.items;

	console.log(c);

	if( !i ) return false;

	for(var s = 0; s < i.length; s++){
		var e = i[s];
		Cart.push(e, c.valuta);
	}
}
function getCartInfo(callback){
	$.post('/ajax/get/',{
		type : 'cartInfo'
	},function(d){
		var p = $.parseJSON(d);
		callback(p);
	},"html");
}
function refreshCart(p){
	$('#cart-item-num-v, .cart-item-num-v').text(p.itemNum);
	$('#cart-item-num, .cart-item-num-v').text(p.itemNum);
	$('.cart-item-num, .cart-item-num-v').text(p.itemNum);
	$('#cart-item-prices').html(p.totalPriceTxt);
	$('.cart-item-prices').html(p.totalPriceTxt);

	if( p.itemNum > 0 ){
		$('.cart-box').show(0);
		$('.cart .whattodo').addClass('active');
	}else{
		$('.cart-box').hide(0);
		$('.cart .whattodo').removeClass('active');
	}
}
function addToCart(termekID, me, callback){

	$.post('/ajax/post/',{
		type : 'cart',
		mode : 'add',
		t 	 : termekID,
		m    : me
	},function(d){
		var p = $.parseJSON(d);
		if(p.success == 1){
			getCartInfo(function(e){
				refreshCart(e);
				Cart.reLoad(e);
			});
		}
		callback(p.success, p.msg);
	},"html");
}
function getLocation() {
	var ts = new Date().getTime(),
		cs = $.cookie( 'geo_lastrefresh' ),
		go = false,
		diff;

	diff_hr = ((ts - cs) / 1000 / 60 / 60);

	if( diff_hr > 24 ) {
		go = true;
	}

	if( go ) {
		if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition( showPosition );
			} else {

			}
	}
}
function showPosition(position) {
	$.cookie( 'geo_lastrefresh',  new Date().getTime() );
	$.cookie( 'geo_latlng',  position.coords.latitude+","+position.coords.longitude );
	var ctc = $.cookie( 'geo_countrycode' );

	if( !ctc ) {
		$.getJSON('http://ws.geonames.org/countryCode', {
					lat: position.coords.latitude,
					lng: position.coords.longitude,
					username: 'mridev',
					type: 'JSON'
			}, function(result) {
					$.cookie( 'geo_countrycode', result.countryCode );
			});
	}
}
function searchItem(e){
	var srcString = e.find('input[type=text]').val();
	$.post('<?=AJAX_POST?>',{
		type: 'log',
		mode: 'searching',
		val: srcString
	},function(re){
		document.location.href='/kereses/'+srcString;
	},"html");
}
function prepareHelpdeskHeaderSearch( form ) {
	var src= $(form).find('input').val();
	document.location.href='/tudastar#?tags='+src;
}

var tc = angular.module('sealring', ['ngMaterial', 'ngMessages', 'ngCookies']);

tc.controller('App', ['$scope', '$sce', '$http', '$mdToast', '$mdDialog', '$location', '$window','$cookies', '$cookieStore', function($scope, $sce, $http, $mdToast, $mdDialog, $location, $window, $cookies, $cookieStore)
{
	$scope.fav_num = 0;
	$scope.fav_ids = [];
	$scope.in_progress_favid = false;
	$scope.requesttermprice = {};
	$scope.order_accepted = false;
	$scope.accept_order_key = 'acceptedOrder';
	$scope.accept_order_text = null;
	$scope.accept_order_title = 'Szerződési feltételek elfogadása';
	$scope.lang = 'hu';

	$scope.productAddToFav = function( id, ev ){
		var infav = $scope.fav_ids.indexOf(id);

		if ( infav !== -1 ) {
			var confirmRemoveFav = $mdDialog.confirm()
					.title(_('realy_want_to_delete_from_fav'))
					.textContent(_('this_already_in_fav'))
					.ariaLabel(_('realy_want_to_delete_from_fav'))
					.targetEvent(ev)
					.ok(_('remove'))
					.cancel(_('cancel'));

			$mdDialog.show(confirmRemoveFav).then(function() {
				$scope.doFavAction('remove', id, function(){
					$scope.syncFavs(function(err, n){
						$scope.fav_num = n;
						$scope.in_progress_favid = false;
					});
				});
			}, function() {

			});
		} else {
			$scope.in_progress_favid = id;
			$scope.doFavAction('add', id, function(){
				$scope.syncFavs(function(err, n){
					$scope.fav_num = n;
					$scope.in_progress_favid = false;
				});
			});
		}
	}

	$scope.init = function( ordernow ){
		$scope.syncFavs(function(err, n){
			$scope.fav_num = n;
		});

		if (typeof ordernow !== 'undefined' && ordernow === true ) {
			$scope.loadSettings( ['tuzvedo_order_pretext','tuzvedo_order_pretext_wanted','tuzvedo_order_pretext_title'], function(settings){
				if (settings.tuzvedo_order_pretext_wanted == '1') {
					$scope.accept_order_title = (settings.tuzvedo_order_pretext_title != '') ? settings.tuzvedo_order_pretext_title : $scope.accept_order_title ;
					$scope.accept_order_text = settings.tuzvedo_order_pretext;
					$scope.acceptBeforeDoneOrder();
				} else {
					$scope.order_accepted = true;
				}
			});
		}
	}

	$scope.loadSettings = function( key, callback ){
		$http({
			method: 'POST',
			url: '/ajax/get',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param({
				type: "settings",
				key: key
			})
		}).success(function(r){
			callback(r.data);
		});
	}

	$scope.productRemoveFromFav = function( id ){

	}

	$scope.acceptBeforeDoneOrder = function(){
		var accepted = $cookieStore.get( $scope.accept_order_key );

		if ( typeof accepted === 'undefined' )
		{
			var confirm = $mdDialog.confirm({
				controller: acceptBeforeDoneOrderController,
				templateUrl: '/app/templates/acceptBeforeDoneOrder',
				scope: $scope,
				preserveScope: true,
				parent: angular.element(document.body),
				locals: {
					order_accepted: $scope.order_accepted,
					accept_order_key: $scope.accept_order_key
				}
			});

			function acceptBeforeDoneOrderController( $scope, $mdDialog, order_accepted, accept_order_key) {
				$scope.order_accepted = order_accepted;
				$scope.accept_order_key = accept_order_key;

				$scope.closeDialog = function(){
					$mdDialog.hide();
				}
				$scope.acceptOrder = function(){
					$cookies.put($scope.accept_order_key, 1);
					$scope.order_accepted = true;
					$mdDialog.hide();
				}
			}
			$mdDialog.show(confirm);
		} else {
			$scope.order_accepted = true;
		}
	}

	$scope.requestPrice = function( id ){
		var confirm = $mdDialog.confirm({
			controller: RequestPriceController,
			templateUrl: '/app/templates/ProductItemPriceRequest',
			parent: angular.element(document.body),
			locals: {
				termid: id,
				requesttermprice: $scope.requesttermprice
			}
		});

		function RequestPriceController( $scope, $mdDialog, termid, requesttermprice) {
			$scope.sending = false;
			$scope.termid = termid;
			$scope.requesttermprice = requesttermprice;

			$scope.closeDialog = function(){
				$mdDialog.hide();
			}

			$scope.validateForm = function(){
				var state = false;
				var phone_test = ''

				if (
					(typeof $scope.requesttermprice.name !== 'undefined' && $scope.requesttermprice.name.length >= 5) &&
					(typeof $scope.requesttermprice.phone !== 'undefined' && !$scope.requesttermprice.phone.$error) &&
					(typeof $scope.requesttermprice.email !== 'undefined' && !$scope.requesttermprice.email.$error)
				) {
					state = true;
				}

				return state;
			}

			$scope.sendModalMessage = function( type ){
				if (!$scope.sending) {
					$scope.sending = true;

					$scope.requesttermprice.termid = parseInt($scope.termid);

					$http({
						method: 'POST',
						url: '/ajax/post',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						data: $.param({
							type: "modalMessage",
							modalby: type,
							datas: $scope.requesttermprice
						})
					}).success(function(r) {
						$scope.sending = false;
						$scope.requesttermprice = {};
						console.log(r);

						if (r.error == 1) {
							$scope.toast(r.msg, 'alert', 10000);
						} else {
							$mdToast.hide();
							$scope.closeDialog();
							$scope.toast(r.msg, 'success', 10000);
						}
					});
				}
			}

			$scope.toast = function( text, mode, delay ){
				mode = (typeof mode === 'undefined') ? 'simple' : mode;
				delay = (typeof delay === 'undefined') ? 5000 : delay;

				if (typeof text !== 'undefined') {
					$mdToast.show(
						$mdToast.simple()
						.textContent(text)
						.position('top')
						.toastClass('alert-toast mode-'+mode)
						.hideDelay(delay)
					);
				}
			}
		}

		$http({
			method: 'POST',
			url: '/ajax/post',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param({
				type: "getTermItem",
				id: id
			})
		}).success(function(r){
			console.log(r);
			if (r.error == 1) {
				$scope.toast(r.msg, 'alert', 10000);
			} else {
				$scope.requesttermprice.product = r.product;
				$mdDialog.show(confirm)
				.then(function() {
					$scope.status = 'You decided to get rid of your debt.';
				}, function() {
					$scope.status = 'You decided to keep your debt.';
				});
			}
		});

	}

	$scope.doFavAction = function( type, id, callback ){
		$http({
			method: 'POST',
			url: '/ajax/post',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param({
				type: "productFavorite",
				action: type,
				tid: id
			})
		}).success(function(r){
			if (r.error == 1) {
				$scope.toast(r.msg, 'alert', 10000);
			} else {
				$mdToast.hide();
				$scope.toast(r.msg, 'success', 50000);
			}

			if (typeof callback === 'function') {
				callback(r.error, r.msg, r);
			}
		});
	}

	$scope.syncFavs = function( callback ){
		$http({
			method: 'POST',
			url: '/ajax/post',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param({
				type: "productFavorite",
				action: 'get',
				own: 1
			})
		}).success(function(r){
			if (r.ids) {
				$scope.fav_ids = [];
				angular.forEach(r.ids, function(v,i){
					$scope.fav_ids.push(v);
				});
			}
			if (typeof callback === 'function') {
				callback(r.error, r.num);
			}
		});
	}

	$scope.findedCity = {};
	$scope.findCityByIrsz = function( event, tinput )
	{
		event.preventDefault();
		var val = event.target.value;

		$http({
			method: 'POST',
			url: '/ajax/get',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param({
				type: "irszCityHint",
				irsz: val
			})
		}).success(function(r){
			if (r.data && r.data.length != 0) {
				if (r.data.length == 1) {
					$('input#'+tinput).val( r.data[0].varos );
				} else {
					$scope.findedCity[tinput] = r.data;
				}
			} else if( r.data && r.data.length == 0) {
				$scope.findedCity[tinput] = [];
			}
		});
	}
	$scope.fillCityHint = function( tinput, city ) {
		$('input#'+tinput).val( city.varos );
		$scope.findedCity[tinput] = [];
	}

	/******************************
	* Finder
	*******************************/
	$scope.findernavpos = 'simple';
	$scope.finder_result_num = -1;
	$scope.finder_result_text = '';
	$scope.finder_base_url = '/termekek/';
	$scope.finder_config = {
		'felhasznalasi_teruletek': [],
		'meretek': [],
		'selects': {
			'cats': [],
			'subcats': []
		}
	};

	$scope.finder_config_select = {
		catid: 0,
		search_keywords: ''
	};

	$scope.parseQuery = function(queryString) {
		var query = {};
		var pairs = (queryString[0] === '?' ? queryString.substr(1) : queryString).split('&');
		for (var i = 0; i < pairs.length; i++) {
				var pair = pairs[i].split('=');
				query[decodeURIComponent(pair[0])] = decodeURIComponent(decodeURI(pair[1]) || '');
		}
		return query;
	}

	$scope.loadFinder = function( catid, query_string )
	{
		var qry = $scope.parseQuery( query_string );

		if (typeof qry.src !== 'undefined') {
			$scope.finder_config_select.search_keywords = qry.src.replace(/\+/g,' ');
		}

		$scope.prepareConfigs(function(){
			$scope.bindFinder(catid);
		});
	}

	$scope.bindFinder = function( catid, callback )
	{
		if (catid != 0 && catid && catid != '') {
			$scope.finder_config_select.catid = catid;
		}
		$scope.finder_result_text = _('loadings');
		$scope.finder_result_num = -1;
		$http({
			method: 'POST',
			url: '/ajax/post',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param({
				type: "finder",
				action: 'calcitem',
				findermode: $scope.findernavpos,
				datas: $scope.finder_config_select
			})
		}).success(function(r)
		{
			if (r.success == 0) {
				$scope.finder_result_text = r.msg;
			} else {
				$scope.finder_result_text = r.nums+_('_x_results');
			}
			$scope.finder_result_num = r.nums;
			if ( r.baseurl ) {
				$scope.finder_base_url = r.baseurl;
			}
			if (typeof callback === 'function') {
				callback(r.nums);
			}
		});
	}

	$scope.prepareConfigs = function( callback )
	{
		$http({
			method: 'POST',
			url: '/ajax/post',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param({
				type: "finder",
				action: 'loadTerms'
			})
		}).success(function(r)
		{
			// Termék típusok
			if (r.success == 1 && r.data.termektipus && r.data.termektipus.length !== 0) {
				$scope.finder_config.selects.cats.push({
					id: 0,
					label: 'Összes típus'
				});
				angular.forEach(r.data.termektipus, function(e,i){
					if (e.parent == 0) {
						$scope.finder_config.selects.cats.push(e);
					} else {
						if (typeof $scope.finder_config.selects.subcats[e.parent] === 'undefined') {
							$scope.finder_config.selects.subcats[e.parent] = [];
						}

						$scope.finder_config.selects.subcats[e.parent].push(e);
					}
				});
			}

			// Felhasználási területek
			if (r.success == 1 && r.data.felhasznalasi_teruletek && r.data.felhasznalasi_teruletek.length !== 0) {
				$scope.finder_config.felhasznalasi_teruletek.push({
					id: 0,
					label: 'Összes terület'
				});
				angular.forEach(r.data.felhasznalasi_teruletek, function(e,i){
					$scope.finder_config.felhasznalasi_teruletek.push(e);
				});
			}
			if (typeof callback === 'function') {
				callback();
			}
		});
	}

	$scope.goFinder = function()
	{
		var url = $scope.finder_base_url;

		if ($scope.finder_result_num > 0 )
		{
			var src = (typeof $scope.finder_config_select.search_keywords !== 'undefined') ? $scope.finder_config_select.search_keywords : '';
			url += '?src='+src;

			$window.location.href = url;
		}
	}

	$scope.switchFinderNav = function(tab)
	{
		$scope.findernavpos = tab;
	}
	/* END: Finder */

	$scope.toast = function( text, mode, delay ){
		mode = (typeof mode === 'undefined') ? 'simple' : mode;
		delay = (typeof delay === 'undefined') ? 5000 : delay;

		if (typeof text !== 'undefined') {
			$mdToast.show(
				$mdToast.simple()
				.textContent(text)
				.position('top')
				.toastClass('alert-toast mode-'+mode)
				.hideDelay(delay)
			);
		}
	}

}]);

tc.controller('ActionButtons', ['$scope', '$http', '$mdDialog', '$mdToast', function($scope, $http, $mdDialog, $mdToast){

	$scope.showHints = true;
	$scope.recall = {};
	$scope.ajanlat = {};

	/**
	* Ingyenes visszahívás modal
	**/
	$scope.requestRecall = function(){
		var confirm = $mdDialog.confirm({
			controller: ConfirmPackageOrder,
			templateUrl: '/app/templates/recall',
			parent: angular.element(document.body),
			locals: {
				showHints: $scope.showHints,
				recall: $scope.recall,
				ajanlat: $scope.ajanlat
			}
		});

		function ConfirmPackageOrder( $scope, $mdDialog, showHints, recall, ajanlat) {
			$scope.showHints = showHints;
			$scope.recall = recall;
			$scope.ajanlat = ajanlat;
			$scope.sending = false;

			$scope.closeDialog = function(){
				$mdDialog.hide();
			}
			$scope.validateForm = function(){
				var state = false;
				var phone_test = ''

				if (
					(typeof $scope.recall.name !== 'undefined' && $scope.recall.name.length >= 5) &&
					(typeof $scope.recall.phone !== 'undefined' && !$scope.recall.phone.$error) &&
					(typeof $scope.recall.subject !== 'undefined')
				) {
					state = true;
				}

				return state;
			}

			$scope.sendModalMessage = function( type ){
				if (!$scope.sending) {
					$scope.sending = true;

					$http({
						method: 'POST',
						url: '/ajax/post',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						data: $.param({
							type: "modalMessage",
							modalby: type,
							datas: $scope[type]
						})
					}).success(function(r){
						$scope.sending = false;
						$scope.recall = {};

						if (r.error == 1) {
							$scope.toast(r.msg, 'alert', 10000);
						} else {
							$mdToast.hide();
							$scope.closeDialog();
							$scope.toast(r.msg, 'success', 10000);
						}
					});
				}
			}
			$scope.toast = function( text, mode, delay ){
				mode = (typeof mode === 'undefined') ? 'simple' : mode;
				delay = (typeof delay === 'undefined') ? 5000 : delay;

				if (typeof text !== 'undefined') {
					$mdToast.show(
						$mdToast.simple()
						.textContent(text)
						.position('top')
						.toastClass('alert-toast mode-'+mode)
						.hideDelay(delay)
					);
				}
			}
		}

		$mdDialog.show(confirm)
		.then(function() {
			$scope.status = 'You decided to get rid of your debt.';
		}, function() {
			$scope.status = 'You decided to keep your debt.';
		});
	}
	/**
	* Ajánlatkérés modal
	**/
	$scope.requestAjanlat = function()
	{
		var confirm = $mdDialog.confirm({
			controller: ConfirmPackageOrder,
			templateUrl: '/app/templates/ajanlatkeres',
			parent: angular.element(document.body),
			locals: {
				showHints: $scope.showHints,
				ajanlat: $scope.ajanlat
			}
		});

		function ConfirmPackageOrder( $scope, $mdDialog, showHints, ajanlat) {
			$scope.showHints = showHints;
			$scope.ajanlat = ajanlat;
			$scope.sending = false;

			$scope.closeDialog = function(){
				$mdDialog.hide();
			}
			$scope.validateForm = function(){
				var state = false;
				var phone_test = ''

				if (
					(typeof $scope.ajanlat.name !== 'undefined' && $scope.ajanlat.name.length >= 5) &&
					(typeof $scope.ajanlat.phone !== 'undefined' && !$scope.ajanlat.phone.$error) &&
					(typeof $scope.ajanlat.email !== 'undefined' && !$scope.ajanlat.email.$error) &&
					(typeof $scope.ajanlat.message !== 'undefined')
				) {
					state = true;
				}

				return state;
			}

			$scope.sendModalMessage = function( type ){
				if (!$scope.sending) {
					$scope.sending = true;

					$http({
						method: 'POST',
						url: '/ajax/post',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						data: $.param({
							type: "modalMessage",
							modalby: type,
							datas: $scope[type]
						})
					}).success(function(r){
						$scope.sending = false;
						$scope.ajanlat = {};

						if (r.error == 1) {
							$scope.toast(r.msg, 'alert', 10000);
						} else {
							$mdToast.hide();
							$scope.closeDialog();
							$scope.toast(r.msg, 'success', 10000);
						}
					});
				}
			}
			$scope.toast = function( text, mode, delay ){
				mode = (typeof mode === 'undefined') ? 'simple' : mode;
				delay = (typeof delay === 'undefined') ? 5000 : delay;

				if (typeof text !== 'undefined') {
					$mdToast.show(
						$mdToast.simple()
						.textContent(text)
						.position('top')
						.toastClass('alert-toast mode-'+mode)
						.hideDelay(delay)
					);
				}
			}
		}

		$mdDialog.show(confirm)
		.then(function() {
			$scope.status = 'You decided to get rid of your debt.';
		}, function() {
			$scope.status = 'You decided to keep your debt.';
		});
	}


}]);

tc.controller('Tudastar',['$scope', '$http', '$mdToast', '$element', '$location', '$window', function($scope, $http, $mdToast, $element, $location, $window)
{
	$scope.found_items = 0;
	$scope.loading = false;
	$scope.loaded = false;
	$scope.categories = [];
	$scope.searchKeys = [];
	$scope.validitems = [];
	$scope.catFilters = {};
	$scope.selected_article = false;
	$scope.precats = false;
	$scope.picked_article = false;

	$scope.init = function()
	{
		$scope.doSearch( true );
	}

	$scope.rebuildPath = function()
	{
		// TAGS
		var src = $location.search();
		var tags = $scope.implodeObj($scope.searchKeys, ',');
		src.tags = tags;

		// PICKED ARTICLE
		if ( $scope.selected_article && typeof src.pick === 'undefined' ) {
			src.pick = $scope.selected_article;
		} else if( $scope.selected_article && src.pick != $scope.selected_article ) {
			src.pick = $scope.selected_article;
		} else if( $scope.selected_article === false ){
			src.pick = null;
			$scope.picked_article = false;
		}

		// CATS
		var tempcat = [];
		if ( $scope.catFilters.length != 0 ) {
			angular.forEach( $scope.catFilters, function(e,i){
				tempcat.push( e.ID );
			});
			src.cat = $scope.implodeObj(tempcat, ',');
		}

		$location.path('?', false).search(src);
	}

	$scope.prepareFilters = function(){
		$scope.selected_article = $scope.getURLParam('pick');
		var tags = $scope.getURLParam('tags');
		$scope.precats = $scope.getURLParam('cat');

		if (tags != '') {
			var xtags = tags.split(',');
			if (typeof xtags !== 'undefined') {
				angular.forEach(xtags, function(tag,i){
					$scope.putTagToSearch(tag);
				});
			}
		}
	}

	$scope.implodeObj = function( list, sep )
	{
		var l = '';
		angular.forEach(list, function(e,i){
			l += e + sep;
		});

		l = l.slice(0, -1);

		return l;
	}

	$scope.findArticle = function( article )
	{
		var obj;

		if ( $scope.categories.length != 0 ) {
				angular.forEach( $scope.categories, function(cat, i){
					if (cat.articles.length != 0) {
						angular.forEach( cat.articles, function(art, i){
							if (art.ID == article) {
								obj = art;
							}
						});
					}
				});
		}

		return obj;
	}

	$scope.getURLParam = function( key ){
		var src = $location.search();

		if ( typeof src[key] !== 'undefined' ) {
			return src[key];
		}

		return false;
	}

	$scope.doSearch = function( loader )
	{
		if ( !loader ) {
			$scope.rebuildPath();
		}

		$scope.prepareFilters();
		$scope.loadCategories(function( success ){
			$scope.loaded = true;
			$scope.loading = false;

			var cats = $scope.precats;
			if (cats != '') {
				var cats = cats.split(',');
				if (typeof cats !== 'undefined') {
					angular.forEach(cats, function(cat,i){
						if( !$scope.catInFilter(parseInt(cat)) ) {
							$scope.filterCategory(cat);
						}
					});
				}
			}

			if ( $scope.selected_article ) {
				$scope.picked_article = $scope.findArticle( $scope.selected_article );
			}

		});
	}

	$scope.catInFilter = function( catid ){
		var isin = false;
		if ( $scope.catFilters.length != 0 ) {
			angular.forEach( $scope.catFilters, function(cf, i){
				if( cf.ID == catid){
					isin = true;
				}
			});
		}

		return isin;
	}

	$scope.emptyCatFilters = function(){
		if ( angular.equals({}, $scope.catFilters)) {
			return true;
		}else {
			return false;
		}
	}

	$scope.getCatData = function(catid) {
		var obj;

		if ( $scope.categories.length != 0 ) {
				angular.forEach( $scope.categories, function(cat, i){
					if( cat.ID == catid ) {
						obj = cat;
					}
				});
		}

		return obj;
	}

	$scope.filterCategory = function( catid )
	{
		$scope.selected_article = false;
		var key = 'cat' + catid;
		if ( typeof $scope.catFilters[key] === 'undefined') {
			$scope.catFilters[key] = {};
			$scope.catFilters[key] = $scope.getCatData( catid );
		} else {
			delete $scope.catFilters[key];
		}

		$scope.doSearch( false );
	}

	$scope.toTop = function(){
		$window.scrollTo(0, 0);
	}

	$scope.putTagToSearch = function( tag ){
		if ( $scope.searchKeys.indexOf(tag) === -1) {
			$scope.searchKeys.push(angular.lowercase(tag));
		}
	}

	$scope.inSearchTag = function(tag){
		if ( $scope.searchKeys.indexOf(tag) === -1) {
			return false;
		} else {
			return true;
		}
	}

	$scope.highlightArticle = function( articleid ){
		$scope.pickArticle(articleid, function(){
			$scope.doSearch( false );
		});
	}

	$scope.removeHighlightArticle = function(){
		$scope.selected_article = false;
		$scope.doSearch( false );
	}

	$scope.pickArticle = function( articleid, callback ){
		$scope.selected_article = articleid;

		if ( typeof callback !== 'undefined' ) {
			callback(articleid);
		}
	}

	$scope.loadCategories = function( callback ){
		$scope.loading = true;
		$scope.loaded = false;

		$http({
			method: 'POST',
			url: '/ajax/post',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param({
				type: "Helpdesk",
				action: 'getCategories',
				search: $scope.searchKeys,
				cats: $scope.catFilters
			})
		}).success(function(r){
			if (r.success == 1) {
				$scope.categories = r.data;
				$scope.found_items = r.count;
			} else {
				$scope.toast( r.msg , 'alert', 10000);
			}

			if (typeof callback !== 'undefined') {
				callback(r.success);
			}

		});
	}

	$scope.toast = function( text, mode, delay ){
		mode = (typeof mode === 'undefined') ? 'simple' : mode;
		delay = (typeof delay === 'undefined') ? 5000 : delay;

		if (typeof text !== 'undefined') {
			$mdToast.show(
				$mdToast.simple()
				.textContent(text)
				.position('top')
				.toastClass('alert-toast mode-'+mode)
				.hideDelay(delay)
			);
		}
	}
}]);

tc.filter('unsafe', function($sce){ return $sce.trustAsHtml; });

/**
* Popop tc
**/
tc.controller('popupReceiver', ['$scope', '$sce', '$cookies', '$http', '$location', '$window', '$timeout', function($scope, $sce, $cookies, $http, $location, $window, $timeout)
{
	var ctrl 	= this;
	var _url 	= $location.absUrl();
	var _path 	= $location.path();
	var _host 	= $location.host();
	var loadedsco = false;
	// Defaults
	var _config = {
		'contentWidth' : 970,
		'headerHeight' : 75,
		'responsiveBreakpoint' : 960,
		'domain' : false,
		'receiverdomain' : '',
		'imageRoot' : 'https://www.cp.sealring.web-pro.hu/'
	};

	var param 	= function(obj) {
			var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

			for(name in obj) {
				value = obj[name];

				if(value instanceof Array) {
					for(i=0; i<value.length; ++i) {
						subValue = value[i];
						fullSubName = name + '[' + i + ']';
						innerObj = {};
						innerObj[fullSubName] = subValue;
						query += param(innerObj) + '&';
					}
				}
				else if(value instanceof Object) {
					for(subName in value) {
						subValue = value[subName];
						fullSubName = name + '[' + subName + ']';
						innerObj = {};
						innerObj[fullSubName] = subValue;
						query += param(innerObj) + '&';
					}
				}
				else if(value !== undefined && value !== null)
					query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
			}

			return query.length ? query.substr(0, query.length - 1) : query;
	};

	$http.defaults.headers.post["Content-Type"] = 'application/x-www-form-urlencoded;charset=utf-8';
	$http.defaults.transformRequest = [function(data) {
			return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
	}];

	$scope.showed = false;
	$scope.test = 'minta';

	/**
	* Böngésző szélesség
	*/
	$scope.windowWidth = function(){
		return parseInt($window.innerWidth);
	}

	/**
	* Böngésző magasság
	*/
	$scope.windowHeight= function(){
		return parseInt($window.innerHeight);
	}

	$scope.init = function ( settings )
	{

		angular.extend( _config, settings );

		ctrl.checkCookie(_config.domain);

		// Dokumentum magasság (px)
		var _documentHeight = jQuery(document).height();

		ctrl.loadScreen(_url, function(sco, template)
		{
			if (sco.show)
			{
				// Timed event
				if (sco.data.creative.type == 'timed')
				{
					$timeout(function()
					{
						ctrl.loadedsco = sco;
						ctrl.loadTemplate(template);
						$scope.showed = true;
						ctrl.logShow( sco.data.creative.id, sco.data.screen_loaded );

					}, sco.data.creative.settings.timed_delay_sec * 1000);
				}

				// Scroll event on scroll
				if (sco.data.creative.type == 'scroll')
				{
					var opencount = 0;

					jQuery(window).scroll(function()
					{
						// Távolság a felső résztől (px)
						var _top = jQuery('body').scrollTop();
						var realheight = jQuery(document).height() - $scope.windowHeight();
						var scrollpercent = _top / (realheight / 100);

						if (scrollpercent > sco.data.creative.settings.scroll_percent_point)
						{
							//console.log(view);
							if ( !$scope.showed && opencount == 0 )
							{
								opencount++;
								ctrl.loadedsco = sco;
								ctrl.loadTemplate(template);
								$scope.showed = true;
								ctrl.logShow( sco.data.creative.id, sco.data.screen_loaded );
							};
						}

					});
				};

				// Mousemove event
				if (sco.data.creative.type == 'exit')
				{
					var delay_pause = (typeof sco.data.creative.settings.exit_pause_delay_sec === 'undefined') ? 0 : sco.data.creative.settings.exit_pause_delay_sec;

					$timeout(function()
					{
						var opencount = 0;
						jQuery(document).mousemove(function(e)
						{
							var w = e.clientX;
							var h = e.clientY;

							if (h < _config.headerHeight )
							{
								if ( !$scope.showed && opencount == 0  )
								{
									opencount++;
									ctrl.loadedsco = sco;
									ctrl.loadTemplate(template);
									$scope.showed = true;
									ctrl.logShow( sco.data.creative.id, sco.data.screen_loaded );
								};
							}
						});

					}, delay_pause * 1000);

				};

			};

		});

	}

	$scope.redirect = function()
	{
		ctrl.logInteraction(true, function()
		{
			ctrl.loadedsco 	= false;
			$scope.showed 	= false;
		});
	}

	$scope.close = function()
	{
		ctrl.logInteraction(false, function()
		{
			ctrl.loadedsco 	= false;
			$scope.showed 	= false;
		});
	}

	// TODO
	this.logInteraction = function(positive, callback)
	{
		$http.post(_config.receiverdomain+'/ajax/post/',
		{
			type 		: 'logPopupClick',
			creative 	: ctrl.loadedsco.data.creative.id,
			screen 		: ctrl.loadedsco.data.screen.id,
			closed 		: (positive) ? 0 : 1,
			sessionid	: ctrl.getSessionID()

		}).success(function(d,s,h,c){
			callback();
		});
	}

	this.loadScreen = function( url, callback )
	{
		$http.post(_config.receiverdomain+'/ajax/post/',
		{
			type 		: 'getPopupScreenVariables',
			url 		: url,
			sessionid	: ctrl.getSessionID()

		}).success(function(d,s,h,c){
			//
			var template = {};

			if (d.show) {
				template = {
					'settings' 	: angular.fromJson(d.data.screen.variables.settings),
					'screen' 	: angular.fromJson(d.data.screen.variables.screen),
					'content' 	: angular.fromJson(d.data.screen.variables.content),
					'interacion': angular.fromJson(d.data.screen.variables.interacion),
					'links' 	: angular.fromJson(d.data.screen.variables.links),
				}
			};

			callback(d, template);

		});
	}

	this.logShow = function( c, s) {

		$http.post(_config.receiverdomain+'/ajax/post/',
		{
			type 		: 'logPopupScreenshow',
			creative 	: c,
			screen 		: s,
			sessionid	: ctrl.getSessionID()

		}).success(function(d,s,h,c){
			console.log(d);
		});
	}

	this.getSessionID = function() {
		return $cookies.get('popupHostSessionID');
	}

	this.checkCookie = function( domain ) {
		var user = $cookies.get('popupHostSessionID');

		// Create
		if (typeof user === 'undefined')
		{
			var key = Math.floor((Math.random()*999999999)+111111111);
			var expires = new Date();
			expires.setDate(expires.getDate() + 30);
			$cookies.put('popupHostSessionID', key, { 'path' : '/', 'domain' : domain, 'expires' : expires });
			user = key;
		}
	}

	this.loadTemplate = function( savedTemplate )
	{

		if ( savedTemplate.settings.type == '%' && $scope.windowWidth() < _config.contentWidth )
		{
			savedTemplate.settings.width = 95;
			savedTemplate.content.title.size  = savedTemplate.content.title.size - (savedTemplate.content.title.size / 100 * 20 );
			savedTemplate.interacion.main.text_size = savedTemplate.interacion.main.text_size - (savedTemplate.interacion.main.text_size / 100 * 30);
		}

		if ( savedTemplate.settings.type == 'px' && $scope.windowWidth() < savedTemplate.settings.width  )
		{
			savedTemplate.settings.width = $scope.windowWidth() - 10;
			savedTemplate.content.title.size  = savedTemplate.content.title.size - (savedTemplate.content.title.size / 100 * 20 );
			savedTemplate.interacion.main.text_size = savedTemplate.interacion.main.text_size - (savedTemplate.interacion.main.text_size / 100 * 30);
		}

		// Settings
		$scope.settings = {};
		$scope.settings.width 	= 50;
		$scope.settings.type 	= '%';
		$scope.settings.width_types = ['px', '%'];
		$scope.settings.background_color = 'rgba(255, 121, 154, 0.79)';
		angular.extend($scope.settings, savedTemplate.settings);

		// Screen
		$scope.screen = {};
		$scope.screen.padding 			= 10;
		$scope.screen.background_color 	= 'rgba(212, 28, 79, 1)';
		$scope.screen.background_image 	= '';
		$scope.screen.background_pos 	= {
			'left top' : 'Balra fentre',
			'left center' : 'Balra középre',
			'left bottom' : 'Balra alulra',
			'right top' : 'Jobbra fentre',
			'right center' : 'Jobbra középre',
			'right bottom' : 'Jobbra alulra',
			'center top' : 'Középre fentre',
			'center center' : 'Középre',
			'center bottom' : 'Középre alulra'
		};
		$scope.screen.background_pos_sel= 'center center';
		$scope.screen.background_reps   = { 'no-repeat' : 'Nincs ismétlődés', 'repeat' : 'Ismétlődik', 'repeat-x' : 'Horizontális tengelyen ismétlődik', 'repeat-y' : 'Vertikális tengelyen ismétlődik'};
		$scope.screen.background_repeat = 'no-repeat';
		$scope.screen.background_sizes 	= { '' : 'Eredeti méret', 'contain' : 'Tartalomhoz igazít', 'cover' : 'Kitöltés', '100%' : '100% szélesség'};
		$scope.screen.background_size 	= '';
		$scope.screen.border_color 		= 'rgba(255, 255, 255, 0.2)';
		$scope.screen.border_size 		= 5;
		$scope.screen.border_type 		= "solid";
		$scope.screen.border_types 		= ['dotted','dashed','solid','double','groove','ridge','inset','outset'];
		$scope.screen.shadow_radius		= 50;
		$scope.screen.shadow_color		= '#000';
		$scope.screen.shadow			= { 'x' : 0, 'y' : 15 };
		$scope.screen.shadow_width		= -5;
		$scope.screen.cssstyles			= '';

		// Szöveg
		$scope.screen.text_color 		= "#fff";
		$scope.screen.text_size 		= 1;
		$scope.screen.text_align		= 'center';

		savedTemplate.screen.background_pos = $scope.screen.background_pos;
		savedTemplate.screen.background_reps = $scope.screen.background_reps;
		savedTemplate.screen.background_sizes = $scope.screen.background_sizes;
		savedTemplate.screen.border_types = $scope.screen.border_types;

		angular.extend($scope.screen, savedTemplate.screen);

		// Content
		$scope.content 					= {};
		$scope.content.title 			= {};
		$scope.content.title.text 		= 'Főcím';
		$scope.content.title.color 		= '';
		$scope.content.title.size 		= 2.4;
		$scope.content.title.align 		= '';

		$scope.content.subtitle 			= {};
		$scope.content.subtitle.text 		= 'Alcím';
		$scope.content.subtitle.color 		= '';
		$scope.content.subtitle.size 		= 1.4;
		$scope.content.subtitle.align 		= '';

		$scope.content.fill 			= {};
		$scope.content.fill.text 		= 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel metus id arcu fermentum rutrum. Aenean neque ante, dignissim non massa non, cursus malesuada nulla. Ut sodales volutpat leo vel lobortis. Nulla sagittis tempor dolor at laoreet. Donec at pharetra mauris. Cras at tortor at sapien condimentum facilisis. Vivamus quis erat non nisl dapibus fermentum in sit amet mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus non dapibus ligula. Donec ac nunc interdum, ultricies ligula vitae, cursus lacus. Cras imperdiet ultrices turpis a pulvinar. Phasellus id tortor vitae ante ultrices elementum eget at elit. Duis cursus arcu et magna porttitor, eget maximus mauris dignissim.';
		$scope.content.fill.color 		= '';
		$scope.content.fill.size 		= 1;
		$scope.content.fill.align 		= '';


		savedTemplate.content.fill.text = savedTemplate.content.fill.text.replace( '../', _config.imageRoot);

		$scope.textHTML 	= function(){
			 return $sce.trustAsHtml($scope.content.fill.text);
		}

		angular.extend($scope.content, savedTemplate.content);

		// Interakció
		$scope.interacion 					= {};
		$scope.interacion.main 				= {};
		$scope.interacion.main.text 		= 'Tovább';
		$scope.interacion.main.text_color 	= 'rgba(255,255,255,1)';
		$scope.interacion.main.text_size 	= 1.8;
		$scope.interacion.main.text_custom 	= '';
		$scope.interacion.main.text_align 	= 'center';
		$scope.interacion.main.background  	= 'rgba(0,0,0,1)';
		$scope.interacion.main.width 		= 60;
		$scope.interacion.main.width_type   = '%';
		$scope.interacion.main.width_types  = ['%', 'px'];
		$scope.interacion.main.padding  	= 10;
		$scope.interacion.main.margin  		= 10;
		$scope.interacion.main.border_color = '#fff';
		$scope.interacion.main.border_width = 2;
		$scope.interacion.main.border_style = 'solid';
		$scope.interacion.main.border_radius = 10;

		// Kilépő
		$scope.interacion.exit 				= {};
		$scope.interacion.exit.text 		= 'Nem érdekel';
		$scope.interacion.exit.text_color 	= 'rgba(255,255,255,0.8)';
		$scope.interacion.exit.text_style 	= 'italic';
		$scope.interacion.exit.text_styles 	= { 'bold' : 'Félkövér', 'italic' : 'Dölt', 'normal' : 'Normál' };
		$scope.interacion.exit.text_size 	= 0.8;
		$scope.interacion.exit.text_custom 	= '';

		angular.extend($scope.interacion, savedTemplate.interacion);

		// Linkek
		$scope.links 			= {};
		$scope.links.to_url 	= '#';
		$scope.links.exit_url 	= 'javascript:popupClose();';
		$scope.links.open_type 	= '_blank';
		$scope.links.open_types = {'_blank': 'Új ablakban', '_self':'Helyben'};

		angular.extend($scope.links, savedTemplate.links);
	}
}]);
