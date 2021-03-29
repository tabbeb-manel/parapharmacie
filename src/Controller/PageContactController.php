<?php

namespace App\Controller;

use App\Entity\PageContact;
use App\Form\PagecontactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PageContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request)
    {
        $pagecontact = new PageContact();
        $form = $this->createForm(PagecontactType::class, $pagecontact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pagecontact);
            $entityManager->flush();
        }
        return $this->render('user/contact.html.twig', ['pagecontact'=>$pagecontact,'form' => $form->createView(), 'title' => 'pagecontact']);
    }

}
