<?php 

App::uses("AppShell","Console/Command");

class ToolsShell extends AppShell {


    public function generate_db_schema() {

        $tables = array(

            "Aws.UserDataScript",


        );

        $table_str = implode(",", $tables);

        $this->dispatchShell("schema generate --models {$table_str} --path ".AWS_PLUGIN_CONFIG_PATH);

    }

}