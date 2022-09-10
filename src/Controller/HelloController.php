<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; # this is needed to use 'render' to twig method & other 'helpers' https://symfony.com/doc/current/controller.html
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response; # Right-click on class name, Import Class

class HelloController extends AbstractController # One class per file
{
    private array $messages = [
        'abc', 'def', 'ghi'
    ];

    #[Route('/{limit<\d+>?3}', name: 'app_index')] # limit then <\d+> for int, then ? for optional, then 3 for default limit amount. http://127.0.0.1:8000/2 would return 2 values etc.
    public function index(int $limit): Response
    {
        // return new Response(
        //     implode(',', array_slice($this->messages, 0, $limit)) # array_slice = array, offset, length https://www.php.net/manual/en/function.array-slice.php
        // );
        return $this->render(
            'hello/index.html.twig',
            ['message' => implode(',', array_slice($this->messages, 0, $limit))]
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one')] # regex <\d+> to only allow integers & throws 404 for if other type
    public function showOne(int $id): Response
    {
        return $this->render(
            'hello/show_one.html.twig', # where to render
            [
                'message' => $this->messages[$id] # what to render
            ]
        );
        // return new Response($this->messages[$id]);
    }
}
