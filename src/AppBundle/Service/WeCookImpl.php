<?php

namespace AppBundle\Service;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:55
 */

class WeCookImpl
{
    public function callWecook()
    {

// $url will contain the API endpoint
        $url = "https://www.wecook.fr/web-api/recipes?id=4975";

// Make the POST request using Curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer qFS9q2cQ4h4ijNQVBRihvQ", "Wecook-Version: 1"));

// Decode and display the output
        $api_output = curl_exec($ch);
        $json_output = json_decode($api_output, true);
        $output = $json_output ? $json_output : $api_output;
// Clean up
        curl_close($ch);

// Get the decoded body
        return $output;
    }

}