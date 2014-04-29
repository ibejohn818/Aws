<?php 


App::uses("AppShell","Console/Command");


class TestingShell extends AppShell {


    public $uses = array("Aws.Ec2Login");


    public function test() {
        
        $login = $this->Ec2Login->find('first',array(
            "conditions"=>array(
                "Ec2Login.id"=>6
            ),
            'contain'=>false
        ));



        $cmd = "ssh -t -i $privKey {$login['Ec2Login']['name']}@johnchardy.com 'uptime'";

        echo passthru($cmd);

        $this->deleteRsaFile($privKey);
        $this->deleteRsaFile($pubKey);

    }




}