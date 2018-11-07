<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FromageController extends AbstractController
{

    // private $apiKey = getenv("OMDB_APIKEY");

    // Route MOVIE

    /**
     * @Route("/", name="default")
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

        return $this->render('fromage/film.html.twig' , [
                'query' => $query,
                'movies' => $json->Search
        ]);
    }


    // Route Movie Single
    /**
     * @Route("/films", name="films")
     */
    public function filmSingle()
    {

    // Cle api

        $apiKey = '37c1231f';
        $query = "wars";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?s='. $query . '&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $resultat_curl = curl_exec($ch);
        $json = json_decode ($resultat_curl);

   // Rendu

        return $this->render('fromage/films.html.twig' , [
                'query' => $query,
                'movies' => $json->Search
        ]);
    }


    // Route Movie + Param

    /**
     * @Route("/film_param/{query}", name="film_param")
     */
    public function filmParam($query)
    {

    // Cle api

        $apiKey = '37c1231f';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?s='. $query . '&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $resultat_curl = curl_exec($ch);
        $json = json_decode ($resultat_curl);

   // Rendu
        return $this->render('fromage/film-param.html.twig' , [
                'query' => $query,
                'movies' => $json->Search
        ]);
    }

    //Route Résultat Film

    /**
     * @Route("/the-film/{id}", name="the-film")
     */

public function theFilm($id)

    {
         $api = '37c1231f';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?i='. $id . '&apikey='. $api);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $resultat_curl = curl_exec($ch);
        $json = json_decode ($resultat_curl);

   // Rendu
        return $this->render('fromage/the-film.html.twig' , [
                'id' => $id,
                'movie' => $json
        ]);
    }

    // Route Recherche
    /**
     * @Route("/recherche", name="recherche")
     */
    public functionQuery (Request $request)
    {

        // Cle api
        $apiKey = '37c1231f';
        $query = "wars";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?s='. $query . '&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $resultat_curl = curl_exec($ch);
        $json = json_decode ($resultat_curl);

        // Rendu

        return $this->render('fromage/films.html.twig' , [
            'query' => $query,
            'movies' => $json->Search
        ]);
    }





}
