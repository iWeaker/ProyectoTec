<?php

namespace App\Controller;

use App\Entity\GroupEntity;
use App\Entity\SolicitudesEntity;
use App\Entity\User;
use App\Form\GroupType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class GroupController extends AbstractController
{
    /**
     * @Route("/group", name="group")
     * @param EntityManagerInterface $interface
     * @param UserInterface $user
     * @return Response
     */
    public function Group(EntityManagerInterface $interface , UserInterface $user)
    {

        $uRespository = $interface->getRepository(User::class);
        $u = $uRespository->findOneBy([
            'id' => $user->getUsername()
        ]);
        $group = $interface->getRepository(GroupEntity::class);
        $otherGroups = $group->otherGroups($user->getUsername());
        $myGroups = $group->findBy(['creator' => $u] );
        return $this->render('group/group.html.twig', [
            'mygroups' => $myGroups,
            'othergroups' => $otherGroups,
        ]);
    }

    /**
     * @Route("/view/{id}" , name="viewgroup")
     * @param $id
     * @param EntityManagerInterface $interface
     * @return Response
     */
    public function viewGroup($id, EntityManagerInterface $interface){
        $group = $interface->getRepository(GroupEntity::class)->find($id);


        return $this->render('group/viewgroup.html.twig', [
            'title' => $group->getTitleGroup(),
            'creator' => $group->getCreator(),
            'tematica' => $group->getTematica(),
            'image' => $group->getGroupImage(),
            'solicitudes' => $group->getSolicitudesEntities()
        ]);
    }
    /**
     * @Route("/newgroup" , name="newgroup" )
     * @param Request $request
     * @param UserInterface $user
     * @return JsonResponse
     *
     */
    public function addGroup(Request $request, UserInterface $user){
        $form = $this->createForm(GroupType::class, new GroupEntity());
        $form->handleRequest($request);
        $newFilename = "default.jpg";

        if($form->isSubmitted() && $form->isValid()){
            $con = $this->getDoctrine()->getManager();

            $group = new GroupEntity();
            $user = $con->getRepository(User::class)->find($user->getUsername());
            $title = $form['titleGroup']->getData();
            $tematica = $form['tematica']->getData();
            $groupImage = $form['groupImage']->getData();

            if($groupImage){
                $originalFilename = pathinfo($groupImage->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$groupImage->guessExtension();
                $newFilename = str_replace(' ', '', $newFilename);
            }
            try {
                $groupImage->move(
                    $this->getParameter('groupImageUploader'),
                    $newFilename
                );
                $group->setGroupImage($newFilename);
                $group->setTematica($tematica);
                $group->setTitleGroup($title);
                $group->setCreator($user);
                $group->setGroupImage($newFilename);

                $con->persist($group);
                $con->flush();
            } catch (FileException $e) {
                $message = $e;
            }

        }
        $response = array(
            'status' => "",
            'message' => $this->renderView('group/groupcreator.html.twig' , [
                'form' => $form->createView()
            ]),
        );

        return $this->json($response);
    }

    /**
     * @Route("/solicitud/{id}" , name="solicitud")
     * @param $id
     * @param EntityManagerInterface $interface
     * @param UserInterface $user
     * @return null
     */
    public function addSolicitud($id, EntityManagerInterface $interface, UserInterface $user){
        $arreglo = Array('success' => false, 'msg' => 'error');
        $solicitud = new SolicitudesEntity();
        $con = $this->getDoctrine()->getManager();
        $group = $con->getRepository(GroupEntity::class)->find($id);
        $user = $con->getRepository(User::class)->find($user->getUsername());
        try{
            $solicitud->setGroupid($group);
            $solicitud->setUserid($user);
            $con->persist($solicitud);
            $con->flush();
            $arreglo['success'] = true;
            $arreglo['msg'] = "Se ha mandado la solicitud correctamente";
            return $this->json($arreglo);
        }catch (\Exception $e){

        }
    }
    /**
     * @Route("/solicitudremove/{id}" , name="solicitudremove")
     * @param $id
     * @param EntityManagerInterface $interface
     * @param UserInterface $user
     * @return null
     */
    public function removeSolicitud($id, EntityManagerInterface $interface, UserInterface $user){
        $arreglo = Array('success' => false, 'msg' => 'error');

        $con = $this->getDoctrine()->getManager();
        $repository = $interface->getRepository(SolicitudesEntity::class);
        $h = $repository->findOneBy(array('groupid' => $id , 'userid' => $user->getUsername()));
        try{

            $con->remove($h);
            $con->flush();
            $arreglo['success'] = true;
            $arreglo['msg'] = "Se ha cancelado la solicitud correctamente";
            return $this->json($arreglo);
        }catch (\Exception $e){

        }


    }
}
