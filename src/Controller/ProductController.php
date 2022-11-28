<?php

namespace App\Controller;

use App\Classe\Shearch;
use App\Entity\Product;
use App\Form\ShearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/name-product', name: 'app_products')]
    public function index( Request $request): Response
    {
        $search = new Shearch;
  
        $form = $this->createForm(ShearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithShearch($search);
            
        }else {
             $products = $this->entityManager->getRepository(Product::class)->findAll();
        }


        return $this->render('product/index.html.twig',[
            'products'=>$products,
            'form'=>$form->createView()
        ]);
    }


    #[Route('/produit/{slug}', name: 'app_product')]
    public function show( $slug): Response
    {
       
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        if (!$product) {
           return $this->redirectToRoute('app_products');
        }


        return $this->render('product/show.html.twig',[
            'product'=>$product
        ]);
    }
}
