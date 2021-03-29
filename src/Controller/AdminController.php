<?php

namespace App\Controller;

use App\Entity\Pagecontact;
use App\Entity\User;
use App\Form\PagecontactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Admin;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/loginadmin",name="loginadmin")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/loginadmin.html.twig',
            ['lastUsername'=>$lastUsername,'error' => $error]);
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
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
     * @param $id
     * @Route("/users/delete/{id}", name="user_delete")
     * @return mixed
     */
    public function getUserDeleteAction($id)
    {

        $this->get('user')->deleteUser($id);

        return $this->success();
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
     * @Route("/chatroom", name="chatroom")
     */
    public function affichechatroom(): Response
    {
        $Repo=$this->getDoctrine()->getRepository(Pagecontact::class);
        $chatroom =$Repo->findAll();
        return  $this->render('admin/chatroom.html.twig',[
            "controller_name"=> "mailController","chatroom" => $chatroom
        ]);

    }
}
