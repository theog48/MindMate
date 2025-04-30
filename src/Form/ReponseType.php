<?php
namespace App\Form;

use App\Entity\Cours;
use App\Entity\Quizz;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Quizz $quizz */
        $quizz = $options['data']; // L'entité Quizz liée au formulaire
        
        $builder
            ->add('userreponse1', ChoiceType::class, [
                'choices' => [
                    $quizz->getReponse11() => $quizz->getReponse11(),
                    $quizz->getReponse12() => $quizz->getReponse12(),
                    $quizz->getReponse13() => $quizz->getReponse13(),
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => $quizz->getQuestion1() ?: 'Question 1',
            ])
            ->add('reponseUser2', ChoiceType::class, [
                'choices' => [
                    $quizz->getReponse21() => $quizz->getReponse21() ,
                    $quizz->getReponse22() => $quizz->getReponse22() ,
                    $quizz->getReponse23() => $quizz->getReponse23() ,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => $quizz->getQuestion2() ?: 'Question 2',
            ])
            ->add('reponseUser3', ChoiceType::class, [
                'choices' => [
                    $quizz->getReponse31() => $quizz->getReponse31(),
                    $quizz->getReponse32() => $quizz->getReponse32(),
                    $quizz->getReponse33() => $quizz->getReponse33(),
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => $quizz->getQuestion3() ?: 'Question 3',
            ])
            ->add('reponseUser4', ChoiceType::class, [
                'choices' => [
                    $quizz->getReponse41() => $quizz->getReponse41(),
                    $quizz->getReponse42() => $quizz->getReponse42(),
                    $quizz->getReponse43() => $quizz->getReponse43(),
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => $quizz->getQuestion4() ?: 'Question 4',
            ])
            ->add('reponseUser5', ChoiceType::class, [
                'choices' => [
                    $quizz->getReponse51() => $quizz->getReponse51(),
                    $quizz->getReponse52() => $quizz->getReponse52(),
                    $quizz->getReponse53() => $quizz->getReponse53(),
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => $quizz->getQuestion5() ?: 'Question 5',
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