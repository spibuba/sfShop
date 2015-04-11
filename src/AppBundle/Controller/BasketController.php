<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;

class BasketController extends Controller {

    /**
     * @Route("/koszyk", name="basket")
     * @Template()
     */
    public function indexAction(Request $request) {
        return $this->render('Basket/index.html.twig', array('basket' => $this->get('basket')));
    }

    /**
     * @Route("/koszyk/{id}/dodaj", name="basket_add")
     */
    public function addAction(Request $request, Product $product = null) {
        if (is_null($product)) {
            $this->addFlash('error', 'Nie znaleziono produktu o takim id');
            return $this->redirectToRoute('basket');
        }


        try {

            $basket = $this->get('basket');
            $basket->add($product);
        } catch (\Exception $ex) {

            $this->addFlash('error', $ex->getMessage());
            //powrót do strony z której przyszliśmy
            return $this->redirect($request->headers->get('referer'));
        }


        $this->addFlash('notice', sprintf('Produkt "%s" został dodany do koszyka', $product->getName()));

        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/koszyk/{id}/usun", name="basket_remove")
     */
    public function removeAction(Product $product) {
        $basket = $this->get('basket');

        try {
            $basket->remove($product);

            $this->addFlash('notice', sprintf('Product %s został usunięty z koszyka', $product->getName()));
        } catch (\Exception $ex) {

            $this->addFlash('notice', $ex->getMessage());
        }

        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/koszyk/{id}/zaktualizuj-ilosc/{quantity}")
     * @Template()
     */
    public function updateAction($id, $quantity) {
        return array(
                // ...
        );
    }

    /**
     * @Route("/koszyk/wyczysc", name="basket_clear")
     * @Template()
     */
    public function clearAction() {
        $this
                ->get('basket')
                ->clear();

        $this
                ->addFlash('notice', 'Koszyk został opróżniony');
        return $this
                        ->redirectToRoute('basket');
    }

    /**
     * @Route("/koszyk/kup")
     * @Template()
     */
    public function buyAction() {
        return array(
                // ...
        );
    }

    /**
     * @Route("/koszyk/contents", name="basket_contents")
     * @Template()
     */
    public function showContentsAction(Request $request) {
        return $this->render('Basket/contents.html.twig', array('basket' => $this->get('basket')));
    }

    private function getProducts() {
        $file = file('product.txt');
        $products = array();
        foreach ($file as $p) {
            $e = explode(':', trim($p));
            $products[$e[0]] = array(
                'id' => $e[0],
                'name' => $e[1],
                'price' => $e[2],
                'desc' => $e[3],
            );
        }

        return $products;
    }

    private function getProduct($id) {
        $products = $this->getProducts();

        return $products[$id];
    }

}
