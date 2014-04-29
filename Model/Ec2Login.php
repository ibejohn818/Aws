<?php 

App::uses("AwsAppModel","Aws.Model");

class Ec2Login extends AwsAppModel {

    /**
     * beforeSave callback
     *
     * @param $options array
     * @return boolean
     */
        public function beforeSave($options = array()) {
            
            if(empty($this->id)) {

                if($this->data[$this->name]['auto_rsa'] == 1) {

                    $keys = $this->generateRsaKeys();

                    $this->data[$this->name]['private_key'] = $keys['private'];
                    
                    $this->data[$this->name]['public_key'] = $keys['public'];
                }

            }

            return true;
        }
    
    public function generateRsaKeys() {

        include('Crypt/RSA.php');

        $rsa = new Crypt_RSA();

        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);

        $keys = $rsa->createKey();

        return array(
            'private'=>$keys['privatekey'],
            'public'=>$keys['publickey']
        );
    }

    public function _generateRsaKeys() {

        //make a random name
        $name = mt_rand(9999,999999)."-".uniqid();

        $name_path = TMP.$name;

        $cmd = "ssh-keygen -t rsa -f ".TMP."{$name} -N ''";

        $out = array();

        exec($cmd,$out,$res);

        if($res !== 0) {
            //ERROR
            return false;
        }

        $private    = file_get_contents($name_path);
        $public     = file_get_contents("{$name_path}.pub");

        unlink($name_path);
        unlink("{$name_path}.pub");

        return array(
            "private"=>$private,
            "public"=>$public
        );

    }

    public function getFormOptions() {
        
        $logins = $this->find('all',array(
            "conditions"=>array(
                
            ),
            "contain"=>false
        ));

        $o = array();

        foreach ($logins  as $k => $v) {
            
            $o[$v['Ec2Login']['id']] = $v['Ec2Login']['name'];

        }

        return $o;

    }

    public function generate_user_install_cmd($id) {

        $user = $this->find('first',array(
            "conditions"=>array("Ec2Login.id"=>$id),
            'contain'=>false
        ));

        $user = $user['Ec2Login'];

        $cmd = array();

        $cmd[] = "useradd {$user['name']}";

        if($user['sudoer']) {

            $cmd[] = "echo \"{$user['name']}    ALL=(ALL)   NOPASSWD:ALL\" >> /etc/sudoers";

        }


        $cmd[] = "su {$user['name']} bash -c 'mkdir /home/{$user['name']}/.ssh'";
        $cmd[] = ''; $cmd[] = '';

        if(!empty($user['private_key']) && !empty($user['public_key'])) {
            $cmd[] = "su {$user['name']} bash -c 'echo \"{$user['private_key']}\" > /home/{$user['name']}/.ssh/id_rsa'";
            $cmd[] = "su {$user['name']} bash -c 'echo \"{$user['public_key']}\" > /home/{$user['name']}/.ssh/id_rsa.pub'";
            $user['authorized_keys'] .= "\n".$user['public_key'];

        }

        $cmd[] = "su {$user['name']} bash -c 'chmod 700 /home/{$user['name']}/.ssh'";
        
        if(!empty($user['private_key']) && !empty($user['public_key'])) {
            $cmd[] = "su {$user['name']} bash -c 'chmod 600 /home/{$user['name']}/id_rsa /home/{$user['name']}/.ssh/id_rsa.pub'";
        }

        if(!empty($user['authorized_keys'])) {
            $cmd[] = "su {$user['name']} bash -c 'echo \"{$user['authorized_keys']}\" > /home/{$user['name']}/.ssh/authorized_keys'";
            $cmd[] = "su {$user['name']} bash -c 'chmod 644 /home/{$user['name']}/.ssh/authorized_keys'";
        }
        
        $knownHosts = explode("\n", $user['known_hosts']);

        foreach((array)$knownHosts as $host) {

            $cmd[] = "su {$user['name']} bash -c 'ssh-keyscan -H {$host} >> /home/{$user['name']}/.ssh/known_hosts'";

            $cmd[] = "su {$user['name']} bash -c 'echo \"\" >> /home/{$user['name']}/.ssh/known_hosts'";

        }

        $str = "";

        foreach($cmd as $v) {
            $str .= $v."\n";
        }

        return $str; 

    }
    

}