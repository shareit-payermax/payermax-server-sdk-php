<?php
namespace payermax\sdk\domain;

class GatewayReq
{
    /**
     * 格式为 yyyy-MM-dd'T'HH:mm:ss.SSSZ,  符合ISO 8601 规范，paymax会校验此时间和服务器的时间差不超过两分钟
     */
    public $requestTime;
    public $version = "1.2";
    public $appId;
    public $merchantNo;
    public $spMerchantNo;
    public $keyVersion = "1";
    public $data;


}
