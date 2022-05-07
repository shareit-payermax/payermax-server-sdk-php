<?php

namespace payermax\sdk\client;

use http\Exception\RuntimeException;
use payermax\sdk\domain\GatewayReq;
use GuzzleHttp\Client;
use payermax\sdk\domain\GatewayResult;
use payermax\sdk\utils\RSAUtils;

class PayermaxClient
{

    private static $merchantConfig;

    private static $client;

//    private static $url = "https://pay-gate-uat.payermax.com/aggregate-pay/api/gateway";
    private static $domain = "http://pay-dev.shareitpay.in";


    public static function setConfig($config) {
        self::$merchantConfig = $config;
        self::init();
    }

    private static function init() {
        self::$client = new Client([
            'base_uri' => self::$domain,
            'timeout'  => 15.0
        ]);
    }


    public static function send($apiName, $data) {
        //构建参数
        $req = new GatewayReq();
        //ISO 8601 带毫秒的
        $dateTime = new \DateTime();
        $req->requestTime = $dateTime->format('Y-m-d\TH:i:s.vP');
        $req->merchantAppId = self::$merchantConfig->merchantAppId;
        $req->merchantNo = self::$merchantConfig->merchantNo;
        $req->data = $data;

        //转成json并签名
        $reqBody = json_encode($req);
        $sign = RSAUtils::sign($reqBody, self::$merchantConfig->merchantPrivateKey);
        //发送请求
        $requestPath = "/aggregate-pay/api/gateway/" . $apiName;
        $reqOptions = [
            'headers' => [
                'sign' => $sign,
                'content-type' => 'application/json',
                'sdk-ver' => 'php-1.0.0'
            ],
            'body' => $reqBody
        ];
        $response = self::$client->request('POST', $requestPath, $reqOptions);

        $respBody = (string)$response->getBody();

        $respJson = json_decode($respBody, true);

        //验签
        if(GatewayResult::success($respJson)
            && RSAUtils::verify($respBody, $response->getHeader('sign'), self::$merchantConfig->payermaxPublicKey)) {
            return $respBody;
        }

        throw new \RuntimeException($respBody);
    }


}