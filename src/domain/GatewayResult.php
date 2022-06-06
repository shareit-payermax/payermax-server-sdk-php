<?php
namespace payermax\sdk\domain;

/**
 * @author zhu.q
 */
class GatewayResult {
    public static function success($resp) {
        if(!empty($resp) && $resp['code'] == "APPLY_SUCCESS") {
            return true;
        }
        return false;
    }

}
