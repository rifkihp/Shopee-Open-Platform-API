<?php
    function getItemBaseInfo($partnerId, $partnerKey, $accessToken, $shopId, $itemIdList) {
        global $host;
        $path = "/api/v2/product/get_item_base_info";
        
        $timest = time();
        $baseString = sprintf("%s%s%s%s%s", $partnerId, $path, $timest, $accessToken, $shopId);
        $sign = hash_hmac('sha256', $baseString, $partnerKey);

        $url = sprintf(
            "%s%s?access_token=%s&item_id_list=%s&need_complaint_policy=true&need_tax_info=true&partner_id=%s&shop_id=%s&sign=%s&timestamp=%s&update_time_from=946684800&update_time_to=1701734400", 
            $host, $path, $accessToken, $itemIdList, $partnerId, $shopId, $sign, $timest
        
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
    $itemIdList  = $_POST['itemIdList'];

    echo getItemBaseInfo($partnerId, $partnerKey, $accessToken, $shopId, $itemIdList);