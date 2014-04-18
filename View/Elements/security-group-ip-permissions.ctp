<h4>
    <?php echo $name; ?>
</h4>
<table class="table table-stripped table-bordered">
    <thead>
        <tr>
            <th>Protocol</th>
            <th>Port Range</th>
            <th>CIDR</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rules as $k => $rule): ?>
        <tr>
            <td>
                <?php 
                    switch($rule['IpProtocol']) {

                        case '-1':
                            echo "All Traffic";
                        break;
                        default:
                            echo $rule['IpProtocol'];
                        break;

                    }

                 ?>
            </td>
            <td>
                <?php 

                    if(!isset($rule['ToPort']) || !isset($rule['FromPort'])) {
                        echo "All";
                    } else {

                        echo "{$rule['FromPort']} -> {$rule['ToPort']}";

                    }

                 ?>
            </td>
            <td>
                <?php foreach ($rule['IpRanges'] as $key => $v): ?>
                    <div class='cidr'>
                        <?php echo $v['CidrIp']; ?>
                    </div>
                <?php endforeach ?>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>