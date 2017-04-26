<?php

namespace AppBundle\Service;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:55
 */

class GoogleImpl
{
    //A REVOIR
    public function getUser($token){
        $client = new \Google_Client();
        $client->setApplicationName('Nashi');
        $client->setClientId("240172526905-gio55omtvde9u2jhcn0d61au6p87kcs5.apps.googleusercontent.com");
        $client->setClientSecret("VVZBdgxrKWr1NPTRKLtq7jb4");
        $client->setDeveloperKey("AIzaSyAgd0Sm_goFnaJronym_PlyeuR461nKGuY");
        $client->setAccessToken($token);
        $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
        $plus = new \Google_Service_Oauth2($client);
        return $plus->userinfo->get();
        //$ticket = $client->verifyIdToken($token);
        //if ($ticket) {
        //    $data = $ticket->getAttributes();
        //    return $data['payload']['sub']; // user ID
        //}
        //return false;
    }

}