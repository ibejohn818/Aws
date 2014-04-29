<?php 

echo $this->element("scripts");

 ?>
<div class="page-header">
    <h2>
        EC2 Instances
    </h2>
</div>

    
<div id="ec2-index">
    <table class="table table-stripped table-bordered table-hover" cellspacing="0">
        <thead>
            <tr>
                <th>EC2 Instance ID</th>
                <th>Name Tag</th>
                <th>SDK Config</th>
                <th>Instance State</th>
                <th>Instance Type</th>
                <th>Security Group(s)</th>
                <th>Tags</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($instances as $k => $instance):
                $apiData = unserialize($instance['Ec2Instance']['serialized_api_data']);
             ?>
            <tr>
                <td><?php echo $instance['Ec2Instance']['instance_id']; ?></td>
                <td>
                    <?php 
                        $nameTag = Set::extract("/AwsTag[tag_key=Name]",$instance);
                        if(count($nameTag)>0):
                            foreach ($nameTag as $k => $v): ?>
                               <?php echo $v['AwsTag']['tag_value']; ?>
                            <?php
                            endforeach;
                        else:
                     ?>
                        No Name Tag
                    <?php endif; ?>
                </td>
                <td><?php echo $instance['Ec2Instance']['sdk_config']; ?></td>
                <td>
                    <?php echo $instance['Ec2Instance']['instance_state']; ?>
                </td>
                <td><?php echo $apiData['InstanceType']; ?></td>
                <td>
                    <?php 
                            foreach ($apiData['SecurityGroups'] as $group): 
                                $url = $this->Html->url(array(
                                    'action'=>'security_group',
                                    'security_group_id'=>$group['GroupId'],
                                    'config'=>$instance['Ec2Instance']['sdk_config']
                                ));
                    ?>

                        <a href="<?php echo $url; ?>" class="btn btn-default btn-xs security-group-btn">
                            <?php echo strtoupper($group['GroupName']); ?>
                        </a>
                    <?php endforeach ?>
                </td>
                <td>
                    <?php foreach ((array)$instance['AwsTag'] as $key => $tag): ?>
                        
                            <?php 
                                $url = $this->Html->url(array(
                                    "TagKey"=>$tag['tag_key'],
                                    "TagValue"=>$tag['tag_value']
                                ));
                             ?>
                            <a class='btn btn-primary btn-xs' href='<?php echo $url; ?>'><?php echo $tag['tag_key'] ?> : <?php echo $tag['tag_value'] ?></a> &nbsp;
                        
                    <?php endforeach ?>
                </td>
                <td></td>
                <td></td>
                <td>
                    <div class="btn-group">
                        <a href="" class="btn btn-default">
                            
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php pr($apiData); ?>