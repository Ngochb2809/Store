<?php

namespace App\Controller;


use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderController extends AbstractController
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->session = new Session();
        $this->managerRegistry = $managerRegistry;
    }
    #[Route('/cart', name: 'add_to_cart')]
    public function addToCart (Request $request) {
        $session = $request->getSession();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($request->get('id'));
        $session->set('product', $product);
        $quantity = $request->get('quantity');
        $session->set('quantity', $quantity);
        $date = date('Y/m/d');  //get current date
        $session->set('date', $date);
        $datetime = date('Y/m/d H:i:s'); //get current date + time
        $session->set('date', $date);
        $session->set('datetime', $datetime);
        $product_price = $product->getPrice();
        $order_price = $product_price * $quantity;
        $session->set('price', $order_price);
        $user = $this->getUser(); //get current user
        $session->set('user', $user);
        return $this->render('cart/detail.html.twig');
   }
   #[Route('/order', name: 'make_order')]
    public function orderMake(Request $request,ManagerRegistry $managerRegistry) 
    {
        
        $this->addFlash('Info', 'Order product successfully !');
        return $this->redirectToRoute('product_store'); 
    }

}
