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
        'title'        => _wp('Fancybox status'),
        'description'  => _wp('If the fancybox library is already loaded in your template disable this setting'),
        'value'        => 'enable',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'enable'  => _wp('Enable'),
            'disable' => _wp('Disable'),
        ),
    ),
    'bxslider_status' => array(
        'title'        => _wp('bxslider status'),
        'description'  => _wp('If the bxslider library is already loaded in your template disable this setting'),
        'value'        => 'enable',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'enable'  => _wp('Enable'),
            'disable' => _wp('Disable'),
        ),
    ),
    'template_type' => array(
        'title'        => _wp('Template type'),
        'value'        => 'plugin',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            'plugin' => _wp('Plugin custom template'),
            'theme'  => _wp('Theme standard template'),
        ),
    ),
    'template_theme_file' => array(
        'title'        => _wp('Template file'),
        'description'  => _wp('If you chose "Theme standard template" fill the file name'),
        'placeholder'  => 'product.html',
        'value'        => 'product.html',
        'control_type' => waHtmlControl::INPUT,
    ),
    'button_color' => array(
        'title'        => _wp('button_color'),
        'class'        => 's-color',
        'value'        => 'ffffff',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
    'button_background_color' => array(
        'title'        => _wp('button_background_color'),
        'class'        => 's-color',
        'value'        => '21a6de',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
    'button_color_hover' => array(
        'title'        => _wp('button_color_hover'),
        'class'        => 's-color',
        'value'        => 'dddddd',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
    'button_background_color_hover' => array(
        'title'        => _wp('button_background_color_hover'),
        'class'        => 's-color',
        'value'        => '1196ce',
        'control_type' => waHtmlControl::CUSTOM.' '.'shopFprviewPlugin::settingColorControl',
    ),
    'button_template' => array(
        'title'        => _wp('View button template'),
        'description'  => '<a id="button-template-get-origin" href="#">Исходный код шаблона</a>
<p id="button-template-warning"><b>Важно</b>: у ссылки обязательно должен быть аттрибут <b>class="fprview-more-info"</b></p>
<br /><br />
<p id="button-template-origin">
&#060;a href="{$wa_url}fprview/?id={$product_id}" class="fprview-more-info"&#062;Быстрый просмотр&#060;/a&#062;
</p>',
        'value'        => '<a href="{$wa_url}fprview/?id={$product_id}" class="fprview-more-info">Быстрый просмотр</a>',
        'control_type' => waHtmlControl::TEXTAREA,
    ),
    'button_style' => array(
        'title'        => _wp('View button style'),
        'description'  => '<a id="button-style-get-origin" href="#">Исходный код шаблона</a><br /><br />
<p id="button-style-origin">
&#060;style&#062;
  .fprview-more-info {
    border-radius: 2px;
    display: block;
    font-size: 1.05em;
    margin: 40% 10% 0;
    padding: 10px 0;
    position: absolute;
    text-align: center;
    text-decoration: none;
    width: 80%;
  }
  .fprview-more-info:hover {
    
  }
&#060;/style&#062;
</p>',
        'value'        => '<style>
.fprview-more-info {
    border-radius: 2px;
    display: block;
    font-size: 1.05em;
    margin: 40% 10% 0;
    padding: 10px 0;
    position: absolute;
    text-align: center;
    text-decoration: none;
    width: 80%;
}
.fprview-more-info:hover {

}
</style>',
        'control_type' => waHtmlControl::TEXTAREA,
    ),
);