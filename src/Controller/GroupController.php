<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    /**
     * @Route("/group", name="group")
     */
    public function Group()
    {
        return $this->render('group/group.html.twig');
    }
}
