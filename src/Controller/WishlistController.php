<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class WishlistController extends AbstractController
{
    /**
     * @Route("/wishlist", name="wishlist_index")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $wishlist = $session->get('wishlist',[]);

        $wishlistf = [];

        foreach ($wishlist as $id => $quantity)
        {
            $wishlistf[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($wishlistf as $item)
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('wishlist/index.html.twig', [
            'items' => $wishlistf
        ]);

    }

    /**
     * @Route("/wishlist/add/{id}", name="wishlistadd_index")
     */
    public function add($id, SessionInterface $session, ProductRepository $productRepository)
    {
        $wishlist = $session->get('wishlist',[]);

        if(empty($wishlist[$id]))
        {
            $wishlist[$id] = 1;
        }

        $session->set('wishlist', $wishlist);

        return $this->redirectToRoute("product_index");
    }

    /**
     * @param $id
     * @param SessionInterface $session
     * @Route("/wishlist/delete/{id}", name="wishlistd_index")
     */
    public function delete($id, SessionInterface $session)
    {
        $wishlist = $session->get('wishlist',[]);

        if(!empty($wishlist[$id]))
        {
            unset($wishlist[$id]);
        }

        $session->set('wishlist', $wishlist);

        return $this->redirectToRoute("wishlist_index");
    }
}
