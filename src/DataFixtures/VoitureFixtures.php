<?php

namespace App\DataFixtures;

use App\Entity\Voiture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class VoitureFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i=1 ; $i<=15;$i++)
        {
            $voiture = new Voiture;
            $voiture->setMarque("Marque n°$i")
                    ->setModele("Modele $i")
                    ->setPrix("$i*10000")
                    ->setDescription("Superbe description du modèle$i");
            $manager->persist($voiture);
        }

        $manager->flush();
    }
}
