<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Contenu')
            ->add('Categorie', EntityType::class, [
                'class' => Categorie::class,
                'placeholder' => 'Choisir une catégorie',
                'choice_label' => function (Categorie $categorie){
                    return $categorie->getTitre();
                }

            ])
        
    
            ->add('Date_C')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
