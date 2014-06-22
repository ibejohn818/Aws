<?php 

$this->Html->script(
    array(
        "Aws.ec2-index"
    ),
    array("inline"=>false)
);
$this->Html->css(
    array(
        "Aws.ec2-index"
    ),
    "stylesheet",
    array("inline"=>false)
);
?>
<div class="page-header">
    <h1>
        EC2 Instances
    </h1>
</div>

<?php echo $this->element("nav-tabs") ?>

<div id="ec2-index-options">
    <?php 
        $configs = ClassRegistry::init("Aws.AwsSdkConfig")->find('all');
     ?>
     <ul class='nav nav-pills dropdown'>
         <li>
             <a href="#" class='dropdown-toggle' rel='noAjax' data-toggle='dropdown'>
                 Aws SDK Configurations <b class="caret"></b>
             </a>
             <ul class='dropdown-menu'>
                <?php 
                    foreach ($configs as $k => $config): 
                        $configUrl = $this->Html->url(array(
                            "action"=>"index",
                            "aws_sdk_config_id"=>$config['AwsSdkConfig']['id']
                        ));
                ?>
                <li>
                    <a href="<?php echo $configUrl; ?>">
                        <?php echo $config['AwsSdkConfig']['name']; ?>
                    </a>
                </li>
                <?php endforeach ?>
             </ul>
         </li>
     </ul>
</div>
<div id="ec2-index">
    <h4>
        &nbsp;&nbsp;&nbsp;&nbsp;&#8593; Select an SDK config to view instances
    </h4>
</div>
<div class="loading-div"></div>