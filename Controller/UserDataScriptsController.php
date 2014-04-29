<?php 

App::uses("AwsAppController","Aws.Controller");

class UserDataScriptsController extends AwsAppController {


    public $uses = array("Aws.AwsUserDataScript");

    /**
     * beforeFilter callback
     *
     * @return void
     */
        public function beforeFilter() {
            
            parent::beforeFilter();
            
            $this->Auth->allow();

        }
    

    public function index() {



    }

    public function add() {

        if($this->request->is("post") || $this->request->is("put")) {
        
            //die(pr($this->request->data));

            $user_yaml = spyc_dump($this->request->data['User']);

            die($user_yaml);
        
        }

    }

    public function add_user_form($key = 0) {

        $this->set("key",$key);
        $this->render("/Elements/add-user-form");

    }

    public function wizard() {



    }


    public function yum() {

        $yum = $this->AwsUserDataScript->available_yum_packages();

        $this->set(compact("yum"));

    }

    public function yum_cmd() {

        $this->render("/Elements/yum-command-textarea");

    }
    

}