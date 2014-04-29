<?php 

pr($operators);

 ?>
<div class="page-header">
    <h2>
        Cloud Watch Metrics
    </h2>
</div>
<div class="row">
    <div class="col-md-12">
        <?php foreach ($awsNamespaces as $k => $v): ?>
            <?php 
                $url = $this->Html->url(array(
                    "namespace"=>$k
                ));
             ?>
             <a href="<?php echo $url ?>" class="btn">
                    <?php echo $v; ?>
             </a>
        <?php endforeach ?>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        
    </div>
    <div class="col-md-8">
        
    </div>
    <div class="col-md-2">
        <?php if ($nextToken): ?>
            <?php 

                $nextParams = $this->request->params['named'];

                unset($nextParams['nexttoken']);

                $url = $this->Html->url(
                    array_merge(
                        $nextParams,
                        array(
                            "nexttoken"=>$nextToken
                        )
                    )
                )
             ?>
             <a href="<?php echo $url; ?>" class="btn btn-default">
                Next
             </a>
        <?php endif ?>
    </div>
</div>

<div>
    <table class="table table-stripped table-bordered table-hover" cellspacing='0'>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Namespace</th>
                <th>Params</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($metrics['Metrics'] as $k => $v): ?>
                
            <tr>
                <td>
                    <?php echo $v['MetricName']; ?>
                </td>
                <td>
                    <?php 

                        $url = $this->Html->url(array(
                            "namespace"=>str_replace("/","-",$v['Namespace'])
                        ));

                    ?>
                    <a href="<?php echo $url; ?>" class="btn btn-default">
                            <?php echo $v['Namespace']; ?>
                    </a>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

             <?php endforeach ?>
        </tbody>
    </table>
</div>