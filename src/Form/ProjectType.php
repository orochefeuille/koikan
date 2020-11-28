<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        setlocale(LC_TIME, "fr_FR");
        $builder
            ->add('label')
            ->add('description')
            ->add('deadline', DateTimeType::Class, array(
                'widget' => 'choice', 
                // 'format' => 'dd-MMMM-yyyy',
                // 'html5' => false,
                'years' => range(date('Y'), date('Y')+100),
            ))
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'à démarrer' => 'todo',
                    'en cours' => 'in progress',
                    'terminé' => 'done',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
