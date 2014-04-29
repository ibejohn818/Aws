<?php 

App::uses('BaseAuthorize', 'Controller/Component/Auth');

class UserDataAuthorize extends BaseAuthorize {


    public function authorize($user, CakeRequest $request) {

        die(pr($user));        
        die("Here we are in authorize");

    }

    private function sha1_config($config) {

        $file = AWS_PLUGIN_SDK_CONFIG_PATH . DS . $config;

        $hash = sha1_file($file);

        return $hash;

    }

}