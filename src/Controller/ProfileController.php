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
    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @param UserInterface $user
     * @param EntityManagerInterface $interface
     * @return Response
     */
    public function index(UserInterface $user, EntityManagerInterface $interface)

    {

        $userId = $user->getUsername();
        $uRespository = $interface->getRepository(User::class);
        $u = $uRespository->findOneBy([
            'id' => $user->getUsername()
        ]);

        $form = self::postForm(new Request());

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
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/profile/{id}", name="userprofile" , methods={"GET", "POST"})
     * @param String $id
     * @param EntityManagerInterface $interface
     * @return Response
     */
    public function userIndex(String $id, EntityManagerInterface $interface) {
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
            'cover' => $user->getCover()
        ]);
    }


    public function postForm(Request $request){
        $post = new PostEntity();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        return $form;
    }
}

