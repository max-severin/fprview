<?php

/*
 * Class shopFprviewPluginSettingsAction
 * @author Max Severin <makc.severin@gmail.com>
 */
class shopFprviewPluginSettingsAction extends waViewAction {

    public function execute() {
    	$plugin = wa('shop')->getPlugin('fprview');
        $namespace = 'shop_fprview';

        $params = array();
        $params['id'] = 'fprview';
        $params['namespace'] = $namespace;
        $params['title_wrapper'] = '%s';
        $params['description_wrapper'] = '<br><span class="hint">%s</span>';
        $params['control_wrapper'] = '<div class="name">%s</div><div class="value">%s %s</div>';

        $settings = $plugin->getSettings();
        $settings_controls = $plugin->getControls($params);

        $this->view->assign('fprview_settings', $settings);
        $this->view->assign('settings_controls', $settings_controls);
    }

}