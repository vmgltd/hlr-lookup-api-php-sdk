hlr-lookup-api-php-sdk
======================
Official HLR Lookup API PHP SDK by www.hlr-lookups.com

For SDKs in different languages, see https://www.hlr-lookups.com/en/sdks

Requirements
------------
* PHP >=5.3.0
* cURL extension for PHP

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

**Usage**
```php
require_once __DIR__ . '/vendor/autoload.php';

use VmgLtd\HlrLookupClient;

$client = new HlrLookupClient('username', 'password');

echo $client->submitSyncLookupRequest('+491788735000');
```

Installation as Drop-In
-----------------------
Copy the contents of `src/VmgLtd` into the include path of your project.

**Usage**
```php
include "HlrLookupClient.php";

$client = new \VmgLtd\HlrLookupClient('username', 'password');

echo $client->submitSyncLookupRequest('+491788735000');
```

With that you should be ready to go!

Tests
-----

The code contains annotations and you can find usage examples as tests in `tests/`:
* `tests/test-composer.php`
* `tests/test-drop-in.php`

Please refer to https://www.hlr-lookups.com/en/sdks/php for further documentation or send us an email to service@hlr-lookups.com.

Support and Feedback
--------------------
Your feedback is appreciated! If you have specific problems or bugs with this SDK, please file an issue on Github. For general feedback and support requests, send an email to service@hlr-lookups.com.


