<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea', array(
                'label' => "form.comment.label",
                'attr'  => array(
                    'class' => 'form-control', 
                    'placeholder' => "form.comment.placeholder"
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comment'
          //  'translation' => 'gdyby była inna ścieżka do tłumaczeń to podać ja tu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_comment';
    }
}
