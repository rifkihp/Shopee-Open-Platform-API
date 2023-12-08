<?php 
    function getTokenShopLevel($code, $partnerId, $partnerKey, $shopId) {
        global $host;
        $path = "/api/v2/auth/token/get";
        
        $timest = time();
        $body = array("code" => $code,  "shop_id" => $shopId, "partner_id" => $partnerId);
        $baseString = sprintf("%s%s%s", $partnerId, $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $partnerKey);
        $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $partnerId, $timest, $sign);
        
    
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $resp = curl_exec($c);
        echo "raw result: $resp";
    
        $ret = json_decode($resp, true);
        $accessToken = $ret["access_token"];
        $newRefreshToken = $ret["refresh_token"];
        echo "\naccess_token: $accessToken, refresh_token: $newRefreshToken raw: $ret"."\n";
        return $ret;
    }

    $host       = "https://partner.shopeemobile.com";
    $partnerId  = (int) $_POST['partner_id'];
    $partnerKey = $_POST['partner_key'];
    $code       = $_POST['code'];
    $shopId     = (int) $_POST['shopId'];
    
    getTokenShopLevel($code, $partnerId, $partnerKey, $shopId);