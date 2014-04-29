<?php

App::uses('AppController', 'Controller');

class AwsAppController extends AppController {



    public function beforeFilter() {

        if(!defined('AWS_PLUGIN_LOADED')) {

            throw new AwsPluginBootstrapException("Not Found");

        }

        parent::beforeFilter();

        if(Configure::read("AwsPlugin.useAuth") === true) {
            $this->Auth->deny();    
        }

    }


}
