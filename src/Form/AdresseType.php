<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adrPays', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Pays :",

            ])
            ->add('adrVille', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Ville :",
            ])
            ->add('adrPostal', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 15,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Code postal :",
            ])
            ->add('adrAdresse', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 255,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Adresse :",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
