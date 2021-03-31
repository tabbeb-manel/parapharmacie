<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class UpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('firstName',TextType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('lastName',TextType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('dateBirth',DateType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('adress',TextType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('PhoneNumber',NumberType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('skinType', ChoiceType::class, [
                'choices'  => [
                    'Seche' => 'Seche',
                    'Mixte' => 'Mixte',
                    'Grasse' => 'Grasse',
                    'Normal' => 'Normal',
                ],"attr"=>["class"=>"form-control"
                ]])

            ->add('email',EmailType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('password',PasswordType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('password',PasswordType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('confirm_password',PasswordType::class,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('submit', SubmitType::class, ['label'=>'Update', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
