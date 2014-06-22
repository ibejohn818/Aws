<table cellspacing="0" class="table table-bordered table-stripped table-hover">
    <thead>
        <tr>
            <th>
                SDK Config
            </th>
            <th>
                <?php echo $this->Paginator->sort('Ec2Instance.modified',"Last Sync'ed") ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort("instance_id") ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort("instance_state") ?>
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($instances as $k => $instance): ?>
        <tr>
            <td>
                <?php echo $instance['AwsSdkConfig']['name']; ?>
            </td>
            <td>
                <?php echo $this->Time->niceShort($instance['Ec2Instance']['modified']) ?>
            </td>
            <td>
                <?php echo $instance['Ec2Instance']['instance_id'] ?>
            </td>
            <td>
                <?php echo $instance['Ec2Instance']['instance_state'] ?>
            </td>
            <td>
                <?php echo $instance['Ec2Instance']['instance_state'] ?>
            </td>
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>