<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response // more 'dependency injection' in the index()
    {
        // An example
        // $microPost = new MicroPost();
        // $microPost->setTitle('This is from the MP Controller');
        // $microPost->setText('yes it is');
        // $microPost->setCreated(new DateTime());
        //
        // $posts->add($microPost, true);          // 'true' for flush in the repository class

        // $microPost = $posts->find(4);           // find by index & modify
        // $microPost->setTitle('Weclome?');
        // $posts->add($microPost, true);

        // $microPost = $posts->find(5);
        // $posts->remove($microPost, true);

        // endpoint is '/micro-post', as defined in the Route (above)
        // dd($posts->findOneBy(['title' => 'Symfony is ace!']));               // dd = 'dump & die' - like 'var_dump()' or 'print_r()'

        // dd($posts->findAll());               // dd = 'dump & die' - like 'var_dump($var); die();' or 'print_r()'
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }


    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response          // MicroPost called because sensio uses that in param converter for single cases. Use the MicroPostRepository injection for multiple cases (above) // https://symfony.com/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html
    {
        // dd($post);
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(Request $request, MicroPostRepository $posts): Response
    {
        $microPost = new MicroPost();
        /** @var $form Symfony\Component\Form\ClickableInterface */
        $form = $this->createFormBuilder($microPost)
            ->add('title')
            ->add('text')
            ->add('submit', SubmitType::class, ['label' => 'Save'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            // dd($post);
            $post->setCreated(new DateTime());
            $posts->add($post, true);           // 📌 remember 'true' for flush on entity manager (repository)
        }

        return $this->renderForm(
            'micro_post/add.html.twig',
            [
                'form' => $form
            ]
        );
    }
}
