<?php

namespace App\Controller;

use App\Entity\PostEntity;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @param UserInterface $user
     * @param EntityManagerInterface $interface
     * @return Response
     */
    public function index(UserInterface $user, EntityManagerInterface $interface)

    {

        $userId = $user->getUsername();
        $repository = $interface->getRepository(PostEntity::class);
        $post = $repository->findByExampleField('16491121');
        return $this->render('profile/index.html.twig', [
            'post' => $post
        ]);

    }

    /**
     * @Route("/profile/{id}", name="userprofile")
     * @param $id
     * @return Response
     */
    public function userIndex(int $id) {
        $user = $this->getDoctrine()->getRepository(User::class)
            ->findOneBy([
                'id' => $id
            ]);

        return $this->render('profile/index.html.twig' , [
            'name' => $user->getUser()
        ]);
    }
}

