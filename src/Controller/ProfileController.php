<?php

namespace App\Controller;

use App\Entity\HeartEntity;
use App\Entity\ImagesEntity;
use App\Entity\ImgEntity;
use App\Entity\PostEntity;
use App\Entity\User;
use App\Form\PhotoType;
use App\Form\CoverType;
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
    protected $post;
    protected $img;

    public function __construct(EntityManagerInterface $interface)
    {
        $this->post = new PostController($interface);
        $this->img = new ImgEntity($interface);
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
        $newFilename= "";
        $con = $this->getDoctrine()->getManager();
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
            $imagePost = new ImgEntity();
            if($text == null && $image == null){
                self::$error = "Error de ambos";
            }else{
                if($image){
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename.'-'.uniqid().'.'.$image->guessExtension();
                    $newFilename = str_replace(' ', '', $newFilename);
                    try {
                        $image->move(
                            $this->getParameter('imagePostUploader'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        $message = $e;
                    }
                    $imagePost->setImgName($newFilename);
                    $imagePost->setUser($u);
                    $con->persist($imagePost);
                    $con->flush();
                    $postEntity->setImagePost($newFilename);
                }
                $postEntity->setContentPost($text);
                $postEntity->setDatePost();
                $postEntity->setUserPost($u);
                $con->persist($postEntity);
                try{
                    $con->flush();
                    $status = "success";
                    $response['status'] = $status;
                    $repository = $interface->getRepository(PostEntity::class);
                    $post = $repository->findByLast($user->getUsername());
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
     * @param UserInterface $user
     * @param EntityManagerInterface $interface
     * @return JsonResponse
     */
    public function photoSection(UserInterface $user, EntityManagerInterface $interface){
        $uRespository = $interface->getRepository(User::class);
        $u = $uRespository->findOneBy([
            'id' => $user->getUsername()
        ]);
        $imgRepo =$interface->getRepository(ImgEntity::class);
        $i = $imgRepo->findByExampleField($user->getUsername());
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('profile/photo.html.twig' , ['img' => $i])
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
     * @Route("photoprofile" ,name="photoprofile")
     * @param Request $request
     * @param UserInterface $user
     * @return JsonResponse
     *
     */
    public function changeProfile(Request $request, UserInterface $user){


        $form = $this->createForm(PhotoType::class, new User());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $con = $this->getDoctrine()->getManager();
            $user = $con->getRepository(User::class)->find($user->getUsername());
            $img = $form['image']->getData();
            if($img){
                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$img->guessExtension();
                $newFilename = str_replace(' ', '', $newFilename);
                try {
                    $img->move(
                        $this->getParameter('profileUserUploader'),
                        $newFilename
                    );
                    $user->setImage($newFilename);
                    $con->persist($user);
                    $con->flush();
                } catch (FileException $e) {
                    $message = $e;
                }

            }

        }
        $response = array(
            'status' => "",
            'message' => $this->renderView('profile/profilephoto.html.twig' , [
                'form' => $form->createView()
            ]),
        );

        return $this->json($response);
    }


    /**
     * @Route("coverprofile" ,name="coverprofile")
     * @param Request $request
     * @param UserInterface $user
     * @return JsonResponse
     *
     */
    public function changeCover(Request $request, UserInterface $user){


        $form = $this->createForm(CoverType::class, new User());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $con = $this->getDoctrine()->getManager();
            $user = $con->getRepository(User::class)->find($user->getUsername());
            $img = $form['cover']->getData();
            if($img){
                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$img->guessExtension();
                $newFilename = str_replace(' ', '', $newFilename);
                try {
                    $img->move(
                        $this->getParameter('coverUserUploader'),
                        $newFilename
                    );
                    $user->setCover($newFilename);
                    $con->persist($user);
                    $con->flush();
                } catch (FileException $e) {
                    $message = $e;
                }

            }

        }
        $response = array(
            'status' => "",
            'message' => $this->renderView('profile/profilecover.html.twig' , [
                'form' => $form->createView()
            ]),
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

