<?php
/**
 * Class HLRRESTClientResponseObject
 *
 * An instance of this class is returned by the get, post, put or delete methods in HLRLookupClient
 */
class HLRRESTClientResponseObject {

    /**
     * Contains the HTTP response in plain text. Usually this is a JSON string
     * @var String
     */
    var $responseBody = null;

    /**
     * Contains the HTTP response headers in plain text
     * @var String (headers are separated by \n\n)
     */
    var $responseHeaders = null;

    /**
     * The numeric HTTP status code, as given by the HLR Lookups server
     * @var integer
     */
    var $httpStatusCode = null;

    /**
     * Plain text curl error description, if any
     * @var String
     */
    var $curlError = null;

    /**
     * The numeric curl error code, if any
     * @var integer
     */
    var $curlErrNo = null;

    /**
     * Contains an array with the entire curl information, as given by PHP's native curl_info().
     * @var array
     */
    var $curlInfo = null;

    function __construct($responseBody, $responseHeaders, $httpStatusCode, $curlError, $curlErrNo, $curlInfo) {
        foreach (get_defined_vars() as $key => $value) {
            $this->$key = $value;
        }
    }

}