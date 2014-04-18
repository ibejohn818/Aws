<?php 

App::uses("AwsAppModel","Aws.Model");


class UserDataScript extends AwsAppModel {



    public function parse_add_user($data) {

        $userDir = "/home/{$data['user_name']}";

        $sshDir = "{$userDir}/.ssh";

        $authKeyFile = "{$sshDir}/authorized_keys";

        $knownHostsFile = "{$sshDir}/known_hosts";

        $pubKeyFile = "{$sshDir}/id_rsa.pub";

        $privKeyFile = "{$sshDir}/id_rsa";

        $userBashCmd = "su {$data['user_name']} bash -c ";

        $cmd = "useradd {$data['user_name']}; \n";

        if($data['add_to_sudo']) {

             $cmd .= "echo \"{$data['user_name']}   ALL=(ALL) NOPASSWD:ALL\" >> /etc/sudoers; \n";

        }

        $cmd .= "{$userBashCmd} 'mkdir {$sshDir} && chmod 600 {$sshDir} \n";

        $cmd .= "{$userBashCmd} 'touch {$knownHostsFile}' \n";

        $cmd .= "{$userBashCmd} 'touch {$pubKeyFile}' && chmod 600 {$pubKeyFile} \n";

        $cmd .= "{$userBashCmd} 'touch {$privKeyFile}' && chmod 600 {$privKeyFile} \n";

        //add public & private key
        $cmd .= "echo \"{$data['public_key']}\" > {$pubKeyFile}; \n";
        $cmd .= "echo \"{$data['private_key']}\" > {$privKeyFile}; \n";

        
        //add some sites to known_hosts
        


        return $cmd; 

    }

    public function available_yum_packages() {

        $token = "yum-modules";

        if(($packages = Cache::read($token,"eod")) === false) {

            $out = array();

            exec("yum search ''",$out);

            $yum = array();

            $add = false;

            $currentKey = false;

             $packages = array();$packages = array();

            foreach($out as $k=>$v) {

                $v = trim($v);

                if(preg_match('/(N\/S Matched)/i',$v)) {

                    $add = true;
                    continue;

                }

                if(preg_match('/(N\/S Matched)/i',$v) || preg_match('/(loaded plugins)/i',$v)) {
                    continue;
                }

                if(!preg_match('/(:)/',$v) || !preg_match('/([a-zA-Z])/',$v)) {
                    continue;
                }

                if(preg_match('/^:/',$v)) {

                    @$packages[$currentKey] .= " ".preg_replace('/^:/',"",$v);

                } else {

                    $m = explode(":",$v);

                    $p = explode(".",trim($m[0]));

                    $currentKey = $p[0];

                    @$packages[$currentKey] = trim($m[1]);

                }

            }

            Cache::write($token,$packages,"eod");

        }

       

        return $packages;


    }


}