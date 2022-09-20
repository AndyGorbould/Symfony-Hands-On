<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
        
        dd($posts->findAll());               // dd = 'dump & die' - like 'var_dump($var); die();' or 'print_r()'
        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
        ]);
    }
    
    
    #[Route('/micro-post/{id}', name: 'app_micro_post_show')]
    public function showOne($id, MicroPostRepository $posts): Response
    {
        dd($posts->find($id))
    }
}
