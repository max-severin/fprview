/**
 * fprview.backend.settings.js
 * Module fprviewBackendSettings
 */

/*global $, fprviewBackendSettings */

var fprviewBackendSettings = (function () { "use strict";
    //---------------- BEGIN MODULE SCOPE VARIABLES ---------------
    var
        farbtastic_url = "{$wa_url}wa-content/js/farbtastic/farbtastic.js?{$wa->version(true)}",
        initColorPicker, setColorPickerElement, setColorPicker, changeColorPickerInputValue, initModule;
    //----------------- END MODULE SCOPE VARIABLES ----------------

    //--------------------- BEGIN DOM METHODS ---------------------

    initColorPicker = function (elements, init) {
    	if ($.fn.farbtastic) {
            init(elements);
        } else {
            $.ajax({
                dataType: "script",
                url: farbtastic_url,
                cache: true
            }).done(function () {
                init(elements);
            });
        }
    };

    setColorPickerElement = function (el) {
        var color_wrapper = el.closest('.value');
        var color_picker = color_wrapper.find('.s-colorpicker');
        var color_replacer = color_wrapper.find('.s-color-replacer');
        var color_input = color_wrapper.find('.s-color');

        var farbtastic = $.farbtastic(color_picker, function(color) {
            color_replacer.find('i').css('background', color);
            color_input.val(color.substr(1));
            color_input.trigger('change');
        });

        farbtastic.setColor('#'+color_input.val());

        color_replacer.click(function () {
            color_picker.slideToggle(200);
            return false;
        });
    };

    setColorPicker = function (color_elements) {
        for (var i = 0; i < color_elements.length; i++) {

            setColorPickerElement( $(color_elements[i]) );

        }
    };
    //--------------------- END DOM METHODS -----------------------

    //------------------- BEGIN EVENT HANDLERS --------------------
    changeColorPickerInputValue = function (input, $color) {
        var color = 0xFFFFFF & parseInt(('' + input.value + 'FFFFFF').replace(/[^0-9A-F]+/gi, '').substr(0, 6), 16);
        $color.css('background', (0xF000000 | color).toString(16).toUpperCase().replace(/^F/, '#'));
    };
    //------------------- END EVENT HANDLERS ----------------------

    //------------------- BEGIN PUBLIC METHODS --------------------
    initModule = function () {

        var color_elements = [
            '#fprview_shop_fprview_button_color',
            '#fprview_shop_fprview_button_background_color',
            '#fprview_shop_fprview_button_color_hover',
            '#fprview_shop_fprview_button_background_color_hover',
            '#fprview_shop_fprview_custom_template_color',
            '#fprview_shop_fprview_custom_template_background_color'
        ];

        initColorPicker( color_elements, setColorPicker );

        var timer = {};
        $('.s-color').unbind('keydown').bind('keydown', function () {
            if (timer[this.name]) {
                clearTimeout(timer[this.name]);
            }
            var input = this;
            timer[this.name] = setTimeout(function () {
                var $color = $(input).parent().find('.icon16.color');
                changeColorPickerInputValue(input, $color);
            }, 300);
        });

        var cm1 = CodeMirror.fromTextArea(document.getElementById('fprview_shop_fprview_button_template'), {
            mode: "text/html",
            tabMode: "indent",
            height: "dynamic",
            lineWrapping: true
        });   

        var cm2 = CodeMirror.fromTextArea(document.getElementById('fprview_shop_fprview_button_style'), {
            mode: "text/html",
            tabMode: "indent",
            height: "dynamic",
            lineWrapping: true
        });   

        var buttonTemplate = document.getElementById("button-template-origin");
        var cm3 = CodeMirror(function(node){
            buttonTemplate.parentNode.replaceChild(node, buttonTemplate);
        }, {
            value: buttonTemplate.textContent || buttonTemplate.innerText,
            mode: "text/html",
            readOnly: true
        });   

        var buttonStyle = document.getElementById("button-style-origin");
        var cm4 = CodeMirror(function(node){
            buttonStyle.parentNode.replaceChild(node, buttonStyle);
        }, {
            value: buttonStyle.textContent || buttonStyle.innerText,
            mode: "text/html",
            readOnly: true
        }); 

        $('#button-template-get-origin').closest('.hint').find('.CodeMirror').hide();
        $('#button-style-get-origin').closest('.hint').find('.CodeMirror').hide();

        $('body').on('click', '#button-template-get-origin', function () {
            $(this).closest('.hint').find('.CodeMirror').toggle();
            return false;
        });

        $('body').on('click', '#button-style-get-origin', function () {
            $(this).closest('.hint').find('.CodeMirror').toggle();
            return false;
        });

        if ($('#fprview_shop_fprview_template_type').val() == 'plugin') {
            $('#fprview_shop_fprview_template_theme_file').closest('.field').hide();
            $('#fprview_shop_fprview_custom_template_color, #fprview_shop_fprview_custom_template_background_color').closest('.field').show();
        } else if ($('#fprview_shop_fprview_template_type').val() == 'theme') {
            $('#fprview_shop_fprview_template_theme_file').closest('.field').show();
            $('#fprview_shop_fprview_custom_template_color, #fprview_shop_fprview_custom_template_background_color').closest('.field').hide();
        }

        $('body').on('change', '#fprview_shop_fprview_template_type', function () {
            console.log($(this).val());
            if ($(this).val() == 'plugin') {
                $('#fprview_shop_fprview_template_theme_file').closest('.field').hide();
                $('#fprview_shop_fprview_custom_template_color, #fprview_shop_fprview_custom_template_background_color').closest('.field').show();
            } else if ($(this).val() == 'theme') {
                $('#fprview_shop_fprview_template_theme_file').closest('.field').show();
                $('#fprview_shop_fprview_custom_template_color, #fprview_shop_fprview_custom_template_background_color').closest('.field').hide();
            }
        });

        $('#fprview_shop_fprview_button_template').closest('.field').find('.CodeMirror').css('height', '95px');
        $('#fprview_shop_fprview_button_template').closest('.field').find('.CodeMirror-scroll').css('height', '65px');
        

        $('.plugin-links a').css({
            'display': 'block',
            'top': '-500px'
        }).animate({
            'top': '0'
        }, 500).animate({
            'top': '-25px'
        }, 100).animate({
            'top': '-35px'
        }, 100).animate({
            'top': '0'
        }, 250);

    };

    return {
        initModule: initModule
    };
    //------------------- END PUBLIC METHODS ----------------------
}());