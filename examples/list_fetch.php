<?php
/**
 * Fetch data from GDS  * with an indexed string field *
 *
 * @author Tom Walder <tom@docnet.nu>
 */
require_once('../vendor/autoload.php');
require_once('config/setup.php');

// We'll need a Google_Client, use our convenience method
$obj_google_client = GDS\Gateway\GoogleAPIClient::createGoogleClient(GDS_APP_NAME, GDS_SERVICE_ACCOUNT_NAME, GDS_KEY_FILE_PATH);
$obj_gateway = new GDS\Gateway\GoogleAPIClient($obj_google_client, GDS_DATASET_ID); // Optionally, namespace

// Define the model on-the-fly
$obj_contact_schema = (new GDS\Schema('Contact'))
    ->addString('first_name')
    ->addString('last_name')
    ->addStringList('tags', TRUE);

// Configure the Store
$obj_store = new GDS\Store($obj_contact_schema, $obj_gateway);

// A couple of tests
show($obj_store->fetchAll("SELECT * FROM Contact_v1 WHERE tags = 'newsletter' AND tags = 'customer'"));
show($obj_store->fetchAll("SELECT * FROM Contact_v1 WHERE tags = 'api'"));
show($obj_store->fetchAll("SELECT * FROM Contact_v1 WHERE tags = 'newsletter'"));

/**
 * Show result data
 *
 * @param $arr
 */
function show($arr)
{
    echo PHP_EOL, "Query found ", count($arr), " records", PHP_EOL;
    foreach ($arr as $obj_model) {
        echo "   Email: {$obj_model->getKeyName()}, Name: {$obj_model->first_name}", PHP_EOL;
    }
}