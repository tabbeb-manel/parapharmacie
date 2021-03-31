<?php

namespace App\Controller;

use App\Entity\PageContact;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Admin;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{

    /**
     * @Route("/{id}/profilad", name="profilad")
     * @param Admin $Admin
     * @return Response
     */
    public function afficheadmin(Admin $Admin):Response
    {

        return  $this->render('admin/profiladmin.html.twig',[
            'admin'=>$Admin

        ]);

    }
    /**
     * @Route("/listeuser", name="liste_user")
     */
    public function affiche(): Response
    {
        $Repo=$this->getDoctrine()->getRepository(User::class);
        $ListeUser =$Repo->findAll();
        return  $this->render('admin/listeuser.html.twig',[
        "controller_name"=> "userController","liste" => $ListeUser
        ]);

    }


    /**
     * @Route("/mailview", name="mailview")
     */
    public function affichelist(): Response
    {
        $Repo=$this->getDoctrine()->getRepository(Pagecontact::class);
        $mailview =$Repo->findAll();
        return  $this->render('admin/mailview.html.twig',[
            "controller_name"=> "mailController","mailview" => $mailview
        ]);

    }
    /**
     * @Route("/{id}/message", name="msg")
     * @param PageContact $pageContact
     * @return Response
     */
    public function affichemessage(PageContact $pageContact):Response
    {

        return  $this->render('admin/message.html.twig',[
            'pagecontact'=>$pageContact
        ]);

    }

}
