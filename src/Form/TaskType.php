<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('description')
            ->add('deadline', DateTimeType::Class, array(
                'widget' => 'choice', 
                'date_format' => 'dd-MMMM-yyyy',
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
            'data_class' => Task::class,
        ]);
    }
}
