<?php
require_once __DIR__ . '/../vendor/autoload.php';

use VmgLtd\HlrLookupClient;
use VmgLtd\HlrCallbackHandler;

$client = new HlrLookupClient('username', 'password');

/**
 * Returns the remaining balance (EUR) in your account.
 *
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"balance":"5878.24600"}}
 */
echo "\n\n";
echo $client->getBalance();
echo "\n\n";


/**
 * Performs a system health check and returns a sanity report.
 *
 * @return string (JSON)
 *
 * Return example: { "success":true, "results":{ "system":{ "state":"up" }, "routes":{ "states":{ "IP1":"up", "ST2":"up", "SV3":"up", "IP4":"up", "XT5":"up", "XT6":"up", "NT7":"up", "LC1":"up" } }, "account":{ "lookupsPermitted":true, "balance":"295.23000" } } }
 */
echo "\n\n";
echo $client->doHealthCheck();
echo "\n\n";


/**
 * Submits a synchronous HLR Lookup request. The HLR is queried in real time and results presented in the response body.
 *
 * @param string $msisdn - An MSISDN in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"results":[{"id":"e1fdf26531e4","msisdncountrycode":"DE","msisdn":"+491788735000","statuscode":"HLRSTATUS_DELIVERED","hlrerrorcodeid":null,"subscriberstatus":"SUBSCRIBERSTATUS_CONNECTED","imsi":"262031300000000","mccmnc":"26203","mcc":"262","mnc":"03","msin":"1300000000","servingmsc":"140445","servinghlr":null,"originalnetworkname":"E-Plus","originalcountryname":"Germany","originalcountrycode":"DE","originalcountryprefix":"+49","originalnetworkprefix":"178","roamingnetworkname":"Fixed Line Operators and Other Networks","roamingcountryname":"United States","roamingcountrycode":"US","roamingcountryprefix":"+1","roamingnetworkprefix":"404455","portednetworkname":null,"portedcountryname":null,"portedcountrycode":null,"portedcountryprefix":null,"portednetworkprefix":null,"isvalid":"Yes","isroaming":"Yes","isported":"No","usercharge":"0.0100","inserttime":"2014-12-28 06:22:00.328844+08","storage":"SDK-TEST-SYNC-API","route":"IP1"}]}
 */
echo "\n\n";
echo $client->submitSyncLookupRequest('+491788735000');
echo "\n\n";

/**
 * Submits a synchronous number type lookup request. The HLR is queried in real time and results presented in the response body.
 *
 * @param string $number - A number in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"results":[{"id":"3cdb4e4d0ec1","number":"+4989702626","numbertype":"LANDLINE","state":"COMPLETED","isvalid":"Yes","ispossiblyported":"No","isvalidshortnumber":"No","isvanitynumber":"No","qualifiesforhlrlookup":"No","originalcarrier":null,"countrycode":"DE","mcc":null,"mnc":null,"mccmnc":null,"region":"Munich","timezones":["Europe\/Berlin"],"infotext":"This is a landline number.","usercharge":"0.0050","inserttime":"2015-12-04 13:02:48.415133+00","storage":"SYNC-API-NT-2015-12","route":"LC1"}]}
 */
echo "\n\n";
echo $client->submitSyncNumberTypeLookupRequest('+4989702626');
echo "\n\n";


/**
 * Sets the callback URL for asynchronous lookups.
 *
 * @param string $url
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"url":"http:\/\/user:pass@www.your-server.com\/path\/file"}}
 */
echo "\n\n";
echo $client->setAsyncCallbackUrl('http://user:pass@www.your-server.com/path/file');
echo "\n\n";


/**
 * Submits asynchronous HLR Lookups containing up to 1,000 MSISDNs per request. Results are sent back asynchronously to a callback URL on your server. Use \VmgLtd\HlrCallbackHandler to capture them.
 *
 * @param array $msisdns - A list of MSISDNs in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"acceptedMsisdns":[{"id":"e489a092eba7","msisdn":"+491788735000"},{"id":"23ad48bf0c26","msisdn":"+491788735001"}],"rejectedMsisdns":[],"acceptedMsisdnCount":2,"rejectedMsisdnCount":0,"totalCount":2,"charge":0.02,"storage":"SDK-TEST-ASYNC-API","route":"IP4"}}
 */
echo "\n\n";
echo $client->submitAsyncLookupRequest(array('+491788735000','+491788735001'));
echo "\n\n";

/**
 * Sets the callback URL for asynchronous number type lookups.
 *
 * @param string $url - callback url on your server
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"url":"http:\/\/user:pass@www.your-server.com\/path\/file"}}
 */
echo "\n\n";
echo $client->setNtAsyncCallbackUrl('http://user:pass@www.your-server.com/path/file');
echo "\n\n";

/**
 * Submits asynchronous number type lookups containing up to 1,000 numbers per request. Results are sent back asynchronously to a callback URL on your server. Use \VmgLtd\HlrCallbackHandler to capture them.
 *
 * @param array $numbers - A list of phone numbers in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"acceptedNumbers":[{"id":"4f0820c76fb7","number":"+4989702626"},{"id":"9b9a7dab11a4","number":"+491788735000"}],"rejectedNumbers":[],"acceptedNumberCount":2,"rejectedNumberCount":0,"totalCount":2,"charge":0.01,"storage":"ASYNC-API-NT-2015-12","route":"LC1"}}
 */
echo "\n\n";
echo $client->submitAsyncNumberTypeLookupRequest(array('+4989702626','+491788735000'));
echo "\n\n";

$handler = new HlrCallbackHandler();

/**
 * Parses an asynchronous HLR Lookup callback and returns a JSON string with the results.
 *
 * @param array $request
 * @return string (JSON)
 *
 * Return example: {"success":true,"results":[{"id":"40ebb8d9e7cc","msisdncountrycode":"DE","msisdn":"+491788735001","statuscode":"HLRSTATUS_DELIVERED","hlrerrorcodeid":null,"subscriberstatus":"SUBSCRIBERSTATUS_CONNECTED","imsi":"262032000000000","mccmnc":"26203","mcc":"262","mnc":"03","msin":"2000000000","servingmsc":"491770","servinghlr":null,"originalnetworkname":"178","originalcountryname":"Germany","originalcountrycode":"DE","originalcountryprefix":"+49","originalnetworkprefix":"178","roamingnetworkname":null,"roamingcountryname":null,"roamingcountrycode":null,"roamingcountryprefix":null,"roamingnetworkprefix":null,"portednetworkname":null,"portedcountryname":null,"portedcountrycode":null,"portedcountryprefix":null,"portednetworkprefix":null,"isvalid":"Yes","isroaming":"No","isported":"No","usercharge":"0.0100","inserttime":"2014-12-28 05:53:03.765798+08","storage":"ASYNC-API","route":"IP4"}]}
 */
echo "\n\n";
echo $handler->parseCallback($_REQUEST);
echo "\n\n";