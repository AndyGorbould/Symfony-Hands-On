<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\UserProfileRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response; # Right-click on class name, Import Class
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; # this is needed to use 'render' to twig method & other 'helpers' https://symfony.com/doc/current/controller.html

class HelloController extends AbstractController # One class per file
{
    private array $messages = [
        ['message' => 'abc', 'created' => '2022/09/10'],
        ['message' => 'def', 'created' => '2022/09/09'],
        ['message' => 'ghi', 'created' => '2019/08/08']
    ];

    #[Route('/', name: 'app_index')] # limit then <\d+> for int, then ? for optional, then 3 for default limit amount. http://127.0.0.1:8000/2 would return 2 values etc.
    public function index(UserProfileRepository $profiles): Response
    {
        // $user = new User();
        // $user->setEmail('root@root.com');
        // $user->setPassword('root');

        // $profile = new UserProfile();
        // $profile->setUser($user);
        // $profiles->add($profile, true);


        // $profile = $profiles->find(1);
        // $profiles->remove($profile, true);

        // return new Response(
        //     implode(',', array_slice($this->messages, 0, $limit)) # array_slice = array, offset, length https://www.php.net/manual/en/function.array-slice.php
        // );
        return $this->render(
            'hello/index.html.twig',
            [
                // 'messages' => array_slice($this->messages, 0, $limit) # renamed to 'messages' (plural) & removed implode, so this fits better to the MVC pattern
                'messages' => $this->messages,
                'limit' => 3
            ]
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
