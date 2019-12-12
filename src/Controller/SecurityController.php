<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param EntityManagerInterface $interface
     * @return Response
     */
    public function login(Request $request, AuthenticationUtils $utils, EntityManagerInterface $interface)
    {
        $error = "";
        $username = "";
        $login = new User();
        $form = $this->createForm(LoginType::class, $login);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $repository = $interface->getRepository(User::class);
            $u = $repository->findOneBy(array('id' => $form['id']->getData()));
            if($u) {
                //$error = $utils->getLastAuthenticationError();
                $username = $utils->getLastUsername();
            }else{

            }
            $error = "El usuario no existe";
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
     * @return Response
     */
    public function register(Request $request, AuthenticationUtils $utils, EntityManagerInterface $interface)
    {
        $status = "";
        $username = "";
        $response = array(
            'status' => "error",
            'message' => ""
        );
        $register = new User();
        $form = $this->createForm(RegisterType::class, $register);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if(!is_numeric($form['id']->getData())){
                $response['message'] = "El numero de control debe de ser numerico";
                return new JsonResponse($response);
            }
            if(strlen($form['id']->getData()) != 8){
                $response['message'] = "El numero de control son 8 digitos";
                return new JsonResponse($response);
            }

            if(strlen($form['user']->getData()) < 2 || strlen($form['user']->getData()) > 20){
                $response['message'] = "El rango del nombre es de 2 a 20 caracteres";
                return new JsonResponse($response);
            }
            if(strlen($form['lastM']->getData()) < 2 || strlen($form['lastM']->getData()) > 20){
                $response['message'] = "El rango del apellido paterno es de 2 a 20 caracteres";
                return new JsonResponse($response);
            }
            if(strlen($form['lastF']->getData()) < 2 || strlen($form['lastF']->getData()) > 20){
                $response['message'] = "El rango del apellido materno es de 2 a 20 caracteres";
                return new JsonResponse($response);
            }
            if(strlen($form['password']->getData()) < 8 || strlen($form['password']->getData()) > 20){
                $response['message'] = "La contraseña es de un rango de 8 a 20 caracteres ";
                return new JsonResponse($response);
            }
            $repository = $interface->getRepository(User::class);
            $u = $repository->findOneBy(array('id' => $form['id']->getData()));
            if($u){
                $response['message'] = "Ya existe el usuario";
                return new JsonResponse($response);
            }
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
                $response['message'] = $message;
                $response['status'] = $status;
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
