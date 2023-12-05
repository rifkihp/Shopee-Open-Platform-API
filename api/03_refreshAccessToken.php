<?php 

    function getAccessTokenShopLevel($partnerId, $partnerKey, $shopId, $refreshToken) {
        global $host;
        $path = "/api/v2/auth/access_token/get";
        
        $timest = time();
        $body = array("partner_id" => $partnerId, "shop_id" => $shopId, "refresh_token" => $refreshToken);
        $baseString = sprintf("%s%s%s", $partnerId, $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $partnerKey);
        $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $partnerId, $timest, $sign);
    
    
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($c);
        echo "\nraw result ".$result."\n";
    
        $ret = json_decode($result, true);
    
        $accessToken = $ret["access_token"];
        $newRefreshToken = $ret["refresh_token"];
        echo "\naccess_token: ".$accessToken.", refresh_token: ".$newRefreshToken."\n";
        return $ret;
    }

    $host             = "https://partner.shopeemobile.com";
    $partnerId        = (int) $_POST['partner_id'];
    $partnerKey       = $_POST['partner_key'];
    $shopId           = (int) $_POST['shopId'];
    $shopRefreshToken = $_POST['shopRefreshToken']; 
    
    getAccessTokenShopLevel($partnerId, $partnerKey, $shopId, $shopRefreshToken);