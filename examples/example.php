#!/usr/bin/php
<?
include('../src/HLRLookupClient.class.php');

/**
 * This file contains examples on how to interact with the HLR Lookup API.
 * All endpoints of the API are documented here: https://www.hlr-lookups.com/en/api-docs
 */

/**
 * Create an HLR Lookups API client
 * The constructor takes your API Key, API Secret and an optional log file location as parameters
 * Your API Key and Secret can be obtained here: https://www.hlr-lookups.com.com/en/api-settings
 */
$client = new HLRLookupClient(
    'YOUR-API-KEY',
    'YOUR-API-SECRET',
    '/var/log/coinqvest.log' // an optional log file location
);

/**
 * Invoke a request to GET /auth-test (https://www.hlr-lookups.com/en/api-docs#get-auth-test) to see if everything worked
 */
$response = $client->get('/auth-test');

/**
 * The API returns an HTTP status code of 200 if the request was successfully processed, let's have a look.
 */
echo "Auth Test Status Code: " . $response->httpStatusCode . "\n";
echo "Auth Test Response Body: " . $response->responseBody . "\n\n";

/**
 * Submit an HLR Lookup via POST /hlr-lookup (https://www.hlr-lookups.com/en/api-docs#post-hlr-lookup)
 */

$response = $client->post('/hlr-lookup', array(
    'msisdn' => '+905536939460'
));

echo "HLR Lookup Status Code: " . $response->httpStatusCode . "\n";
echo "HLR Lookup Response Body: " . $response->responseBody . "\n\n";

if ($response->httpStatusCode != 200) {
    // something went wrong, let's abort and debug by looking at our log file specified above in the client.
    echo "Invalid Response from server (HLR).";
}

/**
 * Submit an NT Lookup via POST /nt-lookup (https://www.hlr-lookups.com/en/api-docs#post-nt-lookup)
 */

$response = $client->post('/nt-lookup', array(
    'number' => '+4989702626'
));

echo "NT Lookup Status Code: " . $response->httpStatusCode . "\n";
echo "NT Lookup Response Body: " . $response->responseBody . "\n\n";

if ($response->httpStatusCode != 200) {
    // something went wrong, let's abort and debug by looking at our log file specified above in the client.
    echo "Invalid Response from server (NT).";
}

/**
 * Submit an MNP Lookup via POST /mnp-lookup (https://www.hlr-lookups.com/en/api-docs#post-mnp-lookup)
 */

$response = $client->post('/mnp-lookup', array(
    'msisdn' => '+14156226819'
));

echo "MNP Lookup Status Code: " . $response->httpStatusCode . "\n";
echo "MNP Lookup Response Body: " . $response->responseBody . "\n\n";

if ($response->httpStatusCode != 200) {
    // something went wrong, let's abort and debug by looking at our log file specified above in the client.
    echo "Invalid Response from server (MNP).";
}


