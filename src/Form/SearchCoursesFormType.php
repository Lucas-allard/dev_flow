<?php

namespace App\Form;

use App\Data\ChallengeFilterData;
use App\Entity\Category;
use App\Entity\Level;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCoursesFormType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un cours'
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'empty_data' => null,
                'required' => false,
            ])
            ->add('level', EntityType::class, [
                'label' => 'Level',
                'class' => Level::class,
                'choice_label' => 'name',
                'multiple' => false,
                'empty_data' => null,
                'required' => false,
            ])
            ->add('minPoint', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Gain de points min'
                ]
            ])
            ->add('maxPoint', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Gain de points max'
                ]
            ])
//            ->add('isRead', ChoiceType::class, [
//                'label' => 'Déjà vue',
//                'choices' => [
//                    'Oui' => true,
//                    'Non' => false
//                ],
//                'multiple' => false,
//                'required' => false,
//                'empty_data' => null
//            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher'
            ]);

    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChallengeFilterData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }

}
