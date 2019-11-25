<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityController extends AbstractController
{
    private $crypt;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->crypt = $encoder;
    }
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
     * @param UserPasswordEncoder $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, AuthenticationUtils $utils)
    {
        $status = "";
        $message = "";

        $username = "";

        $register = new User();
        $form = $this->createForm(RegisterType::class, $register);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $register->setPassword($this->crypt->encodePassword($register,$form->get('password')->getData()));
            $register->setImage('default.jpg');
            $register->setCover('default.jpg');
            $register->setDateRegister();

            $con = $this->getDoctrine()->getManager();
            $con->persist($register);
            try{
                $con->flush();
                $status = "success";
                $message = "Se guardo";
                $response = array(
                    'status' => $status,
                    'message' => $message
                );
                return new JsonResponse($response);

            }catch(\Exception $e) {
                $message = $e->getMessage();

            }
        }

        return $this->render('security/register.html.twig', [
            'error' => $status,
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
