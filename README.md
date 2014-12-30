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
 * Returns the remaining balance (EUR) in your account.
 *
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"balance":"5878.24600"}}
 */
echo $client->getBalance();

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
echo $client->setAsyncCallbackUrl('http://user:pass@www.your-server.com/path/file');

/**
 * Parses an asynchronous HLR Lookup callback and returns a JSON string with the results.
 *
 * @param array $request
 * @return string (JSON)
 *
 * Return example: {"success":true,"results":[{"id":"40ebb8d9e7cc","msisdncountrycode":"DE","msisdn":"+491788735001","statuscode":"HLRSTATUS_DELIVERED","hlrerrorcodeid":null,"subscriberstatus":"SUBSCRIBERSTATUS_CONNECTED","imsi":"262032000000000","mccmnc":"26203","mcc":"262","mnc":"03","msin":"2000000000","servingmsc":"491770","servinghlr":null,"originalnetworkname":"178","originalcountryname":"Germany","originalcountrycode":"DE","originalcountryprefix":"+49","originalnetworkprefix":"178","roamingnetworkname":null,"roamingcountryname":null,"roamingcountrycode":null,"roamingcountryprefix":null,"roamingnetworkprefix":null,"portednetworkname":null,"portedcountryname":null,"portedcountrycode":null,"portedcountryprefix":null,"portednetworkprefix":null,"isvalid":"Yes","isroaming":"No","isported":"No","usercharge":"0.0100","inserttime":"2014-12-28 05:53:03.765798+08","storage":"ASYNC-API","route":"IP4"}]}
 */
echo $client->submitAsyncLookupRequest(array('+491788735000','+491788735001'));
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
 * Returns the remaining balance (EUR) in your account.
 *
 * @return string (JSON)
 *
 * Return example: {"success":true,"messages":[],"results":{"balance":"5878.24600"}}
 */
echo $client->getBalance();

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
echo $client->setAsyncCallbackUrl('http://user:pass@www.your-server.com/path/file');

/**
 * Parses an asynchronous HLR Lookup callback and returns a JSON string with the results.
 *
 * @param array $request
 * @return string (JSON)
 *
 * Return example: {"success":true,"results":[{"id":"40ebb8d9e7cc","msisdncountrycode":"DE","msisdn":"+491788735001","statuscode":"HLRSTATUS_DELIVERED","hlrerrorcodeid":null,"subscriberstatus":"SUBSCRIBERSTATUS_CONNECTED","imsi":"262032000000000","mccmnc":"26203","mcc":"262","mnc":"03","msin":"2000000000","servingmsc":"491770","servinghlr":null,"originalnetworkname":"178","originalcountryname":"Germany","originalcountrycode":"DE","originalcountryprefix":"+49","originalnetworkprefix":"178","roamingnetworkname":null,"roamingcountryname":null,"roamingcountrycode":null,"roamingcountryprefix":null,"roamingnetworkprefix":null,"portednetworkname":null,"portedcountryname":null,"portedcountrycode":null,"portedcountryprefix":null,"portednetworkprefix":null,"isvalid":"Yes","isroaming":"No","isported":"No","usercharge":"0.0100","inserttime":"2014-12-28 05:53:03.765798+08","storage":"ASYNC-API","route":"IP4"}]}
 */
echo $client->submitAsyncLookupRequest(array('+491788735000','+491788735001'));
```

**Usage Callback Handler**
```php
include "HlrCallbackHandler.php";

$client = new HlrCallbackHandler();

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


