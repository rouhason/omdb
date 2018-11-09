<?php

namespace App\Controller;

use App\Entity\Vote;
use Symfony\Component\HttpFoundation\Request;
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
        if( isset($json->Search) )
        {
            // Rendu si données
            return $this->render('fromage/films.html.twig' , [
                'query' => $query,
                'movies' => $json->Search
            ]);
        }
        else {
            //Rendu PBM
            return $this->render('fromage/errors.html.twig' , [
                'query' => $query,
            ]);
        }

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

        if (isset($json->Search)) {

            // Rendu
            return $this->render('fromage/film-param.html.twig' , [
                'query' => $query,
                'movies' => $json->Search
            ]);

        }  else {
                // Rendu
                return $this->render('fromage/errors.html.twig' , [
                    'query' => $query,
                    'prout' => 'très drôle',
                ]);

        }

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


        //Récupération de la moyenne des notes
        $moyenne = $this->getDoctrine()
            ->getRepository(Vote::class)
            ->findAverage($id);

   // Rendu
        return $this->render('fromage/the-film.html.twig' , [
                'id' => $id,
                'movie' => $json,
            'moyenne' => $moyenne
        ]);
    }

    // Route Recherche
    /**
     * @Route("/recherche", name="recherche")
     */
    public function Query (Request $request)
    {
//   analyser le contenu de l'objet request'
        $result = $request->query -> get('nom-film');
        dump($result);

        // Redirection vers l'action du contrôleur qui va afficher la liste des films avec ce paramètre (ma recherche)
            return $this->redirectToRoute('film_param' , [
            'query' => $request->query -> get('nom-film')
        ]);
    }


    // Route Send Mail
    /**
     * @Route("/mail", name="send-mail")
     */

//    public function EmailSend (Request $request)
//    {
////        on utilise les injections de dépendances avec request-swift_mail  (et var)
//
////   analyser le contenu de l'objet request' : soit un par un au niveau des input (name = 'key')
/////        $result = $request->query -> get('email-dest');
//
////        soit avec une récupération globale des données du form via request->all()
//        $result = $request->request -> all();
//        dump($result);
////        dump($result['imdbID']);
////        die;
//
//
//        //Recupérer les données du film (sinon ça marchera pas ><)
//        $api = '37c1231f';
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?i='. $result['imdbID'] . '&apikey='. $api);
//        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
//
//        $resultat_curl = curl_exec($ch);
//        $json = json_decode ($resultat_curl);
//
//        // Redirection vers l'action du contrôleur qui va afficher la liste des films avec ce paramètre (ma recherche)
//
////            Gabarit dans une vue sur le site
//        return $this->render('mail/send-mail.html.twig',[
//            'movie'=>$json,
//            'nom' => $result['nom-dest'],
//            'email' =>$result['email-dest'],
//            'sujet' =>$result['sujet-dest'],
//            'description'=> $result['description-dest'],
//        ]);
//    }

    // Route Send Mail
    /**
     * @Route("/mail", name="send-mail")
     */
    public function EmailSend (Request $request, \Swift_Mailer $mailer)
    {
//        on utilise les injections de dépendances avec request-swift_mail  (et var)
//        soit avec une récupération globale des données du form via request->all()
        $result = $request->request -> all();
        dump($result);

    //Recupérer les données du film (sinon ça marchera pas ><)
        $api = '37c1231f';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?i='. $result['imdbID'] . '&apikey='. $api);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $resultat_curl = curl_exec($ch);
        $json = json_decode ($resultat_curl);


//        Gabarit EMAIL : on utilise une valeur de stockage à la place de output
        $output=  $this->render('mail/mail-template.html.twig',[
            'movie'=>$json,
            'nom' => $result['nom-dest'],
            'email' =>$result['email-dest'],
            'sujet' =>$result['sujet-dest'],
            'description'=> $result['description-dest'],
        ]);

//        Création d'un objet swift message
        $message = (new \Swift_Message('Un utilisateur veut vous partager un film:'))
            ->setFrom('mamen@bangbros.fr')
            ->setTo($result['email-dest']) //adresse mail du request
            ->setBody(
                $output,'text/html'
            );

//        Appel du facteur d'email, objet qui va transmettre les data
        $mailer->send( $message );

        //Réponse de traitement (controller = réponse obligatoire)
        $this->addFlash(
            'success',
            'message envoyé !'
        );

        return $this->redirectToRoute('the-film' , [
            'id' => $result['imdbID']
        ]);

    }

    //Route Vote
    /**
     * @Route("/nouveauvote/{imdbID}/{note}", name="nouveau-vote")
     */

    public function VoteFilm ($imdbID, $note)
    {
//        dd($imdbID, $note);
        // vaut dump and die

// class entité qui représente une table, en POO : on fait new object
        $vote = new Vote();
        //function créer dans la class VOTE dans Vote.php

//        j'affecte l'id IMDB à partir du param
   $vote->setImdbID($imdbID);

//   j'affecte la note à partir du param
   $vote->setNote($note);

// on check les données
//   dd($vote);

//  Appel au gestionnaire d'entités fournis par Doctrine
$entityManager = $this ->getDoctrine()->getManager();

//on demande au gestionnaire d'entités de persister : génération de requete SQL (prépa)
        $entityManager -> persist($vote);

        //on demande au gestionnaire d'entités d'executer les requetes en attente (flush = tirer la chasse)
        $entityManager -> flush();


        //Message de confirmation d'envois de données
        $this->addFlash(
            'success',
            'votre note a été pris en compte'
        );

        //Renvoi des données et affichage de la vue
        return $this->redirectToRoute('the-film' , [
            'id' => $imdbID
        ]);



        //Recupérer les données du film (sinon ça marchera pas ><)
//        $api = '37c1231f';
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?i='. $imdbID . '&apikey='. $api);
//        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
//
//        $resultat_curl = curl_exec($ch);
//        $json = json_decode ($resultat_curl);




    }


    // Route Nouveau Vote
    /**
     * @Route("/votefilm", name="vote-film")
     */

    public function NewVoteFilm (Request $request)
    {
        $note = $request->request -> get('note-film');
        $imdbID = $request -> request -> get('imdbID');
        $nomFilm = $request -> request -> get('nom-film');

//        Récupération globale
//        $result = $request->request -> all();

        $vote = new Vote();

        $vote->setNote($note);
        //  traitement de note sur all()
//    $vote->setNote($result['note-film']);

        $vote ->setImdbID($imdbID);
        // traitement de ID sur all()
//    $vote ->setImdbID($result['imdbID']);

        $vote ->setNomFilm($nomFilm);
        // traitement de nomsur all()
//    $vote ->setImdbID($result['nom-film]);


        $entityManager = $this ->getDoctrine()->getManager();

//            Prépa requete
        $entityManager ->persist($vote);
//        Valider requete et flush
        $entityManager ->flush();


//        Renvoi des données et affichage de la vue
        return $this->redirectToRoute('the-film' , [
            'id' => $imdbID,
//                'id' => $result['imdbID'],
            'note' => $note,
//                'note' => $result['note-film'],
            'nomFilm' => $nomFilm,
//                'nomFilm' => $result['nom-film'],
        ]);



    }

}
