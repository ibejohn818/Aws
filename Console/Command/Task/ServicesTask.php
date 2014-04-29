<?php 

App::uses("AppShell","Console/Command");


class ServicesTask extends AppShell {

    public $servicesPath = false;

    public function execute() {

        $this->findPath();


    }


    private function findPath() {

        switch(true) {

            case is_dir("/etcaaa/init.d"):
                $this->servicesPath = "/etc/init.d";
            break;

            default:
                $this->ask();
            break;

        }

    }

    private function ask() {

        $this->out("Unabled to determins the location of your services");
        $this->out("Please input the full path where services are located on this server");

        $this->servicesPath = $this->in("Enter Path:");

        $this->servicesPath = rtrim($this->servicesPath,"/");

        if(!is_dir($this->servicesPath)) {

            $this->out("<error>{$this->servicesPath}: Invalid Path!</error>");

            $this->servicesPath = false;
            return $this->ask();

        }

    }

}