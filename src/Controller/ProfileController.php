<?php

namespace App\Controller;

use App\Entity\PostEntity;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{



    private static string $error = "";
    protected  $post;
    public function __construct(EntityManagerInterface $interface)
    {
        $this->post = new PostController($interface);
    }

    /**
     * @Route("/profile", name="profile")
     * @param UserInterface $user
     * @param Request $request
     * @param EntityManagerInterface $interface
     * @return Response
     */
    public function index(UserInterface $user,Request $request, EntityManagerInterface $interface)

    {
        $userId = $user->getUsername();
        $uRespository = $interface->getRepository(User::class);
        $u = $uRespository->findOneBy([
            'id' => $user->getUsername()
        ]);

        $postEntity = new PostEntity();
        $form = $this->createForm(PostType::class,$postEntity);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $text = $form['contentPost']->getData();
            $image = $form['imagePost']->getData();
            if($text == null && $image == null){
                self::$error = "Error de ambos";
            }else{
                if($image){
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename.'-'.uniqid().'.'.$image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('imagePostUploader'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        $message = $e;
                    }
                    $postEntity->setImagePost($newFilename);
                }
                $postEntity->setContentPost($text);

                $postEntity->setDatePost();
                $postEntity->setUserPost($u);
                $con = $this->getDoctrine()->getManager();
                $con->persist($postEntity);
                try{
                    $con->flush();
                    $status = "success";
                    //$message = "Se guardo";
                    $lastPost = $this->repository->findByLast($user->getUsername());
                    $response = array(
                        'status' => $status,
                        'message' => $this->post->showLastPost($user->getUsername()),

                    );
                    return new JsonResponse($response);

                }catch(\Exception $e) {
                    $message = $e->getMessage();

                }
            }
        }
        return $this->render('profile/index.html.twig', [
            'post' => $this->post->showAllPost($user),
            'id' => $u->getId(),
            'name' =>$u->getUser(),
            'lastname' => $u->getLastM(),
            'lastname2' => $u->getLastF(),
            'picture' => $user->getImage(),
            'cover' => $user->getCover(),
            'form' => $form->createView(),
            'getUrl' => 0,
            'error' => self::$error,
            'pst' => ""
        ]);

    }

    /**
     * @Route(name="photo")
     *
     */
    public function showPhotos(){
        return "";
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

