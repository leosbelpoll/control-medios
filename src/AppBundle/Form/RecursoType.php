<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecursoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('responsable', null, array(
                'placeholder' => ' - Seleccione - '
            ))
            ->add('fechacreacion', null, array(
                'widget' => 'single_text'
            ))
            ->add('descripcion')
            ->add('recursosatributos', CollectionType::class, array(
                'entry_type' => RecursoAtributoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'label' => ' ',
            ))
            // ->add('subrecursos')
            ->add('padre', null, array(
                'placeholder' => '- Ninguno -'
            ))
            ->add('fechabaja', null, array(
                'widget' => 'single_text'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recurso'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recurso';
    }


}
