# PayerMAX Server sdk

## Evn prepare
composer install
## Init Config

```php
    //构造参数
    $merchantConfig = new MerchantConfig();
    $merchantConfig->merchantNo = "your merchant no";
    $merchantConfig->appId = "your merchantAppId";
    $merchantConfig->merchantPrivateKey = "your private key";
    $merchantConfig->payermaxPublicKey = "payermax public key";
    //构造ISV商户所需参数
    $merchantConfig->spMerchantNo = "xxx";
    $merchantConfig->merchantAuthToken = "xxx";
    //设置参数
    PayermaxClient::setConfig($merchantConfig);
```


## Send request

```php
    //构造业务报文
    $requestData = '{"outTradeNo": "PAM20220109123456111617V3","subject": "hello","totalAmount": "0.99","currency": "USD","country": "HK","userId": "100000002","goodsDetails": [{"goodsId": "60","goodsName": "60鑽石","quantity": "1","price": "0.99","goodsCurrency": "USD","showUrl": "http://domaim.com"}],"language": "en","reference": "300011","frontCallbackUrl": "https://domai.url","notifyUrl": "https://domain.com"}';
    $json_decodeData = json_decode($requestData, true);
    //请求并获取业务返回
    $resp = PayermaxClient::send('orderAndPay', $json_decodeData);
    echo json_encode($resp)  . "\n";
```



## Verify Notification

```php
    PayermaxClient::verify("payermax request body", "payermax request sign");
```
