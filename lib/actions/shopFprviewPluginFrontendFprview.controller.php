<?php

class shopFprviewPluginFrontendFprviewController extends shopFrontendAction {
    /**
     * @var shopProductReviewsModel
     */
    protected $reviews_model;

    public function __construct($params = null) {
        $this->reviews_model = new shopProductReviewsModel();
        parent::__construct($params);
    }

    public function execute() {
        $id = (int)waRequest::get('id');  

        $html = '';  

        $app_settings_model = new waAppSettingsModel();
        $settings = $app_settings_model->get(array('shop', 'fprview'));  
        
        $product = new shopProduct($id);
        $route_params = array('product_url' => $product['url']);
        if (isset($product['category_url'])) {
            $route_params['category_url'] = $product['category_url'];
        }

        $product['frontend_url'] = wa()->getRouteUrl('shop/frontend/product', $route_params);

        $feature_codes = array_keys($product->features);
        $feature_model = new shopFeatureModel();
        $features = $feature_model->getByCode($feature_codes);        

        $theme = waRequest::param('theme', 'default');
        $theme_path = wa()->getDataPath('themes', true).'/'.$theme;

        if (!file_exists($theme_path) || !file_exists($theme_path.'/theme.xml')) {
            $theme_path = wa()->getAppPath().'/themes/'.$theme;
        }

        switch ($settings['template_type']) {
            case 'plugin':

                $view = wa()->getView();

                $view->assign('features', $features);
                $view->assign('product', $product);
                
                $view->assign('fprview_settings', $settings);

                $html = $view->fetch(realpath(dirname(__FILE__)."/../../").'/templates/Frontend.html');

                break;
            case 'theme':

                if ($settings['template_theme_file'] && file_exists($theme_path . '/' . $settings['template_theme_file'])) {

                    $view = wa()->getView(array('template_dir' => $theme_path));

                    list($services, $skus_services) = $this->getServiceVars($product);

                    $compare = waRequest::cookie('shop_compare', array(), waRequest::TYPE_ARRAY_INT);

                    $view->assign(array(
                        'sku_services'  => $skus_services,
                        'services'      => $services,
                        'compare'       => in_array($product['id'], $compare) ? $compare : array(),
                        'currency_info' => $this->getCurrencyInfo(),
                        'stocks'        => shopHelper::getStocks(true),

                        'reviews'              => $this->getTopReviews($product['id']),
                        'rates'                => $this->reviews_model->getProductRates($product['id']),
                        'reviews_total_count'  => $this->getReviewsTotalCount($product['id']),

                        'features'      => $features,
                        'product'       => $product
                    ));

                    $view->assign('frontend_product', wa()->event('frontend_product', $product, array('menu', 'cart', 'block_aux', 'block')));

                    $template = $this->setThemeTemplate($settings['template_theme_file']);
                    $html = $view->fetch($this->getTemplate());

                }

                break;
            
            default:
                $html = '';
                break;
        }

        echo $html;
        exit();
    }      

    protected function getServiceVars($product) {
        $type_services_model = new shopTypeServicesModel();
        $services = $type_services_model->getServiceIds($product['type_id']);

        // Fetch services
        $service_model = new shopServiceModel();
        $product_services_model = new shopProductServicesModel();
        $services = array_merge($services, $product_services_model->getServiceIds($product['id']));
        $services = array_unique($services);
        $services = $service_model->getById($services);
        shopRounding::roundServices($services);

        // Convert service.price from default currency to service.currency
        foreach($services as &$s) {
            $s['price'] = shop_currency($s['price'], null, $s['currency'], false);
        }
        unset($s);

        // Fetch service variants
        $variants_model = new shopServiceVariantsModel();
        $rows = $variants_model->getByField('service_id', array_keys($services), true);
        shopRounding::roundServiceVariants($rows, $services);
        foreach ($rows as $row) {
            if (!$row['price']) {
                $row['price'] = $services[$row['service_id']]['price'];
            } else if ($services[$row['service_id']]['variant_id'] == $row['id']) {
                $services[$row['service_id']]['price'] = $row['price'];
            }
            $services[$row['service_id']]['variants'][$row['id']] = $row;
        }

        // Fetch service prices for specific products and skus
        $rows = $product_services_model->getByField('product_id', $product['id'], true);
        shopRounding::roundServiceVariants($rows, $services);
        $skus_services = array(); // sku_id => [service_id => price]
        $frontend_currency = wa('shop')->getConfig()->getCurrency(false);
        foreach ($product['skus'] as $sku) {
            $skus_services[$sku['id']] = array();
        }
        foreach ($rows as $row) {
            if (!$row['sku_id']) {
                if (!$row['status']) {
                    // remove disabled services and variants
                    unset($services[$row['service_id']]['variants'][$row['service_variant_id']]);
                } elseif ($row['price'] !== null) {
                    // update price for service variant, when it is specified for this product
                    $services[$row['service_id']]['variants'][$row['service_variant_id']]['price'] = $row['price'];
                    // !!! also set other keys related to price
                }
                if ($row['status'] == shopProductServicesModel::STATUS_DEFAULT) {
                    // default variant is different for this product
                    $services[$row['service_id']]['variant_id'] = $row['service_variant_id'];
                }
            } else {
                if (!$row['status']) {
                    $skus_services[$row['sku_id']][$row['service_id']][$row['service_variant_id']] = false;
                } else {
                    $skus_services[$row['sku_id']][$row['service_id']][$row['service_variant_id']] = $row['price'];
                }
            }
        }

        // Fill in gaps in $skus_services
        foreach ($skus_services as $sku_id => &$sku_services) {
            $sku_price = $product['skus'][$sku_id]['price'];
            foreach ($services as $service_id => $service) {
                if (isset($sku_services[$service_id])) {
                    if ($sku_services[$service_id]) {
                        foreach ($service['variants'] as $v) {
                            if (!isset($sku_services[$service_id][$v['id']]) || $sku_services[$service_id][$v['id']] === null) {
                                $sku_services[$service_id][$v['id']] = array($v['name'], $this->getPrice($v['price'], $service['currency'], $sku_price, $product['currency']));
                            } elseif ($sku_services[$service_id][$v['id']]) {
                                $sku_services[$service_id][$v['id']] = array($v['name'], $this->getPrice($sku_services[$service_id][$v['id']], $service['currency'], $sku_price, $product['currency']));
                            }
                        }
                    }
                } else {
                    foreach ($service['variants'] as $v) {
                        $sku_services[$service_id][$v['id']] = array($v['name'], $this->getPrice($v['price'], $service['currency'], $sku_price, $product['currency']));
                    }
                }
            }
        }
        unset($sku_services);

        // disable service if all variants are disabled
        foreach ($skus_services as $sku_id => $sku_services) {
            foreach ($sku_services as $service_id => $service) {
                if (is_array($service)) {
                    $disabled = true;
                    foreach ($service as $v) {
                        if ($v !== false) {
                            $disabled = false;
                            break;
                        }
                    }
                    if ($disabled) {
                        $skus_services[$sku_id][$service_id] = false;
                    }
                }
            }
        }

        // Calculate prices for %-based services,
        // and disable variants selector when there's only one value available.
        foreach ($services as $s_id => &$s) {
            if (!$s['variants']) {
                unset($services[$s_id]);
                continue;
            }
            if ($s['currency'] == '%') {
                foreach ($s['variants'] as $v_id => $v) {
                    $s['variants'][$v_id]['price'] = $v['price'] * $product['skus'][$product['sku_id']]['price'] / 100;
                }
                $s['currency'] = $product['currency'];
            }

            if (count($s['variants']) == 1) {
                $v = reset($s['variants']);
                if ($v['name']) {
                    $s['name'] .= ' '.$v['name'];
                }
                $s['variant_id'] = $v['id'];
                $s['price'] = $v['price'];
                unset($s['variants']);
                foreach ($skus_services as $sku_id => $sku_services) {
                    if (isset($sku_services[$s_id]) && isset($sku_services[$s_id][$v['id']])) {
                        $skus_services[$sku_id][$s_id] = $sku_services[$s_id][$v['id']][1];
                    }
                }
            }
        }
        unset($s);

        uasort($services, array('shopServiceModel', 'sortServices'));

        return array($services, $skus_services);
    }

    protected function getCurrencyInfo() {
        $currency = waCurrency::getInfo($this->getConfig()->getCurrency(false));
        $locale = waLocale::getInfo(wa()->getLocale());
        return array(
            'code'          => $currency['code'],
            'sign'          => $currency['sign'],
            'sign_html'     => !empty($currency['sign_html']) ? $currency['sign_html'] : $currency['sign'],
            'sign_position' => isset($currency['sign_position']) ? $currency['sign_position'] : 1,
            'sign_delim'    => isset($currency['sign_delim']) ? $currency['sign_delim'] : ' ',
            'decimal_point' => $locale['decimal_point'],
            'frac_digits'   => $locale['frac_digits'],
            'thousands_sep' => $locale['thousands_sep'],
        );
    }

    protected function getTopReviews($product_id) {
        return $this->reviews_model->getReviews($product_id,
            0, wa()->getConfig()->getOption('reviews_per_page_product'),
            'datetime DESC',
            array('escape' => true)
        );
    }

    protected function getReviewsTotalCount($product_id) {
        return $this->reviews_model->count($product_id, true);
    }
     
}