<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php 
		$cs = Yii::app()->getClientScript();
  		$cs->registerCoreScript('jquery');
  		$cs->registerCoreScript('bbq');
		$cs->registerCssFile(Yii::app()->baseUrl.'/css/styles.css');
	?>
 
  	<?php 
$script=<<<HTML
			function applychanges(obj) {
					for(k in obj) {
						jQuery(k).html(obj[k]);
					}	
			}
HTML;
$cs->registerScript('applychanges', $script, CClientScript::POS_HEAD);
?>	
 
  	<?php 
$script=<<<HTML
		var headline = $("#loading");
 
		$(document).ajaxSend(function() {
			headline.css({"left":((screen.width-headline.width())/2)+"px"});
    		headline.attr("class", "activity");
		});
 
		$(document).ajaxStop(function() {
    		headline.removeAttr("class")
		 	});
HTML;
$cs->registerScript('loading-indicator', $script, CClientScript::POS_READY);

$script=<<<HTML
 
  // handling links and forms
 
  $("a:not(.direct)").live("click", function(){		  	
		    var href = $(this).attr( "href" );		    
		    if(href=="#")
		    	return false;	
 
		    $.bbq.pushState({ url: href});  
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
 
		  		$.bbq.pushState({ url: url});
 
		  	} else {
		  		jQuery.ajax({
					type:"post",
					data:$(this).serialize(),
					url:jQuery(this).attr("action"),
						success:applychanges
					});
				}	
 
 
		  	return false;
		  })
 
			$(window).bind( "popstate", function(event) {
 				if(event.originalEvent.state !== null){
 				$.bbq.pushState({url:event.originalEvent.state.url});
				}
 				});
		   $(window).bind( "hashchange", function(e) {	    
    		var url = $.bbq.getState( "url" );    		
 
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
					success:applychanges
				});
 
		  });
 
		  $(window).trigger( "hashchange" );
 
HTML;
$cs->registerScript('ajaxlinks-and-forms', $script, CClientScript::POS_READY);
?>
</head>

<body>
<div id="loading"><?php echo Yii::t('main','Loading');?></div>
<div id="mainmenu" > 
<?php $this->renderPartial('/includes/menu');?>
</div>
<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
