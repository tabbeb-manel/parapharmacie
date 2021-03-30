<?php

namespace App\Controller;

use App\Entity\PageContact;
use App\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MailController extends AbstractController
{
    /**
     * @Route("/{id}/mail", name="mail")
     */
    public function repondre(Request $request , PageContact $contact)
    {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->getData();

            // Ici nous enverrons l'e-mail

            $this->addFlash('message', 'Votre message a été transmis.'); // Permet un message flash de renvoi
        }
        return $this->render('admin/mail.html.twig',['contactForm' => $form->createView(),"contact"=>$contact]);
    }

}
