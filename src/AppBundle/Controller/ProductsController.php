<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Category;
use AppBundle\Form\ProductType;

class ProductsController extends Controller
{
    /**
     * @Route("/produkty/{id}", name="products_list", defaults={"id" = false},
     * requirements={"id": "\d+"})
     */
    public function indexAction(Request $request, Category $category = null)
    {
        $getProductsQuery = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->getProductsQuery($category);
        
        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $getProductsQuery,
            $request->query->get('page', 1),
            8
        );

        return $this->render('Products/index.html.twig', [
            'products' => $products,
        ]);
    }
    
    
    /**
     * @Route("/produkty/dodaj", name="products_add")
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(new ProductType());
        $form->handleRequest($request);
        
        return $this->render('Products/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    
    /**
     * @Route("/produkty/pokaz/{id}", name="products_show")
     * 
     */
    public function showAction(Request $request, $id)
    {
        
        return $this->render("Products/show.html.twig",
                array( 'product' => $this->getDoctrine()
                ->getEntityManager()
                ->getReference('AppBundle:Product', $id)));
    }
            
}