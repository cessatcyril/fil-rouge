<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            ->add('mois', ChoiceType::class, [
                'required' => true, 
                'choices' => [
                    'janvier' => 1,
                    'février' => 2,
                    'mars' => 3,
                    'avril' => 4,
                    'mai' => 5,
                    'juin' => 6,
                    'juillet' => 7,
                    'août' => 8,
                    'septembre' => 9,
                    'octobre' => 10,
                    'novembre' => 11,
                    'décembre' => 12,
                ]
            ])
            ->add('annee', ChoiceType::class, [
                'required' => true, 
                'choices' => $this->choixAnnee(),
            ])
            ->add('save', SubmitType::class);
        ;
    }

    public function choixAnnee() {
        $distance = 5;
        $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") + $distance));
        return array_combine(range($yearsBefore, $yearsAfter), range($yearsBefore, $yearsAfter));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
