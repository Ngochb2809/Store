<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[IsGranted("ROLE_ADMIN")]
#[Route('/category')]
class CategoryController extends AbstractController
{
    public function __construct(ManagerRegistry $managerRegistry)
   {
      $this->managerRegistry = $managerRegistry;
   } 
   #[Route('/index', name: 'category_index')]
   public function categoryIndex () {
      $categorys = $this->getDoctrine()->getRepository(Category::class)->findAll();
      return $this->render('category/index.html.twig',
        [
            'categorys' => $categorys
        ]);
   } 
   #[Route('/list', name: 'category_list')]
   public function categoryList() {
      $categorys = $this->getDoctrine()->getRepository(Category::class)->findAll();
      return $this->render('category/list.html.twig',
        [
            'categorys' => $categorys
        ]);
   } 
   #[Route('/detail/{id}', name: 'category_detail')]
   public function categoryDetail ($id, CategoryRepository $categoryRepository) {
      $category = $categoryRepository->find($id);
      if ($category == null) {
         $this->addFlash('Warning','Invalid category id !');
         return $this->redirectToRoute('category_index');
      }
      return $this->render('category/detail.html.twig',
        [
            'category' => $category
        ]);   
   }
   #[Route('/delete/{id}', name: 'category_delete')]
   public function categoryDelete ($id) {
     $category = $this->managerRegistry->getRepository(Category::class)->find($id);
     if ($category == null) {
        $this->addFlash('Warning', 'Category not existed !');
     } else if (count($category->getProducts()) >= 1){ //check xem category này có ràng buộc với book hay không trước khi xóa
         //nếu có tối thiểu 1 book thì hiển thị lỗi và không cho xóa  
      $this->addFlash('Warning', 'Can not delete this category');
     }   
     else {
        $manager = $this->managerRegistry->getManager();
        $manager->remove($category);
        $manager->flush();
        $this->addFlash('Info', 'Delete category succeed !');
     }
     return $this->redirectToRoute('category_index');
   }
   #[Route('/add', name: 'category_add')]
   public function categoryAdd (Request $request) {
      $category = new Category;
      $form = $this->createForm(CategoryType::class,$category);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->managerRegistry->getManager();
         $manager->persist($category);
         $manager->flush();
         $this->addFlash('Info', 'Add category succeed !');
         return $this->redirectToRoute("category_index");
      }
      return $this->renderForm("category/add.html.twig",
      [
            'categoryForm' => $form
      ]);
   }
   #[Route('/edit/{id}', name: 'category_edit')]
   public function categoryEdit ($id, Request $request) {
        $category = $this->managerRegistry->getRepository(Category::class)->find($id);
        if ($category == null) {
            $this->addFlash('Warning', 'Category not existed !');
         } else {
            $form = $this->createForm(CategoryType::class,$category);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->managerRegistry->getManager();
                $manager->persist($category);
                $manager->flush();
                $this->addFlash('Info', 'Edit category succeed !');
                return $this->redirectToRoute("category_index");
            }
            return $this->renderForm("category/edit.html.twig",
            [
                'categoryForm' => $form
            ]);
         }
   }

}
