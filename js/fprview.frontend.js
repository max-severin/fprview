/**
 * fprview.frontend.js
 * Module fprviewFrontend
 */

/*global $, fprviewFrontend */

var fprviewFrontend = (function () { "use strict";
	//---------------- BEGIN MODULE SCOPE VARIABLES ---------------
	var
		initModule;
	//----------------- END MODULE SCOPE VARIABLES ----------------

	//------------------- BEGIN PUBLIC METHODS --------------------
	initModule = function () {

		$(document).on('click', '.fprview-more-info', function(event){
			event.preventDefault();

	        $.fancybox({
	            width: '50%',
	            height: '50%',
	            href: $(this).attr('href'),
	            type: 'ajax'
	        });

	        {if isset($fprview_settings.button_hide) && $fprview_settings.button_hide === 'on'}
	        $(this).hide();
	        {/if}
	    });  

		{if isset($fprview_settings.button_hide) && $fprview_settings.button_hide === 'on'}
	    $('.fprview-more-info').parent().mouseenter(function () {
	    	$(this).find('.fprview-more-info').show();
	    });
	    $('.fprview-more-info').parent().mouseleave(function () {
	    	$(this).find('.fprview-more-info').hide();
	    });
	    {/if}

	};

	return {
		initModule: initModule
	};
	//------------------- END PUBLIC METHODS ----------------------
}());