<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VirementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('IBAN', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/[a-z0-9]{14,34}/',
                        'match' => true,
                        'message' => 'Composé de 14 à 34 caractères alphanumériques.'
                    ])
                ]
            ])
            ->add('BIC', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/[a-z0-9]{8}|[a-z0-9]{11}/',
                        'match' => true,
                        'message' => 'Composé de 8 ou 11 caractères alphanumériques.'
                    ])
                ]
            ])
            ->add('save', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}