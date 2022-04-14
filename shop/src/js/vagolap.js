 $(document).ready(function() {
	var clip = new ZeroClipboard($('.copy'), {
	  moviePath: "/public/DreamFish/swf/ZeroClipboard.swf"
	});
		
	clip.on( 'complete', function(client, args) {
	 /* this.style.display = 'none'; // "this" is the element that was clicked*/
	 	hideAlt();
	  $('.alrt').html('<div style="color:red;"><strong>Vágolapra másolva:</strong> '+args.text+'</div>').show(250);
	  
	  if($(this).attr("close") == 1){
	  	window.close();
	  }else{
		  alert('Oldal elérhetősége vágólapra másolva!');
	  }
	  //setTimeout('hideAlt();',3500);
	} );
	
	
});

function hideAlt(){
	$('.alrt').hide(250);
}