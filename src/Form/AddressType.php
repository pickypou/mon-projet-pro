<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>'Quel nom souheter vous donner a votre adresse',
                'attr'=>[
                    'placeholder'=>'Donner un nom a votre adresse'
                ]
            ])
            ->add('firstname', TextType::class,[
                'label'=>'Votre prénom',
                
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre prénom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label'=>'Votre nom',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre nom'
                ]
            ])
            ->add('company', TextType::class,[
                'label'=>' votre société',
                'attr'=>[
                    'placeholder'=>'(Falcutatif)Merci de saisir le nom de votre société'
                ]
            ])
            ->add('address', TextType::class,[
                'label'=>'Votre adresse',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre adresse'
                ]
            ])
            ->add('postal', TextType::class,[
                'label'=>'Code postal',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre code postal'
                ]
            ])
            ->add('city', TextType::class,[
                'label'=>'Votre ville',
                'attr'=>[
                    'placeholder'=>'Merci de saisir le nom de votre ville'
                ]
            ])
            ->add('country', CountryType::class,[
                'label'=>'Votre pays',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre ville'
                ]
            ])
            ->add('phone', TelType::class,[
                'label'=>'Votre numéro de téléphone',
                'attr'=>[
                    'placeholder'=>'Merci de saisir votre numéro de téléphone'
                ]
            ])
            ->add('user')
            ->add('submit', SubmitType::class,[
                'label'=>"Valider",
                'attr'=>[
                    'class'=>'btn-block btn-info'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
