<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/name-product', name: 'app_products')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Product::class);
        $products = $repository->findAll();


        return $this->render('product/index.html.twig',[
            'products'=>$products
        ]);
    }


    #[Route('/produit/{slug}', name: 'app_product')]
    public function show(ManagerRegistry $doctrine, $slug): Response
    {
        $repository = $doctrine->getRepository(Product::class);
        $product = $repository->findOneBySlug($slug);
        if (!$product) {
           return $this->redirectToRoute('app_products');
        }


        return $this->render('product/show.html.twig',[
            'product'=>$product
        ]);
    }
}
