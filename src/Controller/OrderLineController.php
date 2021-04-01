<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\Product;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderLineController extends AbstractController
{
    private $logger;


    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("/orderline", name="order_line_index")
     */

    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $cart = $session->get('cart',[]);
        $cartWithData = [];

        foreach ($cart as $id => $quantity)
        {
            $cartWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($cartWithData as $item)
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }



        return $this->render('order_line/index.html.twig',[
            'items' => $cartWithData,
            'total' => $total
        ]);


    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session, OrderLineRepository $orderLineRepository, EntityManagerInterface $em, ProductRepository $productRepository, OrderRepository $orderRepository)
    {
        //$order_line = new OrderLine();
        $cart = $session->get('cart',[]);
        //$product = $productRepository->find($id);

        if (empty($cart[$id]))
        {
            $quantity = $cart[$id] = 1;
        } else {
            $quantity = $cart[$id]++;
        }

//        $order_line->setProduct($product);
//        $order_line->setQuantity($quantity);
//        $order_line->setTotal($product->getPrice());

        $session->set('cart', $cart);

        //$cart = $productRepository->find($id);
        //$em ->persist($order_line);
        //$em ->flush();

        return $this->redirectToRoute("product_index");
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id]))
        {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute("order_line_index");
    }


    /**
     * @param $id
     * @Route("/order/details/{id}", name="details_index")
     */
    public function Od(SessionInterface $session,ProductRepository $productRepository,$id, OrderLineRepository $orderLineRepository, OrderRepository $orderRepository)
    {

        return $this->render('order_line/details.html.twig', [
            'order_lines' => $orderLineRepository->findAll(),
            'orders' => $orderRepository->findAll(),
            'id' => $id,
        ]);
    }

    /**
     * @Route("/deleteCart", name="delete_cart_index")
     */
    public function ClearSession(SessionInterface $session){

        $session->remove('cart');
        return $this->redirectToRoute("order_line_index");
    }


    /**
     * @param $id
     * @Route("/orderlist/odetails/{id}", name="odetails_index")
     */

    public function Odetails(SessionInterface $session,ProductRepository $productRepository,$id, OrderLineRepository $orderLineRepository, OrderRepository $orderRepository)
    {

        return $this->render('order_line/orderdetail.html.twig', [
            'order_lines' => $orderLineRepository->findAll(),
            'orders' => $orderRepository->findAll(),
            'id' => $id,
        ]);
    }

    /**
     * @param $id
     * @Route("/orderlist/valier/{id}", name="ValidateOrder")
     */

    public function ValidateOrder($id,OrderRepository $ordRep)
    {
    $em = $this->getDoctrine()->getManager();
    $order = $em->getRepository(Order::class)->find($id);
    $order->setStatus(2);
    $em->flush();
    return $this->redirectToRoute("orderlist_index");
    }


}