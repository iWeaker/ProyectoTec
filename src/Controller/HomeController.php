<?php

namespace App\Controller;

use App\Entity\PostEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param EntityManagerInterface $interface
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(EntityManagerInterface $interface)
    {

        $repository = $interface->getRepository(PostEntity::class);
        $post = $repository->findBy([], ['datePost' => 'DESC']);
        return $this->render('home/index.html.twig', [
            'post' => $post,
        ]);
    }
}
