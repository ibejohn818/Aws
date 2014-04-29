<div class="page-header">
    <h2>
        Aws Security Group
    </h2>
</div>
<?php 

echo $this->Form->create('SecurityGroup',array(
    "id"=>'SecurityGroupForm',
    "url"=>$this->request->here
));

 ?>
<div class="security-group row">
    <div class="col-md-4">
        <?php echo $this->Form->input("GroupName",array("value"=>$group['GroupName'])) ?>
    </div>
    <div class="col-md-4">
        <?php echo $this->element("security-group-ip-permissions",array("name"=>"Permissions In","rules"=>$group['IpPermissions'])) ?>
    </div>
    <div class="col-md-4">
        <?php echo $this->element("security-group-ip-permissions",array("name"=>"Permissions Out","rules"=>$group['IpPermissionsEgress'])) ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
<?php 
pr($group);
 ?>