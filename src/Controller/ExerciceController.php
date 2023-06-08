<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExerciceController extends AbstractController
{
    #[Route('/exercice', name: 'exercice')]
    public function index(VoitureRepository $repo): Response
    {
        $voiture = $repo->findAll();
        return $this->render('exercice/index.html.twig', [
            'voitures' => $voiture,
        ]);
    }

    /****
     * *#####Pour afficher #####
     * *Ajouter le repository et importer la classe
     *  public function index(VoitureRepository $repo): Response
     * *appelle la methode findAll
     * $voiture = $repo->findAll();
     * return $this->render('exercice/index.html.twig', [
            'voitures' => $voiture,
        ]);
        **Donner une variable qui je dois utiliser dans la page de vue(ici on utilise "voitures")
     */

    #[Route('/exercice/add', name:'add_voiture')]
    #[Route('/exercice/update/{id}', name:'exercice_update')]
    public function form(Request $globals, EntityManagerInterface $manager, Voiture $voiture=null)
    {
        if($voiture == null)
        {
            $voiture = new Voiture;
        }

        $formVoiture = $this->createForm(VoitureType::class, $voiture);
        $formVoiture->handleRequest($globals);

        if($formVoiture->isSubmitted() && $formVoiture->isValid())
        {
            $manager->persist($voiture);
            $manager->flush();
            return $this->redirectToRoute('exercice');
        }
        

        return $this->renderForm('exercice/form.html.twig',[
            "formVoiture" => $formVoiture,
            "editMode" => $voiture->getId() !==null
            
        ]);
    }

    /****#######################################
 * ! Modifier
 * *Nouvelle route pour <<modifier>> même si c'est dans la même page, n'oublie pas le paramètre en GET dans l'url
 * *!On requit un bundle pour utiliser la variable à place $id 
 #[Route('/exercice/update/{id}', name:'exercice_update')]
 public function form(Request $globals, EntityManagerInterface $manager, Voiture $voiture=null)
 **si voiture n'est pas null
 if($voiture ==null)
        {
            $voiture = new Voiture;
        }

**un boolean dans le render
 return $this->renderForm('exercice/form.html.twig',[
            "formVoiture" => $formVoiture,
            "editMode" => $voiture->getId() !==null
            
        ]);
 */

    #[Route('/exercice/delete/{id}', name :"exercice_delete")]
    public function delete(Voiture $voiture, EntityManagerInterface $manager)
    {
        $manager->remove($voiture);
        $manager->flush();
        return $this->redirectToRoute('exercice');
    }

    
}





//##########################################################################################

/**
 * *Créer une variable pour stocker une methode afin de créer le tableau : $form = $this->createForm(xxxType::class)
 *  $formVoiture = $this->createForm(VoitureType::class);
        

        return $this->renderForm('exercice/form.html.twig',[
            "formVoiture" => $formVoiture
        ]);

    **Ajouter le Request $globals et Entitymanager $manager
     public function form(Request $globals, EntityManagerInterface $manager)

    **stocker entity(une table) dans une variable en créant un objet Voiture
        
        $voiture = new Voiture;
    
    **Istancier le builder -> Importer la classe(clique droit) -> proceder à handleRequest

        $formVoiture = $this->createForm(VoitureType::class, $voiture);
        $formVoiture->handleRequest($globals);
        

        return $this->renderForm('exercice/form.html.twig',[
            "formVoiture" => $formVoiture

    **Verifier si c'est valid
    if($formVoiture->isSubmitted() && $formVoiture->isValid())
        {
            $manager->persist($voiture);
            $manager->flush();
            return $this->redirectToRoute('la page que je voudrais envoyer');


        }
 */