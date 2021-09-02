<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CarteCreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero_carte', NumberType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 16,
                        'max' =>16,
                        'minMessage' => "Doit être un nombre à 16 chiffres",
                        'maxMessage' => "Doit être un nombre à 16 chiffres"
                    ])
                ]
            ])
            ->add('cryptogramme', NumberType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' =>3,
                        'minMessage' => "Doit être un nombre à 3 chiffres",
                        'maxMessage' => "Doit être un nombre à 3 chiffres"
                    ])
                ]
            ])
            ->add('detenteur', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au plus 255 caractères"
                    ])
                ]
            ])
            ->add('expiration', DateType::class, [
                'widget' => 'choice',
                'required' => true,
                'html5' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
