<?php 

App::uses("AwsAppController","Aws.Controller");


class LaunchScriptsController extends AwsAppController {

    public $uses = array(
        "Aws.Ec2LaunchScript",
        "Aws.Ec2Login",
        "Aws.Ec2Instance"
    );


    /**
     * beforeFilter callback
     *
     * @return void
     */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
            


    }   

    public function create() {
         
        if($this->request->is("post") || $this->request->is("put")) {
        
            if($this->Ec2LaunchScript->save($this->request->data))  {

                $this->Session->setFlash("Launch Script Created Successfully");

                $this->redirect(array(
                    "action"=>"edit",
                    $this->Ec2LaunchScript->id
                ));

            } else {

                $this->Session->setFlash("There was an error while saving your Launch Script, Please Try Again");

            }
        
        }

    } 

    public function edit($id = false) {
        
        if(!$id) {
            throw new BadRequestException("Invalid LInk: ID Argument Not Set");
        }

        if($this->request->is("post") || $this->request->is("put")) {

            $this->Ec2LaunchScript->handleEdit($this->request->data);
        
        } else {

            $this->request->data = $this->Ec2LaunchScript->returnEdit($id);

        }

        $this->setSelects($this->request->data['Ec2LaunchScript']['sdk_config']);

    }

    public function setSelects($sdkConfig) {

        $secGroups = $this->Ec2Instance->get_security_groups($sdkConfig);
        
        $secGroupOptions = array();

        foreach($secGroups as $g) {

            $secGroupOptions[$g['GroupId']] = $g['GroupName'];

        }

        $logins = $this->Ec2Login->getFormOptions($sdkConfig);

        $ec2InstanceTypes = AwsSdk::getInstanceTypes();

        $instanceTypes = array();

        foreach ($ec2InstanceTypes as $k => $t) {
                
            $instanceTypes[$t] = $t;

        }

        $packageManagers = array(
            "yum",
            "apt-get"
        );

        $packageManagers = array_combine($packageManagers, $packageManagers);

        $this->set(compact(
            "secGroups",
            "secGroupOptions",
            "logins",
            "instanceTypes",
            "packageManagers"
        ));

    }



}