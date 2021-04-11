<?php
namespace App\Helpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PasarelaNiubiz{

    protected $Merchant = "";
    protected $AccessKey = "";
    protected $SecretAccessKey = "";

    protected $merchantidtest_en = "";
    protected $usrtest= "";
    protected $pwdtest= "";


    protected $securityapitest = "";
    protected $sessionapitest = "";
    protected $autorizationapitest = "";
    protected $urltest = "";

    protected $merchantidprd_es = "";
    protected $usr= "";
    protected $pwd= "";

    protected $securityapiprd = "";
    protected $sessionapiprd = "";
    protected $autorizationapiprd = "";
    protected $urlprd = "";
    // protected $MerchantPRD = "";
    // protected $AccessKeyPRD = "";
    // protected $SecretAccessKeyPRD = "";

    protected $url = "";
    public function __construct() {

        // Configuraciones para el testeo
        if(App::isLocale('en')){
            $this->merchantidtest="456879856";
            $this->usrtest="integraciones@niubiz.com.pe";
            $this->pwdtest='_7z3@8fF';
        }
        else{
            $this->merchantidtest="456879856";
            $this->usrtest="integraciones@niubiz.com.pe";
            $this->pwdtest='_7z3@8fF';
        }

        $this->securityapitest="https://apisandbox.vnforappstest.com/api.security/v1/security";
        $this->sessionapitest="https://apisandbox.vnforappstest.com/api.ecommerce/v2/ecommerce/token/session/";
        $this->autorizationapitest="https://apisandbox.vnforappstest.com/api.authorization/v3/authorization/ecommerce/";
        $this->urltest="https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true";

        // Configurciones para produccion
        if(App::isLocale('en')){
            $this->merchantidprd="";
            $this->usr="";
            $this->pwd='';
        }
        else{
            $this->merchantidprd="";
            $this->usr="";
            $this->pwd='';
        }
        $this->securityapiprd="https://apiprod.vnforapps.com/api.security/v1/security";
        $this->sessionapiprd="https://apiprod.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/";
        $this->autorizationapiprd="https://apiprod.vnforapps.com/api.authorization/v3/authorization/ecommerce/";
        $this->urlprd="https://static-content.vnforapps.com/v2/js/checkout.js";

        //$this->MerchantPRD="110402505";
        //$this->AccessKeyPRD="AKIAI3S45ADIBHPAB5NQ";
        //$this->SecretAccessKeyPRD="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";

        #$this->MerchantPRD="148131802";
        #$this->AccessKeyPRD="AKIAJRWJQBFYLRVB22ZQ";
        #$this->SecretAccessKeyPRD="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";

        // $this->MerchantPRD="341198210";
        // $this->AccessKeyPRD="AKIAI737YRU5WIQ5W6JQ";
        // $this->SecretAccessKeyPRD="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";
    }

    public function Merchant()
    {
        return $this->Merchant;

    }

    public function AccessKey()
    {
        return $this->AccessKey;

    }
    public function SecretAccessKey()
    {
        return $this->SecretAccessKey;

    }
    public function merchantidtest()
    {
        return $this->merchantidtest;
    }
    public function usrtest()
    {
        return $this->usrtest;
    }
    public function pwdtest()
    {
        return $this->pwdtest;
    }
    public function securityapitest()
    {
        return $this->securityapitest;
    }
    public function sessionapitest()
    {
        return $this->sessionapitest;
    }
    public function autorizationapitest()
    {
        return $this->autorizationapitest;
    }
    public function merchantidprd()
    {
        return $this->merchantidprd;
    }
    public function usr()
    {
        return $this->usr;
    }
    public function pwd()
    {
        return $this->pwd;
    }
    public function securityapiprd()
    {
        return $this->securityapiprd;
    }
    public function sessionapiprd()
    {
        return $this->sessionapiprd;
    }
    public function autorizationapiprd()
    {
        return $this->autorizationapiprd;
    }
    // public function MerchantPRD()
    // {
    //     return $this->MerchantPRD;
    // }
    // public function AccessKeyPRD()
    // {
    //     return $this->AccessKeyPRD;
    // }
    // public function SecretAccessKeyPRD()
    // {
    //     return $this->SecretAccessKeyPRD;
    // }
    public function url()
    {
        return $this->url;
    }

public  function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12).$hyphen
            .chr(125);// "}"
        $uuid = substr($uuid, 1, 36);
        return $uuid;
    }
}
public  function create_json_post($post){
            $request="{";
            for ($i=0; $i < count($post) ; $i++) {
                $llave = key($post);
                $valor = $post[$llave];
                if($i==count($post)-1){
                    $request = $request. "\"$llave\":\"$valor\"";
                }else{
                    $request = $request. "\"$llave\":\"$valor\",";
                }
                next($post);
            }
            $request = $request."}";
            return $request;
}

public  function contador(){
    $exists = Storage::disk('archivos')->exists('contador.txt');
    $contador = 0;
    if($exists){
        $archivo = Storage::disk('archivos')->path('contador.txt');
        $contents = File::get($archivo);
        $contador = (int)$contents;
        ++$contador;
        Storage::disk('archivos')->put('contador.txt', $contador);
    }
    return $contador;
}

public  function securitykey($environment){
    switch ($environment) {
        case 'prd':
            $merchantId = $this->merchantidprd;
            $url = $this->securityapiprd;
            $accessKey=$this->usr;
            $secretKey=$this->pwd;
            break;
        case 'dev':
            $merchantId = $this->merchantidtest;
            $url = $this->securityapitest;
            $accessKey=$this->usrtest;
            $secretKey=$this->pwdtest;
            break;
    }
    $header = array("Content-Type: application/json");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$accessKey:$secretKey");
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $key = curl_exec($ch);
    return $key;
}

public  function create_token($environment,$amount,$mdd4,$mdd21,$mdd32,$mdd75,$mdd77,$key){
    switch ($environment) {
        case 'prd':
            #$merchantId = merchantIdprd;
            $url = $this->sessionapiprd.$this->merchantidprd;
            $accessKey=$this->usr;
            $secretKey=$this->pwd;
            $merchantId=$this->merchantidprd;
            break;
        case 'dev':
            #$merchantId = merchantidtest;
            $url = $this->sessionapitest.$this->merchantidtest;
            $accessKey=$this->usrtest;
            $secretKey=$this->pwdtest;
            $merchantId=$this->merchantidtest;
            break;
    }
    $header=array("Content-Type: application/json",
            "merchantId: $merchantId","accessToken: $key",
            "Authorization: $key");
    // var_dump($header);
    $request_body="{
        \"amount\" : \"$amount\",
        \"channel\" : \"web\",
        \"antifraud\" : {
            \"clientIp\" : \"192.168.10.44\",
            \"merchantDefineData\" : {
                \"MDD4\" : \"$mdd4\",
                \"MDD21\" : \"$mdd21\",
                \"MDD32\" : \"$mdd32\",
                \"MDD75\" : \"$mdd75\",
                \"MDD77\" : \"$mdd77\"
            }
        }
    }";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    return $response;

}
public function urljs($environment){
    switch ($environment){
        case 'prd':
            $url = $this->urlprd;
            break;
        case 'dev':
            $url = $this->urltest;
            break;
    }
    return $url;
}

public  function authorization($environment,$key,$amount,$transactionToken,$purchaseNumber){
    switch ($environment) {
        case 'prd':
            #$merchantId = merchantIdprd;
            $this->url = $this->autorizationapiprd.$this->merchantidprd;
            $merchantId=$this->merchantidprd;
            break;
        case 'dev':
            #$merchantId = merchantidtest;
            $this->url = $this->autorizationapitest.$this->merchantidtest;
            $merchantId=$this->merchantidtest;
            break;
    }
    // $header = array("Content-Type: application/json","Authorization: $key");

    $header=array("Content-Type: application/json",
            "merchantId: $merchantId","accessToken: $key",
            "Authorization: $key");

    $request_body="{

        \"antifraud\" : null,
        \"captureType\" : \"manual\",
        \"channel\" : \"web\",
        \"countable\" : true,
        \"order\" : {
            \"amount\" : \"$amount\",
            \"tokenId\" : \"$transactionToken\",
            \"purchaseNumber\" : \"$purchaseNumber\",
            \"currency\" : \"PEN\"
        }
    }";

    $dds=$this->url ;
    // echo "<hr>";
    // echo $this->url;
    // echo "<br>";
    // echo $request_body;
    // echo "<hr>";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $dds);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    #curl_setopt($ch, CURLOPT_USERPWD, "$accessKey:$secretKey");
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    // return $response;
    // var_dump($response);
    // $json = json_decode($response);
    // $json = json_encode($json, JSON_PRETTY_PRINT);
    // $response = json_decode($response);
    // $response = json_encode($response);
    //$dato = $json->sessionKey;
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//    echo "<hr>status:".$status."<hr>";
    // $rpt_json=[];
    $rpt_json=array('0'=>$status,'1'=>$response);
    return json_encode($rpt_json);
    // ['0']=$status;
    // $rpt_json=['1']=$json;

    //  "{\"0\":\"$status\",\"1\":\"\"}";
    // $rpt = json_encode($rpt_json);
    // return $json;
    // return $rpt_json;
}

public  function post_form($array_post,$url_){
    $html="<html>
    <head>
    </head>
    <Body onload=\"f1.submit();\">
    <form name=\"f1\" method=\"post\" action=\"{$url_}\">";
    for ($i=0; $i < count($array_post) ; $i++) {
        $llave = key($array_post);
        $valor = $array_post[$llave];
        $html = $html."<input type=\"hidden\" name=\"$llave\" value=\"$valor\" />";
        next($array_post);
    }
    $html = $html."</form>
    </body>
    </html>";
    return $html;
}


}
