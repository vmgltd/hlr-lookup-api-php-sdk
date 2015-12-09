<?php

namespace VmgLtd;

/**
 * Class HlrCallbackHandler
 * @package VmgLtd
 */
class HlrCallbackHandler {

    /**
     * Parses an asynchronous HLR Lookup callback and returns a JSON string with the results.
     *
     * @param array $request
     * @return string (JSON)
     *
     * Params example: {"success":true,"results":[{"id":"40ebb8d9e7cc","msisdncountrycode":"DE","msisdn":"+491788735001","statuscode":"HLRSTATUS_DELIVERED","hlrerrorcodeid":null,"subscriberstatus":"SUBSCRIBERSTATUS_CONNECTED","imsi":"262032000000000","mccmnc":"26203","mcc":"262","mnc":"03","msin":"2000000000","servingmsc":"491770","servinghlr":null,"originalnetworkname":"178","originalcountryname":"Germany","originalcountrycode":"DE","originalcountryprefix":"+49","originalnetworkprefix":"178","roamingnetworkname":null,"roamingcountryname":null,"roamingcountrycode":null,"roamingcountryprefix":null,"roamingnetworkprefix":null,"portednetworkname":null,"portedcountryname":null,"portedcountrycode":null,"portedcountryprefix":null,"portednetworkprefix":null,"isvalid":"Yes","isroaming":"No","isported":"No","usercharge":"0.0100","inserttime":"2014-12-28 05:53:03.765798+08","storage":"ASYNC-API","route":"IP4","interface":"Async API"}]}
     */
    public function parseCallback($request = array()) {

        if (!isset($request['json']) || is_null(json_decode($request['json']))) {
            return self::generateInvalidCallbackResponse($request);
        }

        return $request['json'];

    }

    /**
     * @param array $request
     * @return string
     */
    private static function generateInvalidCallbackResponse($request = array()) {

        $response = new \StdClass();
        $response->success = false;
        $response->fieldErrors = array();
        $response->globalErrors = array(
            'Invalid Callback Data',
            print_r($request, true)
        );
        return json_encode($response);

    }

}

