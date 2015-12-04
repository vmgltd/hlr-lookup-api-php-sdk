hlr-lookup-api-php-sdk
======================
Official HLR Lookup API PHP SDK by www.hlr-lookups.com

This SDK implements the REST API documented at https://www.hlr-lookups.com/en/api-docs

For SDKs in different languages, see https://www.hlr-lookups.com/en/sdks

Requirements
------------
* PHP >=5.3.0
* cURL extension for PHP
* Recommended: OpenSSL extension for PHP

The SDK can be installed with Composer or as a drop-in with simple PHP file includes.

Installation with Composer
--------------------------
```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Require hlr-lookup-api-php-sdk as a dependency
php composer.phar require vmgltd/hlr-lookup-api-php-sdk
```

Once installed you can include the library in your project by using Composer's autoloader:
```php
require 'vendor/autoload.php';
```

**Usage Client**
```php
require_once __DIR__ . '/vendor/autoload.php';

use VmgLtd\HlrLookupClient;

$client = new HlrLookupClient('username', 'password');

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
echo $client->submitSyncLookupRequest('+491788735000');

/**
 * Submits a synchronous number type lookup request. Results are presented in the response body.
 *
 * @param string $number - A number in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"results":[{"id":"3cdb4e4d0ec1","number":"+4989702626","numbertype":"LANDLINE","state":"COMPLETED","isvalid":"Yes","ispossiblyported":"No","isvalidshortnumber":"No","isvanitynumber":"No","qualifiesforhlrlookup":"No","originalcarrier":null,"countrycode":"DE","mcc":null,"mnc":null,"mccmnc":null,"region":"Munich","timezones":["Europe\/Berlin"],"infotext":"This is a landline number.","usercharge":"0.0050","inserttime":"2015-12-04 13:02:48.415133+00","storage":"SYNC-API-NT-2015-12","route":"LC1"}]}
 */
 echo $client->submitSyncNumberTypeLookupRequest('+4989702626');

/**
 * Returns the remaining balance (EUR) in your account.
 *
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"balance":"5878.24600"}}
 */
echo $client->getBalance();

/**
 * Performs a system health check and returns a sanity report.
 *
 * @return string (JSON)
 *
 * Return example: { "success":true, "results":{ "system":{ "state":"up" }, "routes":{ "states":{ "IP1":"up", "ST2":"up", "SV3":"up", "IP4":"up", "XT5":"up", "XT6":"up", "NT7":"up", "LC1":"up" } }, "account":{ "lookupsPermitted":true, "balance":"295.23000" } } }
 */
echo $client->doHealthCheck();

/**
 * Sets the callback URL for asynchronous HLR lookups. Read more about the concept of asynchronous HLR lookups @ http://www.hlr-lookups.com/en/asynchronous-hlr-lookup-api
 *
 * @param string $url - callback url on your server
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"url":"http:\/\/user:pass@www.your-server.com\/path\/file"}}
 */
echo $client->setAsyncCallbackUrl('http://user:pass@www.your-server.com/path/file');

/**
 * Submits asynchronous HLR Lookups containing up to 1,000 MSISDNs per request. Results are sent back asynchronously to a callback URL on your server.
 *
 * @param array $msisdns - A list of MSISDNs in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"acceptedMsisdns":[{"id":"e489a092eba7","msisdn":"+491788735000"},{"id":"23ad48bf0c26","msisdn":"+491788735001"}],"rejectedMsisdns":[],"acceptedMsisdnCount":2,"rejectedMsisdnCount":0,"totalCount":2,"charge":0.02,"storage":"SDK-TEST-ASYNC-API","route":"IP4"}}
 */
echo $client->submitAsyncLookupRequest(array('+491788735000','+491788735001'));

/**
 * Sets the callback URL for asynchronous number type lookups. 
 *
 * @param string $url - callback url on your server
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"url":"http:\/\/user:pass@www.your-server.com\/path\/file"}}
 */
echo $client->setNtAsyncCallbackUrl('http://user:pass@www.your-server.com/path/file');

/**
 * Submits asynchronous number type lookups containing up to 1,000 MSISDNs per request. Results are sent back asynchronously to a callback URL on your server. Use \VmgLtd\HlrCallbackHandler to capture them.
 *
 * @param array $numbers - A list of phone numbers in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"acceptedNumbers":[{"id":"4f0820c76fb7","number":"+4989702626"},{"id":"9b9a7dab11a4","number":"+491788735000"}],"rejectedNumbers":[],"acceptedNumberCount":2,"rejectedNumberCount":0,"totalCount":2,"charge":0.01,"storage":"ASYNC-API-NT-2015-12","route":"LC1"}}
 */
echo $client->submitAsyncNumberTypeLookupRequest(array('+4989702626','+491788735000'));


```

**Usage Callback Handler**
```php
require_once __DIR__ . '/vendor/autoload.php';

use VmgLtd\HlrCallbackHandler;

$handler = new HlrCallbackHandler();

/**
 * Parses an asynchronous HLR Lookup callback and returns a JSON string with the results.
 *
 * @param array $request
 * @return string (JSON)
 *
 * Return example: {"success":true,"results":[{"id":"40ebb8d9e7cc","msisdncountrycode":"DE","msisdn":"+491788735001","statuscode":"HLRSTATUS_DELIVERED","hlrerrorcodeid":null,"subscriberstatus":"SUBSCRIBERSTATUS_CONNECTED","imsi":"262032000000000","mccmnc":"26203","mcc":"262","mnc":"03","msin":"2000000000","servingmsc":"491770","servinghlr":null,"originalnetworkname":"178","originalcountryname":"Germany","originalcountrycode":"DE","originalcountryprefix":"+49","originalnetworkprefix":"178","roamingnetworkname":null,"roamingcountryname":null,"roamingcountrycode":null,"roamingcountryprefix":null,"roamingnetworkprefix":null,"portednetworkname":null,"portedcountryname":null,"portedcountrycode":null,"portedcountryprefix":null,"portednetworkprefix":null,"isvalid":"Yes","isroaming":"No","isported":"No","usercharge":"0.0100","inserttime":"2014-12-28 05:53:03.765798+08","storage":"ASYNC-API","route":"IP4"}]}
 */
echo $handler->parseCallback($_REQUEST);
```

Installation as Drop-In
-----------------------
Copy the contents of `src/VmgLtd` into the include path of your project.

**Usage Client**
```php
include "HlrLookupClient.php";

$client = new \VmgLtd\HlrLookupClient('username', 'password');

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
echo $client->submitSyncLookupRequest('+491788735000');

/**
 * Submits a synchronous number type lookup request. Results are presented in the response body.
 *
 * @param string $number - A number in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"results":[{"id":"3cdb4e4d0ec1","number":"+4989702626","numbertype":"LANDLINE","state":"COMPLETED","isvalid":"Yes","ispossiblyported":"No","isvalidshortnumber":"No","isvanitynumber":"No","qualifiesforhlrlookup":"No","originalcarrier":null,"countrycode":"DE","mcc":null,"mnc":null,"mccmnc":null,"region":"Munich","timezones":["Europe\/Berlin"],"infotext":"This is a landline number.","usercharge":"0.0050","inserttime":"2015-12-04 13:02:48.415133+00","storage":"SYNC-API-NT-2015-12","route":"LC1"}]}
 */
 echo $client->submitSyncNumberTypeLookupRequest('+4989702626');

/**
 * Returns the remaining balance (EUR) in your account.
 *
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"balance":"5878.24600"}}
 */
echo $client->getBalance();

/**
 * Performs a system health check and returns a sanity report.
 *
 * @return string (JSON)
 *
 * Return example: { "success":true, "results":{ "system":{ "state":"up" }, "routes":{ "states":{ "IP1":"up", "ST2":"up", "SV3":"up", "IP4":"up", "XT5":"up", "XT6":"up", "NT7":"up", "LC1":"up" } }, "account":{ "lookupsPermitted":true, "balance":"295.23000" } } }
 */
echo $client->doHealthCheck();


/**
 * Sets the callback URL for asynchronous HLR lookups. Read more about the concept of asynchronous HLR lookups @ http://www.hlr-lookups.com/en/asynchronous-hlr-lookup-api
 *
 * @param string $url - callback url on your server
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"url":"http:\/\/user:pass@www.your-server.com\/path\/file"}}
 */
echo $client->setAsyncCallbackUrl('http://user:pass@www.your-server.com/path/file');

/**
 * Submits asynchronous HLR Lookups containing up to 1,000 MSISDNs per request. Results are sent back asynchronously to a callback URL on your server.
 *
 * @param array $msisdns - A list of MSISDNs in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"acceptedMsisdns":[{"id":"e489a092eba7","msisdn":"+491788735000"},{"id":"23ad48bf0c26","msisdn":"+491788735001"}],"rejectedMsisdns":[],"acceptedMsisdnCount":2,"rejectedMsisdnCount":0,"totalCount":2,"charge":0.02,"storage":"SDK-TEST-ASYNC-API","route":"IP4"}}
 */
echo $client->submitAsyncLookupRequest(array('+491788735000','+491788735001'));

/**
 * Sets the callback URL for asynchronous number type lookups. 
 *
 * @param string $url - callback url on your server
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"url":"http:\/\/user:pass@www.your-server.com\/path\/file"}}
 */
echo $client->setNtAsyncCallbackUrl('http://user:pass@www.your-server.com/path/file');

/**
 * Submits asynchronous number type lookups containing up to 1,000 MSISDNs per request. Results are sent back asynchronously to a callback URL on your server. Use \VmgLtd\HlrCallbackHandler to capture them.
 *
 * @param array $numbers - A list of phone numbers in international format, e.g. +491788735000
 * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
 * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"acceptedNumbers":[{"id":"4f0820c76fb7","number":"+4989702626"},{"id":"9b9a7dab11a4","number":"+491788735000"}],"rejectedNumbers":[],"acceptedNumberCount":2,"rejectedNumberCount":0,"totalCount":2,"charge":0.01,"storage":"ASYNC-API-NT-2015-12","route":"LC1"}}
 */
echo $client->submitAsyncNumberTypeLookupRequest(array('+4989702626','+491788735000'));
```

**Usage Callback Handler**
```php
include "HlrCallbackHandler.php";

$client = new \VmgLtd\HlrCallbackHandler();

/**
 * Parses an asynchronous HLR Lookup callback and returns a JSON string with the results.
 *
 * @param array $request
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":[{"id":"40ebb8d9e7cc","msisdncountrycode":"DE","msisdn":"+491788735001","statuscode":"HLRSTATUS_DELIVERED","hlrerrorcodeid":null,"subscriberstatus":"SUBSCRIBERSTATUS_CONNECTED","imsi":"262032000000000","mccmnc":"26203","mcc":"262","mnc":"03","msin":"2000000000","servingmsc":"491770","servinghlr":null,"originalnetworkname":"178","originalcountryname":"Germany","originalcountrycode":"DE","originalcountryprefix":"+49","originalnetworkprefix":"178","roamingnetworkname":null,"roamingcountryname":null,"roamingcountrycode":null,"roamingcountryprefix":null,"roamingnetworkprefix":null,"portednetworkname":null,"portedcountryname":null,"portedcountrycode":null,"portedcountryprefix":null,"portednetworkprefix":null,"isvalid":"Yes","isroaming":"No","isported":"No","usercharge":"0.0100","inserttime":"2014-12-28 05:53:03.765798+08","storage":"ASYNC-API","route":"IP4"}]}
 */
echo $handler->parseCallback($_REQUEST);
```

With that you should be ready to go!

Tests
-----

The code contains annotations and you can find usage examples as tests in `tests/`:
* `tests/test-composer.php`
* `tests/test-drop-in.php`

Please refer to https://www.hlr-lookups.com/en/sdk-php for further documentation or send us an email to service@hlr-lookups.com.

Support and Feedback
--------------------
Your feedback is appreciated! If you have specific problems or bugs with this SDK, please file an issue on Github. For general feedback and support requests, send an email to service@hlr-lookups.com.

Contributing
------------

1. Fork it ( https://github.com/vmgltd/hlr-lookup-api-php-sdk/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request


