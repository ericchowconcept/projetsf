<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * *Une méthode lié à une route DOIT retourner un objet de la classe Response.
 * *Plusieurs méthodes de la classe AbstractController retourn un objet Response
 * *(render, json..........)
 */


  /**
         * *La méthode render va générer l'affichage qui va être envoyé au client
         * *le 1er argument  (obligatoire) est le nom du fichier utilisé pour générer l'affichage.
         * * Quand on utilise TWIG, le nom du fichier est toujours donné à partir du dossier 'templates'
         * 
         * *le 2ème argument (optionel) est de type array. il contient les variables que l'on veut passer à la vue
         */
class TestController extends AbstractController
{
    // *on met en paramètre notre repository de l'entité article qu'on stock dans la variable $repo (Article $repo)
    #[Route('/test', name: 'test')]
    public function index(ArticleRepository $repo): Response
    {
    //    *on stock dans la variable $articles le tableau de données récupéré grace à la méthode findAll de l'objet $repo
         $article =$repo->findAll();
        return $this->render('test/index.html.twig', [
            'articles' => $article,
        ]);
    }

    #[Route('/', name:'home')]
    public function home() :Response
    {
     
      return $this->render('test/home.html.twig', ['age' => 35]);
    }

    #[Route('/test/show/{id}', name:'test_show')]
    public function show($id, ArticleRepository $repo)
    {
        $article = $repo->find($id);
        return $this->render('test/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('test/new', name:'test_new')]
    public function form(Request $globals, EntityManagerInterface $manager)
    {
        // *je crée un objet Article vide prêt être rempli
        $article= new Article;
        $form = $this->createForm(ArticleType::class, $article);//*je lie le formulaire à mon objet $article
        // *createForm() permet de récuperer le formulaire

        // dd($globals);

        $form->handleRequest($globals);
        // *handleRequest() permet d'inserer les données du formulaire dans l'objet $article

        if($form->isSubmitted() && $form->isValid())
        {
            $article->setCreatedAt(new \DateTimeImmutable); 
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute("test_show", [
                'id' => $article->getId()
            ]);
        }

        return $this->renderForm('test/form.html.twig',[
            'formArticle' => $form
        ]);
    }



    #[Route('/test/salut')]
    public function salut()
    {
      $prenom = "Eric";  
      return $this->render('test/salut.html.twig',[
        'prenom' => $prenom,
      ]);
    }

    // *EXERCICE:
/**
 * *Ajouter une nouvelle route le chemin "test/calcul qui affiche le résultat du calcul 5+12
 * 
 */

    #[Route('/test/calcul', name: 'app_calcul')]
    public function calcul()
    {
        // $result = 5 + 12;
        // return $this->render('test/calcul.html.twig',[
        //    'result' => $result
        // ]);

        $a = 5;
        $b = 12;
        return $this->render('test/calcul.html.twig',[
            'nb1' => $a,
            'nb2' => $b,
          ]);
    }

     /**
     * *On peu ajouter des paramètres dans le chemin d'une route. Il faut les placer entre {}
     * *Cela signifie que la partie de l'URL qui est entre {} sera remplacé par n'importe qu'elle chaine de caractères.
     ** Pour récupérer les paramètres de l'URLil faut les passer dans les arguments de la méthode

    **EXPRESSION irreguliers (REGEX)
    **[0-9] : le caractère doit être compris entre les caractères 0 et 9
    ** \d : le caractère doit être un chiffre (digit)
    ** + : le caractère précédent peut-être présent 1 ou plusieurs fois
    ** * : le caractère précédent peut-être  présent 0 ou plusieurs fois
    ** ? : le caracètre précédent peut-être 0 ou 1 fois     
     */

    #[Route('/test/calcul/{a}/{b}', name:'app_test_calcul', requirements:["a" => "[0-9)]+", "b" => "\d+"])]
    public function calculDynamique($a, $b)
    {
        return $this ->render('test/calcul.html.twig', [
            "nb1" => $a,
            "nb2" => $b,
        ]);
    }

    // *EXERCICE
    // * ajouter une route pour l'url "/test/salutation" suivi du prénom. La page affichera  "bonjour prenom" en remplacant prenom par le mot qui suit salutation dans l'url(donc il faut récupéerer le prénom à afficher dans l'url)

    #[Route('/test/salutation/{p?}', name:'app-prenom')]
    public function afficherPrenom($p)
    {
        if(!$p){
            $p = "par défaut";
        }
        return $this->render('test/salutation.html.twig', [
            "prenom" => $p
        ]);
    }

}


