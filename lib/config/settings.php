<?php

/*
 * @author Max Severin <makc.severin@gmail.com>
 */
return array(
    'status' => array(
        'title'        => _wp('Status'),
        'value'        => 'off',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'off' => _wp('Off'),
            'on'  => _wp('On'),
        ),
    ),

    'fancybox_status' => array(
        'title'        => _wp('FancyBox status'),
        'description'  => _wp('FancyBox is a tool for displaying product content in modal window. If the FancyBox library is already loaded in your template, disable this setting.'),
        'value'        => 'on',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'on'  => _wp('On'),
            'off' => _wp('Off'),
        ),
    ),
    'bxslider_status' => array(
        'title'        => _wp('BxSlider status'),
        'description'  => _wp('BxSlider is a content slider. Used within the template of plugin in the frontend to slide product images. If the BxSlider library is already loaded in your template disable this setting.'),
        'value'        => 'on',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'on'  => _wp('On'),
            'off' => _wp('Off'),
        ),
    ),

    'template_type' => array(
        'title'        => _wp('Template type'),
        'description'  => _wp('If you want to see standard template of your theme in product preview (usually it is <b>product.html</b>), select «Theme standard template».'),
        'value'        => 'plugin',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'plugin' => _wp('Plugin custom template'),
            'theme'  => _wp('Theme standard template'),
        ),
    ),
    'template_theme_file' => array(
        'title'        => _wp('Template file'),
        'description'  => _wp('If you chose «Theme standard template» fill the file name.'),
        'placeholder'  => 'product.html',
        'value'        => 'product.html',
        'control_type' => waHtmlControl::INPUT,
    ),

    'button_template' => array(
        'title'        => _wp('Preview button template'),
        'description'  => '<a id="button-template-get-origin" href="#">'. _wp('Template source code') .'</a>
<p id="button-template-warning"><b>'. _wp('Warning') .'</b>: '. _wp('the link must have attributes') .':<br /><b>href="{$wa->getUrl(\'/frontend/fprview/\')}?id={$product_id}"</b><br /><b>class="fprview-more-info"</b></p>
<br /><br />
<p id="button-template-origin">
&#060;button href="{$wa->getUrl(\'/frontend/fprview/\')}?id={$product_id}" class="fprview-more-info"&#062;'. _wp('Fast Preview') .'&#060;/button&#062;
</p>',
        'value'        => '<button href="{$wa->getUrl(\'/frontend/fprview/\')}?id={$product_id}" class="fprview-more-info">'. _wp('Fast Preview') .'</button>',
        'control_type' => waHtmlControl::TEXTAREA,
    ),

    'button_style' => array(
        'title'        => _wp('Preview button style'),
        'description'  => '<a id="button-style-get-origin" href="#">'. _wp('Template source code') .'</a><br /><br />
<p id="button-style-origin">
&#060;style&#062;
  .fprview-more-info {
    border: 0 none;
    border-radius: 2px;
    cursor: pointer;
    display: block;
    font-size: 1.1em;
    font-weight: normal;
    margin: 40% 10% 0;
    opacity: 0.7;
    padding: 10px 0;
    position: absolute;
    text-align: center;
    text-decoration: none;
    width: 80%;
  }
  .fprview-more-info:hover {
    opacity: 1;
  }
&#060;/style&#062;
</p>',
        'value'        => '<style>
.fprview-more-info {
    border: 0 none;
    border-radius: 2px;
    cursor: pointer;
    display: block;
    font-size: 1.1em;
    font-weight: normal;
    margin: 40% 10% 0;
    opacity: 0.7;
    padding: 10px 0;
    position: absolute;
    text-align: center;
    text-decoration: none;
    width: 80%;
}
.fprview-more-info:hover {
    opacity: 1;
}
</style>',
        'control_type' => waHtmlControl::TEXTAREA,
    ),

    'button_hide' => array(
        'title'        => _wp('Preview button hide'),
        'description'  => _wp('If you want to have the preview button visible only when you hover the mouse over the product and for all the others remained hidden, enable this setting. Otherwise, the button is displayed for all products.'),
        'value'        => 'off',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'off' => _wp('Off'),
            'on'  => _wp('On'),
        ),
    ),
    'button_color' => array(
        'title'        => _wp('Preview button text color'),
        'class'        => 's-color',
        'value'        => 'ffffff',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
    'button_background_color' => array(
        'title'        => _wp('Preview button background color'),
        'class'        => 's-color',
        'value'        => '21a6de',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
    'button_color_hover' => array(
        'title'        => _wp('Preview button text color on mouse hover'),
        'class'        => 's-color',
        'value'        => 'dddddd',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
    'button_background_color_hover' => array(
        'title'        => _wp('Preview button background color on mouse hover'),
        'class'        => 's-color',
        'value'        => '1196ce',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),

    'custom_template_target_blank' => array(
        'title'        => _wp('Links in new tab'),
        'description'  => _wp('Enable this setting if you want to open product links in a new browser tab.'),
        'value'        => 'on',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'off' => _wp('Off'),
            'on'  => _wp('On'),
        ),
    ),
    'custom_template_color' => array(
        'title'        => _wp('Text color in plugin custom template'),
        'description'  => _wp('Text color in the header and footer.'),
        'class'        => 's-color',
        'value'        => 'ffffff',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
    'custom_template_background_color' => array(
        'title'        => _wp('Background color in plugin custom template'),
        'description'  => _wp('Background color of the header and footer, color of content borders and product link.'),
        'class'        => 's-color',
        'value'        => '21a6de',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
);