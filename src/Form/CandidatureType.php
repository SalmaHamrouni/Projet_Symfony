<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Candidature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CandidatureType extends AbstractType
{
    /**
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
{
            $builder
                
                ->add('valider')
                 ;
                
        }
    
    /**
     * @param OptionsResolver $resolver
     */
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Candidature',
            'validation_groups' => ['create'],
            'role' => ['ROLE_USER']
        ));
    }
}
