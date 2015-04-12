<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/list")
     */
    public function listAction()
    {
        $qb = $this
            ->getDoctrine()
            ->getManager()
            ->createQueryBuilder();

        $qb
            ->select('c, p')
            ->from('AppBundle:Category', 'c')
            ->leftJoin('c.products', 'p');

        $categories = $qb
            ->getQuery()
            ->getResult();

        return $this->render('Category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

}
