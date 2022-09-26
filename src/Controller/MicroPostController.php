<?php

namespace App\Controller;

// use DateTime;                // not needed???
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response // more 'dependency injection' in the index()
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAllWithComments(),
        ]);
    }


    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    #[IsGranted(MicroPost::VIEW, 'post')]
    public function showOne(MicroPost $post): Response          // MicroPost called because sensio uses that in param converter for single cases. Use the MicroPostRepository injection for multiple cases (above) // https://symfony.com/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]                      // ⛔ Deny access to this page if not logged in
    public function add(Request $request, MicroPostRepository $posts): Response
    {
        $form = $this->createForm(MicroPostType::class, new MicroPost());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            // $post->setCreated(new DateTime());
            $post->setAuthor($this->getUser());
            $posts->add($post, true);           // 📌 remember 'true' for flush on entity manager (repository)

            $this->addFlash('success', 'Your post has been added'); // flash message after submit

            return $this->redirectToRoute('app_micro_post'); // redirect after submit
        }

        return $this->renderForm(
            'micro_post/add.html.twig',
            [
                'form' => $form
            ]
        );
    }

    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    #[IsGranted(MicroPost::EDIT, 'post')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response
    {
        $form = $this->createForm(MicroPostType::class, $post);     // class & data

        $form->handleRequest($request);

        // $this->denyAccessUnlessGranted(MicroPost::EDIT, $post);          // ⭐⭐⭐ is it this??

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $posts->add($post, true);           // 📌 'add' works for add & edit

            $this->addFlash('success', 'Your post has been edited'); // flash message after submit

            return $this->redirectToRoute('app_micro_post'); // redirect after submit
        }

        return $this->renderForm(
            'micro_post/edit.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]
        );
    }

    #[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
    // #[IsGranted('ROLE_COMMENTER')]
    public function addComment(MicroPost $post, Request $request, CommentRepository $comments): Response
    {
        $form = $this->createForm(CommentType::class, new Comment());     // class & data

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $comments->add($comment, true);

            $this->addFlash('success', 'Your comment has been added');

            return $this->redirectToRoute(
                'app_micro_post_show',
                ['post' => $post->getId()]
            );
        }

        return $this->renderForm(
            'micro_post/comment.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]
        );
    }
}
