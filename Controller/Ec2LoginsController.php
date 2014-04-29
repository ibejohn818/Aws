<?php 

App::uses("AwsAppController","Aws.Controller");


class Ec2LoginsController extends AwsAppController {

    public $uses = array(
        "Aws.Ec2Login"
    );

/**
 * beforeFind callback
 *
 * @param $query array
 * @return mixed
 */
    public function beforeFind($query) {
        
        return $query;
    }

    public function index() {
        
        $logins = $this->Paginator->paginate("Ec2Login");

        $this->set(compact("logins"));

    }


    public function create() {
        
        if($this->request->is("post") || $this->request->is("put")) {
                
            if($this->Ec2Login->save($this->request->data)) {

                $this->Session->setFlash("Login Added Successfully");

                $this->redirect(array(
                    "action"=>"index"
                ));

            }            
                
        }        

    }

    public function edit($id) {
        
        if($this->request->is("post") || $this->request->is("put")) {
        
            if($this->Ec2Login->save($this->request->data)) {

                $this->Session->setFlash("Ec2 Login Updated");

            } else {

                
                
            }
        
        } else {

            $this->request->data = $this->Ec2Login->find('first',array(
                'conditions'=>array(
                    'Ec2Login.id'=>$id
                ),
                'contain'=>false
            ));

        }





    }

    public function generate_install_script($id) {
        
        $cmd = $this->Ec2Login->generate_user_install_cmd($id);

        die($cmd);
        
    }

    public function download_login_script($id) {

        
        $login = $this->Ec2Login->find('first',array("conditions"=>array("Ec2Login.id"=>$id),'contain'=>false));

        $content = $this->Ec2Login->generate_user_install_cmd($id);

        $fileName = $login['Ec2Login']['name'].".sh";

        $fullPath = TMP.$fileName;

        file_put_contents($fullPath, $content);

        $this->response->file($fullPath,array("download"=>true,"name"=>$fileName));

        return $this->response;

    }



    public function keyscan_host() {

        $cmd = "ssh-keyscan {$this->request->data['host_name']}";

        $out = array();

        exec($cmd,$out);

        die($out[0]);

    }



}