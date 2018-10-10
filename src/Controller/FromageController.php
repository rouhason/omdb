<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FromageController extends AbstractController
{
    // Route

    /**
     * @Route("/query", name="query")
     */
    public function index()
    {

    // Cle api

        $apiKey = '37c1231f';
        $query = "running";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?s='. $query . '&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $resultat_curl = curl_exec($ch);
        $json = json_decode ($resultat_curl);

   // Rendu

        return $this->render('fromage/index.html.twig' , [
                'query' => $query,
                'movies' => $json->Search
        ]);
    }
}
