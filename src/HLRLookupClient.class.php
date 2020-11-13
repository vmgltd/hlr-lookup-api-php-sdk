<?php
include('HLRRESTClient.class.php');
include('HLRRESTClientResponseObject.class.php');
include('HLRLoggingService.class.php');

/**
 * Class HLRLookupClient
 *
 * PHP implementation of a REST client for the HLR Lookups API
 * see https://www.hlr-lookups.com/en/api-docs
 */
class HLRLookupClient extends HLRRESTClient {

    /**
     * The API Key as given by https://www.hlr-lookups.com/en/api-settings
     * This is initialized by the constructor, see below.
     *
     * @var string
     */
    var $key = null;

    /**
     * The API Secret as given by https://www.hlr-lookups.com/en/api-settings
     * This is initialized by the constructor, see below.
     *
     * @var string
     */
    var $secret = null;

    /**
     * The API version to which we connect (leave it as is)
     *
     * @var string
     */
    var $apiVersion = 'v2';

    /**
     * Used in the HTTP user agent (leave it as is)
     *
     * @var string
     */
    var $clientName = 'php-sdk';

    /**
     * The current version of this SDK, used in the HTTP user agent (leave it as is)
     *
     * @var string
     */
    var $clientVersion = '2.0.0';

    /**
     * Indicates whether requests and responses should be logged
     * This is automatically initialized by the constructor, see below.
     *
     * @var boolean
     */
    var $enableLogging = false;

    /**
     * Specifies the log file to which to write, if any.
     * This is initialized by the constructor, see below.
     *
     * @var string
     */
    var $logFile = null;

    /**
     * HLR Lookup API client constructor, initialize this with the API key and secret as given by https://www.hlr-lookups.com/en/api-settings
     *
     * @param string $key Your HLR Lookups API Key
     * @param string $secret Your HLR Lookups API Secret
     * @param string $logFile Log file location, if any
     */
    public function __construct($key = null, $secret = null, $logFile = null) {

        $this->key = $key;
        $this->secret = $secret;

        if (!is_null($logFile)) {
            $this->logFile = $logFile;
            $this->enableLogging = true;
        }

        parent::__construct('https', 'www.hlr-lookups.com', '/api/' . $this->apiVersion);

    }

    /**
     * Use this method to communicate with GET endpoints
     *
     * @param string $endpoint
     * @param array $params, a list of GET parameters to be included in the request
     * @return HLRRESTClientResponseObject
     */
    public function get($endpoint = '/', $params = array()) {

        $method = 'GET';
        $authHeaders = $this->buildAuthHeaders($endpoint, $method, $params);
        $response = parent::sendRequest($endpoint, $method, array(), false, $params, $authHeaders, $this->buildCustomOptions());
        $this->log("[HLRLookupClient][get] Request: GET $endpoint Params: " . json_encode($params) . " Auth Headers: " . json_encode($authHeaders));
        $this->log("[HLRLookupClient][get] Response: " . json_encode($response));
        return $response;

    }

    /**
     * Use this method to communicate with POST endpoints
     *
     * @param string $endpoint
     * @param array $params, an array representing the JSON payload to include in this request
     * @return HLRRESTClientResponseObject
     */
    public function post($endpoint = '/', $params = array()) {

        $method = 'POST';
        $authHeaders = $this->buildAuthHeaders($endpoint, $method, $params);
        $response = $this->sendRequest($endpoint, $method, $params, true, array(), $authHeaders, $this->buildCustomOptions());
        $this->log("[HLRLookupClient][post] Request: GET $endpoint Params: " . json_encode($params) . " Auth Headers: " . json_encode($authHeaders));
        $this->log("[HLRLookupClient][post] Response: " . json_encode($response));
        return $response;
    }

    /**
     * Use this method to communicate with DELETE endpoints
     *
     * @param string $endpoint
     * @param array $params, an array representing the JSON payload to include in this request
     * @return HLRRESTClientResponseObject
     */
    public function delete($endpoint = '/', $params = array()) {

        $method = 'DELETE';
        $authHeaders = $this->buildAuthHeaders($endpoint, $method, $params);
        $response = $this->sendRequest($endpoint, $method, $params, true, array(), $authHeaders, $this->buildCustomOptions());
        $this->log("[HLRLookupClient][delete] Request: DELETE $endpoint Params: " . json_encode($params) . " Auth Headers: " . json_encode($authHeaders));
        $this->log("[HLRLookupClient][delete] Response: " . json_encode($response));
        return $response;

    }

    /**
     * Use this method to communicate with PUT endpoints
     *
     * @param string $endpoint
     * @param array $params, an array representing the JSON payload to include in this request
     * @return HLRRESTClientResponseObject
     */
    public function put($endpoint = '/', $params = array()) {

        $method = 'PUT';
        $authHeaders = $this->buildAuthHeaders($endpoint, $method, $params);
        $response = $this->sendRequest($endpoint, $method, $params, true, array(), $authHeaders, $this->buildCustomOptions());
        $this->log("[HLRLookupClient][put] Request: PUT $endpoint Params: " . json_encode($params) . " Auth Headers: " . json_encode($authHeaders));
        $this->log("[HLRLookupClient][put] Response: " . json_encode($response));
        return $response;

    }

    /**
     * Private class to automatically generate authentication headers.
     *
     * @param $path
     * @param $method
     * @param array $params
     * @return array
     */
    private function buildAuthHeaders($path, $method, $params = array()) {

        $timestamp = json_decode(file_get_contents('https://www.hlr-lookups.com/api/v2/time'))->time;
        $body = $method != 'GET' ? (count($params) ? json_encode($params) : null) : null;
        return array(
            'X-Digest-Key: ' . $this->key,
            'X-Digest-Signature: ' . hash_hmac('sha256', $path . $timestamp . $method . $body, $this->secret),
            'X-Digest-Timestamp: ' . $timestamp
        );

    }

    /**
     * Private class to automatically generate the user agent in the request
     *
     * @return array
     */
    private function buildCustomOptions() {

        return array(CURLOPT_USERAGENT => $this->clientName . ' ' . $this->clientVersion . ' (' . $this->key . ')');

    }

    /**
     * Private class to optionally log API request and response
     *
     * @param $message
     */
    private function log($message) {

        if (!$this->enableLogging) {
            return;
        }

        HLRLoggingService::write($message, $this->logFile);

    }

}







