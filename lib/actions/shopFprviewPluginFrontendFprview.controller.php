<?php

class shopFprviewPluginFrontendFprviewController extends shopFrontendAction {

    public function execute() {
        $id = (int)waRequest::get('id');    

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
                $view->assign('theme_path', $theme_path);

                $html = $view->fetch(realpath(dirname(__FILE__)."/../../").'/templates/Frontend.html');

                break;
            case 'theme':

                $view = wa()->getView(array('template_dir' => $theme_path));

                $view->assign(array(
                    'reply_allowed' => false,
                    'features' => $features,
                    'product' => $product
                ));

                $template = $this->setThemeTemplate('product.html');
                $html = $view->fetch($this->getTemplate());

                break;
            
            default:
                $html = '';
                break;
        }

        echo $html;
        exit();
    }      
     
}