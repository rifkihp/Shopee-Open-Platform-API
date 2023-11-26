<?php
    function getItemListShopLevel($partnerId, $partnerKey, $accessToken, $shopId) {
        global $host;
        $path = "/api/v2/auth/access_token/get";
        
        $timest = time();
        
        $body = array("partner_id" => $partnerId, "shop_id" => $shopId, "refresh_token" => $refreshToken);
        
        $baseString = sprintf("%s%s%s%s%s", $partnerId, $path, $timest, $accessToken, $shopId);
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



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://partner.shopeemobile.com/api/v2/product/get_item_list?access_token=xxxxx&item_status=NORMAL&offset=0&page_size=10&partner_id=xxxxx&shop_id=13109863&sign=xxxxx&timestamp=1700148724&update_time_from=1611311600&update_time_to=1611311631',
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
echo $response;