<?php

namespace Drupal\imd_module;

/** 
 * An Api service provided From https://rapidapi.com/apidojo/api/imdb8/endpoints
 * this a custom service
*/
class ImdService{
    
    public function __construct()
    {
        $this->rapiapiKey = '054cba950bmsh769823410c75f63p1f9e99jsndaa867912879';
        $this->hostName = 'https://imdb8.p.rapidapi.com';
    }

    public function getActorData ($q = 'moderm family') {
        $client = \Drupal::httpClient();
        $url = $this->hostName.'/title/auto-complete?q='.$q;
        $request = $client->get($url, [
            'headers' => [
                'x-rapidapi-host' => 'imdb8.p.rapidapi.com',
                'x-rapidapi-key' => $this->rapiapiKey
            ]
        ]);

        $response = json_decode($request->getBody());

        return $response;
    }
}