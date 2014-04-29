<div class="page-header">
    <h2>
        Ec2 Logins
    </h2>
</div>
<div>
    <table cellspacing="0" class="table table-stripped table-bordered table-hover">
        <thead>
            <tr>
                <th>UserName</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logins as $k => $login): ?>
            <tr>
                <td>
                    <?php echo $login['Ec2Login']['name']; ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class='actions'>
                    <?php 

                        $url = $this->Html->url(array(
                            "action"=>"generate_install_script",
                            $login['Ec2Login']['id']
                        ));

                     ?>
                    <a href="<?php echo $url ?>" class="btn btn-default btn-xs">
                        Generate Install Script
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>