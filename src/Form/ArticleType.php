<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // *l'objet builder permet de créer un formulaire 
        // *la méthode add() permet d'ajouter un champ au formulaire 
        $builder
            ->add('title')
            ->add('content', TextType::class, [
                'attr' => [
                    'placeholder' => "Contenue de l'article"
                ]
            ]) //*on modifie le champ content en tant que champ textuel simple
            ->add('image')
            // ->add('created_at')
            // *on commente ce champ car nous ne voulons pas l'utilisateur entre lui-même une date d'ajout. Cela sera fait automatiquement lors du traitement du formulaire avant l'insertion en BDD
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
