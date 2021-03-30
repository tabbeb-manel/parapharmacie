<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_index")
     */
    public function index(ProductRepository $productRepository)
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }
}
