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
       $this->session = $request->getSession();
       $product = $this->getDoctrine()->getRepository(Product::class)->find($request->get('id'));
       $quantity = $request->get('quantity');
       $date = date('Y/m/d');  
       $datetime = date('Y/m/d H:i:s');  
       $user = $this->getUser();
       $productprice = $product->getPrice();
       $totalprice = $productprice * $quantity;
       $this->session->set('product', $product);
       $this->session->set('user', $user);
       $this->session->set('quantity', $quantity);
       $this->session->set('totalprice', $totalprice);
       $this->session->set('datetime', $datetime);
       return $this->render('cart/detail.html.twig');
    }

    #[Route('/order/make', name: 'make_order')]
    public function orderMake(Request $request) 
    {
      //khởi tạo session
      $session = new Session();
      //tạo object Order để lưu thông tin đơn hàng
      $order = new Order();
      //giảm quantity của product sau khi order
      $product = $this->getDoctrine()->getRepository(Product::class)->find($session->get('productid'));
      $product_quantity = $product->getQuantity();
      $order_quantity = $session->get('quantity');
      $new_quantity = $product_quantity - $order_quantity;
      $product->setQuantity($new_quantity);

      //set từng thuộc tính cho bảng Order 

      $order->setPrice('totalprice',$totalprice);
      $session->setUser('user', $user);
      $session->setQuantity('quantity', $quantity);
      $session->setTotalprice('totalprice', $totalprice);
      $session->setDatetime('datetime', $datetime);


      //dùng Manager để lưu object vào DB
      $manager = $managerRegistry->getManager();
      $manager->persist($product);
      $manager->flush();

      //gửi thông báo về view bằng addFlash
      $this->addFlash('Info', 'Order product successfully !');

      //redirect về trang product store
      return $this->redirectToRoute('product_list',);
             
    }
}
