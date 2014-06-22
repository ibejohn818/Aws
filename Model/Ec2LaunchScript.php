<?php 

App::uses("AwsAppModel","Aws.Model");

class Ec2LaunchScript extends AwsAppModel {


    public $belongTo = array(
        "Aws.Ec2Instance"
    );
    public $hasMany = array(
        "Aws.Ec2LaunchScriptLogin",
        "Aws.Ec2LaunchScriptSecurityGroup"
    );


    public function getLaunchScript() {

        
    }

    public function handleEdit($data) {
        
        $this->id = $data['Ec2LaunchScript']['id'];

        $this->Ec2LaunchScriptLogin->handleEdit($this->id,$data['Ec2LaunchScriptLogin']);

        $this->Ec2LaunchScriptSecurityGroup->handleEdit($this->id,$data['Ec2LaunchScriptSecurityGroup']);

        return $this->save($data);

    }

    public function returnEdit($id) {

        $script = $this->find('first',array(
            'conditions'=>array(
                'Ec2LaunchScript.id'=>$id
            ),
            'contain'=>false
        ));

        $logins = $this->Ec2LaunchScriptLogin->find('all',array(
            'conditions'=>array(
                'Ec2LaunchScriptLogin.ec2_launch_script_id'=>$id
            ),
            'contain'=>false
        ));

        foreach ($logins as $k => $v) {
            
            $script['Ec2LaunchScriptLogin']['ec2_login_id'][] = $v['Ec2LaunchScriptLogin']['ec2_login_id'];

        }

        $secGroups = $this->Ec2LaunchScriptSecurityGroup->find('all',array(
            'conditions'=>array(
                'Ec2LaunchScriptSecurityGroup.ec2_launch_script_id'=>$id
            ),
            'contain'=>false
        ));

        foreach ($secGroups as $k => $v) {
            
            $script['Ec2LaunchScriptSecurityGroup']['security_group_id'][] = $v['Ec2LaunchScriptSecurityGroup']['security_group_id'];

        }

        return $script;

    }

    public function user_data_script($config,$ec2_launch_script_id) {

        //the script 
        $s = array();

        //make the sec hash

        $sec_hash = sha1_file(AWS_PLUGIN_SDK_CONFIG_PATH . DS . $config . ".yaml");

        $s[] = "SECHASH=\"{$sec_hash}\";";

        //write the download function script

        $s[] = "wget {}/aws/user_data/launch_script/{$ec2_launch_script_id}?${SECHASH} -P /tmp/;";

    }

}