<div class="page-header">
    <h2>
        Edit Lanch Script : <?php echo $this->request->data['Ec2LaunchScript']['name']; ?>
    </h2>
</div>
<?php 

echo $this->Form->create('Ec2LaunchScript',array(
    "id"=>'Ec2LaunchScriptForm',
    "url"=>$this->request->here
));
echo $this->Form->input("id");
echo $this->Form->input("sdk_config",array("type"=>"hidden"));
 ?>
<div id="edit-launch-script">
    <fieldset>
        <legend>EC2 Configuratin</legend>
        <div>
                    <?php 
        
            echo $this->Form->input("name");
            echo $this->Form->input("ami_id",array("type"=>"text"));
            echo $this->Form->input("instance_type",array("options"=>$instanceTypes));

        ?>
        </div>
        <div class="security-groups">
            <?php echo $this->Form->input("Ec2LaunchScriptSecurityGroup.security_group_id",array("options"=>$secGroupOptions,"multiple"=>"checkbox")) ?>
        </div>
    </fieldset>
    <fieldset>
        <legend>Post Launch Commands</legend>
            <div class="well">
                <p>
                    After the instance has been created, a script with the command you enter here will be executed by the root account.
                    First, WGET will be installed by the package manager. After WGET is installed, an update command will be issued to the package manager.
                    After the update has been completed, the user accounts will be created, then the 'Top Content' commands will be executed.
                    'Top Content' should be used to install any software that is required. 
                    You should also create any directories needed for the staged asset downloads.
                    After top content has been executed, your assets will be downloaded to the server in the locations that you specified when creating
                    the downloads. After the entire launch script has been executed it will delete itself. 
                    A log file of any output will be saved to the servers 'tmp' directory.
                    Keep in mind that all commands will be executed by the 'root' user. To issue commands in the scope of another account use the 'su command' ( john is an example of a user account)
                    <br />
<pre>
su john bash -c 'git clone myrepo /repo/location';
</pre>
                </p>
            </div>
            <div>
                <?php echo $this->Form->input("package_manager",array("options"=>$packageManagers)) ?>
            </div>
            <div class="ec2-logins">
                <?php echo $this->Form->input("Ec2LaunchScriptLogin.ec2_login_id",array("options"=>$logins,"multiple"=>"checkbox")) ?>
            </div>
            <div class="content-top">
                <?php echo $this->Form->input('content_top') ?>
            </div>
            <div class="content-middle">
                <?php echo $this->Form->input("content_middle") ?>
            </div>
            <div class="content-bottom">
                <?php echo $this->Form->input("content_bottom") ?>
            </div>
    </fieldset>
</div>
<div class="form-actions">
    <button type="submit" class="btn btn-primary">
        Update Launch Script
    </button>
</div>
<?php echo $this->Form->end(); ?>
<?php pr($this->request->data) ?>