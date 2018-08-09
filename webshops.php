<?php

//
//Returns array with all webshop data
//The address information is mainly used for creating a DPD LABEL
//
function getAllShops(){
    $rows = get_field("webshops_repeater1" , "option");
    $shops = array();
    if($rows)
    {
        foreach($rows as $row)
        {
            array_push($shops , [
                "shop_name" => $row["shop_name"],
                "sender_street"=> $row["shop_street"],
                "sender_houseNo"=> $row["shop_houseno"],
                "sender_country"=> $row["shop_country"],
                "sender_zipCode"=> $row["shop_zip"],
                "sender_city"=> $row["shop_city"],
                "get_url" => $row["shop_get_url"],
                "unique_key" => "",
                "idPrefix" => $row["shop_id_prefix"],
            ]);
        }
    }
    return $shops;
}

//
//Return a single shop object from all the saved shops given the url of the shop
//
function getShopByGetUrl($url){
    $allShops = getAllShops();
    $i = 0;
    foreach ($allShops as $singleShop){
        if ($singleShop["get_url"] === $url){
            return $allShops[$i];
        }
        $i++;
    }
    return "NO MATCH";
}


//
//Returns an array to recieve an auth key from the DPD deli services given the login credentials from samti's DPD account
//
function getDPDinfo(){
    return array(
        "delisId" => "webniq516",
        "customerUid" => "webniq516",
        "authToken" => "MH4O2O56QXyMPM4XFyTTVIIBHALEcR6G5KUPcB3NzyHIGJDcMzy4TIKyATIJ2z32cG5IMN4NMKDWQX6G64LAGVzczOHXGHVJRNP4RJUMIGWUAJRPc27MBJzGR4XJBLOL",
        "depot" => "0516",
    );
}

