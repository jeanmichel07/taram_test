<?php

namespace App\Form;

use App\Entity\Provider;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImportPurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('provider', EntityType::class, [
                'class' => Provider::class,
                'choice_label' => 'name',
                'label' => 'Fournisseur',
                'placeholder' => 'Sélectionnez un fournisseur',
            ])
            ->add('csvFile', FileType::class, [
                'label' => 'Fichier CSV',
                'constraints' => [
                    new File([
                        'maxSize' => '2m', // Limite à 2 Mo
                        'mimeTypes' => ['text/csv', 'text/plain', 'application/csv'],
                        'mimeTypesMessage' => 'Veuillez uploader un fichier CSV valide.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Importer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // Formulaire non lié à une entité
        ]);
    }
}