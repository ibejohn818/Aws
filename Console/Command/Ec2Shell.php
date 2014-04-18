<?php 

App::uses("AwsAppShell","Aws.Console/Command");



class Ec2Shell extends AwsAppShell {

    public function startup() {

        parent::startup();

        $this->hr();

        $this->out("EC2 Shell");

        $this->hr();

    }

    public function list_all_instances() {
        


    }

    private function search_instances($tags = array()) {



    }


    private function parseInstanceResults($results) {

        $nodes = array();

        $reservations = $results['Reservations'];
            foreach ($reservations as $reservation) {
                $instances = $reservation['Instances'];
                foreach ($instances as $instance) {

                    $instanceName = '';

                    if($instance['State']['Name'] == "running") {

                        $nodes[] = array(

                            "Instance"=>$instance,
                            "Name"=>$instance['State']['Name'],
                            "PrivateIp"=>$instance['PrivateIpAddress']

                        );

                    }

                }

            }


        return $nodes;

    }



}