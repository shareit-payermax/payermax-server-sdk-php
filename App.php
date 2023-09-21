<?php

require 'vendor/autoload.php';

use payermax\sdk\client\PayermaxClient;
use payermax\sdk\config\MerchantConfig;
try {

    //构造参数
    $merchantConfig = new MerchantConfig();
    $merchantConfig->merchantNo = "your merchant no ";
    $merchantConfig->appId = "your appId";
    $merchantConfig->merchantPrivateKey = "your private key";
    $merchantConfig->payermaxPublicKey = "payermax public key";
    //ISV商户所需参数 非ISV商户不用传递如下两个字段
//     $merchantConfig->spMerchantNo = "xxx";
//     $merchantConfig->merchantAuthToken = "xxx";

    //设置参数
    PayermaxClient::setConfig($merchantConfig, \payermax\sdk\constants\Env::$uat);

    //构造业务报文
    $requestData = '{"outTradeNo": "xxx","subject": "hello","totalAmount": "0.99","currency": "USD","country": "HK","userId": "100000002","goodsDetails": [{"goodsId": "com.corps.gp.60","goodsName": "60鑽石","quantity": "1","price": "0.99","goodsCurrency": "USD","showUrl": "httpw://www.okgame.com"}],"language": "en","reference": "300011","frontCallbackUrl": "https://payapi.okgame.com/v2/PayerMax/result.html","notifyUrl": "https://payapi.okgame.com/v2/PayerMax/Callback.ashx"}';
    $json_decodeData = json_decode($requestData, true);

    //请求并获取业务返回
    $resp = PayermaxClient::send('orderAndPay', $json_decodeData);
    echo json_encode($resp)  . "\n";

    PayermaxClient::verify("payermax request body", "payermax request sign");
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}






