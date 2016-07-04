<?php
return array(
    'name' => 'Быстрый просмотр товара',
    'description' => /*_wp*/('BLABLABLA'),
    'img' => 'img/fprview.png',
    'vendor' => 1020720,
    'version' => '1.0.0',
    'shop_settings' => true,
    'frontend' => true,
    'handlers' => array(
        'frontend_head' => 'frontendHeader',
    ),
);