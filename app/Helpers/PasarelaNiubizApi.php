<?php
namespace App\Helpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PasarelaNiubizApi{

    protected $VISA_MERCHANT_ID;
    protected $VISA_USER;
    protected $VISA_PWD;
    protected $VISA_URL_SECURITY;
    protected $VISA_URL_SESSION;
    protected $VISA_URL_JS;
    protected $VISA_URL_CSS;
    protected $VISA_URL_AUTHORIZATION;
    protected $VISA_URL_TOKENIZATION;
    public function __construct(){
        $this->VISA_MERCHANT_ID= env('VISA_DEVELOPMENT')?env('VISA_DEV_MERCHANT_ID'):env('VISA_PRD_MERCHANT_ID');
        $this->VISA_USER=env('VISA_DEVELOPMENT')?env('VISA_DEV_USER'):env('VISA_PRD_USER');
        $this->VISA_PWD=env('VISA_DEVELOPMENT')?env('VISA_DEV_PWD'):env('VISA_PRD_PWD');
        $this->VISA_URL_SECURITY=env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_SECURITY'):env('VISA_PRD_URL_SECURITY');
        $this->VISA_URL_SESSION=env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_SESSION'):env('VISA_PRD_URL_SESSION');
        $this->VISA_URL_JS=env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_JS'):env('VISA_PRD_URL_JS');
        $this->VISA_URL_CSS=env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_CSS'):env('VISA_PRD_URL_CSS');
        $this->VISA_URL_AUTHORIZATION=env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_AUTHORIZATION'):env('VISA_PRD_URL_AUTHORIZATION');
        $this->VISA_URL_TOKENIZATION=env('VISA_DEVELOPMENT')?env('VISA_DEV_URL_TOKENIZATION'):env('VISA_PRD_URL_TOKENIZATION');
    }
    function generateToken() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->VISA_URL_SECURITY,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            'Authorization: '.'Basic '.base64_encode($this->VISA_USER.":".$this->VISA_PWD)
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generateSesion($amount, $token, $channel, $mdd4, $mdd21, $mdd32, $mdd75, $mdd77) {
        $session = array(
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => array(
                    'MDD4' =>$mdd4, //'integraciones.visanet@necomplus.com',
                    'MDD21' =>$mdd21,// 'integraciones.visanet@necomplus.com',
                    'MDD32' =>$mdd32,// 'integraciones.visanet@necomplus.com',
                    'MDD75' =>$mdd75,// 'Registrado',
                    'MDD77' =>$mdd77// '63'
                ),
            ),
            'channel' => $channel,
        );
        $json = json_encode($session);
        $response = json_decode($this->postRequest($this->VISA_URL_SESSION, $json, $token));
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
        $session = json_decode($this->postRequest($this->VISA_URL_AUTHORIZATION, $json, $token));
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
            CURLOPT_URL => $this->VISA_URL_TOKENIZATION.$transactionToken,
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
    function visa_merchant_id(){
        if(env('VISA_DEVELOPMENT'))
        return env('VISA_DEV_MERCHANT_ID');
        else
        return env('VISA_PRD_MERCHANT_ID');
    }
}
