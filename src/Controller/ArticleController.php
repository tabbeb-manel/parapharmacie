<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(ArticleRepository $artrepo)
    {
        $articles = $artrepo->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    /**
     * @Route("/{id}/show", name="article_show")
     * @param Article $article
     * @return Response
     */
    public function show(Article $article): Response
    {
        return $this->render("article/show.html.twig", [
            "article" => $article
        ]);
    }

    /**
     * @Route("/articlescard", name="articles")
     */
    public function home(ArticleRepository $artrepo)
    {
        $articles = $artrepo->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @param ArticleRepository $artrepo
     * @return Response
     * @Route("/article/table", name="table")
     */
    public function tablearticle(ArticleRepository $artrepo)
    {
        $articles = $artrepo->findAll();
        return $this->render('article/table.html.twig', [
            'articles' => $articles,
        ]);
    }


    /**
     * @Route("/article/new", name="article_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file= $article->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter("images_directory"),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $em = $this->getDoctrine()->getManager();
            $article->setImage($fileName);
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('articles');

        }
        return $this->render('article/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("article/{id}/edit", name="article_edit")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function edit(Article $article, Request $request): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('table');
        }
        return $this->render("article/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @param ArticleRepository $repo
     * @param $id
     * @return RedirectResponse
     * @Route("/article/{id}/delete", name="article_delete")
     */
    public function delete(ArticleRepository $repo, $id): RedirectResponse
    {
        $art = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($art);
        $em->flush();
        return $this->redirectToRoute('table');
    }


}
