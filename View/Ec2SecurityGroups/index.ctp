<?php 

$this->Html->css("Aws.main","stylesheet",array("inline"=>false));

 ?>
<div class="page-header">
    <h2>
        EC2 Security Groups
    </h2>
</div>

<div class="" id='ec2-security-groups'>
    <?php foreach ($groups['SecurityGroups'] as $k => $group): ?>
    <div class='row ev2-secruity-group'>
        <div class="col-md-4">
            <dl>
                
                <dt>Group Name:</dt>
                <dd>
                    <?php echo $group['GroupName']; ?>
                </dd>
    
                <dt>Group Description:</dt>
                <dd>
                    <?php echo $group['Description']; ?>
                </dd>
                
                <dt>Group ID:</dt>
                <dd>
                    <?php echo $group['GroupId']; ?>
                </dd>

                <dt>VPC ID:</dt>
                <dd>
                    <?php echo $group['VpcId']; ?>
                </dd>
            </dl>
        </div>
        <div class="col-md-4">
            <?php echo $this->element("security-group-ip-permissions",array("name"=>"Permissions In","rules"=>$group['IpPermissions'])) ?>
        </div>
        <div class="col-md-4">
            <?php echo $this->element("security-group-ip-permissions",array("name"=>"Permissions Out","rules"=>$group['IpPermissionsEgress'])) ?>
        </div>
    </div>
    <hr>
    <?php //pr($group); ?>    
    <?php endforeach ?>
</div>