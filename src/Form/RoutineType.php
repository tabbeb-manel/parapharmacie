<?php

namespace App\Form;

use App\Entity\Routine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoutineType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameRoutine', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ["attr"=>["class"=>"form-control"]])
            ->add('notification',ChoiceType::class,[
                'choices'  => [
                    'Activée' => '1',
                    'Désactivée' => '0',
                ],"attr"=>["class"=>"form-control"]])

            ->add('Enregistrer', SubmitType::class, ['label'=>'Creer Routine','attr'=>['class'=>'btn']])

            ->getForm();

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Routine::class,
        ]);
    }
}
