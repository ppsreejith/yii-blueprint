/**
 * @author Sreejith
 */
function applychanges(obj) {
		for(k in obj) {
			jQuery(k).html(obj[k]);
		}
};
(function(){
	window.onload=function(){
		var headline = $("#loading");
		$(document).ajaxSend(function(){
			headline.css({"left":((screen.width-headline.width())/2)+"px"});
			headline.attr("class", "activity");
		});
		 
		$(document).ajaxStop(function() {
			headline.removeAttr("class")
		});
	};
}());
(function(){
		 	 
  $("a:not(.direct)").live("click", function(){		  	
		    var href = $(this).attr( "href" );		    
		    if(href=="#")
		    	return false;	
 
			location.hash=href;
		    return false;
		  });
 
 
 
		  $("form:not(.direct)").live("submit", function(){
		  	var url = "";
 
			var type = jQuery(this).attr("method");
 
			if(type==undefined)
		  		type = "get";
 
		  	if(type=="get") {
 
		  		var action = jQuery(this).attr("action");
		  		if(action.indexOf("?")==-1)
		  			url = action + "?" + jQuery(this).serialize();
		  		else 
		  			url = action + "&"	+ jQuery(this).serialize();
 
		  		location.hash=url;
 
		  	} else {
		  		jQuery.ajax({
					type:"post",
					data:$(this).serialize(),
					url:jQuery(this).attr("action"),
					success:applychanges,
					});
				}	
 
 
		  	return false;
		  })
 
			$(window).bind( "popstate", function(event) {
 				if(event.originalEvent.state !== null){
 				location.hash=event.originalEvent.state.url;
				}
 				});
		   $(window).bind( "hashchange", function(e){
    		var url = location.hash.substring(1);
 
    		if(!url || url.indexOf("/")==-1)
    			return;
			window.history.replaceState({url:url},"",url);
			
		    $("a").each(function(){
		      var href = $(this).attr( "href" );
 
		      if ( href === url ) {
		      	$(this).addClass( "current" ); $(this).parent("li").addClass( "active" );
 
		      } else {
		        $(this).removeClass( "current" ); $(this).parent("li").removeClass( "active" );
		      }
		    });
 
				jQuery.ajax({
					type:"get",
					url:url,
					success:applychanges,
				});
 
		  });
 
		  $(window).trigger( "hashchange" );
 }());