<?php 

App::uses("FormAuthenticate","Controller/Component/Auth");


class UserDataAuthenticate extends BaseAuthenticate {


    public function authenticate(CakeRequest $request, CakeResponse $response) {

        //just return to hand off to the user data authorizer
        return array();

    }
    
    public function unauthenticated(CakeRequest $request, CakeResponse $response) {
        
        if(!isset($_GET['config']) || !in_array($request->params['controller'],array('UserData'))) {

            return $this->authError();

        }

        return true;

    }
    
    public function getUser(CakeRequest $request) {
        die(pr($request));
        $token = md5(serialize($request));

        if( ($file = Cache::read($token,"aws-1min")) ===false ) {

            //check to see which script to download
            switch(strtolower($request->params['action'])) {

                case "launch_script":

                    $file = ClassRegistry::init("Aws.Ec2LaunchScript")->getLaunchScript($request->params['pass'][0]);

                break;
                case "file_download":
                    $file = "no";
                break;

            }



        }

        return compact("file");
    }



    private function authError() {

        throw new UnauthorizedException();

    }



}