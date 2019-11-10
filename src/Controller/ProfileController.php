<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @param UserInterface $user
     * @param SecurityController $serialize
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(UserInterface $user)

    {
        $userId = $user->getUsername();

        return $this->render('profile/index.html.twig');
    }

    /**
     * @Route("/profile/{id}", name="userprofile")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
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

