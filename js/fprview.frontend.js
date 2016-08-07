/**
 * fprview.frontend.js
 * Module fprviewFrontend
 */

/*global $, fprviewFrontend */

//------------------- BEGIN JQUERY FUNCTIONS ------------------
{if isset($fprview_settings.button_hide) && $fprview_settings.button_hide === 'on'}
jQuery.fn.extend({
    getSelectorPath: function () {
        var path, node = this;

        while (node.length) {
            var realNode = node[0], name = realNode.localName;

            if (!name) break;

            name = name.toLowerCase();

            var parent = node.parent();

            path = name + (path ? '>' + path : '');
            node = parent;
        }

        return path;
    }
});
{/if}
//-------------------- END JQUERY FUNCTIONS -------------------

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
	            type     : 'ajax',
	            href     : $(this).attr('href'),
	        	autoSize : false,
			    width    : "60%",
			    height   : "auto"
	        });

	        {if isset($fprview_settings.button_hide) && $fprview_settings.button_hide === 'on'}
	        $(this).hide();
	        {/if}
	    });  

		{if isset($fprview_settings.button_hide) && $fprview_settings.button_hide === 'on'}
		var viewButtonClass = '.fprview-more-info',
	 		viewButtonParent = $(viewButtonClass).parent();
console.log(viewButtonParent.getSelectorPath());
	    $(document).on('mouseenter', viewButtonParent.getSelectorPath(), function () {
	    	var viewButton = $(this).find(viewButtonClass);
	    	if (viewButton) {
	    		viewButton.css('display', 'block');
	    	}
	    });
	    $(document).on('mouseleave', viewButtonParent.getSelectorPath(), function () {
	    	var viewButton = $(this).find(viewButtonClass);
	    	if (viewButton) {
	    		viewButton.css('display', 'none');
	    	}
	    });
	    {/if}

	};

	return {
		initModule: initModule
	};
	//------------------- END PUBLIC METHODS ----------------------
}());