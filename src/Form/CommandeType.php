<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comNumero', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au maximum 255 caractères"
                    ]),
                ]
            ])
            ->add('comFiche', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au maximum 255 caractères"
                    ]),
                ]
            ])
            ->add('comFacture', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au maximum 255 caractères"
                    ]),
                ]
            ])
            ->add('comStatut', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au maximum 255 caractères"
                    ]),
                ]
            ])
            ->add('comCommande', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au maximum 255 caractères"
                    ]),
                ]
            ])
            ->add('comLivraison', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au maximum 255 caractères"
                    ]),
                ]
            ])
            ->add('comButoir', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au maximum 255 caractères"
                    ]),
                ]
            ])
            ->add('client', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => "Doit contenir au moins 3 caractères",
                        'maxMessage' => "Doit contenir au maximum 255 caractères"
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
