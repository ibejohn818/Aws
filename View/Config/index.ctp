<?php 

$regions = AwsSdk::regionsSelect();



 ?>
<div class="page-header">
    <h1>
        AWS SDK Configurations
    </h1>
</div>
<?php echo $this->element("nav-tabs") ?>
<div class="index">
    <table cellspacing="0" class="table table stripped table-bordered table-hover">
        <thead>
            <tr>
                <th>
                    <?php echo $this->Paginator->sort("id") ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort("created") ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort("modified") ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort("name") ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort("sdk_key") ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort("sdk_secret") ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort("sdk_region") ?>
                </th>
                <th>-</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($configs as $k => $config): ?>
                <tr>
                    <td>
                        <?php echo $config['AwsSdkConfig']['id'] ?>
                    </td>
                    <td>
                        <?php echo $this->Time->niceShort($config['AwsSdkConfig']['created']) ?>
                    </td>
                    <td>
                        <?php echo $this->Time->niceShort($config['AwsSdkConfig']['modified']) ?>
                    </td>
                    <td>
                        <?php echo $config['AwsSdkConfig']['name'] ?>
                    </td>
                    <td>
                        <?php echo $config['AwsSdkConfig']['sdk_key'] ?>
                    </td>
                    <td>
                        <?php echo $config['AwsSdkConfig']['sdk_secret'] ?>
                    </td>
                    <td>
                        <?php echo $regions[$config['AwsSdkConfig']['sdk_region']]; ?>
                    </td>
                    <td>
                        <?php 

                            $editUrl = $this->Html->url(array(
                                "action"=>"edit",
                                $config['AwsSdkConfig']['id']
                            ));

                            $deleteUrl = $this->Html->url(array(
                                "action"=>"delete",
                                $config['AwsSdkConfig']['id']
                            ));

                         ?>
                         <a href="<?php echo $editUrl; ?>" class="btn btn-primary">
                            Edit
                         </a>
                         <a href="<?php echo $deleteUrl; ?>" class="btn btn-danger" onclick='return confirm("Are you sure you want to delete this configuration?");'>
                            Delete
                         </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>