<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of BasketItemForm
 */
class BasketItemForm extends AbstractType
{
    private $product;

    public function __construct($product = [])
    {
        $this->product = $product;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', 'integer')
            ->add('name', 'text')
        ;

        if (!is_null($this->product)){
            $builder->setData($this->product);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function getName()
    {
        return 'basket_item';
    }
}