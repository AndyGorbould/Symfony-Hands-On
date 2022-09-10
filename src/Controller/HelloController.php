<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response; # Right-click on class name, Import Class

class HelloController # One class per file
{
    private array $messages = [
        'abc', 'def', 'ghi'
    ];

    #[Route('/{limit<\d+>?3}', name: 'app_index')] # limit then <\d+> for int, then ? for optional, then 3 for default limit amount. http://127.0.0.1:8000/2 would return 2 values etc.
    public function index(int $limit): Response
    {
        return new Response(
            implode(',', array_slice($this->messages, 0, $limit)) # array_slice = array, offset, length https://www.php.net/manual/en/function.array-slice.php
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one')] # regex <\d+> to only allow integers & throws 404 for if other type
    public function showOne(int $id): Response
    {
        return new Response($this->messages[$id]);
    }
}
