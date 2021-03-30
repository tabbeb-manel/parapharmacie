<?php

namespace App\Form;
use App\Entity\PageContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
class PagecontactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('email',EmailType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('subject',TextType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('message',TextareaType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('submit', SubmitType::class, ['label'=>'Send message', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pagecontact::class,
        ]);
    }
}
