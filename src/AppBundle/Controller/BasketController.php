<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Product;
use AppBundle\Form\BasketForm;

class BasketController extends Controller
{
    /**
     * @Route("/koszyk", name="basket")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $basket = $this->get('basket');
        $quantities = $request->request->get('quantity', []); 
        foreach ($quantities as $id => $quantity) {
            
            $basket->updateQuantity($id, $quantity);
        }
        
        return array(
            'basket' => $basket
        );
    }

    /**
     * @Route("/koszyk/{id}/dodaj", name="basket_add")
     */
    public function addAction(Request $request, Product $product = null)
    {
        if (is_null($product)) {
            $this->addFlash('error', 'Produkt, który próbujesz dodać nie został znaleziony!');
            return $this->redirect($request->headers->get('referer'));
        }
        
        try {

            $basket = $this->get('basket');
            $basket->add($product);
          
        } catch (\Exception $e) {
            
            $this->addFlash('error', $e->getMessage());
            return $this->redirect($request->headers->get('referer'));
        }

        $this->addFlash('notice', sprintf('Produkt "%s" został dodany do koszyka', $product->getName()));

        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/koszyk/{id}/usun", name="basket_remove")
     */
    public function removeAction(Product $product)
    {
        $basket = $this->get('basket');

        try {
            $basket->remove($product);

            //$this->addFlash('notice', 'Produkt ' . $product->getName() . ' został usunięty z koszyka');
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
    public function updateAction($id, $quantity)
    {




        return array(
                // ...
            );
    }

    /**
     * @Route("/koszyk/wyczysc", name="basket_clear")
     */
    public function clearAction()
    {
        $this
            ->get('basket')
            ->clear();

        $this->addFlash('notice', 'Koszyk został pomyślnie wyczyszczony.');

        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/koszyk/kup")
     * @Template()
     */
    public function buyAction()
    {
        return array(
                // ...
            );
    }

}
