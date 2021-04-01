<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Form\OrderType;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order_index")
     */
    public function index(OrderLineRepository $orderLineRepository, OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        //$user = $this->getUser();
        //$order = $orderRepository->findBy(['user']=>$user);
        return $this->render('order/index.html.twig', [
            'products' => $productRepository->findAll(),
            'order_lines' => $orderLineRepository->findAll(),
            'orders' => $orderRepository->findAll()

        ]);
    }

//    public function sendData(SessionInterface $session)
//    {
//
//        return $this->render('templates/base.html.twig', [
//            'nb'=>$nb
//        ]);
//    }

    /**
     * @Route("/Validateorder", name="validate_order")
     */
    public function Validate(EntityManagerInterface $em,OrderLineRepository $orderLineRepository,SessionInterface $session, ProductRepository $productRepository, OrderRepository $orderRepository)
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
        $totalAmount = 0;
        foreach ($cartWithData as $item)
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $totalAmount += $totalItem;
        }
        $total = 0;


        //$user = $this->getUser();


    $order = new Order();
    $dateToday = new \DateTime('now');
    //$order->setUser($user);
    $order->setAmount($totalAmount);
    $datedel = $dateToday;
    $datedel->modify('+2 days');
    $dateToday = new \DateTime('now');
    $order->setDateOrder($dateToday);
    $order->setStatus(1);
    $order->setDateDelivery($datedel);

        $em->persist($order);
        $em->flush();
    foreach ($cartWithData as $item)
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
            $orderLine = new OrderLine();
            $orderLine->setProduct($item['product']);
            $orderLine->setOrderr($order);
            $orderLine->setTotal($totalItem);
            $orderLine->setQuantity($item['quantity']);
            $em->persist($orderLine);
            $em->flush();
        }


        $session->remove('cart');

        return $this->redirectToRoute("order_index");
    }


    /**
     * @Route("/orderlist", name="orderlist_index")
     */
    public function orderlist(SessionInterface $session,OrderLineRepository $orderLineRepository, OrderRepository $orderRepository)
    {
//        $cart = $session->get('cart',[]);
//        $nb = 0;
//        foreach ($cart as $id => $quantity)
//        {
//            $nb += $quantity;
//        }
//        $this->get('twig')->addGlobal('nb', $nb);
        return $this->render('order/orderlist.html.twig', [
            'order_lines' => $orderLineRepository->findAll(),
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/orderlist2", name="orderlist_index2")
     */
    public function orderlist2(SessionInterface $session,OrderLineRepository $orderLineRepository, OrderRepository $orderRepository)
    {
//        $cart = $session->get('cart',[]);
//        $nb = 0;
//        foreach ($cart as $id => $quantity)
//        {
//            $nb += $quantity;
//        }
//        $this->get('twig')->addGlobal('nb', $nb);
        return $this->render('order/orderlist2.html.twig', [
            'order_lines' => $orderLineRepository->findAll(),
            'orders' => $orderRepository->findAll(),
        ]);
    }


    /**
     * @param $id
     * @Route("/orderlist/edit/{id}", name="edit_index")
     */
    public function edit($id, Request $request){
        $em= $this->getDoctrine()->getManager();
        $order = $em->getRepository(Order::class)->find($id);
        $form=$this->createForm(OrderType::class,$order);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $newOrder = $form->getData();
            $order->setDateDelivery($newOrder->getDateDelivery());
            $em->persist($order);
            $em->flush();
            return $this->redirectToRoute("orderlist_index");
        }
        return $this->render('order/editorder.html.twig', array(
            "form"=>$form->createView(),
            "order"=>$order
        ));



    }

    /**
     * @param $id
     * @Route("/orderlist/cancel/{id}", name="cancel_index")
     */
    public function cancel($id, OrderLineRepository $orderLineRepository){
        $em= $this->getDoctrine()->getManager();
        $orderLines = $em->getRepository(OrderLine::class)->findBy(array('orderr'=>$id));
        foreach ($orderLines as $value) {
            $em->remove($value);
            $em->flush();
        }
        $order = $em->getRepository(Order::class)->find($id);
        $em->remove($order);
        $em->flush();
        return $this->redirectToRoute("orderlist_index");
    }


}
