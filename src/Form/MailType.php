<?php

namespace App\Form;


use App\Entity\PageContact;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('subject',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('message',TextareaType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('submit', SubmitType::class, ['label'=>'Send', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
}
}
