<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BasketController extends Controller
{
    /**
     * @Route("/koszyk", name="basket")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        //get(oczekiwana wartosc, default)
        $session = $request->getSession();
        $basket = $session->get('basket', array());
        $products = $this->getProducts();
        
        $productsInBasket = array();
        
        foreach($basket as $id => $b)
        {
            $productsInBasket[] = $products[$id];
        }
        
        //dump($basket);
        
        return array(
            'products_in_basket' => $productsInBasket,
        );    
        
    }

    /**
     * @Route("/koszyk/{id}/dodaj", name="basket_add")
     * @Template()
     */
    public function addAction($id, Request $request)
    {
        $session = $request ->getSession();        
        $basket = $session->get('basket', array());
        
        //ustalenie ilości na sztywno - 1 :)
        $basket[$id] = 1;
        
        //zapisanie w sesji
        $session->set('basket', $basket);
        
        //flash message oprócz potwqierdzenia operacji zabezpiecza nas
        //przed kolejnym dodaniem produktu przez odświeżenie stronył
        $this->addFlash('notice', 'Produkt dodany do koszyka');
        return $this->redirectToRoute('basket'); 
        
    }

    /**
     * @Route("/koszyk/{id}/usun", name="basket_del")
     * @Template()
     */
    public function removeAction($id, Request $request)
    {
        //pobranie aktualnej sesji, odnalezienie w niej tablicy basket
        //oraz przypisanie jej do zmiennej $basket
        $session = $request->getSession();
        $basket = $session->get('basket');
        
        //usunięcie z tablicy basket obiektu o id przekazanym z tabeli
        unset($basket[$id]);
        
        //zapisanie zmian w tablicy
        $session->set('basket', $basket);
        
        $this->addFlash('notice', 'Produkt usunięty z koszyka');
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
     * @Template()
     */
    public function clearAction(Request $request)
    {
        $session = $request->getSession();
        $basket = $session->get('basket');
        
        //usunięcie i ponowne utworzenie tablicy       
        unset($basket);
        $basket = array(); 
        
        $session->set('basket', $basket);
        
        $this->addFlash('notice', 'Koszyk opróżniony');
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
    
    private function getProducts()
    {
        $file = file('product.txt'); 
        $products = array(); 
        foreach ($file as $p) 
        { 
            //explode(znak rozdzielajacy, trim - usuwa biale znaki)
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

}
