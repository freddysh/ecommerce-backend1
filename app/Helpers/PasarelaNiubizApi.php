<?php
namespace App\Helpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PasarelaNiubizApi{

    public function __construct(){
        env('VISA_MERCHANT_ID',env('VISA_DEVELOPMENT')?env('VISA_DEV_MERCHANT_ID'):env('VISA_PRD_MERCHANT_ID'));
        env('VISA_USER',env('VISA_DEVELOPMENT')?env('VISA_DEV_USER'):env('VISA_PRD_USER'));
        env('VISA_PWD',env('VISA_DEVELOPMENT')?env('VISA_DEV_PWD'):env('VISA_PRD_PWD'));
        env('VISA_URL_SECURITY',env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_SECURITY'):env('VISA_PRD_URL_SECURITY'));
        env('VISA_URL_SESSION',env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_SESSION'):env('VISA_PRD_URL_SESSION'));
        env('VISA_URL_JS',env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_JS'):env('VISA_PRD_URL_JS'));
        env('VISA_URL_CSS',env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_CSS'):env('VISA_PRD_URL_CSS'));
        env('VISA_URL_AUTHORIZATION',env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_AUTHORIZATION'):env('VISA_PRD_URL_AUTHORIZATION'));
        env('VISA_URL_TOKENIZATION',env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_TOKENIZATION'):env('VISA_PRD_URL_TOKENIZATION'));
    }
    function generateToken() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('VISA_URL_SECURITY'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            'Authorization: '.'Basic '.base64_encode(env('VISA_USER').":".env('VISA_PWD'))
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generateSesion($amount, $token, $channel) {
        $session = array(
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => array(
                    'MDD4' => 'integraciones.visanet@necomplus.com',
                    'MDD32' => 'integraciones.visanet@necomplus.com',
                    'MDD75' => 'Registrado',
                    'MDD77' => '63'
                ),
            ),
            'channel' => $channel,
        );
        $json = json_encode($session);
        $response = json_decode($this->postRequest(env('VISA_URL_SESSION'), $json, $token));
        return $response->sessionKey;
    }

    function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token) {
        $data = array(
            'antifraud' => null,
            'captureType' => 'manual',
            'channel' => env('VISA_CHANNEL'),
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => env('VISA_CURRENCY'),
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken
            ),
            'recurrence' => null,
            'sponsored' => null
        );
        $json = json_encode($data);
        $session = json_decode($this->postRequest(env('VISA_URL_AUTHORIZATION'), $json, $token));
        return $session;
    }

    protected function postRequest($url, $postData, $token) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => $postData
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generatePurchaseNumber(){
        return rand(1, 999999999999);
    }

    function generateTokenization($transactionToken, $token) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('VISA_URL_TOKENIZATION').$transactionToken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
