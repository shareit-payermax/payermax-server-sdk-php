<?php
namespace payermax\sdk\utils;

class RSAUtils
{
    public static function sign($content, $privateKeyPem)
    {
        $priKey = $privateKeyPem;
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or die('私钥格式错误');

        openssl_sign($content, $sign, $res, OPENSSL_ALGO_SHA256);
        $sign = base64_encode($sign);
        return $sign;
    }

    public static function verify($content, $sign, $publicKeyPem)
    {
        $pubKey = $publicKeyPem;
        $res = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        ($res) or die('公钥格式错误');

        //调用openssl内置方法验签，返回bool值
        $result = FALSE;
        $result = (openssl_verify($content, base64_decode($sign), $res, OPENSSL_ALGO_SHA256) === 1);
        return $result;
    }

    public static function createKeyPair()
    {
        $config = array(
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $rsaKeys = openssl_pkey_new($config);
        openssl_pkey_export($rsaKeys, $privateKey);
        $publicKey = openssl_pkey_get_details($rsaKeys)["key"];

        $publicKey = str_replace(array("-----BEGIN PUBLIC KEY-----","-----END PUBLIC KEY-----","\n"),"",$publicKey);
        $privateKey = str_replace(array("-----BEGIN PRIVATE KEY-----","-----END PRIVATE KEY-----","\n"),"",$privateKey);

        return array( "publicKey"=>$publicKey, "privateKey"=>$privateKey);
    }
}
