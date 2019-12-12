<?php

namespace App\Controller;

use App\Entity\HeartEntity;
use App\Entity\PostEntity;
use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     * @param Request $request
     * @return JsonResponse
     */
    protected $repository;
    public function __construct(EntityManagerInterface $interface)
    {
        $this->repository = $interface->getRepository(PostEntity::class);
    }


    public function showAllPost(UserInterface $user){
        return $this->repository->findByExampleField($user->getUsername());
    }

    /**
     * @Route("/heart/{id}" , name="heart")
     * @param $id
     * @param EntityManagerInterface $interface
     * @param UserInterface $user
     * @return JsonResponse
     */
    public function heartPost($id, EntityManagerInterface $interface, UserInterface $user){
        $heart =  new HeartEntity();
        $repository = $interface->getRepository(HeartEntity::class);
        $response = array(
            'status' => "",
            'message' =>  $id,
            'counter' => 0,

        );
        if($repository->checkExist($user->getUsername(), $id)){


            $con = $this->getDoctrine()->getManager();
            $h = $repository->findOneBy(array('userHeartId' => $user->getUsername() , 'post_id' => $id));

            $con->remove($h);
            try{
                $con->flush();
                $response['message'] = "unlike";
                $response['counter'] = $repository->createQueryBuilder('a')
                    ->where('a.post_id = '.$id)
                    ->select('count(a.id)')
                    ->getQuery()
                    ->getSingleScalarResult();
                return $this->json($response);
            }catch (\Exception $e){

            }
        }else {
            $uRespository = $interface->getRepository(User::class);
            $u = $uRespository->findOneBy(['id' => $user->getUsername()]);
            $postRespository = $interface->getRepository(PostEntity::class);
            $postRepo = $postRespository->findOneBy([
                'id' => $id
            ]);
            $heart->setPostId($postRepo);
            $heart->setUserHeartId($u);
            $con = $this->getDoctrine()->getManager();
            $con->persist($heart);
            try{
                $con->flush();
                $response['message'] = "like";
                $response['counter'] = $repository->createQueryBuilder('a')
                    ->where('a.post_id = '.$id)
                    ->select('count(a.id)')
                    ->getQuery()
                    ->getSingleScalarResult();
                return $this->json($response);
            }catch (\Exception $e){

            }
        }
        return $this->json($response);
    }



}
