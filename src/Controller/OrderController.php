<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Controller\OrderController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    public function __construct()
    {
        $this->session = new Session();
    }
    #[Route('/cart/info', name: 'add_to_cart')]
    public function addToCart (Request $request) {
       //khởi tạo session
       $this->session = $request->getSession();
       //lấy dữ liệu gửi từ form Add To Cart
       $product = $this->getDoctrine()->getRepository(Product::class)->find($request->get('id'));
       $quantity = $request->get('quantity');
       //tạo biến date để lưu thông tin về ngày hiện tại
       $date = date('Y/m/d');  
       //tạo biến datetime để lưu thông tin về ngày giờ hiện tại
       $datetime = date('Y/m/d H:i:s');  
       //tạo biến user để lấy ra user hiện tại (đang login)
       $user = $this->getUser();
       //tạo biến totalprice để lưu tổng tiền của đơn hàng
       $productprice = $product->getPrice();
       $totalprice = $productprice * $quantity;
       //set biến session (global variable) để lưu dữ liệu 
       $this->session->set('product', $product);
       $this->session->set('user', $user);
       $this->session->set('quantity', $quantity);
       $this->session->set('totalprice', $totalprice);
       $this->session->set('datetime', $datetime);
       return $this->render('cart/detail.html.twig');
    }

    #[Route('/order/make', name: 'make_order')]
    public function orderMake() 
    {
        //khởi tạo session;
        $session = new Session();
        //tạo object Order
        $order = new Order;
        //set các thuộc tính cho object Order
        $order = $session->get('product');
        $order = $session->get('user');
        $order = $session->get('quantity');
        $order = $session->get('totalprice');
        $order = $session->get('datetime');
        return $this->render('order/detail.html.twig');
        //lưu object Order vào DB bằng Manager
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($order);
        $manager->flush();
        // //gửi thông báo về trang Store bằng addFlash()
        $this->session->getFlashbag()->add("info","Buy successful");
        return new RedirectResponse($this->router->generate('product_store'));

    }
}
