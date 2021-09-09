<?php

namespace App\Form;

use App\Entity\CommandeDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CommandeDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('detQuantite', NumberType::class, [
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
            ->add('detRemise', NumberType::class, [
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
            ->add('detPrixVente', NumberType::class, [
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
            ->add('produit', TextType::class, [
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
            ->add('commande', NumberType::class, [
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
            'data_class' => CommandeDetail::class,
        ]);
    }
}
