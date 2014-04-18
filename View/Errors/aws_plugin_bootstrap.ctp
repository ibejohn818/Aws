<h2>
    AWS PLUGIN NOT BOOTSTRAPED!
</h2>
<p>
    Please ensure that you have 'bootstrap' enabled in your CakePlugin::load in your bootstrap file for the AWS Plugin
</p>
<pre>
    CakePlugin::load(
        'Aws'=>array(
            'bootstrap'=>true,
            'routes'=>true
        )
    );
</pre>