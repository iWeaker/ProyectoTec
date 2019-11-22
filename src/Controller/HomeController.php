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
     */
    public function index(EntityManagerInterface $interface)
    {
        $repository = $interface->getRepository(PostEntity::class);
        $post = $repository->findAll();
        return $this->render('home/index.html.twig', [
            'post' => $post,
        ]);
    }
}
