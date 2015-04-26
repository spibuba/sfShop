<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use AppBundle\Form\BasketItemForm;

/**
 * Description of BasketForm
 */
class BasketForm extends AbstractType
{
    private $products;
    
    public function __construct($products = [])
    {
        $this->products = $products;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('products', 'collection')
        ;

        //foreach ($this->products as $key => $product) {
        //    $builder->get('products')->add('product_'.$key, new BasketItemForm($product));
        //}

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                $form = $event->getForm();

                foreach ($this->products as $key => $product) {
                    $form->add('product_'.$key, new BasketItemForm($product));

                    //$builder->get('products')->add('product_'.$key, new BasketItemForm($product));
                }



            }
        );

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
        return 'basket';
    }
}