<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/product')]
class ProductController extends AbstractController
{
   public function __construct(ManagerRegistry $managerRegistry)
   {
      $this->managerRegistry = $managerRegistry;
   } 

   #[IsGranted("ROLE_ADMIN")]
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
   #[IsGranted("ROLE_CUSTOMER")]
   #[Route('/store', name: 'product_store')]
   public function productStore()
   {
      $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
      return $this->render(
         'product/store.html.twig',
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
   #[IsGranted("ROLE_ADMIN")]
   #[Route('/delete/{id}', name: 'product_delete')]
   public function productDelete($id,ManagerRegistry $managerRegistry)
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
   #[Route('/add', name: 'product_add')]
   public function productAdd (Request $request) {
      $product = new Product;
      $form = $this->createForm(ProductType::class,$product);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->managerRegistry->getManager();
         $manager->persist($product);
         $manager->flush();
         $this->addFlash('Info', 'Add product succeed !');
         return $this->redirectToRoute("product_index");
      }
      return $this->renderForm("product/add.html.twig",
      [
            'productForm' => $form
      ]);
   }
   #[Route('/edit/{id}', name: 'product_edit')]
   public function productEdit($id, Request $request,ManagerRegistry $managerRegistry)
   {
      $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
      if ($product == null) {
         $this->addFlash('Warning', 'Product not existed !');
      } else {
         $form = $this->createForm(ProductType::class,$product);
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('Info', 'Edit product succeed !');
            return $this->redirectToRoute("product_index");
         }
         return $this->renderForm("product/edit.html.twig",
         [
            'productForm' => $form
         ]);
      }
   }
   #[IsGranted('ROLE_CUSTOMER')]
   #[Route('/price/asc', name: 'sort_product_price_ascending')]
   public function sortProductPriceAscending(ProductRepository $productRepository)
   {
      $products = $productRepository->sortProductPriceAsc();
      return $this->render(
         'product/store.html.twig',
         [
            'products' => $products
         ]
      );
   }

   #[IsGranted('ROLE_CUSTOMER')]
   #[Route('/price/desc', name: 'sort_product_price_descending')]
   public function sortProductPriceDescending(ProductRepository $productRepository)
   {
      $products = $productRepository->sortProductPriceDesc();
      return $this->render(
         'product/store.html.twig',
         [
            'products' => $products
         ]
      );
   }

   #[IsGranted('ROLE_CUSTOMER')]
   #[Route('/search', name: 'search_product_title')]
   public function searchProduct(ProductRepository $productRepository, Request $request)
   {
      $key = $request->get('keyword');
      $products = $productRepository->searchProductByTitle($key);
      //   if ($products == null) {
      //      $this->addFlash('Warning', "No product found");
      //   }
      return $this->render(
         'product/store.html.twig',
         [
            'products' => $products
         ]
      );
   }



}
