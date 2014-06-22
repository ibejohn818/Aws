<?php 

App::uses("AwsAppController","Aws.Controller");

class ConfigController extends AwsAppController {

    public $uses = array(
        "Aws.AwsSdkConfig"
    );

    public function beforeFilter() {
            
        parent::beforeFilter();

    }
    
    public function index() {
        
        $this->Paginator->settings = array(
            "order"=>array("AwsSdkConfig.id","DESC")
        ); 

        $configs = $this->Paginator->paginate("AwsSdkConfig");

        $this->set(compact("configs"));

    }

    public function create() {
        
        if($this->request->is("post") || $this->request->is("put")) {

            if($this->AwsSdkConfig->handleSave($this->request->data,true)) {

                $this->fs("SDK Config Created Successfully");

                $this->redirect(array(
                    "action"=>"edit",
                    $this->AwsSdkConfig->id
                ));

            } else {
                $this->fe("An error occured creating the config");
            }

        }

    }

    public function edit($id = false) {
     
        if($this->request->is("post") || $this->request->is("put")) {
        
            if($this->AwsSdkConfig->handleSave($this->request->data,true)) {

                $this->fs("SDK Config updated successfully");

                $this->redirect(array(
                    "action"=>"edit",
                    $this->AwsSdkConfig->id
                ));

            } else {

                $this->fe("An error occured while updating the config");

            }
        
        } else {
            $this->request->data = $this->AwsSdkConfig->findById($id); 
        }

          
    }

    public function delete($id) {

        if($this->AwsSdkConfig->handleDelete($id)) {

            $this->fs("Configuration deleted successfully");

        } else {

            $this->fe("An error occured while deleting the configuration");

        }

        $this->redirect(array("action"=>"index"));

    }

    public function select() {

        if($this->request->is("post") || $this->request->is("put")) {
        
            
        
        }

    }

}