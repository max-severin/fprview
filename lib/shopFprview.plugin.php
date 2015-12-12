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
        // $settings = $this->getSettings();

        // if ( $settings['status'] === 'on' ) {            

            $view = wa()->getView();
            $html = $view->fetch($this->path.'/templates/FrontendHead.html');

            return $html;

        // } else {

        //     return;

        // }
    }

}