<?php

namespace App\Form;

use App\Entity\Musique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MusiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('album')
            ->add('songFile', VichFileType::class, [
                'label' => 'Fichier audio',
                'required' => false,
                'download_uri' => false,
                'allow_delete' => true,
                'asset_helper' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Musique::class,
        ]);
    }
}
