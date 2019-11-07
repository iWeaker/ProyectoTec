<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @param UserInterface $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(UserInterface $user)
    {
        $userId = $user->getUsername();

        return $this->render('profile/index.html.twig', [
            'controller_name' => $userId,
        ]);
    }
}
