<h2>AWS ASK CONFIG FILE NOT CREATED</h2>
<p>
    Configuration file for the AWS PHP SDK was not found
</p>
<p>
    Run the Aws Plugin's Configure Shell:
</p>
<pre>
    <?php echo APP ?>/Console/cake aws.configure
</pre>
<p>OR create the file in the aws plugin's Config folder Config/sdk.yaml</p>
<pre>
key: ####
secret: #######
region: us-west-2
</pre>