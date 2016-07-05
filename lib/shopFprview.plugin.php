<?php

/*
 * Class shopFprviewPlugin
 * Fast product view plugin for Webasyst Shop-Script
 * 
 * @author Max Severin <makc.severin@gmail.com>
 */
class shopFprviewPlugin extends shopPlugin {	
    
    /**
     * Handler for frontend_head event: add fprviewFrontend module in frontend head section
     * @return string
     */
    public function frontendHeader() {
        $settings = $this->getSettings();

        if ( isset($settings['status']) && $settings['status'] === 'on' ) {            

            $view = wa()->getView();
            $view->assign('fprview_settings', $settings);

            $button_style = $view->fetch('string:' . $settings['button_style']);

            $html = $view->fetch($this->path.'/templates/FrontendHead.html');

            return $html;

        } else {

            return;

        }
    }
    
    /**
     * Frontend method displays view button
     * @return string
     */
    static function displayButton($product_id) {

        $app_settings_model = new waAppSettingsModel();
        $settings = $app_settings_model->get(array('shop', 'fprview'));

        if (isset($settings['status']) && $settings['status'] === 'on' && isset($settings['button_template']) && $settings['button_template']) {                

            $view = wa()->getView(); 

            $view->assign('product_id', $product_id);
            $view->assign('settings', $settings);

            // $html = $view->fetch(realpath(dirname(__FILE__)."/../").'/templates/FrontendButton.html');
            $html = $view->fetch('string:' . $settings['button_template']);

            return $html;

        }

        return;
    }

    /**
     * Generates the HTML code for the user control with ID settingColorControl for color parametrs
     * @param string $name
     * @param array $params
     * @return string
     */
    static public function settingColorControl($name, $params = array()) {
        $control = '';

        $control_name = htmlentities($name, ENT_QUOTES, 'utf-8');
        
        $control .= "<input id=\"{$params['id']}\" type=\"text\" name=\"{$control_name}\" ";
        $control .= self::addCustomParams(array('class', 'placeholder', 'value',), $params);
        $control .= ">";
        if (isset($params['value']) && !empty($params['value'])) {
            $control .= "<span class=\"s-color-replacer\">";
            $control .= "<i class=\"icon16 color\" style=\"background: #{$params['value']};\"></i>";
            $control .= "</span>";
        }
        $control .= "<div class=\"s-colorpicker\"></div>";

        return $control;
    }

    /**
     * Generates the HTML parts of code for the params in user controls added by plugin
     * @param array $list
     * @param array $params
     * @return string
     */
    private static function addCustomParams($list, $params = array()) {
        $params_string = '';

        foreach ($list as $param => $target) {
            if (is_int($param)) {
                $param = $target;
            }
            if (isset($params[$param])) {
                $param_value = $params[$param];
                if (is_array($param_value)) {
                    if (isset($param_value['title'])) {
                        $param_value = $param_value['title'];
                    } else {
                        $param_value = implode(' ', $param_value);
                    }
                }
                if ($param_value !== false) {
                    $param_value = htmlentities((string)$param_value, ENT_QUOTES, 'utf-8');
                    if (in_array($param, array('autofocus'))) {                     
                        $params_string .= " {$target}";
                    } else {                        
                        $params_string .= " {$target}=\"{$param_value}\"";
                    }
                }
            }
        }

        return $params_string;
    }

}