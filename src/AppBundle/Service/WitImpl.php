<?php

namespace AppBundle\Service;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:55
 */
use Tgallice\Wit\Client;
use Tgallice\Wit\MessageApi;

class WitImpl
{
    public function connect($language,$sentence){
        if(strtoupper($language )== 'FR'){
            $token = '43S6T5VI7QEPF36C6BPXOTRSY46JF66G';
        }else{
            $token = '5E2VLGDLHTVA6LKFKMOTHX3DY7UB2544';
        }
        $client = new Client($token);
        $response = $client->get('/message', [
            'q' => $sentence,
        ]);

// Get the decoded body
        return json_decode((string) $response->getBody(), true);
    }

}