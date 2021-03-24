<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class ,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('description', TextareaType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('image', FileType::class,[
                "attr"=>["class"=>"form-control"]])
            ->add('createdAt', DateType::class, ['data' => new \DateTime("now"),
                "attr"=>["class"=>"form-control","readonly"=>"", "value"=>"01-01-2014", "size"=>"16"]
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
