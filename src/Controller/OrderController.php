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
    #[Route('/cart/info', name: 'add_to_cart')]
    public function addToCart (Request $request) {
      $session = $request->getSession();
      $product = $this->getDoctrine()->getRepository(Product::class)->find($request->get('id'));
      $quantity = $request->get('quantity');
      $date = date('Y/m/d');  
      $datetime = date('Y/m/d H:i:s');  
      $user = $this->getUser();
      $productprice = $product->getPrice();
      $totalprice = $productprice * $quantity;
      $session->set('product', $product);
      $session->set('user', $user);
      $session->set('quantity', $quantity);
      $session->set('totalprice', $totalprice);
      $session->set('datetime', $datetime);
      return $this->render('cart/detail.html.twig');
   }
   #[Route('/order/make', name: 'make_order')]
    public function orderMake() 
    {
        $session = $request->getSession();
        $id = $request->get('productid');
        $session->set('productid', $id);
        $product=$this->getDoctrine()->getRepository(Product::class)->find($id);
        $session->set('product', $product);
        $date = date("Y-m-d");
        $session->set('date', $date);
        $datetime = date("Y-m-d H:i:s");
        $session->set('datetime', $datetime);
        $user = $this->getUser();
        $session->set('user', $user);
        $manager = $managerRegistry->getManager();
        $manager->persist($product);
        $manager->flush();
        //gửi thông báo về view bằng addFlash
        $this->addFlash('Info', 'Order product successfully !');
  
        //redirect về trang product store
        return $this->redirectToRoute('product_store'); 
    }

}
