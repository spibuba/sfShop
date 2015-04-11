<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller {

    /**
     * @Route("/produkty/{id}", name="products_list", defaults={"id" = false},
     * requirements={"id": "\d+"})
     */
    public function indexAction(Request $request, Category $category = null) {
        $getProductsQuery = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->getProductsQuery($category);

        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
                $getProductsQuery, $request->query->get('page', 1), 8
        );

        return $this->render('Products/index.html.twig', [
                    'products' => $products,
        ]);
    }

    /**
     * @Route("/produkty/dodaj", name="products_add")
     */
    public function addAction(Request $request) {
        $form = $this->createForm(new ProductType());
        $form->handleRequest($request);

        return $this->render('Products/add.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produkt/{id}", name="products_show")
     * 
     */
    public function showAction(Product $product) {

        return $this->render("Products/show.html.twig", [
                    'product' => $product
        ]);
    }

    /**
     * @Route("/szukaj", name="product_search")
     */
    public function searchAction(Request $request) {
        $query = $request->query->get('query');

        $products = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->createQueryBuilder('p')
                ->select('p')
                ->where('p.name LIKE :query')
                ->orWhere('p.description LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();
        //elastic search < check this out

        return $this->render('products/search.html.twig', [
                    'query' => $query,
                    'products' => $products
        ]);
    }

}
