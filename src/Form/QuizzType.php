<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Quizz;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('question1')
            ->add('reponse11')
            ->add('reponse12')
            ->add('reponse13')
            ->add('bonnereponse1')
            ->add('userreponse1')
            ->add('question2')
            ->add('reponse21')
            ->add('reponse22')
            ->add('reponse23')
            ->add('bonneReponse2')
            ->add('reponseUser2')
            ->add('question3')
            ->add('reponse31')
            ->add('reponse32')
            ->add('reponse33')
            ->add('bonneReponse3')
            ->add('reponseUser3')
            ->add('question4')
            ->add('question41')
            ->add('question42')
            ->add('question43')
            ->add('bonneReponse4')
            ->add('reponseUser4')
            ->add('question5')
            ->add('question51')
            ->add('question52')
            ->add('question53')
            ->add('bonneReponse5')
            ->add('reponseUser5')
            ->add('score')
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}
