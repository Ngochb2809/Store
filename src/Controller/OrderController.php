<?php

namespace App\Controller;


use App\Entity\User;
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
    }
    #[Route('/cart', name: 'add_to_cart')]
    public function addToCart (Request $request, ManagerRegistry $managerRegistry) {
        $order = new Order();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($request->get('id'));
        $quantity = $request->get('quantity');
        $order->setProduct($product)
        ->setUser($user)
        ->setQuantity($quantity)
        ->setTotalprice($product->getPrice() * $quantity)
        ->setDatetime(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
        $manager = $managerRegistry->getManager();
        $manager->persist($order);
        $manager->flush();

        //gửi thông báo về view bằng addFlash
        $this->addFlash('Info', 'Order product successfully !');
        return $this->render('cart/detail.html.twig',
    [
        'order' => $order
    ]);
        
    }
}
