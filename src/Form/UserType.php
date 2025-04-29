<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'Utilisateur' => 'ROLE_USER',
                'Administrateur' => 'ROLE_ADMIN',
                'Premium' => 'ROLE_PAID',
            ],
            'multiple' => true,
            'expanded' => true, // true = cases à cocher, false = menu déroulant multiple
            'label' => 'Rôles',
        ])
            ->add('email')
            ->add('password')
            ->add('nom')
            ->add('nbToken')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('hasTestPremium')
            ->add('dateFinPremium', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
