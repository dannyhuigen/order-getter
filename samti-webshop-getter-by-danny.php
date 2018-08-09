<?php
/*
Plugin Name: Samti Webshop Getter
Description: Samti Webshop Getter
Author: Danny Huigen
*/


include_once "webshops.php";
foreach (glob("classes/*.php") as $filename)
{
    include $filename;
}


//
//Function to retrieve parameters from urls
//Wordpress doesent use url extensions (.php) so I cant use the build in parameter function from php
//This function is a replacement
//
function getUrlParameterValue($parameter){
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $link_pieces = explode("?",$actual_link);
    foreach ($link_pieces as $single_link_piece){
        if (strpos($single_link_piece, $parameter) !== false) {
            $requested_value = explode("=",$single_link_piece)[1];
            return str_replace("%20" , " " , $requested_value);
        }
    }

    return "NO PARAMETER";
}

//
//Returns a shop object with all the customer information
//
function returnAllOrders(){
    $allShops = getAllShops();
    $shopsWithOrders = array();

    foreach ($allShops as $singleshop){
        $shop_url = $singleshop["get_url"];
        $json = file_get_contents($shop_url);
        $orders = json_decode($json);

        $shopWithOrders = array(
            [
                "shop_name" => $singleshop["shop_name"],
                "sender_street"=>$singleshop["sender_street"],
                "sender_houseNo"=>$singleshop["sender_houseNo"],
                "sender_country"=>$singleshop["sender_country"],
                "sender_zipCode"=>$singleshop["sender_zipCode"],
                "sender_city"=>$singleshop["sender_city"],
                "get_url" => $singleshop["get_url"],

                "orders" => $orders
            ]
        );
        array_push($shopsWithOrders , $shopWithOrders);
    }

    return($shopsWithOrders);
}

//
//Returns a single shop with all items in order
//Mainly used for the single order page
//
function returnSingleShop($url){
    $singleShop = getShopByGetUrl($url);
    $shopsWithOrders = array();
    $shop_url = $singleShop["get_url"] . "?status=wc-pending///wc-processing///wc-on-hold///wc-completed";
    $json = dec_enc("decrypt" , file_get_contents($shop_url));
    $orders = json_decode($json);

    $shopWithOrders = array(
        [
            "shop_name" => $singleShop["shop_name"],
            "sender_street"=>$singleShop["sender_street"],
            "sender_houseNo"=>$singleShop["sender_houseNo"],
            "sender_country"=>$singleShop["sender_country"],
            "sender_zipCode"=>$singleShop["sender_zipCode"],
            "sender_city"=>$singleShop["sender_city"],
            "get_url" => $singleShop["get_url"],

            "orders" => $orders
        ]
    );
    array_push($shopsWithOrders , $shopWithOrders);

    return($shopsWithOrders);
}







