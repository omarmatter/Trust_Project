<?php

namespace Modules\Order\Services\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PayfortIntegration
{
    public $merchantIdentifier ;
    public $accessCode     ;
    public $SHARequestPhrase  ;
    public $SHAResponsePhrase ;
    public $SHAType       ;
    public $sandboxMode = true;
    public $gatewayHost = 'https://checkout.payfort.com/';
    public $gatewaySandboxHost = 'https://sbcheckout.payfort.com/';



    public function __construct()
    {
     $this->merchantIdentifier = env('MERCHANT_IDENTIFIER');
     $this->accessCode=env('ACCESS_CODE');
     $this->SHARequestPhrase= env('SHA_REQUEST_PASSPHRASE');
     $this->SHAResponsePhrase=env('SHA_RESPONSE_PASSPHRASE');
     $this->SHAType =env('SHA_Type');
    }

    public function Tokenization()
    {
        $merchantReference = $this->generateMerchantReference();


        $iframeParams              = array(
            'merchant_identifier' => $this->merchantIdentifier,
            'access_code'         => $this->accessCode,
            'merchant_reference'  => $merchantReference,
            'service_command'     => 'TOKENIZATION',
            'language'            => 'ar',
            'return_url'          => 'url',
        );

        $iframeParams['signature'] = $this->calculateSignature($iframeParams, 'request');

        if ($this->sandboxMode) {

            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';

        }
        else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }
        $this->callApi($iframeParams,$gatewayUrl);
    }

    public function getRedirectionData(Request $request) {
        $merchantReference = $this->generateMerchantReference();
        if ($this->sandboxMode) {
            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
        }
        else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }

        $postData = array(
            'amount'              => $this->convertFortAmount($request->amount, $request->currency),
            'currency'            => strtoupper($request->currency),
            'merchant_identifier' => $this->merchantIdentifier,
            'access_code'         => $this->accessCode,
            'merchant_reference'   => $merchantReference,
            'customer_email'      => $request->customer_email,
            'command'             => "PURCHASE",
            'language'            => "en",
            'return_url'          => URL('Process/'),
        );

        $postData['signature'] = $this->calculateSignature($postData, 'request');


      return  $this->callApi($postData ,$gatewayUrl);
    }

    public function convertFortAmount($amount, $currencyCode)
    {
        $new_amount = 0;
        $total = $amount;

        $new_amount = round($total, 3) * (pow(10, 3));
        return $new_amount;
    }
    public function calculateSignature($arrData, $signType = 'request')
    {
        $shaString = '';
        ksort($arrData);
        foreach ($arrData as $k => $v) {
            $shaString .= "$k=$v";
        }

        if ($signType == 'request') {
            $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        } else {
            $shaString = $this->SHAResponsePhrase . $shaString . $this->SHAResponsePhrase;
        }
        $signature = Hash::make($this->SHAType);

        return $signature;
    }
    public function generateMerchantReference()
    {
        return (string) Str::uuid();
    }

    public function callApi($postData, $gatewayUrl)
    {

        $ch = curl_init();
        $useragent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0";
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json;charset=UTF-8',
        ));
        curl_setopt($ch, CURLOPT_URL, $gatewayUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "compress, gzip");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); // The number of seconds to wait while trying to connect
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
       return $response;

        curl_close($ch);

        $array_result = json_decode($response, true);

        if (!$response || empty($array_result)) {
            return false;
        }
        return "ssss";

    }
    public function processResponse($data)
    {
        $fortParams = $data;

        $reason = '';
        $response_code = '';
        $success = true;
        if (empty($fortParams)) {
            $success = false;
            $reason = "Invalid Response Parameters";
        } else {
            //validate payfort response
            $params = $fortParams;
            $responseSignature = $fortParams['signature'];
            $merchantReference = $params['merchant_reference'];
            unset($params['r']);
            unset($params['signature']);
            unset($params['integration_type']);
            $calculatedSignature = $this->calculateSignature($params, 'response');
            $success = true;
            $reason = '';

            if ($responseSignature != $calculatedSignature) {
                $success = false;
                $reason = 'Invalid signature.';

            } else {
                $response_code = $params['response_code'];
                $response_message = $params['response_message'];
                $status = $params['status'];
                if (substr($response_code, 2) != '000') {
                    $success = false;
                    $reason = $response_message;

                }
            }
        }
        if (!$success) {
            $p = $params;
            $p['error_msg'] = $reason;
          return $p;
        } else {
         return  "success";
        }

    }


}
