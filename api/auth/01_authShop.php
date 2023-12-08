<?php 
    function authShop($partnerId, $partnerKey) {   
        global $host;
        $path = "/api/v2/shop/auth_partner";
        $redirectUrl = "https://open.shopee.com/";
    
        $timest = time();
        $baseString = sprintf("%s%s%s", $partnerId, $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $partnerKey);
        $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&redirect=%s", $host, $path, $partnerId, $timest, $sign, $redirectUrl);
        return $url;
    }

    $host       = "https://partner.shopeemobile.com";
    $partnerId  = (int) $_POST['partner_id'];
    $partnerKey = $_POST['partner_key'];

    echo authShop($partnerId, $partnerKey);