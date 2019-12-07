<?php

namespace App\Controller;

use App\Entity\PostEntity;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    private static $error = "";
    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @param UserInterface $user
     * @param EntityManagerInterface $interface
     * @return Response
     */
    public function index(Request $request , UserInterface $user, EntityManagerInterface $interface)

    {

        $userId = $user->getUsername();
        $uRespository = $interface->getRepository(User::class);
        $u = $uRespository->findOneBy([
            'id' => $user->getUsername()
        ]);

        $post = new PostEntity();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $text = $form['contentPost']->getData();
            $image = $form['imagePost']->getData();
            if($text == null && $image == null){
                self::$error = "Error de ambos";
            }else{
                $post->setContentPost($text);
                $post->setImagePost($image);
                $post->setDatePost();
                $post->setUserPost($user);
                $con = $this->getDoctrine()->getManager();
                $con->persist($post);
                $con->flush();
            }
        }

        $repository = $interface->getRepository(PostEntity::class);
        $post = $repository->findByExampleField($user->getUsername());
        return $this->render('profile/index.html.twig', [
            'post' => $post,
            'id' => $u->getId(),
            'name' =>$u->getUser(),
            'lastname' => $u->getLastM(),
            'lastname2' => $u->getLastF(),
            'picture' => $user->getImage(),
            'cover' => $user->getCover(),
            'form' => $form->createView(),
            'getUrl' => 0,
            'error' => self::$error
        ]);

    }

    /**
     * @Route("/profile/{id}", name="userprofile" , methods={"GET", "POST"})
     * @param String $id
     * @param EntityManagerInterface $interface
     * @return Response
     */
    public function userIndex(String $id,UserInterface $u, EntityManagerInterface $interface) {
        if($id == $u->getUsername()){
            return $this->redirectToRoute('profile');
        }
        $user = $this->getDoctrine()->getRepository(User::class)
            ->findOneBy([
                'id' => $id
            ]);
        $repository = $interface->getRepository(PostEntity::class);
        $post = $repository->findByExampleField($id);
        return $this->render('profile/index.html.twig' , [
            'post' => $post,
            'id' => $user->getId(),
            'name' =>$user->getUser(),
            'lastname' => $user->getLastM(),
            'lastname2' => $user->getLastF(),
            'picture' => $user->getImage(),
            'cover' => $user->getCover(),
            'getUrl' => 1
        ]);
    }

}

