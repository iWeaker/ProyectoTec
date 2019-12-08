<?php

namespace App\Controller;

use App\Entity\PostEntity;
use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     * @param Request $request
     * @return JsonResponse
     */
    protected $repository;
    public function __construct(EntityManagerInterface $interface)
    {
        $this->repository = $interface->getRepository(PostEntity::class);
    }


    public function showAllPost(UserInterface $user){
        return $this->repository->findByExampleField($user->getUsername());
    }

}
