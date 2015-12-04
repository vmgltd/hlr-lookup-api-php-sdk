<?php

namespace VmgLtd;

define('CLIENT_VERSION', '1.0.0');

define('HTTP_REQUEST_TYPE_GET', 0);
define('HTTP_REQUEST_TYPE_POST', 1);
define('HTTP_REQUEST_TYPE_PUT', 2);
define('HTTP_REQUEST_TYPE_DELETE', 3);


/**
 * Class HlrLookupClient
 * @package VmgLtd
 */
class HlrLookupClient {

    var $username = '';
    var $password = '';
    var $scheme = '';
    var $host = '';
    var $path = '';

    /**
     * Initializes the HLR Lookup Client
     *
     * @param string $username, www.hlr-lookups.com username
     * @param string $password, www.hlr-lookups.com password
     * @param bool $ssl, directive to enable/disable SSL
     */
    public function __construct($username = '', $password = '', $ssl = true) {

        $this->username = $username;
        $this->password = $password;
        $this->scheme = $ssl ? 'https' : 'http';
        $this->host = 'www.hlr-lookups.com';
        $this->path = '/api';

    }

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
    public function submitSyncLookupRequest($msisdn = '', $route = null, $storage = null) {

        return self::normalizeResponse(self::sendRequest(new CurlRequestParameters(
            $this->scheme,
            $this->host,
            $this->path,
            http_build_query(array(
                'username' => $this->username,
                'password' => $this->password,
                'action' => 'submitSyncLookupRequest',
                'msisdn' => $msisdn,
                'route' => $route ? $route : null,
                'storage' => $storage ? $storage : null
            ), '', '&'),
            HTTP_REQUEST_TYPE_GET
        )));

    }


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
    public function submitAsyncLookupRequest($msisdns = array(), $route = null, $storage = null) {

        return self::normalizeResponse(self::sendRequest(new CurlRequestParameters(
            $this->scheme,
            $this->host,
            $this->path,
            http_build_query(array(
                'username' => $this->username,
                'password' => $this->password,
                'action' => 'submitAsyncLookupRequest',
                'msisdns' => self::convertMsisdnsArrayToString($msisdns),
                'route' => $route ? $route : null,
                'storage' => $storage ? $storage : null
            ), '', '&'),
            HTTP_REQUEST_TYPE_GET
        )));

    }

    /**
     * Sets the callback URL for asynchronous HLR lookups. Read more about the concept of asynchronous HLR lookups @ http://www.hlr-lookups.com/en/asynchronous-hlr-lookup-api
     *
     * @param string $url - callback url on your server
     * @return string (JSON)
     *
     * Return example: {"success":true,"messages":[],"results":{"url":"http:\/\/user:pass@www.your-server.com\/path\/file"}}
     */
    public function setAsyncCallbackUrl($url = '') {

        return self::normalizeResponse(self::sendRequest(new CurlRequestParameters(
            $this->scheme,
            $this->host,
            $this->path,
            http_build_query(array(
                'username' => $this->username,
                'password' => $this->password,
                'action' => 'setAsyncCallbackUrl',
                'url' => $url
            ), '', '&'),
            HTTP_REQUEST_TYPE_GET
        )));

    }

    /**
     * Submits a synchronous number type lookup request. The HLR is queried in real time and results presented in the response body.
     *
     * @param string $number - A number in international format, e.g. +491788735000
     * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
     * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
     * @return string (JSON)
     *
     * Return example: {"success":true,"messages":[],"results":[{"id":"3cdb4e4d0ec1","number":"+4989702626","numbertype":"LANDLINE","state":"COMPLETED","isvalid":"Yes","ispossiblyported":"No","isvalidshortnumber":"No","isvanitynumber":"No","qualifiesforhlrlookup":"No","originalcarrier":null,"countrycode":"DE","mcc":null,"mnc":null,"mccmnc":null,"region":"Munich","timezones":["Europe\/Berlin"],"infotext":"This is a landline number.","usercharge":"0.0050","inserttime":"2015-12-04 13:02:48.415133+00","storage":"SYNC-API-NT-2015-12","route":"LC1"}]}
     */
    public function submitSyncNumberTypeLookupRequest($number = '', $route = null, $storage = null) {

        return self::normalizeResponse(self::sendRequest(new CurlRequestParameters(
            $this->scheme,
            $this->host,
            $this->path,
            http_build_query(array(
                'username' => $this->username,
                'password' => $this->password,
                'action' => 'submitSyncNumberTypeLookupRequest',
                'number' => $number,
                'route' => $route ? $route : null,
                'storage' => $storage ? $storage : null
            ), '', '&'),
            HTTP_REQUEST_TYPE_GET
        )));

    }


    /**
     * Submits asynchronous number type Lookups containing up to 1,000 MSISDNs per request. Results are sent back asynchronously to a callback URL on your server. Use \VmgLtd\HlrCallbackHandler to capture them.
     *
     * @param array $numbers - A list of phone numbers in international format, e.g. +491788735000
     * @param null $route - An optional route assignment, see: http://www.hlr-lookups.com/en/routing-options
     * @param null $storage - An optional storage assignment, see: http://www.hlr-lookups.com/en/storages
     * @return string (JSON)
     *
     * Return example: {"success":true,"messages":[],"results":{"acceptedNumbers":[{"id":"4f0820c76fb7","number":"+4989702626"},{"id":"9b9a7dab11a4","number":"+491788735000"}],"rejectedNumbers":[],"acceptedNumberCount":2,"rejectedNumberCount":0,"totalCount":2,"charge":0.01,"storage":"ASYNC-API-NT-2015-12","route":"LC1"}}
     */
    public function submitAsyncNumberTypeLookupRequest($numbers = array(), $route = null, $storage = null) {

        return self::normalizeResponse(self::sendRequest(new CurlRequestParameters(
            $this->scheme,
            $this->host,
            $this->path,
            http_build_query(array(
                'username' => $this->username,
                'password' => $this->password,
                'action' => 'submitAsyncLookupRequest',
                'numbers' => self::convertMsisdnsArrayToString($numbers),
                'route' => $route ? $route : null,
                'storage' => $storage ? $storage : null
            ), '', '&'),
            HTTP_REQUEST_TYPE_GET
        )));

    }

    /**
     * Sets the callback URL for asynchronous number type lookups.
     *
     * @param string $url - callback url on your server
     * @return string (JSON)
     *
     * Return example: {"success":true,"messages":[],"results":{"url":"http:\/\/user:pass@www.your-server.com\/path\/file"}}
     */
    public function setNtAsyncCallbackUrl($url = '') {

        return self::normalizeResponse(self::sendRequest(new CurlRequestParameters(
            $this->scheme,
            $this->host,
            $this->path,
            http_build_query(array(
                'username' => $this->username,
                'password' => $this->password,
                'action' => 'setNtAsyncCallbackUrl',
                'url' => $url
            ), '', '&'),
            HTTP_REQUEST_TYPE_GET
        )));

    }

    /**
     * Returns the remaining balance (EUR) in your account.
     *
     * @return string (JSON)
     *
     * Return example: {"success":true,"messages":[],"results":{"balance":"5878.24600"}}
     */
    public function getBalance() {

        return self::normalizeResponse(self::sendRequest(new CurlRequestParameters(
            $this->scheme,
            $this->host,
            $this->path,
            http_build_query(array(
                'username' => $this->username,
                'password' => $this->password,
                'action' => 'getBalance'
            ), '', '&'),
            HTTP_REQUEST_TYPE_GET
        )));

    }

    /**
     * Performs a system health check and returns a sanity report.
     *
     * @return string (JSON)
     *
     * Return example: {"success":true,"results":{"system":{"state":"up"},"routes":{"states":{"IP1":"up","ST2":"up","SV3":"up","IP4":"up","XT5":"up","XT6":"up","NT7":"up","LC1":"up"}},"account":{"lookupsPermitted":true,"balance":"509.35500"}}}
     */
    public function doHealthCheck() {

        return self::normalizeResponse(self::sendRequest(new CurlRequestParameters(
            $this->scheme,
            $this->host,
            $this->path,
            http_build_query(array(
                'username' => $this->username,
                'password' => $this->password,
                'action' => 'doHealthCheck'
            ), '', '&'),
            HTTP_REQUEST_TYPE_GET
        )));

    }

    /**
     * @param CurlResponseObject $curlResponseObject
     * @return string (JSON)
     */
    private static function normalizeResponse(CurlResponseObject $curlResponseObject) {

        if ($curlResponseObject->statusCode != 200) {
            $response = new \StdClass();
            $response->success = false;
            $response->fieldErrors = array();
            $response->globalErrors = array(
                print_r($curlResponseObject, true)
            );
            return json_encode($response);
        }

        return $curlResponseObject->curlContent;

    }

    /**
     * @param CurlRequestParameters $curlRequestParameters
     * @return CurlResponseObject
     */
    private static function sendRequest(CurlRequestParameters $curlRequestParameters) {

        $ch = curl_init($curlRequestParameters->scheme . '://' . $curlRequestParameters->host . $curlRequestParameters->path . ($curlRequestParameters->query ? '?' . $curlRequestParameters->query : null));
        $ch = self::setDefaultOptions($curlRequestParameters, $ch);

        switch ($curlRequestParameters->requestType) {
            case(HTTP_REQUEST_TYPE_POST):
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $curlRequestParameters->postFields);
                break;
            case(HTTP_REQUEST_TYPE_GET):
                break;
            case(HTTP_REQUEST_TYPE_DELETE):
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            case(HTTP_REQUEST_TYPE_PUT):
                break;
        }

        $curlResponseObject = new CurlResponseObject(
            trim(curl_exec($ch)),
            curl_error($ch),
            curl_errno($ch),
            curl_getinfo($ch),
            curl_getinfo($ch, CURLINFO_HTTP_CODE)
        );

        curl_close($ch);

        return $curlResponseObject;

    }

    /**
     * @param CurlRequestParameters $curlRequestParameters
     * @param $curlHandle
     * @return mixed
     */
    private static function setDefaultOptions(CurlRequestParameters $curlRequestParameters, $curlHandle) {

        curl_setopt($curlHandle, CURLOPT_PORT, $curlRequestParameters->port ? $curlRequestParameters->port : ($curlRequestParameters->scheme == 'https' ? 443 : 80));
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curlHandle, CURLOPT_AUTOREFERER, true);
        curl_setopt($curlHandle, CURLOPT_USERAGENT, 'VmgLtd/HlrLookupClient PHP SDK ' . CLIENT_VERSION);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 7200);
        curl_setopt($curlHandle, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curlHandle, CURLOPT_SSLVERSION, 3);
        curl_setopt($curlHandle, CURLINFO_HEADER_OUT, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);

        if (!is_null($curlRequestParameters->basicAuthUsername) && !is_null($curlRequestParameters->basicAuthPassword)) {
            curl_setopt($curlHandle, CURLOPT_USERPWD, $curlRequestParameters->basicAuthUsername . ":" . $curlRequestParameters->basicAuthPassword);
        }

        if (count($curlRequestParameters->headers) > 0) {
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $curlRequestParameters->headers);
        }

        return $curlHandle;

    }

    /**
     * Converts an array of MSISDNs to a comma separated string.
     *
     * @param $msisdns array
     * @return null|string
     */
    private static function convertMsisdnsArrayToString($msisdns= array()) {

        $string = null;

        foreach ($msisdns as $key => $value) {

            if(!is_int($value) && !is_string($value)) continue;

            if ($key > 0) {
                $string .= ',';
            }

            $string .= $value;

        }

        return $string;

    }

}

/**
 * Class CurlRequestParameters
 * @package VmgLtd
 */
class CurlRequestParameters {

    var $scheme;        // http or https
    var $host;          // www.host.com:443
    var $port;
    var $path;          // /path/to/target
    var $query;         // query string
    var $postFields;    // query string
    var $requestType;   // HTTP_REQUEST_TYPE
    var $basicAuthUsername = null;
    var $basicAuthPassword = null;
    var $headers = array();

    /**
     * @param $scheme
     * @param $host
     * @param $path
     * @param $query
     * @param $requestType
     * @param null $basicAuthUsername
     * @param null $basicAuthPassword
     * @param array $headers
     * @param null $postFields
     */
    function __construct($scheme, $host, $path, $query, $requestType, $basicAuthUsername = null, $basicAuthPassword = null, $headers = array(), $postFields = null) {
        foreach (get_defined_vars() as $key => $value) {

            if ($key == 'host' && preg_match("/:/", $value)) {
                $pieces = explode(":", $value);
                $this->port = $pieces[1];
                $value = $pieces[0];
            }

            $this->$key = $value;
        }
    }

}

/**
 * Class CurlResponseObject
 * @package VmgLtd
 */
class CurlResponseObject {

    var $curlContent = null;
    var $curlError = null;
    var $curlErrNo = null;
    var $curlInfo = null;
    var $statusCode = null;

    /**
     * @param $curlContent
     * @param $curlError
     * @param $curlErrNo
     * @param $curlInfo
     * @param $statusCode
     */
    function __construct($curlContent, $curlError, $curlErrNo, $curlInfo, $statusCode) {
        foreach (get_defined_vars() as $key => $value) {
            $this->$key = $value;
        }
    }

}

