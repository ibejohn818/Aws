<?php 

App::uses("AppShell","Console/Command");

class AwsAppShell extends AppShell {


    public function __construct($stdout = null, $stderr = null, $stdin = null) {

        parent::__construct($stdout,$stderr,$stdin);

        if(!defined('AWS_PLUGIN_LOADED')) {

            $err = "Aws Plugini 'bootstrap' option not configured \n In your app's Config/bootstrap.php file, ensure 'bootstrap' is set to true for the Aws Plugin \n CakePlugin::load( \n \tarray('Aws'=>array('bootstrap'=>true)\n));";

            throw new AwsPluginBootstrapException($err);

        }

    }

}