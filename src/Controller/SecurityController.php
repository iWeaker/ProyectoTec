<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $error = "";
        $username = "";

        $login = new User();
        $form = $this->createForm(LoginType::class, $login);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $error = $utils->getLastAuthenticationError();
            $username = $utils->getLastUsername();
        }

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $username,
            'form' => $form->createView()
        ]);

    }
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, AuthenticationUtils $utils)
    {
        $error = "";
        $username = "";

        $login = new User();
        $form = $this->createForm(RegisterType::class, $login);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $error = $utils->getLastAuthenticationError();
            $username = $utils->getLastUsername();
        }

        return $this->render('security/register.html.twig', [
            'error' => $error,
            'last_username' => $username,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/logout" , name="logout")
     *
     */

    public function logout(){

    }
}
