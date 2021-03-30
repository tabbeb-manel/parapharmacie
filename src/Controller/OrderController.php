<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order_index")
     */
    public function index(OrderLineRepository $orderLineRepository, OrderRepository $orderRepository)
    {
        return $this->render('order/index.html.twig', [
            'order_lines' => $orderLineRepository->findAll(),
            'orders' => $orderRepository->findAll()

        ]);
    }
    /**
     * @Route("/Validateorder", name="validate_order")
     */
    public function Validate(EntityManagerInterface $em,OrderLineRepository $orderLineRepository,SessionInterface $session, ProductRepository $productRepository, OrderRepository $orderRepository){


        $cart = $session->get('cart',[]);
        $cartWithData = [];


        foreach ($cart as $id => $quantity)
        {
            $cartWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        $totalAmount = 0;
        foreach ($cartWithData as $item)
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $totalAmount += $totalItem;
        }
        $total = 0;




    $order = new Order();
    $dateToday = new \DateTime('now');
//    $order->setUser(1);
    $order->setAmount($totalAmount);
    $datedel = $dateToday;
    $datedel->modify('+2 days');
    $dateToday = new \DateTime('now');
    $order->setDateOrder($dateToday);
    $order->setDateDelivery($datedel);
        $em->persist($order);
        $em->flush();
    foreach ($cartWithData as $item)
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
            $orderLine = new OrderLine();
            $orderLine->setOrderr($order);
            $orderLine->setTotal($totalItem);
            $orderLine->setQuantity($item['quantity']);
            $em->persist($orderLine);
            $em->flush();
        }




        return $this->redirectToRoute("order_index");
    }


    /**
     * @Route("/orderlist", name="orderlist_index")
     */
    public function orderlist(OrderLineRepository $orderLineRepository, OrderRepository $orderRepository)
    {
        return $this->render('order/orderlist.html.twig', [
            'order_lines' => $orderLineRepository->findAll(),
            'orders' => $orderRepository->findAll()

        ]);
    }


    /**
     * @Route("/edit", name="edit_index")
     */
    public function edit(){
        return $this->render('order/editorder.html.twig', []);
    }

    /**
     * @Route("/cancel", name="cancel_index")
     */
    public function cancel(){
        return $this->render('order/cancelorder.html.twig', []);
    }
}
