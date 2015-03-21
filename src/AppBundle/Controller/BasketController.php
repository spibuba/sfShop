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
            //klucz                      wartosc
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
     */
    public function removeAction($id, Request $request)
    {
        //pobranie aktualnej sesji, odnalezienie w niej tablicy basket
        //oraz przypisanie jej do zmiennej $basket
        $session = $request->getSession();
        $basket = $session->get('basket');
        
        
        if (!array_key_exists($id, $basket)) {
            $this->addFlash('notice', 'Nie odnaleziono produktu');
            return $this->redirectToRoute('basket');
        }
              
        unset($basket[$id]);    
        
        
        //zapisanie zmian w sesji
        $session->set('basket', $basket);
        $product = $this->getProduct($id);
        
        $this->addFlash('notice', sprintf('Produkt %s usunięty z koszyka', $product['name']));
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
                
        //czyszczenie polegające na ustawieniu w sesji pustej tablicy basket
        $session->set('basket', array());
        
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
    
    private function getProduct($id){
        
        $products = $this->getProducts();
        
        return $products[$id];
    }

}
