<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class CreerCompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 255,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Email :",
                "attr" =>  ["autocomplete" => "off"]
            ])

            ->add('plainPassword', PasswordType::class, [
                // 'mapped' => false
                "label" => "Password: :"
            ])

            ->add('cliNom', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Nom :",
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
                ],
                "label" => "Prenom :",
            ])

            ->add('cliNaissance', DateType::class, [
                'widget' => 'single_text',
                "label" => "Date de naissance :",
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
                ],
                "label" => "Téléphone :",
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
                ],
                "label" => "Fax :",
            ])

            ->add('cliSexe', ChoiceType::class, [
                'choices'  => [
                    'Femme' => true,
                    'Homme' => false,
                ],
                "label" => "Sexe :",
            ])

            ->add('adrPaysDomicile', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Pays du domicile :",

            ])

            ->add('adrVilleDomicile', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Ville du domicile :",
            ])

            ->add('adrPostalDomicile', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 15,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Code postal du domicile :",
            ])

            ->add('adrAdresseDomicile', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 255,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Adresse du domicile :",
            ])

            ->add('adrPaysLivraison', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Pays de livraison :",

            ])

            ->add('adrVilleLivraison', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Ville de livraison :",
            ])

            ->add('adrPostalLivraison', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 15,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Code postal de livraison :",
            ])

            ->add('adrAdresseLivraison', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 255,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Adresse de livraison :",
            ])

            ->add('adrPaysFacturation', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Pays de facturation :",

            ])

            ->add('adrVilleFacturation', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        "minMessage" => "trop petit",
                        'max' => 50,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Ville de facturation :",
            ])

            ->add('adrPostalFacturation', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 15,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Code postal de facturation :",
            ])

            ->add('adrAdresseFacturation', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        "minMessage" => "trop petit",
                        'max' => 255,
                        "maxMessage" => "trop long",
                    ]),
                ],
                "label" => "Adresse de facturation :",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
