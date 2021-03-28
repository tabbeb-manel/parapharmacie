<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Form\ArticleType;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
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

    /**
     * @Route("/article/{id}/like", name="article_like")
     * @param Article $article
     * @param ObjectManager $manager
     * @param ArticleLikeRepository $likerepo
     * @return Response
     */
    public function like(Article $article, ObjectManager $manager, ArticleLikeRepository $likerepo) : Response{
        $user = $this->getUser();
        if(!$user) return $this->json([
            'code'=> 403,
            'message'=>"Unauthorized"
        ],403);
        if ($article->isLikedByUser($user)){
            $like = $likerepo->findOneBy([
                'article' => $article,
                'user'=> $user
            ]);
            $manager->remove($like);
            $manager->flush();
            return $this->json([
                'code' => 200,
                'message'=>'Like est supprimé',
                'likes'=> $likerepo->count(['article'=> $article])
            ], 200);
        }
        $like = new ArticleLike();
        $like->setArticle($article)
            ->getUser($user);
        $manager->persist($like);
        $manager->flush();
        return $this->json(['code'=> 200, 'message'=>'Like bien ajouté','likes'=>$likerepo->count(['article'=>$article])
        ], 200);
    }


}
