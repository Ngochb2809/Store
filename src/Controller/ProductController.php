<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/index', name: 'product_index')]
   public function productIndex(ProductRepository $productRepository)
   {
      $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
      //$products = $productRepository->sortProductByIdDesc();
      return $this->render(
         'product/index.html.twig',
         [
            'products' => $products
         ]
      );
   }
   #[Route('/store', name: 'product_store')]
   public function productStore()
   {
      $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
      return $this->render(
         'product/list.html.twig',
         [
            'products' => $products
         ]
      );
   }
   #[Route('/detail/{id}', name: 'product_detail')]
   public function productDetail($id, ProductRepository $productRepository)
   {
      $product = $productRepository->find($id);
      if ($product == null) {
         $this->addFlash('Warning', 'Invalid product id !');
         return $this->redirectToRoute('product_index');
      }
      return $this->render(
         'product/detail.html.twig',
         [
            'product' => $product
         ]
      );
   }
   #[Route('/delete/{id}', name: 'product_delete')]
   public function productDelete($id, ManagerRegistry $managerRegistry)
   {
      $product = $managerRegistry->getRepository(Product::class)->find($id);
      if ($product == null) {
         $this->addFlash('Warning', 'Product not existed !');
      } else {
         $manager = $managerRegistry->getManager();
         $manager->remove($product);
         $manager->flush();
         $this->addFlash('Info', 'Delete product succeed !');
      }
      return $this->redirectToRoute('product_index');
   }
   public function productAdd(Request $request)
   {
      $product = new Product;
      $form = $this->createForm(ProductType::class, $product);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         //bổ sung code upload ảnh
         //B1: lấy ra ảnh vừa upload
         $img = $product->getImage();
         //B2: set tên mới cho ảnh => đảm bảo tên ảnh là duy nhất trong thư mục
         $imgName = uniqid(); //uniqid : tạo ra string duy nhất
         //B3: lấy ra đuôi (extension) của ảnh
         $imgExtension = $img->guessExtension();
         //B4: hoàn thiện tên mới cho ảnh (giữ đuôi cũ và thay tên mới)
         $imageName = $imgName . "." . $imgExtension;
         //VD: greenwich.jpg 
         //B5: di chuyển ảnh về thư mục chỉ định trong project
         try {
            $img->move(
               $this->getParameter('product_image'),
               $imageName
               //di chuyển file ảnh upload về thư mục cùng với tên mới
               //note: cầu hình parameter trong file services.yaml
            );
         } catch (FileException $e) {
            throwException($e);
         }
         //B6: set dữ liệu của image vào object product
         $product->setImage($imageName);
         //lưu dữ liệu của product vào DB
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($product);
         $manager->flush();
         $this->addFlash('Info', 'Add product succeed !');
         return $this->redirectToRoute("product_index");
      }
      return $this->renderForm(
         "product/add.html.twig",
         [
            'productForm' => $form
         ]
      );
   }
   #[Route('/edit/{id}', name: 'product_edit')]
   public function productEdit($id, Request $request)
   {
      $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
      if ($product == null) {
         $this->addFlash('Warning', 'Product not existed !');
      } else {
         $form = $this->createForm(ProductType::class, $product);
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
            //kiểm tra xem người dùng có muốn upload ảnh mới hay không
            //nếu có thì thực hiện code upload ảnh
            //nếu không thì bỏ qua
            $imageFile = $form['image']->getData();
            if ($imageFile != null) {
               $image = $product->getImage();
               $imgName = uniqid();
               $imgExtension = $image->guessExtension();
               $imageName = $imgName . "." . $imgExtension;
               try {
                  $image->move(
                     $this->getParameter('product_image'),
                     $imageName
                  );
               } catch (FileException $e) {
                  throwException($e);
               }
               $product->setImage($imageName);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('Info', 'Edit product succeed !');
            return $this->redirectToRoute("product_index");
         }
         return $this->renderForm(
            "product/edit.html.twig",
            [
               'productForm' => $form
            ]
         );
      }
   }



}
