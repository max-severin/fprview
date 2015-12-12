<?php

class shopFprviewPluginFrontendFprviewController extends waJsonController {

    public function execute() {
        $id = (int)waRequest::get('id');      
        
        $product = new shopProduct($id);
        $route_params = array('product_url' => $product['url']);
        if (isset($product['category_url'])) {
            $route_params['category_url'] = $product['category_url'];
        }

        $product['frontend_url'] = wa()->getRouteUrl('shop/frontend/product', $route_params);

        $feature_codes = array_keys($product->features);
        $feature_model = new shopFeatureModel();
        $features = $feature_model->getByCode($feature_codes);

        $view = wa()->getView();
        $view->assign('features', $features);
        $view->assign('product', $product);
        $html = $view->fetch(realpath(dirname(__FILE__)."/../../").'/templates/Frontend.html');

        echo $html;
        exit();
    }  
     
}