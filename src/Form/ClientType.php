<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('cliNom', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ]
            ])

            ->add('cliPrenom', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ]
            ])

            ->add('cliNaissance', DateType::class, [
                'widget' => 'single_text',
            ])

            ->add('cliTel', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 10,
                        "minMessage" => "trop petit",
                        'max' => 15,
                        "maxMessage" => "trop long",
                    ]),
                ]
            ])

            ->add('cliFax', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 10,
                        "minMessage" => "trop petit",
                        'max' => 15,
                        "maxMessage" => "trop long",
                    ]),
                ]
            ])

            ->add('cliSexe', ChoiceType::class, [
                'choices'  => [
                    'Femme' => true,
                    'Homme' => false,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
