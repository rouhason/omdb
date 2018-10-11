<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class YoutubeApiController extends AbstractController
{
    /**
     * @Route("/youtube-api", name="youtube-api")
     */
    public function index()
    {
        return $this->render('youtube_api/index.html.twig', [
            'controller_name' => 'YoutubeApiController',
        ]);
    }


    public function getVideo(){

    	$apikey = 'AIzaSyApSn5hvwENlfDBSgkEAJnD_PLzaksoktk';
    	$query_search = ' 2hdp';


    	$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/'. $query . '&key='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $resultat_curl = curl_exec($ch);
        $json = json_decode ($resultat_curl);

        return $this->render('youtube_api/youtube-video.html.twig', [
            'controller_name' => 'YoutubeApiController',
        ]);

    }

    public function getWiki(){

    }
}
