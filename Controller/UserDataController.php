<?php 

App::uses("AwsAppController","Aws.Controller");

class UserDataController extends AwsAppController {

    public $uses = array(
        "Aws.AwsUserDataScript"
    );

    public function beforeFilter() {

        $this->Auth->authenticate = "Aws.UserData";

        AuthComponent::$sessionKey = false;

        $this->Auth->authorize = "Aws.UserData";

        $this->Auth->deny();

    }


    public function launch_script($id) {

        

    }


    public function download() {



    }

}