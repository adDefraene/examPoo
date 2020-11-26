<?php

namespace App\Form;

use App\Entity\Car;
use App\Form\AppType;
use App\Form\ImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CarType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', TextType::class, $this->getConfiguration("Marque", "Marque de la voiture"))
            ->add('model', TextType::class, $this->getConfiguration("Modèle", "Modèle de la voiture"))
            ->add('coverImage', FileType::class, $this->getConfiguration("Image de couverture", "Image de la couverture de l'annonce"))
            ->add('mileage', NumberType::class, $this->getConfiguration("Kilométrage", "Nombre de km de la voiture (xxxxxxkm)"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix", "Prix de vente de la voiture (xxxx€)"))
            ->add('oldOwner', IntegerType::class, $this->getConfiguration("Anciens propriétaires", "Nombre d'anciens propriétaires"))
            ->add('engineCc', NumberType::class, $this->getConfiguration("Cylindrée", "Cylindrée de la voiture (xxxxCC)"))
            ->add('enginePower', NumberType::class, $this->getConfiguration("Puissance", "Puissance de la voiture (xxKw/h)"))
            ->add('fuel', ChoiceType::class, [
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    "Électrique" => 'électrique',
                    "Hybride" => "hybride"
                ],
                'label' => 'Type de carburant'
            ])
            ->add('yearRelease', NumberType::class, $this->getConfiguration("Année de mise en circulation", "Année de mise en circulation du véhicule"))
            ->add('transmission', ChoiceType::class, [
                'choices' => [
                    'Automatique' => 'automatique',
                    'Manuelle' => 'manuelle'
                ],
                'label' => 'Type de transmission'
            ])
            ->add('description', TextareaType::class , $this->getConfiguration("Description", "Texte de description de la voiture"))
            ->add('options', TextType::class, $this->getConfiguration("Options", "Options de la voiture"))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
