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



    private static $error = "";
    private $interface;
    private $request;
    private $user;
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
    public function index( UserInterface $user,Request $request, EntityManagerInterface $interface)

    {
        $this->interface = $interface;
        $this->request = $request;
        $this->user = $user;

        $uRespository = $interface->getRepository(User::class);
        $u = $uRespository->findOneBy([
            'id' => $this->user->getUsername()
        ]);

        $postEntity = new PostEntity();
        $form = $this->createForm(PostType::class,$postEntity);
        $form->handleRequest($this->request);
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
                    $response['status'] = $status;
                    $repository = $interface->getRepository(PostEntity::class);
                    $post = $repository->findByLast($this->user->getUsername());
                    $response = array(
                        'status' => "",
                        'message' => $this->renderView('post/index.html.twig' , ['p' => $post]),
                    );
                    return $this->json($response);
                }catch(\Exception $e) {
                    $message = $e->getMessage();
                }

            }
        }
        return $this->render('profile/index.html.twig', [
            'post' => $this->post->showAllPost($this->user),
            'id' => $u->getId(),
            'name' =>$u->getUser(),
            'lastname' => $u->getLastM(),
            'lastname2' => $u->getLastF(),
            'picture' => $u->getImage(),
            'cover' => $u->getCover(),
            'form' => $form->createView(),
            'getUrl' => 0,
            'error' => self::$error,
            'pst' => ""
        ]);

    }

    /**
     * @Route("/profile/photo", name="photo")
     *
     */
    public function photoSection(){
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('profile/photo.html.twig' ),
        );
        return $this->json($response);
    }
    /**
     * @Route("/profile/config", name="config")
     *
     */
    public function configSection(){
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('profile/config.html.twig' ),
        );
        return $this->json($response);
    }
    /**
     * @Route("/profile/follow", name="follow")
     *
     */
    public function followSection(){
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('profile/follow.html.twig' ),
        );
        return $this->json($response);
    }

    /**
     * @Route("/profile/{id}", name="userprofile" , methods={"GET", "POST"})
     * @param String $id
     * @param UserInterface $u
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

