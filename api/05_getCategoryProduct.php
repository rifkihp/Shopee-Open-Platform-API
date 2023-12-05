<?php
    function getItemListShopLevel($partnerId, $partnerKey, $accessToken, $shopId) {
        global $host;
        $path = "/api/v2/product/get_category";
        
        $timest = time();
        $baseString = sprintf("%s%s%s%s%s", $partnerId, $path, $timest, $accessToken, $shopId);
        $sign = hash_hmac('sha256', $baseString, $partnerKey);

        $url = sprintf(
            "%s%s?access_token=%s&language=id&partner_id=%s&shop_id=%s&sign=%s&timestamp=%s", 
            $host, $path, $accessToken, $partnerId, $shopId, $sign, $timest
        
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    $host        = "https://partner.shopeemobile.com";
    $partnerId   = (int) $_POST['partner_id'];
    $partnerKey  = $_POST['partner_key'];
    $accessToken = $_POST['shopAccessToken'];
    $shopId      = (int) $_POST['shopId'];

    echo getItemListShopLevel($partnerId, $partnerKey, $accessToken, $shopId);